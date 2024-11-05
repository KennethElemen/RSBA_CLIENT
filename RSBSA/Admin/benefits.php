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
			   
			    
		<!-- Download Button -->
<div class="mt-3 mb-3" style="text-align: right;">
    <a href="export.php" class="btn btn-primary">Download Excel</a>
</div>
<div class="tab-content" id="orders-table-tab-content">
    <!-- Paid Orders Tab -->
    <div class="tab-pane fade show active" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
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
                                <th class="cell">Benefits</th>
                                <th class="cell">view</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../includes/Applicants/qualified.php' ?>
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

				

				
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    <?php include 'components/footer.php' ?>
		<script>
// orders.php

function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to reject this user? This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reject!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to reject_user.php
            $.ajax({
                url: 'reject_user.php', // Point to the correct PHP file
                type: 'POST',
                data: { user_id: userId }, // Send user ID for deletion
                dataType: 'json',  // Expecting JSON in response
                success: function(response) {
                    console.log('Server Response:', response);  // Debugging
                    if (response.success) {
                        Swal.fire({
                            title: 'Rejected!',
                            text: 'The user has been rejected successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();  // Reload to reflect changes
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'An unknown error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);  // Log errors
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while rejecting the user. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}

</script>

	    
    </div><!--//app-wrapper-->    					

	<?php include 'modals.php' ?>

	<?php include 'components/script.php'; ?>

</body>
</html> 

