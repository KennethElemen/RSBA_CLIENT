<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

<?php include 'components/head.php'; ?>
<body class="app">   
<?php include 'components/header.php'; ?>

<div class="app-wrapper">
    
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0">Staff</h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            <div class="col-auto">
                                <form class="table-search-form row gx-1 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" id="search-staff" name="search-staff" class="form-control search-staff" placeholder="Search">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn app-btn-secondary">Search</button>
                                    </div>
                                </form>
                            </div><!--//col-->
                            <div class="col-auto">
                                <a class="btn app-btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#createStaffModal">Create Staff</a>
                            </div>
                        </div><!--//row-->
                    </div><!--//table-utilities-->
                </div><!--//col-auto-->
            </div><!--//row-->

            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">ID</th>
                                    <th class="cell">Name</th>
                                    <th class="cell">Email</th>
                                    <th class="cell">Phone</th>
                                    <th class="cell">Status</th>
                                    <th class="cell">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="cell">1</td>
                                    <td class="cell">John Doe</td>
                                    <td class="cell">john.doe@example.com</td>
                                    <td class="cell">123-456-7890</td>
                                    <td class="cell"><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm px-2" data-bs-toggle="modal" data-bs-target="#editStaffModal" data-id="1" data-name="John Doe" data-email="john.doe@example.com" data-phone="123-456-7890" data-status="active">
                                            <i class="fa-solid fa-pen-to-square text-white"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm px-2">
                                            <i class="fa-solid fa-eye text-white"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm px-2">
                                            <i class="fa-solid fa-trash text-white"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Add more staff rows as needed... -->
                            </tbody>
                        </table>
                    </div><!--//table-responsive-->
                </div><!--//app-card-body-->     
            </div><!--//app-card-->
            
            <nav class="app-pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav><!--//app-pagination-->
        </div><!--//container-fluid-->
    </div><!--//app-content-->
    
    <?php include 'components/footer.php' ?>
    
</div><!--//app-wrapper-->    

<!-- Create Staff Modal -->
<div class="modal fade" id="createStaffModal" tabindex="-1" aria-labelledby="createStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="createStaffModalLabel">Create Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createStaffForm">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="staffEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffPhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="staffPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffStatus" class="form-label">Status</label>
                        <select class="form-select" id="staffStatus" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary text-white" form="createStaffForm">Create Staff</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-dark">
                <h5 class="modal-title text-white" id="editStaffModalLabel">Edit Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStaffForm">
                    <input type="hidden" id="staffId">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMiddleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddleName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editStaffEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffPhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="editStaffPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStaffStatus" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-primary text-dark text-white" form="editStaffForm">Update Staff</button>
            </div>
        </div>
    </div>
</div>

<?php include 'components/script.php'; ?>


</body>
</html>
