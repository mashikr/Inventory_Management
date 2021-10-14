<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inventory Management</title>
       <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
        <!-- endinject -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset('vendors/vertical-layout-light/style.css') }}">
        <!-- endinject -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>

        <div class="container-scroller" id="app"> 
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
              <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                  <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize" style="display: none;" id="iconToggler">
                    <span class="icon-menu"></span>
                  </button>
                </div>
                <div>
                  <span class="navbar-brand brand-logo">
                    Apu Shop
                  </span>
                </div>
              </div>
              <div class="navbar-menu-wrapper d-flex align-items-top"> 
                <ul class="navbar-nav">
                  <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                    <h1 class="welcome-text">Welcome to, <span class="text-black fw-bold">Apu Shop</span></h1>
                  </li>
                </ul>
                <ul class="d-none ms-auto" id="rightNav">
                  <li class="nav-item dropdown d-none d-lg-block">
                    <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> Select Category </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                      {{-- <a class="dropdown-item py-3" >
                        <p class="mb-0 font-weight-medium float-left">Select category</p>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item preview-item">
                        <div class="preview-item-content flex-grow py-2">
                          <p class="preview-subject ellipsis font-weight-medium text-dark">Bootstrap Bundle </p>
                          <p class="fw-light small-text mb-0">This is a Bundle featuring 16 unique dashboards</p>
                        </div>
                      </a>
                      <a class="dropdown-item preview-item">
                        <div class="preview-item-content flex-grow py-2">
                          <p class="preview-subject ellipsis font-weight-medium text-dark">Angular Bundle</p>
                          <p class="fw-light small-text mb-0">Everything you’ll ever need for your Angular projects</p>
                        </div>
                      </a> --}}
                    </div>
                  </li>
                  <li class="nav-item d-none d-lg-block">
                    <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                      <span class="input-group-addon input-group-prepend border-right">
                        <span class="icon-calendar input-group-text calendar-icon"></span>
                      </span>
                      <input type="text" class="form-control">
                    </div>
                  </li>
                  <li class="nav-item">
                    <form class="search-form" action="#">
                      <i class="icon-search"></i>
                      <input type="search" class="form-control" placeholder="Search Here" title="Search here">
                    </form>
                  </li>
                
                  
                  <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="far fa-user"></i> </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                      <div class="dropdown-header text-center">
                        <p class="mb-1 mt-3 font-weight-semibold" id="username">Apu Super Shop</p>
                        <p class="fw-light text-muted mb-0" id="useremail">apusupershop@gmail.com</p>
                      </div>
                      <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                      <a id="signout" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                    </div>
                  </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                  <span class="mdi mdi-menu"></span>
                </button>
              </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid px-0 page-body-wrapper">
              <!-- partial:partials/_settings-panel.html -->
              <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                  <i class="settings-close ti-close"></i>
                  <p class="settings-heading">SIDEBAR SKINS</p>
                  <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border me-3"></div>Light</div>
                  <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border me-3"></div>Dark</div>
                  <p class="settings-heading mt-2">HEADER SKINS</p>
                  <div class="color-tiles mx-0 px-4">
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles default"></div>
                  </div>
                </div>
              </div>
              
              <!-- partial -->
              <!-- partial:partials/_sidebar.html -->
              <nav class="sidebar sidebar-offcanvas" style="display: none;" id="sidebar">
                <ul class="nav">
                  <li class="nav-item">
                    <router-link class="nav-link" to="/home">
                      <i class="mdi mdi-grid-large menu-icon"></i>
                      <span class="menu-title">Dashboard</span>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="sell">
                      <i class="menu-icon fas fa-cart-plus"></i>
                      <span class="menu-title">Sell</span>
                    </a>
                  </li>

                  <li class="nav-item nav-category">Product Department</li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Products" aria-expanded="false" aria-controls="form-elements">
                      <i class="menu-icon fas fa-box-open"></i>
                      <span class="menu-title">Products</span>
                      <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="Products">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><router-link class="nav-link" to="/product/add">Add Product</router-link></li>
                        <li class="nav-item"><router-link class="nav-link" to="/product/all">All Product</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Categories" aria-expanded="false" aria-controls="charts">
                      <i class="menu-icon far fa-list-alt"></i>
                      <span class="menu-title">Categories</span>
                      <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="Categories">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <router-link class="nav-link" to="/category/add">Add Category</router-link></li>
                        <li class="nav-item"> <router-link class="nav-link" to="/category/all">All Category</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Stock" aria-expanded="false" aria-controls="tables">
                      <i class="menu-icon fas fa-layer-group"></i>
                      <span class="menu-title">Stock</span>
                      <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="Stock">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Stock</a></li>
                      </ul>
                    </div>
                  </li>

                  <li class="nav-item nav-category">HR Departmen</li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#employee" aria-expanded="false" aria-controls="ui-basic">
                      <i class="menu-icon fas fa-people-carry"></i>
                      <span class="menu-title">Employee</span>
                      <i class="menu-arrow"></i> 
                    </a>
                    <div class="collapse" id="employee">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <router-link class="nav-link" to="/employee/add">Add Employee</router-link></li>
                        <li class="nav-item"> <router-link class="nav-link" to="/employee/all">All Employee</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#suppliers" aria-expanded="false" aria-controls="ui-basic">
                      <i class="menu-icon fas fa-truck-moving"></i>
                      <span class="menu-title">Suppliers</span>
                      <i class="menu-arrow"></i> 
                    </a>
                    <div class="collapse" id="suppliers">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <router-link class="nav-link" to="/supplier/add">Add Supplier</router-link></li>
                        <li class="nav-item"> <router-link class="nav-link" to="/supplier/all">All Supplier</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#customer" aria-expanded="false" aria-controls="ui-basic">
                      <i class="menu-icon fas fa-users"></i>
                      <span class="menu-title">Customers</span>
                      <i class="menu-arrow"></i> 
                    </a>
                    <div class="collapse" id="customer">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add Customer</a></li>
                        <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Delete Customer</a></li>
                      </ul>
                    </div>
                  </li>
                  
                  <li class="nav-item nav-category">Cost Department</li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#salary" aria-expanded="false" aria-controls="ui-basic">
                      <i class="menu-icon fas fa-dollar-sign"></i> 
                      <span class="menu-title">Employee Salary</span>
                      <i class="menu-arrow"></i> 
                    </a>
                    <div class="collapse" id="salary">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <router-link class="nav-link" to="/salary/add">Pay Salary</router-link></li>
                        <li class="nav-item"> <router-link class="nav-link" to="/salary/all">Salary List</router-link></li>
                      </ul>
                    </div>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#expense" aria-expanded="false" aria-controls="ui-basic">
                      <i class="menu-icon fas fa-hand-holding-usd"></i>
                      <span class="menu-title">Expense</span>
                      <i class="menu-arrow"></i> 
                    </a>
                    <div class="collapse" id="expense">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <router-link class="nav-link" to="/expense/add">Add Expense</router-link></li>
                        <li class="nav-item"> <router-link class="nav-link" to="/expense/all">Expense List</router-link></li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </nav>
            
              
              <!-- partial -->
              <div class="main-panel" style="width: 100%;">
                <div class="content-wrapper">
                 
                
                    <router-view></router-view>
                 
                  
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                  <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © Apu Super Shop 2021. All rights reserved.</span>
                  </div>
                </footer>
                <!-- partial -->
              </div>
              <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
          </div>
          <!-- container-scroller -->
        
        <!-- plugins:js -->
        <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ asset('vendors/off-canvas.js') }}"></script>
        <script src="{{ asset('vendors/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('vendors/template.js') }}"></script>
        <script src="{{ asset('vendors/settings.js') }}"></script>
        <script src="{{ asset('vendors/todolist.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="{{ asset('vendors/dashboard.js') }}"></script>
        <script src="{{ asset('vendors/Chart.roundedBarCharts.js') }}"></script>
        <!-- End custom js for this page-->

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
          document.getElementById("signout").addEventListener("click", function() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.replace("http://127.0.0.1:8000");
            Toast.fire({
                icon: 'success',
                title: 'Sign out successfully'
            })
          });

          if(localStorage.getItem('token')) {
            document.getElementById('iconToggler').style.display = '';
            document.getElementById('sidebar').style.display = 'block';
            document.getElementById('rightNav').classList.remove('d-none');
            document.getElementById('rightNav').classList.add('navbar-nav');
            
            document.getElementById('username').innerText = localStorage.getItem('user')
            document.getElementById('useremail').innerText = localStorage.getItem('email')
          
          }

          setTimeout(() => {
            $(".nav-link[data-bs-toggle='collapse']").attr('aria-expanded', 'false').addClass('collapsed');
            $("div.collapse").removeClass('show');
            $(".nav-item").removeClass('active');
          }, 10);

        </script>
    </body>
</html>
