<?php

include_once('../php-class/employee.php');

if(isset($_GET['employeeID'])){
    $feedbackMsg;

    $employeeID = $_GET['employeeID'];
    $employee = new Employee();
    $employee->setEmployeeID($employeeID);

    if($employee->deleteEmployee($employeeID)){
         $feedbackMsg = "Employee Deactivate Successfully";
    }else{
         $feedbackMsg = "Error Deactivate Employee";
    }

    echo json_encode($feedbackMsg);
    exit();
}

?>