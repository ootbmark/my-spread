<?php

namespace App\Console\Commands;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyAlert extends Command
{
    const SUB_DAYS = 7;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily_alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily alerts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $threads = Thread::with('group', 'user.organisation')
            ->whereBetween('created_at', [now()->subDays(self::SUB_DAYS), now()])
            ->where('status', 'active')
            ->where('is_daily_sent', 0)
            ->orderBy('id', 'desc')
            ->get();

        $replies = Reply::with('thread.user', 'thread.group', 'user')
            ->whereBetween('created_at', [now()->subDays(self::SUB_DAYS), now()])
            ->where('status', 'active')
            ->where('is_daily_sent', 0)
            ->orderBy('id', 'desc')
            ->get();

        $users = User::where('status', 'active')
            ->whereIn('alert', [1, 2])
            ->where('is_subscribed', 1)
            ->get();

        $all_groups = [];
        foreach ($threads as $thread) {
            $all_groups[$thread->group_id]['group'] = $thread->group;
            $all_groups[$thread->group_id]['threads'][] = $thread;
            $thread->is_daily_sent = 1;
            $thread->save();
        }

        $all_reply_groups = [];
        foreach ($replies as $reply) {
            $all_reply_groups[$reply->thread->group_id]['group'] = $reply->thread->group;
            $all_reply_groups[$reply->thread->group_id]['threads'][$reply->thread_id]['thread'] = $reply->thread;
            $all_reply_groups[$reply->thread->group_id]['threads'][$reply->thread_id]['replies'][] = $reply;
            $reply->is_daily_sent = 1;
            $reply->save();
        }

        foreach ($users as $user) {
            $groups = $all_groups;
            $reply_groups = $all_reply_groups;

            foreach ($all_groups as $id => $group) {
                $userAlertGroup = $user->groups()->where('groups.id', $id)->first();
                if (!$userAlertGroup) {
                    unset($groups[$id]);
                    unset($reply_groups[$id]);
                }
            }

            if (count($groups)) {
                $groupTitle = '';
                foreach ($groups as $item) {
                    $groupTitle .= $item['group']->name . ': ';
                }
                $subject = count($groups) . ' Discussion' . (count($groups) > 1 ? 's' : '') . ' : ' . $groupTitle;
                try {
                    Mail::send('emails.daily_alert', ['user' => $user, 'groups' => $groups],
                        function ($m) use ($user, $subject) {
                            $m->from('alerts@my-spread.com', 'My Spread Alert <do-not-reply>');
                            $m->to($user->email)->subject($subject);
                        });
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }

            if (count($reply_groups)) {
                $subject_resp_count = 0;

                foreach ($reply_groups as $key => $value) {
                    foreach ($value['threads'] as $item) {
                        $subject_resp_count += count($item['replies']);
                    }
                }

                $subject = 'Daily Alert: ' . $subject_resp_count . ' Response' . ($subject_resp_count > 1 ? 's' : '') . ' in ' . count($reply_groups) . ' Discussion Groups';
                try {
                    Mail::send('emails.daily_alert_replies', ['user' => $user, 'reply_groups' => $reply_groups, 'subject' => $subject],
                        function ($forum) use ($user, $subject) {
                            $forum->from('alerts@my-spread.com', 'My Spread Alert <do-not-reply>')->subject($subject);

                            if ($user->alert_to_personal && $user->personal_email) {
                                if ($user->alert_to_personal == 1) {
                                    $forum->to($user->personal_email);
                                } else {
                                    $forum->to($user->email)->cc($user->personal_email);
                                }
                            } else {
                                $forum->to($user->email);
                            }

                        });
                } catch (\Exception $e) {

                }
            }
        }
    }
}
