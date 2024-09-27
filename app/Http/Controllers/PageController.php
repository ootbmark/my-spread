<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\FeedbackRequest;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact()
    {
        SeoService::setPageMeta('contact');
        return view('pages.contact');
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactSubmit(ContactRequest $request)
    {
        $data = $request->all();
        Mail::send('emails.contact', ['data' => $data], function ($m) use ($data) {
            $m->to(config('mail.notifications'))
                ->subject($data['subject']);
        });
        flash()->success('Message sent!');
        return back();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function help()
    {
        SeoService::setPageMeta('help');
        return view('pages.help');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about()
    {
        SeoService::setPageMeta('about');
        return view('pages.about');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function useful()
    {
        SeoService::setPageMeta('useful');
        return view('pages.useful');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function guide()
    {
        SeoService::setPageMeta('guide');
        return view('pages.guide');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function privacy()
    {
        SeoService::setPageMeta('privacy');
        return view('pages.privacy');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function faq()
    {
        SeoService::setPageMeta('faq');
        return view('pages.faq');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function logout()
    {
        SeoService::setPageMeta('logout');
        return view('pages.logout');
    }
}
