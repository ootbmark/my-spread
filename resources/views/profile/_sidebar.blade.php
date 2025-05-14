<div class="my-profile-menu">
    <a href="/" class="brend-left-menu">
        <img src="{{ asset('/img/logo.png') }}" class="img-responsive" alt="logo" width="99">
    </a>
    <nav class="profile-nav">
        <span class="open_close-menu"><i class="my-arrow" aria-hidden="true"></i></span>
        <div class="user-info">
            <div class="user-info-img position-relative">

                <div class="account-img-view" id="user-img">
                    <img src="{{ auth()->user()->image }}" class="user_photos" alt="">
                </div>

                <div class="avatar-buttons">
                    <button type="button" class="btn edit-img" data-toggle="modal" data-target="#myModal"
                        title="Edit avatar">
                        <img src="{{ asset('/img/edit.svg') }}" alt="" width="25">
                    </button>

                    @if (auth()->user()->getRawOriginal('image'))
                        <a href="#" class="delete-avatar" id="delete-avatar" onclick="$(this).next().submit()"
                            title="Delete avatar">
                            <img src="{{ asset('/img/rubbish-bin.svg') }}" alt="" width="17">
                        </a>
                        <form action="{{ route('profile.image.delete') }}" method="POST">
                            @csrf
                        </form>
                    @endif
                </div>

            </div>

            <div class="flex-grow-1">
                <h5>{{ auth()->user()->name }}</h5>
                <p>{{ auth()->user()->job_title }}</p>
                <p>{{ auth()->user()->location }}</p>
                <h6>{{ auth()->user()->organisation->name ?? '' }}</h6>
            </div>

        </div>

        <ul class="profile-nav-ul">
            <li @if (Request::is('profile') ||
                    Request::is('profile/info') ||
                    Request::is('profile/discussions') ||
                    Request::is('profile/replies')) class="active" @endif>
                <a class="left-content" href="{{ route('profile.index') }}">
                    <span><img src="{{ asset('/img/user-p.svg') }}" alt="" width="18"></span>
                    Profile
                </a>
            </li>
            @if (auth()->user()->role == 'admin')
                <li @if (Request::is('dashboard*') &&
                        !Request::is('dashboard/forms*') &&
                        !Request::is('dashboard/scribes*') &&
                        !Request::is('dashboard/groups-for-quiz*')) class="active" @endif>
                    <a class="left-content" href="{{ route('dashboard.users.index') }}">
                        <span><img src="{{ asset('/img/id-card.svg') }}" alt="" width="18"></span>
                        Dashboard
                    </a>
                </li>
            @endif
            <li @if (Request::is('profile/invite')) class="active" @endif>
                <a class="left-content" href="{{ route('profile.invite') }}">
                    <span><img src="{{ asset('/img/invite.svg') }}" alt="" width="18"></span>
                    Invite friends
                </a>
            </li>
            <li @if (Request::is('profile/find')) class="active" @endif>
                <a class="left-content" href="{{ route('profile.find') }}">
                    <span><img src="{{ asset('/img/search.png') }}" alt="" width="18"></span>
                    {{ __('Find friends') }}
                </a>
            </li>
            <li @if (Request::is('profile/notifications')) class="active" @endif>
                <a class="left-content" href="{{ route('profile.notifications') }}">
                    <span><img src="{{ asset('/img/share-post.svg') }}" alt="" width="18"></span>
                    Notification
                </a>
            </li>
            <li @if (Request::is('profile/password')) class="active" @endif>
                <a class="left-content" href="{{ route('profile.password') }}">
                    <span><img src="{{ asset('/img/password-p.svg') }}" alt="" width="18"></span>
                    Password
                </a>
            </li>
            @if (auth()->user()->id == 11646 || auth()->user()->id == 3414)
                <li @if (Request::is('discussion-spam.view')) class="active" @endif>
                    <a class="left-content" href="{{ route('discussion-spam.view') }}">
                        <span><img src="{{ asset('/img/password-p.svg') }}" alt="" width="18"></span>
                        Spam Discussion
                    </a>
                </li>
            @endif
            <li class="">
                <a class="left-content" href="#" onclick="$('#profile-logout-form').submit()">
                    <span><img src="{{ asset('/img/logout.svg') }}" alt="" width="18"></span>
                    Logout
                </a>
                <form action="{{ route('logout') }}" method="post" id="profile-logout-form">
                    @csrf
                </form>
            </li>
        </ul>

        <div class="total-block">
            <div class="total-item mr-4">
                Discussions:<span class="ml-2">{{ auth()->user()->threads()->active()->count() }}
            </div>
            <div class="total-item mr-4">
                Replies:<span class="ml-2">{{ auth()->user()->replies()->active()->count() }}
            </div>
            <div class="total-item mr-4">
                Member since:<span class="ml-2">{{ auth()->user()->created_at->format('d F Y') }}</span>
            </div>
            <div class="total-item mr-4">
                Last Activity:<span class="ml-2">{{ auth()->user()->updated_at->format('d F Y') }}</span>
            </div>
        </div>
        @if (auth()->user()->role == 'admin')
            <div class="pl-0 total-block">
                <ul class="profile-nav-ul">
                    <li @if (Request::is('dashboard/forms*') && !Request::is('dashboard/*/archive*')) class="active" @endif>
                        <a class="left-content" href="{{ route('forms.index') }}">
                            <span><img src="{{ asset('/img/form=2.svg') }}" alt="" width="18"></span>
                            Forms
                        </a>
                    </li>
                    <li @if (Request::is('dashboard/groups-for-quiz*')) class="active" @endif>
                        <a class="left-content" href="{{ route('groups-for-quiz.index') }}">
                            <span><img src="{{ asset('/img/form=2.svg') }}" alt="" width="18"></span>
                            Form Groups
                        </a>
                    </li>
                    <li @if (Request::is('dashboard/scribes*')) class="active" @endif>
                        <a class="left-content" href="{{ route('scribes.index') }}">
                            <span><img src="{{ asset('/img/form=2.svg') }}" alt="" width="18"></span>
                            Scribes
                        </a>
                    </li>
                    <li @if (Request::is('dashboard/companies*')) class="active" @endif>
                        <a class="left-content" href="{{ route('companies.index') }}">
                            <span><img src="{{ asset('/img/form=2.svg') }}" alt="" width="18"></span>
                            Companies
                        </a>
                    </li>
                    <li @if (Request::is('dashboard/*/archive*')) class="active" @endif>
                        <a class="left-content" href="{{ route('archive.index') }}">
                            <span><img src="{{ asset('/img/form=2.svg') }}" alt="" width="18"></span>
                            History
                        </a>
                    </li>
                </ul>
            </div>
        @endif

    </nav>
</div>

<div id="myModal" class="modal fade modal-add-img" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h4 class="modal-title">Edit Photo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-center flex-column align-items-center">
                    <div class="fileform">
                        <div id="fileformlabel"></div>
                        <div class="selectbutton">select picture</div>
                        <input type="file" name="upload" id="upload" onchange="getName(this.value);" />
                    </div>
                    <br />
                    <div>
                        <div id="upload-img"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn my-btn upload-result text-uppercase" disabled data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-white text-uppercase" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>
