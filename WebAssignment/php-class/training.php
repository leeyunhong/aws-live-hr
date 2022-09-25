<?php

include_once ('dbcontroller.php');

class Training{

    private $trainingID, $title, $description, $trainer, $startDate, $endDate, $startTime, $endTime, $venue, $employeeID, $departmentID;

    public function __construct(){
        $this->trainingID = '';
        $this->title = '';
        $this->description = '';
        $this->trainer = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->startTime = '';
        $this->endTime = '';
        $this->venue = '';
        $this->employeeID = '';
        $this->departmentID = '';
    }

    public function setTrainingID($trainingID){
        $this->trainingID = $trainingID;
        return $this;
    }

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function setDepartmentID($departmentID){
        $this->departmentID = $departmentID;
        return $this;
    }

    public function setTrainer($trainer){
        $this->trainer = $trainer;
        return $this;
    }

    public function setStartDate($startDate){
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate){
        $this->endDate = $endDate;
        return $this;
    }

    public function setStartTime($startTime){
        $this->startTime = $startTime;
        return $this;
    }

    public function setEndTime($endTime){
        $this->endTime = $endTime;
        return $this;
    }

    public function setVenue($venue){
        $this->venue = $venue;
        return $this;
    }

    public function setEmployeeID($employeeID){
        $this->employeeID = $employeeID;
        return $this;
    }

    //generate Training ID
    public function generateID(){
        $db = new DBController();
        //Will be descending order
        $sql = "SELECT * FROM trainingClass ORDER BY trainingID DESC";
        $result = $db->runQuery($sql);
        $prefix = 'TRN';

        if(empty($result)){
            $prefix .= '001';
            return $prefix;
        }

        //Get the first ID 
        $lastID = $result[0]['trainingID'];
        //SubString to last part of ID
        $numberPart = substr($lastID, 3, 6);
        
        if((int)$numberPart < 9 ){
            $prefix .= '00' . ((int)$numberPart + 1);
        }else if ((int)$numberPart >= 9){
            $prefix .= '0' . ((int)$numberPart + 1);
        }

        return $prefix;
    }

    public function selectQuery(){
        $db = new DBController();
        $sql = "SELECT * FROM trainingclass WHERE trainingID = '$this->trainingID'";
        $result = $db->runQuery($sql);
        return $result;
    }

    public function addTraining(){
        $db = new DBController();
        //Insert into training class
        $sql = "INSERT INTO trainingClass 
        (trainingID, title, description, trainer, startDate, endDate, startTime, endTime, venue, departmentID) 
        VALUES 
        ('$this->trainingID', '$this->title', 
        '$this->description', '$this->trainer', 
        '$this->startDate', '$this->endDate', 
        '$this->startTime', '$this->endTime', 
        '$this->venue', '$this->departmentID')";

        $result = $db->executeQuery($sql);
   
        if($result){
            //Select all employee under this department
            $employees = $db->runQuery("SELECT * FROM employee WHERE departmentID = '$this->departmentID'");

            //Insert each employee into class list
            foreach($employees as $employee){
               // $i = 0;
               $employeeID = $employee['employeeID'];
               $classListResult = $db->executeQuery("INSERT INTO traineelist (trainingID, employeeID) VALUES ('$this->trainingID', '$employeeID')");

               if(!$classListResult){
                     return false;
                     exit();
               }

            }

           return $this->sendNewTrainingEmail();
        }else{
            return false;
        }
    }

    public function sendNewTrainingEmail(){
        $db_handle = new DBController();
        //Select all employees under this department
        $employees = $db_handle->runQuery("SELECT * FROM employee WHERE departmentID = '$this->departmentID'");

        if(!empty($employees)){
                //Send email to each employee under this department
            $to = "";
            foreach($employees as $employee){
                $to .= $employee['email'] . ",";
            }

            $url = "http://localhost:1080/WebAssignment/dashboard/viewTraining.php";
                
            $headers = "From: noreply@human.com";
            $subject = "New Training Schedule - " . $this->title;
            $txt = "Hi, \n\nKindly noted that new training has been scheduled for your department.\n\nTitle: ".$this->title."\n\nDescription: ".$this->description."\n\nTrainer: ".$this->trainer."\n\nDate: ".$this->startDate." -- ".$this->endDate."\n\nTime: ".$this->startTime." -- ".$this->endTime."\n\nVenue: ".$this->venue."\n\nKindly check via this link: $url\n\nThank You.";

            $sendEmail = mail($to,$subject,$txt,$headers);

            if(!$sendEmail){
                return false;
                exit();
            }
            
            return true;
        }else{
            header("Location: ../dashboard/viewTraining.php");
        }
        
    }

