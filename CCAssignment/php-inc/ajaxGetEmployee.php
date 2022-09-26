<?php
include_once('../php-class/dbcontroller.php');

if(isset($_GET['employeeID'])){

    if(empty($_GET['employeeID'])){
        return false;
    } 

    $employeeID = $_GET['employeeID'];
    $db_handle = new DBController();
    $array = array();
    $empQuery = "";
    
    //Get Employee Details
    if($employeeID == 'all'){
        $empQuery = "SELECT * FROM employee";
    }else{
        $empQuery = "SELECT * FROM employee WHERE employeeID = '$employeeID'";
    }
   
    $empResults = $db_handle->runQuery($empQuery);
    
    if(!empty($empResults)){    
        foreach($empResults as $employee){
            $employeeID = $employee['employeeID'];
            $fullName = $employee['fullName'];
            $icNo = $employee['icNo'];
            $email = $employee['email'];
            $contactNo = $employee['contactNo'];
            $address = $employee['address'];
            $position = $employee['position'];
            $joinDate = $employee['joinDate'];
            $bankAccount = $employee['bankAccount'];
            $activeStatus = $employee['activeStatus'];
            $profilePhoto = $employee['profilePhoto'];
            $managerID = $employee['managerID'];
            $departmentID = $employee['departmentID'];

            //Get Wages Amount
            $wagesQuery = "SELECT * FROM wages WHERE employeeID = '$employeeID'";
            $wagesResults = $db_handle->runQuery($wagesQuery);

        $totalSalary = (ceil($wagesResults[0]['basicWagesPerHour'] * 24 * 8)) + $wagesResults[0]['allowance'];

            //Get Manager Name
            if($managerID == 'None'){
                $managerName = 'None';
            }else{
                $managerQuery = "SELECT * FROM employee WHERE managerID = '$managerID'";
                $managerResults = $db_handle->runQuery($managerQuery);
                $managerName = $managerResults[0]['fullName'];
            }
            
            //Get Department Name
            $departmentQuery = "SELECT * FROM department WHERE departmentID = '$departmentID'";
            $departmentResults = $db_handle->runQuery($departmentQuery);
            $departmentName = $departmentResults[0]['departmentName'];

            $array[] = array(
                "employeeID" => $employeeID,
                "fullName" => $fullName,
                "icNo" => $icNo,
                "email" => $email,
                "contactNo" => $contactNo,
                "address" => $address,
                "position" => $position,
                "joinDate" => $joinDate,
                "bankAccount" => $bankAccount,
                "activeStatus" => $activeStatus,
                'profilePhoto' => $profilePhoto,
                "wages" => $totalSalary,
                "manager" => $managerName,
                "department" => $departmentName
            ); //JSON - javascript object notation
        }

        echo json_encode($array);
    }else{
        $array[] = array(
            "employeeID" => "",
            "fullName" => ""            
        ); 

        echo json_encode($array);
    }  
}
