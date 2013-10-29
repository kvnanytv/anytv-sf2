<!DOCTYPE HTML>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../../assets/ico/favicon.png">

  <title>AnyTV | A new kind of YouTube Channel</title>

<!--[if IE 7]>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
      <![endif]-->

      <!-- Favicon -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png"/>
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png"/>
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png"/>
      <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png"/>
      <link rel="shortcut icon" href="assets/ico/favicon.png"/>

      <!-- Fonts -->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,700,800,600' rel='stylesheet' type='text/css'>    

      <style type="text/css">
       @import url('css/layout.css');     
       @import url('css/normalize.css');
       @import url('css/subnav.css');                     
       @import url('css/bootstrap/bootstrap.css'); 
       @import url('css/bootstrap/bootstrap-select.css');
       @import url('font-awesome/css/font-awesome.min.css');
     </style>
   </head>

   <body>


    <div class="page-wrap">
      <header>
    
      <div class="alert alert-dismissable alert-info any-notif">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><i class="icon-exclamation-sign"></i> New on any.TV?</strong> Sign up now to get free tees!
      </div>

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

  <div id="content">
    <section class="banner">
      <div class="container">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="cta-home">
              <div class="col-lg-5">
                <h3>A new kind of YouTube Network</h3>
                <p>No need to unpartner from your YouTube Network</p>
                <div class="cta-btns">
                  <a class="btn btn-primary btn-lg btn-join">Join Us!</a>
                </div>
              </div>
              <div class="col-lg-7">      
                <div class="video-container">
                         <iframe src="http://www.youtube.com/embed/UCqJAZuvUS0&wmode=opaque" frameborder="0" width="560" height="315"></iframe>
                </div>              
              </div>
            </div>
          </div>
        </div>          
      </div>       
    </section>
    <section id="games-lists">
      <div class="container">
        <div class="games-list-wrap">
          <h3>any.TV <span>Games List</span></h3>
          <div class="row">
            <div class="col-lg-12">
              <div class="input-group input-group-lg">
                <input id="in-pl" type="search" class="form-control input-lg" role="search" placeholder="Search Games...">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="icon-search icon-large"></i></button>
                </span>
              </div>                   
            </div>
            <div class="cl-20"></div>
            <div class="col-lg-12">

              <div id="gl-tbl" class="table-responsive mrgn-top">
                <!-- Table -->
                <table class="table">             
                  <thead>
                    <tr>
                      <th>Games</th>
                      <th>Payout</th>
                      <th>Countries</th>
                      <th>Play Now Links</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Age of Conan</td>
                      <td>$0.60</td>
                      <td>Canada, United Kingdom, United States</td>
                      <td>
                        <?php if (true) {?>
                        <a href="#" class="btn btn-default btn-glink"> Get Link</a>
                        <?php } else {?>
                        <a href="#"></a>
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Age of Wulin</td>
                      <td>$0.60</td>
                      <td>United Kingdom, Ireland</td>
                      <td>
                        <?php if (true) {?>
                        <a href="#" class="btn btn-default"> Get Link</a>
                        <?php } else {?>
                        <a href="#"></a>
                        <?php } ?>                      
                      </td>
                    </tr>
                    <tr>
                      <td>Age of Wushu</td>
                      <td>$1.50</td>
                      <td>Canada</td>
                      <td>
                        <?php if (true) {?>
                        <a href="#" class="btn btn-default"> Get Link</a>
                        <?php } else {?>
                        <a href="#"></a>
                        <?php } ?>                      
                      </td>
                    </tr>
                    <tr>
                      <td>Age of Wushu</td>
                      <td>$1.50</td>
                      <td>Canada</td>
                      <td>
                        <?php if (true) {?>
                        <a href="#" class="btn btn-default"> Get Link</a>
                        <?php } else {?>
                        <a href="#"></a>
                        <?php } ?>                      
                      </td>
                    </tr>
                    <tfoot>
                      <tr>
                        <td class="al-cntr" colspan="4">
                          <ul class="pagination">
                            <li class="disabled"><a href="#">&laquo;</a></li>
                            <li class="active"><span>1 <span class="sr-only">(current)</span></span></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href="">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                          </ul>                     
                        </td>
                      </tr>
                    </tfoot>                  
                  </tbody>
                </table>
              </div>               
            </div>                   
          </div>
        </div>          
      </div>
    </section>


    <section id="networks">
      <div class="container"> 
        <div class="row-fluid"> 
          <div class="col-lg-12">
            <div class="net-title">
              <!-- <h3>News</h3> -->
            </div>
          </div>
          <div class="col-lg-4">
            <div id="net-col">          
              <h4>George is Back!</h4>
              <p>As promised.</p>
              <p>I am the ex-President and founder of TGN, my old company that I sold to BroadbandTV in 2012. It was time for something new.</p>
              <p>Will you help me build any.TV together?</p>
              <a href="#" style="bottom: 0;" class="btn btn-default">Help George</a>
            </div>          
          </div>
          <div class="col-lg-4">
            <div id="net-col">
              <h4>News and Updates</h4>
              <div class="news-updates fnt-13">

                <p><strong>Lorem ipsum dolor sit amet</strong>
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                <p><strong>Lorem ipsum dolor sit amet</strong>
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                <p><strong>Lorem ipsum dolor sit amet</strong>
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                <p><strong>Lorem ipsum dolor sit amet</strong>
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                <p><strong>Lorem ipsum dolor sit amet</strong>
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>                                                  
              </div>
            </div>  
            </div>
            <div class="col-lg-4">
              <div id="net-col">  
                <h4>10% Lifetime Bonus</h4>
                <p>Yes, we mean forever.</p>
                <p>any.TV pays you a 10% bonus of everything your referrals make, our way of saying “Thank You” for recommending any.TV to your friends and partners!</p><p>This is not a pyramid scheme.</p>
                <a href="#" class="btn btn-default">Learn more</a>
              </div>  
            </div>
          </div>
        </div>
      </section>

      <section id="about-anytv">
        <div class="container">
          <div class="row">
            <div class="aa-title">
              <h3>Happy Affiliates!</h3>
            </div>
            <div class="cl-20"></div>
            <div class="col-lg-4">
              <blockquote>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
              </blockquote>             
            </div>
            <div class="col-lg-4">
              <blockquote>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
              </blockquote>                             
            </div>
            <div class="col-lg-4">
              <blockquote>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
              </blockquote>             
            </div>
          </div>
        </div>
      </section>  

      <section id="our-partners">
        <div class="container">
          <div class="op-title">
            <h3>Our Partners</h3>
          </div>
        </div>
      </section>      


    </div>

    <!-- /content -->


    <?php include 'footer.php'; ?>