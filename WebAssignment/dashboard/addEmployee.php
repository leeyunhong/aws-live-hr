<?php
session_start();

include('../php-class/employee.php');

if (!isset($_SESSION['employeeID'])) {
    header('Location: ../home.php?login=invalid');
}
if($_SESSION['departmentID'] != 'DEPT003'){
    header ('Location: ../dashboard/userProfile.php?authorize=0');
}

if(isset($_GET['addEmployee'])){
    if($_GET['addEmployee'] == 'success'){
       echo '<script>alert("Employee Added Successfully!");</script>';
    }else{
       echo '<script>alert("Employee Added Failed!");</script>';
    }  
}

$employee = new Employee();
$employeeID = $employee->generateID();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="../css/addEmployee.css">
</head>

<body>
    <div class="container">
        <aside>
            <img src="../img/Logo - BnW.png" alt="Logo">
            <nav>
                <ul>
                    <li class="layer1Li">
                        <input type="checkbox" id="employee">
                        <label for="employee">Employee</label>
                        <ul class="employeeSub">
                            <li><a href="userProfile.php">View Profile</a></li>
                            <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                ?>
                                <li><a href="addEmployee.php">Add Employee</a></li>
                                <li><a href="employeeTable.php">Employee List</a></li>
                            <?php
                                 }
                            ?>
                            
                        </ul>
                    </li>
                    <li class="layer1Li">
                        <input type="checkbox" id="payroll">
                        <label for="payroll">Payroll</label>
                        <ul class="payrollSub">
                            <li><a href="viewWages.php">View Wages</a></li>
                        </ul>
                    </li>
                    <li class="layer1Li">
                        <input type="checkbox" id="application">
                        <label for="application">Leave Application</label>
                        <ul class="applicationSub">
                            <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                ?>
                                 <li><a href="viewLeave.php">View Application</a></li>
                            <?php
                                 }
                            ?>             
                            <li><a href="applyLeave.php">Apply Leave</a></li>
                            <li><a href="editLeave.php">Edit Leave</a></li>
                        </ul>
                    </li>
                    <li class="layer1Li">
                        <input type="checkbox" id="schedule">
                        <label for="schedule">Training</label>
                        <ul class="scheduleSub">
                            <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                ?>
                                 <li><a href="addTraining.php">Add Training</a></li>
                            <?php
                                 }
                            ?>                               
                            <li><a href="viewTraining.php">View Schedule</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="inner-cont">
            <div class="right-top-container">
                <div class="top">
                    <?php
                    if (isset($_SESSION['fullName'])) {
                        echo "<h3>Hi, <span>" . $_SESSION['fullName'] . "</span></h3>";
                    }
                    ?>
                    <a href="../changePassword.php">Change Password</a>
                    <form action="../php-inc/logout-inc.php" method="get">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </div>
            </div>

            <!-- 
            Add Employee
            Add Wages only For HR -->

            <div class="right-lower-cont">
                <div class="inner-cont">
                    <h1>Add New <span>Employee</span></h1>
                    <form action="../php-inc/addEmployee-inc.php" method="post" enctype="multipart/form-data">
                        <div class="left-form">
                            <label for="employeeid">Employee ID</label>
                            <input readonly type="text" name="employeeid" value="<?php
                             if (isset($employeeID)) { echo $employeeID;}                                                     
                             ?>" id="id">

                            <label for="name">Employee Name</label>
                            <?php
                            if (isset($_GET['name'])) {
                            ?>
                                <input type="text" name="name" value="<?php echo $_GET['name']; ?>" id="name" required>
                            <?php
                            } else {
                            ?>
                                <input type="text" name="name" id="name" required>
                            <?php
                            }
                            ?>

                            <label for="ic">IC Number</label>
                            <?php
                            if ((isset($_GET['icNo']) && $_GET['icNo'] != "notNumber" && $_GET['icNo'] != "used")) {
                            ?>
                                <input type="text" name="ic" id="ic" required maxlength="12" value="<?php echo $_GET['icNo']; ?>">
                            <?php
                            } else if((isset($_GET['icNo']) && $_GET['icNo'] == "notNumber")){
                            ?>
                                <input type="text" name="ic" id="ic" required maxlength="12">
                                <p class="error-msg">Please enter a valid IC number</p>                                
                            <?php
                            } else if ((isset($_GET['icNo']) && $_GET['icNo'] == "used")) {
                            ?>
                                <input type="text" name="ic" id="ic" required maxlength="12">
                                <p class="error-msg">This IC already been used</p>     
                            <?php
                            }else{
                            ?>
                                <input type="text" name="ic" id="ic" required maxlength="12">
                            <?php
                            }
                            ?>
                            <label for="contact">Contact No. (Without dash (-))</label>
                            <?php
                            if ((isset($_GET['contactNo']) && $_GET['contactNo'] != "notNumber")) {

                            ?>
                                <input type="tel" name="contact" id="contact" required maxlength="12" value="<?php echo $_GET['contactNo']; ?>">
                            <?php
                            } else if((isset($_GET['contactNo']) && $_GET['contactNo'] == "notNumber")) {
                            ?>
                                <input type="tel" name="contact" id="contact" required maxlength="12">
                                <p class="error-msg">Please enter a valid Contact Number</p>
                            <?php
                            }else{
                            ?>
                                <input type="tel" name="contact" id="contact" required maxlength="12">
                           <?php
                            }
                            ?>

                            <label for="email">Email</label>
                            <?php
                            if(isset($_GET['email'])) {
                            ?>
                            <input type="email" name="email" id="email" required value="<?php echo $_GET['email']; ?>">

                            <?php
                            } else if ((isset($_GET['emailExist']))) {
                            ?>
                                <input type="email" name="email" id="email" required>       
                                <p class="error-msg">The email is being used by others</p>                 
                            <?php
                            }else{
                            ?>
                                <input type="email" name="email" id="email" required>
                           <?php
                            }
                            ?>
                               
                            <label for="address">Home Address</label>
                            <?php
                            if (isset($_GET['address'])) {
                                echo '<textarea name="address" id="address" cols="30" rows="5" required >' . $_GET['address'] . ' </textarea>';
                            } else {
                            ?>
                                <textarea name="address" id="address" cols="30" rows="5" required></textarea>
                            <?php
                            }
                            ?>                         
                        </div>
                        <div class="right-form">
                            <label for="department">Department</label>                           
                            <select name="department" id="department" onchange="insertManagerID();">
                                <?php
                                include_once('../php-class/dbcontroller.php');
                                $db_handle = new DBController();
                                $query = "SELECT * FROM department";
                                $results = $db_handle->runQuery($query);
                                for ($i = 0; $i < count($results); $i++) {
                                    echo "<option value='" . $results[$i]['departmentID'] . "'>" . $results[$i]['departmentName'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="manager">Manager</label>
                            <select name="manager" id="manager">
                                <option value="None">None</option>
                            </select>
                            <label for="position">Position</label>

                            <?php
                            if (isset($_GET['position'])) {
                            ?>
                                <input type="text" name="position" id="position" required value="<?php echo $_GET['position']; ?>">
                            <?php
                            } else {
                            ?>
                                <input type="text" name="position" id="position" required>
                            <?php
                            }
                            ?>

                            <label for="dateJoined">Date Joined</label>
                            <?php
                            if (isset($_GET['joinDate'])) {
                            ?>
                                <input type="date" name="dateJoined" value="<?php echo $_GET['joinDate']; ?>" id="dateJoined">
                            <?php
                            } else {
                            ?>
                                <input type="date" name="dateJoined" id="dateJoined" required>
                            <?php
                            }
                            ?>
                            
                            <label for="salary">Basic Salary (RM)</label>
                            <?php
                            if ((isset($_GET['salary'])) && $_GET['salary'] != "notNumber") {
                            ?>
                                <input type="text" name="salary" id="salary" required value="<?php echo $_GET['salary']; ?>">
                            <?php
                            } else if((isset($_GET['salary']) && $_GET['salary'] == "notNumber")) {
                            ?>
                                <input type="text" name="salary" id="salary" required>
                                <p class="error-msg"> Please enter valid number</p>
                            <?php
                            }else{
                            ?>
                                <input type="text" name="salary" id="salary" required>
                           <?php
                           }
                            ?>
                            <label for="bankAcc">Bank Account</label>

                            <?php
                            if ((isset($_GET['bankAccount'])) && $_GET['bankAccount'] != "notNumber") {
                            ?>
                                <input type="text" name="bankAcc" id="bankAcc" required value="<?php echo $_GET['bankAccount']; ?>">
                            <?php
                            } else if((isset($_GET['bankAccount'])) && $_GET['bankAccount'] == "notNumber") {
                            ?>
                                <input type="text" name="bankAcc" id="bankAcc" required>
                                <p class="error-msg"> Please enter valid bank account</p>
                            <?php
                            }else{
                            ?>
                                <input type="text" name="bankAcc" id="bankAcc" required>
                           <?php
                           }
                            ?>

                        </div>
                        <div class="btnBar">
                            <div class="profile-img">
                                <label>Profile Picture</label>
                                <input type="file" name="image" accept="image/*" required>
                            </div>
                            <div class="btn">
                                <input type="submit" value="Add" name="addEmp" class="submit-btn" id="submit">
                                <input type="reset" value="Reset" name="reset" id="reset">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <footer>

    </footer>
    <script>
      preventPrevDate();

       async function fetchDepartmentMng(){
            const departmentID = document.getElementById('department').value;
            const getManagerPhp = '../php-inc/ajaxDepartmentMng.php?departmentID=' + departmentID;

            let getEmployeeRespond = await fetch(getManagerPhp);
            let managerObj = await getEmployeeRespond.json();
            return managerObj;
        }

        //Calling async function need to be async as well
       async function insertManagerID(){
           const managerSelect = document.getElementById('manager');
           const managerObj = await fetchDepartmentMng();

            if (Object.keys(managerObj).length != 0) {
              //  managerSelect.innerHTML = "";
                for (let i = 0; i < managerObj.length; i++) {
                    managerSelect.innerHTML += "<option value='" + managerObj[i].employeeID + "'>" + managerObj[i]
                        .fullName + "</option>";
                }
            } else {
                managerSelect.innerHTML = "<option value='None'>None</option>";
            }
        }

        function preventPrevDate(){
        // dateJoined
            let date = new Date().toISOString().slice(0, 10);
            const startDateInput = document.getElementById('dateJoined');
            startDateInput.setAttribute('min', date);
        }
     
        function checkMatchPassword(){
        const newPass = document.getElementById('newPass').value;
        const confPass = document.getElementById('confPass').value;
        const getErrorP = document.getElementById('errorPw');
        const getForm = document.getElementById('changePass-Form');
        const submitBtn = document.getElementById('changePass-btn');

        if(newPass != confPass){
            if(!getErrorP){
                document.getElementById('confPass').style.borderColor = 'red';

                pElement = document.createElement('p');               
                pElement.setAttribute('id', 'errorPw');
                pElement.innerHTML = 'New Password Not Match';
                document.getElementById('confPass').after(pElement);

                submitBtn.disabled = true;
                submitBtn.style.backgroundColor = "#b6b8ba";
                submitBtn.style.color = "#5e19e7";
            }
        }else if(newPass == confPass){
            if(!getErrorP){
                return;
            }
            getForm.removeChild(getErrorP);
            submitBtn.disabled = false;
            submitBtn.removeAttribute('style', '');
        }
    }


    </script>
</body>

</html>