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
        $target_dir = "../../RSBSA/assets/picture/";
        $profile_picture = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profile_picture)) {
            echo "Error uploading file.";
            exit; // Exit if file upload fails
        }
    }

    // Insert into Users table
    $sql_users = "INSERT INTO Users (first_name, middle_name, sur_name, sex, date_of_birth, birth_municipality, birth_province, profile_picture)
                  VALUES ('$first_name', '$middle_name', '$sur_name', '$sex', '$date_of_birth', '$birth_municipality', '$birth_province', '$profile_picture')";

    if ($dbConnection->query($sql_users) === TRUE) {
        $user_id = $dbConnection->insert_id; // Get the last inserted user ID
        
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
        
        $sql_account = "INSERT INTO UserAccounts (user_id, email, password, accountStatus, role)
                        VALUES ('$user_id', '$email', '$password', '$accountStatus', '$role')";
        if ($dbConnection->query($sql_account) === FALSE) {
            echo "Error: " . $dbConnection->error;
        }
        header("Location: ../../../RSBSA/Public/login.php"); 
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

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
    <div class="main">
      <div class="container">
        <h2>AGRILAND REGISTRATION FORM</h2>
        <form
          method="POST"
          id="signup-form"
          class="signup-form"
          action=""
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
                  data-multiple-caption="{count} files selected"
                  multiple
                />
                <label for="profile_picture">
                  <figure>
                    <img
                      src="images/your-picture.png"
                      alt=""
                      class="profile_picture"
                    />
                  </figure>
                  <span class="file-button">choose picture</span>
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
              <input type="hidden" id="benefits" name="benefits" value="Pending">
              <input type="hidden" id="reference" name="reference" value="">
              <input type="hidden" id="accountStatus" name="accountStatus" value="Pending">
              <input type="hidden" id="role" name="role" value="user">
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
                <input
                  type="text"
                  name="birthMunicipaltiy"
                  id="birthMunicipaltiy"
                  placeholder="MUNICIPALITY"
                  required
                />
              </div>
              <div class="form-input">
                <input
                  type="text"
                  name="birthProvince"
                  id="birthProvince"
                  placeholder="PROVINCE/STATE"
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

          <h3>STEP 9</h3>
          <fieldset>
            <h4>Account</h4>

            <div
              class="form-row form-input-flex"
              style="
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 2%;
              "
            >
              <label style="display: flex; align-items: center; gap: 10px">
                <input
                  type="email"
                  name="email"
                  id="email"
                  placeholder="EMAIL"
                  required
                />
              </label>
            </div>

            <div
              class="form-row form-input-flex"
              style="
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 2%;
              "
            >
              <label style="display: flex; align-items: center; gap: 10px">
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="PASSWORD"
                  required
                />
              </label>
            </div>

            <div
              class="form-row form-input-flex"
              style="
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 2%;
              "
            >
              <label style="display: flex; align-items: center; gap: 10px">
                <input
                  type="password"
                  name="confirm_password"
                  id="confirm_password"
                  placeholder="CONFIRM PASSWORD"
                  required
                />
              </label>
            </div>
            <input type="submit" value="SUBMIT" />
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

    
  </body>
</html>