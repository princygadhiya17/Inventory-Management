 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">AdminLTE 3</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block"><?php echo $_SESSION['user_name']; ?></a>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="index.php" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                 </li>
                 <li class="nav-item has-treeview">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Parties
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>

                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="customers.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Customers</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="supplier.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Suppliers</p>
                             </a>
                         </li>
                     </ul>
                 </li>

                 <li class="nav-item has-treeview">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-tree"></i>
                         <p>
                             Masters
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>

                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="brand.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Brand</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="category.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Category</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="unit.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Unit</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="product.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Product</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item has-treeview">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-tree"></i>
                         <p>
                             Invoice
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>

                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="sales.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Sales</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="sales_return.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Sales Return</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="purchase.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Purchase</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="purchase_return.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Purchase Return</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="payment_in.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Payment In</p>
                             </a>
                         </li>
                         <!-- <li class="nav-item">
                             <a href="payment_out.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Payment Out</p>
                             </a>
                         </li> -->
                     </ul>
                 </li>
                 <li class="nav-item has-treeview">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-tree"></i>
                         <p>
                             Reports
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>

                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="sales_reports.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Sales Reports</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="salesreturn_report.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Sales Return Reports</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="purchase_report.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Purchase Reports</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="purchasereturn_report.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Purchase Return Reports</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item has-treeview">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-tree"></i>
                         <p>
                             Stock History
                             <i class="fas fa-angle-left right"></i>
                         </p>
                     </a>

                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="stock_history.php" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Stock Summary</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="logout.php" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             logout
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                 </li>

             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>