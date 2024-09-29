<?php
include '../../RSBSA/includes/dbconn.php';

// Create a database connection
$dbConnection = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $first_name = $dbConnection->real_escape_string($_POST['first_name']);
    $middle_name = $dbConnection->real_escape_string($_POST['middle_name']);
    $sur_name = $dbConnection->real_escape_string($_POST['sur_name']);
    $sex = $dbConnection->real_escape_string($_POST['sex']);
    $date_of_birth = $dbConnection->real_escape_string($_POST['dateOfBirth']);
    $birth_municipality = $dbConnection->real_escape_string($_POST['birthMunicipaltiy']);
    $birth_province = $dbConnection->real_escape_string($_POST['birthProvince']);
    
    // Handling profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $file_size = $_FILES['profile_picture']['size'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_type = $_FILES['profile_picture']['type'];
        $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));

        // Define allowed file extensions and size limit
        $allowed_extensions = ['jpeg', 'jpg', 'png'];
        $max_file_size = 5 * 1024 * 1024; // 5 MB

        // Check file size and extension
        if ($file_size > $max_file_size) {
            echo "Error: File size exceeds the 5 MB limit.";
            exit;
        }
        if (!in_array($file_ext, $allowed_extensions)) {
            echo "Error: Only JPEG, JPG, and PNG files are allowed.";
            exit;
        }

        // Temporarily store the profile picture path
        $target_dir = "../../RSBSA/assets/images/profiles/";
        $temp_profile_picture = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (!move_uploaded_file($file_tmp, $temp_profile_picture)) {
            echo "Error uploading file.";
            exit; // Exit if file upload fails
        }
    }

    // Insert into Users table (initial insertion before renaming the profile picture)
    $sql_users = "INSERT INTO Users (first_name, middle_name, sur_name, sex, date_of_birth, birth_municipality, birth_province, profile_picture)
                  VALUES ('$first_name', '$middle_name', '$sur_name', '$sex', '$date_of_birth', '$birth_municipality', '$birth_province', null)";

    if ($dbConnection->query($sql_users) === TRUE) {
        $user_id = $dbConnection->insert_id; // Get the last inserted user ID
        
        // Now rename the profile picture with the correct naming convention
        if ($temp_profile_picture) {
            $new_filename = "profile_" . $user_id . "." . $file_ext; // e.g., profile_123.jpg
            $new_file_path = $target_dir . $new_filename;

            // Rename the file
            if (rename($temp_profile_picture, $new_file_path)) {
                $profile_picture = $new_file_path;

                // Update the Users table with the correct profile picture path
                $sql_update_picture = "UPDATE Users SET profile_picture = '$profile_picture' WHERE user_id = '$user_id'";
                $dbConnection->query($sql_update_picture);
            } else {
                echo "Error renaming profile picture.";
                exit;
            }
        }

        // Insert into Addresses table (home address)
        $region = $dbConnection->real_escape_string($_POST['region']);
        $province = $dbConnection->real_escape_string($_POST['province']);
        $city = $dbConnection->real_escape_string($_POST['city']);
        $barangay = $dbConnection->real_escape_string($_POST['barangay']);
        $street_number = $dbConnection->real_escape_string($_POST['street_number']);
        $purok = $dbConnection->real_escape_string($_POST['purok']);
        
        $sql_address = "INSERT INTO Addresses (user_id, region, province, city_municipality, barangay, street_number, purok, address_type)
                        VALUES ('$user_id', '$region', '$province', '$city', '$barangay', '$street_number', '$purok', 'home')";
        if (!$dbConnection->query($sql_address)) {
            echo "Error: " . $dbConnection->error;
        }

        // Insert into Contacts table (personal and emergency)
        $personal_phone = $dbConnection->real_escape_string($_POST['number']);
        $emergency_phone = $dbConnection->real_escape_string($_POST['emergencyNumber']);
        
        $sql_contact_personal = "INSERT INTO Contacts (user_id, phone_number, contact_type)
                                 VALUES ('$user_id', '$personal_phone', 'personal')";
        $sql_contact_emergency = "INSERT INTO Contacts (user_id, phone_number, contact_type)
                                  VALUES ('$user_id', '$emergency_phone', 'emergency')";
        $dbConnection->query($sql_contact_personal);
        $dbConnection->query($sql_contact_emergency);

        // Insert into Crops table
        $crop_name = $dbConnection->real_escape_string($_POST['crop_name']);
        $crop_area = $dbConnection->real_escape_string($_POST['crop_area']);
        $benefits = $dbConnection->real_escape_string($_POST['benefits']);

        $benefits = "Pending";
        // Function to generate a unique 8-digit reference number
        function generateUniqueReference($dbConnection) {
            do {
                // Generate a random 8-digit number
                $reference = rand(10000000, 99999999);

                // Check if the reference number already exists in the Crops table
                $checkReference = "SELECT reference FROM Crops WHERE reference = '$reference'";
                $result = $dbConnection->query($checkReference);
            } while ($result->num_rows > 0); // Repeat until a unique reference is found

            return $reference;
        }

        // Generate unique reference
        $reference = generateUniqueReference($dbConnection);

        // Insert into the Crops table
        $sql_crop = "INSERT INTO Crops (user_id, crop_name, crop_area_hectares, benefits, reference)
                    VALUES ('$user_id', '$crop_name', '$crop_area', '$benefits', '$reference')";
        $dbConnection->query($sql_crop);

        // Insert into JobRoles table
        $job_role = $dbConnection->real_escape_string($_POST['job']);
        $sql_job = "INSERT INTO JobRoles (user_id, job_role)
                    VALUES ('$user_id', '$job_role')";
        $dbConnection->query($sql_job);

        // Insert into UserAccounts table
        $email = $dbConnection->real_escape_string($_POST['email']);
        $accountStatus = $dbConnection->real_escape_string($_POST['accountStatus']);
        $role = $dbConnection->real_escape_string($_POST['role']);
        $password = password_hash($dbConnection->real_escape_string($_POST['password']), PASSWORD_DEFAULT);

        $accountStatus = "Pending"; // Set accountStatus to "Pending" directly
        $role = "user"; // Set role to "user" directly
        
        $sql_account = "INSERT INTO UserAccounts (user_id, email, password, accountStatus, role)
                        VALUES ('$user_id', '$email', '$password', '$accountStatus', '$role')";
        if ($dbConnection->query($sql_account) === FALSE) {
            echo "Error: " . $dbConnection->error;
        }
        header("Location: ../../RSBSA/Public/login.php"); 
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $sql_users . "<br>" . $dbConnection->error;
    }
}

