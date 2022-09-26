<?php
     session_start();
     include ('../php-class/employee.php');
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }else{
        $employee = new Employee();
        $employeeID = $employee->setEmail($_SESSION['email']);
        $employeeResult = $employee->selectQuery();
     }
     
     if(isset($_GET['updateEmployee'])){
        if($_GET['updateEmployee'] == 'true'){
           echo '<script>alert("Employee Updated Successfully!");</script>';
        }else{
           echo '<script>alert("Employee Update Failed!");</script>';
        }  
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile_viewWages.css">
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
                        if(isset($_SESSION['fullName'])){
                            echo "<h3>Hi, <span>".$_SESSION['fullName']."</span></h3>";
                        }
                    ?>
                    <a href="../changePassword.php">Change Password</a>
                    <form action="../php-inc/logout-inc.php" method="get">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </div>
            </div>

            <div class="right-lower-cont">
                <div class="inner-cont">
                    <h1>Employee's <span>Profile</span></h1>
                    <!--Only for HR-->
                    <form action="../php-inc/editEmployee-inc.php" method="POST" enctype="multipart/form-data">
                        <?php
                            if($_SESSION['departmentID'] == 'DEPT003'){   
                        ?>
                        <div class="searchBar">
                            <div class="wrap-bar-btn">
                                <input type="search" name="searchBar" id="searchBar" placeholder="Search by Name or IC"
                                    oninput="displaySearchResult();">
                                <input type="button" id="search-btn" value="Search" onclick="putEmployeeResult();">
                            </div>
                            <div class="result-box">
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="left-form">
                            <label for="employeeid">Employee ID</label>
                            <?php
                                if(isset($_GET['id'])){
                            ?>
                            <input readonly required type="text" name="employeeid" id="id" value="<?php echo $_GET['id']?> ">

                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID'])  && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>

                            <input readonly type="text" required name="employeeid" id="id"
                                value="<?php echo $employeeResult[0]['employeeID'] ?> ">

                            <?php
                                } else {                            
                            ?>

                            <input readonly type="text" name="employeeid" id="id" required>

                            <?php   
                                }
                            ?>
                            
                            <label for="name">Employee Name</label>
                            <?php
                                if(isset($_GET['name'])){
                            ?>
                            <input readonly type="text" name="name" id="name" required
                                value="<?php echo $_GET['name']?> ">
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input readonly type="text" name="name" id="name" required
                                value="<?php echo $employeeResult[0]['fullName']?> ">
                            <?php    
                                } else {                            
                            ?>
                            <input readonly type="text" name="name" id="name" required>
                            <?php   
                                }
                            ?>
                            <label for="ic">IC Number</label>
                            <?php
                                if(isset($_GET['icNo']) && $_GET['icNo'] != 'notNumber' && $_GET['icNo'] != "used"){
                            ?>
                            <input readonly type="text" name="ic" id="ic" required value="<?php echo $_GET['icNo']?>"
                                maxlength="12">
                            <?php
                                } else if((isset($_GET['icNo']) && $_GET['icNo'] == "notNumber")){
                            ?>
                            <input readonly type="text" name="ic" id="ic" required maxlength="12">
                            <p class="error-msg">Please enter a valid IC number</p>

                            <?php
                                }else if((isset($_GET['icNo']) && $_GET['icNo'] == "used")){
                            ?>
                            <input readonly type="text" name="ic" id="ic" required maxlength="12">
                            <p class="error-msg">This IC already been used</p>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input readonly type="text" name="ic" id="ic" required
                                value="<?php echo $employeeResult[0]['icNo']?> ">
                            <?php
                                } else{
                            ?>
                            <input readonly type="text" name="ic" id="ic" required maxlength="12">
                            <?php
                            }
                            ?>
                            <label for="contact">Contact No.</label>
                            <?php
                            if ((isset($_GET['contactNo']) && $_GET['contactNo'] != "notNumber")) {
                            ?>
                            <input type="tel" name="contact" id="contact" readonly required maxlength="12"
                                value="<?php echo $_GET['contactNo']; ?>">
                            <?php
                            } else if((isset($_GET['contactNo']) && $_GET['contactNo'] == "notNumber")) {
                            ?>
                            <input type="tel" readonly name="contact" id="contact" required maxlength="12">
                            <p class="error-msg">Please enter a valid Contact Number</p>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input type="tel" name="contact" id="contact" readonly required maxlength="12"
                                value="<?php echo $employeeResult[0]['contactNo']?> ">
                            <?php
                            }else{
                            ?>
                            <input type="tel" readonly name="contact" id="contact" required maxlength="12">
                            <?php
                            }
                            ?>

                            <label for="email">Email</label>
                            <?php
                            if(isset($_GET['email'])) {
                            ?>
                            <input readonly type="email" name="email" id="email" required
                                value="<?php echo $_GET['email']; ?>">

                            <?php
                            } else if ((isset($_GET['emailExist']))) {
                            ?>
                            <input readonly type="email" name="email" id="email" required>
                            <p class="error-msg">The email is being used by others</p>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input readonly type="email" name="email" id="email" required
                                value="<?php echo $employeeResult[0]['email']?> ">
                            <?php
                            }else{
                            ?>
                            <input readonly type="email" name="email" id="email" required>
                            <?php
                            }
                            ?>
                            <label for="address">Home Address</label>

                            <?php
                            if (isset($_GET['address'])) {
                                echo '<textarea readonly name="address" id="address" cols="30" rows="5" required >' . $_GET['address'] . ' </textarea>';
                            } else if(((isset($employeeResult[0]['employeeID']) && $employeeResult[0]   ['departmentID'] != 'DEPT003'))) {
                            ?>
                            <textarea readonly name="address" id="address" cols="30" rows="5"
                                required><?php echo $employeeResult[0]['address']?></textarea>

                            <?php
                            }else{
                            ?>
                            <textarea readonly name="address" id="address" cols="30" rows="5" required></textarea>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="right-form">
                            <label for="department">Department</label>
                            <select name="department" id="department" onchange="insertManagerID();" disabled>
                                <?php
                                include_once('../php-class/dbcontroller.php');
                                $db_handle = new DBController();
                                $query = "SELECT * FROM department";
                                $results = $db_handle->runQuery($query);
                                for ($i = 0; $i < count($results); $i++) {
                                    if((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                                        if($results[$i]['departmentID'] == $employeeResult[0]['departmentID']){
                                            echo '<option value="' . $results[$i]['departmentID'] . '" selected>' . $results[$i]['departmentName'] . '</option>';
                                            break;
                                        }
                                    }else{
                                        echo "<option value='" . $results[$i]['departmentID'] . "'>" . $results[$i]['departmentName'] . "</option>";
                                    }                         
                                }
                                ?>
                            </select>
                            <label for="manager">Manager</label>
                            <select name="manager" id="manager" disabled>
                                <option value="None">None</option>
                                <?php
                                 if((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                                    include_once('../php-class/dbcontroller.php');
                                    $db_handle = new DBController();
                                    if($employeeResult[0]['managerID'] != "None"){
                                        $query = "SELECT * FROM employee WHERE employeeID = '" . $employeeResult[0]['managerID'] . "'";
                                        $results = $db_handle->runQuery($query);
                                        echo '<option value="' . $results[0]['employeeID'] . '" selected>' . $results[0]['fullName'] . '</option>';
                                    }
                                 }
                                ?>
                            </select>
                            <label for="position">Position</label>
                            <?php
                            if (isset($_GET['position'])) {
                            ?>
                            <input readonly type="text" name="position" id="position" required
                                value="<?php echo $_GET['position']; ?>">
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input readonly type="text" name="position" id="position" required
                                value="<?php echo $employeeResult[0]['position']?> ">
                            <?php
                            } else {
                            ?>
                            <input readonly type="text" name="position" id="position" required>
                            <?php
                            }
                            ?>
                            <label for="dateJoined">Date Joined</label>
                            <?php
                            if (isset($_GET['joinDate'])) {
                            ?>
                            <input type="date" name="dateJoined" value="<?php echo $_GET['joinDate']; ?>"
                                id="dateJoined" disabled required>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input type="date" name="dateJoined" value="<?php echo $employeeResult[0]['joinDate']?>"
                                id="dateJoined" disabled required>
                            <?php
                            } else {
                            ?>
                            <input readonly type="date" name="dateJoined" id="dateJoined" required>
                            <?php
                            }
                            ?>

                            <label for="salary">Basic Salary (RM)</label>
                            <?php
                            if ((isset($_GET['salary'])) && $_GET['salary'] != "notNumber") {
                            ?>
                            <input readonly type="text" name="salary" id="salary" required
                                value="<?php echo $_GET['salary']; ?>">
                            <?php
                            } else if((isset($_GET['salary']) && $_GET['salary'] == "notNumber")) {
                            ?>
                            <input readonly type="text" name="salary" id="salary" required>
                            <p class="error-msg"> Please enter valid number</p>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                                    include_once('../php-class/wages.php');
                                    $wages = new Wages();
                                    $wages->setEmployeeID($employeeResult[0]['employeeID']);
                                    $wagesResult = $wages->selectQuery();
                                    $totalWages = floor($wagesResult[0]['basicWagesPerHour'] * 24 * 8) + $wagesResult[0]['allowance'];
                            ?>
                            <input readonly type="text" name="salary" id="salary" required
                                value="<?php echo $totalWages?>">
                            <?php
                            }else{
                            ?>
                            <input readonly type="text" name="salary" id="salary" required>
                            <?php
                           }
                            ?>
                            <label for="bankAcc">Bank Account</label>
                            <?php
                            if ((isset($_GET['bankAccount'])) && $_GET['bankAccount'] != "notNumber") {
                            ?>
                            <input readonly type="text" name="bankAcc" id="bankAcc" required
                                value="<?php echo $_GET['bankAccount']; ?>">
                            <?php
                            } else if((isset($_GET['bankAccount'])) && $_GET['bankAccount'] == "notNumber") {
                            ?>
                            <input readonly type="text" name="bankAcc" id="bankAcc" required>
                            <p class="error-msg"> Please enter valid bank account</p>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                            ?>
                            <input readonly type="text" name="bankAcc" id="bankAcc" required
                                value="<?php echo $employeeResult[0]['bankAccount']?>">
                            <?php
                            }else{
                            ?>
                            <input readonly type="text" name="bankAcc" id="bankAcc" required>
                            <?php
                           }
                            ?>
                        </div>
                        <div class="btnBar">
                            <div class="profile-img">
                                <?php    
                                 if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){                            
                                        echo '<img src="' . $employeeResult[0]['profilePhoto'] . '" alt="Profile Picture" id="profile-pic" width="170" height="210">'; 
                                        
                                        if($employeeResult[0]['activeStatus'] == 1){
                                            echo '<p class="active">Active</p>';
                                        }else if($employeeResult[0]['activeStatus'] == 0){
                                            echo '<p class="inactive">Inactive</p>';
                                        }else{
                                            echo '<p class="unknown">Status</p>';
                                        }                            
                                 }else if (isset($_GET['photo'])) {
                                    echo '<img src="' . $_GET['photo'] . '" alt="Profile Picture" id="profile-pic" width="170" height="210">';  
                                                                     
                                    if($_GET['activeStatus'] == 1){
                                        echo '<p class="active">Active</p>';
                                    }else if($_GET['activeStatus'] == 0){
                                        echo '<p class="inactive">Inactive</p>';
                                    }else{
                                        echo '<p class="unknown">Status</p>';
                                    }       
                                 } else {
                                    echo '<img src="../img/profile-pic.png" alt="Profile Picture" id="profile-pic" width="170" height="210">';

                                    echo '<p class="unknown">Status</p>';
                                         
                                 }
                            ?>
                            </div>
                            <?php
                            
                                if($_SESSION['departmentID'] == 'DEPT003'){   
                            ?>
                            <div class="btn-class">

                                <input type="button" value="Edit" class="submit-btn" id="edit-Submit">
                                <!--Only for HR-->
                                <input type="button" value="Deactivate" name="delete" id="delete">
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <footer>

    </footer>
    <script>
         getUrl();
        getSearchBtn();

        function getUrl() {
            let url = window.location.href;
            if (url.search("name") != -1 && url.search("contactNo") != -1) {
                allowEdit();
            }
        }

        document.querySelector('body').addEventListener('click', function () {
            document.querySelector('.result-box').style.display = 'none';
        });

        function getSearchBtn() {
            const getBtn = document.querySelector('#search-btn');
            if (getBtn) {
                getBtn.addEventListener('click', function () {
                    if (document.getElementById('searchBar').value == "") {
                        alert("Please enter a name or IC number");
                    }
                });
            } else {
                return;
            }
        }

        //Click edit button
        document.getElementById('edit-Submit').addEventListener('click', (btn) => {
            if (btn.target.value == "Edit") {
                btn.preventDefault();
            } else if (btn.target.value == "Submit") {
                btn.defaultPrevented();
            }

            allowEdit();
        });

        function allowEdit() {
            const btn = document.getElementById('edit-Submit');
            const input = document.querySelectorAll(
                ' input[type="text"], input[type="tel"], input[type="email"], input[type="date"],.inner-cont textarea, select'
            );
            const getImageBox = document.querySelector('.profile-img');

            let word = btn.value;
            if (input[0].value != "" && input[1].value != "") {
                if (word == "Edit") {
                    word = btn.value = "Submit";
                    btn.setAttribute('type', 'submit');
                    btn.setAttribute('name', 'submit');
                    btn.style.backgroundColor = "#06b906";

                    //Create image for Image Box
                    createImgInput = document.createElement('input');
                    createImgInput.setAttribute('type', 'file');
                    createImgInput.setAttribute('name', 'profilePhoto');
                    createImgInput.setAttribute('id', 'image');
                    createImgInput.setAttribute('accept', 'image/*');
                    createImgInput.setAttribute('required', '');
                    createImgInput.setAttribute('style', 'max-width: 100px;');
                    getImageBox.appendChild(createImgInput);

                    //Remove disabled EXCEPT salary input
                    for (let i = 0; i < input.length; i++) {
                        if (input[i].id == "salary" || input[i].id == "id") {
                            continue;
                        } else {
                            input[i].removeAttribute('readonly');
                            input[i].removeAttribute('disabled');
                        }
                    }
                } else if (word == "Submit") {
                    word = btn.value = "Edit";
                    btn.removeAttribute('name');
                    btn.style.backgroundColor = "#5e19e7";
                    input.forEach((input) => {
                        btn.setAttribute('type', 'button');

                        if (input.id == 'manager' || input.id == 'department') {
                            input.setAttribute('disabled', "");
                        } else {
                            input.setAttribute('readonly', "");
                        }

                    });
                }
            } else {
                alert("Please select a employee through search box");
                return;
            }
        }


        //Search Result on Search Bar
        function inputSearchResult() {
            const getSearchResultArr = document.getElementsByClassName('search-result');
            const getSearchBar = document.getElementById('searchBar');
            const getResultBox = document.querySelector('.result-box');

            if (getSearchResultArr.length > 0) {
                for (let i = 0; i < getSearchResultArr.length; i++) {
                    getSearchResultArr[i].addEventListener('click', (btn) => {
                        getSearchBar.value = btn.target.innerText;
                        getResultBox.style.display = 'none';
                    });
                }
            } else {
                return;
            }
        }

        function removeAllChildNodes(parent) {
            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }
        }

        async function displaySearchResult() {
            const getResultBox = document.querySelector('.result-box');
            const respondResult = await searchBarData();
            let resultArr = [];

            if (respondResult === null || respondResult === undefined || respondResult.length == 0) {
                getResultBox.style.display = 'none';
                return;
            }
            //Clear the existing box
            removeAllChildNodes(getResultBox);
            if (respondResult !== null || respondResult !== undefined || respondResult.length != 0) {
                for (let i = 0; i < Object.keys(respondResult).length; i++) {
                    resultArr[i] =
                        `<li class='search-result'>${respondResult[i].employeeID}: ${respondResult[i].fullName}</li>`;
                }
            } else {
                getResultBox.style.display = 'none';
                return;
            }
            getResultBox.style.display = 'block';
            getResultBox.innerHTML = resultArr.join('');
            inputSearchResult();
        }

        async function searchBarData() {
            const getSearchInput = document.getElementById('searchBar').value;
            const getResultBox = document.querySelector('.result-box');
            let url;

            if (getSearchInput == '') {
                getResultBox.style.display = 'none';
                return;
            } else {
                if (Number.isInteger(parseInt(getSearchInput))) {
                    url = '../php-inc/ajaxSearchEmployee.php?icNo=' + getSearchInput;
                } else {
                    url = '../php-inc/ajaxSearchEmployee.php?fullName=' + getSearchInput;
                }
                const response = await fetch(url);
                const data = await response.json();
                return data;
            }
        }

        async function fetchEmpData(employeeID) {
            try {
                const url = '../php-inc/ajaxGetEmployee.php?employeeID=' + employeeID;
                const response = await fetch(url, {
                    method: 'GET',
                });
                const data = await response.json();

                return data;
            } catch (error) {
                console.error(error);
            }
        }

        function clearAllInputField() {
            const input = document.querySelectorAll('.left-form input, .right-form input, textarea');
            input.forEach((input) => {
                input.value = "";
            });
            clearImgBox();
        }

        function clearImgBox() {
            const profileImgBox = document.querySelector('.profile-img');
            removeAllChildNodes(profileImgBox);
        }

        async function putEmployeeResult() {
           
            const profileImgBox = document.querySelector('.profile-img');
            //Get all input field
            const getEmpIDInput = document.getElementById('id');
            const getEmpNameInput = document.getElementById('name');
            const getEmpICInput = document.getElementById('ic');
            const getEmpContactInput = document.getElementById('contact');
            const getEmpEmailInput = document.getElementById('email');
            const getEmpAddressInput = document.getElementById('address');
            const getEmpDepartmentInput = document.getElementById('department');
            const getEmpManagerInput = document.getElementById('manager');
            const getEmpPositionInput = document.getElementById('position');
            const getEmpDateJoinedInput = document.getElementById('dateJoined');
            const getEmpSalaryInput = document.getElementById('salary');
            const getEmpBankAccInput = document.getElementById('bankAcc');
            const departmentOption = Array.from(document.querySelectorAll('#department option'));

            const getEmployeeID = document.getElementById('searchBar').value;
            let employeeID = getEmployeeID.substring(0, 6);
            //Get Data From PHP
            const getEmployeeData = await fetchEmpData(employeeID);

            if (getEmployeeData[0].employeeID != ""|| getEmployeeData[0].fullName != "") {
                clearAllInputField();
                //Set Data to Input Field
                getEmpIDInput.value = getEmployeeData[0].employeeID;
                getEmpNameInput.value = getEmployeeData[0].fullName;
                getEmpICInput.value = getEmployeeData[0].icNo;
                getEmpContactInput.value = getEmployeeData[0].contactNo;
                getEmpEmailInput.value = getEmployeeData[0].email;
                getEmpAddressInput.value = getEmployeeData[0].address;

                //Selection for department
                const departmentToSelect = departmentOption.find((option) => {
                    if (option.innerText == getEmployeeData[0].department) {
                        return option;
                    }
                });
                getEmpDepartmentInput.value = departmentToSelect.value;

                //Create option for manager
                createOption = document.createElement('option');
                createOption.setAttribute('value', getEmployeeData[0].manager);
                createOption.innerText = getEmployeeData[0].manager;
                getEmpManagerInput.append(createOption);
                getEmpManagerInput.value = getEmployeeData[0].manager;

                getEmpPositionInput.value = getEmployeeData[0].position;
                getEmpDateJoinedInput.value = getEmployeeData[0].joinDate;
                getEmpSalaryInput.value = getEmployeeData[0].wages;
                getEmpBankAccInput.value = getEmployeeData[0].bankAccount;

                //Set Profile Picture  
                let createImg = document.createElement('img');
                createImg.setAttribute('src', getEmployeeData[0].profilePhoto);
                createImg.setAttribute('alt', 'Profile Picture');
                createImg.setAttribute('id', 'profile-pic');
                createImg.setAttribute('width', '170');
                createImg.setAttribute('height', '210');
                profileImgBox.appendChild(createImg);

                //Set Active Status - P Tag
                let createP = document.createElement('p');
                if (getEmployeeData[0].activeStatus == 1) {
                    createP.innerHTML = 'Active';
                    createP.classList.add('active');
                    profileImgBox.appendChild(createP);
                } else {
                    createP.innerHTML = 'Inactive';
                    createP.classList.add('inactive');
                    profileImgBox.appendChild(createP);
                }
            }else{
                alert('Employee Not Found!');
                document.getElementById('searchBar').value = "";
                return;  
            }
        }

        async function fetchDepartmentMng() {
            const departmentID = document.getElementById('department').value;
            const getManagerPhp = '../php-inc/ajaxDepartmentMng.php?departmentID=' + departmentID;

            let getEmployeeRespond = await fetch(getManagerPhp);
            let managerObj = await getEmployeeRespond.json();
            return managerObj;
        }

        //Calling async function need to be async as well
        async function insertManagerID() {
            const managerSelect = document.getElementById('manager');
            const managerObj = await fetchDepartmentMng();

            if (Object.keys(managerObj).length != 0) {
                for (let i = 0; i < managerObj.length; i++) {
                    managerSelect.innerHTML += "<option value='" + managerObj[i].employeeID + "'>" + managerObj[i]
                        .fullName + "</option>";
                }              
            } else {
                managerSelect.innerHTML = "<option value='None'>None</option>";
            }
        }

        document.querySelector('#delete').addEventListener('click', async function () {        
            const getEmployeeID = document.getElementById('id').value;

            if(getEmployeeID == ""){
                alert('Please select employee to delete!');
                return;
            }else{
                let confirmation = confirm('Are you sure you want to deactivate this employee?');

                if (confirmation == true) {
                    const deleteEmployeePhp = '../php-inc/ajaxDeleteEmployee.php?employeeID=' + getEmployeeID;
                    let deleteEmployeeRespond = await fetch(deleteEmployeePhp);
                    let deleteEmployeeData = await deleteEmployeeRespond.json();
                    let parsedData = JSON.stringify(deleteEmployeeData);

                    alert(parsedData.replace('"', '').replace('"', ''));
                    location.reload();
                }
            }          
        });
    </script>
</body>

</html>