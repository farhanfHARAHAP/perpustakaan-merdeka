<?php 

session_start(); 
if(!isset($_GET['id'])){
    header('Location: ./show-member-categories.php');
}

?>

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
            <div class="container-fluid">
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Mengedit Kategori Member</h3>
                            <p class="text-muted m-b-30 font-13"> Isi form dengan baik dan benar! </p>
                            <p class="text-right">
                                <a href="<?=$host?>/member_category.php?action=deleteMemberCategory&id=<?=$_GET['id']?>&mode=PHP" class="btn btn-danger">Hapus Data</a>
                            </p>
                            <?php // Get Target Data to be Edited
                                include './request-links.php';
                                $url = $host.'/member_category.php?action=selectMemberCategoryByID&id='.$_GET['id'].'&mode=JSON';
                                $result = fetchJsonFromApi($url);
                                if($result['response']!= 200){ // If no data
                                    header('Location: ./show-member-categories.php');
                                }
                                $data = $result['data'][0];
                            ?>
                            <form class="form-horizontal" action="<?=$host?>/member_category.php" method="POST">                                                                                                                        
                                <div class="form-group">    
                                    <label>Nama Kategori Member</label>                                  
                                    <input type="text" class="form-control" name="name" value="<?=$data['name']?>" required>
                                </div>                                                                                            
                                <div class="container-flex">
                                    <p class="text-center">
                                        <input type="hidden" name="id" value="<?=$data['id']?>">
                                        <input type="hidden" name="mode" value="PHP">
                                        <input type="hidden" name="action" value="updateMemberCategory">
                                        <button class="btn btn-primary">Edit</button>
                                    </p>                                    
                                </div>                                                                                           
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->                                
            </div>
            <!-- /.container-fluid -->
            <footer class="footer t-a-c">
                © 2017 Cubic Admin
            </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="js/sidebarmenu.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.js"></script>
    <script src="js/jasny-bootstrap.js"></script>
    <!--Style Switcher -->
    <script src="../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
