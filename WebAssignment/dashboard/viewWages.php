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

     if((isset($_GET['edit']))){
        if($_GET['edit'] == 'success'){
            echo '<script>alert("Employee Wages Updated Successfully!");</script>';
        }else{
            echo '<script>alert("Employee Wages Update Failed!");</script>';
        }
     }
     

     
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Wages</title>
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
                    <h1>Employee's <span>Wages</span></h1>
                    <form action="../php-inc/editWages-inc.php" method="POST">
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
                            <input readonly required type="text" name="employeeid" id="id"
                                value="<?php echo $employeeResult[0]['employeeID'] ?> ">
                            <?php
                                } else {                            
                            ?>
                            <input readonly required type="text" name="employeeid" id="id">
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
                            <label for="ic">IC Number</label>                            <?php
                                if(isset($_GET['icNo']) && $_GET['icNo'] != 'notNumber'){
                            ?>
                            <input readonly type="text" name="ic" id="ic" required value="<?php echo $_GET['icNo']?>"
                                maxlength="12">
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
                            <label for="bankAcc">Bank Account</label>
                            <?php
                            if ((isset($_GET['bankAccount'])) && $_GET['bankAccount'] != "notNumber") {
                            ?>
                            <input readonly type="text" name="bankAcc" id="bankAcc" required
                                value="<?php echo $_GET['bankAccount']; ?>">
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
                        <div class="right-form">
                            <label for="salary">Basic Salary (RM)</label>
                            <?php
                            if ((isset($_GET['salary'])) && $_GET['salary'] != "notNumber") {
                            ?>
                            <input type="text" name="salary" id="salary" required
                                value="<?php echo $_GET['salary']; ?>">
                            <?php
                            } else if((isset($_GET['salary']) && $_GET['salary'] == "notNumber")) {
                            ?>
                            <input type="text" name="salary" id="salary" required>
                            <p class="error-msg"> Please enter valid number</p>
                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                                    include_once('../php-class/wages.php');
                                    $wagesSalary = new Wages();
                                    $wagesSalary->setEmployeeID($employeeResult[0]['employeeID']);
                                    $wagesResult = $wagesSalary->selectQuery();
                                    $totalWages = floor($wagesResult[0]['basicWagesPerHour'] * 24 * 8);
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
                            <label for="allowance">Allowance</label>
                            <!-- <input readonly type="text" name="allowance" id="allowance" required> -->
                            <?php
                                if ((isset($_GET['allowance'])) && $_GET['allowance'] != "notNumber") {
                            ?>
                            <input type="text" name="allowance" id="allowance" required value="<?php echo $_GET['allowance']; ?>">

                            <?php
                                } else if((isset($_GET['allowance']) && $_GET['allowance'] == "notNumber")) {
                            ?>
                                <input type="text" name="allowance" id="allowance" required>
                                <p class="error-msg"> Please enter valid number</p>

                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                                    include_once('../php-class/wages.php');
                                    $wagesAllowance = new Wages();
                                    $wagesAllowance->setEmployeeID($employeeResult[0]['employeeID']);
                                    $wagesResult = $wagesAllowance->selectQuery();
                                    $allowance = $wagesResult[0]['allowance'];
                            ?>
                                 <input readonly type="text" name="allowance" id="allowance" required value="<?php echo $allowance; ?>">
                            <?php
                            }else{
                            ?>
                                <input readonly type="text" name="allowance" id="allowance" required>

                            <?php
                            }
                            ?>
                            <label for="annualBonus">Annual Bonus</label>
                            <!-- <input readonly type="text" name="annualBonus" id="annualBonus" required> -->
                            <?php
                                if ((isset($_GET['annualBonus'])) && $_GET['annualBonus'] != "notNumber") {
                            ?>
                            <input type="text" name="annualBonus" id="annualBonus" required value="<?php echo $_GET['annualBonus']; ?>">

                            <?php
                                } else if((isset($_GET['annualBonus']) && $_GET['annualBonus'] == "notNumber")) {
                            ?>
                                <input type="text" name="annualBonus" id="annualBonus" required>
                                <p class="error-msg"> Please enter valid number</p>

                            <?php    
                                }else if ((isset($employeeResult[0]['employeeID']) && $employeeResult[0]['departmentID'] != 'DEPT003')){
                                    include_once('../php-class/wages.php');
                                    $wagesBonus = new Wages();
                                    $wagesBonus ->setEmployeeID($employeeResult[0]['employeeID']);
                                    $wagesResult = $wagesBonus->selectQuery();
                                    $annualBonus = $wagesResult[0]['annualBonus'];
                            ?>
                                 <input readonly type="text" name="annualBonus" id="annualBonus" required value="<?php echo $annualBonus; ?>">
                            <?php
                            }else{
                            ?>
                                <input readonly type="text" name="annualBonus" id="annualBonus" required>

                            <?php
                            }
                            ?>

                        </div>
                        <div class="btnBar">
                        <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){   
                                    if((isset($_GET['annualBonus'])) || (isset($_GET['salary'])) || (isset($_GET['allowance']))){
                        ?>
                                <div class="btn-class">
                                <input type="submit" value="Submit" name="edit" class="submit-btn" id="edit-Submit" style="background-color:#06b906;">
                                </div>
                        <?php
                        }else{
                        ?>
                            <!--Only for HR-->
                            <div class="btn-class">
                                <input type="button" value="Edit" class="submit-btn" id="edit-Submit">
                            </div>
                        <?php
                                }
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
        getSearchBtn()

        document.querySelector('body').addEventListener('click', function () {
            document.querySelector('.result-box').style.display = 'none';
        });

        document.getElementById('edit-Submit').addEventListener('click', (btn) => {
           
            if (btn.target.value == "Edit") {
                btn.preventDefault();
            } 
            else if (btn.target.value == "Submit") {
                btn.defaultPrevented();
            }
            allowEdit();
        });

        function allowEdit() {
            const btn = document.getElementById('edit-Submit');
            const input = document.querySelectorAll(
                ' #salary, #allowance, #annualBonus'
            );

            let word = btn.value;
            if (input[0].value != "" && input[1].value != "") {
                if (word == "Edit") {
                    word = btn.value = "Submit";
                    btn.setAttribute('name', 'edit');
                    btn.setAttribute('type', 'submit');
                    btn.style.backgroundColor = "#06b906";
                    input.forEach((input) => {
                    input.removeAttribute('readonly');
                });
                } else if (word == "Submit") {
                    word = btn.value = "Edit";
                    btn.style.backgroundColor = "#5e19e7";
                    input.forEach((input) => {
                    btn.setAttribute('type', 'button');
                    input.setAttribute('readonly', "");
                });
                }
            } else {
                alert("Please select a employee through search box");
                return;
            }
        }

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

        function clearAllInputField() {
            const input = document.querySelectorAll('.left-form input, .right-form input, textarea');
            input.forEach((input) => {
                input.value = "";
            });
        }

        async function fetchEmpWagesData(employeeID) {
            try {
                const url = '../php-inc/ajaxGetEmpWages.php?employeeID=' + employeeID;
                const response = await fetch(url, {
                    method: 'GET',
                });
                const data = await response.json();

                return data;
            } catch (error) {
                console.error(error);
            }
        }

        async function putEmployeeResult() {
            
            //Get all input field
            const getEmpIDInput = document.getElementById('id');
            const getEmpNameInput = document.getElementById('name');
            const getEmpICInput = document.getElementById('ic');
            const getEmpDateJoinedInput = document.getElementById('dateJoined');
            const getEmpPositionInput = document.getElementById('position');
            const getEmpBankAccInput = document.getElementById('bankAcc');
            const getEmpSalaryInput = document.getElementById('salary');
            const getAllowanceInput = document.getElementById('allowance');
            const getAnnualBonusInput = document.getElementById('annualBonus');

            const getEmployeeID = document.getElementById('searchBar').value;
            let employeeID = getEmployeeID.substring(0, 6);
            //Get Data From PHP
            const getEmpWagesData = await fetchEmpWagesData(employeeID);
            console.log(getEmpWagesData);

            if (getEmpWagesData[0].employeeID != ""|| getEmpWagesData[0].fullName != "") {
                clearAllInputField();
                //Set Data to Input Field
                getEmpIDInput.value = getEmpWagesData[0].employeeID;
                getEmpNameInput.value = getEmpWagesData[0].fullName;
                getEmpICInput.value = getEmpWagesData[0].icNo;
                getEmpDateJoinedInput.value = getEmpWagesData[0].joinDate;
                getEmpPositionInput.value = getEmpWagesData[0].position;
                getEmpBankAccInput.value = getEmpWagesData[0].bankAccount;
                getEmpSalaryInput.value = getEmpWagesData[0].basicSalary;
                getAllowanceInput.value = getEmpWagesData[0].allowance;
                getAnnualBonusInput.value = getEmpWagesData[0].annualBonus;
            }else{
                alert('Employee Not Found!');
                document.getElementById('searchBar').value = "";
                return;     
            }
        }
    </script>
</body>

</html>