$dbConnection->close();
?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="colorlib.com" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign Up Form</title>

    <!-- Font Icon -->
    <link
      rel="stylesheet"
      href="fonts/material-icon/css/material-design-iconic-font.min.css"
    />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">


    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <style>
  .input-container {
    position: relative;
    display: flex;
    align-items: center;
  }
  
  .input-container input {
    padding-right: 30px; /* Add padding to make space for the icon */
  }

  .icon {
    position: absolute;
    right: 10px; /* Position the icon inside the input */
    cursor: pointer;
    pointer-events: auto; /* Allow click events on the icon */
  }
</style>

  <body>
    <div class="main">
      <div class="container">
        <h2>AGRILAND REGISTRATION FORM</h2>
        <form
          method="POST"
          id="signup-form"
          class="signup-form"
          action=""
          enctype="multipart/form-data"
        >
          <h3>STEP 1</h3>
          <fieldset>
            <h4>Personal Profile</h4>
            <div class="form-row">
              <div class="form-file">
               
                <input
                      type="file"
                      class="inputfile"
                      name="profile_picture"
                      id="profile_picture"
                      onchange="readURL(this);"
                      accept="image/*"
                      required 
                  />
                  <label for="profile_picture">
                      <figure>
                          <img id="preview_image" src="images/your-picture.png" alt="Profile Picture" class="profile_picture" />
                      </figure>
                      <span class="file-button">Choose Picture</span>
                  </label>

              </div>
              <div class="form-group-flex">
                <div class="form-group">
                  <input
                    type="text"
                    name="first_name"
                    id="first_name"
                    placeholder="First Name"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="middle_name"
                    id="middle_name"
                    placeholder="Middle Name"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="sur_name"
                    id="sur_name"
                    placeholder="Surname"
                    required
                  />
                  <hr />
                  <div
                    class="form-row"
                    style="display: flex; align-items: center"
                  >
                    <div
                      class="form-holder"
                      style="display: flex; align-items: center"
                    >
                      <p style="color: black"><strong>SEX:</strong></p>
                      <label
                        style="
                          display: flex;
                          align-items: start;
                          margin: 20px 20px 20px 20px;
                        "
                      >
                        <input type="radio" name="sex" value="male" required/>
                        Male
                      </label>

                      <label style="display: flex; align-items: start">
                        <input type="radio" name="sex" value="female" required/>
                        Female
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h4>Home Address</h4>
            <div class="form-row form-input-flex">
              <div class="form-input">
                <select name="region" id="region" required>
                  <option value="" >
                    REGION
                  </option>
                </select>
                <span class="select-icon"><i class="zmdi zmdi-caret-down"></i></span>
              </div>
  
              <div class="form-input">
                <select name="province" id="province" required>
                  <option value="" required>
                    PROVINCE
                  </option>
                </select>
                <span class="select-icon"><i class="zmdi zmdi-caret-down"></i></span>
              </div>
              
              <input type="hidden" id="reference" name="reference" value="">
             
              <div class="form-input">
                <select name="city" id="city" required>
                  <option value="" required>
                    CITY/MUNICIPALITY
                  </option>
                </select>
              </div>
            </div>
            <div class="form-row form-input-flex">
              <div class="form-input">
                <select name="barangay" id="barangay" required>
                  <option value="" required>
                    BARANGAY
                  </option>
                </select>
              </div>
              <div class="form-input">
                <input
                  type="text"
                  name="street_number"
                  id="street_number"  
                  placeholder="STREET/SITIO/SUBDV."
                  required
                />
              </div>
              <div class="form-input">
                <input
                  type="text"
                  name="purok"
                  id="purok"
                  placeholder="HOUSE/LOT/BLDG. NO./PUROK"
                  required
                />
              </div>
              
            </div>
          
          </fieldset>

          <h3>STEP 2</h3>
          <fieldset>
            <h4>Contact</h4>
            <div class="form-row form-input-flex">
              <div class="form-input">
                <input
                  type="number"
                  name="number"
                  id="number"
                  placeholder="MOBILE NUMBER"
                  required
                />
              </div>
            </div>
            <hr />
            <h4>Person to Contact in case of emergency</h4>
            <div class="form-row form-input-flex">
              <div class="form-input">
                <input
                  type="number"
                  name="emergencyNumber"
                  id="emergencyNumber"
                  placeholder="MOBILE NUMBER"
                  required
                />
              </div>
            </div>
            <hr />
            <div class="form-row form-input-flex">
              <div class="form-input">
                <h4>DATE OF BIRTH</h4>
                <input
                  type="date"
                  name="dateOfBirth"
                  id="dateOfBirth"
                  placeholder="DATE OF BIRTH"
                  required
                />
              </div>
            </div>
            <hr />
            <h4>PLACE OF BIRTH:</h4>
            <div class="form-row form-input-flex">
              <div class="form-input">
                  <select name="birthProvince" id="birthProvince" required>
                      <option value="">PROVINCE</option>
                  </select>
                  <span class="select-icon"><i class="zmdi zmdi-caret-down"></i></span>
              </div>

              <div class="form-input">
                  <select name="birthMunicipaltiy" id="birthMunicipaltiy" required>
                      <option value="">CITY/MUNICIPALITY</option>
                  </select>
                  <span class="select-icon"><i class="zmdi zmdi-caret-down"></i></span>
              </div>
            </div>
          </fieldset>

          <h3>STEP 3</h3>
          <fieldset>
            <div class="form-radio">
              <label for="job" class="label-radio" style="margin-top: 20px"
                >What are you doing?</label
              >
              <div class="form-flex">
                <div class="form-radio">
                  <input
                    type="radio"
                    name="job"
                    value="farmer"
                    id="farmer"
                    checked="checked"
                    onchange="showOptions()"
                    
                  />
                  <label for="farmer">
                    <figure>
                      <img src="images/icon-1.png" alt="Farmer" />
                    </figure>
                    <span>Farmer</span>
                  </label>
                </div>

                <div class="form-radio">
                  <input
                    type="radio"
                    name="job"
                    value="farmworker"
                    id="farmworker"
                    onchange="showOptions()"
                  />
                  <label for="farmworker">
                    <figure>
                      <img src="images/icon-2.png" alt="Farmworker" />
                    </figure>
                    <span>FARMWORKER/LABORER</span>
                  </label>
                </div>

                <div class="form-radio">
                  <input
                    type="radio"
                    name="job"
                    value="fisherfolk"
                    id="fisherfolk"
                    onchange="showOptions()"
                  />
                  <label for="fisherfolk">
                    <figure>
                      <img src="images/icon-3.png" alt="Fisherfolk" />
                    </figure>
                    <span>FISHERFOLK</span>
                  </label>
                </div>

                <div class="form-radio">
                  <input
                    type="radio"
                    name="job"
                    value="agri_youth"
                    id="agri_youth"
                    onchange="showOptions()"
                  />
                  <label for="agri_youth">
                    <figure>
                      <img src="images/icon-4.png" alt="Agri Youth" />
                    </figure>
                    <span>AGRI YOUTH</span>
                  </label>
                </div>
              </div>
            </div>
          </fieldset>

          <h3>STEP 4</h3>
          <fieldset>
            <h4>Crop Area</h4>

            <div class="form-row form-input-flex">
              
              <div class="form-input">
                <input
                  type="number"
                  name="crop_area"
                  id="crop_area"
                  placeholder="CROP AREA IN HECTARS"
                  required
                />
              </div>
            
            </div>
            <hr />
            <h4>Crop Name</h4>
            <div
              class="form-row form-input-flex"
              style="
                display: flex;
                justify-content: center;
                align-items: center;
              "
            >
              <label style="display: flex; align-items: center; gap: 10px">
                <select name="crop_name" id="crop_name" required>
                  <option value="">Piliin ang Pananim (Select Crop)</option>
                  <option value="Palay/Rice">Palay/Rice (Palay)</option>
                  <option value="Corn">Corn/Mais (Mais)</option>
                  <option value="Mungbean">Mungbean/Monggo (Monggo)</option>
                  <option value="Onion">Onion/Sibuyas (Sibuyas)</option>
                  <option value="Garlic">Garlic/Bawang (Bawang)</option>
                  <option value="Eggplant">Eggplant/Talong (Talong)</option>
                  <option value="Tomato">Tomato/Kamatis (Kamatis)</option>
                  <option value="Cabbage">Cabbage/Repolyo (Repolyo)</option>
                  <option value="Carrot">Carrot/Karot (Karot)</option>
                  <option value="Watermelon">Watermelon/Pakwan (Pakwan)</option>
                </select>
              </label>
            </div>
            <hr>
            <h4>Farm Address</h4>
            <div class="form-row form-input-flex">
              <div class="form-input">
                <select name="region" id="step4_region" required>
                  <option value="">REGION</option>
                </select>
              </div>
              <div class="form-input">
                <select name="province" id="step4_province" required>
                  <option value="">PROVINCE</option>
                </select>
              </div>
            </div>
            <div class="form-row form-input-flex">
              <div class="form-input">
                <select name="city" id="step4_city" required>
                  <option value="">CITY/MUNICIPALITY</option>
                </select>
              </div>
              <div class="form-input">
                <select name="barangay" id="step4_barangay" required>
                  <option value="">BARANGAY</option>
                </select>
              </div>
              
            </div>

          
          </fieldset>

          <h3>STEP 5</h3>
          <fieldset>
            <h4>Email</h4>
            <div class="form-row form-input-flex">
              <div class="form-input">
              <input
                  type="email"
                  name="email"
                  id="email"
                  placeholder="EMAIL"
                  required
                />
              </div>
            </div>
         
            <hr>
            <h4>Password</h4>
              <div class="form-row form-input-flex">
              <div class="form-input">
              <div class="input-container">
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="PASSWORD"
                  required
                />
                <span id="togglePassword" class="icon" onclick="togglePassword('password', 'togglePassword')">
                  <i class="bi bi-eye-slash"></i>
                </span>
              </div>
            </div>
            <div class="form-input">
              <div class="input-container">
                <input
                  type="password"
                  name="confirm_password"
                  id="confirm_password"
                  placeholder="CONFIRM PASSWORD"
                  required
                />
                <span id="toggleConfirmPassword" class="icon" onclick="togglePassword('confirm_password', 'toggleConfirmPassword')">
                  <i class="bi bi-eye-slash"></i>
                </span>
              </div>
            </div>
            </div>
            <hr/>

            

          <h5>Password must contain the following:</h5>
              <div >
                <div class="col-md-4">
                  <p id="letter" class="invalid">
                    <span><i class="bi bi-x-circle-fill" style="color:#f63726"></i></span> A
                    <b>lowercase</b> letter
                  </p>
                  <p id="capital" class="invalid">
                    <span><i class="bi bi-x-circle-fill" style="color:#f63726"></i></span> A
                    <b>capital</b> letter
                  </p>
                </div>
                <div class="col-md-4">
                  <p id="number_validation" class="invalid">
                    <span ><i class="bi bi-x-circle-fill" style="color:#f63726"></i></span> A
                    <b>number</b>
                  </p>
                  <p id="length" class="invalid">
                    <span ><i class="bi bi-x-circle-fill" style="color:#f63726"></i></span> Minimum
                    <b>8 characters</b>
                  </p>
                </div>
                <div class="col-md-4">
                  <p id="match" class="invalid">
                    <span><i class="bi bi-x-circle-fill" style="color:#f63726"></i></span> Passwords
                    <b>match</b>
                  </p>
                </div>
              </div>
        </div>
          </fieldset>
        </form>
      </div>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/location.js"></script>
      <!-- JavaScript to display selected photo -->
      <script>
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            document.getElementById('preview_image').src = e.target.result;
          };

          reader.readAsDataURL(input.files[0]); // Convert file to base64 string
        }
      }
    </script>
 <script>
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    const letter = document.getElementById("letter");
    const capital = document.getElementById("capital");
    const number = document.getElementById("number_validation");
    const length = document.getElementById("length");
    const match = document.getElementById("match");

    password.onkeyup = function () {
      const lowerCaseLetters = /[a-z]/g;
      const upperCaseLetters = /[A-Z]/g;
      const numbers = /[0-9]/g;

      // Validate lowercase letters
      if (password.value.match(lowerCaseLetters)) {
        letter.innerHTML = '<span><i class="bi bi-check-circle-fill" style="color: #1ed760;"></i></span> A <b>lowercase</b> letter';
        letter.classList.remove("invalid");
        letter.classList.add("valid");
      } else {
        letter.innerHTML = '<span><i class="bi bi-check-circle " style="color: #1ed760;"></i></span> A <b>lowercase</b> letter';
        letter.classList.remove("valid");
        letter.classList.add("invalid");
      }

      // Validate capital letters
      if (password.value.match(upperCaseLetters)) {
        capital.innerHTML = '<span><i class="bi bi-check-circle-fill " style="color: #1ed760;"></i></span> A <b>capital (uppercase)</b> letter';
        capital.classList.remove("invalid");
        capital.classList.add("valid");
      } else {
        capital.innerHTML = '<span><i class="bi bi-check-circle" style="color: #1ed760;"></i></span> A <b>capital (uppercase)</b> letter';
        capital.classList.remove("valid");
        capital.classList.add("invalid");
      }

      // Validate numbers
      if (password.value.match(numbers)) {
        number.innerHTML = '<span><i class="bi bi-check-circle-fill" style="color: #1ed760;"></i></span> A <b>number</b>';
        number.classList.remove("invalid");
        number.classList.add("valid");
      } else {
        number.innerHTML = '<span><i class="bi bi-check-circle " style="color: #1ed760;"></i></span> A <b>number</b>';
        number.classList.remove("valid");
        number.classList.add("invalid");
      }

      // Validate length
      if (password.value.length >= 8) {
        length.innerHTML = '<span><i class="bi bi-check-circle-fill " style="color: #1ed760;"></i></span> Minimum <b>8 characters</b>';
        length.classList.remove("invalid");
        length.classList.add("valid");
      } else {
        length.innerHTML = '<span><i class="bi bi-check-circle" style="color: #1ed760;"></i></span> Minimum <b>8 characters</b>';
        length.classList.remove("valid");
        length.classList.add("invalid");
      }
    };

    confirmPassword.onkeyup = function () {
      // Validate matching passwords
      if (password.value === confirmPassword.value) {
        match.innerHTML = '<span><i class="bi bi-check-circle-fill " style="color: #1ed760;"></i></span> Passwords <b>match</b>';
        match.classList.remove("invalid");
        match.classList.add("valid");
      } else {
        match.innerHTML = '<span><i class="bi bi-check-circle" style="color: #1ed760;"></i></span> Passwords <b>match</b>';
        match.classList.remove("valid");
        match.classList.add("invalid");
      }
    };
  </script>
  <script>
  function togglePassword(inputId, iconId) {
    const inputField = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    // Toggle the input type between password and text
    if (inputField.type === 'password') {
      inputField.type = 'text';
      icon.innerHTML = '<i class="bi bi-eye"></i>'; // Change icon to eye
    } else {
      inputField.type = 'password';
      icon.innerHTML = '<i class="bi bi-eye-slash"></i>'; // Change icon to eye-slash
    }
  }
