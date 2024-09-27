<ul class="nav mb-3 profile-nav-tab">
    <li class="nav-item">
        <a class="nav-link @if(Request::is('profile')) active @endif" href="{{route('profile.index')}}">My Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('profile/info')) active @endif" href="{{route('profile.info')}}">Personal Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('profile/discussions')) active @endif" href="{{route('profile.discussions')}}">My Discussions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('profile/replies')) active @endif" href="{{route('profile.replies')}}">My Replies</a>
    </li>
</ul>
