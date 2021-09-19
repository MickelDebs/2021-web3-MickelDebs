<?php
session_start();
$user_error=false;
if(isset($_POST['signup']))
{
    if(isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']))
    {
        include 'cnx.php';
        
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        $sql_username = "SELECT * FROM users WHERE username='$username'";

        $result_username = mysqli_query($database, $sql_username);

        if(mysqli_num_rows($result_username) > 0)
        {
            //username already taken
            //-->
            $user_error=true;

            $i=0;
            $suggested=array(3);
            while($i<3)
            {
                $random=rand(0,999);
                $new_username=$username.$random;
                
                $sql_new_username = "SELECT * FROM users WHERE username='$new_username'";
                $result_new_username = mysqli_query($database, $sql_new_username);
                if(mysqli_num_rows($result_new_username) == 0)
                {
                    $suggested[$i]=$new_username;
                    $i++;
                }
            }
        }else
        {
           $user_error=false;

           $query = "INSERT INTO users (username,email,password,status) 
      	   VALUES ('$username', '$email', '".password_hash($password,PASSWORD_DEFAULT)."','normal')";
           
           $results = mysqli_query($database, $query);

           $idQuery="SELECT * from users WHERE `username`='".$username."'";
           $result_id = mysqli_query($database, $idQuery);
           $a=array();
           if(mysqli_num_rows($result_id) == 1)
            {
                while($row=mysqli_fetch_assoc($result_id))
                {
                    $a[]=$row;
                }
            }
           mysqli_close($database);
           $_SESSION['user']=$a[0];
           header('location:BuyPage.php');
        }

    }else
    {
        header('location:index.php');
    }
}
?>