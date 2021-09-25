<?php
session_start();
print_r($_SESSION)
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <!--google maps-->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <!-- -->
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
                            <div class="cart" id="cart">
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
                                                    echo('<img src="./images/ingredients/'.$ingrArray[$i].'.png">');
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
                                <div class="header-container" id="searchButton">
                                    <img style="filter: invert(15%) sepia(24%) saturate(7499%) brightness(100%) contrast(103%);" class="img" src="./images/icons/cart-icon.png">
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
            <div class="account-container">
                    <div class="checkout-container">
                        <div class="checkout-layout">
                            <div class="checkout-items-container">
                                <div class="checkout-items-header">
                                    <div class="c-title">
                                        <img src="./images/icons/checkout.png">
                                        <h3>Checkout</h3>
                                    </div>
                                    <div id="c-itemcount" class="c-itemcount">
                                        <?php
                                        if(isset($_SESSION['cart_item']))
                                        {
                                            echo(count($_SESSION['cart_item']));
                                            if(count($_SESSION['cart_item'])==1)
                                            {
                                                echo(' item');
                                            }else
                                            {
                                                echo(' items');
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="checkout-item-content" class="checkout-items-content">
                                <?php
                                $subtotal=0;
                                $discount=0;
                                $total=0;
                                $tempId=0;
                                if(isset($_SESSION['cart_item']))
                                {
                                    if(count($_SESSION['cart_item'])!=0)
                                    {
                                        foreach($_SESSION['cart_item'] as $meal)
                                        {
                                        $subtotal+=$meal['price'];
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
                                                        <div onclick="removeFromCart('.$tempId.','.$meal['cartNumber'].')"></div>
                                                    </div>
                                                </div>
                                                ');
                                                $tempId++;
                                        }
                                    }
                                }
                                ?>
                                </div>
                            </div>
                            <div class="confirm-order">
                                <div class="co-header">
                                    <div class="co-title">
                                    Confirm your order
                                    </div>
                                    <div class="co-subtitle" id="co-subtitle">
                                    <?php
                                    if(isset($_SESSION['cart_item']))
                                    {
                                        echo(count($_SESSION['cart_item']));
                                        if(count($_SESSION['cart_item'])==1)
                                        {
                                            echo(' item');
                                        }else
                                        {
                                            echo(' items');
                                        }
                                        echo(' in cart');
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="co-list">
                                    <div class="co-item">
                                        <div class="co-item-title">Subtotal</div>
                                        <div class="co-item-total" id="subtotal">
                                            <?php
                                                echo($subtotal."LL");
                                            ?>
                                        </div>
                                    </div>
                                    <div class="co-item">
                                        <div class="co-item-title">Discount</div>
                                        <div class="co-item-total">
                                            <?php
                                                echo($discount."LL");
                                            ?>
                                        </div>
                                    </div>
                                    <div class="co-item">
                                        <div class="co-item-title">Total</div>
                                        <div class="co-item-total" id="total">
                                            <?php
                                                $total=$subtotal-$discount;
                                                echo($total."LL");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="co-payment">
                                    <div class="co-accept">
                                        <div class="co-accept-check">
                                            <input type="checkbox" onclick="toggleTerms(this)">
                                        </div>
                                        <div class="co-accept-terms">
                                            <p>I have read and understood my right of cancellation.</p>
                                            <p>I agree to the beginning of the contract execution before 
                                                the end of the cancellation period. I am aware that I thereby 
                                                lose my right of cancellation.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="co-pay">
                                        <input type="button" onclick="checkout()" disabled id="pay-button" class="b-disabled"value="proceed to checkout">
                                        <p>By clicking PROCEED TO CHECKOUT, you agree to our Terms of Service and that
                                            you have read our Privacy Policy.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="popup" id="popup">
                <div class="popup-front">
                    <div class="checkout">
                        <div class="checkout-left" id="checkout-left">

                        </div>
                        <div class="checkout-right">
                            <div class="checkout-header">
                                <h2 id="checkout-items-count">
                                <?php
                                    if(isset($_SESSION['cart_item']))
                                    {
                                        echo(count($_SESSION['cart_item']));
                                        if(count($_SESSION['cart_item'])==1)
                                        {
                                            echo(' item');
                                        }else
                                        {
                                            echo(' items');
                                        }
                                    }
                                    ?>
                                </h2>
                                <img src="./images/icons/close.png" onclick="closeCheckout()">
                            </div>
                            <div class="checkout-items">
                                <?php
                                
                                if(isset($_SESSION['cart_item']))
                                {
                                    if(count($_SESSION['cart_item'])!=0)
                                    {
                                        foreach($_SESSION['cart_item'] as $meal)
                                        {
                                            echo('
                                            <div class="checkout-cart-item">
                                                <div class="checkout-cart-item-imgbox">
                                                    <img src="'.$meal['image'].'">
                                                </div>
                                                <div class="checkout-cart-item-desc">
                                                    <div class="checkout-cart-item-name">'.$meal['name'].'</div>
                                                    <div class="checkout-cart-item-notincluded">
                                                        <ul>');
                                                        if($meal['notIncluded']!="")
                                                        {
                                                            $notin=substr($meal['notIncluded'],0,-1);
                                                            $ingrs=explode(",",$notin);
                                                            foreach($ingrs as $ing)
                                                            {
                                                                echo('<li>no '.$ing.'</li>');
                                                            }
                                                        } 
                                                        echo('</ul>
                                                    </div>
                                                    <div class="checkout-cart-item-price">'.$meal['price'].'LL</div>
                                                </div>
                                            </div>
                                            ');
                                  
                                        }
                                    }
                                }
                                
                                ?>
                            </div>
                            <div class="checkout-footer">
                                <div class="checkout-footer-total">
                                    <div class="c-text">
                                        Subtotal
                                    </div>
                                    <div id="checkout-items-subtotal" class="c-value">
                                    <?php
                                        echo($subtotal."LL");
                                    ?>
                                    </div>
                                </div>
                                <div class="checkout-footer-total checkout-footer-total--large">
                                    <div class="c-text">
                                        Total
                                    </div>
                                    <div id="checkout-items-total" class="c-value">
                                    <?php
                                        echo($total."LL");
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        

    function removeFromCart(tempid,cart_number)
    {
	    var queryString = "";
		queryString = 'action=remove&site=checkout&cartNumber='+cart_number;
        cartNumber--;
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
        var content=document.getElementById("checkout-item-content");
		$('.checkout-item')[tempid].remove();
        var items=content.getElementsByClassName('checkout-item');
        $('#cart-text').text(items.length);
        $('#cart-text-mobile').text(items.length);
        if(items.length==1)
        {
            $('#c-itemcount').text(items.length+' item');
            $('#co-subtitle').text(items.length+' item');
        }else
        {
            $('#c-itemcount').text(items.length+' items');
            $('#co-subtitle').text(items.length+' items');
        }

        var subtotal=0;
        var discount=0;
        for(var i=0;i<items.length;i++)
        {
            var price=items[i].getElementsByClassName("citem-price")[0].innerText.slice(0,-2);
            subtotal+=parseInt(price);
        }
        $('#subtotal').text(subtotal+"LL");
        var total=subtotal-discount;
        $('#total').text(total+"LL");

        //remove from checkout-right
        $('.checkout-cart-item')[tempid].remove();
        if(items.length==1)
        {
            $('#checkout-items-count').text(items.length+' item');
        }else
        {
            $('#checkout-items-count').text(items.length+' items');
        }
        $('#checkout-items-subtotal').text(subtotal+"LL");
        $('#checkout-items-total').text(total+"LL");
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
    function toggleTerms(element)
    {
        var button=$('#pay-button');
        if($(element).prop('checked')==true)
        {
            button.addClass("button-enabled");
            button.removeClass("button-disabled");
            button.prop("disabled",false);
        }else
        {
            button.removeClass("button-enabled");
            button.addClass("button-disabled");
            button.prop("disabled",true);
        }
    }
    function checkout()
    {
        
        queryString="&action=checkout";
        
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
        url: "./actions/checkout-action.php",
        data:queryString,
        type: "POST",
        success:function(response){
            $('#progress').animate({"width":"100%"},200,function()
            {
                $('#progress').hide();
            });
            if(isJson(response))
            {
                        //if default card is selected
                        var card=JSON.parse(response);
                        SelectCard(card['number']);   
                        
            }
            else
            {
                $('#checkout-left').html(response);
                $('#popup').animate({"right":"0"},250);
                if($("#map").length != 0) {
                    initMap();
                }
            }
        }
        });
    }
    function checkInfo()
            {
                var fn=$('#firstname');
                var ln=$('#lastname');
                var bday=$('#date');
                var save=$('#pinfo-save');
                var md=$('#md');

                if(checkName(fn.val())&&
                checkName(ln.val())&&
                bday.val()!="")
                {
                    md.css("display","none");
                    $('.info').css("border","none");
                    save.addClass("button-enabled");
                    save.removeClass("button-disabled");
                }else
                {
                    save.removeClass("button-enabled");
                    save.addClass("button-disabled");
                }
                
                
            }
            function checkName(str)
            {
                var reg=/^[a-zA-Z0-9]+$/;
                if(reg.test(str))
                {
                    return true;
                }
                return false;
            }

            var lastfn="";
            var lastln="";
            var lastbd="";
            <?php
                if(isset($_SESSION['user']['firstname']))
                {
                    echo('lastfn="'.$_SESSION['user']['firstname'].'";');
                }
                if(isset($_SESSION['user']['lastname']))
                {
                    echo('lastln="'.$_SESSION['user']['lastname'].'";');
                }
                if(isset($_SESSION['user']['birthday']))
                {
                    echo('lastbd="'.$_SESSION['user']['birthday'].'";');
                }
            ?>

            function updateInfo()
            {
                var queryString="";
                
                var fn=$('#firstname');
                var ln=$('#lastname');
                var bday=$('#date');

                var save=$('#pinfo-save');

                if(checkName(fn.val())&&
                checkName(ln.val())&&
                bday.val()!="")
                {
                    if(lastfn==""&&
                    lastln==""&&
                    lastbd=="")
                    {
                    }else
                    {
                        
                            $('#progress').css("width","0");
                                    $('#progress').show();
                                    $('#progress').animate({"width":"49%"},400,function()
                                    {
                                        $('#progress').animate({"width":"50%"},300,function()
                                        {
                                            $('#progress').animate({"width":"70%"},600);
                                        });
                                    });
                            queryString="action=changeInfo&firstname="+fn.val()+"&lastname="+ln.val()+"&birthday="+bday.val()+"&defaultpayment=<?php echo($_SESSION['user']['payment']);?>"+"&card=<?php echo($_SESSION['user']['card']);?>";
                            $.ajax({
                                url: "account-action.php",
                                data:queryString,
                                type: "POST",
                                success:function(response){
                                    $('#progress').animate({"width":"100%"},200,function()
                                    {
                                        $('#progress').hide();
                                    });
                                    if(response=="success")
                                    {
                                        $('#popup').animate({"right":"-100%"},250);
                                        checkout();
                                    }
                                },
                            });
                        
                    }
                }
            }
            function SetPayment(payment)
            {
                queryString="&action=checkout&payment="+payment;
        
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
                url: "./actions/checkout-action.php",
                data:queryString,
                type: "POST",
                success:function(response){
                    $('#progress').animate({"width":"100%"},200,function()
                    {
                        $('#progress').hide();
                    });
                    if(isJson(response))
                    {
                        //if default card is selected
                        var card=JSON.parse(response);
                        SelectCard(card['number']);   
                        
                    }else
                    {
                        $('#checkout-left').html(response);
                        $('#popup').animate({"right":"0"},250);
                        //cod has no select so load map directly
                        if(payment=="Cash on delivery")
                        {
                            initMap();
                        }
                    }   
                    
                }
                });
            }
            function isJson(response)
            {
                try{
                    JSON.parse(response)
                }catch(e)
                {
                    return false;
                }
                return true;
            }
            function closeCheckout()
            {
                $('#popup').animate({"right":"-100%"},250);
            }
            function addCard()
            {
                $.ajax({
                    url: "card.html",
                    success:function(response){
                        $('#add-cards-c').html(response);
                        $('#add-cards-container').show(400);
                    },
                });
            }
            function addCardDb()
            {
                var queryString="";
                var cardnum = $('#card-number');
                var cardname = $('#card-name');
                var cardmonth=$('#card-month');
                var cardyear=$('#card-year');
                var ccv = $('#ccv');


                $('#progress').css("width","0");
                                    $('#progress').show();
                                    $('#progress').animate({"width":"49%"},400,function()
                                    {
                                        $('#progress').animate({"width":"50%"},300,function()
                                        {
                                            $('#progress').animate({"width":"70%"},600);
                                        });
                                    });
                            queryString="action=addCard&number="+cardnum.val()+"&name="+cardname.val()+"&month="+cardmonth.val()+"&year="+cardyear.val()+"&ccv="+ccv.val();
                            $.ajax({
                                url: "./actions/card-action.php",
                                data:queryString,
                                type: "POST",
                                success:function(response){
                                    $('#progress').animate({"width":"100%"},200,function()
                                    {
                                        $('#progress').hide();
                                    });
                                    parseCards(response);
                                    
                                },
                            });
            }
            function closeAddCard()
            {
                $('#add-cards-container').hide(400);
            }
            function parseCards(response)
            {
                var cards=JSON.parse(response);
                $('#checkout-cards-select').html('');
                $('#checkout-cards-select').show();
                $('#checkout-cards-empty').remove();
                for(var i=0;i<cards.length;i++)
                {
                    var ht='<div class="payment-option" onclick="SelectCard('+cards[i]['number']+')">'
                            +cards[i]['number']
                            +'</div>';
                    $('#checkout-cards-select').append(ht);
                }
                closeAddCard();
            }
            function checkCardInfo()
            {
                var cardnum = $('#card-number');
                var cardname = $('#card-name');
                var ccv = $('#ccv');

                if(checkCardNum(cardnum.val())&&
                checkCardName(cardname.val())&&
                checkCCV(ccv.val()))
                {
                    $('#card-save').addClass("button-enabled");
                    $('#card-save').removeClass("button-disabled");
                }else
                {
                    $('#card-save').addClass("button-disabled");
                    $('#card-save').removeClass("button-enabled");
                }
            }
            function checkCardName(str)
            {
                var reg=/^[a-zA-Z]+[a-zA-Z\s]+$/;
                if(reg.test(str))
                {
                    return true;
                }
                return false;
            }
            function checkCardNum(str)
            {
                var reg=/^([0-9]{4}\s){4}$/;
                if(reg.test(str))
                {
                    return true;
                }
                return false;
            }
            var nextCount=4;
            function fixCardNum(element)
            {
                var count=element.value.length;
                if(count==nextCount)
                {
                    element.value=element.value+" ";
                    nextCount+=5;
                }
                if(nextCount-count>5)
                {
                    nextCount-=5;
                }
            }
            function checkCCV(str)
            {
                var reg=/^[0-9]{3}$/;
                if(reg.test(str))
                {
                    return true;
                }
                return false;
            }
            function SelectCard(card_num)
            {
                queryString="&action=checkout&payment=pay&card_number="+card_num;
        
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
                url: "./actions/checkout-action.php",
                data:queryString,
                type: "POST",
                success:function(response){
                    $('#progress').animate({"width":"100%"},200,function()
                    {
                        $('#progress').hide();
                    });
                    if(response!='fail')
                    {
                        $('#checkout-left').html(response);
                        $('#popup').animate({"right":"0"},250);
                        initMap();
                    }
                }
                });
            }
            function goManual()
            {
                var checkoutleft=$('#checkout-left');
                var header='<div class="checkout-location-header"><h2>Input your current location</h2></div>';
                var content='<div class="checkout-items">'
                            +'<div class="info"><input type="text" oninput="checkManualLocation()" id="street" placeholder="Street" class="input-enabled" style="747778"></div>'
                            +'<div class="info"><input type="text" oninput="checkManualLocation()" id="city" placeholder="City" class="input-enabled" style="747778"></div>'
                            +'<div class="info"><input type="text" oninput="checkManualLocation()" id="building" placeholder="Building" class="input-enabled" style="747778"></div>'
                            +'<div class="info"><textarea id="moreinfo" style="resize:none;height:90px" placeholder="Additional Info" class="input-enabled" style="747778"></textarea></div>'
                            +'</div>'
                            +'<div style="margin-right:10px;margin-bottom:10px;display:flex;justify-content:flex-end;align-items:center">'
                                +'<div id="set-location" onclick="acceptManualLocation()" class="add-cards button-disabled" style="text-align:center">Set Location</div>'
                            +'</div>';
                var footer='<div style="width:100%"class="choose-payment-footer">'
                                +'<img src="./images/icons/info.png">'
                                +'<div class="text">Please make sure you give us reliable information as we need it to give you the best experience</div>'
                            +'</div>';

                checkoutleft.html('');
                checkoutleft.append(header);
                checkoutleft.append(content);
                checkoutleft.append(footer);

            }
            function acceptLocation(lati,long)
            {
                queryString="action=automatic&lat="+lati+"&lng="+long;
        
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
                    if(response!='fail')
                    {
                        $('#checkout-left').html(response);
                        $('#popup').animate({"right":"0"},250);
                        $('#cart-text').html('0');
                    }
                }
                });
            }
            function acceptManualLocation()
            {
                var street=$('#street');
                var city=$('#city');
                var building=$('#building');
                var moreinfo=$('#moreinfo');
                queryString="action=manual&street="+street.val()+"&city="+city.val()+"&building="+building.val()+"&moreinfo="+moreinfo.val();
        
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
                    if(response!='fail')
                    {
                        $('#checkout-left').html(response);
                        $('#popup').animate({"right":"0"},250);
                        $('#cart-text').html('0');
                    }
                }
                });
            }
            function checkManualLocation()
            {
                var reg=/[^\s-]/;
                var button=$('#set-location');
                var street=$('#street');
                var city=$('#city');
                var building=$('#building');

                if(reg.test(street.val())&&
                reg.test(city.val())&&
                reg.test(building.val()))
                {
                    button.addClass('button-enabled');
                    button.removeClass('button-disabled');
                    button.prop('disabled',false);
                }else
                {
                    button.removeClass('button-enabled');
                    button.addClass('button-disabled');
                    button.prop('disabled',true);
                }
            }
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly&channel=2"
      async
    ></script>
    <script type="text/javascript">
    // Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.
