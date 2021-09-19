<?php
    session_start();
    if(isset($_POST['action']))
    {
        include '../cnx.php';
        if($_POST['action']=='addCard')
        {
            $number=$_POST['number'];
            $name=$_POST['name'];
            $month=$_POST['month'];
            $year=$_POST['year'];
            $ccv=$_POST['ccv'];
            $number=str_replace(" ","",$number);

            $addCardQuery="INSERT INTO `cards` (number,name,month,year,ccv)
                        VALUES ('$number','$name','$month','$year','$ccv')";

            $resultAddCard=mysqli_query($database,$addCardQuery);
            if($resultAddCard==1)
            {
                $manymanyQuery="INSERT INTO `user_cards` VALUES ('".$_SESSION['user']['Id']."','".mysqli_insert_id($database)."');";
                $resultMany=mysqli_query($database,$manymanyQuery);
                if($resultMany==1)
                {
                    $cards=array();
                    
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
                    
                    echo(json_encode($cards));
                    exit;
                }    
            }
            echo('fail');
            
        }else if($_POST['action']=='removeCard')
        {
            $id=$_POST['id'];

            $deleteQuery="DELETE FROM `cards` WHERE card_id='".$id."'";
            $resultDelete=mysqli_query($database,$deleteQuery);
            if($resultDelete==1)
            {
                $deleteManyQuery="DELETE FROM `user_cards` WHERE card_id='".$id."'";
                $resultManyDelete=mysqli_query($database,$deleteManyQuery);

                if($resultManyDelete==1)
                {
                    $cardsQuery="SELECT `number`,`card_id` FROM `cards` NATURAL JOIN `user_cards` WHERE user_cards.user_id='".$_SESSION['user']['Id']."'";
                    $resultCards=mysqli_query($database,$cardsQuery);

                    $cards=array();
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
                    $_SESSION['user']['card']='Always ask';
                    echo(json_encode($cards));
                    exit;
                }
            }
        }
    }
?>