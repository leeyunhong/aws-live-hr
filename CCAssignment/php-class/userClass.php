<?php
    include_once ('dbcontroller.php');

    class User{

        private $email, $currPass, $icNo, $newPass, $confNewPass;

        public function __construct(){
            $this->email = '';
            $this->currPass = '';
            $this->icNo = '';
            $this->newPass = '';
            $this->confNewPass = '';
        }

        public function setEmail($email){
            $this->email = $email;
            return $this;
        }

        public function setCurrPass($currPass){
            $this->currPass = $currPass;
            return $this;
        }

        public function setIcNo($icNo){
            $this->icNo = $icNo;
            return $this;
        }

        public function setNewPass($newPass){
            $this->newPass = $newPass;
            return $this;
        }

        public function setConfNewPass($confNewPass){
            $this->confNewPass = $confNewPass;
            return $this;
        }

        public function selectQuery(){
            $db = new DBController();
            $sql = "SELECT * FROM employee WHERE email = '$this->email'";
            $result = $db->runQuery($sql);
            return $result;
        }

        public function checkEmail(){
            if($this->selectQuery() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function checkPassword(){
            $result = $this->selectQuery();

            $matched = password_verify($this->currPass, $result[0]['password']);

            if($matched){
                return true;
            }else{
                return false;
            }      
            
        }

        public function checkIcNo(){
            $result = $this->selectQuery();

            if($result[0]['icNo'] == $this->icNo){
                return true;
            }else{
                return false;
            }
        }

        public function loginValidation(){
            $exist = $this->selectQuery();

            if(!$this->checkEmail()){
                header('Location: ../home.php?email=invalid');
                exit();
            }else if(!$this->checkPassword()){
                header('Location: ../home.php?password=invalid');
                exit();  
            }else if ($this->checkEmail() && $this->checkPassword() && $exist[0]['activeStatus'] == 1){
                $result = $this->selectQuery();
                session_start();
                $_SESSION['employeeID'] = $result[0]['employeeID'];
                $_SESSION['email'] = $result[0]['email'];
                $_SESSION['fullName'] = $result[0]['fullName'];
                $_SESSION['departmentID'] = $result[0]['departmentID'];

               return true;
            }else{
                return false;
            }
        }

        public function changePassword(){
            if(!$this->checkEmail()){
                header('Location: ../changePassword.php?email=invalid&icNo='.$this->icNo.'');
                exit();
            }
            else if(!$this->checkIcNo()){
                header('Location: ../changePassword.php?email='.$this->email.'&icNo=invalid');
                exit();
            }else if(!$this->checkPassword()){
                header('Location: ../changePassword.php?email='.$this->email.'&icNo='.$this->icNo.'&password=invalid');
                exit();
            }
            if($this->newPass != $this->confNewPass){
                header('Location: ../changePassword.php?newpassword=mismatch');
                exit();
            }else{
                $hashedPwd = password_hash($this->confNewPass, PASSWORD_DEFAULT);

                $db = new DBController();
                $sql = "UPDATE employee SET password = '$hashedPwd' WHERE email = '$this->email'";

                $result = $db->executeQuery($sql);

                if($result){
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function recoveryPasswordChange(){
            $result = $this->selectQuery();
            $updatedPassword = $this->currPass;
            $checkMatch = $this->newPass == $this->confNewPass;
            $match = strcmp($result[0]['password'], $updatedPassword);

            if($match && $checkMatch){
                $hashedPwd = password_hash($this->confNewPass, PASSWORD_DEFAULT);
                $db = new DBController();
                $sql = "UPDATE employee SET password = '$hashedPwd' WHERE email = '$this->email'";

                $result = $db->executeQuery($sql);

                if($result){
                    return true;
                }else{
                    return false;
                }
            }          
        }

        public function sendRecoveryEmail(){
            $db_handle = new DBController();

            if(!$this->checkEmail()){
                header('Location: ../forgetPass.php?email=invalid&icNo='.$this->icNo.'');
                exit();
            }else if(!$this->checkIcNo()){
                header('Location: ../forgetPass.php?email='.$this->email.'&icNo=invalid');
                exit();
            }else if($this->checkEmail() && $this->checkIcNo()){
                $results = $this->selectQuery();
                $email = $results[0]['email'];
                $fullName = $results[0]['fullName'];

                //Generate random string
                $randomPass = $this->generateRandomString();

                //Hash random string
                $hashedRandomPass = password_hash($randomPass, PASSWORD_DEFAULT);

                //Reset link send to user
                $url = "http://localhost:1080/WebAssignment/changePassword.php?email=$email&icNo=$this->icNo&passwordRecovery=$hashedRandomPass";

                //Send email
                $to = $email;
                $subject = "Password Recovery";
                $txt = "Hi, $fullName.\n\nPlease click the link below to change your password.\n\nLink: $url\n\nThank You.";
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
        }

        public function generateRandomString($length = 8){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }
?>

