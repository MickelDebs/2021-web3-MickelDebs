<?php
session_start();
$invalidLogin=false;
if(isset($_POST["login"]))
{
    if(isset($_POST['login-username']) &&
    isset($_POST['login-password']))
    {
        include 'cnx.php';

        $loginUsername=$_POST['login-username'];
        $loginPass=$_POST['login-password'];

        $sql_login_username="SELECT * FROM `users` where `username` = '".$loginUsername."'";

        $result_login_username = mysqli_query($database, $sql_login_username);
        $a=array();
        

        if(mysqli_num_rows($result_login_username) == 1)
        {
            while($row=mysqli_fetch_assoc($result_login_username))
            {
                $a[]=$row;
            }
            for($i=0;$i<count($a);$i++)
            {
                if($a[$i]["username"]==$loginUsername)
                {
                    if(password_verify($loginPass,$a[$i]["password"])) 
                    {
                        $_SESSION['username']=$loginUsername;
                        header('location:testpage.php');
                    }else
                    {
                        $invalidLogin=true;
                    }
                }
            }
        }else
        {
            $invalidLogin=true;
        }
    }else
    {
        header('location:index.php');
    }
}
?>