<!DOCTYPE HTML>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

  <title>Dashboard.tm | Part of any.tv family.</title>

  <!--[if IE 7]>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
  <![endif]-->

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

  <link href="css/layout.css" rel="stylesheet">    
  <link href="css/normalize.css" rel="stylesheet"> 
  <link href="css/subnav.css" rel="stylesheet">
  <link href="css/dashboard-menu.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png"/>
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png"/>
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png"/>
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png"/>
  <link rel="shortcut icon" href="assets/ico/favicon.png"/>

  <!-- Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'> 

  <!-- Bootstrap -->
  <link href="css/bootstrap/bootstrap.css" rel="stylesheet"> 

  <!-- -->



</head>

<body class="dashbrd-bg">
<!-- page wrap -->
<div class="page-wrap">
<!-- header -->
<header id="top-navigation">
  <div id="main-nav">    
      <nav class="navbar navbar-default" role="navigation">
      <div class="container">
          <div class="navbar-header nb-main">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                
              </button>
              <a class="navbar-brand" href="dashboard.php"><img src="images/anytv-dashboard-logo.png"></a><p id="nvbr-txt" class="navbar-text">Part of &nbsp;<img src="images/any-tv-family-logo.png"> &nbsp;family.</p>
          </div>


          <div style="padding-top: 5px;" class="collapse navbar-collapse navbar-ex1-collapse atv-sites">        

            <ul class="nav navbar-nav navbar-left">
            <li><a class="lnk-blue" href="index.php">any.TV</a></li>
            <li><a class="lnk-yellow" href="dashboard.php">dashboard</a></li>
            <li><a class="lnk-red" href="#">mmo</a></li> </ul>
            <ul class="nav navbar-nav navbar-right">
            <li>
            <?php
             $x = 0;
            if ($x == 0) {
              echo "<p class='navbar-text pull-right '>Signed in as <a href='#' class='navbar-link'>Mark Otto</a></p>";
            }
            else {
              echo "<a href='dashboard.php' class='log-btn mrgn-left'>LOG IN</a>";
            }            
            ?>
            </li>            
              <li class="dropdown mrgn-left">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/flags/us.png">&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu dd-height">
                  <li><a href="#"><img src="images/flags/us.png">English (US)</a></li>
                  <li><a href="#"><img src="images/flags/cn.png">Chinese</a></li>
                  <li><a href="#"><img src="images/flags/nl.png">Dutch</a></li>
                </ul>
              </li>              
            </ul>
          </div>  
      </div>
      <!-- /container -->        
      </nav> 
      <!-- /nav -->
  </div>
  <!-- /main-nav -->

  <div id="sub-nav" class="dashbrd">
    <div class="container">
      <nav class="subnav-cllps db-lnks">
          <ul id="nav">
            <li><a href="#">Link 1</a></li>
            <li><a href="#">Link 2</a></li>
            <li><a href="#">Link 3</a></li>
            <li><a href="#">Link 4</a></li>
            <li><a href="#">Link 5</a></li>
          </ul>
      </nav>
    </div>
  </div>
</header>
<!-- /header -->