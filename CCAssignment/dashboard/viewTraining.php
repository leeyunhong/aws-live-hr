<?php
     session_start();
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }
     
     if(isset($_GET['delete'])){
        if($_GET['delete'] == 'successful'){
           echo '<script>alert("Training Class Deleted Successfully!");</script>';
        }else{
           echo '<script>alert("Training Class Deleted Failed!");</script>';
        }  
    }

    if(isset($_GET['edit'])){
        if($_GET['edit'] == 'successful'){
           echo '<script>alert("Training Class Edited Successfully!");</script>';
        }else{
           echo '<script>alert("Training Class Edited Failed!");</script>';
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Training Schedule</title>
    <link rel="stylesheet" href="../css/viewTraining.css">
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
                    <h1>View <span>Training Schedule</span></h1>
                    <?php
                            if($_SESSION['departmentID'] == 'DEPT003'){   
                    ?>
                    <div class="search-print-cont">
                        <div class="search-cont">
                            <input type="search" name="searchBar" id="searchBar" placeholder="Search by Department"
                                oninput="displaySearchResult();">
                            <input type="button" id="search-btn" value="Search">
                            <input type="button" id="reset-btn" value="Reset">
                            <div class="result-box">
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                    ?>
                    <div class="table">
                        <table>
                            <thead>
                                <th>Training ID</th>
                                <th>Training Title</th>
                                <th>Description</th>
                                <th>Department</th>
                                <th>Venue</th>
                                <th>Trainer</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <?php
                                if($_SESSION['departmentID'] == 'DEPT003'){
                                    echo "<th>Action</th>";
                                }
                                ?>
                            </thead>
                            <tbody id='tableBody'>                             
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

<script>
    putTrainingResult("");

    function getSearchBtn() {
        const getBtn = document.querySelector('#search-btn');
        if (getBtn) {
            getBtn.addEventListener('click', function () {
                if (document.getElementById('searchBar').value == "") {
                    alert("Please enter Department Name");
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
                    `<li class='search-result'>${respondResult[i].departmentID} : ${respondResult[i].departmentName}</li>`;
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
                url = '../php-inc/ajaxDepartmentName.php?department=' + getSearchInput;
            
            const response = await fetch(url);
            const data = await response.json();
            return data;
        }
    }

    document.getElementById('search-btn').addEventListener('click', () => {
        let departmentID = document.getElementById('searchBar').value;
        putTrainingResult(departmentID.substring(0,7));
    });

    document.getElementById('reset-btn').addEventListener('click', () => {
        putTrainingResult("");
        document.getElementById('searchBar').value = "";
    });

    async function fetchSession() {
        const response = await fetch('../php-inc/get_session.php');
        const data = await response.json();
        return data;
        console.log(data);
    }

    async function fetchTrainingData(departmentID) {
            try {
                let sessionData = await fetchSession();
                let url = "";

                if(sessionData[0].departmentID != "DEPT003"){
                    url = '../php-inc/ajaxTrainingDetails.php?departmentID=' + sessionData[0].departmentID;
                    const response1 = await fetch(url, {
                    method: 'GET',
                    });
                    const data1 = await response1.json();

                    return data1;
                }

                if(departmentID == ""){
                    url = '../php-inc/ajaxTrainingDetails.php?departmentID=all';
                }else{
                    url = '../php-inc/ajaxTrainingDetails.php?departmentID=' + departmentID;
                }
                          
                const response = await fetch(url, {
                    method: 'GET',
                });
                const data = await response.json();

                return data;
            } catch (error) {
                console.error(error);
            }
    }

    async function putTrainingResult(insert) {
            const getTableBody = document.querySelector('tbody');
            let getTrainingData;

            getTrainingData = await fetchTrainingData(insert);
            
            if (getTrainingData[0].trainingID != "") {
                let tbody = document.querySelector('#tableBody');
                removeAllChildNodes(tbody);

                //Set Data to Table Body
                for (let i = 0; i < getTrainingData.length; i++) {

                    //Add Action Button
                    let actionBtnWrap = "";
                    let sessionData = await fetchSession();

                    if(getTrainingData[i].endDate < new Date('YYYY-mm-dd')){
                        actionBtnWrap = `<td>
                                        <p>Training Class Has Ended</p>
                                    </td>`;
                    }else{
                        actionBtnWrap = `<td class="table-btn-group">
                                        <button class="table-edit-btn" onClick="window.location.href='../dashboard/editTraining.php?action=Edit&trainingID=${getTrainingData[i].trainingID}&departmentID=${getTrainingData[i].departmentID}'">Edit</button>
                                        <button class="table-delete-btn" onClick="window.location.href='../php-inc/deleteTraining-inc.php?trainingID=${getTrainingData[i].trainingID}&departmentID=${getTrainingData[i].departmentID}'">Delete</button>
                                    </td>`;
                    }

                    if(sessionData[0].departmentID == 'DEPT003'){
                        getTableBody.innerHTML += `
                    <tr>
                        <td class="column-max-width">${getTrainingData[i].trainingID}</td>
                        <td class="column-max-width">${getTrainingData[i].title}</td>
                        <td class="description">${getTrainingData[i].description}</td>
                        <td class="column-max-width">${getTrainingData[i].departmentName}</td>
                        <td class="column-max-width">${getTrainingData[i].venue}</td>
                        <td class="column-max-width">${getTrainingData[i].trainer}</td>
                        <td>${getTrainingData[i].startDate}</td>
                        <td>${getTrainingData[i].endDate}</td>
                        <td class="column-max-width">${getTrainingData[i].startTime}</td>
                        <td class="column-max-width">${getTrainingData[i].endTime}</td>
                        ${actionBtnWrap}
                    </tr>
                    `;
                    }else{
                        getTableBody.innerHTML += `
                    <tr>
                        <td class="column-max-width">${getTrainingData[i].trainingID}</td>
                        <td class="column-max-width">${getTrainingData[i].title}</td>
                        <td class="description">${getTrainingData[i].description}</td>
                        <td class="column-max-width">${getTrainingData[i].departmentName}</td>
                        <td class="column-max-width">${getTrainingData[i].venue}</td>
                        <td class="column-max-width">${getTrainingData[i].trainer}</td>
                        <td>${getTrainingData[i].startDate}</td>
                        <td>${getTrainingData[i].endDate}</td>
                        <td class="column-max-width">${getTrainingData[i].startTime}</td>
                        <td class="column-max-width">${getTrainingData[i].endTime}</td>
                    </tr>
                    `;
                    }

                    
                }       
            }else{
                alert('Currently Has No Training Yet!');
                document.getElementById('searchBar').value = "";
                return;     
            }
    }
</script>

</html>