<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifiedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $organisation = $user->organisation;
        $university = $user->university;
        try{
            Mail::send('emails.welcome', ['user' => $user], function ($m) use ($user){
                $m->to($user->email, $user->name)->subject('Welcome to My-Spread');
            });
            Mail::send('emails.new_user', ['user' => $user], function ($m) use ($user){
                $m->to(config('mail.notifications'))->subject('New user in forum: ' . $user->username);
            });
            if(isset($organisation) && $organisation->status == 'new') {
                Mail::send('emails.new_organisation', ['organisation' => $organisation, 'user' => $user], function ($m) use ($organisation){
                    $m->to(config('mail.notifications'))->subject('New organisation in forum: ' . $organisation->name);
                });
            }
            if(isset($university) && $university->status == 'new') {
                Mail::send('emails.new_university', ['university' => $university, 'user' => $user], function ($m) use ($university){
                    $m->to(config('mail.notifications'))->subject('New university in forum: ' . $university->name);
                });
            }
        }catch (\Exception $e){}
        if (Auth::id() === $user->id) {
            flash()->success('Congratulations - You have completed the registration successfully.
            Your account will be activated very shortly. Once your account is activated you will receive a welcome email
            - this is normally very quick - but if we are out may take a day or two. Before your account is activated you
            will be able to immediately post ONE discussion - but it will not go live until your account is activated.');
        }

    }
}
