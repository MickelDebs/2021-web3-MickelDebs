<?php
    session_start();
    if(isset($_POST['action']))
    {
        include '../cnx.php';
        if($_POST['action']=='addToFavorites')
        {
            $id=$_POST['id'];

            $addFavQuery="INSERT INTO `favorites` VALUES ('".$_SESSION['user']['Id']."','".$id."')";

            $resultAddFav=mysqli_query($database,$addFavQuery);
            if($resultAddFav==1)
            {
                $fav=array();
                if(isset($_SESSION['user']['favorites']))
                {
                    $fav=$_SESSION['user']['favorites'];
                }
                $favid=array();
                $favid['meal_id']=$id;
                array_push($fav,$favid);
                //array push with key
                $_SESSION['user']['favorites']=$fav;
                echo('success');
                exit;
            }
            echo('fail');
            
        }else if($_POST['action']=='removeFromFavorites')
        {
            $id=$_POST['id'];

            $DeleteFavQuery="DELETE FROM `favorites` WHERE meal_id='".$id."'";

            $resultDeleteFav=mysqli_query($database,$DeleteFavQuery);
            if($resultDeleteFav==1)
            {
                $fav=$_SESSION['user']['favorites'];
                $favid['meal_id']=$id;
                if (($key = array_search($favid, $fav)) !== false) {
                    unset($fav[$key]);
                }
                $_SESSION['user']['favorites']=$fav;
                echo('success');
                exit;
            }
            echo('fail');
        }
    }
?>