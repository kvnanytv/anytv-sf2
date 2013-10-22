<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../assets/ico/favicon.png">

	<title>Dashboard.tm | Part of any.tv family.</title>	

	<?php include 'header-dashboard.php'; ?>

	<div id="content">
		<div id="dboard-wrap">

			<section class="sec-content-title">
				<div class="container">
					<div style="float: left;"><h3>Affiliate</h3></div>
					<div style="float: right;">Last Affiliate ID = ""</div>
				</div>
			</section>

			<section class="db-slide-1">
				<div class="container">
					<div class="row">

						

						<form class="form-inline" role="form">
										<div class="input-group input-group-lg">
											<input type="text" class="form-control input-lg" placeholder="Search Offers">
											<span class="input-group-btn">
												<button class="btn btn-default btn-srch" type="button"><i class="icon-search"></i></button>
											</span>
										</div>
							
							<div class="f-lft">
								<div class="form-group">
									<label class="sr-only">Country</label>
									<select class="selectpicker"><option>Choose Country...</option></select>

								</div>
								<div class="form-group">
									<label class="sr-only">Status</label>
									<select class="selectpicker"><option>Choose Status...</option></select>

								</div>			

								<div class="form-group">
									<div class="checkbox">
										<label class="lbl-h"><strong>Paypal Email</strong></label>
										<input type="checkbox"> 
									</div>
								</div>
							</div>

							<div class="f-rght">

								<button type="submit" class="btn btn-default">Update</button>
								<button type="submit" class="btn btn-default" disabled>Update Paypal</button>
							</div>																
						</form>
						<div class="cl-20"></div>
						<hr>
						<div class="table-responsive">
							<div class="offer-tbl-wrap">
								<table class="table table-striped">							
									<thead>
										<tr>
											<th>Id</th>
											<th>Affiliate Id</th>
											<th>Company</th>
											<th>Country</th>
											<th>Date Added</th>
											<th>Paypal</th>
											<th>Sign up IP</th>
											<th>Thumbnail</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>4244</td>
											<td>14040</td>
											<td>NoYoC</td>
											<td>Taiwan</td>
											<td>2013-10-21</td>
											<td>&nbsp;</td>
											<td>114.34.194.136</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>4244</td>
											<td>14040</td>
											<td>NoYoC</td>
											<td>Taiwan</td>
											<td>2013-10-21</td>
											<td>&nbsp;</td>
											<td>114.34.194.136</td>
											<td>&nbsp;</td>
										</tr>										

									</tbody>	

									<tfoot>
										<tr>
											<td class="al-cntr" colspan="8">
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
				</div>

			</section>

		</div>
	</div>


	<?php include 'footer.php' ?>