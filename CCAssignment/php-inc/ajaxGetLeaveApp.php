<?php
include_once('../php-class/leave.php');

if(isset($_GET['employeeID'])){
    $db_control = new DBController();

    $newLeave = new Leave();
    $leaveResult = "";

    //For reset
    if($_GET['employeeID'] == 'all'){
        $leaveResult = $db_control->runQuery("SELECT * FROM leaveapplication");
    }else{
        //For specific employee
        $newLeave->setEmployeeID($_GET['employeeID']);
        $leaveResult = $newLeave->selectQuery();
    }

    if(!empty($leaveResult)){
        //Store in an array with assign key
        $array = array();

        foreach($leaveResult as $row){
            $leaveAppID = $row['leaveAppID'];
            $employeeID = $row['employeeID'];
            $applyDate = $row['applyDate'];
            $startDate = $row['startDate'];
            $endDate = $row['endDate'];
            $leaveReason = $row['leaveReason'];
            $supportDocument = $row['supportDocument'];
            $applicationStatus = $row['applicationStatus'];

            $array[] = array(
                "leaveAppID" => $leaveAppID,
                "employeeID" => $employeeID,
                "applyDate" => $applyDate,
                "startDate" => $startDate,
                "endDate" => $endDate,
                "leaveReason" => $leaveReason,
                "supportDocument" => $supportDocument,
                "applicationStatus" => $applicationStatus
            );
        }

        echo json_encode($array);

    }else{
        $array[] = array(
            "employeeID" => "",
            "leaveAppID" => ""            
        ); 

        echo json_encode($array);
    }
}

?>