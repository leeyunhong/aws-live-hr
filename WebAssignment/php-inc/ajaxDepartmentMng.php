<?php

include_once('../php-class/dbcontroller.php');

if(isset($_GET['departmentID'])){
    $departmentID = $_GET['departmentID'];
    $db_handle1 = new DBController();
    $query = "SELECT * FROM employee WHERE departmentID = '$departmentID' AND position = 'Manager'";
    $results = $db_handle1->runQuery($query);
    $array = array();

    if(!empty($results)){
        for($i = 0; $i < count($results); $i++) {                        
            $employeeID = $results[$i]['employeeID'];
            $fullName = $results[$i]['fullName'];
      
            $array[] = array(
                'employeeID' => $employeeID,
                'fullName' => $fullName
              );
          }
   }       
    echo json_encode($array);
    exit();
}

?>