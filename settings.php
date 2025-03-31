<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- base:css -->
    <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
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
  <a class="navbar-brand brand-logo" href="dashboard.php">
    <img src="images/logo.png" alt="logo" class="enhanced-logo"/>
  </a>
  <a class="navbar-brand brand-logo-mini" href="dashboard.php">
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
                <a class="nav-link" href="dashboard.php">
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
    <div class="col-lg-12">
      	<div class="accordion" id="accordionExample">
      		<div class="accordion-item">
			    <h2 class="accordion-header" id="headingThree">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			        General Settings
			      </button>
			    </h2>
			    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
			      <div class="accordion-body">
			        	<form method="post" action="settings.php" class="forms-sample">
				            <div class="form-group">
				              <label for="exampleInputUsername1">Site Name</label>
				              <input type="text" class="form-control" name="site_name" value="Platinum Links" required>
				            </div>

				            <div class="form-group">
				              <label for="exampleInputUsername1">Site Title</label>
				              <input type="text" class="form-control" name="sitetitle" value="Logistics" required>
				            </div>

				            <div class="form-group">
				              <label for="exampleInputUsername1">Site URL</label>
				              <input type="text" class="form-control" name="siteurl" value="https://platinumlinkslogitics.com" required>
				            </div>


				            
				            <div class="text-center">
				              <button type="submit" name="save-general" class="btn btn-block btn-success">Save</button>
				            </div>  
				        </form>
			      </div>
			    </div>
			  </div>
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingOne">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
		        Shipping Settings
		      </button>
		    </h2>
		    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
		      <div class="accordion-body">
		      		<form method="post" action="settings.php" class="forms-sample">
			            <div class="form-group">
			              <label for="exampleInputUsername1">Delivery Prefix</label>
			              <input type="text" class="form-control" name="prefix" minlength="4" value="CC" required>
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">Number of digits in the trace: EXAMPLE: 0000001</label>
			              <input type="number" class="form-control" value="6" name="trace" id="" required>
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">Allow Print Invoice</label>
			              <select name="print" class="form-control" required="">
			              	<option value="Yes" selected>Yes</option>
			              	<option value="No" >No</option>
			              </select>
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">Show Map</label>
			              <select name="show_map" class="form-control" required="">
			              	<option value="Yes" selected>Yes</option>
			              	<option value="No" >No</option>
			              </select>
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">Invoice Terms</label>
			              <textarea name="terms" class="form-control">terms</textarea>
			            </div>
			            <div class="text-center">
			              <button type="submit" name="save-ship" class="btn btn-block btn-success">Save</button>
			            </div>  
			        </form>
		      </div>
		    </div>
		  </div>
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingTwo">
		      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		        E-Mail Settings
		      </button>
		    </h2>
		    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
		      <div class="accordion-body">
		        <form method="post" action="settings.php" class="forms-sample">
		            <div class="form-group">
		              <label for="exampleInputUsername1">Email Name</label>
		              <input type="text" class="form-control" name="mail_name" value="Platinum Links Logistics" required>
		            </div>

		            <div class="form-group">
		              <label for="exampleInputUsername1">Email Address</label>
		              <input type="text" class="form-control" name="mail_add" value="shipping@platinumlinkslogitics.com" required>
		            </div>

		            <div class="form-group">
		              <label for="exampleInputUsername1">Send Mail When For New Tracking</label>
		              <select name="mail_track" class="form-control" required="">
		              	<option value="Yes" selected>Yes</option>
		              	<option value="No" >No</option>
		              </select>
		            </div>

		            <div class="form-group">
		              <label for="exampleInputUsername1">Send Mail When Tracking's Update</label>
		              <select name="mail_update" class="form-control" required="">
		              	<option value="Yes" selected>Yes</option>
		              	<option value="No" >No</option>
		              </select>
		            </div>
		            
		            <div class="text-center">
		              <button type="submit" name="save-mail" class="btn btn-block btn-success">Save</button>
		            </div>  
		        </form>
		    </div>
		  </div>
		  
		</div>
    </div>
</div>
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