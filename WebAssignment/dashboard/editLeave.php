<?php
     session_start();
     if(!isset($_SESSION['employeeID'])){
         header ('Location: ../home.php?login=invalid');
     }

     if(isset($_GET['status'])){
        if($_GET['status'] == 'updateSuccess'){
           echo '<script>alert("Leave Edited Successfully!");</script>';
        }else{
           echo '<script>alert("Leave Edited Failed!");</script>';
        }  
    }

    if(isset($_GET['delete'])){
        if($_GET['delete'] == 'success'){
           echo '<script>alert("Leave Delete Successfully!");</script>';
        }else{
           echo '<script>alert("Leave Delete Failed!");</script>';
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave Application</title>
    <link rel="stylesheet" href="../css/editLeave.css">
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
                    <h1>Edit <span>Leave Application</span></h1>
                    <form action="../php-inc/updateLeave-inc.php" method="post" enctype="multipart/form-data">
                        <div class="left-form">
                        <label for="employeeid">Employee ID</label>
                            <input type="text" name="employeeid" id="id" readonly
                            <?php
                                if(isset($_SESSION['employeeID'])){
                                    echo "value='".$_SESSION['employeeID']."'";
                                }
                            ?>
                            >
                            <label for="name">Employee Name</label>
                            <input type="text" name="name" id="name" readonly
                            <?php
                                if(isset($_SESSION['fullName'])){
                                    echo "value='".$_SESSION['fullName']."'";
                                }
                            ?>
                            >
                            <label for="date">Date</label>
                            <div class="input-date-range">
                                <?php if(isset($_GET['startdate'])){
                                 ?>   
                                    <input type="date" name="startdate" id="startdate" required onchange="checkDateValid();" value="<?php echo $_GET['startdate']; ?>">
                                 
                                 <?php
                                }else{
                                ?>
                                        <input disabled type="date" name="startdate" id="startdate" required onchange="checkDateValid();">
                                <?php
                                }
                                ?>                          
                                <span> - </span>
                                <?php if(isset($_GET['enddate'])){
                                 ?>   
                                    <input type="date" name="enddate" id="enddate" required onchange="checkDateValid();" value="<?php echo $_GET['enddate']; ?>">
                                 
                                 <?php
                                }else{
                                ?>
                                        <input disabled type="date" name="enddate" id="enddate" required onchange="checkDateValid();">
                                <?php
                                }
                                ?>
                            </div>                            
                            <label>New Evidence Upload</label>
                            <?php if(isset($_GET['file']) && $_GET['file'] == 'error'){
                                 ?>   
                                    <input id="uploadFile" type="file" name="file" accept="image/*,.pdf" required>
                                    <p class="error">Only Accept PDF, JPEG, JPG and PNG, Size Less Than 15MB</p>
                                 
                            <?php
                                }else{
                            ?>
                                        <input disabled id="uploadFile" type="file" name="file" accept="image/*,.pdf" required>
                            <?php
                                }
                            ?>
                            
                            <label for="reason">Leave Reason (Less than 50 words)</label>
                            <?php if(isset($_GET['leaveReason'])){                                   
                            ?>   
                                    <textarea name="reason" id="reason" cols="30" rows="5" required><?php echo $_GET['leaveReason'] ?></textarea>
                                 
                            <?php
                                }else{
                            ?>
                                        <textarea disabled name="reason" id="reason" cols="30" rows="5" required></textarea>
                            <?php
                                }
                            ?>
                        </div>

                        <div class="btnBar">

                            <div class="btn">
                            <?php if(isset($_GET['file'])){                                   
                            ?>   
                                    <input type="submit" value="Submit" name="submitLeave" class="submit-btn" id="submit">
                                <input type="reset" value="Reset" name="reset" id="reset">
                                 
                            <?php
                                }else{
                            ?>
                                        <input type="submit" disabled style="background-color: #f2f2f2;" value="Submit" name="submitLeave" class="submit-btn" id="submit">
                                        <input type="reset" disabled style="background-color: #f2f2f2;" value="Reset" name="reset" id="reset">
                            <?php
                                }
                            ?>                             
                            </div>
                        </div>
                    </form>

                    <div class="table">
                        <table>
                            <thead>
                                <th>#</th>
                                <th>Submission <br> Date</th>
                                <th>Leave <br> Period</th>
                                <th>Total Day <br> of Leave</th>
                                <th>Support Document</th>
                                <th>Reason</th>
                                <th>Application <br> Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody id='tableBody'>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <footer>

    </footer>
    <script src="../js/editLeave.js"></script>
    <script>
      putLeaveResult();
    
        async function fetchLeaveData(employeeID) {
            try {             
                let url = '../php-inc/ajaxGetLeaveApp.php?employeeID=' + employeeID;
                
                const response = await fetch(url).then(response => response.json());

                return response;
            } catch (error) {
                console.error(error);
            }
        }

        function removeAllChildNodes(parent) {
            while (parent.hasChildNodes()) {
                parent.removeChild(parent.firstChild);
            }
        }

       async function editLeave(rowNo) {
            const getStartDate = document.getElementById('startdate');
            const getEndDate = document.getElementById('enddate');
            const getReason = document.getElementById('reason');
            const getAllRow = document.querySelectorAll('#tableBody tr');

            const getAllInput = document.querySelectorAll('#submit , #reset, #startdate, #enddate, #reason, #uploadFile');

            getAllInput.forEach(input => {
                input.disabled = false;

                if(input.id == 'submit'){
                    input.style.backgroundColor = '#06b906';
                    
                }else if(input.id == 'reset'){
                    input.style.backgroundColor = '#5e19e7';
                }
            });

           for (let i = 0; i < getAllRow.length; i++) {
                if(i == rowNo){
                    const getLeaveID = getAllRow[i].children[0].innerHTML;
                    const dateRange = getAllRow[i].children[2].innerHTML;
                    const reason = getAllRow[i].children[5].innerHTML;
                    
                    const dateRangeSplit = dateRange.split(' <br> to ');
                    getStartDate.value = dateRangeSplit[0];
                    getEndDate.value = dateRangeSplit[1];
                    getReason.value = reason;
                    
                    //Set leaveAppID to session
                    let putSession = await fetch('../php-inc/set_session.php?leaveAppID=' + getLeaveID);
                    let putSessionData = await putSession.json();

                }            
           }
        }

        async function putLeaveResult() {
            const getTableBody = document.querySelector('tbody');

            let employeeID = document.querySelector('#id').value;
            let getLeaveData = await fetchLeaveData(employeeID);
          
            if (getLeaveData[0].employeeID != "" || getLeaveData[0].leaveAppID != "") {

                let tbody = document.querySelector('#tableBody');
                removeAllChildNodes(tbody);
               
                //Set Data to Table Body
                for (let i = 0; i < getLeaveData.length; i++) {
                    //Get total days leave taken
                    let totalDays = parseInt(getLeaveData[i].endDate.substring(8, 10)) - parseInt(getLeaveData[i]
                        .startDate.substring(8, 10)) + 1;

                    //Add Action Button
                    let actionBtnWrap = "";

                    if (getLeaveData[i].applicationStatus == "Approved" || getLeaveData[i].applicationStatus == "Rejected") {
                        actionBtnWrap = `<td>
                                            <p>Action Has Taken</p>
                                        </td>`;
                    } else {
                        actionBtnWrap = `<td class="table-btn-group">
                                        <button class="table-edit-btn" onClick="editLeave(${i}); ">Edit</button>
                                        <button class="table-delete-btn" onClick="window.location.href='../php-inc/deleteLeave-inc.php?leaveAppID=${getLeaveData[i].leaveAppID}'">Delete</button>
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

            } else {
                alert('You Have No Any Leave Yet');               
                return;
            }
        }
    </script>
    
      

</body>

</html>