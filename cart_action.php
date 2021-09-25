<?php
session_start();
include 'cnx.php';
$total=0;
$site="";

if(!empty($_POST["action"])) {
switch($_POST["action"]) {
	case "add":
            $quantity=1;
            $query_pac="SELECT * FROM `meals` WHERE Id='".$_POST["Id"]."'";
            $productByCode = mysqli_query($database, $query_pac);

            $itemArray=array();
            while($row=mysqli_fetch_assoc($productByCode))
            {
            $itemArray[]=$row;
            }
            if(isset($_POST["notIncluded"]))
            {
                $itemArray[0]['notIncluded']=$_POST["notIncluded"];
            }else
            {
                $itemArray[0]['notIncluded']="";
            }
            $_SESSION["cartNumber"]=$_POST["cartNumber"];
            $itemArray[0]['cartNumber']=$_SESSION['cartNumber'];
            if(!empty($_SESSION["cart_item"])) {
				if(in_array($itemArray[0]["Id"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($itemArray[0]["Id"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $quantity;
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
            if(isset($_POST['site']))
            {
                $site=$_POST['site'];
            }
			foreach($_SESSION["cart_item"] as $k => $v) 
            {
                if(is_array($v))
                {

                foreach($v as $key => $value)
                {
                    if($key=="cartNumber")
                    {
                        if($_POST['cartNumber']==$value)
                            unset($_SESSION["cart_item"][$k]);
                        
                            if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                    }
                }
                }
					
                
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;		
}
}
?>
<?php
if($site!="checkout")
{
echo('<div class="cart-items">');
if(isset($_SESSION['cart_item']))
{
foreach($_SESSION['cart_item'] as $kk => $item)
{
        if($item['notIncluded']!="")
        {
            $ings=substr($item['notIncluded'],0,-1);
            $ingrArray=explode(",",$ings);
        }else
        {
            $ingrArray=array();
        }
        $total+=$item['price'];
    echo('
    <div class="cart-item">
        <img src="'.$item['image'].'">
            <div class="desc">
                <span class="name">'.$item['name'].'</span>
                <div class="checkboxs">
                <div class="not-included">');
                for($i=0;$i<count($ingrArray);$i++)
                {
                    $query_ingr="SELECT * FROM `ingredients` WHERE name='".$ingrArray[$i]."'";
                    $ingr = mysqli_query($database, $query_ingr);

                    $ingr_array=array();
                    while($row=mysqli_fetch_assoc($ingr))
                    {
                    $ingr_array[]=$row;
                    }
                   echo('
                        <img src="'.$ingr_array[0]['image'].'">
                    ');
                }
                echo('</div>
                </div>
                <span class="price">'.$item['price'].'</span>
            </div>
            <div class="close">
                <div class="x-button" onclick="cartAction(\'remove\',\''.$item['cartNumber'].'\');">
                </div>
            </div>
    </div>
    ');
}	
}
echo('</div>
<div class="total-hidden" style="display:none">'.$total.'</div>');
    $_SESSION['total']=$total;
}else
{
    if(isset($_SESSION['cart_item']))
    {
    if(count($_SESSION['cart_item'])!=0)
                                {
                                    foreach($_SESSION['cart_item'] as $meal)
                                    {
                                      echo('
                                                <div class="checkout-item">
                                                <div class="citem-img">
                                                    <img src="'.$meal['image'].'">
                                                </div>
                                                <div class="citem-desc">
                                                    <div class="citem-name">'.$meal['name'].'</div>
                                                    <div class="citem-notincluded">');
                                                    if($meal['notIncluded']!="")
                                                    {
                                                        $notin=substr($meal['notIncluded'],0,-1);
                                                        $ingrs=explode(",",$notin);
                                                        foreach($ingrs as $ing)
                                                        {
                                                            echo('<img src="./images/ingredients/'.$ing.'.png">');
                                                        }
                                                    }
                                                    echo('</div>
                                                    <div class="citem-price">'.$meal['price'].'LL</div>
                                                </div>
                                                <div class="citem-remove">
                                                    <div onclick="removeFromCart('.$meal['cartNumber'].')"></div>
                                                </div>
                                            </div>
                                            ');
                                    }
                                }
                            }
}
?>
