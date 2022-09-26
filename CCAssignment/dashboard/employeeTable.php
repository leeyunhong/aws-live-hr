<?php
     session_start();
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }
     if($_SESSION['departmentID'] != 'DEPT003'){
        header ('Location: ../dashboard/userProfile.php?authorize=0');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link rel="stylesheet" href="../css/employeeTable.css">
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
                    <h1>Employee <span>List</span></h1>
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
                                <th>Employee ID</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Name</th>
                                <th>IC Number</th>
                                <th>Contact Number</th>
                                <th class="min-width">Email</th>   
                                <th>Date Joined</th>                                        
                                <th>Active Status</th>                        
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
    putEmployeeResult("");

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
            putEmployeeResult("");
    });

    document.getElementById('search-btn').addEventListener('click', () => {
            let employeeID = document.getElementById('searchBar').value;
            putEmployeeResult(employeeID.substring(0,6));
    });

    async function fetchEmployeeData(employeeID) {
            try {
                let url = "";

                if(employeeID == ""){
                    url = '../php-inc/ajaxGetEmployee.php?employeeID=all';
                }else{
                    url = '../php-inc/ajaxGetEmployee.php?employeeID=' + employeeID;
                }
                          
                let response = await fetch(url).then(response => response.json());
              //  let data = await response.json();

                return response;
            } catch (error) {
                console.error(error);
            }
    }

    async function putEmployeeResult(insert) {
            const getTableBody = document.querySelector('tbody');
           
            let getEmpData = await fetchEmployeeData(insert);
            console.log(getEmpData);
            
            if (getEmpData[0].employeeID != ""|| getEmpData[0].fullName != "") {
                let tbody = document.querySelector('#tableBody');
                removeAllChildNodes(tbody);

                //Set Data to Table Body
                for (let i = 0; i < getEmpData.length; i++) {

                    //Add Action Button
                    let actionBtnWrap = "";

                    if(getEmpData[i].activeStatus == "0"){
                        actionBtnWrap = `<td>
                                        <p class="inactive">Inactive</p>
                                    </td>`;
                    }else{
                        actionBtnWrap = `<td>
                                        <p class="active">Active</p>
                                    </td>`;
                    }

                    getTableBody.innerHTML += `
                    <tr>
                        <td class="column-max-width">${getEmpData[i].employeeID}</td>
                        <td class="column-max-width">${getEmpData[i].department}</td>
                        <td>${getEmpData[i].position}</td>
                        <td>${getEmpData[i].fullName}</td>
                        <td class="column-max-width">${getEmpData[i].icNo}</td>
                        <td>${getEmpData[i].contactNo}</td>
                        <td class="min-width"><a href="mailto:${getEmpData[i].email}">Email Employee</a></td>
                        <td>${getEmpData[i].joinDate}</td>                
                        ${actionBtnWrap}
                    </tr>
                    `;
                }
                
            }else{
                alert('Your company has no employee yet!');
                document.getElementById('searchBar').value = "";
                return;     
            }
    }
</script>

</html>