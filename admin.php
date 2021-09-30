<?php
session_start();
?>
<!DOCTYPE html>
<?php
    include 'fetchmeals.php';
    include './admin/addmeal.php';
    include './admin/deletemeal.php';
    include './admin/editmeal.php';
    include './admin/addingredient.php';
    include './admin/deleteingredient.php';
    include './admin/editingredient.php';

?>
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
                                <div class="cart-text">
                                0
                                </div>
                            </div>
                            <div class="cart-container" id="cart-container">
                                <div class="cart-header">
                                    <span>Cart</span>
                                    <img src="./images/icons/close.png" onclick="enableCart()">
                                </div>
                                <div class="cart-content">

                                </div>
                                <div class="cart-footer">
                                    <div class="footer-header">
                                        <span class="total">Total</span>
                                        <span class="price">200,000LL</span>
                                    </div>
                                    <a class="cart-checkout" href="checkout.php">
                                       BUY NOW
                                    </a>
                                    <div class="cart-clear">
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
    <div class="admin-container">
        <div class="admin-content" id="admin-content">
                <input type="button" id="add-meals-button" value="Add Meals" onclick="EnablePanel(0)">
                <input type="button" id="edit-meals-button" value="Edit Meals" onclick="EnablePanel(1)">
                <input type="button" id="add-ingredients-button" value="Add Ingredients" onclick="EnablePanel(2)">
                <input type="button" id="edit-ingredients-button" value="Edit Ingredients" onclick="EnablePanel(3)">
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
                <div class="cart-content">
                </div>
                <div class="cart-footer">
                    <div class="footer-header">
                        <span class="total">Total</span>
                        <span class="price">200,000LL</span>
                    </div>
                    <div class="cart-checkout" onclick="location.href=\'checkout.php\';">
                       BUY NOW
                    </div>
                    <div class="cart-clear">
                       CLEAR CART
                    </div>
                </div>
            </div>');
            }
            ?>
    </div>
    <div id="admin-panel" class="admin-panel" style="display:none">
        <div class="add-meals-panel" id="add-meals-panel" style="display:none">
            <div class="login-toolbar">
                <div class="toolbar-x" id="toolbar-x" onclick="closePanel(this)"></div>
            </div>
            <div class="add-meals">
                <div class="title" >Add Meals</div>
                <div class="add">
                <form action="./admin.php" method="POST">
                    <table>
                        <tr>
                            <td colspan="2" align="center">
                                <?php
                                    if($addMealError==true)
                                    {
                                        echo('<span style="color:red">Some values are empty -> Meal not added </span>');
                                    }else if
                                    ($mealAlreadyExists==true)
                                    {
                                        echo('<span style="color:red">Meal name already exists -> Meal not added</span>');
                                    }
                                    else if
                                    ($mealAdded==true)
                                    {
                                        echo('<span style="color:green">Meal added!</span>');
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name:
                            </td>
                            <td>
                                <input class="input" type="text" name="meal-name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Price:
                            </td>
                            <td>
                                <input class="input" type="text" name="meal-price">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Categorie:
                            </td>
                            <td>
                                <select name="meal-categorie" onchange="changeCategorie(this)" class="input">
                                    <?php
                                        for($i=0;$i<count($categories_array);$i++)
                                        {
                                            echo('<option value="'.$categories_array[$i]['name'].'">'.$categories_array[$i]['name'].'</option>');
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Image:
                            </td>
                            <td>
                            <img style="width:150px" src="">
                                <input class="input" onchange="changeMealImage(this)"type="file">
                                <input type="text" readonly name="meal-image" style="display:none">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Descprition:
                            </td>
                            <td>
                                <textarea class="textarea"name="meal-description"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ingredients:
                            </td>
                            <td>
                                <div class="ingredients-div">
                                    <input type="text" class="input"  onkeyup="filter(this)" id="ingredient-search" placeholder="Search">
                                    <div class="ingredient">
                                        <ul class="ingredients-list" id="ingredients-list">
                                           
                                        <?php
                                        for($i=0;$i<count($ingredients_array);$i++){
                                            echo('
                                            <li class="ingredients-li" onclick="clickCheckbox(this)">'
                                            .$ingredients_array[$i]["name"].
                                            '<input class="check" type="checkbox" onclick="addIngredient(this)">
                                            </li>');
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ingredients-control">
                                    <textarea id="ingredients-textarea" readonly class="ingredients-textarea" name="meal-ingredients"></textarea>
                                    <input type="button" value="Clear" onclick="DeselectAll()">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                                <input name="addmeal-submit"class="addmeal-submit" type="submit" value="Add">
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
            </div>
        </div>
        <div class="add-meals-panel" id="edit-meals-panel" style="display:none">
            <div class="login-toolbar">
                <div class="toolbar-x"  onclick="closePanel(this)"></div>
                <div class="toolbar-x blue" onclick="backPanel(this)"></div>
            </div>
            <div class="add-meals" id="edit-items-page" >
                <div class="title" >Edit Meals</div>
                <div class="search-meal">
                    <input type="text" class="input" style="width:80%" id="edit-meal-search" oninput="filterMeals()" placeholder="Search">
                </div>
                    <div class="edit">
                        <?php
                        if(isset($meals_array))
                        {
                            
                            if($editMealError==true)
                            {
                                echo('<span style="color:red">Some values are empty -> Meal not edited </span>');
                            }
                            else if
                            ($mealEdited==true)
                            {
                                echo('<span style="color:green">Meal edited!</span>');
                            }
                            else if($mealDeleted==true)
                            {
                                echo('<span style="color:red">Meal deleted!</span>');
                            }
                            else if($mealEditAlreadyExists==true)
                            {
                                echo('<span style="color:red">Meal name already exists -> Meal not edited </span>');
                            }
                                
                            for($i=0;$i<count($meals_array);$i++)
                            {
                                echo('
                            
                        <div class="edit-meal">
                                <img src="'.$meals_array[$i]['image'].'">
                                <div class="edit-meal-desc">
                                    '.$meals_array[$i]['name'].'
                                    <div class="hidden-desc">
                                        <div>
                                            <input type="text" readonly name="id" value="'.$meals_array[$i]['Id'].'">
                                            <input type="text" readonly name="name" value="'.$meals_array[$i]['name'].'">
                                            <input type="text" readonly name="price" value="'.$meals_array[$i]['price'].'">
                                            <input type="text" readonly name="description" value="'.$meals_array[$i]['description'].'">
                                            <input type="text" readonly name="image" value="'.$meals_array[$i]['image'].'">
                                            <input type="text" readonly name="ingredients" value="'.$meals_array[$i]['ingredients'].'">
                                            <input type="text" readonly name="categorie" value="'.$meals_array[$i]['categorie'].'">
                                        </div>
                                    </div>
                                </div>
                                <div class="edit-meal-control">
                                    <input type="button" value="Edit" onclick="editMeal(this)">
                                    <input type="button" class="delete-button" value="Delete" onclick="deleteMeal(this)">
                                </div>
                        </div>');
                            }
                        }
                        ?>
                    </div>                    
            </div>
            <div class="add-meals" id="edit-page"style="display:none">
                <div class="title" id="edit-meal-title"></div>
                <div class="add">
                <form action="./admin.php" method="POST">
                    <table>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="text" readonly  id="edit-meal-id" name="edit-meal-id" style="display:none">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name:
                            </td>
                            <td>
                                <input class="input" type="text" id="edit-meal-name" name="edit-meal-name">
                                <input type="text" id="edit-meal-originalname" name="edit-meal-originalname" style="display:none">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Price:
                            </td>
                            <td>
                                <input class="input" type="text" id="edit-meal-price" name="edit-meal-price">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Categorie:
                            </td>
                            <td>
                                <select id="edit-meal-categorie" onchange="changeCategorie(this)" name="edit-meal-categorie" class="input">
                                    <?php
                                        for($i=0;$i<count($categories_array);$i++)
                                        {
                                            echo('<option value="'.$categories_array[$i]['name'].'">'.$categories_array[$i]['name'].'</option>');
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Image:
                            </td>
                            <td>
                                <img style="width:150px" id="edit-meal-image" src="">
                                <input class="input" onchange="changeMealImage(this)" type="file" >
                                <input type="text" readonly name="edit-meal-image" style="display:none">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Descprition:
                            </td>
                            <td>
                                <textarea class="textarea" id="edit-meal-description" name="edit-meal-description"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Ingredients:
                            </td>
                            <td>
                                <div class="ingredients-div">
                                    <input type="text" class="input"  onkeyup="filter(this)" placeholder="Search">
                                    <div class="ingredient">
                                        <ul class="ingredients-list" id="edit-ingredients-list">
                                           
                                        <?php
                                        for($i=0;$i<count($ingredients_array);$i++){
                                            echo('
                                            <li class="ingredients-li" onclick="clickCheckbox(this)">'
                                            .$ingredients_array[$i]["name"].
                                            '<input class="check" type="checkbox" onclick="addIngredient(this)">
                                            </li>');
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ingredients-control">
                                    <textarea readonly class="ingredients-textarea" name="edit-meal-ingredients"></textarea>
                                    <input type="button" value="Clear" onclick="DeselectAll()">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center">
                                <input name="edit-meal-submit"class="addmeal-submit" type="submit" value="Edit">
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
            </div>
            <div class="delete-pop" id="delete-pop" >
                <form action="admin.php" method="POST">
                    <table>
                        <tr>
                            <td colspan="2" id="delete-pop-msg">
                                Are you sure you want to delete?
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="delete-meal-id" readonly style="display:none" id="delete-pop-text">
                                <input type="submit"  name="delete-meal-submit" class="delete-yes"value="Yes">
                            </td>
                            <td>
                                <input type="button" class="delete-no"value="No" onclick="disableDelete(this)">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="add-meals-panel" id="add-meals-panel" style="display:none">
            <div class="login-toolbar">
                <div class="toolbar-x" id="toolbar-x" onclick="closePanel(this)"></div>
            </div>
            <div class="add-meals">
                <div class="title" >Add Ingredients</div>
                <div class="add">
                    <form action="./admin.php" method="POST">
                        <table>
                            <tr>
                                <td colspan="2">
                                    <?php
                                        if($addingredientError==true)
                                        {
                                            echo('<span style="color:red">Some values are empty -> Ingredient not added </span>');
                                        }else if
                                        ($ingredientAlreadyExists==true)
                                        {
                                            echo('<span style="color:red">Ingredient name already exists -> Ingredient not added</span>');
                                        }
                                        else if
                                        ($ingredientAdded==true)
                                        {
                                            echo('<span style="color:green">Ingredient added!</span>');
                                        }
                                    ?>
                                </td>
                            </tr>        
                            <tr>
                                <td>
                                    Name:
                                </td>
                                <td>
                                    <input class="input" type="text" name="ingredient-name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Image:
                                </td>
                                <td>
                                    <img style="width:150px" src="">
                                    <input class="input" onchange="changeIngredientImage(this)"type="file">
                                    <input type="text" readonly name="ingredient-image" style="display:none">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <input name="add-ingredient-submit"class="addmeal-submit" type="submit" value="Add">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="add-meals-panel" id="edit-meals-panel" style="display:none">
            <div class="login-toolbar">
                <div class="toolbar-x"  onclick="closePanel(this)"></div>
                <div class="toolbar-x blue" onclick="backPanel(this)"></div>
            </div>
            <div class="add-meals" id="edit-ingredients-page" >
                <div class="title" >Edit Ingredients
                </div>
                <div class="search-meal">
                    <input type="text" class="input" style="width:80%" id="edit-ingredient-search" oninput="filterIngredients()" placeholder="Search">
                </div>
                <div class="edit">
                <?php
                        if(isset($ingredients_array))
                        {
                            
                            if($editingredientError==true)
                            {
                                echo('<span style="color:red">Some values are empty -> Ingredient not edited </span>');
                            }
                            else if
                            ($ingredientEdited==true)
                            {
                                echo('<span style="color:green">Ingredient edited!</span>');
                            }
                            else if($ingredientDeleted==true)
                            {
                                echo('<span style="color:red">Ingredient deleted!</span>');
                            }else if($ingredientEditAlreadyExists==true)
                            {
                                echo('<span style="color:red">Ingredient name already exists -> Ingredient not edited </span>');
                            }
                                
                            for($i=0;$i<count($ingredients_array);$i++)
                            {
                                echo('
                            
                        <div class="edit-meal" style="background:rgba(0,0,0,0.8);height:70px">
                                <img src="'.$ingredients_array[$i]['image'].'">
                                <div class="edit-ingredient-desc">
                                    '.$ingredients_array[$i]['name'].'
                                    <div class="hidden-desc">
                                        <div>
                                            <input type="text" readonly name="id" value="'.$ingredients_array[$i]['Id'].'">
                                            <input type="text" readonly name="name" value="'.$ingredients_array[$i]['name'].'">
                                            <input type="text" readonly name="image" value="'.$ingredients_array[$i]['image'].'">
                                        </div>
                                    </div>
                                </div>
                                <div class="edit-meal-control">
                                    <input type="button" value="Edit" onclick="editIngredient(this)">
                                    <input type="button" class="delete-button" value="Delete" onclick="deleteIngredient(this)">
                                </div>
                        </div>');
                            }
                        }
                        ?>
                </div>
            </div>
            <div class="add-meals" id="ingredient-edit-page" style="display:none" >
                <div class="title" id="edit-ingredient-title">Edit Ingredients</div>
                <div class="add">
                    <form action="./admin.php" method="POST">
                        <table>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="edit-ingredient-id" readonly id="edit-ingredient-id" style="display:none">
                                </td>
                            </tr>        
                            <tr>
                                <td>
                                    Name:
                                </td>
                                <td>
                                    <input class="input" type="text" name="edit-ingredient-name" id="edit-ingredient-name">
                                    <input type="text" name="edit-ingredient-originalname" id="edit-ingredient-originalname" style="display:none">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Image:
                                </td>
                                <td>
                                    <img style="width:150px" src="" id="edit-ingredient-image">
                                    <input class="input" onchange="changeIngredientImage(this)"type="file">
                                    <input type="text" readonly name="edit-ingredient-image" style="display:none">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <input name="edit-ingredient-submit"class="addmeal-submit" type="submit" value="Edit">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="delete-pop" id="delete-ingredient-pop" >
                <form action="admin.php" method="POST">
                    <table>
                        <tr>
                            <td colspan="2" id="delete-ingredient-pop-msg">
                                Are you sure you want to delete?
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="delete-ingredient-id" readonly style="display:none" id="delete-ingredient-pop-text">
                                <input type="submit"  name="delete-ingredient-submit" class="delete-yes"value="Yes">
                            </td>
                            <td>
                                <input type="button" class="delete-no"value="No" onclick="disableDelete(this)">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    </div>
    </body>
    <script>

        $(window).on("load",function()
        {
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        });

        <?php
        if($addMealError==true||$mealAlreadyExists==true||$mealAdded==true){
        echo('$(window).on("load", function(){
                $("#admin-control-div").click();
                $("#add-meals-button").click();
            });');
        }

        if($mealEditAlreadyExists==true||$editMealError==true||$mealEdited==true||$mealDeleted==true){
            echo('$(window).on("load", function(){
                    $("#admin-control-div").click();
                    $("#edit-meals-button").click();
                });');
            }

        if($addingredientError==true||$ingredientAlreadyExists==true||$ingredientAdded==true){
        echo('$(window).on("load", function(){
                $("#admin-control-div").click();
                $("#add-ingredients-button").click();
            });');
        }
        if($ingredientEditAlreadyExists==true||$editingredientError==true||$ingredientEdited==true||$ingredientDeleted==true){
            echo('$(window).on("load", function(){
                    $("#admin-control-div").click();
                    $("#edit-ingredients-button").click();
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

        function EnablePanel(num)
        {
            var adminpanel=document.getElementById('admin-panel');
            for(var i=0;i<adminpanel.children.length;i++)
            {
                $(adminpanel.children[i]).hide();
            }
            $(adminpanel).show();
            $(adminpanel.children[num]).slideToggle();
        }
        function closePanel(element)
        {
            var parent=element.parentElement.parentElement;
            var adminpanel=parent.parentElement;
            $(parent).slideToggle(function()
            {
                $(adminpanel).hide();
            });
        }
        function backPanel(element)
        {
            var parent=element.parentElement.parentElement;
            $(element).hide();
            $(parent.children[2]).hide();
            $(parent.children[1]).show();
        }
        function changeCategorie(element)
        {
            var elt=element.parentElement.parentElement.nextElementSibling.children[1].children[1];
            var value=element.value;

            changeMealImage(elt,value);
        }
        function changeMealImage(element,cat)
        {
            var img=element.parentElement.firstElementChild;
            var text=element.nextElementSibling;
            if(cat==null){
            cat=element.parentElement.parentElement.previousElementSibling.children[1].firstElementChild.value;
            }
            if(element.files.item(0)!=null){
            var name=element.files.item(0).name;
            img.src="./images/"+cat+"/"+name;
            text.value="./images/"+cat+"/"+name;
            }
        }
        function changeIngredientImage(element)
        {
            var img=element.previousElementSibling;
            var text=element.nextElementSibling;
            
            if(element.files.item(0)!=null){
            var name=element.files.item(0).name;
            img.src="./images/ingredients/"+name;
            text.value="./images/ingredients/"+name;
            }
        }
        function editMeal(element)
        {
            var id,name,price,desc,img,ingr,cat,parent,ingr_array,list,li;
            $('#edit-items-page').hide();
            $('#edit-page').show();
            $(document.getElementById("edit-items-page").parentElement.firstElementChild.children[1]).show();
            parent=element.parentElement.previousElementSibling.firstElementChild.firstElementChild;
            id=parent.children[0].value;
            name=parent.children[1].value;
            price=parent.children[2].value;
            desc=parent.children[3].value;
            img=parent.children[4].value;
            ingr=parent.children[5].value;
            cat=parent.children[6].value;

            ingr_array=ingr.split(',');
            list=document.getElementById('edit-ingredients-list');
            li=list.getElementsByTagName('li');
            for(var i=0;i<li.length;i++)
            {
                for(var j=0;j<ingr_array.length;j++){
                    if(li[i].innerText==ingr_array[j])
                    {
                        li[i].click();
                    }
                }
            }
            document.getElementById('edit-meal-title').innerText="Edit "+name;
            document.getElementById('edit-meal-id').value=id;
            document.getElementById('edit-meal-name').value=name;
            document.getElementById('edit-meal-originalname').value=name;
            document.getElementById('edit-meal-price').value=price;
            document.getElementById('edit-meal-description').value=desc;
            document.getElementById('edit-meal-categorie').value=cat;
            document.getElementById('edit-meal-image').src=img;
            document.getElementById('edit-meal-image').nextElementSibling.nextElementSibling.value=img;
        }

        function editIngredient(element)
        {
            var id,name,img;
            $('#edit-ingredients-page').hide();
            $('#ingredient-edit-page').show();
            $(document.getElementById("edit-ingredients-page").parentElement.firstElementChild.children[1]).show();
            parent=element.parentElement.previousElementSibling.firstElementChild.firstElementChild;
            id=parent.children[0].value;
            name=parent.children[1].value;
            img=parent.children[2].value;

            document.getElementById('edit-ingredient-title').innerText="Edit "+name;
            document.getElementById('edit-ingredient-id').value=id;
            document.getElementById('edit-ingredient-name').value=name;
            document.getElementById('edit-ingredient-originalname').value=name;
            document.getElementById('edit-ingredient-image').src=img;
            document.getElementById('edit-ingredient-image').nextElementSibling.nextElementSibling.value=img;
        }

        function addIngredient(element)
        {
            var textarea=element.parentElement.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
            var text=element.parentElement.innerText;
            if(element.checked==true)
            {
                str+=text+" ";
            }else
            {
                str=str.replace(text+" ",'');
            }
            textarea.value=str;
        }
        function deleteMeal(element)
        {
            var name=element.parentElement.previousElementSibling.firstElementChild.firstElementChild.children[1].value;
            var id=element.parentElement.previousElementSibling.firstElementChild.firstElementChild.firstElementChild.value;
            document.getElementById("delete-pop-text").value=id;
            document.getElementById("delete-pop-msg").innerText="Are you sure you want to delete "+name+" ?";
            $('#delete-pop').slideToggle();
        }
        function deleteIngredient(element)
        {
            var name=element.parentElement.previousElementSibling.firstElementChild.firstElementChild.children[1].value;
            var id=element.parentElement.previousElementSibling.firstElementChild.firstElementChild.firstElementChild.value;
            document.getElementById("delete-ingredient-pop-text").value=id;
            document.getElementById("delete-ingredient-pop-msg").innerText="Are you sure you want to delete "+name+" ?";
            $('#delete-ingredient-pop').slideToggle();
        }
        var str="";
        function filter(element)
            {
                var filter, ul, li,td, a, i, txtValue;
                
                filter = element.value.toUpperCase();
                ul = element.nextElementSibling.firstElementChild;
                li = ul.getElementsByTagName('li');
                

                for (i = 0; i < li.length; i++) {
                    a = li[i];
                    txtValue = a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
            function filterMeals()
            {
                var input, filter,names, a, i,txtValue;
                input = document.getElementById('edit-meal-search');
                filter = input.value.toUpperCase();
                names = document.getElementsByClassName('edit-meal-desc');

                for (i = 0; i < names.length; i++) {
                    a = names[i];
                    txtValue = a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        names[i].parentElement.style.display = "";
                    } else {
                        names[i].parentElement.style.display = "none";
                    }
                }
            }
            function filterIngredients()
            {
                var input, filter,names, a, i,txtValue;
                input = document.getElementById('edit-ingredient-search');
                filter = input.value.toUpperCase();
                names = document.getElementsByClassName('edit-ingredient-desc');

                for (i = 0; i < names.length; i++) {
                    a = names[i];
                    txtValue = a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        names[i].parentElement.style.display = "";
                    } else {
                        names[i].parentElement.style.display = "none";
                    }
                }
            }
        
        function DeselectAll()
        {
            var ul = document.getElementById("ingredients-list");
            var li = ul.getElementsByTagName('li');
            var textarea=document.getElementById("ingredients-textarea");

            for(var i=0;i<li.length;i++)
            {
                li[i].firstElementChild.checked=false;
            }
            str="";
            textarea.value=str;
        }
        function disableDelete(element)
        {
            var parent=element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
            $(parent).slideToggle();
        }
        function clickCheckbox(element)
        {
            element.firstElementChild.click();
        }
    </script>
</html>