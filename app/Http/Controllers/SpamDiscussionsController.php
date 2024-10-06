<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadSpam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SpamDiscussionsController extends Controller
{
    function index(Request $request)
    {
        $threads = ThreadSpam::where('status', 'new')->with('group')->orderBy('created_at', 'desc')->paginate(20);
        return view('spam-discussion.view', compact('threads'));
    }
    function view(Request $request, $id)
    {
        $thread = ThreadSpam::find($id);
        return view('spam-discussion.spam_view', compact('thread'));
    }
    function store_thread(Request $request)
    {
        $spamThread = ThreadSpam::find($request->id);
        // /return $spamThread;
        $invalid = array(
            'user_id' => $spamThread->user_id,
            'group_id' => $spamThread->group_id,
            'subject' => $spamThread->subject,
            'body' => $spamThread->body,
            'location' => $spamThread->location,
            'status' => 'new',
            'activity_date' => now()
        );
        $spamThread->status = 'inactive';
        $spamThread->save();
        $thread = Thread::create($invalid);
        /*  $share_service = new ShareService();
        $share_service->linkedin($thread); */

        $subject = 'A new discussion has been posted on My-Spread';
        Mail::send('emails.new_thread', ['thread' => $thread], function ($mail) use ($subject) {
            $mail->to('mark@ootbinnovations.com')->subject($subject);
            /*  $m->to(config('mail.notifications'))->subject($subject); */
        });
        flash()->success('The discussion has been removed from spam.');
        return redirect(route('discussion-spam.view'));
    }
}
