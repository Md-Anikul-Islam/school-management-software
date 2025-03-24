<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Dashboard | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description"/>
    <meta content="SDMGA" name="author"/>
    <link rel="shortcut icon" href="{{asset('backend/images/favicon.ico')}}">
    <!-- Select2 css -->
    <link href="{{asset('backend/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Datatables css -->
    <link href="{{asset('backend/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('backend/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}"
          rel="stylesheet" type="text/css"/>
{{--    <link href="{{asset('backend/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css')}}"--}}
{{--          rel="stylesheet" type="text/css"/>--}}
{{--    <link href="{{asset('backend/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css')}}"--}}
{{--          rel="stylesheet" type="text/css"/>--}}
    <link href="{{asset('backend/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('backend/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{asset('backend/vendor/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet"
          href="{{asset('backend/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}">
    <script src="{{asset('backend/js/config.js')}}"></script>
    <link href="{{asset('backend/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style"/>
    <link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    {{-- Custom Css File here --}}
    <script src="{{asset('backend/js/chart.js')}}"></script>
    <script src="{{asset('backend/js/echarts.min.js')}}"></script>

</head>

<body>
<div class="wrapper">
    <div class="navbar-custom">
        <div class="topbar container-fluid">
            <div class="d-flex align-items-center gap-1">
                <!-- Sidebar Menu Toggle Button -->
                <button class="button-toggle-menu">
                    <i class="ri-menu-line"></i>
                </button>
            </div>
            <ul class="topbar-menu d-flex align-items-center gap-3">
                <li class="dropdown d-lg-none">
                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        <i class="ri-search-line fs-22"></i>
                    </a>
                </li>
                <li class="d-none d-sm-inline-block">
                    <div class="nav-link" id="light-dark-mode">
                        <i class="ri-moon-line fs-22"></i>
                    </div>
                </li>
                <li class="dropdown">
                    @php
                        $admin = auth()->user();
                    @endphp
                    <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                       role="button"
                       aria-haspopup="false" aria-expanded="false">
                        <span class="d-lg-block d-none">
                              <h5 class="my-0 fw-normal">{{$admin->name}}
                                  <i class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                              </h5>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>
                        <a href="#" class="dropdown-item">
                            <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                            <span>My Account</span>
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="leftside-menu">
        <a href="{{route('dashboard')}}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{URL::to('backend/images/logo/1737184094.png')}}" alt="logo" style="height: 100px;">
            </span>
            <span class="logo-sm">
                <img src="{{URL::to('backend/images/logo/1730959165.png')}}" alt="small logo" style="height: 20px;">
            </span>
        </a>

        <div class="h-100" id="leftside-menu-container" data-simplebar>
            <ul class="side-nav">
                <li class="side-nav-title">Main</li>
                <li class="side-nav-item">
                    <a href="{{route('dashboard')}}" class="side-nav-link">
                        <i class="ri-dashboard-3-line"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                @can('resource-list')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-pages-line"></i>
                            <span> Resource </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages">
                            <ul class="side-nav-second-level">

                                <li>
                                    <a href="#">News</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endcan

                @can('student-list')
                    <li class="side-nav-item">
                        <a href="{{ route('student.index') }}" class="side-nav-link">
                            <i class="ri-user-3-line"></i> <span> Student </span>
                        </a>
                    </li>
                @endcan

                @can('guardian-list')
                    <li class="side-nav-item">
                        <a href="{{route('guardian.index')}}" class="side-nav-link">
                            <i class="ri-user-heart-line"></i> <span> Parents </span>
                        </a>
                    </li>
                @endcan

                @can('teacher-list')
                    <li class="side-nav-item">
                        <a href="{{route('teacher.index')}}" class="side-nav-link">
                            <i class="ri-user-star-line"></i> <span> Teacher </span>
                        </a>
                    </li>
                @endcan

                @can('academics-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages2" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-book-2-line"></i> <span>Academic</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages2">
                            <ul class="side-nav-second-level">
                                @can('class-list')
                                    <li>
                                        <a href="{{ route('class.index') }}">
                                            <i class="ri-team-line"></i> <span>Class</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('section-list')
                                    <li>
                                        <a href="{{ route('section.index') }}">
                                            <i class="ri-layout-grid-line"></i> <span>Section</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('subject-list')
                                    <li>
                                        <a href="{{ route('subject.index') }}">
                                            <i class="ri-book-open-line"></i> <span>Subject</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('syllabus-list')
                                    <li>
                                        <a href="{{ route('syllabus.index') }}">
                                            <i class="ri-file-list-3-line"></i> <span>Syllabus</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('assignment-list')
                                    <li>
                                        <a href="{{ route('assignment.index') }}">
                                            <i class="ri-task-line"></i> <span>Assignment</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('exam-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages3" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-file-text-line"></i>
                            <span>Exam</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages3">
                            <ul class="side-nav-second-level">
                                @can('exam-list')
                                    <li>
                                        <a href="{{ route('exam.index') }}">
                                            <i class="ri-file-text-line"></i>
                                            <span>Exam</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('exam-schedule-list')
                                    <li>
                                        <a href="{{ route('exam-schedule.index') }}">
                                            <i class="ri-calendar-event-line"></i>
                                            <span>Exam Schedule</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('grade-list')
                                    <li>
                                        <a href="{{ route('grade.index') }}">
                                            <i class="ri-bar-chart-line"></i>
                                            <span>Exam Grade</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('mark-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages4" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-pencil-ruler-2-line"></i>
                            <span>Mark</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages4">
                            <ul class="side-nav-second-level">
                                @can('mark-list')
                                    <li>
                                        <a href="{{ route('mark.index') }}">
                                            <i class="ri-file-edit-line"></i>
                                            <span>Mark</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('mark-distribution-list')
                                    <li>
                                        <a href="#">
                                            <i class="ri-pie-chart-line"></i>
                                            <span>Mark Distribution</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('mark-promotion')
                                    <li>
                                        <a href="#">
                                            <i class="ri-arrow-up-circle-line"></i>
                                            <span>Promotion</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('inventory-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages5" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-inbox-archive-line"></i>
                            <span>Inventory</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages5">
                            <ul class="side-nav-second-level">
                                @can('category-list')
                                    <li>
                                        <a href="{{ route('category.index') }}">
                                            <i class="ri-price-tag-3-line"></i>
                                            <span>Category</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('product-list')
                                    <li>
                                        <a href="{{ route('product.index') }}">
                                            <i class="ri-shopping-bag-line"></i>
                                            <span>Product</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('warehouse-list')
                                    <li>
                                        <a href="{{ route('warehouse.index') }}">
                                            <i class="ri-store-2-line"></i>
                                            <span>Warehouse</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('supplier-list')
                                    <li>
                                        <a href="{{ route('supplier.index') }}">
                                            <i class="ri-truck-line"></i>
                                            <span>Supplier</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('hostel-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages6" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-hotel-line"></i>
                            <span>Hostel</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages6">
                            <ul class="side-nav-second-level">
                                @can('hostel-list')
                                    <li>
                                        <a href="{{ route('hostel.index') }}">
                                            <i class="ri-home-4-line"></i>
                                            <span>Hostel</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('hostel-category-list')
                                    <li>
                                        <a href="{{ route('hostel-category.index') }}">
                                            <i class="ri-bookmark-3-line"></i>
                                            <span>Category</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('online-exam-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages7" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-computer-line"></i>
                            <span>Online Exam</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages7">
                            <ul class="side-nav-second-level">
                                @can('question-group-list')
                                    <li>
                                        <a href="{{ route('question-group.index') }}">
                                            <i class="ri-stack-line"></i>
                                            <span>Question Group</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('question-level-list')
                                    <li>
                                        <a href="{{ route('question-level.index') }}">
                                            <i class="ri-filter-3-line"></i>
                                            <span>Question Level</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('question-bank-list')
                                    <li>
                                        <a href="{{ route('question-bank.index') }}">
                                            <i class="ri-database-2-line"></i>
                                            <span>Question Bank</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('instruction-list')
                                    <li>
                                        <a href="{{ route('instruction.index') }}">
                                            <i class="ri-information-line"></i>
                                            <span>Instruction</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('asset-management-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages8" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-briefcase-line"></i> <span>Asset Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages8">
                            <ul class="side-nav-second-level">
                                @can('question-group-list')
                                    <li>
                                        <a href="{{ route('vendor.index') }}">
                                            <i class="ri-user-3-line"></i> <span>Vendor</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('location-list')
                                    <li>
                                        <a href="{{ route('location.index') }}">
                                            <i class="ri-map-pin-line"></i> <span>Location</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('asset-category-list')
                                    <li>
                                        <a href="{{ route('asset-category.index') }}">
                                            <i class="ri-folder-2-line"></i> <span>Asset Category</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('asset-list')
                                    <li>
                                        <a href="{{ route('asset.index') }}">
                                            <i class="ri-stack-line"></i> <span>Asset</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('asset-assignment-list')
                                    <li>
                                        <a href="{{ route('asset-assignment.index') }}">
                                            <i class="ri-exchange-line"></i> <span>Asset Assignment</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('purchase-list')
                                    <li>
                                        <a href="{{ route('purchase.index') }}">
                                            <i class="ri-shopping-cart-line"></i> <span>Purchase</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('leave-application-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages9" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-calendar-2-line"></i>
                            <span>Leave Application</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages9">
                            <ul class="side-nav-second-level">
                                @can('leave-category-list')
                                    <li>
                                        <a href="{{ route('leave-category.index') }}">
                                            <i class="ri-list-settings-line"></i>
                                            <span>Leave Category</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('leave-assign-list')
                                    <li>
                                        <a href="{{ route('leave-assign.index') }}">
                                            <i class="ri-user-search-line"></i>
                                            <span>Leave Assign</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('leave-apply-list')
                                    <li>
                                        <a href="{{ route('leave-apply.index') }}">
                                            <i class="ri-file-edit-line"></i>
                                            <span>Leave Apply</span></a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('leave-application-list')
                                    <li>
                                        <a href="{{ route('leave-application.index') }}">
                                            <i class="ri-file-edit-line"></i>
                                            <span>Leave Application</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('announcement-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages10" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-megaphone-line"></i>  <span>Announcement</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages10">
                            <ul class="side-nav-second-level">
                                @can('notice-list')
                                    <li>
                                        <a href="{{ route('notice.index') }}">
                                            <i class="ri-information-line"></i>  <span>Notice</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('event-list')
                                    <li>
                                        <a href="{{ route('event.index') }}">
                                            <i class="ri-calendar-line"></i>  <span>Event</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('holiday-list')
                                    <li>
                                        <a href="{{ route('holiday.index') }}">
                                            <i class="ri-calendar-event-line"></i>  <span>Holiday</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('media-list')
                    <li class="side-nav-item">
                        <a href="{{route('media.index')}}" class="side-nav-link">
                            <i class="ri-gallery-line"></i> <span> Media </span>
                        </a>
                    </li>
                @endcan


                @can('transport-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages11" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-bus-2-line"></i>  <span>Transport</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages11">
                            <ul class="side-nav-second-level">
                                @can('transport-list')
                                    <li>
                                        <a href="{{ route('transport.index') }}">
                                            <i class="ri-list-check"></i>   <span>Transport</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="side-nav-second-level">
                                @can('transport-member-list')
                                    <li>
                                        <a href="{{ route('transport-members.index') }}">
                                            <i class="ri-user-3-line"></i>   <span>Transport Member</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan


                @can('child-module')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages12" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-bus-2-line"></i>  <span>Child</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages12">
                            <ul class="side-nav-second-level">
                                @can('activities-category-list')
                                    <li>
                                        <a href="{{ route('activities-category.index') }}">
                                            <i class="ri-list-check"></i><span>Activities Category</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('role-and-permission-list')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages1" aria-expanded="false"
                           aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-rotate-lock-line"></i>
                            <span>Permission Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages1">
                            <ul class="side-nav-second-level">
                                @can('user-list')
                                    <li>
                                        <a href="{{url('users')}}">Create User</a>
                                    </li>
                                @endcan

                                @can('role-list')
                                    <li>
                                        <a href="{{url('roles')}}">Role & Permission</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                @yield('admin_content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <script>document.write(new Date().getFullYear())</script>
                        © Admin Dashboard</b>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

{{-- font awesome here --}}
<script src="{{asset('backend/js/vendor.min.js')}}"></script>

<!-- Dropzone File Upload js -->
<script src="{{asset('backend/vendor/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{asset('backend/js/pages/fileupload.init.js')}}"></script>

<!--  Select2 Plugin Js -->
<script src="{{asset('backend/vendor/select2/js/select2.min.js')}}"></script>
<script src="{{asset('backend/vendor/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('backend/vendor/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('backend/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('backend/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script
    src="{{asset('backend/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- Ckeditor Here -->
<script src="{{asset('backend/js/sdmg.ckeditor.js')}}"></script>

<!-- Datatables js -->
<script src="{{asset('backend/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
{{--<script src="{{asset('backend/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>--}}
{{--<script src="{{asset('backend/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js')}}"></script>--}}
<script src="{{asset('backend/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>

<!-- Datatable Demo Aapp js -->
{{--<script src="{{asset('backend/js/pages/datatable.init.js')}}"></script>--}}
<script src="{{asset('backend/js/pages/dashboard.js')}}"></script>
<script src="{{asset('backend/js/app.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.form-control[multiple]').select2({
            allowClear: true
        });
    });
</script>
</body>
</html>
