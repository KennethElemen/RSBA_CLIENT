<!DOCTYPE html>
<html lang="en"> 

<?php include 'components/head.php'; ?>
<body class="app">   	
<?php include 'components/header.php'; ?>
    
<div class="app-wrapper">

	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <div class="row g-3 mb-4 align-items-center justify-content-between">
				    <div class="col-auto">
			            <h1 class="app-page-title mb-0">Applicants</h1>
				    </div>
				    
			    </div><!--//row-->
			   
			    
			    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
				    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All</a>
				    <a class="flex-sm-fill text-sm-center nav-link"  id="orders-paid-tab" data-bs-toggle="tab" href="#orders-paid" role="tab" aria-controls="orders-paid" aria-selected="false">Accepted</a>
				    <a class="flex-sm-fill text-sm-center nav-link" id="orders-pending-tab" data-bs-toggle="tab" href="#orders-pending" role="tab" aria-controls="orders-pending" aria-selected="false">Pending</a>
				    <a class="flex-sm-fill text-sm-center nav-link" id="orders-cancelled-tab" data-bs-toggle="tab" href="#orders-cancelled" role="tab" aria-controls="orders-cancelled" aria-selected="false">Cancelled</a>
				</nav>
				
				<div class="tab-content" id="orders-table-tab-content">
						<!-- All Orders Tab -->
						<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
							<div class="app-card app-card-orders-table shadow-sm mb-5">
								<div class="app-card-body">
									<div class="table-responsive">
										<table class="table app-table-hover mb-0 text-left">
											<thead>
												<tr>
												<th class="cell">accountID</th>
													<th class="cell">Email</th>
													<th class="cell">Full Name</th>
													<th class="cell">Status</th>
													<th class="cell" colspan="3">Action</th>


												</tr>
											</thead>
											<tbody>
											<?php include '../includes/Applicants/allAplicants.php' ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							

							<!-- Pagination -->
							<nav class="app-pagination">
								<ul class="pagination justify-content-center">
									<?php if ($page > 1): ?>
										<li class="page-item">
											<a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
										</li>
									<?php else: ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">Previous</a>
										</li>
									<?php endif; ?>

									<?php for ($i = 1; $i <= $totalPages; $i++): ?>
										<li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
											<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
										</li>
									<?php endfor; ?>

									<?php if ($page < $totalPages): ?>
										<li class="page-item">
											<a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
										</li>
									<?php else: ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">Next</a>
										</li>
									<?php endif; ?>
								</ul>
							</nav>
							</div>			



						<!-- Paid Orders Tab -->
						<div class="tab-pane fade" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
							<div class="app-card app-card-orders-table mb-5">
								<div class="app-card-body">
									<div class="table-responsive">
										<table class="table mb-0 text-left">
											<thead>
												<tr>
													<th class="cell">accountID</th>
													<th class="cell">Email</th>
													<th class="cell">Full Name</th>
													<th class="cell">Status</th>
													<th class="cell">action</th>
												</tr>
											</thead>
											<tbody>
											<?php include '../includes/Applicants/accepted.php' ?>
											</tbody>
										</table>
									</div><!--//table-responsive-->
								</div><!--//app-card-body-->
							</div><!--//app-card-->
							
							<!-- Pagination for Paid Orders Tab -->
							<nav class="app-pagination">
								<ul class="pagination justify-content-center">
									<?php if ($page_paid > 1): ?>
										<li class="page-item">
											<a class="page-link" href="?page_paid=<?php echo $page_paid - 1; ?>">Previous</a>
										</li>
									<?php else: ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">Previous</a>
										</li>
									<?php endif; ?>

									<?php for ($i = 1; $i <= $totalPages_paid; $i++): ?>
										<li class="page-item <?php echo ($i == $page_paid) ? 'active' : ''; ?>">
											<a class="page-link" href="?page_paid=<?php echo $i; ?>"><?php echo $i; ?></a>
										</li>
									<?php endfor; ?>

									<?php if ($page_paid < $totalPages_paid): ?>
										<li class="page-item">
											<a class="page-link" href="?page_paid=<?php echo $page_paid + 1; ?>">Next</a>
										</li>
									<?php else: ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">Next</a>
										</li>
									<?php endif; ?>
								</ul>
							</nav>
						</div><!--//tab-pane-->
										

				<!-- Pending Orders Tab -->
					<div class="tab-pane fade" id="orders-pending" role="tabpanel" aria-labelledby="orders-pending-tab">
						<div class="app-card app-card-orders-table mb-5">
							<div class="app-card-body">
								<div class="table-responsive">
									<table class="table mb-0 text-left">
										<thead>
											<tr>
												<th class="cell">accountID</th>
												<th class="cell">Email</th>
												<th class="cell">Full Name</th>
												<th class="cell">Status</th>
												<th class="cell">Action</th>
											</tr>
										</thead>
										<tbody>
										<?php include '../includes/Applicants/Pending.php' ?>
										</tbody>
									</table>
								</div><!--//table-responsive-->
							</div><!--//app-card-body-->
						</div><!--//app-card-->

						<!-- Pagination for Pending Orders Tab -->
						<nav class="app-pagination">
							<ul class="pagination justify-content-center">
								<?php if ($page_pending > 1): ?>
									<li class="page-item">
										<a class="page-link" href="?page_pending=<?php echo $page_pending - 1; ?>">Previous</a>
									</li>
								<?php else: ?>
									<li class="page-item disabled">
										<a class="page-link" href="#">Previous</a>
									</li>
								<?php endif; ?>

								<?php for ($i = 1; $i <= $totalPages_pending; $i++): ?>
									<li class="page-item <?php echo ($i == $page_pending) ? 'active' : ''; ?>">
										<a class="page-link" href="?page_pending=<?php echo $i; ?>"><?php echo $i; ?></a>
									</li>
								<?php endfor; ?>

								<?php if ($page_pending < $totalPages_pending): ?>
									<li class="page-item">
										<a class="page-link" href="?page_pending=<?php echo $page_pending + 1; ?>">Next</a>
									</li>
								<?php else: ?>
									<li class="page-item disabled">
										<a class="page-link" href="#">Next</a>
									</li>
								<?php endif; ?>
							</ul>
						</nav>
					</div><!--//tab-pane-->


						<!-- Cancelled Orders Tab -->
						<div class="tab-pane fade" id="orders-cancelled" role="tabpanel" aria-labelledby="orders-cancelled-tab">
							<div class="app-card app-card-orders-table mb-5">
								<div class="app-card-body">
									<div class="table-responsive">
										<table class="table mb-0 text-left">
											<thead>
												<tr>
													<th class="cell">accountID</th>
													<th class="cell">Email</th>
													<th class="cell">Status</th>
													<th class="cell">action</th>
													
													<th class="cell">Total</th>
													<th class="cell"></th>
												</tr>
											</thead>
											<tbody>
											<?php
												// Pagination logic for 'cancelled' tab
												$result = $dbConnection->query("SELECT user_id, email, accountStatus, account_id FROM useraccounts WHERE accountStatus = 'cancelled' LIMIT $limit OFFSET $offset");
												if ($result->num_rows > 0) {
													while ($row = $result->fetch_assoc()) {
														echo '<tr>';
														
														echo '<td class="cell"><span class="truncate">' . htmlspecialchars($row['account_id']) . '</span></td>';
														echo '<td class="cell">' . htmlspecialchars($row['email']) . '</td>';
														echo '<td class="cell"><span class="badge bg-danger">' . ucfirst(htmlspecialchars($row['accountStatus'])) . '</span></td>';
														echo '<td class="cell"><a class="btn-sm app-btn-secondary" href="#">View</a></td>';
														echo '</tr>';
													}
												} else {
													echo '<tr><td colspan="7" class="text-center">No users found</td></tr>';
												}

												$totalResult = $dbConnection->query("SELECT COUNT(*) as total FROM useraccounts WHERE accountStatus = 'cancelled'");
												$totalRecords = $totalResult->fetch_assoc()['total'];
												$totalPages = ceil($totalRecords / $limit);
											?>
											</tbody>
										</table>
									</div><!--//table-responsive-->
								</div><!--//app-card-body-->
							</div><!--//app-card-->
							
							<!-- Pagination for Cancelled Orders Tab -->
							<nav class="app-pagination">
								<ul class="pagination justify-content-center">
									<?php if ($page > 1): ?>
										<li class="page-item">
											<a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
										</li>
									<?php else: ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">Previous</a>
										</li>
									<?php endif; ?>

									<?php for ($i = 1; $i <= $totalPages; $i++): ?>
										<li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
											<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
										</li>
									<?php endfor; ?>

									<?php if ($page < $totalPages): ?>
										<li class="page-item">
											<a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
										</li>
									<?php else: ?>
										<li class="page-item disabled">
											<a class="page-link" href="#">Next</a>
										</li>
									<?php endif; ?>
								</ul>
							</nav>
						</div><!--//tab-pane-->
					</div><!--//tab-content-->

				
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    <?php include 'components/footer.php' ?>
	    
    </div><!--//app-wrapper-->    					

	<?php include 'modals.php' ?>

	<?php include 'components/script.php'; ?>

</body>
</html> 

