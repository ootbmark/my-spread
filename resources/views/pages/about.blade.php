@extends('layouts.app')
@section('content')
    <div class="my-container pt-5 mb-5">
        <h1 class="title-h2 mb-4 text-center">WHAT SPREAD IS ABOUT?</h1>

        <div class="my-container bg-white p-4">
            <p>Welcome to SPREAD, the FREE global community of drilling, completion & subsea professionals. SPREAD gives you access to a wealth of knowledge that you may not otherwise have had.</p>

            <b>With SPREAD you can:</b>
            <ul>
                <li>1. Start new discussions</li>
                <li>2. Contribute your knowledge and ideas to existing discussions.</li>
                <li>3. Forward discussions to your friends who are likely to be interested.</li>
                <li>4. <a href="{{route('profile.invite')}}">Invite your friends</a> to join SPREAD</li>
            </ul>

        </div>
        <div class="main-section d-flex flex-wrap pb-4 mt-4 pt-2">
            <div class="section-left">
                <h4 class="title-h4"><i>My-Spread is powered by:</i></h4>
                <div class="d-flex align-items-start pt-2 flex-wrap my-powered">
                    <picture class="mr-4">
                        <source srcset="/img/rp2_logo.webp" type="image/webp">
                        <source srcset="/img/rp2_logo.png" type="image/png">
                        <img src="/img/rp2_logo.png" alt="rp2" class="" loading="lazy" width="150">
                    </picture>
                    <div class="mt-4 my-powered-right">
                        <h5 class="title-h5">Drilling &amp; Completion Performance Consultants</h5>
                        <a href="http://rp-squared.com/" class="link-black">
                            www.rp-squared.com
                        </a>
                        <br>
                        <a href="mailto:dave@rp-squared.com" class="link-black d-inline-block mb-3">
                            dave@rp-squared.com
                        </a>

                        <h5 class="title-h5">Bringing you:</h5>
                        <ol>
                            <li>
                                <a href="http://rp-squared.com/rp%C2%B2-approach/living-the-limit/" target="_blank" rel="noopener" class="text-blue">
                                    Living the Limit™  model
                                </a>
                            </li>
                            <li>DWOPs / Risk Assessments</li>
                            <li>Wellsite &amp; office coaches</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="section-right d-flex align-items-center">
                <div class="support-spread text-center">
                    <h6>Support Spread</h6>
                    <p><i>We need the support of our members to keep our forum online. If you find the
                            information on spread useful please consider a donation</i>
                    </p>
                    <picture>
                        <source srcset="/img/donate.webp" type="image/webp">
                        <source srcset="/img/donate.jpg" type="image/jpg">
                        <img src="/img/donate.jpg" alt="donate" class="w-100" loading="lazy">
                    </picture>
                    <button type="button" class="btn my-btn w-100 mt-2">Donate</button>
                </div>
            </div>

            <p class="pr-3 pl-3 font-16 mb-2">Technical limit specialists with clients in:</p>
            <picture class="pr-3 pl-3">
                <img src="/img/map5.jpg" alt="my-spread-map" class="w-100 h-auto" loading="lazy" width="1068" height="575">
            </picture>
        </div>
    </div>
@endsection

