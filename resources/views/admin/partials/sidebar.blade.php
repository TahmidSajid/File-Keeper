        <div class="app-sidebar">
            <div class="logo">
                <a href="index.html" class="logo-icon"><span class="logo-text">File Keeper</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="{{ route('user.profile.index') }}">
                        @if (auth()->user()->image)
                            <img src="{{ asset('assets/frontend/user/' . auth()->user()->image) }}" alt="...">
                        @else
                            <img src="{{ asset('assets/frontend/default/user-default.jpg') }}" alt="...">
                        @endif
                        <span class="activity-indicator"></span>
                        <span class="user-info-text">{{ auth()->user()->fullname }}</span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Side Manue
                    </li>
                    <li class="page">
                        <a href="{{ route('home') }}" class="active"><i
                                class="material-icons-two-tone">dashboard</i>Dashboard</a>
                    </li>
                    <li class="page">
                        <a href="{{ route('user.profile.index') }}" class="active"><i
                                class="material-icons-two-tone">account_box</i>Profile</a>
                    </li>
                    <li class="page">
                        <a href="{{ route('user.drive.index') }}" class="active"><i
                                class="material-icons-two-tone">settings_applications</i>Drive</a>
                    </li>
                    <li class="page">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="material-icons-two-tone">power_settings_new</i>
                            {{ __('Logout') }}
                        </a>
                    </li>
                </ul>
                {{-- Form for logout --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
