 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg">
     <div class="sidebar-content js-simplebar my-bg">
         <a class="sidebar-brand" href="#">
            <span class="align-middle text-capitalize">Panel {{ Auth::user()->role }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('user.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>
             <li class="sidebar-item @if (request()->routeIs('user.private-documents.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.private-documents.index') }}">
                    <i class="align-middle fa fa-key"></i>
                    <span class="align-middle">Kelola Dokumen Khusus</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('user.get-requests.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.get-requests.index') }}">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Minta Izin Akses Dokumen Khusus</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('user.requests.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('user.requests.index') }}">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Kelola Permintaan Dokumen</span>
                </a>
            </li>
         </ul>
     </div>
 </nav>
