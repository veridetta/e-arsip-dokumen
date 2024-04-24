 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg">
     <div class="sidebar-content js-simplebar my-bg">
        <a class="sidebar-brand bg-white" href="#">
            <img src="{{ asset(get_my_app_config('logo')) }}" class="align-middle" alt="logo" width="30">
            <span class="align-middle text-dark">{{ get_my_app_config('nama_web') }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('user.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>
             <li class="sidebar-item @if (request()->routeIs('user.general.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.general') }}">
                    <i class="align-middle fa fa-file"></i> <span class="align-middle">Dokumen Umum</span>
                </a>
            </li>
             <li class="sidebar-item @if (request()->routeIs('user.private-documents.*') || request()->routeIs('user.get-requests.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#kelola-dokumen" aria-expanded="true">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Dokumen Khusus</span>
                    <i class="fas fa-chevron-down" style="float: right; margin-right: 10px;"></i>
                </a>
                <div id="kelola-dokumen" class="collapse show">
                    <ul class="sidebar-dropdown list-unstyled" style="padding-left: 10px;">
                        <li class="sidebar-item @if (request()->routeIs('user.private-documents.*')) active @endif">
                            <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.private-documents.index') }}">
                                <i class="align-middle fa fa-key"></i>
                                <span class="align-middle">Dokumen Khusus</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if (request()->routeIs('user.get-requests.*')) active @endif">
                            <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.get-requests.index') }}">
                                <i class="align-middle fa fa-file"></i>
                                <span class="align-middle">Request Dokumen Khusus</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-item @if (request()->routeIs('user.requests.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.requests.index') }}">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Kelola Request</span>
                </a>
            </li>
         </ul>
     </div>
 </nav>
