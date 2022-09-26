<?php
    include ('../php-class/training.php');

    if(isset($_GET['trainingID'])){
        $training = new Training();
        $departmentID = $_GET['departmentID'];

        $training->setTrainingID($_GET['trainingID'])
        ->setDepartmentID($departmentID);

        if($training->deleteTraining()){
            header('Location: ../dashboard/viewTraining.php?delete=successful');
            exit();
        }else{
            header('Location: ../dashboard/viewTraining.php?delete=failed');
            exit();
        }
    }

?>