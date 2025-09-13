 <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
     <div class="sidebar-header d-flex align-items-center justify-content-start">
         <a href="{{ route('dashboard') }}" class="navbar-brand">
             <!--Logo start-->
             <div class="logo-main">
                 <img src="{{ URL::asset('assets/images/LimaPuluhKotaLogo.png') }}" alt="Logo Normal"
                     class="logo-normal img-fluid" style="max-height: 40px;">
                 <img src="{{ URL::asset('assets/images/LimaPuluhKotaLogo.png') }}" alt="Logo Mini"
                     class="logo-mini img-fluid d-none">
             </div>

             <!--logo End-->
             <h4 class="logo-title">SILANKA</h4>
         </a>
         <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
             <i class="icon">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                     <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round"></path>
                 </svg>
             </i>
         </div>
     </div>
     <div class="sidebar-body pt-0 data-scrollbar">
         <div class="sidebar-list">
             <!-- Sidebar Menu Start -->
             <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                 <li class="nav-item static-item">
                     <a class="nav-link static-item disabled" href="#" tabindex="-1">
                         <span class="default-icon">Main Menu</span>
                         <span class="mini-icon">
                             <svg class="icon-12" width="12" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path d="M10.33 16.5928H4.0293" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M13.1406 6.90042H19.4413" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M8.72629 6.84625C8.72629 5.5506 7.66813 4.5 6.36314 4.5C5.05816 4.5 4 5.5506 4 6.84625C4 8.14191 5.05816 9.19251 6.36314 9.19251C7.66813 9.19251 8.72629 8.14191 8.72629 6.84625Z"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M20.0002 16.5538C20.0002 15.2581 18.9429 14.2075 17.6379 14.2075C16.3321 14.2075 15.2739 15.2581 15.2739 16.5538C15.2739 17.8494 16.3321 18.9 17.6379 18.9C18.9429 18.9 20.0002 17.8494 20.0002 16.5538Z"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"></path>
                             </svg>
                         </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page"
                         href="{{ route('dashboard') }}">
                         <i class="icon">
                             <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                 class="icon-20">
                                 <path opacity="0.4"
                                     d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                     fill="currentColor"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Dashboard</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('verifikasi.pengguna') ? 'active' : '' }}"
                         href="{{ route('verifikasi.pengguna') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path opacity="0.4"
                                     d="M12.0865 22C11.9627 22 11.8388 21.9716 11.7271 21.9137L8.12599 20.0496C7.10415 19.5201 6.30481 18.9259 5.68063 18.2336C4.31449 16.7195 3.5544 14.776 3.54232 12.7599L3.50004 6.12426C3.495 5.35842 3.98931 4.67103 4.72826 4.41215L11.3405 2.10679C11.7331 1.96656 12.1711 1.9646 12.5707 2.09992L19.2081 4.32684C19.9511 4.57493 20.4535 5.25742 20.4575 6.02228L20.4998 12.6628C20.5129 14.676 19.779 16.6274 18.434 18.1581C17.8168 18.8602 17.0245 19.4632 16.0128 20.0025L12.4439 21.9088C12.3331 21.9686 12.2103 21.999 12.0865 22Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M11.3194 14.3209C11.1261 14.3219 10.9328 14.2523 10.7838 14.1091L8.86695 12.2656C8.57097 11.9793 8.56795 11.5145 8.86091 11.2262C9.15387 10.9369 9.63207 10.934 9.92906 11.2193L11.3083 12.5451L14.6758 9.22479C14.9698 8.93552 15.448 8.93258 15.744 9.21793C16.041 9.50426 16.044 9.97004 15.751 10.2574L11.8519 14.1022C11.7049 14.2474 11.5127 14.3199 11.3194 14.3209Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Verifikasi Pengguna</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('pengaduan.index') ? 'active' : '' }}"
                         href="{{ route('pengaduan.index') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                     d="M13.3571 6.45056C13.3068 5.96422 13.2543 5.45963 13.1254 4.95611C12.7741 3.75153 11.801 3.00001 10.7576 3.00001C10.1757 2.99786 9.43954 3.35644 9.0222 3.71932L5.56287 6.61697H3.75194C2.41918 6.61697 1.34751 7.6444 1.14513 9.12705C0.973161 10.5506 0.931217 13.2379 1.14513 14.8042C1.33073 16.3706 2.35416 17.383 3.75194 17.383H5.56287L9.08931 20.3236C9.45107 20.6382 10.0897 20.9989 10.6769 20.9989C10.7146 21 10.7482 21 10.7817 21C11.845 21 12.7814 20.2206 13.1327 19.0192C13.2659 18.5082 13.312 18.0293 13.3571 17.5666L13.4043 17.1082C13.5846 15.6213 13.5846 8.36908 13.4043 6.89288L13.3571 6.45056Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M17.4064 6.49468C17.118 6.06953 16.5465 5.96325 16.1281 6.25849C15.7139 6.55587 15.6112 7.14206 15.8995 7.56613C16.7017 8.74816 17.1432 10.3221 17.1432 12.0001C17.1432 13.6771 16.7017 15.252 15.8995 16.4341C15.6112 16.8581 15.7139 17.4443 16.1292 17.7417C16.2844 17.8512 16.4658 17.9092 16.6524 17.9092C16.9534 17.9092 17.2344 17.7578 17.4064 17.5055C18.4193 16.0132 18.9782 14.0582 18.9782 12.0001C18.9782 9.94201 18.4193 7.98698 17.4064 6.49468Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M20.5672 3.45726C20.2809 3.03319 19.7073 2.92475 19.29 3.22107C18.8758 3.51845 18.773 4.10464 19.0603 4.52871C20.4172 6.52776 21.1649 9.18169 21.1649 11.9999C21.1649 14.8192 20.4172 17.4731 19.0603 19.4722C18.773 19.8973 18.8758 20.4824 19.291 20.7798C19.4462 20.8893 19.6266 20.9473 19.8132 20.9473C20.1142 20.9473 20.3963 20.7959 20.5672 20.5436C22.1359 18.2343 22.9999 15.2003 22.9999 11.9999C22.9999 8.80164 22.1359 5.76657 20.5672 3.45726Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Pengaduan Warga</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('permintaan.surat') ? 'active' : '' }}"
                         href="{{ route('permintaan.surat') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path opacity="0.4"
                                     d="M18.8089 9.021C18.3574 9.021 17.7594 9.011 17.0149 9.011C15.199 9.011 13.7059 7.508 13.7059 5.675V2.459C13.7059 2.206 13.503 2 13.2525 2H7.96436C5.49604 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59109 22 8.1703 22H16.0455C18.5059 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.298 9.012 20.0465 9.013C19.6238 9.016 19.1168 9.021 18.8089 9.021Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1732 7.55437 17.2792 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M15.1052 12.7088C14.8132 12.4198 14.3432 12.4178 14.0512 12.7108L12.4622 14.3078V9.48084C12.4622 9.06984 12.1282 8.73584 11.7172 8.73584C11.3062 8.73584 10.9722 9.06984 10.9722 9.48084V14.3078L9.38224 12.7108C9.09124 12.4178 8.62024 12.4198 8.32924 12.7088C8.03724 12.9988 8.03724 13.4698 8.32624 13.7618L11.1892 16.6378H11.1902C11.2582 16.7058 11.3392 16.7608 11.4302 16.7988C11.5202 16.8358 11.6182 16.8558 11.7172 16.8558C11.8172 16.8558 11.9152 16.8358 12.0052 16.7978C12.0942 16.7608 12.1752 16.7058 12.2432 16.6388L12.2452 16.6378L15.1072 13.7618C15.3972 13.4698 15.3972 12.9988 15.1052 12.7088Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>

                         <span class="item-name">Permintaan Surat</span>
                     </a>
                 </li>

                 <li>
                     <hr class="hr-horizontal">
                 </li>
                 @php
                     // Kumpulan pattern nama route untuk grup "Menu Surat"
                     $suratRoutePatterns = ['skkm.*', 'skd.*', 'sku.*', 'sktm.*'];

                     // True jika salah satu route di atas sedang aktif
                     $suratActive = request()->routeIs(...$suratRoutePatterns);
                 @endphp
                 <li class="nav-item">
                     <a class="nav-link {{ $suratActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                         href="#menuSurat" role="button" aria-expanded="{{ $suratActive ? 'true' : 'false' }}"
                         aria-controls="menuSurat">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path opacity="0.4"
                                     d="M18.8088 9.021C18.3573 9.021 17.7592 9.011 17.0146 9.011C15.1987 9.011 13.7055 7.508 13.7055 5.675V2.459C13.7055 2.206 13.5036 2 13.253 2H7.96363C5.49517 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59022 22 8.16958 22H16.0463C18.5058 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.299 9.012 20.0475 9.013C19.6247 9.016 19.1177 9.021 18.8088 9.021Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1742 7.55437 17.2802 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z"
                                     fill="currentColor"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M8.97398 11.3877H12.359C12.77 11.3877 13.104 11.0547 13.104 10.6437C13.104 10.2327 12.77 9.89868 12.359 9.89868H8.97398C8.56298 9.89868 8.22998 10.2327 8.22998 10.6437C8.22998 11.0547 8.56298 11.3877 8.97398 11.3877ZM8.97408 16.3819H14.4181C14.8291 16.3819 15.1631 16.0489 15.1631 15.6379C15.1631 15.2269 14.8291 14.8929 14.4181 14.8929H8.97408C8.56308 14.8929 8.23008 15.2269 8.23008 15.6379C8.23008 16.0489 8.56308 16.3819 8.97408 16.3819Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Menu Surat</span>
                         <i class="right-icon ms-auto">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" />
                             </svg>
                         </i>
                     </a>
                     <ul class="sub-nav collapse {{ $suratActive ? 'show' : '' }}" id="menuSurat"
                         data-bs-parent="#sidebar-menu">
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('skkm.*') ? 'active' : '' }}"
                                 href="{{ route('skkm.index') }}">
                                 <span class="item-name text-wrap">Surat Keterangan Meninggal Dunia</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('skd.*') ? 'active' : '' }}"
                                 href="{{ route('skd.index') }}">
                                 <span class="item-name text-wrap">Surat Keterangan Domisili</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('sku.*') ? 'active' : '' }}"
                                 href="{{ route('sku.index') }}">
                                 <span class="item-name text-wrap">Surat Keterangan Usaha</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('sktm.*') ? 'active' : '' }}"
                                 href="{{ route('sktm.index') }}">
                                 <span class="item-name text-wrap">Surat Keterangan Tidak Mampu</span>
                             </a>
                         </li>
                     </ul>
                 </li>

                 <li>
                     <hr class="hr-horizontal">
                 </li>
                 <li class="nav-item static-item">
                     <a class="nav-link static-item disabled" href="#" tabindex="-1">
                         <span class="default-icon">Manajemen Pengguna</span>
                         <span class="mini-icon">
                             <svg class="icon-12" width="12" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path d="M10.33 16.5928H4.0293" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M13.1406 6.90042H19.4413" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M8.72629 6.84625C8.72629 5.5506 7.66813 4.5 6.36314 4.5C5.05816 4.5 4 5.5506 4 6.84625C4 8.14191 5.05816 9.19251 6.36314 9.19251C7.66813 9.19251 8.72629 8.14191 8.72629 6.84625Z"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M20.0002 16.5538C20.0002 15.2581 18.9429 14.2075 17.6379 14.2075C16.3321 14.2075 15.2739 15.2581 15.2739 16.5538C15.2739 17.8494 16.3321 18.9 17.6379 18.9C18.9429 18.9 20.0002 17.8494 20.0002 16.5538Z"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"></path>
                             </svg>
                         </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('perangkat.index') ? 'active' : '' }}"
                         href="{{ route('perangkat.index') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                     d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Perangkat Nagari</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('pengguna.index') ? 'active' : '' }}"
                         href="{{ route('pengguna.index') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                     d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Data Pengguna</span>
                     </a>
                 </li>

                 @role('seknag')
                     <li class="nav-item">
                         <a class="nav-link {{ request()->routeIs('verifikasi.index') ? 'active' : '' }}"
                             href="{{ route('verifikasi.index') }}">
                             <i class="icon">
                                 <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path opacity="0.4"
                                         d="M18.8088 9.021C18.3573 9.021 17.7592 9.011 17.0146 9.011C15.1987 9.011 13.7055 7.508 13.7055 5.675V2.459C13.7055 2.206 13.5036 2 13.253 2H7.96363C5.49517 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59022 22 8.16958 22H16.0463C18.5058 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.299 9.012 20.0475 9.013C19.6247 9.016 19.1177 9.021 18.8088 9.021Z"
                                         fill="currentColor"></path>
                                     <path opacity="0.4"
                                         d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1742 7.55437 17.2802 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z"
                                         fill="currentColor"></path>
                                     <path fill-rule="evenodd" clip-rule="evenodd"
                                         d="M8.97398 11.3877H12.359C12.77 11.3877 13.104 11.0547 13.104 10.6437C13.104 10.2327 12.77 9.89868 12.359 9.89868H8.97398C8.56298 9.89868 8.22998 10.2327 8.22998 10.6437C8.22998 11.0547 8.56298 11.3877 8.97398 11.3877ZM8.97408 16.3819H14.4181C14.8291 16.3819 15.1631 16.0489 15.1631 15.6379C15.1631 15.2269 14.8291 14.8929 14.4181 14.8929H8.97408C8.56308 14.8929 8.23008 15.2269 8.23008 15.6379C8.23008 16.0489 8.56308 16.3819 8.97408 16.3819Z"
                                         fill="currentColor"></path>
                                 </svg>
                             </i>
                             <span class="item-name">Verifikasi Surat</span>
                         </a>
                     </li>
                 @endrole
                 <li>
                     <hr class="hr-horizontal">
                 </li>
                 <li class="nav-item static-item">
                     <a class="nav-link static-item disabled" href="#" tabindex="-1">
                         <span class="default-icon">Manajemen Konten</span>
                         <span class="mini-icon">
                             <svg class="icon-12" width="12" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path d="M10.33 16.5928H4.0293" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M13.1406 6.90042H19.4413" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M8.72629 6.84625C8.72629 5.5506 7.66813 4.5 6.36314 4.5C5.05816 4.5 4 5.5506 4 6.84625C4 8.14191 5.05816 9.19251 6.36314 9.19251C7.66813 9.19251 8.72629 8.14191 8.72629 6.84625Z"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M20.0002 16.5538C20.0002 15.2581 18.9429 14.2075 17.6379 14.2075C16.3321 14.2075 15.2739 15.2581 15.2739 16.5538C15.2739 17.8494 16.3321 18.9 17.6379 18.9C18.9429 18.9 20.0002 17.8494 20.0002 16.5538Z"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"></path>
                             </svg>
                         </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('kategori-koten.index') ? 'active' : '' }}"
                         href="{{ route('kategori-koten.index') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path opacity="0.4"
                                     d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z"
                                     fill="currentColor"></path>
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                     d="M8.07996 6.6499V6.6599C7.64896 6.6599 7.29996 7.0099 7.29996 7.4399C7.29996 7.8699 7.64896 8.2199 8.07996 8.2199H11.069C11.5 8.2199 11.85 7.8699 11.85 7.4289C11.85 6.9999 11.5 6.6499 11.069 6.6499H8.07996ZM15.92 12.7399H8.07996C7.64896 12.7399 7.29996 12.3899 7.29996 11.9599C7.29996 11.5299 7.64896 11.1789 8.07996 11.1789H15.92C16.35 11.1789 16.7 11.5299 16.7 11.9599C16.7 12.3899 16.35 12.7399 15.92 12.7399ZM15.92 17.3099H8.07996C7.77996 17.3499 7.48996 17.1999 7.32996 16.9499C7.16996 16.6899 7.16996 16.3599 7.32996 16.1099C7.48996 15.8499 7.77996 15.7099 8.07996 15.7399H15.92C16.319 15.7799 16.62 16.1199 16.62 16.5299C16.62 16.9289 16.319 17.2699 15.92 17.3099Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Data Kategori Konten</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('konten.index') ? 'active' : '' }}"
                         href="{{ route('konten.index') }}">
                         <i class="icon">
                             <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                     d="M21.9999 14.7024V16.0859C21.9999 16.3155 21.9899 16.5471 21.9699 16.7767C21.6893 19.9357 19.4949 22 16.3286 22H7.67126C6.06806 22 4.71535 21.4797 3.74341 20.5363C3.36265 20.1864 3.042 19.7753 2.7915 19.3041C3.12217 18.9021 3.49291 18.462 3.85363 18.0208C4.46485 17.289 5.05603 16.5661 5.42677 16.0959C5.97788 15.4142 7.43078 13.6196 9.44481 14.4617C9.85563 14.6322 10.2164 14.8728 10.547 15.0833C11.3586 15.6247 11.6993 15.7851 12.2705 15.4743C12.9017 15.1335 13.3125 14.4617 13.7434 13.76C13.9739 13.388 14.2043 13.0281 14.4548 12.6972C15.547 11.2736 17.2304 10.8926 18.6332 11.7348C19.3346 12.1559 19.9358 12.6872 20.4969 13.2276C20.6172 13.3479 20.7374 13.4592 20.8476 13.5695C20.9979 13.7198 21.4989 14.2211 21.9999 14.7024Z"
                                     fill="currentColor"></path>
                                 <path opacity="0.4"
                                     d="M16.3387 2H7.67134C4.27455 2 2 4.37607 2 7.91411V16.086C2 17.3181 2.28056 18.4119 2.79158 19.3042C3.12224 18.9022 3.49299 18.4621 3.85371 18.0199C4.46493 17.2891 5.05611 16.5662 5.42685 16.096C5.97796 15.4143 7.43086 13.6197 9.44489 14.4618C9.85571 14.6323 10.2164 14.8729 10.5471 15.0834C11.3587 15.6248 11.6994 15.7852 12.2705 15.4734C12.9018 15.1336 13.3126 14.4618 13.7435 13.759C13.9739 13.3881 14.2044 13.0282 14.4549 12.6973C15.5471 11.2737 17.2305 10.8927 18.6333 11.7349C19.3347 12.1559 19.9359 12.6873 20.497 13.2277C20.6172 13.348 20.7375 13.4593 20.8477 13.5696C20.998 13.7189 21.499 14.2202 22 14.7025V7.91411C22 4.37607 19.7255 2 16.3387 2Z"
                                     fill="currentColor"></path>
                                 <path
                                     d="M11.4543 8.79668C11.4543 10.2053 10.2809 11.3783 8.87313 11.3783C7.46632 11.3783 6.29297 10.2053 6.29297 8.79668C6.29297 7.38909 7.46632 6.21509 8.87313 6.21509C10.2809 6.21509 11.4543 7.38909 11.4543 8.79668Z"
                                     fill="currentColor"></path>
                             </svg>
                         </i>
                         <span class="item-name">Data Berita</span>
                     </a>
                 </li>
             </ul>
             <!-- Sidebar Menu End -->
         </div>
     </div>
 </aside>
