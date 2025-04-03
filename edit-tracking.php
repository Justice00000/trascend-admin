
    
    
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
		<!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <ul class="navbar-nav navbar-nav-left">
              
                                         
            </ul>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
  <a class="navbar-brand brand-logo" href="index.php">
    <img src="images/logo.png" alt="logo" class="enhanced-logo"/>
  </a>
  <a class="navbar-brand brand-logo-mini" href="index.php">
    <img src="images/logo.png" alt="logo" class="enhanced-logo-mini"/>
  </a>
</div>
            <ul class="navbar-nav navbar-nav-right">
                
                
                
                <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <span class="nav-profile-name">Admin</span>
                    <span class="online-status"></span>
                    <img src="images/face28.png" alt="profile"/>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                      <a href="settings.php" class="dropdown-item">
                        <i class="mdi mdi-settings text-primary"></i>
                        Settings
                      </a>
                      <a href="logout.php" class="dropdown-item">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                      </a>
                  </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
              <li class="nav-item">
                <a class="nav-link" href="index.php">
                  <i class="mdi mdi-file-document-box menu-icon"></i>
                  <span class="menu-title">Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                  <a href="add-tracking.php" class="nav-link">
                    <i class="mdi mdi-grid menu-icon"></i>
                    <span class="menu-title">Add Tracking</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="account.php" class="nav-link">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">Account</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="settings.php" class="nav-link">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="logout.php" class="nav-link">
                    <i class="mdi mdi-close menu-icon"></i>
                    <span class="menu-title">Logout</span>
                    <i class="menu-arrow"></i>
                  </a>

              </li>
              
              
              
                          </ul>
        </div>
      </nav>
    </div>
    <!-- partial -->
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">


<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<label style="font-weight: bold;font-size: 25px;">TRACKING NUMBER  - CC-03-234791</label>
				
			</div>
		</div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <form method="post" action="edit-tracking.php?num=CC-03-234791" class="forms-sample">
            <div class="form-group">
              <label for="exampleInputUsername1">Status</label>
              <select class="form-control" name="status">
                <option value="Pending">Pending</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Picked Up">Picked Up</option>
                <option value="On going">On going</option>
                <option value="Delivered">Delivered</option>
                <option value="Departed">Departed</option>
                <option value="On hold">On hold</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Current Location</label>
              <input type="text" class="form-control" value="" name="current_loc" id="exampleInputPassword1" placeholder="Current Location ">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Date</label>
              <input type="date" class="form-control" value="" name="date" id="" placeholder="Date">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Time</label>
              <input type="time" class="form-control" value="" name="time" id="" placeholder="">
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Delivery Charge</label>
              <input type="text" class="form-control" value="" name="delivery_charge" id="exampleInputPassword1" placeholder="Delivery Charge">
            </div>
            
             <div class="form-group">
              <label for="exampleInputPassword1">Total Charge</label>
              <input type="text" class="form-control" value="" name="total_charge" id="exampleInputPassword1" placeholder="Total Charge">
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Note</label>
              <textarea name="note" class="form-control"></textarea>
            </div>
        </div>
      </div>
    </div>
    
</div>
    <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
            	<button class="btn btn-lg btn-success btn-block" name="update">Update</button>
            </div>
        </div>
        </form>
    </div>


</div>
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
				<footer class="footer">
          <div class="footer-wrap">
              <div class="w-100 clearfix">
                <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright ©Platinum Links 2025 All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <i class="mdi mdi-heart-outline"></i></span>
              </div>
          </div>
        </footer>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="vendors/base/vendor.bundle.base.js"></script>

  <script src="js/template.js"></script>

  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  </body>
</html>
