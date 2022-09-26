<?php
    include ('../php-class/leave.php');

    if(isset($_GET['leaveAppID'])){
        $leaveAppID = $_GET['leaveAppID'];
        $employeeID = $_GET['employeeID'];
        $action = $_GET['action'];
        $leave = new Leave();
        $leave->setLeaveAppID($leaveAppID);
        
        if($leave->updateLeaveStatus($action, $employeeID)){
            header("Location: ../dashboard/viewLeave.php?status=updateSuccess");
            exit();
        }else{
            header("Location: ../dashboard/viewLeave.php?status=updateFailed");
            exit();
        }
    }

?>