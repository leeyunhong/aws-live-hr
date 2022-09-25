<?php
     session_start();
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }
     if($_SESSION['departmentID'] != 'DEPT003'){
        header ('Location: ../dashboard/userProfile.php?authorize=0');
    }

    if(isset($_GET['status'])){
        if($_GET['status'] == 'updateSuccess'){
           echo '<script>alert("Leave Updated Successfully!");</script>';
        }else{
           echo '<script>alert("Leave Update Failed!");</script>';
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Application</title>
    <link rel="stylesheet" href="../css/viewLeave.css">
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
                    <h1>View <span>Leave Application</span></h1>
                    <div class="search-print-cont">
                        <div class="search-cont">
                                <input type="search" name="searchBar" id="searchBar" placeholder="Search by Name or IC"
                                    oninput="displaySearchResult();">
                                <input type="button" id="search-btn" value="Search">
                                <input type="button" id="reset-btn" value="Reset" >
                                <div class="result-box">                              
                                </div>
                        </div>
                    </div>

                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Submission <br> Date</th>
                                <th>Leave <br> Period</th>
                                <th>Total Day <br> of Leave</th>
                                <th>Support Document</th>
                                <th>Reason</th>
                                <th>Application <br> Status</th>
                                <th>Action</th>
                                </tr>            
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
    getSearchBtn();
    putLeaveResult("");

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
    
    document.getElementById('reset-btn').addEventListener('click', () => {
            putLeaveResult("");
    });

    document.getElementById('search-btn').addEventListener('click', () => {
            let employeeID = document.getElementById('searchBar').value;
            putLeaveResult(employeeID.substring(0,6));
    });

    async function fetchLeaveData(employeeID) {
            try {
                let url = "";

                if(employeeID == ""){
                    url = '../php-inc/ajaxGetLeaveApp.php?employeeID=all';
                }else{
                    url = '../php-inc/ajaxGetLeaveApp.php?employeeID=' + employeeID;
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

    async function putLeaveResult(insert) {
            const getTableBody = document.querySelector('tbody');
            let getLeaveData;

            getLeaveData = await fetchLeaveData(insert);
            
            if (getLeaveData[0].employeeID != ""|| getLeaveData[0].leaveAppID != "") {
                let tbody = document.querySelector('#tableBody');
                removeAllChildNodes(tbody);

                //Set Data to Table Body
                for (let i = 0; i < getLeaveData.length; i++) {
                    //Get total days leave taken
                    let totalDays = parseInt(getLeaveData[i].endDate.substring(8,10)) - parseInt(getLeaveData[i].startDate.substring(8,10)) + 1;

                    //Add Action Button
                    let actionBtnWrap = "";

                    if(getLeaveData[i].applicationStatus == "Approved" || getLeaveData[i].applicationStatus == "Rejected"){
                        actionBtnWrap = `<td>
                                        <p class="inactive">Action Has Taken</p>
                                    </td>`;
                    }else{
                        actionBtnWrap = `<td class="table-btn-group">
                                        <button class="table-approve-btn" onClick="window.location.href='../php-inc/actionOnLeave-inc.php?action=Approved&leaveAppID=${getLeaveData[i].leaveAppID}&employeeID=${getLeaveData[i].employeeID}'">Approve</button>
                                        <button class="table-reject-btn" onClick="window.location.href='../php-inc/actionOnLeave-inc.php?action=Rejected&leaveAppID=${getLeaveData[i].leaveAppID}&employeeID=${getLeaveData[i].employeeID}'">Reject</button>
                                    </td>`;
                    }

                    getTableBody.innerHTML += `
                    <tr>
                        <td class="column-max-width">${getLeaveData[i].leaveAppID}</td>
                        <td class="column-max-width">${getLeaveData[i].applyDate}</td>
                        <td>${getLeaveData[i].startDate} <br> to ${getLeaveData[i].endDate}</td>
                        <td>${totalDays}</td>
                        <td class="column-max-width"><a href="${getLeaveData[i].supportDocument}" download>Click To Download</a></td>
                        <td>${getLeaveData[i].leaveReason}</td>
                        <td>${getLeaveData[i].applicationStatus}</td>
                        ${actionBtnWrap}
                    </tr>
                    `;
                }
                
            }else{
                alert('Has no any application yet!');
                document.getElementById('searchBar').value = "";
                return;     
            }
    }
</script>

</html>