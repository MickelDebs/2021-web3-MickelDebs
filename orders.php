<?php
session_start();
if(!isset($_SESSION['user']))
{
    header('location:signin.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <script src="jQuery.js"></script>
    </head>
    <body>
        <div class="root">
            <!--pc interface-->
            <div class="pc-header">
                <div class="header">
                    <div class="header-div">
                        <div class="logo">
                            <div class="logo-img"><img src="./images/logo.png"></div>
                            <a class="logo-text" href="index.php">BFE</a>
                        </div>
                        <div class="header-container">
                            <a href="BuyPage.php" class="a">Menu</a>
                        </div>
                        <div class="header-container">
                            <a href="about.php" class="a" >About</a>
                        </div>
                        <div class="header-container" style="flex-grow:10">
                            <div class="searchDiv">
                                <div class="searchIcon"><img src="./images/icons/search.png"></div>
                                <input type="text" class="searchMealsInput" placeholder="Search meals">
                            </div>
                        </div>
                        <?php
                        if(isset($_SESSION['user']['status']))
                        {
                            echo('
                            <div class="header-container">
                            <div class="cart" id="cart" onclick="enableCart()">
                                <div class="cart-img">
                                    <img src="./images/icons/cart-icon.png">
                                </div>
                                <div id="cart-text"class="cart-text">
                                0
                                </div>
                            </div>
                            <div class="cart-container" id="cart-container">
                                <div class="cart-header">
                                    <span>Cart</span>
                                    <img src="./images/icons/close.png" onclick="enableCart()">
                                </div>
                                <div class="cart-content" id="cart-content">
                                <div class="cart-items">');
                                if(isset($_SESSION['cart_item']))
                                {
                                foreach($_SESSION['cart_item'] as $item)
                                {
                                    if($item['notIncluded']!="")
                                    {
                                        $ings=substr($item['notIncluded'],0,-1);
                                        $ingrArray=explode(",",$ings);
                                    }else
                                    {
                                        $ingrArray=array();
                                    }
                                    echo('
                                    <div class="cart-item">
                                        <img src="'.$item['image'].'">
                                            <div class="desc">
                                                <span class="name">'.$item['name'].'</span>
                                                <div class="checkboxs">
                                                <div class="not-included">');
                                                for($i=0;$i<count($ingrArray);$i++)
                                                {
                                                   echo('
                                                        <img src="./images/ingredients/'.$ingrArray[$i].'.png">
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
                                echo('</div>');
                                if(isset($_SESSION['total']))
                                {
                                    echo('<div class="total-hidden" style="display:none">'.$_SESSION['total'].'</div>');
                                }else
                                {
                                    echo('<div class="total-hidden" style="display:none">0</div>');
                                }
                                echo('</div>
                                <div class="cart-footer">
                                    <div class="footer-header">
                                        <span class="total">Total</span>
                                        <span id="cart-total"class="price">0</span>
                                    </div>
                                    <a class="cart-checkout" href="checkout.php">
                                       BUY NOW
                                    </a>
                                    <div class="cart-clear" onclick="cartAction(\'empty\');">
                                       CLEAR CART
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-container">
                            <div class="profile-container" onclick="showUserSettings()">
                                <div class="profile-img-container">
                                    <img src="'.$_SESSION['user']['picture'].'">
                                </div>
                                <div id="user-arrow" class="profile-arrow">
                                    <img src="./images/icons/arrow.png">
                                </div>
                            </div>
                            <div id="user-settings" class="user-container">
                                <div class="user-dropdown">
                                    <div>
                                        '.$_SESSION['user']['username'].'
                                    </div>
                                    <div class="user-links">
                                        <a class="user-link" href="account.php">
                                            <img src="./images/icons/settings-icon.png">
                                            <span>Settings</span>
                                        </a>
                                        <a class="user-link" href="orders.php">
                                            <img src="./images/icons/orders.png">
                                            <span>Orders</span>
                                        </a>
                                        <a class="user-link" href="favorites.php">
                                            <img src="./images/icons/heart.png">
                                            <span>Favorites</span>
                                        </a>
                                    </div>
                                    <a class="user-link" href="#" onclick="document.getElementById(\'logout-pc\').click()" style="margin:0;">
                                        <img src="./images/icons/logout.png">
                                        <span>Logout</span>
                                        <form style="display:none" method="POST" action="Logout.php">
                                        <input type="submit" name="logout" id="logout-pc">
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </div>');
                            if($_SESSION['user']['status']=="admin")
                                {
                                    echo('<div class="header-container" onclick="location.href=\'admin.php\';">
                                    <img class="img" src="./images/icons/admin-icon.png">
                                    </div>');
                                }
                        }else
                        {
                            echo('<div class="header-container">
                            <a href="signin.php" class="a">Sign in</a>
                        </div>
                        <div class="header-container">
                            <input type="button" value="Sign up" onclick="location.href=\'signup.php\';">
                        </div>');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--Mobile interface-->
            <div class="mobile-header">
                <div class="header">
                    <div class="header-div">
                        <div class="header-container" style="width:45px;margin-left:7px" onclick="openMenu()">
                            <img class="img" src="./images/icons/menu.png" id="menu-img">
                        </div>
                        <div class="logo">
                            <div class="logo-img"><img src="./images/logo.png"></div>
                            <a class="logo-text" href="index.php">BFE</a>
                        </div>
                        <div class="header-container" id="searchButton">
                            <img class="img" src="./images/icons/search.png">
                        </div>
                        <?php
                            if(isset($_SESSION['user']['status']))
                            {
                                echo('
                                <div class="header-container" id="searchButton" onclick="enableCartMobile()">
                                    <img class="img" src="./images/icons/cart-icon.png">
                                    <div class="sub" id="cart-text-mobile" style="display:none">0</div>
                                </div>
                                <div class="header-container">
                                    <div class="profile-container" onclick="showUserSettingsMobile()">
                                        <div class="profile-img-container">
                                            <img src="'.$_SESSION['user']['picture'].'">
                                        </div>
                                    </div>
                                </div>
                                ');
                                if($_SESSION['user']['status']=="admin")
                                {
                                    echo('<div class="header-container" onclick="location.href=\'admin.php\';">
                                    <img class="img" src="./images/icons/admin-icon.png">
                                    </div>');
                                }
                            }else
                            {
                                echo('<div class="header-container" id="loginButtonMobile" onclick="location.href=\'signin.php\';">
                                <img class="img" src="./images/icons/profile-icon.png">
                                </div>');
                            }
                        ?> 
                    </div>
                    <div class="searchDiv" id="searchDiv">
                        <div class="innerSearchDiv">
                            <div class="searchImage">
                                <img src="./images/icons/search.png">
                            </div>
                            <input type="text" placeholder="Search meals">
                            <div class="closeSearchImage" id="searchCloseButton">
                                <img src="./images/icons/close.png">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <div class="background-flex">
        <div id="progress" class="progress"></div>
            <div class="favorites-container">
                    <div class="favorites-content">
                        <div class="favorites-tab">
                                <a href="orders.php" class="settings-item"  style="filter: invert(15%) sepia(24%) saturate(7499%) brightness(100%) contrast(103%);">
                                    <img src="./images/icons/orders.png">
                                    <span>Orders</span>
                                </a>
                                <a href="favorites.php" class="settings-item">
                                    <img src="./images/icons/heart.png">
                                    <span>Favorites</span>
                                </a>
                                <a href="account.php" class="settings-item">
                                    <img src="./images/icons/settings-icon.png">
                                    <span>Settings</span>
                                </a>
                                
                        </div>
                        <div class="favorites-header">
                            <div class="favorites-title">
                                Orders
                            </div>
                        </div>
                        <div class="favorites" style="color:white">
                            <?php

                            if(!empty($_SESSION['user']['orders']))
                            {
                                include 'cnx.php';
                                //getting the meals and the ingredients that are in all orders.
                                $needed_meals=array();
                                $needed_ingredients=array();
                                foreach($_SESSION['user']['orders'] as $order)
                                {
                                    $current_order_meals=explode(',',$order['meals']);
                                    foreach($current_order_meals as $cm)
                                    {
                                        $index=strpos($cm,":");
                                        //get meals
                                        $m=$cm;
                                        if(!empty($index))
                                        {
                                            $m=substr($m,0,$index);
                                        }
                                        array_push($needed_meals,$m);
                                        //get ingredients
                                        $i=$cm;
                                        if(!empty($index))
                                        {
                                            $i=substr($i,$index+1);
                                            $ii=explode('-',$i);
                                            foreach($ii as $ing)
                                            {
                                                array_push($needed_ingredients,$ing);
                                            }
                                        }
                                        
                                    }
                                
                                }
                                //removing the duplicates
                                $needed_meals=array_unique($needed_meals);
                                print_r($needed_meals);
                                $needed_ingredients=array_unique($needed_ingredients);
                                //Preparing them for sql query
                                $str_ids="";
                                foreach($needed_meals as $nm)
                                {
                                    $str_ids.=$nm.',';
                                }

                                $str_ids=substr($str_ids,0,-1);
                                echo($str_ids);
                                //Now they look like this 1,13,15
                                //Same for ingredients
                                $ing_ids="";
                                foreach($needed_ingredients as $ni)
                                {
                                    $ing_ids.=$ni.',';
                                }
                                $ing_ids=substr($ing_ids,0,-1);
                                //Trying to not make the sql query in for loop for better performance
                                $get_orders_meals_query="SELECT * FROM `meals` WHERE `Id` IN (".$str_ids.")";
                                $result_get_meals=mysqli_query($database,$get_orders_meals_query);
                                
                                $mealArray=array();
                                
                                if(mysqli_num_rows($result_get_meals) > 0)
                                {
                                    while($row=mysqli_fetch_assoc($result_get_meals))
                                    {
                                        $mealArray[]=$row;
                                    }
                                }
                                
                                //Same for ingredients
                                $get_orders_ingredients_query="SELECT * FROM `ingredients` WHERE `Id` IN (".$ing_ids.")";
                                $result_get_ingredients=mysqli_query($database,$get_orders_ingredients_query);
                                $ingredientArray=array();

                                if(mysqli_num_rows($result_get_ingredients) > 0)
                                {
                                    while($row=mysqli_fetch_assoc($result_get_ingredients))
                                    {
                                        $ingredientArray[]=$row;
                                    }
                                }
                                $_SESSION['user']['orderMeals']=$mealArray;
                                $_SESSION['user']['orderIngredients']=$ingredientArray;

                                $types=array("active","finished");
                                foreach($types as $type)
                                {
                                   echo('<div class="favorites-categorie-title">'.$type.'</div>
                                   <div class="orders-categorie" id="'.$type.'">');
                                foreach($_SESSION['user']['orders'] as $order)
                                {
                                    if($type==$order['eta'])
                                    {
                                    echo('
                                        <div class="order-container">
                                            <div class="order-item">
                                                <div class="order-header">
                                                    <div class="order-header-item" style="color:#F3A800">Order #'.$order['order_id'].'</div>
                                                    <div class="order-header-item">
                                                        <div>
                                                            Order time: '.$order['time'].' '.$order['date'].'
                                                        </div>
                                                        <div>
                                                            Order amount: '.$order['total'].'LL
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="meal-orders">
                                    ');
                                    $meals=$order['meals'];
                                    $meals=explode(',',$meals);
                                    foreach($meals as $meal)
                                    {
                                        
                                        $dotIndex=strpos($meal,':');
                                        $mealId='';
                                        $thismealingredients=array();

                                        if(empty($dotIndex))
                                        {
                                            $mealId=$meal;
                                        }
                                        else
                                        {
                                            $mealId=substr($meal,0,$dotIndex);

                                            
                                            $ingredients=explode('-',substr($meal,$dotIndex+1));
                                            foreach($ingredients as $ingredient)
                                            {
                                                //Searching for each ingredient id in the array that i got from the database
                                                foreach($ingredientArray as $ingsArray)
                                                {
                                                    foreach($ingsArray as $k => $v)
                                                    {
                                                        if($k=='Id' && $v==$ingredient)
                                                        {
                                                            array_push($thismealingredients,$ingsArray);
                                                        }
                                                    }
                                                }
                                            }
                                            
                                            
                                        }
                                        $thismeal=array();
                                        foreach($mealArray as $mealinfo)
                                        {
                                            foreach($mealinfo as $k=>$v)
                                            {
                                                if($k=='Id' && $v==$mealId)
                                                {
                                                    $thismeal=$mealinfo;
                                                    break;
                                                }
                                            }
                                        }
                                        echo('<div class="meal-order">
                                                <div class="meal-order-info">
                                                    <div class="meal-order-name">
                                                        '.$thismeal['name'].'
                                                    </div>
                                                    <div class="meal-order-image">
                                                        <img src="'.$thismeal['image'].'">
                                                    </div>
                                                    <div class="meal-order-price">
                                                        '.$thismeal['price'].'LL
                                                    </div>
                                                </div>
                                            
                                        ');
                                        if(!empty($thismealingredients))
                                        {
                                            echo('<div class="meal-order-ing">
                                            <ul>');
                                        foreach($thismealingredients as $ing)
                                            {
                                                echo('<li>no '.$ing['name'].'</li>');
                                                
                                            }
                                            echo('<ul>
                                            </div>');
                                        }
                                        echo('
                                            </div>');
                                    }
                                    echo('</div>
                                            <div class="order-footer">
                                                <div class="order-footer-info" >
                                                    <img src="./images/icons/info.png">
                                                    <div class="text">hover on the meals for more info</div>
                                                </div>');
                                                if($order['eta']=="finished")
                                                {
                                                    echo('<div>Order Finished</div>');
                                                }else
                                                {
                                                    echo('
                                                    <div class="finish-order">
                                                        <div>Estimated Delivery Time: '.date("h:i A",strtotime($order['time']) + 60*60).'</div>
                                                        <div class="finish-order-btn" onclick="ConfirmOrder('.$order['order_id'].')">Confirm Order Received</div>
                                                    </div>');
                                                }
                                            echo('</div>
                                    </div>
                                </div>');
                                    }
                                }
                                
                                echo('</div>');
                                }
                            }
                            
                            ?>

                        </div>
                    </div>
            </div>    
            <div class="mobile-menu" id="menu">
                <div class="menu">
                    <div onclick="location.href='BuyPage.php';">Menu</div>
                    <div onclick="location.href='about.php';">About</div>
                </div>
            </div>
            <?php
            if(isset($_SESSION['user']['status']))
            {
                echo('<div id="user-settings-mobile" class="user-container">
                <div class="user-dropdown">
                    <div class="user-header">
                        <span>
                            '.$_SESSION['user']['username'].'
                        </span>
                        <img src="./images/icons/close.png" onclick="showUserSettingsMobile()">
                    </div>
                    <div class="user-links">
                        <a class="user-link" href="account.php">
                            <img src="./images/icons/settings-icon.png">
                            <span>Settings</span>
                        </a>
                        <a class="user-link" href="orders.php">
                            <img src="./images/icons/orders.png">
                            <span>Orders</span>
                        </a>
                        <a class="user-link" href="favorites.php">
                            <img src="./images/icons/heart.png">
                            <span>Favorites</span>
                        </a>
                    </div>
                    <a class="user-link" href="#" onclick="document.getElementById(\'logout-mobile\').click()" style="margin:0;">
                        <img src="./images/icons/logout.png">
                        <span>Logout</span>
                        <form style="display:none" method="POST" action="Logout.php">
                            <input type="submit" name="logout" id="logout-mobile">
                        </form>
                    </a>
                </div>
</div>
<div class="cart-container" id="cart-container-mobile">
                <div class="cart-header">
                    <span>Cart</span>
                    <img src="./images/icons/close.png" onclick="enableCartMobile()">
                </div>
                <div class="cart-content" id="mobile-cart-content">
                <div class="cart-items">');
                if(isset($_SESSION['cart_item']))
                {
                foreach($_SESSION['cart_item'] as $item)
                {
                    if($item['notIncluded']!="")
                    {
                        $ings=substr($item['notIncluded'],0,-1);
                        $ingrArray=explode(",",$ings);
                    }else
                    {
                        $ingrArray=array();
                    }
                    echo('
                    <div class="cart-item">
                        <img src="'.$item['image'].'">
                            <div class="desc">
                                <span class="name">'.$item['name'].'</span>
                                <div class="checkboxs">
                                <div class="not-included">');
                                for($i=0;$i<count($ingrArray);$i++)
                                {
                                   echo('
                                        <img src="./images/ingredients/'.$ingrArray[$i].'.png">
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
                echo('</div>');  
                if(isset($_SESSION['total']))
                                {
                                    echo('<div class="total-hidden" style="display:none">'.$_SESSION['total'].'</div>');
                                }else
                                {
                                    echo('<div class="total-hidden" style="display:none">0</div>');
                                }  
                echo('</div>
                <div class="cart-footer">
                    <div class="footer-header">
                        <span class="total">Total</span>
                        <span id="cart-total-mobile" class="price">0</span>
                    </div>
                    <div class="cart-checkout" onclick="location.href=\'checkout.php\';">
                       BUY NOW
                    </div>
                    <div class="cart-clear" onclick="cartAction(\'empty\');">
                       CLEAR CART
                    </div>
                </div>
            </div>');
            }
            ?>
            <div id="add-cards-container" style="display:none" class="add-cards-container">
                <div class="add-cards-title">
                    <h3>Add Card</h3>
                    <img src="./images/icons/close.png" onclick="closeAddCard()">
                </div>
                <div id="add-cards-c" class="add-cards-c">  
                </div>
                <div class="add-cards-footer">
                    <input type="button" value="Add" id="card-save" onclick="addCardDb()" class="button-disabled">
                </div>
            </div>
        </div>
        </div>
    </body>
    <script>
         <?php
        if(isset($_SESSION['cart_item']))
        {
        echo('$(document).ready(function()
        {
            refreshCart();
        });');
        }
        ?>
        //Scripts for mobile only
        $("#searchButton").click(function()
        {
            $("#searchDiv").slideToggle("fast");
            $("#searchDiv").css("display","flex");
        });

        $("#searchCloseButton").click(function()
        {
            $("#searchDiv").slideToggle("fast");
        });
        
        var cnt=0;
        function openMenu()
        {
            var menu=$('#menu');
            var img=$("#menu-img");
            cnt++;

            if(menu.css("display")=="none")
            {
                if(cnt==1)
                {
                menu.css("display","flex");
                menu.animate({"width":"100%"},500);
                img.fadeOut(250,function()
                {
                    img.attr('src','./images/icons/close.png');
                    img.fadeIn(250);
                });
                cnt=0;
                }
            }else
            {
                if(cnt=1)
                {
                    img.fadeOut(250,function()
                    {
                        img.attr('src','./images/icons/menu.png');
                        img.fadeIn(250);
                    });
                    menu.animate({"width":"0"},500,function()
                    {
                        menu.css("display","none");
                        cnt=0;
                    })
                }
            }
        }
        function showUserSettingsMobile()
        {
            var userCtn=$('#user-settings-mobile');
            userCtn.slideToggle("fast");
        }
        function enableCartMobile()
        {
            var cartContainer=$('#cart-container-mobile');

            cartContainer.slideToggle();
        }
        //End of scripts for mobile only
        var rotation=0;
        function showUserSettings()
        {
            var userCtn=$('#user-settings');
            var arrow=$('#user-arrow');
            userCtn.slideToggle("fast");
            
            rotation+=180;
            rotation%=360;
            arrow.css("transform","rotate("+(rotation)+"deg)");

        }

        var cartNum=1;
        function enableCart()
        {
            var cart=$('#cart');
            var cartContainer=$('#cart-container');

            cartContainer.slideToggle();
            cartNum++;
            if(cartNum%2==0)
            {
                cart.css("background-color","#323738");
            }else
            {
                cart.css("background-color","#F3A800");
            }
        }
        
        var cartNumber=0;
        <?php
            if(isset($_SESSION['cartNumber']))
            {
                echo("cartNumber=".$_SESSION['cartNumber'].";");
            }
        ?>
        

        function cartAction(action,product_code) {
	var queryString = "";
	if(action != "") {
		switch(action) {
			case "add":
                var notIncluded = "";
            
                var itemId="meal"+product_code;
                var item=document.getElementById(itemId);
                var ingredients=item.getElementsByClassName("ingredients")[0];
                for(var i=0;i<ingredients.children.length;i++)
                {
                    if(ingredients.children[i].firstElementChild.checked==false)
                    {
                        notIncluded+=ingredients.children[i].firstElementChild.name+",";
                    }
                }
                cartNumber++;
                queryString = 'action=add'+'&Id='+ product_code+'&notIncluded='+notIncluded+'&cartNumber='+cartNumber;
			break;
			case "remove":
				queryString = 'action='+action+'&cartNumber='+ product_code;
                cartNumber--;
			break;
			case "empty":
				queryString = 'action='+action;
			break;
		}	 
	}
    $('#progress').css("width","0");
    $('#progress').show();
    $('#progress').animate({"width":"49%"},400,function()
    {
        $('#progress').animate({"width":"50%"},300,function()
        {
            $('#progress').animate({"width":"70%"},600);
        });
    });
	jQuery.ajax({
	url: "cart_action.php",
	data:queryString,
	type: "POST",
	success:function(response){
        $('#progress').animate({"width":"100%"},200,function()
        {
            $('#progress').hide();
        });
		$('#cart-content').html(response);
        $('#mobile-cart-content').html(response);
        refreshCart();
	},
	error:function (){}
	});
}

    function refreshCart()
    {
        var c=document.getElementsByClassName("cart-item").length;
        document.getElementById("cart-text").innerText=c/2;
        var cartTextMobile=document.getElementById("cart-text-mobile");
        if(c==0)
        {
            cartTextMobile.style.display="none";
        }else
        {
            cartTextMobile.style.display="flex";
        }
        cartTextMobile.innerText=c/2;

        var total=document.getElementsByClassName("total-hidden");
        document.getElementById("cart-total").innerText=total[0].innerText;
        document.getElementById("cart-total-mobile").innerText=total[0].innerText;
    }
    
    var rot=180;
    function toggleSort()
    {
        var dropdown=$('#sort-dropdown');
        rot+=180;
        rot%=360;
        $('#sort-arrow').css("transform","rotate("+rot+"deg)");
        
        if($(dropdown).css("display")=="none")
        {
            $(dropdown).css("display","block");
            $(dropdown).animate({"opacity":"1"},300);
        }else
        {   
            $(dropdown).animate({"opacity":"0"},300,function()
            {
                $(dropdown).css("display","none");
            });
        }
    }

    function sort(element)
    {
        var text=$(element).first().text();
        $('#sort-title').text(text);
        $('.sort-dropdown-item').removeClass("sort-dropdown-item--active");
        $(element).addClass("sort-dropdown-item--active");

        switch(text)
        {

        }
    }
    function ConfirmOrder(id)
    {
        var queryString = "action=confirm&id="+id;
	    
        
        $('#progress').css("width","0");
        $('#progress').show();
        $('#progress').animate({"width":"49%"},400,function()
        {
            $('#progress').animate({"width":"50%"},300,function()
            {
                $('#progress').animate({"width":"70%"},600);
            });
        });
        jQuery.ajax({
        url: "./actions/order-action.php",
        data:queryString,
        type: "POST",
        success:function(response){
            $('#progress').animate({"width":"100%"},200,function()
            {
                $('#progress').hide();
            });
            var result=JSON.parse(response);
            var active=result['active'];
            var finished=result['finished'];

            var activeElement=$('#active');
            var finishedElement=$('#finished');
            
            
            activeElement.html(parseOrders('active',active));
            finishedElement.html(parseOrders('finished',finished));

        },
        error:function (){}
        });
    }
    function parseOrders(type,a)
    {
        var ht='';
        a.forEach(order => {
                ht+='<div class="order-container">'
                            +'<div class="order-item">'
                                +'<div class="order-header">'
                                    +'<div class="order-header-item" style="color:#F3A800">Order #'+order['order_id']
                                    +'</div>'
                                    +'<div class="order-header-item">'
                                        +'<div>Order Time: '+order['time']+' '+order['date']+'</div>'
                                        +'<div>Order amount: '+order['total']+'LL</div>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="meal-orders">';
                                    var meals=order['meals'];
                                    meals.forEach(meal => {
                                        ht+='<div class="meal-order">'
                                                    +'<div class="meal-order-info">'
                                                        +'<div class="meal-order-name">'+meal['name']+'</div>'
                                                        +'<div class="meal-order-image"><img src="'+meal['image']+'"></div>'
                                                        +'<div class="meal-order-price">'+meal['price']+'LL</div>'
                                                    +'</div>';
                                                            var ings=meal['ingredients'];
                                                            if(ings!='')
                                                            {
                                                                ht+='<div class="meal-order-ing">'
                                                                +'<ul>';
                                                            ings.forEach(ing => {
                                                                ht+='<li>no '+ing['name']+'</li>';
                                                            });
                                                            ht+='</ul>'
                                                            +'</div>'
                                                            }
                                                 ht+='</div>';
                                    });
                                ht+='</div>'
                                +'<div class="order-footer">'
                                    +'<div class="order-footer-info">'
                                        +'<img src="./images/icons/info.png">'
                                        +'<div class="text">hover on the meals for more info</div>'
                                    +'</div>';
                                    if(type=="active")
                                    {
                                        ht+='<div class="finish-order">'
                                            +'<div>Estimated Delivery Time: '+order['deliveryTime']+'</div>'
                                            +'<div class="finish-order-btn" onclick="ConfirmOrder('+order['order_id']+')">Confirm Order Received</div>'
                                        +'</div>';
                                    }else
                                    {
                                        ht+='<div>Order Finished</div>';
                                    }
                                ht+='</div>'
                            +'</div>'
                      +'</div>';
            });
        return(ht);
    }
    </script>
</html>