    public function deleteTraining(){
        $db = new DBController();
        
        //Delete from class list
        $deleteList = $db->executeQuery("DELETE FROM traineelist WHERE trainingID = '$this->trainingID'");
        
        if($deleteList){
            //Send Cancellation announcement
            if($this->sendCancelEmail()){

                //Delete from training class
                $sql = "DELETE FROM trainingclass WHERE trainingID = '$this->trainingID'";
                $result = $db->executeQuery($sql);
                return $result;
            }
            
        }else{
            return false;
        }
    }

    public function sendCancelEmail(){
        $db_handle = new DBController();
        //Select all employees under this department
        $employees = $db_handle->runQuery("SELECT * FROM employee WHERE departmentID = '$this->departmentID'");

        //Send email to each employee under this department
        $to = "";
        foreach($employees as $employee){
            $to .= $employee['email'] . ",";
        }

        $trainingDetails = $this->selectQuery();

        $url = "http://localhost:1080/WebAssignment/dashboard/viewTraining.php";
            
        $headers = "From: noreply@human.com";
        $subject = "Training Cancel - " . $trainingDetails[0]['title'];
        $txt = "Hi, \n\nKindly noted that training at ".$trainingDetails[0]['startDate']." -- ".$trainingDetails[0]['endDate']." has been cancel due to some technical issue.\n\nWith Title: ".$trainingDetails[0]['title']."\n\nDescription: ".$trainingDetails[0]['description']."\n\nTrainer: ".$trainingDetails[0]['trainer']."\n\nTime: ".$trainingDetails[0]['startTime']." -- ".$trainingDetails[0]['endTime']."\n\nVenue: ".$trainingDetails[0]['venue']."\n\nKindly check via this link: $url\n\nThank You.";

        $sendEmail = mail($to,$subject,$txt,$headers);

        if(!$sendEmail){
            return false;
            exit();
        }
        
        return true;
    }

      

        public function editTraining(){
            $db = new DBController();

            $sql = "UPDATE trainingclass 
            SET 
            title = '$this->title', 
            description = '$this->description', 
            trainer = '$this->trainer', 
            startDate = '$this->startDate', 
            endDate = '$this->endDate', 
            startTime = '$this->startTime', 
            endTime = '$this->endTime', 
            venue = '$this->venue' 
            WHERE 
            trainingID = '$this->trainingID'";

            $result = $db->executeQuery($sql);

            if($result){
                return $this->sendUpdateEmail();         
            }
            return false;
        }

        public function sendUpdateEmail(){
            $db_handle = new DBController();
            //Select all employees under this department
            $employees = $db_handle->runQuery("SELECT * FROM employee WHERE departmentID = '$this->departmentID'");
    
            //Send email to each employee under this department
            $to = "";
            foreach($employees as $employee){
                $to .= $employee['email'] . ",";
            }
    
            $url = "http://localhost:1080/WebAssignment/dashboard/viewTraining.php";
                
            $headers = "From: noreply@human.com";
            $subject = "Training Schedule Updated - " . $this->title;
            $txt = "Hi, \n\nKindly noted that training has been updated.\n\nTitle: ".$this->title."\n\nDescription: ".$this->description."\n\nTrainer: ".$this->trainer."\n\nDate: ".$this->startDate." -- ".$this->endDate."\n\nTime: ".$this->startTime." -- ".$this->endTime."\n\nVenue: ".$this->venue."\n\nKindly check via this link: $url\n\nThank You.";
    
            $sendEmail = mail($to,$subject,$txt,$headers);
    
            if(!$sendEmail){
                return false;
                exit();
            }
            
            return true;
        }


}

?>