<?php
session_start();
include 'fetchmeals.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <script src="jQuery.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        function drawChart(name,data) {

            var options = {
            title: name,
            hAxis: {title: 'Time'},
            vAxis: {minValue: 0},
            backgroundColor: 'transparent',
            titleTextStyle: {fontSize:'20'},
            colors:['#F3A800'],
            tooltip:
            {
               isHtml:true
            }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        </script>
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
                                        <span id="cart-total" class="price">0</span>
                                    </div>
                                    <a class="cart-checkout" href="checkout.php">
                                       BUY NOW
                                    </a>
                                    <div class="cart-clear" onclick="cartAction(\'empty\',\'\');">
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
                                <div class="header-container" onclick="enableCartMobile()">
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
            <div class="buymenu-parent">
            <div id="progress" class="progress"></div>
                <div class="buymenu">
                    <div class="buymenu-title">
                        <?php
                            if(isset($categories_array))
                            {
                                for($i=0;$i<count($categories_array);$i++)
                                {
                                    echo('
                                        <div class="buymenu-title-item" onclick="EnableCategories(this,'.$i.')">
                                        <img src="'.$categories_array[$i]['image'].'" class="logo-img">
                                        <div class="food-text">'.$categories_array[$i]['name'].'</div>
                                        </div>
                                    ');
                                }
                            }

                        ?>
                        <!--<div class="buymenu-title-item" onclick="EnableCategories(this,0)" style="background:#F3A800">
                            <img src="images/burger-logo.png" class="logo-img">
                            <div class="food-text">Burgers</div>
                        </div>

                        <div class="buymenu-title-item" onclick="EnableCategories(this,1)">
                            <img src="images/pizza-logo.png" class="logo-img">
                            <div class="food-text">Pizzas</div>
                        </div>-->
                    </div>
                    <div class="buymenu-items">
                            <?php
                                if(!empty($categories_array))
                                {
                                    for($i=0;$i<count($categories_array);$i++){
                                        if($i==0){
                                            echo('<div class="buymenu-categorie">');
                                        }else
                                        {
                                            echo('<div class="buymenu-categorie" style="display:none">');
                                        }
                                    for($j=0;$j<count($meals_array);$j++)
                                    {
                                        if($meals_array[$j]['categorie']==$categories_array[$i]['name']){
                               echo('<div class="container">
                                        <div class="item-card" id=meal'.$meals_array[$j]["Id"].'>
                                            <div class="item-imgBox"  onclick="EnableDescription(this)">
                                                <img src="'.$meals_array[$j]['image'].'">
                                                <span>'.$meals_array[$j]['name'].'</span>
                                            </div>
                                            <div class="item-content">
                                                <div class="arrow" onclick="DisableDescription(this)">
                                                    <img src="./images/icons/arrow.png"> 
                                                </div>
                                                    <div class="main-heart">
                                                    <div>
                                                    <input type="checkbox" class="heart-checkbox"');
                                                    if(isset($_SESSION['user']))
                                                    {
                                                        $favs=$_SESSION['user']['favorites'];
                                                        foreach($favs as $fav)
                                                        {
                                                            if($fav['meal_id']==$meals_array[$j]['Id'])
                                                            {
                                                                echo('checked ');
                                                            }
                                                        }
                                                    }
                                                    
                                                    echo('onclick="');
                                                    if(isset($_SESSION['user']))
                                                    {
                                                        echo('ManageFavorite(this,'.$meals_array[$j]["Id"].')"');
                                                    }else
                                                    {
                                                        echo('location.href=\'signin.php\'"');
                                                    }
                                                    echo('id="heart-checkbox-'.$meals_array[$j]["Id"].'"/>
                                                    <label for="heart-checkbox-'.$meals_array[$j]["Id"].'">
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
                                                <div class="info-stats" onclick="showStats('.$meals_array[$j]['Id'].')">
                                                    <img src="./images/icons/info.png">
                                                </div>
                                                <div class="description">
                                                        '.$meals_array[$j]['description'].'
                                                </div>
                                                <div class="ingredients">
                                                ');
                                                for($k=0;$k<count($mealingredients_array[$j]);$k++)
                                                {
                                                echo('
                                                    <div>
                                                        <input type="checkbox" name="'.$mealingredients_array[$j][$k].'" id="checkbox'.$checkboxCount.'" checked="true">
                                                        <label for="checkbox'.$checkboxCount.'"><img src="images/ingredients/'.
                                                        $mealingredients_array[$j][$k].
                                                        '.png" /></label>
                                                    </div>');
                                                    $checkboxCount++;
                                                }
                                                echo('</div>
                                                <div class="price"><h2>'.$meals_array[$j]['price'].'</h2></div>
                                                <div class="order">
                                                    <input type="button" id="add_'.$meals_array[$j]['Id'].' name="add" class="order-btn" value="Add to Card" onclick="cartAction(\'add\','.$meals_array[$j]['Id'].');">
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
                <div class="mobile-menu"  id="menu">
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
                        <span class="price" id="cart-total-mobile">0</span>
                    </div>
                    <div class="cart-checkout" onclick="location.href=\'checkout.php\';">
                       BUY NOW
                    </div>
                    <div class="cart-clear" onclick="cartAction(\'empty\')">
                       CLEAR CART
                    </div>
                </div>
            </div>');
            }
            ?>
            <div class="add-cards-container" id="stats-container" style="display:none">
                <div class="add-cards-title">
                    <h3>Stats</h3>
                    <img src="./images/icons/close.png" onclick="closeStats()">
                </div>
                <div class="stats" id="stats" >  
                    <div id="chart_div" style="width:100%;height:500px">

                    </div>
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
        var itemsCount=0;
        
        
        function EnableSidePanels(element,num)
        {
            var elementParent=element.parentElement;
            var parent=element.parentElement.nextElementSibling;
            for(var i=0;i<parent.children.length;i++)
            {
                elementParent.children[i].style.removeProperty('background');
                $(parent.children[i]).hide();
            }
            element.style.background="#F3A800";
            $(parent.children[num]).show();
        }
        function EnableCategories(element,num)
        {
            var elementParent=element.parentElement;
            var categorieParent=element.parentElement.nextElementSibling;
            for(var i=0;i<categorieParent.children.length;i++)
            {
                elementParent.children[i].style.removeProperty('background');
                $(categorieParent.children[i]).hide();
            }
            element.style.background="#F3A800";
            $(categorieParent.children[num]).show();
        }
        function EnableDescription (element)
        {
            DisableAll();
            var content=element.parentElement.children[1];

            content.style.height="100%";
            content.firstElementChild.firstElementChild.style.animation="rotate 0.5s forwards";
        }
        function DisableDescription(element)
        {
            var arrow=element;
            var content=arrow.parentElement;

            if(content.style.height=="100%")
            {
                content.style.height="5%";
                content.firstElementChild.firstElementChild.style.animation="rotateback 0.5s forwards";
            }else
            {
                content.style.height="100%";
                content.firstElementChild.firstElementChild.style.animation="rotate 0.5s forwards";
            }
        }
        function DisableAll()
        {
            var contents=$(".item-content");
            for(var i=0;i<contents.length;i++)
            {
                contents[i].style.height="5%";  
                contents[i].firstElementChild.firstElementChild.style.animation="rotateback 0.5s forwards";
            }
        }


        function UpdateTotal()
        {
            var buynow=$('#cart-content-buynow');
            var cartcontentitems=document.getElementById("cart-content-items");
            var total=0;
            var span=buynow.get(0).firstElementChild.firstElementChild;
            if(itemsCount==0)
            {
                buynow.slideToggle();
            }
            for(var i=0;i<cartcontentitems.children.length;i++)
            {
                total+=fixPrice(cartcontentitems.children[i].children[1].children[2].innerHTML);
            }
            span.innerText="Total:"+total;

            
        }
        function fixPrice(str)
        {
            /*if(Number.isInteger(str))
            {
                var price=str+"";
                
                for(var i=price.length;i>0;i--)
                {
                   if((i+1)%3==0){
                       price=[price.slice(0,i),price.slice(i)].join();
                        console.log(price);
                    }
                }

                return price;
            }*/
            s=str.replace(",","");
            s=s.replace("LL","");
            return parseInt(s);
        }
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
        $('#loginButtonMobile').click(function()
        {
            $('#login-box').show(400);
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
            console.log(response);
        }
        });
    }
    function closeStats()
    {
        $('#stats-container').hide(400);
    }
    function showStats(id)
    {
        var stats=$('#stats-container');
        $(stats).show(400);
        var statsinner=$('#chart_div');
        $(statsinner).html('');
        var queryString='id='+id;

        jQuery.ajax({
            url: "./actions/chart-action.php",
            data:queryString,
            type: "POST",
            success:function(response){
                $('#progress').animate({"width":"100%"},200,function()
                {
                    $('#progress').hide();
                });
                $('#cart-content').html(response);
                $('#mobile-cart-content').html(response);
                json=JSON.parse(response);
                
                meal=json.title;
                jsonData=json.data;

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Time');
                data.addColumn('number', 'Sales');

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].time, jsonData[i].number]);
                }
                drawChart(meal+" sales",data);
            },
            error:function (){}
            });
            }
    </script>
</html>