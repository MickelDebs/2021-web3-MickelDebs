<?php
    session_start();
    include 'cnx.php';
    if(!empty($_POST["action"])) 
    {
        switch($_POST["action"]) 
        {
            case "changePassword":
                if(isset($_SESSION['user']))
                {
                    $passwordQuery="SELECT `password` FROM `users` WHERE `Id`='".$_SESSION['user']['Id']."'";

                    $result_password = mysqli_query($database, $passwordQuery);
                    $a=array();

                    if(mysqli_num_rows($result_password) == 1)
                    {
                        while($row=mysqli_fetch_assoc($result_password))
                        {
                            $a[]=$row;
                        }
                    }
                    $currentPass=$a[0]['password'];
                    $oldpass=$_POST['oldpass'];
                    $newpass=$_POST['newpass'];
                    $cpass=$_POST['cpass'];

                    if(password_verify($oldpass,$currentPass))
                    {
                        if($newpass==$cpass)
                        {
                            if($oldpass==$newpass)
                            {
                                echo("<div class=\"pass-change-result\" style=\"color:red\"> old and new password cannot be the same</div>");
                            }else
                            {
                                $passchangeQuery="UPDATE `users` SET `password`='".password_hash($newpass,PASSWORD_DEFAULT)."' WHERE `Id`='".$_SESSION['user']['Id']."'";
                                $result_change=mysqli_query($database,$passchangeQuery);
                                
                                if($result_change==1)
                                {
                                    echo("<div class=\"pass-change-result\" style=\"color:green\"> Password was changed successfully.</div>");
                                }
                            }
                        }else
                        {
                            echo("<div class=\"pass-change-result\" style=\"color:red\">Check if both passwords are the same</div>");
                        }
                    }
                    else
                    {
                        echo("<div class=\"pass-change-result\" style=\"color:red\">Password does not match old password</div>");
                    }
                }
            break;
            case 'uploadPicture':
                if(isset($_POST['source']))
                {
                    $picQuery="UPDATE `users` SET `picture`='".$_POST['source']."' WHERE `Id`='".$_SESSION['user']['Id']."'";
                    
                    $resultPicSave=mysqli_query($database,$picQuery);
                    
                    if($resultPicSave==1)
                    {
                        deleteTempPictures($_POST['source']);
                        $_SESSION['user']['picture']=$_POST['source'];
                        echo("<div style=\"color:green;font-size:14px;font-weight:bold\">Picture has been changed</div>");
                    }else
                    {
                        echo("<div style=\"color:red;font-size:14px;font-weight:bold\">Failed to change picture</div>");
                    }
                }
            break;
            case 'changeInfo':
                $resultUpdate=0;
                $firstname=$_POST['firstname'];
                $lastname=$_POST['lastname'];
                $birthday=$_POST['birthday'];
                $defaultpayment=$_POST['defaultpayment'];
                $defaultcard=$_POST['card'];

                if($firstname!=$_SESSION['user']['firstname']
                |$lastname!=$_SESSION['user']['lastname']
                |$birthday!=$_SESSION['user']['birthday']
                |$defaultpayment!=$_SESSION['user']['payment']
                |$defaultcard!=$_SESSION['user']['card'])
                {
                    $updateQuery="UPDATE `users` SET `firstname`='".$firstname."',
                                                    `lastname` = '".$lastname."',
                                                    `birthday` = '".$birthday."',
                                                    `payment` = '".$defaultpayment."',
                                                    `card` = '".$defaultcard."'
                                                WHERE `Id` = '".$_SESSION['user']['Id']."'";

                    $_SESSION['user']['firstname']=$firstname;
                    $_SESSION['user']['lastname']=$lastname;
                    $_SESSION['user']['birthday']=$birthday;
                    $_SESSION['user']['payment']=$defaultpayment;
                    $_SESSION['user']['card']=$defaultcard;

                    $resultUpdate=mysqli_query($database,$updateQuery);
                }
                if($resultUpdate==1)
                {
                    $result="success";
                }else
                {
                    $result="fail";
                }
                echo($result);

            break;
        }
    }else
    {
        if(isset($_FILES['file']['name'])){

            /* Getting file name */
            $filename = $_FILES['file']['name'];
         
            $wantedLocation="./images/users/".$_SESSION['user']['username']."_".$_SESSION['user']['Id'];
            /* Location */
            if(!file_exists($wantedLocation))
            {
                mkdir($wantedLocation,0777,true);
            }
            $location = $wantedLocation."/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
         
            /* Valid extensions */
            $valid_extensions = array("jpg","jpeg","png");
         
            $response ="";
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) 
            {
                $newName=rand().'.'.$imageFileType;
                $location=str_replace($filename,$newName,$location);
               /* Upload file */
               if(move_uploaded_file($_FILES['file']['tmp_name'],$location))
               {
                  $response = $location;
               }
            }

            echo $response;
            exit;
         }
         
         echo 0;
    }
    function deleteTempPictures($pictureName)
    {
        $directory="./images/users/".$_SESSION['user']['username']."_".$_SESSION['user']['Id'];
        $files=scandir($directory);
        $files = array_diff($files, array('.', '..'));
        
        $pictureName=str_replace($directory."/","",$pictureName);
        
        foreach($files as $pic)
        {
            if($pic!=$pictureName)
            {
                unlink($directory."/".$pic);
            }
        }

    }
?>