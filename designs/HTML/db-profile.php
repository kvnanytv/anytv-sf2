<!DOCTYPE HTML>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../assets/ico/favicon.png">

	<title>Dashboard.tm | Part of any.tv family.</title>

	<?php include 'header-dashboard.php'; ?>

	<!-- content -->
	<section id="content">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div id="user-db">
						<div class="panel panel-default user-panel">
							<div class="panel-heading"></div>
							<div class="user-pic">								
								<img src="images/db-img/profile-default-sm.png">
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
								<h3>Hi <span>Jane Doe</span>!</h3>							
								<div class="user-det">

									<p>Referral link:</p>

									<input id="ref-lnk" type="text" class="form-control" value="http://www.any.tv/dashboard/signup/79745/zh" disabled>								
									<a id="cpy-ref-btn" class="btn btn-default">Copy Link</a>


								</div>
							</div>
							<div id="user-menus">
								<ul class="nav nav-pills nav-stacked">
									<li>
										<a href="#">
											<span class="badge pull-right">42</span>
											Dashboard
										</a>
									</li>
									<li class="active"><a href="#">My Profile</a></li>
									<li><a href="db-offers.php">Offers</a></li>
									<li><a href="#">Reports</a> </li>						  
								</ul>
							</div>
						</div>
					</div>
					<div class="cl-20"></div>
				</div>

				<div class="col-lg-9">
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#pane1" data-toggle="tab">Company Details</a>
							</li>
							<li><a href="#pane2" data-toggle="tab">User Details</a></li>
							<li><a href="#pane3" data-toggle="tab">Password</a></li>							
						</ul>
						<div class="tab-content">
							<!-- USER DETAILS -->
							<div id="pane1" class="tab-pane active">
								<div class="row">
									<div class="col-lg-8">
										<div class="f-lft v-mid">
											<h3>Company Details</h3>
										</div>
										<div class="f-rght mtop-10">
											<a class="btn btn-default">Edit</a>	
										</div>	
										
										<div class="cl-20"></div>
										<hr>

										<div id="form-row-style">
											<div class="form_row">
												<label for="company_company" class="required">Company</label>
												<input class="form-control input-lg" type="text" id="company_company" name="company[company]" required="required" maxlength="255" value="AnyTV Philippines" />
											</div>

											<div class="form_row">
												<label for="company_address1">Address1</label>
												<input class="form-control input-lg" type="text" id="company_address1" name="company[address1]" maxlength="255" value="1902 Belmira, Cypress Towers" />
											</div>

											<div class="form_row"><label for="company_address2">Address2</label>
												<input class="form-control input-lg" type="text" id="company_address2" name="company[address2]" maxlength="255" />
											</div>

											<div class="form_row"><label for="company_city">City</label>
												<input class="form-control input-lg" type="text" id="company_city" name="company[city]" maxlength="255" value="Taguig City" />
											</div>

											<div class="form_row"><label for="company_region">Region</label>
												<input class="form-control input-lg" type="text" id="company_region" name="company[region]" maxlength="255" value="NCR" />
											</div>

											<div class="form_row"><label for="company_country">Country</label>
												<select class="selectpicker" data-width="100%" id="company_country" name="company[country]">
													<option value=""></option>
													<option value="1">Afghanistan</option>
													<option value="2">Aland Islands</option></select>
												</div>

												<img src="/app_dev.php/media/cache/profile_thumbnail/uploads/affiliates/thumbnails/beaca476948deea6fb0239ffb791e809675d2a44.jpeg" alt="AnyTV Philippines" />     
												<div class="form_row"><label for="company_file">File</label>
													<input class="form-control input-lg" type="file" id="company_file" name="company[file]" />
												</div>

												<div class="form_row">
													<label for="company_phone">Phone</label>
													<input class="form-control input-lg" type="text" id="company_phone" name="company[phone]" maxlength="255" value="639178014866" />
												</div>

												<div class="form_row">
													<label for="company_fax">Fax</label>
													<input class="form-control input-lg" type="text" id="company_fax" name="company[fax]" maxlength="255" value="027253202" />
												</div>

  <div><button class="btn btn-default btn-lg" type="submit" id="company_save" name="company[save]">Save</button></div>
