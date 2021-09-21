<?php
session_start();
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
                                    <div class="cart-checkout">
                                       BUY NOW
                                    </div>
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
                                    <a class="user-link" href="#" style="margin:0;">
                                        <img src="./images/icons/logout.png">
                                        <span>Logout</span>
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
                                <a href="favorites.php" class="settings-item" style="filter: invert(15%) sepia(24%) saturate(7499%) brightness(100%) contrast(103%);">
                                    <img src="./images/icons/heart.png">
                                    <span>Favorites</span>
                                </a>
                                <a href="account.php" class="settings-item">
                                    <img src="./images/icons/settings-icon.png">
                                    <span>Settings</span>
                                </a>
                                <a href="orders.php" class="settings-item">
                                    <img src="./images/icons/orders.png">
                                    <span>Orders</span>
                                </a>
                        </div>
                        <div class="favorites-header">
                            <div class="favorites-title">
                                Favorites
                            </div>
                            <div class="sort-div" onclick="toggleSort()">
                                <div class="sort">
                                    <div id="sort-title" class="sort-selected">expensive first</div>
                                    <img class="sort-arrow" id="sort-arrow" src="./images/icons/arrow.png">
                                </div>
                                <div id="sort-dropdown" class="sort-dropdown">
                                    <div class="sort-dropdown-item sort-dropdown-item--active" onclick="sort(this);">
                                        <div class="sort-item-text">
                                            Expensive first
                                        </div>
                                    </div>
                                    <div class="sort-dropdown-item" onclick="sort(this);">
                                        <div class="sort-item-text">
                                            Cheapest first
                                        </div>
                                    </div>
                                    <div class="sort-dropdown-item" onclick="sort(this);">
                                        <div class="sort-item-text">
                                            Newest
                                        </div>
                                    </div>
                                    <div class="sort-dropdown-item" onclick="sort(this);">
                                        <div class="sort-item-text">
                                            Oldest
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="favorites">
                            <?php
                            if(isset($_SESSION['user']['favorites']))
                            {
                                include 'cnx.php';
                                $checkboxCount=0;
                                $allmeals=array();
                                foreach($_SESSION['user']['favorites'] as $fav_meal)
                                {
                                $getFavQuery="SELECT * FROM `meals` WHERE Id='".$fav_meal['meal_id']."'";
                                
                                $resultGetFav=mysqli_query($database,$getFavQuery);
                                    $mealArray=array();
                                    if(mysqli_num_rows($resultGetFav) == 1)
                                    {
                                        while($row=mysqli_fetch_assoc($resultGetFav))
                                        {
                                            $mealArray[]=$row;
                                        }
                                        $meal=$mealArray[0];
                                        array_push($allmeals,$meal);
                                    }
                                }
                                $allcategories=array();
                                foreach($allmeals as $currentmeal)
                                {
                                    array_push($allcategories,$currentmeal['categorie']);
                                }
                                $allcategories=array_unique($allcategories);
                                foreach($allcategories as $cat)
                                {
                                    echo('<div class="favorites-categorie-title">'.$cat.'</div>
                                        <div class="favorites-categorie">');
                                    foreach($allmeals as $currentmeal)
                                    {
                                        
                                        if($currentmeal['categorie']==$cat)
                                        {
                                            echo('
                                            <div class="favorites-item-container">
                                                <div class="favorites-item" id="meal'.$currentmeal['Id'].'">
                                                    <div class="fav-item-imgbox">
                                                        <img src="'.$currentmeal['image'].'">
                                                        <h3>'.$currentmeal['name'].'</h3>
                                                    </div>
                                                    <div class="fav-item-content">
                                                    <div class="main-heart-fav">
                                                    <div>
                                                    <input type="checkbox" class="heart-checkbox"');
                                                    $favs=$_SESSION['user']['favorites'];
                                                    foreach($favs as $fav)
                                                    {
                                                        if($fav['meal_id']==$currentmeal['Id'])
                                                        {
                                                            echo('checked ');
                                                        }
                                                    }
                                                    
                                                    echo('onclick="ManageFavorite(this,'.$currentmeal["Id"].')" id="heart-checkbox-'.$currentmeal["Id"].'"/>
                                                    <label for="heart-checkbox-'.$currentmeal["Id"].'">
                                                        <svg id="heart-svg" viewBox="467 392 58 57">
                                                        <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                                            <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#AAB8C2"/>
                                                            <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>
                                                
                                                            <g id="grp7" opacity="0" transform="translate(7 6)">
                                                            <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                                            <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                                            </g>
                                                
                                                            <g id="grp6" opacity="0" transform="translate(0 28)">
                                                            <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                                            <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                                            </g>
                                                
                                                            <g id="grp3" opacity="0" transform="translate(52 28)">
                                                            <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                                            <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                                            </g>
                                                
                                                            <g id="grp2" opacity="0" transform="translate(44 6)">
                                                            <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                                            <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                                            </g>
                                                
                                                            <g id="grp5" opacity="0" transform="translate(14 50)">
                                                            <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                                            <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                                            </g>
                                                
                                                            <g id="grp4" opacity="0" transform="translate(35 50)">
                                                            <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                                            <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                                            </g>
                                                
                                                            <g id="grp1" opacity="0" transform="translate(24)">
                                                            <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                                            <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                                            </g>
                                                        </g>
                                                        </svg>
                                                    </label>
                                                    </div>
                                                </div>
                                                        <div class="fav-item-desc">
                                                            '.$currentmeal['description'].'
                                                        </div>
                                                        <div class="ingredients">
                                                ');
                                                $mealingredients_array=explode(',',$currentmeal['ingredients']);
                                                for($k=0;$k<count($mealingredients_array);$k++)
                                                {
                                                echo('
                                                    <div>
                                                        <input type="checkbox" name="'.$mealingredients_array[$k].'" id="checkbox'.$checkboxCount.'" checked="true">
                                                        <label for="checkbox'.$checkboxCount.'"><img src="images/ingredients/'.
                                                        $mealingredients_array[$k].
                                                        '.png" /></label>
                                                    </div>');
                                                    $checkboxCount++;
                                                }
                                                echo('</div>
                                                <div class="price"><h2>'.$currentmeal['price'].'</h2></div>
                                                <div class="order">
                                                    <input type="button" id="add_'.$currentmeal['Id'].' name="add" class="order-btn" value="Add to Card" onclick="cartAction(\'add\','.$currentmeal['Id'].');">
                                                    <input type="button" class="order-btn" value="Buy Now">
                                                </div>
                                                </div>
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
                        <a class="user-link" href="#">
                            <img src="./images/icons/settings-icon.png">
                            <span>Settings</span>
                        </a>
                        <a class="user-link" href="#">
                            <img src="./images/icons/orders.png">
                            <span>Orders</span>
                        </a>
                        <a class="user-link" href="#">
                            <img src="./images/icons/heart.png">
                            <span>Favorites</span>
                        </a>
                    </div>
                    <a class="user-link" href="#" style="margin:0;">
                        <img src="./images/icons/logout.png">
                        <span>Logout</span>
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
                    <div class="cart-checkout">
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
    function ManageFavorite(element,id)
    {
        var queryString="";
        if(element.checked)
        {
            queryString="&action=addToFavorites&id="+id;
        }else
        {
            queryString="&action=removeFromFavorites&id="+id;
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
        url: "./actions/favorites-action.php",
        data:queryString,
        type: "POST",
        success:function(response){
            $('#progress').animate({"width":"100%"},200,function()
            {
                $('#progress').hide();
            });
            if(response=="success")
            {
                var item=$(element).parent().parent().parent().parent().parent();
                var categorie=$(item).parent();
                var title=$(categorie).prev();
                $(item).hide(200,function()
                {
                    $(item).remove();
                        if($(categorie).children().length==0)
                        {
                            $(title).hide(200,function()
                            {
                                $(item).remove();
                            });
                        }
                
                });
                
            }
            
        }
        });
    }
    </script>
</html>