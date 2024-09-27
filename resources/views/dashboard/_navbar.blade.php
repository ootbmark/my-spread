<ul class="nav mb-3 profile-nav-tab">
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/users*')) active @endif"
           href="{{route('dashboard.users.index')}}">Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/organisations*')) active @endif"
           href="{{route('dashboard.organisations.index')}}">Organisations</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/threads*')) active @endif"
           href="{{route('dashboard.threads.index')}}">Discussions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/replies*')) active @endif"
           href="{{route('dashboard.replies.index')}}">Replies</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/universities*')) active @endif"
           href="{{route('dashboard.universities.index')}}">Universities</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/groups*')  && Request::segment(2) != "groups-for-quiz") active @endif"
           href="{{route('dashboard.groups.index')}}">Groups</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/alerts*')) active @endif"
           href="{{route('dashboard.alerts')}}">Alerts</a>
    </li>
</ul>
