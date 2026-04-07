<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Cubic Admin Template</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <!-- ===== Animation CSS ===== -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="css/style.css" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="mini-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <?php // Frontend Function
        // Get Host URL
        include 'request-links.php';
        // JSON->Array() Script
        function fetchJsonFromApi($url) {
            // Create a cURL resource
            $ch = curl_init($url);
        
            // Set cURL options for a successful request
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // Disable SSL verification (optional, adjust based on API requirements)
        
            // Execute the cURL request and handle errors
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
            echo "Error fetching data: " . curl_error($ch);
            return null;
            }
        
            curl_close($ch);  // Close the cURL resource
        
            // Decode the JSON response
            $data = json_decode($response, true);  // Decode to an associative array
        
            return $data;
        }
    ?>
    <div id="wrapper">
        <!-- ===== Top-Navigation ===== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="top-left-part">
                    <a class="logo" href="index.html">
                        <b>
                            <img src="../plugins/images/logo.png" alt="home" />
                        </b>
                        <span>
                            <img src="../plugins/images/logo-text.png" alt="homepage" class="dark-logo" />
                        </span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
                    </li>                    
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">                                        
                    <li class="right-side-toggle">
                        <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" href="javascript:void(0)">
                            <i class="icon-settings"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- ===== Top-Navigation-End ===== -->
        <!-- ===== Left-Sidebar ===== -->
        <?php include 'left-nav.php';?>
        <!-- Page Content -->
        <div class="page-wrapper">
        <?php include 'alert.php'; ?>       
        <?php
        // Get Stat
        $apiUrl = $host."/stats.php?action=giveStat&mode=JSON";
        $get_stats = fetchJsonFromApi($apiUrl);        
        ?>
            <div class="container-fluid">   
                <div class="container" style="height: 100px; width: 100%;"></div>                             
                <h1 class="ms-3">Rangkuman <i class="icon-info"></i></h1>
                <hr>
                <div class="row colorbox-group-widget">                                        
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count"><?= $get_stats['data']['books'] ?> <span class="pull-right"><i class="icon-book-open"></i></span></h3>
                                    <p class="info-text font-12">Buku</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count"><?= $get_stats['data']['members'] ?> <span class="pull-right"><i class="icon-people"></i></span></h3>
                                    <p class="info-text font-12">Member</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>     
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count"><?= $get_stats['data']['book_categories'] ?> <span class="pull-right"><i class="icon-folder"></i></span></h3>
                                    <p class="info-text font-12">Kategori Buku</p>                                    
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count"><?= $get_stats['data']['member_categories'] ?> <span class="pull-right"><i class="icon-folder"></i></span></h3>
                                    <p class="info-text font-12">Kategori Member</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>              
            </div>
            <!-- /.container-fluid -->
            <footer class="footer t-a-c"> © 2017 Cubic Admin
            </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- ==============================
        Required JS Files
    =============================== -->
    <!-- ===== jQuery ===== -->
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
    <!-- ===== Bootstrap JavaScript ===== -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ===== Slimscroll JavaScript ===== -->
    <script src="js/jquery.slimscroll.js"></script>
    <!-- ===== Wave Effects JavaScript ===== -->
    <script src="js/waves.js"></script>
    <!-- ===== Menu Plugin JavaScript ===== -->
    <script src="js/sidebarmenu.js"></script>
    <!-- ===== Custom JavaScript ===== -->
    <script src="js/custom.js"></script>
    <!-- ===== Plugin JS ===== -->
    <!-- ===== Style Switcher JS ===== -->
    <script src="../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
