<?php
session_start();

if(isset($_POST['action']))
{
    include '../cnx.php';
    $action=$_POST['action'];
    switch($action)
    {
        case 'automatic':
            $lat=$_POST['lat'];
            $lng=$_POST['lng'];

            $query="INSERT INTO `location_automatic` (`lat`,`lng`) VALUES ('".$lat."','".$lng."')";
            $result=mysqli_query($database,$query);
            $location_id=mysqli_insert_id($database);

            if($result==1)
            {
                MakeOrder("automatic",$location_id);
            }
        break;
        case 'manual':
            $street=$_POST['street'];
            $city=$_POST['city'];
            $building=$_POST['building'];
            $moreinfo=$_POST['moreinfo'];

            $query="INSERT INTO `location_manual` (`street`,`city`,`building`,`info`) VALUES ('".$street."','".$city."','".$building."','".$moreinfo."')";
            $result=mysqli_query($database,$query);
            $location_id=mysqli_insert_id($database);
            if($result==1)
            {
                MakeOrder("manual",$location_id);
            }
        break;
        case 'confirm';
            $id=$_POST['id'];
            $confirmQuery="UPDATE `orders` SET eta='finished' WHERE order_id='".$id."'";
            $resultConfirm=mysqli_query($database,$confirmQuery);

            $order_array=array();
            if($resultConfirm==1)
            {
                foreach($_SESSION['user']['orders'] as $order)
                {
                    foreach($order as $k =>$v)
                    {
                        if($k=='order_id' && $v==$id)
                        {
                            $order['eta']='finished';
                        }
                    }
                    array_push($order_array,$order);
                }
                $_SESSION['user']['orders']=$order_array;

                $allorders=array("active"=>array(),"finished"=>array());
                foreach($_SESSION['user']['orders'] as $order)
                {
                    $meals=parseMeals($order);
                    foreach($order as $k => $v)
                    {
                        $order['meals']=$meals;
                        $order['deliveryTime']=date("h:i A",strtotime($order['time']) + 60*60);
                        if($k=="eta")
                        {
                            if($v=="finished")
                            {
                                array_push($allorders['finished'],$order);
                            }else
                            {
                                array_push($allorders['active'],$order);
                            }
                        }
                    }
                }
                updateSales($id);
                echo(json_encode($allorders));
                
            }else
            {
                echo('fail');
            }
        break;
    }
}
function MakeOrder($location_type,$location_id)
    {
        include '../cnx.php';
        $user_id=$_SESSION['user']['Id'];
        $meals=$_SESSION['cart_item'];
        $str_meals=toString($meals);
        $quantity=count($_SESSION['cart_item']);
        $total=$_SESSION['total'];
        date_default_timezone_set('Asia/Beirut');
        $time=date('h:i A');
        $date=date('d,m,Y');
        
        $order_query="INSERT INTO `orders` (`user_id`,`location_type`,`location_id`,`meals`,`quantity`,`total`,`time`,`date`)
        VALUES ('".$user_id."','".$location_type."','".$location_id."','".$str_meals."','".$quantity."','".$total."','".$time."','".$date."')";

        $result_order=mysqli_query($database,$order_query);
        $order_id=mysqli_insert_id($database);
        if($result_order==1)
        {
            echo('
                <div class="checkout-header">
                    <h2>Your order is on the way.</h2>
                </div>
                <div class="checkout-items">
                    <div class="thank-you">
                        <img src="./images/icons/order-sent.png">
                        <h2>Thank you for your order!</h2>
                    </div>
                    
                    <div class="info">
                        <div>Order Confirmation</div>
                        <div>#'.$order_id.'</div>
                    </div>
                    <div class="order-end">
                        <div class="order-end-item">
                            <div>Purchased meals ('.count($_SESSION['cart_item']).')</div>
                            <div>'.$_SESSION['total'].'LL</div>
                        </div>
                        <div class="order-end-item">
                            <div>Shipping</div>
                            <div>0LL</div>
                        </div>
                        <div class="order-end-item">
                            <div>Total</div>
                            <div>'.$_SESSION['total'].'LL</div>
                        </div>
                    </div>
                </div>
                <div class="choose-payment-footer">
                    <img src="./images/icons/info.png">
                    <div class="text">You can get more info about your orders in <a href="./orders.php">order history</a></div>
                </div>
            ');
            $new_order=array("order_id"=>$order_id,"user_id"=>$user_id,"location_type"=>$location_type,"location_id"=>$location_id,"meals"=>$str_meals,"quantity"=>$quantity,"total"=>$total,"time"=>$time,"date"=>$date,"eta"=>"active");
            if(isset($_SESSION['user']['orders']))
            {
                $orders=$_SESSION['user']['orders'];
            }else
            {
                $orders=array();
            }
            array_push($orders,$new_order);
            $_SESSION['user']['orders']=$orders;

            unset($_SESSION['cart_item']);
            $_SESSION['total']=0;
        }
    }

    function toString($meals)
    {
        include '../cnx.php';
        
        $result='';
        
        for($j=0;$j<count($meals);$j++)
        {
            $str='';
            $id=$meals[$j]['Id'];
            if(!empty($meals[$j]['notIncluded']))
            {
                //remove the last ','
                $notin=substr($meals[$j]['notIncluded'],0,-1);
                $not_included=explode(',',$notin);
                $ing_str="";
                for($i=0;$i<count($not_included);$i++)
                {
                    $ing_query="SELECT `Id` FROM `ingredients` WHERE name='".$not_included[$i]."'";
                    $result_ing=mysqli_query($database,$ing_query);

                    if(mysqli_num_rows($result_ing) == 1)
                    {
                        while($row=mysqli_fetch_assoc($result_ing))
                        {
                            if($i==count($not_included)-1)
                            {
                                $ing_str.=$row['Id'];
                            }else
                            {
                                $ing_str.=$row['Id'].'-';
                            }
                        }
                    }
                }
                if($j==count($meals)-1)
                {
                    $str=$id.':'.$ing_str;
                }else
                {
                    $str=$id.':'.$ing_str.',';
                }
            }else
            {
                if($j==count($meals)-1)
                {
                    $str=$id;
                }else
                {
                    $str=$id.',';
                }
            }
            $result.=$str;
        }
        return $result;
    }
    function parseMeals($order)
    {
        $meals=$order['meals'];
        $meals=explode(',',$meals);
        $allmeals=array();
        foreach($meals as $meal)
        {
            
            $dotIndex=strpos($meal,':');
            $mealId='';

            if(empty($dotIndex))
            {
                $mealId=$meal;

                
                foreach($_SESSION['user']['orderMeals'] as $mealinfo)
                {
                    foreach($mealinfo as $k=>$v)
                    {
                        if($k=='Id' && $v==$mealId)
                        {
                            unset($mealinfo['ingredients']);
                            $mealinfo['ingredients']=array();
                            array_push($allmeals,$mealinfo);
                        }
                    }
                }
            }
            else
            {
                $mealId=substr($meal,0,$dotIndex);
                $ings=array();

                $ingredients=explode('-',substr($meal,$dotIndex+1));
                foreach($ingredients as $ingredient)
                {
                    //Searching for each ingredient id in the array that i got from the database
                    foreach($_SESSION['user']['orderIngredients'] as $ingsArray)
                    {
                        foreach($ingsArray as $k => $v)
                        {
                            if($k=='Id' && $v==$ingredient)
                            {
                                array_push($ings,$ingsArray);
                            }
                        }
                    }
                }
                foreach($_SESSION['user']['orderMeals'] as $mealinfo)
                {
                    foreach($mealinfo as $k=>$v)
                    {
                        if($k=='Id' && $v==$mealId)
                        {
                            unset($mealinfo['ingredients']);
                            $mealinfo['ingredients']=array();
                            $mealinfo['ingredients']=$ings;
                            array_push($allmeals,$mealinfo);
                        }
                    }
                }
                
                
            }
            

        }
        return $allmeals;
    }
    function updateSales($order_id)
    {
        include '../cnx.php';
        $all_meals=array();
        $getOrderMeals="SELECT `meals` from `orders` WHERE order_id='".$order_id."'";
        $resultMeals=mysqli_query($database,$getOrderMeals);

        if(mysqli_num_rows($resultMeals) == 1)
        {
            $mealsStr=mysqli_fetch_assoc($resultMeals);
        }
        if(!empty($mealsStr))
        {
            $mealsArray=explode(',',$mealsStr['meals']);
            foreach($mealsArray as $m)
            {
                $index=strpos($m,':');
                $meal=$m;
                if(!empty($index))
                {
                    $meal=substr($m,0,$index);
                }
                array_push($all_meals,$meal);
            }
        }
        $date=date("Y/m/d");
        foreach($all_meals as $me)
        {
            $selectQuery="SELECT `number`,`sales_id` FROM `sales` WHERE meal_id='".$me."' AND time='".$date."'";
            $selectQueryResult=mysqli_query($database,$selectQuery);
            if(mysqli_num_rows($selectQueryResult)==1)
            {
                
                $sales=mysqli_fetch_assoc($selectQueryResult);
                $number=(int)$sales['number'];
                $number++;
                $saleId=$sales['sales_id'];
                $updateQuery="UPDATE `sales` SET number='".$number."' WHERE sales_id='".$saleId."'";
                mysqli_query($database,$updateQuery);
            }else
            {
                $insertQuery="INSERT INTO `sales` (`meal_id`,`number`,`time`) VALUES ('".$me."','1','".$date."')";
                mysqli_query($database,$insertQuery);
            }
        }
    }
?>