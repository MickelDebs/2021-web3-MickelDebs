<?php
session_start();
?>
<!DOCTYPE html>
<?php
    include 'fetchmeals.php';

?>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
        <script src="jQuery.js"></script>
    </head>
    <body>
        <div class="root"> 
        <?php
            if(isset($_SESSION['status']))
            {
                $status=$_POST['status'];
                if($status=='admin')
                {
                    
                }
            }
        ?>
    <!--pc interface-->
    <div class="pc-header">
                <div class="header">
                    <div class="header-div">
                        <div class="logo">
                            <div class="logo-img"><img src="./images/logo.png"></div>
                            <a class="logo-text" href="index.php">BFE</a>
                        </div>
                        <div class="header-container">
                            <a href="BuyPage.php">Menu</a>
                        </div>
                        <div class="header-container">
                            <a href="about.php">About</a>
                        </div>
                        <div class="header-container" style="flex-grow:10">
                            <div class="searchDiv">
                                <div class="searchIcon"><img src="./images/icons/search.png"></div>
                                <input type="text" class="searchMealsInput" placeholder="Search meals">
                            </div>
                        </div>
                        <!-- To do in php-->
                        <div class="header-container" onclick="location.href='admin.php';">
                            <img src="./images/icons/admin-icon.png">
                        </div>
                        <!-- -->
                        <div class="header-container">
                            <input type="button" onclick="location.href='signin.php';" value="Sign in" id="signin">
                        </div>
                    </div>
                </div>
            </div>
            <!--mobile-header interface-->
            <div class="mobile-header">
                <div class="header">
                    <div class="header-div">
                        <div class="header-container" style="width:45px;margin-left:7px" onclick="openMenu()">
                            <img src="./images/icons/menu.png" id="menu-img">
                        </div>
                        <div class="logo">
                            <div class="logo-img"><img src="./images/logo.png"></div>
                            <a class="logo-text" href="index.php">BFE</a>
                        </div>
                        <div class="header-container" id="searchButton">
                            <img src="./images/icons/search.png">
                        </div>
                        <div class="header-container" id="loginButtonmobile-header" onclick="location.href='signin.php';">
                            <img src="./images/icons/profile-icon.png">
                        </div>
                        <!-- To do in php-->
                        <div class="header-container" onclick="location.href='admin.php';">
                            <img src="./images/icons/admin-icon.png">
                        </div>
                        <!-- -->
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
                                        <div class="item-card">
                                            <div class="item-imgBox"  onclick="EnableDescription(this)">
                                                <img src="'.$meals_array[$j]['image'].'">
                                                <span>'.$meals_array[$j]['name'].'</span>
                                            </div>
                                            <div class="item-content">
                                                <div class="arrow" onclick="DisableDescription(this)">
                                                    <img src="./images/icons/arrow.png"> 
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
                                                        <input type="checkbox" id="checkbox'.$checkboxCount.'" checked="true">
                                                        <label for="checkbox'.$checkboxCount.'"><img src="images/ingredients/'.
                                                        $mealingredients_array[$j][$k].
                                                        '.png" /></label>
                                                    </div>');
                                                    $checkboxCount++;
                                                }
                                                echo('</div>
                                                <div class="price"><h2>'.$meals_array[$j]['price'].'</h2></div>
                                                <div class="order">
                                                    <input type="button" value="Add to Card" onclick="AddToCart(this)">
                                                    <input type="button" value="Buy Now">
                                                </div>
                                            </div>
                                        </div>     
                                   </div>'); 
                                            }else
                                            {
                                                //echo('<div style="color:white;font-size:20px">Categorie is empty</div>');
                                            }
                                    }
                                echo('</div>');
                                }
                            }

                            ?>
                            <!--<div class="container">
                                <div class="item-card" onclick="EnableDescription(this)">
                                    <div class="item-imgBox">
                                        <img src="images/burgers/burger1.png">
                                        <h2>Double Cheese Bacon Burger</h2>
                                    </div>
                                    <div class="item-content">
                                        <div class="description">
                                                <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus cumque natus, alias similique aut nemo. Illo dicta reiciendis quae rerum.</h3>
                                        </div>
                                        <div class="ingredients">
                                            <div>
                                                <input type="checkbox" id="checkbox1" checked="true">
                                                <label for="checkbox1"><img src="images/burger-logo.png" /></label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="checkbox2" checked="true">
                                                <label for="checkbox2"><img src="images/burger-logo.png" /></label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="checkbox3" checked="true">
                                                <label for="checkbox3"><img src="images/burger-logo.png" /></label>
                                            </div>
                                        </div>
                                        <div class="price"><h2>24,000LL</h2></div>
                                        <div class="order">
                                            <input type="button" value="Add to Card" onclick="AddToCart(this)">
                                            <input type="button" value="Buy Now">
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                                                                  
                        </div>
                        <!--
                        <div class="buymenu-categorie" style="display:none">
                            <div class="container">
                                <div class="item-card" onclick="EnableDescription(this)">
                                    <div class="item-imgBox">
                                        <img src="images/backgroundFood1.png">
                                        <h2>Tomato Pizza</h2>
                                    </div>
                                    <div class="item-content">
                                        <div class="description">
                                                <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus cumque natus, alias similique aut nemo. Illo dicta reiciendis quae rerum.</h3>
                                        </div>
                                        <div class="ingredients">
                                            <div>
                                                <input type="checkbox" id="checkbox4" checked="true">
                                                <label for="checkbox4"><img src="images/pizza-logo.png" /></label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="checkbox5" checked="true">
                                                <label for="checkbox5"><img src="images/burger-logo.png" /></label>
                                            </div>
                                            <div>
                                                <input type="checkbox" id="checkbox6" checked="true">
                                                <label for="checkbox6"><img src="images/pizza-logo.png" /></label>
                                            </div>
                                        </div>
                                        <div class="price"><h2>36,000LL</h2></div>
                                        <div class="order">
                                            <input type="button" value="Add to Card" onclick="AddToCart(this)">
                                            <input type="button" value="Buy Now">
                                        </div>
                                    </div>
                                </div>
                            </div>                                       
                        </div>-->
                    
                </div>
                <!--
                <div class="buymenu-settings" id="buymenu-settings">
                    <div class="title">
                        <div class="cart" id="cart-title" onclick="EnableSidePanels(this,0)" style="background:#F3A800">
                            <img src="images/icons/cart-icon.png">
                        </div>
                        <div class="profile" onclick="EnableSidePanels(this,1)">
                            <img src="images/icons/profile-icon.png">
                        </div>
                        <div class="settings" onclick="EnableSidePanels(this,2)">
                            <img src="images/icons/settings-icon.png">
                        </div>
                        <div class="admin" id="admin-control-div" onclick="EnableSidePanels(this,3)">
                            <img src="images/icons/admin-icon.png">
                        </div>
                    </div>
                    <div class="content" id="content">
                        <div class="cart-content" id="cart-content">
                            <div class="cart-content-items" id="cart-content-items">-->
                            <!--
                                <div class="item" style="margin-left: 0px;">
                                    <img src="images/burgers/burger1.png">
                                    <div class="desc">
                                        <span class="name">Double Cheese Bacon Burger</span>
                                        <div class="checkboxs">
                                            <div class="not-included">
                                                <img src="images/burger-logo.png">
                                            </div>
                                        </div>
                                        <span class="price">24,000LL</span>
                                    </div>
                                    <div class="close">
                                        <div class="x-button" onclick="RemoveFromCart(this)">
                                        </div>
                                    </div>
                                </div>
                            -->
                            <!--
                            </div>
                            <div class="cart-content-buynow" id="cart-content-buynow">
                                <div>
                                    <span>Total:</span>
                                    <input type="button" value="Buy Now">
                                </div>
                            </div>
                        </div>
                        <div class="profile-content" id="profile-content" style="display:none">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, recusandae!
                        </div>
                        <div class="settings-content" id="settings-content" style="display:none">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, recusandae!
                        </div>
                        <div class="admin-content" id="admin-content" style="display:none">
                            <div class="control-panel">
                                <input type="button" id="add-meals-button" value="Add Meals" onclick="EnablePanel(0)">
                                <input type="button" id="edit-meals-button" value="Edit Meals" onclick="EnablePanel(1)">
                                <input type="button" id="add-ingredients-button" value="Add Ingredients" onclick="EnablePanel(2)">
                                <input type="button" id="edit-ingredients-button" value="Edit Ingredients" onclick="EnablePanel(3)">
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="mobile-menu"  id="menu">
                    <div class="menu">
                        <div onclick="location.href='BuyPage.php';">Menu</div>
                        <div onclick="location.href='about.php';">About</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
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

        function EnableSettingsMenu()
        {
            var menu=$('#buymenu-settings');

            if(menu.css("visibility")=="hidden"){
                menu.css("visibility","visible");
                menu.css("width","100%");
                
            }else
            {
                menu.css("visibility","hidden");
                menu.css("width","0");
            }
        }

        function AddToCart(element)
        {
            var cartContent=document.getElementById("cart-content").firstElementChild;
            //GetInfos
            var imgsrc=element.parentElement.parentElement.parentElement.firstElementChild.firstElementChild.src;
            var name=element.parentElement.parentElement.parentElement.firstElementChild.children[1].innerHTML;
            var price=element.parentElement.previousElementSibling.firstElementChild.innerHTML;
            var checkboxsParent=element.parentElement.previousElementSibling.previousElementSibling;
            //CreateDiv
            var item=document.createElement("div");
            item.classList.add("item");
            var img=document.createElement("img");
            img.src=imgsrc;
            item.appendChild(img);
            var desc=document.createElement("div");
            desc.classList.add("desc");
            var nameElement=document.createElement("span");
            var checkboxElement=document.createElement("div");
            var notIncluded=document.createElement("div");
            notIncluded.classList.add("not-included");

            for(var i=0;i<checkboxsParent.children.length;i++)
            {
                var isChecked=checkboxsParent.children[i].firstElementChild.checked;
                var notIncludedimgSrc=checkboxsParent.children[i].children[1].firstElementChild.src;
                if(!isChecked){
                    var notIncludedimg=document.createElement("img");
                    notIncludedimg.src=notIncludedimgSrc;
                    notIncluded.appendChild(notIncludedimg);
                }
            }
            checkboxElement.classList.add("checkboxs");
            checkboxElement.appendChild(notIncluded);
            var priceElement=document.createElement("span");
            nameElement.classList.add("name");
            nameElement.innerHTML=name;
            
            priceElement.classList.add("price");
            priceElement.innerHTML=price;
            desc.appendChild(nameElement);
            desc.appendChild(checkboxElement);
            desc.appendChild(priceElement);
            item.appendChild(desc);
            var close=document.createElement("div");
            close.classList.add("close");
            close.innerHTML='<div class="x-button" onclick="RemoveFromCart(this)">';
            item.appendChild(close);
            cartContent.appendChild(item);
            $('#cart-title').click()
            $(item).hide();
            $(item).slideToggle("fast",function(){
                $(item).animate({"margin-left":"2%"}, "fast",function()
                {
                    $(item).animate({"margin-left":"0"}, "fast");
                });  
            });
            UpdateTotal();
            itemsCount++;
        }
        function RemoveFromCart(element)
        {
            var item=element.parentElement.parentElement;
            $(item).slideToggle('fast', function()
            { 
                $(item).remove();
                itemsCount--;
                UpdateTotal(); 
            });
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
        //End of scripts for mobile only
    </script>
</html>