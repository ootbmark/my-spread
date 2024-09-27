<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Email;
use App\Models\Favorite;
use App\Models\File;
use App\Models\Group;
use App\Models\Invitation;
use App\Models\Organisation;
use App\Models\ParkMessage;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\ThreadView;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Support\Facades\DB;

class FixDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix and sync databases';

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
        $threads = Thread::all();
        $replies = Reply::all();


        foreach ($threads as $thread)
        {
            $thread->body = m_nofollow($thread->body);
            $thread->save();
        }

        foreach ($replies as $reply)
        {
            $reply->body = m_nofollow($reply->body);
            $reply->save();
        }

        User::where('status', 'active')->update(['email_verified_at' => now()]);

        dd('success');
//        $this->categories();
//        $this->emails();
//        $this->favorites();
//        $this->groups();
//        $this->invitations();
//        $this->organisations();
//        $this->park_messages();
//        $this->threads();
//        $this->replies();
//        $this->thread_views();
//        $this->user_groups();
//        $this->users();
//        $this->files();
//        $this->syncOrganisationsFiles();
//        $this->syncUsersFiles();
//        $this->syncFiles();
    }

    public function categories()
    {
        $old = DB::connection('mysql_second')->table('category')->get()->each(function ($el){
            $el->name = $el->category_name;
            unset($el->category_name);
        })->toArray();
        $old = json_decode(json_encode($old), true);
        Category::insert($old);
    }

    public function emails()
    {
        $old = DB::connection('mysql_second')->table('emails')->get()->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            Email::insert($t);
        }
    }

    public function favorites()
    {
        $old = DB::connection('mysql_second')->table('favorite')->get()->each(function ($el){
            $el->thread_id = $el->forum_id;
            unset($el->forum_id);
        })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            Favorite::insert($t);
        }
    }

    public function groups()
    {
        $old = DB::connection('mysql_second')->table('groups')->get()->each(function ($el){
            $el->name = $el->group_name;
            $el->type = $el->group_type;
            $el->description = $el->objective;
            unset($el->group_name);
            unset($el->group_type);
            unset($el->objective);
            unset($el->msgid);
            unset($el->remarks);
            unset($el->pinned);
            unset($el->response_count);
            unset($el->thread_count);
            unset($el->created_by);
            unset($el->created_date);
            unset($el->last_modified_date);
            unset($el->last_modified_by);
            if($el->parent_id == 0)
            {
                $el->parent_id = null;
            }
            $el->status = 'active';
        })->toArray();
        $old = json_decode(json_encode($old), true);
        Group::insert($old);
    }

    public function invitations()
    {
        $old = DB::connection('mysql_second')->table('invitations')->get()->each(function ($el){
            unset($el->forum);
            if($el->user_id == 0)
            {
                $el->user_id = null;
            }
        })->toArray();
        $old = json_decode(json_encode($old), true);
        Invitation::insert($old);
    }


    public function organisations()
    {
        $old = DB::connection('mysql_second')->table('organisation')->get()->each(function ($el){
            $el->name = $el->org_name;
            $el->logo = $el->logo_path;
            unset($el->org_name);
            unset($el->pinned);
            unset($el->old_usrid);
            unset($el->mobile);
            unset($el->max_intake);
            unset($el->user_count);
            unset($el->reg_date);
            unset($el->logo_path);
            switch ($el->org_status)
            {
                case 'D':
                    $el->status = 'deleted';
                    break;
                case 'Y':
                    $el->status = 'active';
                    break;
                default:
                    $el->status = 'active';
            }
            unset($el->org_status);
            unset($el->status_changed_date);
            unset($el->status_changed_by);
            unset($el->remarks);
        })->toArray();

        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            Organisation::insert($t);
        }
    }

    public function park_messages()
    {
        $old = DB::connection('mysql_second')->table('park_discussion_chat')->get()->each(function ($el){
            $el->user_id = $el->admin_id;
            $el->thread_id = $el->forum_id;
            unset($el->admin_id);
            unset($el->forum_id);
        })->toArray();
        $old = json_decode(json_encode($old), true);
        ParkMessage::insert($old);
    }

    public function threads()
    {
        $old = DB::connection('mysql_second')->table('forums')->where('parent_id', 0)
            ->get()->each(function ($el){
            unset($el->mid);
            unset($el->subforum_id);
            unset($el->parent_id);
            unset($el->category_id);
            $el->location = $el->current_location;
            unset($el->current_location);
            unset($el->last_modified_date);
            unset($el->last_modified_by);
            unset($el->response_count);
            unset($el->view_count);
            if($el->is_closed == 'Y'){
                $el->is_closed = 1;
            }else{
                $el->is_closed = 0;
            }
            if($el->is_moved_daily == 'Y'){
                $el->is_daily_sent = 1;
            }else{
                $el->is_daily_sent = 0;
            }
            if($el->is_moved_weekly == 'Y'){
                $el->is_weekly_sent = 1;
            }else{
                $el->is_weekly_sent = 0;
            }
            unset($el->view_count);
            unset($el->why_updated);
            unset($el->is_sticky);
            unset($el->is_moved);
            unset($el->prev_group_id);
            unset($el->is_sent_daily);
            unset($el->is_sent_weekly);
            unset($el->is_private);
            unset($el->private);
            unset($el->sub_question);
            unset($el->sup_id);
            unset($el->is_moved_daily);
            unset($el->is_moved_weekly);
            unset($el->anonymous);
                switch ($el->status)
                {
                    case 'D':
                        $el->status = 'deleted';
                        break;
                    case 'A':
                        $el->status = 'active';
                        break;
                    default:
                        $el->status = 'active';
                }
        })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            Thread::insert($t);
        }
    }

    public function replies()
    {
        $old = DB::connection('mysql_second')->table('forums')->where('parent_id', '!=', 0)
            ->get()->each(function ($el){
                unset($el->mid);
                unset($el->subforum_id);
                $el->location = $el->current_location;
                unset($el->current_location);
                unset($el->subject);
                unset($el->last_modified_date);
                unset($el->last_modified_by);
                unset($el->response_count);
                unset($el->view_count);
                unset($el->is_closed);
                unset($el->view_count);
                unset($el->why_updated);
                unset($el->is_sticky);
                unset($el->is_moved);
                unset($el->prev_group_id);
                unset($el->is_sent_daily);
                unset($el->is_sent_weekly);
                unset($el->is_private);
                unset($el->private);
                unset($el->sub_question);
                unset($el->sup_id);
                unset($el->group_id);
                unset($el->is_moved_daily);
                unset($el->is_moved_weekly);
                unset($el->anonymous);
                switch ($el->status)
                {
                    case 'D':
                        $el->status = 'deleted';
                        break;
                    case 'A':
                        $el->status = 'active';
                        break;
                    default:
                        $el->status = 'active';
                }
                if(Thread::find($el->parent_id))
                {
                    $el->thread_id = $el->parent_id;
                    $el->parent_id = null;
                }else{
                    $el->thread_id = null;
                }

            })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            Reply::insert($t);
        }

        $replies = Reply::with('parent')->where('thread_id', '0')->get();

        foreach ($replies as $reply)
        {
            if($reply->parent){
                $reply->thread_id = $reply->parent->thread_id;
                $reply->save();
            }

        }
    }

    public function thread_views()
    {
        $old = DB::connection('mysql_second')->table('discussion_view')->get()->each(function ($el){
            $el->thread_id = $el->forum_id;
            unset($el->forum_id);

        })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            ThreadView::insert($t);
        }
    }

    public function user_groups()
    {
        $old = DB::connection('mysql_second')->table('user_alert_groups')->get()->each(function ($el){
            unset($el->created_at);
            unset($el->updated_at);
            unset($el->id);

        })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            DB::table('user_groups')->insert($t);
        }
    }

    public function users()
    {
        $old = DB::connection('mysql_second')->table('users')->get()->each(function ($el){
            $el->role = $el->permission;
            if($el->role == 'member'){
                $el->role = 'user';
            }
            unset($el->permission);
            unset($el->permission_OLD);
            $el->personal_email = $el->alt_email;
            unset($el->alt_email);
            $el->location = $el->current_location;
            unset($el->current_location);
            unset($el->phone);
            unset($el->mobile);
            unset($el->university);
            $el->organisation_id = $el->org_id;
            unset($el->org_id);

            $el->is_subscribed = 0;
            if($el->subscription == 'Y'){
                $el->is_subscribed = 1;
            }
            unset($el->subscription);

            $el->alert = 0;
            if($el->rec_alert_email == 'Y'){
                $el->alert = 1;
            }
            unset($el->rec_alert_email);
            unset($el->reg_ip);
            $el->image = $el->image_path;
            unset($el->image_path);
            if(!$el->image){
                $el->image = null;
            }
            switch ($el->user_status)
            {
                case 'D':
                    $el->status = 'deleted';
                    break;
                case 'Q':
                    $el->status = 'new';
                    break;
                case 'N':
                    $el->status = 'inactive';
                    break;
                case 'Y':
                    $el->status = 'active';
                    break;
                default:
                    $el->status = 'active';
            }
            unset($el->user_status);
            unset($el->remarks);
            unset($el->disc_count);
            unset($el->last_visit_date);
            unset($el->traffic_source);
            unset($el->status_changed_date);
            unset($el->status_changed_by);
            unset($el->update_password);
            unset($el->code);
            unset($el->active);
            unset($el->is_private);
            $el->reg_source = $el->source_details;
            unset($el->source_details);
            unset($el->timer);
            unset($el->enable_modal);
            unset($el->private_login);

            if($el->students_alert == 'Y'){
                $el->students_alert = 1;
            }else{
                $el->students_alert = 0;
            }

            $el->alert_to_personal = 0;
            if($el->alert_email == 1){
                $el->alert_to_personal = 1;
            }
            unset($el->alert_email);

            $el->contact_to_personal = 0;
            if($el->contact_email == 1){
                $el->contact_to_personal = 1;
            }
            unset($el->contact_email);

        })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            User::insert($t);
        }
    }

    public function files()
    {
        $old = DB::connection('mysql_second')->table('message_files')->get()->each(function ($el){
            $el->path = $el->document_track;
            $el->name = $el->name_document;
            $el->resource_id = $el->forum_id;
            if(Thread::find($el->forum_id)){
                $el->resource_type = 'App\Thread';
            }else{
                $el->resource_type = 'App\Reply';
            }
            unset($el->document_track);
            unset($el->name_document);
            unset($el->check);
            unset($el->forum_id);

        })->toArray();
        $old = json_decode(json_encode($old), true);
        foreach (array_chunk($old,1000) as $t) {
            File::insert($t);
        }
    }

    public function syncOrganisationsFiles()
    {
        $service = new FileService();
        $organisations = Organisation::whereNotNull('logo')->get();

        foreach ($organisations as $organisation)
        {
            if($this->get_http_response_code('https://my-spread.com/logos/' . $organisation->getRawOriginal('logo'))  != "200"){
                $organisation->logo = null;
                $organisation->save();
            }else{
                $content = file_get_contents('https://my-spread.com/logos/' . $organisation->getRawOriginal('logo'));
                $service->saveFileFromContent($content, $organisation->getRawOriginal('logo'), 'organisations', $organisation, 'logo');
            }

        }
    }

    public function syncUsersFiles()
    {
        $service = new FileService();
        $users = User::whereNotNull('image')->get();

        foreach ($users as $user)
        {

            if($this->get_http_response_code('https://my-spread.com/avatar/' . $user->getRawOriginal('image'))  != "200"){
                $user->image = null;
                $user->save();
            }else{
                $content = file_get_contents('https://my-spread.com/avatar/' . $user->getRawOriginal('image'));
                $service->saveFileFromContent($content, $user->getRawOriginal('image'), 'users', $user, 'image');
            }

        }
    }

    public function syncFiles()
    {
        $service = new FileService();
        $files = File::all();

        foreach ($files as $file)
        {
            if($this->get_http_response_code('https://my-spread.com/files/' . $file->getRawOriginal('path'))  != "200"){
                File::destroy($file->id);
            }else{

                $content = file_get_contents('https://my-spread.com/files/' . $file->getRawOriginal('path'));
                $service->saveFileFromContent($content, $file->getRawOriginal('path'), 'files', $file, 'path');
            }

        }
    }


    public function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
}
