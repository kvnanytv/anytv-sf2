<?php include 'header-dashboard.php'; ?>

<!-- content -->
<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div id="user-db">
					<div class="panel panel-default user-panel">
					<div class="panel-heading"></div>
					<div class="user-pic">								
							<img src='images/db-img/test-user.jpg'>
							<p>
								<?php
									$userpic = 1;

									if($userpic == 0) {
										echo "<a class='pic-up-btn' href=''>Upload</a>";
									}

									else {
										echo "<a href='#'>Change</a>";
									}
								?>
								</p>
						</div>				
						<div class="panel-body">							
							<div class="user-det">
								<h3>Hi <span>Jane Doe</span>!</h3>
								<p>Referral link: www.any.tv/sdf51h</p>
							</div>
						</div>
					<div id="user-menus">
						<ul class="nav nav-pills nav-stacked">
						  <li class="active">
						    <a href="#">
						      <span class="badge pull-right">42</span>
						      Dashboard
						    </a>
						  </li>
						  <li><a href="#">My Profile</a></li>
						  <li><a href="#">Offers</a></li>
						  <li><a href="#">Reports</a></li>						  
						</ul>
					</div>
					</div>

					<div class="col-md-8">
					<div>
						
					</div>
					</div>  
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /content -->

<?php include 'footer.php' ?>