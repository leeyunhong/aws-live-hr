<?php
    include ('../php-class/dbcontroller.php');

    if(isset($_GET)){
     
        $department = $_GET['department'];
        $query = "SELECT * FROM department WHERE departmentName LIKE '%$department%'";
        
        $db_handle = new DBController();
        $results = $db_handle->runQuery($query);
        $array = array();
    
        if(!empty($results)){
            for($i = 0; $i < count($results); $i++) {                        
                $departmentName = $results[$i]['departmentName'];    
                $departmentID = $results[$i]['departmentID'];         
          
                $array[] = array(
                    'departmentName' => $departmentName,
                    'departmentID' => $departmentID
                );                
              }
       }       
        echo json_encode($array);
        exit();
    }
?>