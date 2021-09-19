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
            <div class="account-container">
                <div class="account-content">
                    <div class="settings-header">
                        <div class="settings-tab">
                            <a href="account.php" class="settings-item" style="filter: invert(15%) sepia(24%) saturate(7499%) brightness(100%) contrast(103%);">
                                <img src="./images/icons/settings-icon.png">
                                <span>Settings</span>
                            </a>
                            <a href="orders.php" class="settings-item">
                                <img src="./images/icons/orders.png">
                                <span>Orders</span>
                            </a>
                            <a href="favorites.php" class="settings-item">
                                <img src="./images/icons/heart.png">
                                <span>Favorites</span>
                            </a>
                        </div>
                        <div class="settings-title">
                            Settings
                        </div>
                    </div>
                    <div class="account-desc">
                            <div class="account-info">
                                <div class="info-categorie">
                                <div class="info-title">General</div>
                                <div class="tab-holder">
                                    <div class="change-password-header-parent" id="change-password-header-parent">
                                        <div class="change-password-header" id="change-password-header">
                                            <span>Change Password</span>
                                            <img src="./images/icons/close.png" onclick="changePassword()">
                                        </div>
                                    </div>
                                    <div class="change-pass-submit button-disabled" id="click-submit-button" onclick="ChangePasswordAJAX()">
                                    Change
                                    </div>
                                    <div class="info-container">
                                        <div class="info">
                                            <span class="name">Username</span>
                                            <div class="info-div">
                                                <input type="text" value="<?php echo($_SESSION['user']['username']);?>" disabled>
                                            </div>
                                        </div>
                                        <div class="info">
                                            <span class="name">Email</span>
                                            <div class="info-div">
                                                <input type="text" value="<?php echo($_SESSION['user']['email']);?>" disabled>
                                            </div>    
                                        </div>
                                        <div class="info">
                                            <span class="name">Password</span>
                                            <div class="info-div">
                                                <input type="password" value="placeholder" disabled>
                                                <img class="info-change" src="./images/icons/change.png" onclick="changePassword()">
                                            </div>
                                        </div>
                                        
                                        <div id="change-password" class="change-password">
                                            <div class="change-password-content">
                                                <div class="info">
                                                    <input type="password" oninput="Check()" id="oldpass" placeholder="old password"  class="input-pass" >
                                                </div>
                                                <div class="info">
                                                    <input type="password" oninput="Check()" placeholder="new password"  class="input-pass" id="pass">
                                                    <div class="spinner-parent" style="right:30px">
                                                        <div class="spinner" id="pass-spinner">
                                                        </div>
                                                        <div class="spinner-error" data-title="Password needs to be atleast 8 characters and 
                                                                contains atleast a number and a special character" id="pass-error">
                                                        </div>
                                                        <div class="spinner-correct" id="pass-correct">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="info" style="margin:0px">
                                                    <input type="password" oninput="Check()" placeholder="confirm new password"  id="cpass" class="input-pass">
                                                    <div class="spinner-parent" style="right:30px">
                                                        <div class="spinner" id="cpass-spinner">
                                                        </div>
                                                        <div class="spinner-error" data-title="Passwords need to match" id="cpass-error">
                                                        </div>
                                                        <div class="spinner-correct" id="cpass-correct">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="pass-change-result">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="info-categorie">
                                        <div class="info-title">
                                                Profile Picture
                                            </div>
                                        <div class="info-container">
                                            <div class="picture-container">
                                                <div class="picture-box">
                                                    <img id="img-src" src="<?php echo($_SESSION['user']['picture']);?>">
                                                </div>
                                                    <input type="file" accept=".png, .jpg, .jpeg" name="profileImg" id="select-picture" style="display:none" onchange="changeProfilePictureAJAX()">
                                                    <div class="picture-info">
                                                        <input type="button" class="input-button button-enabled" value="Choose Image" onclick="$('#select-picture').click()">
                                                        <div id="img-name"></div>
                                                    </div>
                                                <div class="picture-save-div">
                                                    <input type="button" value="Save" class="button-disabled picture-save" id="picture-save" onclick="uploadPicture()">
                                                    <input type="submit" style="display:none" name="profileSubmit">
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="account-info">
                                <div class="info-categorie">
                                    <div class="info-title">
                                        Personal Info
                                    </div>
                                    <div class="info-container">
                                        <div class="info">
                                            <input type="text" id="firstname" oninput="checkInfo()" placeholder="First Name" class="input-enabled"
                                            <?php 
                                            if(isset($_SESSION['user']['firstname']))
                                            {
                                                echo('style="color:#747778" disabled value="'.$_SESSION['user']['firstname'].'"');
                                            }
                                            ?>
                                            >
                                            <?php
                                            if(isset($_SESSION['user']['firstname']))
                                            {
                                                echo('<img src="./images/icons/lock.png" class="info-lock" onclick="unlockInfo(this)">');
                                            }
                                            ?>
                                        </div>
                                        <div class="info">
                                            <input type="text" id="lastname"  oninput="checkInfo()"class="input-enabled" placeholder="Last Name"
                                            <?php 
                                            if(isset($_SESSION['user']['lastname']))
                                            {
                                                echo('style="color:#747778" disabled value="'.$_SESSION['user']['lastname'].'"');
                                            }
                                            ?>
                                            >
                                            <?php
                                            if(isset($_SESSION['user']['lastname']))
                                            {
                                                echo('<img src="./images/icons/lock.png" class="info-lock" onclick="unlockInfo(this)">');
                                            }
                                            ?>
                                        </div>
                                        <div class="subtitle">
                                            Birthday
                                        </div>
                                        <div class="info">
                                            <input type="date" id="date" oninput="checkInfo()"
                                            <?php 
                                            if(isset($_SESSION['user']['birthday']))
                                            {
                                                echo('style="color:#747778" disabled value="'.$_SESSION['user']['birthday'].'"');
                                            }
                                            ?>
                                            >
                                            <?php
                                            if(isset($_SESSION['user']['birthday']))
                                            {
                                                echo('<img src="./images/icons/lock.png" class="info-lock" onclick="unlockInfo(this)">');
                                            }
                                            ?>
                                        </div>
                                        <div class="subtitle">
                                            Default Payment Method
                                        </div>
                                        <div class="info">
                                            <label class="radio">Always ask
                                                <input type="radio" onchange="checkInfo()" checked name="DefaultPayment" value="Always ask">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio">Credit Card
                                                <input type="radio" onchange="checkInfo()" <?php if($_SESSION['user']['payment']=='Credit Card'){echo('checked');}?> name="DefaultPayment" value="Credit Card">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio">Cash on Delivery
                                                <input type="radio" onchange="checkInfo()" <?php if($_SESSION['user']['payment']=='Cash on Delivery'){echo('checked');}?> name="DefaultPayment" value="Cash on Delivery">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="subtitle">
                                            Credit or debit cards
                                        </div>
                                        <div class="info">
                                            <div class="cards-select">
                                                <div class="cards">
                                                    <label class="radio">Always ask
                                                        <input type="radio" id="all-always" onchange="checkInfo()" checked="checked" name="DefaultCard" value="Always ask">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div id="all-cards">
                                                    
                                                        <?php
                                                        if(isset($_SESSION['user']['cards']))
                                                        {
                                                            $cards=$_SESSION['user']['cards'];
                                                            foreach($cards as $card)
                                                            {
                                                                if($card['card_id']==$_SESSION['user']['card'])
                                                                {
                                                                    echo('<div class="cards">
                                                                    <div class="card">
                                                                            <label class="radio">'.$card['number'].'
                                                                                <input type="radio" onchange="checkInfo()" checked name="DefaultCard" value="'.$card['card_id'].'">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="edit-card">
                                                                            <img src="./images/icons/delete.png" onclick="removeCardAjax('.$card['card_id'].')">
                                                                        </div>
                                                                        </div>');
                                                                }else
                                                                {
                                                                    echo('<div class="cards">
                                                                    <div class="card">
                                                                            <label class="radio">'.$card['number'].'
                                                                                <input type="radio" onchange="checkInfo()" name="DefaultCard" value="'.$card['card_id'].'">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="edit-card">
                                                                            <img src="./images/icons/delete.png" onclick="removeCardAjax('.$card['card_id'].')">
                                                                        </div>
                                                                        </div>');
                                                                }
                                                                
                                                            }
                                                        } 
                                                        ?>
                                                </div>
                                                <div class="cards" style="justify-content:flex-end">
                                                    <div class="add-cards" onclick="addCard()">
                                                    Add card
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pinfo-save button-disabled" id="pinfo-save" onclick="updateInfo()">
                                            Save
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
    
    function changePassword()
    {
        if($('#change-password').css('height')=="0px")
        {
            $('#change-password').css('height','100%');
            $('#change-password-header-parent').show(500);
            $('#click-submit-button').show(500);
        }else
        {
            $('#change-password').css('height','0');
            $('#change-password-header-parent').hide(500);
            $('#click-submit-button').hide(500);

        }
    }

    //Check Password
    var input = $('#pass');

// Init a timeout variable to be used below
var timeout = null;

// Listen for keystroke events
input.keyup(function(){
    $('#pass-spinner').show();
    $('#pass-error').hide();
    $('#pass-correct').hide();

    clearTimeout(timeout);
    timeout = setTimeout(function () {
        if(CheckPass(input.val())==true)
        {
            $('#pass-spinner').hide();
            $('#pass-error').hide();
            $('#pass-correct').show();
        }else
        {
            $('#pass-spinner').hide();
            $('#pass-error').show();
            $('#pass-correct').hide();
        }
    }, 400);
});

function CheckPass(str)
        {
            var reg=/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?& ]{8,}$/;

            if(str.match(reg))
            {
                return true;
            }
            return false;
        }

        var cinput = $('#cpass');

// Init a timeout variable to be used below
var ctimeout = null;

// Listen for keystroke events
cinput.keyup(function(){
    $('#cpass-spinner').show();
    $('#cpass-error').hide();
    $('#cpass-correct').hide();

    clearTimeout(ctimeout);
    ctimeout = setTimeout(function () {
        if(cinput.val()==$('#pass').val())
        {
            $('#cpass-spinner').hide();
            $('#cpass-error').hide();
            $('#cpass-correct').show();
        }else
        {
            $('#cpass-spinner').hide();
            $('#cpass-error').show();
            $('#cpass-correct').hide();
        }
    }, 400);
});

function Check()
            {
                var button=$("#click-submit-button");
                
                var oldpass=document.getElementById("oldpass").value;
                var password=document.getElementById("pass").value;
                var cpassword=document.getElementById("cpass").value;

                if(CheckPass(password)&&
                CheckPass(oldpass)&&
                password==cpassword)
                {
                    button.addClass("button-enabled");
                    button.removeClass("button-disabled");
                }else
                {
                    button.removeClass("button-enabled");
                    button.addClass("button-disabled");
                }
            }
            function changePasswordfunction()
            {
                var oldpass=document.getElementById("oldpass");
                var pass=document.getElementById("pass");
                var cpass=document.getElementById("cpass");
                
                var boolArray=[];
                    boolArray.push(CheckPass(oldpass.value));
                    boolArray.push(CheckPass(pass.value));
                    boolArray.push(pass.value==cpass.value);
                    for(var i=0;i<boolArray.length;i++)
                        {
                            if(boolArray[i]==false)
                            {
                            event.preventDefault();
                            return false;
                            }
                        }
                return true;
            }

            function ChangePasswordAJAX()
            {
                var queryString="";

                var oldpass=document.getElementById("oldpass");
                var newpass=document.getElementById("pass");
                var cpass=document.getElementById("cpass");

                var boolArray=[];
                boolArray.push(CheckPass(oldpass.value));
                boolArray.push(CheckPass(pass.value));
                boolArray.push(pass.value==cpass.value);
                for(var i=0;i<boolArray.length;i++)
                    {
                    if(boolArray[i]==false)
                    {
                        event.preventDefault();
                        return false;
                    }
                }
                queryString='action=changePassword'+'&oldpass='+oldpass.value+'&newpass='+newpass.value+'&cpass='+cpass.value;

                $('#progress').css("width","0");
                $('#progress').show();
                $('#progress').animate({"width":"49%"},400,function()
                {
                    $('#progress').animate({"width":"50%"},300,function()
                    {
                        $('#progress').animate({"width":"70%"},600);
                    });
                });

                $.ajax({
                url: "account-action.php",
                data:queryString,
                type: "POST",
                success:function(response){
                    $('#progress').animate({"width":"100%"},200,function()
                    {
                        $('#progress').hide();
                    });
                    $('#pass-change-result').html(response);
                    
                },
                error:function (){}
                });
            }
            function checkProfilePicture(element)
            {
                var files=$(element)[0].files;
                var save=$("#picture-save");

                if(files.length>0)
                {
                    save.addClass("button-enabled");
                    save.removeClass("button-disabled");
                }else
                {
                    save.removeClass("button-enabled");
                    save.addClass("button-disabled");
                }
            }
            function changeProfilePictureAJAX()
            {
                var fd = new FormData();
                var files = $('#select-picture')[0].files;
                
                // Check file selected or not
                if(files.length > 0 ){
                    fd.append('file',files[0]);
                        $('#progress').css("width","0");
                        $('#progress').show();
                        $('#progress').animate({"width":"49%"},400,function()
                        {
                            $('#progress').animate({"width":"50%"},300,function()
                            {
                                $('#progress').animate({"width":"70%"},600);
                            });
                        });
                    $.ajax({
                        url: 'account-action.php',
                        type: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            $('#progress').animate({"width":"100%"},200,function()
                            {
                                $('#progress').hide();
                            });
                            $('#img-src').attr('src',response);
                            checkProfilePicture($('#select-picture'));
                        },
                    });
                }
            }
            function uploadPicture()
            {
                var src=$('#img-src').attr('src');
                var queryString='action=uploadPicture'+'&source='+src;
                $('#progress').css("width","0");
                        $('#progress').show();
                        $('#progress').animate({"width":"49%"},400,function()
                        {
                            $('#progress').animate({"width":"50%"},300,function()
                            {
                                $('#progress').animate({"width":"70%"},600);
                            });
                        });
                $.ajax({
                    url: "account-action.php",
                    data:queryString,
                    type: "POST",
                    success:function(response){
                        $('#progress').animate({"width":"100%"},200,function()
                        {
                            $('#progress').hide();
                        });
                        $('#img-name').html(response);
                        $('#select-picture').val('');
                        $('#picture-save').addClass("button-disabled");
                        $('#picture-save').removeClass("button-enabled");
                    },
                });
            }

            function checkInfo()
            {
                var fn=$('#firstname');
                var ln=$('#lastname');
                var bday=$('#date');
                var save=$('#pinfo-save');

                if(checkName(fn.val())&&
                checkName(ln.val())&&
                bday.val()!="")
                {
                    
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
            function unlockInfo(element)
            {
                element.parentElement.firstElementChild.disabled=false;
                element.parentElement.firstElementChild.style.color="white";
                element.style.display="none";
            }
            function lockInfo()
            {
                var element=document.getElementsByClassName("info-lock");
                for(var i=0;i<element.length;i++)
                {
                    element[i].parentElement.firstElementChild.disabled=true;
                    element[i].parentElement.firstElementChild.style.color="#747778";
                    element[i].style.display="block";
                }
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

                var defaultpayment=$('input[name="DefaultPayment"]:checked').val();
                var card=$('input[name="DefaultCard"]:checked').val();
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
                            queryString="action=changeInfo&firstname="+fn.val()+"&lastname="+ln.val()+"&birthday="+bday.val()+"&defaultpayment="+defaultpayment+"&card="+card;
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
                                        lockInfo();
                                        lastfn=fn.val();
                                        lastln=ln.val();
                                        lastbd=bday.val();
                                        $('#pinfo-save').addClass("button-disabled");
                                        $('#pinfo-save').removeClass("button-enabled");
                                    }
                                },
                            });
                        
                    }
                }
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
            function closeAddCard()
            {
                $('#add-cards-container').hide(400);
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
            function removeCardAjax(cardid)
            {
                var queryString="";

                $('#progress').css("width","0");
                                    $('#progress').show();
                                    $('#progress').animate({"width":"49%"},400,function()
                                    {
                                        $('#progress').animate({"width":"50%"},300,function()
                                        {
                                            $('#progress').animate({"width":"70%"},600);
                                        });
                                    });
                            queryString="action=removeCard&id="+cardid;
                            $.ajax({
                                url: "./actions/card-action.php",
                                data:queryString,
                                type: "POST",
                                success:function(response){
                                    $('#progress').animate({"width":"100%"},200,function()
                                    {
                                        $('#progress').hide();
                                    });
                                    $('#all-always').prop("checked",true);
                                    parseCards(response);
                                },
                            });
            }
            var currentCard="";
            <?php
                if(isset($_SESSION['user']['cards']))
                {
                    if($_SESSION['user']['card']!='Always ask')
                    {
                        echo('currentCard="'.$_SESSION['user']['card'].'";');
                    }   
                }
            ?>
            function parseCards(response)
            {
                var cards=JSON.parse(response);
                                    $('#all-cards').html('');
                                    for(var i=0;i<cards.length;i++)
                                    {
                                        var ht='';
                                        if(cards[i]['card_id']==currentCard)
                                        {
                                                ht='<div class="cards">'
                                                        +'<div class="card">'
                                                            +'<label class="radio">'+cards[i]['number']
                                                                +'<input type="radio" onchange="checkInfo()" checked name="DefaultCard" value="'+cards[i]['card_id']+'">'
                                                                +'<span class="checkmark"></span>'
                                                            +'</label>'
                                                        +'</div>'
                                                        +'<div class="edit-card">'
                                                            +'<img src="./images/icons/delete.png" onclick="removeCardAjax('+cards[i]['card_id']+')">'
                                                        +'</div>'
                                                    +'</div>';
                                        }
                                        else
                                        {
                                                ht='<div class="cards">'
                                                        +'<div class="card">'
                                                            +'<label class="radio">'+cards[i]['number']
                                                                +'<input type="radio" onchange="checkInfo()" name="DefaultCard" value="'+cards[i]['card_id']+'">'
                                                                +'<span class="checkmark"></span>'
                                                            +'</label>'
                                                        +'</div>'
                                                        +'<div class="edit-card">'
                                                            +'<img src="./images/icons/delete.png" onclick="removeCardAjax('+cards[i]['card_id']+')">'
                                                        +'</div>'
                                                    +'</div>';
                                        }
                                       
                                        $('#all-cards').append(ht);
                                    }
                                    closeAddCard();
            }
                
    </script>
</html>