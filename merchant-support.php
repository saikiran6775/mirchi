<?php
// Start the session to track user data across pages
session_start();

// Store the current page URL in session to track last visited page
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

// Include the database connection file
include_once('db-connect.php');

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // If user is not logged in, redirect to login page
    header('Location: login.php');
    exit(); // Stop further execution
}
?>
<!DOCTYPE html >
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities."/>
    <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app"/>
    <meta name="author" content="pixelstrap"/>
    <title>Admiro - Premium Admin Template</title>
    <!-- Favicon icon-->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon"/>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet"/>
    <!-- Flag icon css -->
    <link rel="stylesheet" href="assets/css/vendors/flag-icon.css"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/iconly-icon.css"/>
    <link rel="stylesheet" href="assets/css/bulk-style.css"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/themify.css"/>
    <!--fontawesome-->
    <link rel="stylesheet" href="assets/css/fontawesome-min.css"/>
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/weather-icons/weather-icons.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css"/>
    <!-- App css -->
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen"/>
  </head>
  <body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper"> 
      <?php 
        // Include the header file to load the common header section of the webpage
        // This helps in maintaining a consistent layout across multiple pages
        include 'header.php'; 
      ?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper"> 
        <!-- Page sidebar start-->
         <?php 
          // Include the sidebar file to display the navigation menu or additional content
          // This ensures consistency across multiple pages
          include 'sidebar.php'; 
        ?>
        <!-- Page sidebar end-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6 col-12"> 
                  <h2>Merchants Support Ticket</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Support</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xl-4 col-sm-6 box-col-6">
                        <div class="card ecommerce-widget">
                          <div class="card-body support-ticket-font">
                            <div class="row">
                              <div class="col-5"><span>Order</span>
                                <h3 class="total-num counter">2563</h3>
                              </div>
                              <div class="col-7">
                                <div class="text-end">
                                  <ul>
                                    <li>Profit<span class="product-stts text-success ms-2">8989<i class="icon-angle-up f-12 ms-1"></i></span></li>
                                    <li>Loss<span class="product-stts text-danger ms-2">2560<i class="icon-angle-down f-12 ms-1"></i></span></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <!--<div class="progress-showcase">-->
                            <!--  <div class="progress sm-progress-bar">-->
                            <!--    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--  </div>-->
                            <!--</div>-->
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-sm-6 box-col-6">
                        <div class="card ecommerce-widget">
                          <div class="card-body support-ticket-font">
                            <div class="row">
                              <div class="col-5"><span>Pending</span>
                                <h3 class="total-num counter">8943</h3>
                              </div>
                              <div class="col-7">
                                <div class="text-end">
                                  <ul>
                                    <li>Profit<span class="product-stts text-success ms-2">8989<i class="icon-angle-up f-12 ms-1"></i></span></li>
                                    <li>Loss<span class="product-stts text-danger ms-2">2560<i class="icon-angle-down f-12 ms-1"></i></span></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-sm-6 box-col-6">
                        <div class="card ecommerce-widget">
                          <div class="card-body support-ticket-font">
                            <div class="row">
                              <div class="col-5"><span>Running</span>
                                <h3 class="total-num counter">2500</h3>
                              </div>
                              <div class="col-7">
                                <div class="text-end">
                                  <ul>
                                    <li>Profit<span class="product-stts text-success ms-2">8989<i class="icon-angle-up f-12 ms-1"></i></span></li>
                                    <li>Loss<span class="product-stts text-danger ms-2">2560<i class="icon-angle-down f-12 ms-1"></i></span></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="display" id="basic-6">
                        <thead>
                          <tr>
                            <th rowspan="2">Name</th>
                            <th colspan="2">HR Information</th>
                            <th colspan="4">Contact</th>
                          </tr>
                          <tr>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Office</th>
                            <th>Skill</th>
                            <th>Extn.</th>
                            <th>E-mail</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/1.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Tiger Nixon</div>
                                </div>
                              </div>
                            </td>
                            <td>System Architect</td>
                            <td>$320,800</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>5421</td>
                            <td>t.nixon@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/2.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Garrett Winters</div>
                                </div>
                              </div>
                            </td>
                            <td>Accountant</td>
                            <td>$170,750</td>
                            <td>Tokyo</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-secondary" role="progressbar" style="width: 40%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>8422</td>
                            <td>g.winters@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/3.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Ashton Cox</div>
                                </div>
                              </div>
                            </td>
                            <td>Junior Technical Author</td>
                            <td>$86,000</td>
                            <td>San Francisco</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>1562</td>
                            <td>a.cox@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/4.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Cedric Kelly</div>
                                </div>
                              </div>
                            </td>
                            <td>Senior Javascript Developer</td>
                            <td>$433,060</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-secondary" role="progressbar" style="width: 80%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>6224</td>
                            <td>c.kelly@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/5.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Airi Satou</div>
                                </div>
                              </div>
                            </td>
                            <td>Accountant</td>
                            <td>$162,700</td>
                            <td>Tokyo</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>5407</td>
                            <td>a.satou@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/6.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Brielle Williamson</div>
                                </div>
                              </div>
                            </td>
                            <td>Integration Specialist</td>
                            <td>$372,000</td>
                            <td>New York</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-info" role="progressbar" style="width: 55%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>4804</td>
                            <td>b.williamson@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/7.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Herrod Chandler</div>
                                </div>
                              </div>
                            </td>
                            <td>Sales Assistant</td>
                            <td>$137,500</td>
                            <td>San Francisco</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>9608</td>
                            <td>h.chandler@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/8.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Rhona Davidson</div>
                                </div>
                              </div>
                            </td>
                            <td>Integration Specialist</td>
                            <td>$327,900</td>
                            <td>Tokyo</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-secondary" role="progressbar" style="width: 90%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>6200</td>
                            <td>r.davidson@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/9.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Colleen Hurst</div>
                                </div>
                              </div>
                            </td>
                            <td>Javascript Developer</td>
                            <td>$205,500</td>
                            <td>San Francisco</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>2360</td>
                            <td>c.hurst@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/10.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Sonya Frost</div>
                                </div>
                              </div>
                            </td>
                            <td>Software Engineer</td>
                            <td>$103,600</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 58%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>1667</td>
                            <td>s.frost@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/11.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Jena Gaines</div>
                                </div>
                              </div>
                            </td>
                            <td>Office Manager</td>
                            <td>$90,560</td>
                            <td>London</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>3814</td>
                            <td>j.gaines@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/12.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Quinn Flynn</div>
                                </div>
                              </div>
                            </td>
                            <td>Support Lead</td>
                            <td>$342,000</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>9497</td>
                            <td>q.flynn@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/1.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Charde Marshall</div>
                                </div>
                              </div>
                            </td>
                            <td>Regional Director</td>
                            <td>$470,600</td>
                            <td>San Francisco</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>6741</td>
                            <td>c.marshall@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/2.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Haley Kennedy</div>
                                </div>
                              </div>
                            </td>
                            <td>Senior Marketing Designer</td>
                            <td>$313,500</td>
                            <td>London</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>3597</td>
                            <td>h.kennedy@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/3.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Tatyana Fitzpatrick</div>
                                </div>
                              </div>
                            </td>
                            <td>Regional Director</td>
                            <td>$385,750</td>
                            <td>London</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>1965</td>
                            <td>t.fitzpatrick@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/4.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Michael Silva</div>
                                </div>
                              </div>
                            </td>
                            <td>Marketing Designer</td>
                            <td>$198,500</td>
                            <td>London</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>1581</td>
                            <td>m.silva@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/5.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Paul Byrd</div>
                                </div>
                              </div>
                            </td>
                            <td>Chief Financial Officer (CFO)</td>
                            <td>$725,000</td>
                            <td>New York</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>3059</td>
                            <td>p.byrd@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/6.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Gloria Little</div>
                                </div>
                              </div>
                            </td>
                            <td>Systems Administrator</td>
                            <td>$237,500</td>
                            <td>New York</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 15%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>1721</td>
                            <td>g.little@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/7.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Bradley Greer</div>
                                </div>
                              </div>
                            </td>
                            <td>Software Engineer</td>
                            <td>$132,000</td>
                            <td>London</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>2558</td>
                            <td>b.greer@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/8.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Dai Rios</div>
                                </div>
                              </div>
                            </td>
                            <td>Personnel Lead</td>
                            <td>$217,500</td>
                            <td>Edinburgh</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>2290</td>
                            <td>d.rios@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/9.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Jenette Caldwell</div>
                                </div>
                              </div>
                            </td>
                            <td>Development Lead</td>
                            <td>$345,000</td>
                            <td>New York</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>1937</td>
                            <td>j.caldwell@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/10.jpg" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Yuri Berry</div>
                                </div>
                              </div>
                            </td>
                            <td>Chief Marketing Officer (CMO)</td>
                            <td>$675,000</td>
                            <td>New York</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>6154</td>
                            <td>y.berry@datatables.net</td>
                          </tr>
                          <tr>
                            <td>
                              <div class="d-flex"><img class="rounded-circle img-30 me-3" src="assets/images/user/11.png" alt="Generic placeholder image"/>
                                <div class="flex-grow-1 align-self-center">
                                  <div>Caesar Vance</div>
                                </div>
                              </div>
                            </td>
                            <td>Pre-Sales Support</td>
                            <td>$106,450</td>
                            <td>New York</td>
                            <td>
                              <div class="progress-showcase">
                                <div class="progress sm-progress-bar">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </td>
                            <td>8330</td>
                            <td>c.vance@datatables.net</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Office</th>
                            <th>Skill</th>
                            <th>Extn.</th>
                            <th>E-mail</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <footer class="footer"> 
          <div class="container-fluid">
            <div class="row"> 
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2024 © Admiro theme by pixelstrap.</p>
              </div>
              <div class="col-md-6">
                <p class="float-end mb-0">Hand crafted &amp; made with
                  <svg class="svg-color footer-icon">
                    <use href="assets/svg/iconly-sprite.svg#heart"></use>
                  </svg>
                </p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- jquery-->
    <script src="assets/js/vendors/jquery/jquery.min.js"></script>
    <!-- bootstrap js-->
    <script src="assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" defer=""></script>
    <script src="assets/js/vendors/bootstrap/dist/js/popper.min.js" defer=""></script>
    <!--fontawesome-->
    <script src="assets/js/vendors/font-awesome/fontawesome-min.js"></script>
    <!-- feather-->
    <script src="assets/js/vendors/feather-icon/feather.min.js"></script>
    <script src="assets/js/vendors/feather-icon/custom-script.js"></script>
    <!-- sidebar -->
    <script src="assets/js/sidebar.js"></script>
    <!-- scrollbar-->
    <script src="assets/js/scrollbar/simplebar.js"></script>
    <script src="assets/js/scrollbar/custom.js"></script>
    <!-- slick-->
    <script src="assets/js/slick/slick.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <!-- datatable-->
    <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <!-- counter-->
    <script src="assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="assets/js/counter/jquery.counterup.min.js"></script>
    <script src="assets/js/counter/counter-custom.js"></script>
    <!-- theme_customizer-->
    <script src="assets/js/theme-customizer/customizer.js"></script>
    <!-- support_ticket_custom-->
    <script src="assets/js/support-ticket-custom.js"></script>
    <!-- custom script -->
    <script src="assets/js/script.js"></script>
  </body>
</html>