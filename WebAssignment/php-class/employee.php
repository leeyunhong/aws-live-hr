<?php
include_once ('dbcontroller.php');
include ('wages.php');
include ('userClass.php');

class Employee{
    private $employeeID, $departmentID, $fullName, $icNo, $contactNo, $email, $address, $position, $joinDate, $bankAccount, $password, $activeStatus, $profilePic, $managerID, $salary;

    public function __construct(){
        $this->employeeID = '';
        $this->departmentID = '';
        $this->fullName = '';
        $this->icNo = '';
        $this->contactNo = '';
        $this->email = '';
        $this->address = '';
        $this->position = '';
        $this->joinDate = '';
        $this->banAccount = '';
        $this->password = '';
        $this->activeStatus = '';
        $this->profilePic = '';
        $this->managerID = '';
        $this->salary = '';
    }

    public function setEmployeeID($employeeID){
        $this->employeeID = $employeeID;
        return $this;
    }

    public function setDepartmentID($departmentID){
        $this->departmentID = $departmentID;
        return $this;
    }

    public function setFullName($fullName){
        $this->fullName = $fullName;
        return $this;
    }

    public function setIcNo($icNo){
        $this->icNo = $icNo;
        return $this;
    }

    public function setContactNo($contactNo){
        $this->contactNo = $contactNo;
        return $this;
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    public function setAddress($address){
        $this->address = $address;
        return $this;
    }

    public function setPosition($position){
        $this->position = $position;
        return $this;
    }

    public function setJoinDate($joinDate){
        $this->joinDate = $joinDate;
        return $this;
    }

    public function setBankAccount($bankAccount){
        $this->bankAccount = $bankAccount;
        return $this;
    }   

    public function setPassword($password){
        $this->password = $password;
        return $this;
    }

    public function setActiveStatus($activeStatus){
        $this->activeStatus = $activeStatus;
        return $this;
    }

    public function setProfilePic($profilePic){
        $this->profilePic = $profilePic;
        return $this;
    }

    public function setManager($managerID){
        $this->managerID = $managerID;
        return $this;
    }

    public function setSalary($salary){
        $this->salary = $salary;
        return $this;
    }

    public function getEmployeeID(){
        return $this->employeeID;
    }

    public function getDepartmentID(){
        return $this->departmentID;
    }

    public function getFullName(){
        return $this->fullName;
    }

    public function getIcNo(){
        return $this->icNo;
    }

    public function getContactNo(){
        return $this->contactNo;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getPosition(){
        return $this->position;
    }

    public function getJoinDate(){
        return $this->joinDate;
    }

    public function getBankAccount(){
        return $this->bankAccount;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getActiveStatus(){
        return $this->activeStatus;
    }

    public function getProfilePic(){
        return $this->profilePic;
    }

    public function getManager(){
        return $this->managerID;
    }

    public function getSalary(){
        return $this->salary;
    }

    public function selectQuery(){
        $db = new DBController();
        $sql = "SELECT * FROM employee WHERE email = '$this->email'";
        $result = $db->runQuery($sql);
        return $result;
    }

     //generate employee ID
     public function generateID(){
        $db = new DBController();
        //Will be descending order
        $sql = "SELECT * FROM employee ORDER BY employeeID DESC";
        $result = $db->runQuery($sql);
        $prefix = 'EMP';

        if(empty($result)){
            $prefix .= '001';
            return $prefix;
        }

        //Get the first ID 
        $lastID = $result[0]['employeeID'];
        //SubString to last part of ID
        $numberPart = substr($lastID, 3, 6);

       if((int)$numberPart < 9 ){
            $prefix .= '00' . ((int)$numberPart + 1);
        }else if ((int)$numberPart >= 9){
            $prefix .= '0' . ((int)$numberPart + 1);
        }

        return $prefix;
    }

    private function checkEmailExist(){
        $db = new DBController();
        $sql = "SELECT * FROM employee WHERE email = '$this->email'";
        $result = $db->numRows($sql);

        if($result > 0){
            return true;
        }else{
            return false;
        }
    }

    private function checkICExist(){
        $db = new DBController();
        $sql = "SELECT * FROM employee WHERE icNo = '$this->icNo'";
        $result = $db->numRows($sql);

        if($result > 0){
            return true;
        }else{
            return false;
        }
    }
    //IC, Salary, Bank Account, ContactNo
    private function checkIsNum($input){
        if(!is_numeric($input)){
            return false;
        }else{
            return true;
        }
    }

    public function addEmployee(){
        if(!$this->checkIsNum($this->icNo)){
            header('location: ../dashboard/addEmployee.php?name='.$this->fullName.'&icNo=notNumber&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary);
            exit();
        }else if(!$this->checkIsNum($this->contactNo)){
            header('location: ../dashboard/addEmployee.php?name='.$this->fullName.'&icNo='.$this->icNo.'&email='.$this->email.'&contactNo=notNumber&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary);
            exit();
        }else if(!$this->checkIsNum($this->bankAccount)){
            
            header('location: ../dashboard/addEmployee.php?name='.$this->fullName.'&icNo='.$this->icNo.'&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount=notNumber&salary='.$this->salary);
            exit();
        }else if(!$this->checkIsNum($this->salary)){
            header('location: ../dashboard/addEmployee.php?name='.$this->fullName.'&icNo='.$this->icNo.'&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary=notNumber');
            exit();
        }else if($this->checkEmailExist()){
            header('location: ../dashboard/addEmployee.php?name='.$this->fullName.'&icNo='.$this->icNo.'&emailExist=true&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary);
            exit();
        }else if($this->checkIcExist()){
            header('location: ../dashboard/addEmployee.php?name='.$this->fullName.'&icNo=used&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary);
            exit();
        }else{
            $db = new DBController();
            $sql = "INSERT INTO employee 
            (employeeID, departmentID, fullName, icNo, 
            contactNo, email, address, position, joinDate, 
            bankAccount, password, activeStatus,managerID, profilePhoto) 
            VALUES 
            ('$this->employeeID', '$this->departmentID', 
            '$this->fullName', '$this->icNo', 
            '$this->contactNo', '$this->email', 
            '$this->address', '$this->position', 
            '$this->joinDate', '$this->bankAccount', 
            'abc123', '1', '$this->managerID',
            '$this->profilePic')";

            $result = $db->executeQuery($sql);

            if($result){
            //Add Wages
            $newWages = new Wages();
            
            $newWages
            ->setWagesID($newWages->generateID())
            ->setEmployeeID($this->employeeID) 
            -> setTotalWages($this->salary);

            $wagesResult = $newWages->addNewWages();  
            
                if($wagesResult){
                 $firstTimeEmail = $this->sendFirstTimePassEmail();

                    if($firstTimeEmail){                      
                        return true;
                        exit();
                    }else{
                        header('location: ../dashboard/addEmployee.php?passwordEmail=false');
                        return false;
                        exit();
                    }
                }else{
                    header('location: ../dashboard/addEmployee.php?something=error');
                    return false;
                    exit();
                }

            }else{
                header('location: ../dashboard/addEmployee.php?addNewEmployee=false');
                return false;
                exit();
            }          
        }    
        return false;  
    }

    public function sendFirstTimePassEmail(){
        $db_handle = new DBController();
   
            $results = $this->selectQuery();
            $email = $results[0]['email'];
            $fullName = $results[0]['fullName'];

            $user = new User();
            //Generate random string
            $randomPass = $user->generateRandomString();

            //Hash random string
            $hashedRandomPass = password_hash($randomPass, PASSWORD_DEFAULT);

            //Reset link send to user
            $url = "http://localhost:1080/WebAssignment/changePassword.php?email=$email&icNo=$this->icNo&passwordRecovery=$hashedRandomPass";

            //Send email
            $to = $email;
            $subject = "First Time Password";
            $txt = "Hi, $fullName.\n\nPlease click the link below to change your password.\n\nOr else u could not login to the system\n\nLink: $url\n\nThank You.";
            $headers = "From: noreply@human.com";

            $sendEmail = mail($to,$subject,$txt,$headers);

            if($sendEmail){
                $query = "UPDATE employee SET password = '$hashedRandomPass' WHERE email = '$email'";

                if($db_handle->executeQuery($query)){
                    return true;
                }else{
                    return false;
                }
            }
        
    }

    public function updateEmployee(){
         $db = new DBController();
        $sql1 = "SELECT * FROM employee WHERE NOT employeeID = '$this->employeeID'";
        $result = $db->runQuery($sql1);

        foreach($result as $row){
            if(strcmp($this->email, $row['email']) == 0){
                header('location: ../dashboard/userProfile.php?id='.$this->employeeID.'&name='.$this->fullName.'&icNo='.$this->icNo.'&emailExist=true&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary.'&activeStatus='.$row['activeStatus'].'&photo='.$row['profilePhoto']);
                exit();       
            }
            
            if(strcmp($this->icNo, $row['icNo']) == 0){
                header('location: ../dashboard/userProfile.php?id='.$this->employeeID.'&name='.$this->fullName.'&icNo=used&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary.'&activeStatus='.$row['activeStatus'].'&photo='.$row['profilePhoto']);
                exit();
            }
        }

       

        if(!$this->checkIsNum($this->icNo)){
            header('location: ../dashboard/userProfile.php?id='.$this->employeeID.'&name='.$this->fullName.'&icNo=notNumber&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary.'&activeStatus='.$result[0]['activeStatus'].'&photo='.$result[0]['profilePhoto']);
            exit();

        }else if(!$this->checkIsNum($this->contactNo)){
            header('location: ../dashboard/userProfile.php?id='.$this->employeeID.'&name='.$this->fullName.'&icNo='.$this->icNo.'&email='.$this->email.'&contactNo=notNumber&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount='.$this->bankAccount.'&salary='.$this->salary.'&activeStatus='.$result[0]['activeStatus'].'&photo='.$result[0]['profilePhoto']);
            exit();
        }else if(!$this->checkIsNum($this->bankAccount)){
            
            header('location: ../dashboard/userProfile.php?id='.$this->employeeID.'&name='.$this->fullName.'&icNo='.$this->icNo.'&email='.$this->email.'&contactNo='.$this->contactNo.'&address='.$this->address.'&position='.$this->position.'&joinDate='.$this->joinDate.'&bankAccount=notNumber&salary='.$this->salary.'&activeStatus='.$result[0]['activeStatus'].'&photo='.$result[0]['profilePhoto']);
            exit();
        }else{
            $db = new DBController();

             //Update Employee Details
            $sql = "UPDATE employee SET 
            fullName = '$this->fullName', icNo = '$this->icNo', 
            contactNo = '$this->contactNo', email = '$this->email', 
            address = '$this->address', position = '$this->position', 
            joinDate = '$this->joinDate', bankAccount = '$this->bankAccount', 
            managerID = '$this->managerID',
            profilePhoto = '$this->profilePic' 
            WHERE employeeID = '$this->employeeID'";

            $result = $db->executeQuery($sql);

            if($result){
                return true;
                exit();

            }else{               
                return false;
                exit();
            }        
        }    
        return false;  
    }

    public function deleteEmployee(){
        $db = new DBController();
        
        $sql = "UPDATE employee SET activeStatus = 0 WHERE employeeID = '$this->employeeID'";
        $result = $db->executeQuery($sql);

        if( $result ){        
            if(!$result){
                return false;
                exit();              
            }else{
                return true;
                exit();
            }
        }
    }
}
?>