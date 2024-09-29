<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="viewModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-center gap-4">

                                            <!-- Profile Picture -->
                        <div class="d-flex justify-content-center">
                            <img id="modal-profile-picture" src="" alt="Profile Picture" class="rounded-circle img-fluid border border-primary" style="width: 40vh;">
                        </div>

                    <!-- User Information Card -->
                    <div class="card flex-fill" style="min-width: 300px;">
                        <div class="card-header bg-primary text-white">
                            <strong>User Information</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>User ID:</strong> <span id="modal-user-id" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Email:</strong> <span id="modal-email" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Full Name:</strong> <span id="modal-full-name" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Account Status:</strong> 
                                <span class="badge bg-success text-dark" id="modal-account-status"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Mobile Number:</strong> <span id="modal-phone-number" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Date of Birth:</strong> <span id="modal-date-of-birth" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Sex:</strong> <span id="modal-sex" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Birth Place:</strong> <span id="modal-birth-place" class="text-muted"></span>
                            </li>
                        </ul>
                    </div>

                    <!-- Address Information Card -->
                    <div class="card flex-fill" style="min-width: 300px;">
                        <div class="card-header bg-success text-white">
                            <strong>Address Information</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Region:</strong> <span id="modal-region" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Province:</strong> <span id="modal-province" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>City/Municipality:</strong> <span id="modal-city-municipality" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Barangay:</strong> <span id="modal-barangay" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Street Number:</strong> <span id="modal-street-number" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Purok:</strong> <span id="modal-purok" class="text-muted"></span>
                            </li>
                        </ul>
                    </div>

                    <!-- Crop Information Card -->
                    <div class="card flex-fill" style="min-width: 300px;">
                        <div class="card-header bg-info text-white">
                            <strong>Crop Information</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Crop Name:</strong> <span id="modal-crop-name" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Crop Area (hectares):</strong> <span id="modal-crop-area" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Benefits:</strong> 
                                <span class="badge bg-success text-dark" id="modal-benefits"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Reference:</strong> <span id="modal-reference" class="text-muted"></span>
                            </li>
                            <li class="list-group-item">
                                <strong>Job Role:</strong> <span id="modal-job-role" class="text-muted"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-success update-status" data-userid="" id="modal-update-status">
                    <i class="fas fa-check"></i> Update Status
                </button>
                
                <button type="button" class="btn btn-success update-benefits" data-userid="" id="modal-update-benefits">   
                    <i class="fas fa-check"></i> benefits
                </button>

                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    var viewModal = document.getElementById('viewModal');
    
    // Event listener when the modal is about to be shown
    viewModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        // Retrieve attributes from the button
        var userId = button.getAttribute('data-userid');
        var email = button.getAttribute('data-email');
        var fullName = button.getAttribute('data-full-name');
        var accountStatus = button.getAttribute('data-account-status');
        var mobileNumber = button.getAttribute('data-phone-number');
        var sex = button.getAttribute('data-sex');
        var birthplace = button.getAttribute('data-birth-place');
        var dateOfBirth = button.getAttribute('data-date-of-birth');
        var region = button.getAttribute('data-region');
        var province = button.getAttribute('data-province');
        var cityMunicipality = button.getAttribute('data-city-municipality');
        var barangay = button.getAttribute('data-barangay');
        var streetNumber = button.getAttribute('data-street-number');
        var purok = button.getAttribute('data-purok');
        var cropName = button.getAttribute('data-crop-name');
        var cropArea = button.getAttribute('data-crop-area');
        var benefits = button.getAttribute('data-benefits');
        var reference = button.getAttribute('data-reference');
        var jobRole = button.getAttribute('data-job-role');

        // Set modal content
        viewModal.querySelector('#modal-user-id').textContent = userId;
        viewModal.querySelector('#modal-email').textContent = email;
        viewModal.querySelector('#modal-full-name').textContent = fullName;
        viewModal.querySelector('#modal-phone-number').textContent = mobileNumber;
        viewModal.querySelector('#modal-sex').textContent = sex;
        viewModal.querySelector('#modal-birth-place').textContent = birthplace;
        viewModal.querySelector('#modal-date-of-birth').textContent = dateOfBirth;
        viewModal.querySelector('#modal-region').textContent = region;
        viewModal.querySelector('#modal-province').textContent = province;
        viewModal.querySelector('#modal-city-municipality').textContent = cityMunicipality;
        viewModal.querySelector('#modal-barangay').textContent = barangay;
        viewModal.querySelector('#modal-street-number').textContent = streetNumber;
        viewModal.querySelector('#modal-purok').textContent = purok;
        viewModal.querySelector('#modal-crop-name').textContent = cropName;
        viewModal.querySelector('#modal-crop-area').textContent = cropArea;
        viewModal.querySelector('#modal-reference').textContent = reference;
        viewModal.querySelector('#modal-job-role').textContent = jobRole;
        // Set profile picture source
        viewModal.querySelector('#modal-profile-picture').src = button.getAttribute('data-profile-picture') || '../assets/images/profiles/your-picture.png';  // Set a default picture if not available
                // Set account status badge and its color
        var accountStatusBadge = viewModal.querySelector('#modal-account-status');
        accountStatusBadge.classList.remove('bg-success', 'bg-warning', 'bg-danger');
        accountStatusBadge.textContent = accountStatus;

        // Apply the appropriate color based on account status
        if (accountStatus === 'Pending') {
            accountStatusBadge.classList.add('bg-warning');
        } else if (accountStatus === 'accepted') {
            accountStatusBadge.classList.add('bg-success');
        } else if (accountStatus === 'rejected') {
            accountStatusBadge.classList.add('bg-danger');
        }

        // Set benefits badge and its color
        var benefitsBadge = viewModal.querySelector('#modal-benefits');
        benefitsBadge.classList.remove('bg-success', 'bg-warning', 'bg-danger');
        benefitsBadge.textContent = benefits;

        // Apply the appropriate color based on the benefits value
        if (benefits === 'qualified') {
            benefitsBadge.classList.add('bg-success');
        } else if (benefits === 'not qualified') {
            benefitsBadge.classList.add('bg-danger');
        } else if (benefits === 'Pending') {
            benefitsBadge.classList.add('bg-warning');
        }

        // Attach the user ID to the update button for future use
        var updateStatusButton = viewModal.querySelector('#modal-update-status');
        updateStatusButton.setAttribute('data-userid', userId);

        // Attach the user ID to the update button for future use
        var updateStatusButton = viewModal.querySelector('#modal-update-benefits');
        updateStatusButton.setAttribute('data-userid', userId);
     
    });

        $(document).on('click', '#modal-update-status', function() {
            var userId = $(this).data('userid');
            
            // SweetAlert confirmation for updating status
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update the status of this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../includes/Applicants/update_status.php',
                        type: 'POST',
                        data: { user_id: userId },
                        success: function(response) {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: 'Updated!',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload the page to reflect changes
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error updating status: ' + res.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while processing your request.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '#modal-update-benefits', function() {
            var userId = $(this).data('userid');
            
            // SweetAlert confirmation for updating status
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update the status of this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../includes/Applicants/benefits.php',
                        type: 'POST',
                        data: { user_id: userId },
                        success: function(response) {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: 'Updated!',
                                    text: 'Status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload the page to reflect changes
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error updating status: ' + res.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while processing your request.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

});

  
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
			$.ajax({
				url: '../includes/Applicants/reject_user.php',
				type: 'POST',
				data: { user_id: userId },
				dataType: 'json',
				success: function(data) {
					// Check if the response is structured correctly
					if (data && typeof data.success === 'boolean') {
						if (data.success) {
							Swal.fire({
								title: 'Rejected!',
								text: 'The user has been rejected successfully.',
								icon: 'success',
								confirmButtonText: 'OK'
							}).then(() => {
								$('#user-row-' + userId).remove(); // Optionally remove user row
								location.reload(); // Reload the page to reflect changes
							});
						} else {
							Swal.fire({
								title: 'Error!',
								text: "Failed to reject the user: " + (data.message || "Unknown error."),
								icon: 'error',
								confirmButtonText: 'OK'
							});
						}
					} else {
						Swal.fire({
							title: 'Unexpected Response',
							text: 'Unexpected response from the server.',
							icon: 'error',
							confirmButtonText: 'OK'
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('Error:', textStatus, errorThrown);
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