</div>

</div>
<div class="col-lg-4">
	<div id="user-prof-img">
		<img src="images/db-img/profile-default-lg.svg">
		<div class="cl-20"></div>
		<a href="#">Change Photo</a>
	</div>
</div>
</div>
<hr>
<!-- <button class="btn btn-default btn-lg">Save Changes</button> -->
</div>

<!-- COMPANY DETAILS -->
<div id="pane2" class="tab-pane">
	<div class="row">
		<div class="col-lg-8">
			<h3>User Details</h3>
			<hr>

			<div id="comp-prof-name">
				<label>
					Name 
					<div class="input-group input-group-lg">										    
						<input type="text" class="form-control" value="Jane Doe" disabled>
						<span class="input-group-btn">
							<?php if(true): ?>
								<button type="button" class=" btn btn-default">Edit</button>
							<?php else: ?>
								<button type="submit" class="btn btn-default">Save</button>										      
							<?php endif ?>
						</span>
					</div>
				</label>
			</div>
			<div class="cl-20"></div>
			<div id="comp-prof-email">
				<label>
					Email 
					<div class="input-group input-group-lg">										    
						<input type="email" class="form-control" value="janedoe@gmail.com" disabled>
						<span class="input-group-btn">
							<?php if(true): ?>
								<button type="button" class=" btn btn-default">Edit</button>
							<?php else: ?>
								<button type="submit" class="btn btn-default">Save</button>										      
							<?php endif ?>
						</span>
					</div>
				</label>
			</div>
			<div class="cl-20"></div> 										    									    							
			<div id="comp-prof-email">
				<label>
					Phone 
					<div class="input-group input-group-lg">										    
						<input type="text" class="form-control" value="(02)999-9999" disabled>
						<span class="input-group-btn">
							<?php if(true): ?>
								<button type="button" class=" btn btn-default">Edit</button>
							<?php else: ?>
								<button type="submit" class="btn btn-default">Save</button>										      
							<?php endif ?>
						</span>
					</div>
				</label>
			</div> 										
		</div>
		<div class="col-lg-4">
		</div>
	</div>
</div>

<!-- PASSWORD -->
<div id="pane3" class="tab-pane">
	<div class="row">
		<div class="col-lg-8">
			<h3>Change Password</h3>
			<hr>
			<form>
				<div id="pass-old">
					<label>Old Password</label>
					<input type="password" class="form-control input-lg">											
				</div>
				<div class="cl-20"></div>

				<div id="pass-new">
					<label>New Password</label>
					<input type="password" class="form-control input-lg">											
				</div>
				<div class="cl-20"></div> 										    									    							
				<div id="pass-new-confrm">
					<label>Confirm New Password</label>
					<input type="password" class="form-control input-lg">
				</div>
				<div class="cl-20"></div> 										    									    																	 
				<button type="submit" class="btn btn-default btn-lg">Save Changes</button>
			</form>										
		</div>
		<div class="col-lg-4">
		</div>
	</div>								
</div>

</div><!-- /.tab-content -->
</div><!-- /.tabbable -->				

</div> 
</div>
</div>
</div>
</section>
<!-- /content -->

<!-- Pop-up -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Game Details</h4>
			</div>
			<div class="modal-body">
				Expires in
				<div id="share-div">
					<p><strong>Share</strong></p>
					<span class='st_googleplus_large' displayText='Google +'></span>
					<span class='st_facebook_large' displayText='Facebook'></span>
					<span class='st_twitter_large' displayText='Tweet'></span>
					<span class='st_linkedin_large' displayText='LinkedIn'></span>
					<span class='st_email_large' displayText='Email'></span>
					<span class='st_sharethis_large' displayText='ShareThis'></span>          
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php include 'footer-dbpro.php' ?>