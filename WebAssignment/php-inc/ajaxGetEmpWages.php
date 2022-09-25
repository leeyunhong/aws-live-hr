<?php
include_once('../php-class/dbcontroller.php');


if(isset($_GET['employeeID'])){

    if(empty($_GET['employeeID'])){
        return false;
    } 

    $employeeID = $_GET['employeeID'];
    $db_handle = new DBController();
    $array = array();
    
    //Get Employee Details
    $empQuery = "SELECT * FROM employee WHERE employeeID = '$employeeID'";
    $empResults = $db_handle->runQuery($empQuery);
    
    if(!empty($empResults)){                                  
        $employeeID = $empResults[0]['employeeID'];
        $fullName = $empResults[0]['fullName'];
        $icNo = $empResults[0]['icNo'];
        $position = $empResults[0]['position'];
        $joinDate = $empResults[0]['joinDate'];
        $bankAccount = $empResults[0]['bankAccount'];

        //Get Wages Amount
        $wagesQuery = "SELECT * FROM wages WHERE employeeID = '$employeeID'";
        $wagesResults = $db_handle->runQuery($wagesQuery);

       // echo ($wagesResults[0]['basicWagesPerHour'] * 24 * 8);

       $basicSalary = (floor($wagesResults[0]['basicWagesPerHour'] * 24 * 8));
       $allowance = $wagesResults[0]['allowance'];
       $annualBonus = $wagesResults[0]['annualBonus'];

        $array[] = array(
            "employeeID" => $employeeID,
            "fullName" => $fullName,
            "icNo" => $icNo,
            "position" => $position,
            "joinDate" => $joinDate,
            "bankAccount" => $bankAccount,
            "basicSalary" => $basicSalary,
            "allowance" => $allowance,
            "annualBonus" => $annualBonus
        );

        //return json_encode($array);
        echo json_encode($array);
    }else{
        $array[] = array(
            "employeeID" => "",
            "fullName" => ""            
        ); 

        echo json_encode($array);
    }  
}



?>