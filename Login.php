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
                        $_SESSION['user']=$a[$i];

                        $cardsQuery="SELECT `number`,`card_id` FROM `cards` NATURAL JOIN `user_cards` WHERE user_cards.user_id='".$_SESSION['user']['Id']."'";
                        $resultCards=mysqli_query($database,$cardsQuery);
                        if(mysqli_num_rows($resultCards) > 0)
                        {
                            while($row=mysqli_fetch_assoc($resultCards))
                            {
                                $cards[]=$row;
                            }
                        }
                        for($i=0;$i<count($cards);$i++)
                        {
                            foreach($cards[$i] as $k => $v)
                            {
                                if($k=='number')
                                {
                                    $cards[$i]['number']="●●●● ●●●● ●●●● ".substr($v,-4);
                                }
                            }
                        }
                        $_SESSION['user']['cards']=$cards;

                        $favQuery="SELECT `meal_id` FROM `favorites` NATURAL JOIN `users` WHERE favorites.user_id='".$_SESSION['user']['Id']."'";
                        $resultfav=mysqli_query($database,$favQuery);
                        $fav=array();
                        if(mysqli_num_rows($resultfav) > 0)
                        {
                            while($row=mysqli_fetch_assoc($resultfav))
                            {
                                $fav[]=$row;
                            }
                        }
                        $_SESSION['user']['favorites']=$fav;

                        $ordersQuery="SELECT * FROM `orders` WHERE user_id='".$_SESSION['user']['Id']."'";
                        $resultorders=mysqli_query($database,$ordersQuery);
                        $orders=array();
                        if(mysqli_num_rows($resultorders) > 0)
                        {
                            while($row=mysqli_fetch_assoc($resultorders))
                            {
                                $orders[]=$row;
                            }
                        }
                        $_SESSION['user']['orders']=$orders;
                        header('location:BuyPage.php');
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