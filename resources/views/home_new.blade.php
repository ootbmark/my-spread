@extends('layouts.app_new')
@section('add-css')
    <style>
        .banner-ads {
            color: white;
            margin-top: 30px;
        }

        </div>.p {
            font-family: 'Arial Black', 'Helvetica Neue', sans-serif;
            /* Solid, bold font */
            font-weight: bold;
            /* Makes text bold */
            text-transform: none;
            /* Ensures text is not all caps */
            font-size: 1.2em;
            /* Slightly larger text to "pop" */
            letter-spacing: 0.5px;
            /* Slight spacing for emphasis */
            color: #000000;
            /* Solid black text */
        }

        .banner-logo {
            display: inline-block;
            font-size: 20px;
            font-weight: 900;
        }

        .sub-title-ads {
            color: #eee;
            font-size: 16px;
            margin-top: 10%;
        }
    </style>
@endsection
@section('content')
    <section id="fullpage">
        <div class="bg__first section active position-relative" id="section0">
            <div class="container">
                <div class="flexbox">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="image-left animated fadeInLeft">
                                <img src="{{ asset('/img/home/logo.png') }}" alt="logo" class="image-responsive">
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="right-captions animated fadeInRight">
                                <h4>Welcome to</h4>
                                <h2><span class="green">MY-</span>SPREAD</h2>
                                <p>Sharing Knowledge amongst Energy Professionals</p>

                                <a href="https://rp-squared.com/"  style="margin-top:10%;" target="_blank">
                                    <label class="sub-title-ads">Brought to you free by:</label> <br>
                                    <div class="banner-logo" style="margin-bottom:5%">
                                        <img src="{{ asset('images/rp2-highres.png') }}" style="width: 80px" alt="ads-logo">

                                        <label style="color: #eee; font-size:24px">
                                            Relentless Pursuit of
                                            Perfection Ltd.
                                        </label>
                                    </div>
                                </a>
                                <div class="stroked-button">
                                    @guest
                                        <a href="{{ route('login') }}" class="link" data-id="second-section">LOGIN /
                                            REGISTER</a>
                                    @else
                                        {{-- Mark Samson Added this if else statement to block unverified account from Posting Discussion --}}

                                        @if (Auth::user()->verified())
                                            <a href="{{ route('discussions.check') }}" class="btn home-head-btn">START A NEW
                                                DISCUSSION</a>
                                            {{--     @else
                                            <p>Please wait for administrative verification before
                                                participating in
                                                discussions on our forum.</p> --}}
                                        @endif

                                    @endguest
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="arrow">
                    <a href="#welcome" class="scroll-link" data-id="second-section">
                        <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
                        <lord-icon src="https://cdn.lordicon.com/wtfdpwey.json" trigger="loop"
                            colors="primary:#ffffff,secondary:#c71f16" stroke="90" scale="13"
                            style="width:250px;height:250px">
                        </lord-icon>
                        <div class="scrollertext">Scroll down</div>
                    </a>
                </div>
            </div>
        </div>
        </div>
        <section class="section" id="section1" style="background-color: #eee!important;">
            <div class="container parallax">
                <div class="row">
                    <div class="col-md-12 fadeInUp sevice-items">
                        <div class="col-lg-3 col-md-6 col-sm-6 bounceInUp animated"
                            style="visibility: visible; animation-name: bounceInUp;">
                            <div class="single-item">
                                <div class="counter" id="counter_1">{{ $users_count }}</div>
                                <p>MEMBERS</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bounceInUp animated"
                            style="visibility: visible; animation-name: bounceInUp;">
                            <div class="single-item">
                                <div class="counter" id="counter_2">{{ $threads_count }}</div>
                                <p>DISCUSSIONS</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bounceInUp animated"
                            style="visibility: visible; animation-name: bounceInUp;">
                            <div class="single-item">
                                <div class="counter" id="counter_3">{{ $replies_count }}</div>
                                <p>RESPONSES</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 bounceInUp animated"
                            style="visibility: visible; animation-name: bounceInUp;">
                            <div class="single-item">
                                <div class="counter" id="counter_4">{{ $settings['activity_yearly'] }}</div>
                                <p>TOTAL HITS</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="bg__third">
                <div id="slide">
                    <div class="container">
                        <div class="row ">
                            <div style="width: 100%;">
                                <h2 style="text-align: center !important;font-weight: 600;color:white;margin-bottom: 40px;margin-top:40px;"
                                    id="welcome_to_spread_title">Welcome to SPREAD</h2>
                            </div>
                            <div class="line"></div>
                            <div style="background-color: rgba(255, 255, 255, 0.9);padding:50px;border-radius:20px;">
                                <p>Over the past decade, Spread has grown to become the leading oil and gas drilling forum
                                    for technical Q&amp;A engineering discussions. The site started with a core team of
                                    contributors covering all main specialist areas involved in drilling, exploration,
                                    subsea, completion and abandonment of wells. Over time, our team has grown and now
                                    includes technical specialists from all over the world who are working with all major
                                    oil companies, as well as E&amp;P and service companies.</p>
                                <p>With thousands of discussion threads now indexed in the search engines, newcomers are
                                    discovering fresh content every day.</p>
                                <p>With our current number of active members and daily page views, it means that any
                                    technical question you might have will be answered quickly and to a high standard. This
                                    forum is moderated for quality and accuracy, and old information is updated regularly.
                                </p>
                                <p>Once you have signed up, you can ask your first question right away – or answer somebody
                                    else’s question!</p>
                                <p><strong>Welcome to Spread.</strong></p>
                                <div class="button">
                                    <h3><a href="{{ route('login') }}" style="color:white;">SIGN UP FOR FREE</a></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="service-arrow">
                                    <a href="#discuss" class="scroll-link" data-id="third-section">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="section2" style="background-color: #eee!important;">
            <div class="bg__fourty fourth-container">
                <div class="main-section d-flex flex-wrap pb-4">
                    <div class="main-section-head d-flex flex-wrap align-items-center w-100">
                        <div class="w-100 button-group d-flex justify-content-between mt-4">
                            <a href="{{ route('discussions.check') }}" class="btn my-btn text-uppercase">Start a new
                                discussion</a>
                            <a href="{{ route('discussions.index') }}" class="btn my-btn text-uppercase">All
                                Discussions</a>
                            <a href="{{ route('discussions.index') }}?unanswered=1"
                                class="btn my-btn text-uppercase">Waiting for responses</a>
                        </div>
                    </div>

                    <div class="section-left">
                        <div class="d-flex justify-content-between align-items-center links-group">
                            <h3 class="title-h3">RECENT DISCUSSIONS</h3>
                        </div>
                        @foreach ($recent_threads as $thread)
                            <a href="{{ route('discussions.show', $thread->id) }}"
                                class="link-1 d-flex justify-content-between">
                                {{ $thread->subject }}
                                <span>{{ $thread->active_replies_count }}</span>
                            </a>
                        @endforeach


                        @foreach ($novice_threads as $thread)
                            <a href="{{ route('discussions.show', $thread->id) }}"
                                class="link-1 d-flex justify-content-between">
                                {{ $thread->subject }}
                                <span>{{ $thread->active_replies_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="section-right">
                        <div class="d-flex justify-content-between align-items-center links-group">
                            <h3 class="title-h3">LATEST MEMBERS</h3>
                        </div>
                        @foreach ($latest_members as $member)
                            <div class="d-flex justify-content-between align-items-center links-group">
                                <a href="{{ route('users.show', $member->id) }}" class="link-2">{{ $member->name }}</a>
                                <a href="{{ route('organisations.show', $member->organisation_id) }}"
                                    class="link-2 font-12">({{ $member->organisation->name ?? '' }})</a>
                            </div>
                        @endforeach
                        <a href="{{ route('profile.invite') }}" class="btn my-btn btn-invite w-100  font-18">Invite your
                            friends</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="service-arrow">
                            <a href="#spread-out" class="scroll-link" data-id="four-section">
                                <i class="fa fa-angle-down" style="color: red; border: 1px solid red;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="section3">
            <div class="fifty-container">
                <div class="main-section-spread d-flex flex-wrap">
                    <div class="section-left-spread">
                        <div>
                            <a href="https://rp-squared.com/workshops/beyond-video-conferencing-and-technical-facilitation-service"
                                rel="noopener" target="_blank" class="mt-1 d-block">
                                <picture>
                                    <source srcset="/img/Banner-resized-shrunk.webp" type="image/webp">
                                    <source srcset="/img/Banner-resized-shrunk.jpg" type="image/jpg">
                                    <img src="/img/Banner-resized-shrunk.jpg" alt="shrunk" class="w-100"
                                        loading="lazy">
                                </picture>
                            </a>
                        </div>
                    </div>
                    <div class="section-right-spread">
                        @include('layouts.parts._adds_right')
                    </div>
                </div>
            </div>
            <div class="second-section">
                <div class="bg__secondpara"></div>
            </div>
        </section>

        <section class="section" id="section4">
            <div class="second-section" style="background-color: white">
                <div class="sixty-container">
                    <div class="main-section-spread d-flex flex-wrap mt-5">
                        <div class="section-left">
                            <h4 class="title-h4"><i>My-Spread is powered by:</i></h4>
                            <div class="d-flex align-items-start pt-2 flex-wrap my-powered">
                                <picture class="mr-4">
                                    <source srcset="/img/rp2_logo.webp" type="image/webp">
                                    <source srcset="/img/rp2_logo.png" type="image/png">
                                    <img src="/img/rp2_logo.png" alt="rp2" class="" loading="lazy"
                                        width="150">
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
                                            <a href="http://rp-squared.com/rp%C2%B2-approach/living-the-limit/"
                                                target="_blank" rel="noopener" class="text-blue">
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
                        <img src="{{ asset('/img/map5.jpg') }}" alt="my-spread-map" class="w-100 h-auto"
                            loading="lazy">
                    </div>
                </div>
            </div>

        </section>

        <footer class="mt-auto section" id="section5">
            <div class="second-section">
                <div class="bg__second"></div>
            </div>
            <div style="background-color: #110b42;">
                <div class="footer-container text-center">
                    <a href="/" class="mr-auto" aria-label="logo">
                        <img src="{{ asset('/img/home/logo.png') }}" alt="myspread" width="100" loading="lazy"
                            style="margin-left: -25px;">
                    </a>
                    <div class="footer-links">
                        <a href="{{ route('privacy') }}">Privacy</a>
                        <a href="{{ route('faq') }}">FAQs</a>
                        <a href="{{ route('contact') }}">Feedback</a>
                    </div>
                    <div class="footer-socials d-flex align-items-center justify-content-center">

                        <a href="https://www.facebook.com/Myspread-1655862491362528/" rel="noreferrer" target="_blank"
                            title="facebook" aria-label="facebook">
                            <i class="fa fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/myspread/" rel="noreferrer" target="_blank" title="twitter"
                            aria-label="twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/my-spread" rel="noreferrer" target="_blank"
                            title="linkedin" aria-label="linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center copyright-text">
                        <p class="mb-0">Powered by</p>
                        <strong><a href="https://www.rp-squared.com">rp-squared.com</a></strong>
                    </div>
                </div>
                <div class="copyright">
                    <div class="copyright-container text-center">
                        <p class="mb-1 mr-3">{{ date('Y') }} &copy; SPREAD. All Rights Reserved. Designated trademarks
                            and brands are the property of their respective owners.</p>
                        <a href="https://ootbinnovations.com/" target="_blank" rel="noopener">
                            <p>DEVELOPED BY OUT OF THE BOX INNOVATION</p>
                        </a>
                    </div>
                </div>

                <div class="third-arrow text-center">
                    <a href="#home" class="scroll-top btn" data-id="top"><i class="fa fa-angle-up"></i></a>
                </div>
            </div>
        </footer>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#fullpage').fullpage({
                autoScrolling: true,
                scrollHorizontally: true,
                parallax: false,
                // navigationPosition: 'right',


                anchors: ['home', 'welcome', 'discuss', 'spread-out', 'global-spread', 'footer'],
                navigation: true,
                navigationTooltips: ['Home', 'Welcome', 'Discuss', 'Spread out', 'Global Spread', 'Footer'],

            });

            //methods
            $.fn.fullpage.setAllowScrolling(true);
        });

        // var isCounter = true;
        {{-- document.getElementById("fullpage").addEventListener("wheel", function () { --}}
        {{-- if (isCounter){ --}}
        {{--        isCounter = false; --}}
        {{--        counter("counter_1", 0, parseInt('{{$users_count}}'), 5); --}}
        {{--        counter("counter_2", 0, parseInt('{{$threads_count}}'), 3); --}}
        {{--        counter("counter_3", 0, parseInt('{{$replies_count}}'), 10); --}}
        {{--        counter("counter_4", 0, parseInt('{{$settings['activity_yearly']}}'), 10000); --}}
        {{--    } --}}
        {{-- }); --}}

        {{-- $(document).ready(function() { --}}
        {{--    // navigation click actions --}}
        {{--    $('.scroll-link').on('click', function(event){ --}}
        {{--        if (isCounter){ --}}
        {{--            isCounter = false; --}}
        {{--            counter("counter_1", 0, parseInt('{{$users_count}}'), 5); --}}
        {{--            counter("counter_2", 0, parseInt('{{$threads_count}}'), 3); --}}
        {{--            counter("counter_3", 0, parseInt('{{$replies_count}}'), 10); --}}
        {{--            counter("counter_4", 0, parseInt('{{$settings['activity_yearly']}}'), 10000); --}}
        {{--        } --}}
        {{--    }); --}}
        {{-- }); --}}

        function counter(id, start, end, increment) {
            let obj = document.getElementById(id),
                current = start,
                timer = setInterval(() => {
                    current += increment;
                    obj.textContent = current;
                    if (current > end) {
                        obj.textContent = end;
                        clearInterval(timer);
                    }
                }, 0);
        }
    </script>
@endsection