</script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            const birthProvinceSelect = document.getElementById('birthProvince');
            const birthMunicipaltiySelect = document.getElementById('birthMunicipaltiy');
            const provinceUrl = 'https://psgc.cloud/api/provinces';

            // Function to show loading indicator
            function showLoadingIndicator() {
                const loadingIndicator = document.createElement('div');
                loadingIndicator.textContent = 'Loading...';
                loadingIndicator.id = 'loadingIndicator';
                document.body.appendChild(loadingIndicator);
            }

            // Function to hide loading indicator
            function hideLoadingIndicator() {
                const loadingIndicator = document.getElementById('loadingIndicator');
                if (loadingIndicator) loadingIndicator.remove();
            }

            // Fetch provinces on page load
            fetch(provinceUrl)
                .then(response => {
                    showLoadingIndicator();
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    hideLoadingIndicator();
                    birthProvinceSelect.innerHTML = '<option value="">PROVINCE</option>'; // Clear previous options
                    data.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.name; // Set the value to the province name
                        option.textContent = province.name; // Display the province name
                        birthProvinceSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    hideLoadingIndicator();
                    console.error('Error fetching provinces:', error);
                });

            // Fetch municipalities when a province is selected
            birthProvinceSelect.addEventListener('change', function() {
                const selectedProvince = this.value;
                birthMunicipaltiySelect.innerHTML = '<option value="">CITY/MUNICIPALITY</option>'; // Clear previous options

                if (selectedProvince) {
                    const citiesUrl = `https://psgc.cloud/api/provinces/${selectedProvince}/cities-municipalities`;

                    fetch(citiesUrl)
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                            return response.json();
                        })
                        .then(data => {
                            data.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.name; // Set the value to the city name
                                option.textContent = city.name; // Display the city name
                                birthMunicipaltiySelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                }
            });
        });
    </script>

    
    
  </body>
</html>