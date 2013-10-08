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
						</ul>
						<div class="tab-content">
							<div id="pane1" class="tab-pane active">

								<div id="user-content-offers">
									<form>
										<div class="input-group input-group-lg">
											<input type="text" class="form-control input-lg" placeholder="Search Offers">
											<span class="input-group-btn">
												<button class="btn btn-default" type="button"><i class="icon-search"></i></button>
											</span>
										</div>
										<div class="cl-20"></div>
										<div class="search-btns">				
										<label class="fnt-13">
											Browse by Category
											<br>
											<select class="selectpicker" data-live-search="true">
												<option>Test 1</option>
												<option>Test 2</option>
											</select>
										</label>
										<label class="fnt-13 pdd-left-20">
											Browse by Country
											<br>
											<select class="selectpicker" data-live-search="true">
												<option>Potato</option>													
											</select>																				
										</label>

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
													<th>Name</th>
													<th>Preview</th>
													<th>Payout</th>
													<th>Play Now Link</th>
												</tr>
											</thead>
											<tbody>
												<tr>
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
												<tr>
													<td>Warframe</td>
													<td>warframe.com</td>
													<td>$0.60</td>
													<td>
														<?php if (true) {?>
														<a data-toggle="modal" href="#myModal1" class="btn btn-default">Get Link</a>
														<?php } else {?>
														<a href="#"></a>
														<?php } ?>
													</td>
												</tr>
											</tbody>	

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
										
										</table>
									</div>
								</div>				    	
							</div>

							<div id="pane2" class="tab-pane">
								<h3>Hi</h3>
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

<div id="plnw-pop">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">

		<div class="modal-content">
		<?php if(false): ?>	
			<div class="preloader"></div>
		<?php else: ?>	
			<div id="game-det">
		
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div id="game-det-title">
								<h3 class="modal-title">Warframe</h3>								
							</div>
							<div id="game-det-banner">
								<img src="images/game-thmbs/default-game-img.jpg">
							</div>							
							<div class="pdd-20">
								<div id="game-det-prev">
									<div class="row">
										<div class="col-lg-6"><a href="#">Preview Game</a></div>
										<div class="col-lg-6"><a href="#">Advertiser</a></div>
									</div>
								</div>
								<div class="cl-20"></div>							
								<div id="game-det-desc">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat.
								</div>
								<div class="cl-20"></div>
								<div id="game-det-lnk">
									<input id="ref-lnk1" type="text" class="form-control input-lg" value="play.tm/fjr38" disabled>								
									<a id="cpy-ref-btn1" class="btn btn-default btn-lg" onmouseover="hoverCopy()">Copy Play Now Link</a>
								</div>
							</div>
						</div>					
					</div>
				</div>
			</div>
		
		<?php endif ?>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>


<?php include 'footer-dbpro.php' ?>