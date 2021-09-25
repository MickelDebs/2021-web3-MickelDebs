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
        $time=date('h:i');
        
        $order_query="INSERT INTO `orders` (`user_id`,`location_type`,`location_id`,`meals`,`quantity`,`total`,`time`)
        VALUES ('".$user_id."','".$location_type."','".$location_id."','".$str_meals."','".$quantity."','".$total."','".$time."')";

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
            $id=$_SESSION['user']['Id'];
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
?>