<?php include 'header-dashboard.php'; ?>

<!-- content -->
<section id="content">
	<div class="container">
		<div class="row-fluid">
			<div class="col-lg-4">
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
					</div>

					<div class="col-lg-8">

					</div>  
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /content -->

<?php include 'footer.php' ?>