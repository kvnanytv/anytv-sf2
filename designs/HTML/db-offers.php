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
								<img src="images/db-img/default-photo.png">
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
									<li><a href="db-profile.php">My Profile</a></li>
									<li class="active"><a href="#">Offers</a></li>
									<li><a href="#">Reports</a></li>						  
								</ul>
							</div>
						</div>
					</div>
					<div class="cl-20"></div>
				</div>

				<div class="col-lg-9">
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#pane1" data-toggle="tab">My Offers</a></li>
							<li><a href="#pane2" data-toggle="tab">Browse Offers</a></li>
							<li><a href="#pane3" data-toggle="tab">Tab 3</a></li>
							<li><a href="#pane4" data-toggle="tab">Tab 4</a></li>
						</ul>
						<div class="tab-content">
							<div id="pane1" class="tab-pane active">

								<div id="user-content-offers">
									<form>
										<div class="input-group input-group-lg">
											<input type="text" class="form-control input-lg" placeholder="Search Offers">
											<span class="input-group-btn">
												<button class="btn btn-default" type="button">Go!</button>
											</span>
										</div>
										<div class="cl-20"></div>
										<div class="search-btns">				

												<select class="selectpicker" multiple title="Browse by Category" data-live-search="true" data-width="25%">
													<option>Potato</option>
												</select>												
												<select class="selectpicker" multiple title="Browse by Country" data-live-search="true" data-width="25%">
													<option>Potato</option>
												</select>													

										<div class="rfrsh-wrap">
											<a href="" class="btn btn-default btn-lg"><i class="icon-refresh"></i></a>
										</div>												
												
										</div>

									</form>
								</div>
								<div class="cl-20"></div>
								<div class="progress progress-striped active">
									<div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 50%">							    
									</div> 
								</div>							
								<div class="table-responsive">
									<div class="offer-tbl-wrap">
										<table class="table table-striped">							
											<thead>
												<tr>
													<th>Photo</th>
													<th>Name</th>
													<th>Preview</th>
													<th>Payout</th>
													<th>Play Now Link</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>											
														<?php if (true) {?>
														<img src="images/db-img/photo-thmb.jpg">
														<?php } else {?>
														<img src="">
														<?php } ?>
													</td>
													<td>Warframe</td>
													<td>warframe.com</td>
													<td>$0.60</td>
													<td>
														<?php if (true) {?>
														<a data-toggle="modal" href="#myModal" class="btn btn-default">Get Link</a>
														<?php } else {?>
														<a href="#"></a>
														<?php } ?>
													</td>
												</tr>

												<tfoot>
													<tr>
														<td class="al-cntr" colspan="6">
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
							<div id="pane2" class="tab-pane">
								<h4>Pane 2 Content</h4>
							</div>
							<div id="pane3" class="tab-pane">
								<h4>Pane 3 Content</h4>
							</div>
							<div id="pane4" class="tab-pane">
								<h4>Pane 4 Content</h4>
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