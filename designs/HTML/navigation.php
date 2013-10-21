</head>

<body>

<div class="page-wrap">

<header>
        <div id="main-nav">    
          <nav class="navbar navbar-default" role="navigation">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>                
                </button>
                <a class="navbar-brand" href="index.php"><img src="images/anytv-home-logo.png"></a>
                <p class="navbar-text">Believe in you.</p>              
              </div>

              <div style="padding-top: 5px;" class="collapse navbar-collapse navbar-ex1-collapse atv-sites">


                <ul class="nav navbar-nav navbar-left">
                  <li><a class="lnk-blue" href="index.php">any.TV</a></li>
                  <li><a class="lnk-yellow" href="dashboard.php">dashboard</a></li>
                  <li><a class="lnk-red" href="#">mmo</a></li> </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li>
                      <?php
                      $x = 1;
                      if ($x == 0) {
                        echo "<p class='navbar-text pull-right'>Signed in as <a href='#' class='navbar-link'>Mark Otto</a></p>";
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

          <div id="sub-nav">
            <div class="container">              
              <nav class="subnav-cllps clr-black">
                <ul id="nav">
                  <li><a href="page-what.php">What is any.TV?</a></li>
                  <li><a href="#">Branding Kit</a></li>
                  <li><a href="http://www.games.tm">Games List</a></li>
                  <li><a href="#">Livestream Handbook</a></li>
                  <li><a href="#">Recruiters Handbook</a></li>
                  <li><a href="#">Join our Twitch Team!</a></li>
                  <li><a href="#">Staff</a></li>        
                  <li><a href="page-faq.php">FAQs</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </header>
<!-- /header -->
