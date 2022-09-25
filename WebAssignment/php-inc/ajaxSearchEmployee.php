<?php
    include_once('../php-class/dbcontroller.php');

    if((isset($_GET))){
        $query = "";
        if(isset($_GET['fullName'])){
            $fullName = $_GET['fullName'];
            $query = "SELECT * FROM employee WHERE fullName LIKE '%$fullName%'";

        }else if (isset($_GET['icNo'])){
            $icNo = $_GET['icNo'];
            $query = "SELECT * FROM employee WHERE icNo = '$icNo'";
        }
        
        $db_handle = new DBController();
        $results = $db_handle->runQuery($query);
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