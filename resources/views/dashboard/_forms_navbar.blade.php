<ul class="nav mb-3 profile-nav-tab">
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/forms*') && !Request::is('dashboard/*/archive*')) active @endif" href="{{route('forms.index')}}">Forms</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/groups-for-quiz*') && Request::segment(2) == "groups-for-quiz") active @endif"
           href="{{route('groups-for-quiz.index')}}">Form Groups</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/scribes')) active @endif"
           href="{{route('scribes.index')}}">Scribes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/companies')) active @endif"
           href="{{route('companies.index')}}">Companies</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::is('dashboard/*/archive*')) active @endif"
           href="{{route('archive.index')}}">Archive</a>
    </li>
</ul>
