<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ mix('css/home.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    @yield('add-css')

    @include('layouts._head_scripts')
    @yield('head')
    <script>
        window.trans = <?php
        // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            if (pathinfo($f)['filename'] == 'lesson' || pathinfo($f)['filename'] == 'course' || pathinfo($f)['filename'] == 'quiz') {
                $trans[$filename] = trans($filename);
            }
        }
        echo json_encode($trans);

        ?>;
    </script>
</head>
<body>


<nav class="header navbar-expand-lg" id="header-1">
    <div class="header-container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{asset('/img/home/logo.png')}}" alt="my spread">
        </a>

        <div class="navbar-header">
            <button type="button" id="nav-toggle" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="justify-content-end collapse in navbar-collapse position-relative header-nav" id="main-nav" style="background: white;">
            <ul class="list-unstyled d-flex w-100 justify-content-end header-nav mb-0" id="subMenu">
                <li class="menu-list-item">
                    <a href="#" role="button" data-toggle="dropdown">About</a>
                    <ul class="user-list-sub list-unstyled sub-menu dropdown-menu">
                        <li><a href="{{route('about')}}">About Spread</a></li>
                        <li><a href="{{route('organisations.index')}}">Member organisations</a></li>
                        <li><a href="{{route('guide')}}">User guide</a></li>
                        <li><a href="{{route('useful')}}">Useful links</a></li>
                    </ul>
                </li>
                <li class="menu-list-item">
                    <a href="#" role="button" data-toggle="dropdown">Discussions</a>
                    <ul class="user-list-sub  list-unstyled sub-menu dropdown-menu">
                        <li><a href="{{route('groups.index')}}">View all groups</a></li>
                        <li><a href="{{route('discussions.index')}}">View all discussions</a></li>
                    </ul>
                </li>
                <li class="menu-list-item"><a href="{{route('forms.index.main')}}">Workshop Outputs</a></li>
                <li class="menu-list-item"><a href="#" data-toggle="modal" data-target="#privateForumModal">Private Forums</a></li>
                <li class="menu-list-item"><a href="{{route('contact')}}">Contact</a></li>
                <li class="menu-list-item"><a href="{{route('help')}}">Help</a></li>
                @guest
                    <li class="menu-list-item"><a href="{{ route('login') }}">Login / Register</a></li>
                @else
                    <li class="menu-list-item dropdown">
                        <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{asset('/img/home/user.png')}}" class="" alt="user" width="30">
                        </a>
                        <div class="user-list list-unstyled sub-menu dropdown-menu dropdown-menu-right text-right sub-menu-profile" aria-labelledby="navbarDropdown">

                            <a class="d-flex align-items-center" href="{{route('profile.index')}}"><img src="{{asset('/img/user-b.svg')}}" alt="user">{{ __('Profile') }}</a>
                            @if(auth()->user()->role == 'admin')
                                <a class="d-flex align-items-center" href="{{route('dashboard.users.index')}}"><img src="{{asset('/img/id-card-b.svg')}}" alt="card">{{ __('Dashboard') }}</a>
                            @endif
                            <a class="d-flex align-items-center" href="{{route('profile.invite')}}"><img src="{{asset('/img/invite-b.svg')}}" alt="invite">{{ __('Invite friends') }}</a>
                            <a class="d-flex align-items-center" href="{{route('profile.find')}}"><img src="{{asset('/img/search-b.png')}}" alt="find">{{ __('Find friends') }}</a>
                            <a class="d-flex align-items-center" href="{{route('profile.notifications')}}"><img src="{{asset('/img/share-post-b.svg')}}" alt="share">{{ __('Notification') }}</a>
                            <a class="d-flex align-items-center" href="{{route('profile.password')}}"><img src="{{asset('/img/password-b.svg')}}" alt="password">{{ __('Password') }}</a>

                            <a class="d-flex align-items-center" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{asset('/img/logout-b.svg')}}" alt="logout">{{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@yield('content')



<div class="modal" tabindex="-1" id="privateForumModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <p>Private Forums are corporate spaces that allow groups to use the functionality of
                    MySpread for confidential projects. If you feel your company could benefit from a
                    private forum, please contact <a href="mailto:admin@my-spread.com">admin@my-spread.com</a></p>
                <button type="button" class="btn my-btn mt-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>

    $(".toggle-password").click(function () {

        $(this).toggleClass("eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).ready(function(){
        $(".open_close-menu").click(function(){
            $('.my-profile-menu').toggleClass('profile-menu-opened');
        });
    });
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $('.j-back').click(function (){
        window.location.href = "{{ url()->previous() }}";
    });


    $(document).ready(function () {
        var current_url = window.location.href.split('?')[0];
        $.ajax({
            url: "{{route('activity')}}",
            method: "POST",
            data: {"url": current_url},
            success: function (data) {}
        });
    });

    $('form').submit(function (){
        $(this).find('.disabled-after-submit').attr('disabled', true);
    })

</script>

@include('layouts._foot_scripts')
@yield('scripts')
@include('flash::message')

</body>
</html>

