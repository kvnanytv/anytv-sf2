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
						<h3>Hi <span>Jane Doe</span>!</h3>							
							<div class="user-det">
								
								<p>Referral link:</p>
								<input type="text" class="form-control input-lrg" value="any.tv/s93jr5" disabled>
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
								<li><a href="#">My Profile</a></li>
								<li class="active"><a href="#">Offers</a></li>
								<li><a href="#">Reports</a></li>						  
							</ul>
						</div>
					</div>
				</div>
				<div class="cl-20"></div>
			</div>

			<div class="col-lg-9">
				<div id="user-content-offers">
					<div class="input-group input-group-lg">
						<input type="text" class="form-control" placeholder="Search Offers">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Go!</button>
						</span>
					</div>
					<div class="search-btns">				
						<div class="btn-group">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Browse by Category <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a>Link</a></li>
								</ul>
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Browse by Country <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a>Link</a></li>
								</ul>
							</div>
						</div>														
					</div>

				</div>
				<div class="cl-20"></div>
				<div class="table-responsive">
					<div class="offer-tbl-wrap">
						<table class="table table-striped">							
							<thead>
								<tr>
									<th>Photo</th>
									<th>Preview</th>
									<th>Name</th>
									<th>Payout</th>
									<th>Play Now Link</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1516</td>
									<td>any.tv/4f21</td>
									<td>10 Countries</td>
									<td>link1</td>
									<td></td>
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
		</div>
	</div>

</div>
</section>
<!-- /content -->

<?php include 'footer.php' ?>