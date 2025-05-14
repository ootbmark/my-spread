@extends('layouts.app')

@section('content')
    <div class="home-head">
        <a href="http://rp-squared.com" target="_blank" rel="noopener" aria-label="rp2">
            <img src="/img/logo_header.png" alt="my-spread" class="home-head-logo">
        </a>
        <picture class="h-100 w-100">
            <source srcset="/img/home-head.webp" type="image/webp">
            <source srcset="/img/home-head.jpg" type="image/jpg">
            <img src="/img/home-head.jpg" alt="my-spread" class="w-100 h-100">
        </picture>
        <div class="home-head-block">
            <h1 class="font-medium">Welcome to Spread, the Worlds Premier Drilling Forum</h1>
            @guest
                <a href="{{ route('login') }}" class="btn home-head-btn">LOGIN / REGISTER</a>
            @else
                {{-- Mark Samson Added this if else statement to block unverified account from Posting Discussion --}}
                @if (Auth::user()->verified())
                    <a href="{{ route('discussions.check') }}" class="btn home-head-btn">START A NEW DISCUSSION</a>
                @else
                    {{--      <p>Please wait for administrative verification before
                        participating in
                        discussions on our forum.</p> --}}
                @endif

            @endguest

            <a href="#second-section" class="scroll-link btn" data-id="second-section">
                <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
                <lord-icon src="https://cdn.lordicon.com/wtfdpwey.json" trigger="loop"
                    colors="primary:#ffffff,secondary:#c71f16" stroke="90" scale="13"
                    style="width:250px;height:250px">
                </lord-icon>
                <div class="scrollertext">Scroll down</div>
            </a>
        </div>


    </div>

    <section class="my-container mb-5 pt-5" id="second-section">

        <p class="mb-5">Over the past decade, My-Spread has grown to become the leading oil and gas drilling forum for
            technical
            Q&A engineering discussions. The site started with a core team of contributors covering all main specialist
            areas involved in drilling, exploration, subsea, completion and abandonment of wells. Over time, this team
            has grown and now includes technical specialists from all over the world, who are working with all major
            oil companies, as well as E&P and service companies.

            <br><br>With thousands of discussion threads now indexed in the search engines, newcomers are
            discovering content every day. Many of these new visitors decide to sign up, which is completely
            free of charge. Now, the number of active members, and daily page views mean that any technical
            question that you might have will be answered to a high level, in a reasonable time. The forum is
            moderated for quality and accuracy, and old information is updated as it is discovered.

            <br><br>If you haven’t signed up already please do so, and you can ask or answer your first question right now.
            Welcome to our drilling community!
        </p>

        <div class="main-section d-flex flex-wrap pb-4">
            <div class="main-section-head d-flex flex-wrap align-items-center w-100">
                <h2 class="mr-auto mb-0 title-h2">FORUM</h2>

                <div class="d-flex flex-wrap justify-content-center">
                    <div class="d-flex flex-column align-items-center number-block">
                        <span class="number">{{ $users_count }}</span>
                        <span>Members</span>
                    </div>
                    <div class="d-flex flex-column align-items-center number-block">
                        <span class="number">{{ $threads_count }}</span>
                        <span>Discussions</span>
                    </div>
                    <div class="d-flex flex-column align-items-center number-block">
                        <span class="number">{{ $replies_count }}</span>
                        <span>Responses</span>
                    </div>
                    <div class="d-flex flex-column align-items-center number-block">
                        <span class="number">{{ number_format($settings['activity_yearly'], 0, '.', ',') }}</span>
                        <span>Total hits</span>
                    </div>
                    <div class="d-flex flex-column align-items-center number-block">
                        <span class="number">{{ number_format($settings['activity_monthly'], 0, '.', ',') }}</span>
                        <span>Hits in past 30 days</span>
                    </div>
                </div>

                <div class="w-100 button-group d-flex justify-content-between mt-4">
                    <a href="{{ route('discussions.check') }}" class="btn my-btn text-uppercase">Start a new discussion</a>
                    <a href="{{ route('discussions.index') }}" class="btn my-btn text-uppercase">All Discussions</a>
                    <a href="{{ route('discussions.index') }}?unanswered=1" class="btn my-btn text-uppercase">Waiting for
                        responses</a>
                </div>
            </div>

            <div class="section-left">
                <h3 class="title-h3">RECENT DISCUSSIONS</h3>
                @foreach ($recent_threads as $thread)
                    <a href="{{ route('discussions.show', $thread->id) }}" class="link-1 d-flex justify-content-between">
                        {{ $thread->subject }}
                        <span>{{ $thread->active_replies_count }}</span>
                    </a>
                @endforeach
                <h3 class="title-h3 font-medium pb-0">
                    <a href="{{ route('discussions.index') }}?unanswered=1"
                        class="link-1 d-flex justify-content-between border-0">
                        NOVICE QUESTIONS
                    </a>
                </h3>

                @foreach ($novice_threads as $thread)
                    <a href="{{ route('discussions.show', $thread->id) }}" class="link-1 d-flex justify-content-between">
                        {{ $thread->subject }}
                        <span>{{ $thread->active_replies_count }}</span>
                    </a>
                @endforeach

                <a href="https://rp-squared.com/workshops/beyond-video-conferencing-and-technical-facilitation-service"
                    rel="noopener" target="_blank" class="mt-5 d-block">
                    <picture>
                        <source srcset="/img/Banner-resized-shrunk.webp" type="image/webp">
                        <source srcset="/img/Banner-resized-shrunk.jpg" type="image/jpg">
                        <img src="/img/Banner-resized-shrunk.jpg" alt="shrunk" class="w-100" loading="lazy">
                    </picture>
                </a>
                <a href="https://senergyconsultants.com/" rel="noopener" target="_blank" class="mt-4 d-block">
                    <picture>
                        <source srcset="/img/SEnergy.webp" type="image/webp">
                        <source srcset="/img/SEnergy.png" type="image/png">
                        <img src="/img/SEnergy.png" alt="SEnergy" class="w-100" loading="lazy">
                    </picture>
                </a>
                <a href="https://rigintegrity.com/" rel="noopener" target="_blank" class="mt-4 d-block">
                    <picture>
                        <source srcset="/img/Rig.webp" type="image/webp">
                        <source srcset="/img/Rig.png" type="image/png">
                        <img src="/img/Rig.png" alt="Rig" class="w-100" loading="lazy">
                    </picture>
                </a>
            </div>

            <div class="section-right">
                <h3 class="title-h3">LATEST MEMBERS</h3>
                @foreach ($latest_members as $member)
                    <div class="d-flex justify-content-between align-items-center links-group">
                        <a href="{{ route('users.show', $member->id) }}" class="link-2">{{ $member->name }}</a>
                        <a href="{{ route('organisations.show', $member->organisation_id) }}"
                            class="link-2 font-12">({{ $member->organisation->name ?? '' }})</a>
                    </div>
                @endforeach
                <a href="{{ route('profile.invite') }}" class="btn my-btn w-100 mt-3 font-18">Invite your friends</a>

                @include('layouts.parts._adds_right')

                <a href="{{ route('contact') }}" rel="noopener" target="_blank" class="mt-3 d-block">
                    <picture>
                        <source srcset="/img/advert.webp" type="image/webp">
                        <source srcset="/img/advert.png" type="image/png">
                        <img src="/img/advert.png" alt="pay-advert" class="w-100" loading="lazy">
                    </picture>
                </a>
            </div>
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
                        <h5 class="title-h5">Drilling & Completion Performance Consultants</h5>
                        <a href="http://rp-squared.com/" rel="noopener" class="link-black">
                            www.rp-squared.com
                        </a>
                        <br>
                        <a href="mailto:dave@rp-squared.com" class="link-black d-inline-block mb-3">
                            dave@rp-squared.com
                        </a>

                        <h5 class="title-h5">Bringing you:</h5>
                        <ol>
                            <li>
                                <a href="http://rp-squared.com/rp%C2%B2-approach/living-the-limit/" target="_blank"
                                    rel="noopener" class="text-blue">
                                    Living the Limit™ model
                                </a>
                            </li>
                            <li>DWOPs / Risk Assessments</li>
                            <li>Wellsite &amp; office coaches</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="section-right d-flex align-items-center">
                @include('layouts.parts._donation')
            </div>

            <p class="pr-3 pl-3 font-16 mb-2">Technical limit specialists with clients in:</p>

            <picture class="pr-3 pl-3">
                <img src="/img/map5.jpg" alt="my-spread-map" class="w-100 h-auto" loading="lazy" width="1068"
                    height="575">
            </picture>
        </div>
    </section>
@endsection
