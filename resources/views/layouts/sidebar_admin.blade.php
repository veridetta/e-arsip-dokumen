 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg">
     <div class="sidebar-content js-simplebar my-bg">
         <a class="sidebar-brand bg-white" href="#">
            <img src="{{ asset(get_my_app_config('logo')) }}" class="align-middle" alt="logo" width="30">
            <span class="align-middle text-dark">{{ get_my_app_config('nama_web') }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('admin.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>

             <li class="sidebar-item @if (request()->routeIs('admin.users.*')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.users.index') }}">
                     <i class="align-middle fa fa-users"></i> <span class="align-middle">Kelola User</span>
                 </a>
             </li>


             <li class="sidebar-item @if (request()->routeIs('admin.general-categories.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.general-categories.index') }}">
                    <i class="align-middle fa fa-tag"></i>
                    <span class="align-middle">Kelola Jenis Dokumen</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('admin.general-documents.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.general-documents.index') }}">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Kelola Dokumen Umum</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('admin.private-documents.*') || request()->routeIs('admin.get-requests.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#kelola-dokumen" aria-expanded="true">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Kelola Dokumen Khusus</span>
                    <i class="fas fa-chevron-down" style="float: right; margin-right: 10px;"></i>
                </a>
                <div id="kelola-dokumen" class="collapse show">
                    <ul class="sidebar-dropdown list-unstyled" style="padding-left: 10px;">
                        <li class="sidebar-item @if (request()->routeIs('admin.private-documents.*')) active @endif">
                            <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.private-documents.index') }}">
                                <i class="align-middle fa fa-key"></i>
                                <span class="align-middle">Kelola Dokumen</span>
                            </a>
                        </li>
                        <li class="sidebar-item @if (request()->routeIs('admin.get-requests.*')) active @endif">
                            <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.get-requests.index') }}">
                                <i class="align-middle fa fa-file"></i>
                                <span class="align-middle">Request Dokumen Khusus</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="sidebar-item @if (request()->routeIs('admin.requests.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.requests.index') }}">
                    <i class="align-middle fa fa-file"></i>
                    <span class="align-middle">Kelola Request</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('admin.clients.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.clients.index') }}">
                    <i class="align-middle fa fa-users-cog"></i>
                    <span class="align-middle">Kelola Client</span>
                </a>
            </li>
             {{-- <li class="sidebar-item @if (request()->routeIs('admin.racks.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.racks.index') }}">
                    <i class="align-middle fa fa-boxes-packing"></i> <span class="align-middle">Lemari Penyimpanan</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.ingredients.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.ingredients.index') }}">
                    <i class="align-middle fa fa-layer-group"></i> <span class="align-middle">Bahan Baku</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.ingredientStocks.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.ingredientStocks.index') }}">
                    <i class="align-middle fa fa-cart-flatbed"></i> <span class="align-middle">Persediaan Bahan Baku</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.products.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.products.index') }}">
                    <i class="align-middle fa fa-bread-slice"></i> <span class="align-middle">Master Roti</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.productStocks.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.productStocks.index') }}">
                    <i class="align-middle fa fa-boxes-packing"></i> <span class="align-middle">Produksi Roti</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.orders.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.orders.index') }}">
                    <i class="align-middle fa fa-cart-shopping"></i> <span class="align-middle">Pesanan</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.persediaan.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.persediaan.index') }}">
                    <i class="align-middle fa fa-boxes-stacked"></i> <span class="align-middle">Persediaan Roti</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.mrp.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.mrp.index') }}">
                    <i class="align-middle fa fa-calculator"></i> <span class="align-middle">Perhitungan MRP</span>
                </a>
            </li> --}}
         </ul>
     </div>
 </nav>