let map, infoWindow;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 33.963572, lng: 35.6133335 },
    zoom: 8,
  });
  infoWindow = new google.maps.InfoWindow();

  const locationButton = document.createElement("button");

  locationButton.textContent = "Get Current Location";
  locationButton.classList.add("custom-map-control-button");
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
  locationButton.addEventListener("click", () => {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          infoWindow.setPosition(pos);
          infoWindow.setContent("Location found.");
          infoWindow.open(map);
          map.setCenter(pos);
          map.setZoom(18);
          var acceptbutton=$('#accept-location');
          $(acceptbutton).prop('disabled',false);
          $(acceptbutton).addClass("button-enabled");
          $(acceptbutton).removeClass("button-disabled");
          $(acceptbutton).attr('onclick','acceptLocation(\''+pos.lat+'\',\''+pos.lng+'\')');
        },
        () => {
          handleLocationError(true, infoWindow, map.getCenter());
        }
      );
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
  });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}
    </script>
    <script>
        
    // tell the embed parent frame the height of the content
    if (window.parent && window.parent.parent){
      window.parent.parent.postMessage(["resultsFrame", {
        height: document.body.getBoundingClientRect().height,
        slug: ""
      }], "*")
    }

    // always overwrite window.name, in case users try to set it manually
    window.name = "result"
  
    </script>
    <script>
        
      let allLines = []

window.addEventListener("message", (message) => {
  if (message.data.console){
    let insert = document.querySelector("#insert")
    allLines.push(message.data.console.payload)
    insert.innerHTML = allLines.join(";\r")

    let result = eval.call(null, message.data.console.payload)
    if (result !== undefined){
      console.log(result)
    }
  }
})
</script>
</html>