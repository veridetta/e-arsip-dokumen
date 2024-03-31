<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <?php
            use App\Models\Notification;
            $notifications = Notification::where('to', auth()->user()->id)->where('is_read', 0)->get();
            $notif_all = Notification::where('to', auth()->user()->id)->get();

            ?>
            <li class="nav-item dropdown position-relative me-2">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="bell"></i>
                    <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifications->count() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="min-height: 200px !important">
                    @foreach ( $notif_all as $notification )
                        <li>
                            <?php
                            $role = auth()->user()->role;
                            $url = route('read-notif',['id'=>$notification->id,'to'=>$notification->to,'role'=>$role]);
                            $cla = 'icon text-danger';

                            ?>
                            <a href="{{ $url }}" class="btn-notif dropdown-item d-flex">
                                <div class="me-3">
                                    <div class="{{$cla}}">
                                        <i class="align-middle" data-feather="alert-circle"></i>
                                    </div>
                                </div>
                                <div>
                                    <strong>{{ $notification->title }}</strong>
                                    <div class="small text"> {{ $notification->content }}</div>
                                    <div class="small text"> {{ $notification->created_at }}</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    {{-- <div class="loader-topbar"></div> --}}
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="text-dark fw-bold text-capitalize">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="align-middle me-1"
                            data-feather="user"></i> Profile</a> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Log out</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
