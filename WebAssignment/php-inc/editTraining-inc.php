<?php

include("../php-class/training.php");

    if((isset($_POST['trainingID'])) && (isset($_POST['departmentID']))){
        $training = new Training();

        $trainingID = $_POST['trainingID'];
        $departmentID = $_POST['departmentID'];
        $trainingTitle = $_POST['trainingTitle'];
        $description = $_POST['description'];
        $trainer = $_POST['trainer'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $venue = $_POST['venue'];

        $training->setTrainingID($trainingID)
                ->setDepartmentID($departmentID)
                ->setTitle($trainingTitle)
                ->setDescription($description)  
                ->setTrainer($trainer)
                ->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setStartTime($startTime)
                ->setEndTime($endTime)
                ->setVenue($venue);

        if($training->editTraining()){
            header('Location: ../dashboard/viewTraining.php?edit=successful');
            exit();
        }else{
            header('Location: ../dashboard/viewTraining.php?edit=failed');
            exit();
        }
    }

?>