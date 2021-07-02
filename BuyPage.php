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
        <?php
            if(isset($_SESSION['status']))
            {
                $status=$_POST['status'];
                if($status=='admin')
                {
                    
                }
            }
        ?>
    <div id="admin-panel" class="admin-panel" style="display:none">
        <div class="add-meals-panel" id="add-meals-panel" style="display:none">
            <div class="login-toolbar">
                <div class="toolbar-x" id="toolbar-x" onclick="closePanel(this)"></div>
            </div>
            <div class="add-meals">
                <div class="title" >Add Meals</div>
                <div class="add">
                <form action="./BuyPage.php" method="POST">
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
                                        echo('<span style="color:green">Meal added!</span><br><span>Refresh Page to take effect</span>');
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
                                echo('<span style="color:green">Meal edited!</span><span>Refresh Page to take effect.</span>');
                            }
                            else if($mealDeleted==true)
                            {
                                echo('<span style="color:red">Meal deleted!</span><span>Refresh Page to take effect.</span>');
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
                <form action="./BuyPage.php" method="POST">
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
                <form action="BuyPage.php" method="POST">
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
                    <form action="./BuyPage.php" method="POST">
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
                                            echo('<span style="color:green">Ingredient added!</span><br><span>Refresh Page to take effect</span>');
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
                                echo('<span style="color:green">Ingredient edited!</span><span>Refresh Page to take effect.</span>');
                            }
                            else if($ingredientDeleted==true)
                            {
                                echo('<span style="color:red">Ingredient deleted!</span><span>Refresh Page to take effect.</span>');
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
                    <form action="./BuyPage.php" method="POST">
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
                <form action="BuyPage.php" method="POST">
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
        <div class="background-flex ">
            <div class="flex-column logo-div">
                <div class="background-div-1 background-div-1-buymenu">
                        <div class="background-div-1_1 "></div>
                        <div class="background-div-1_2 "><span>BFE</span></div>
                        <div class="cellphone-menu" onclick="EnableSettingsMenu()">
                            <img src="./images/icons/menu.png">
                        </div>
                </div>
            </div>
            <div class="buymenu-parent ">
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
                                        <div class="item-card" onclick="EnableDescription(this)">
                                            <div class="item-imgBox">
                                                <img src="'.$meals_array[$j]['image'].'">
                                                <h2>'.$meals_array[$j]['name'].'</h2>
                                            </div>
                                            <div class="item-content">
                                                <div class="description">
                                                        <h3>'.$meals_array[$j]['description'].'</h3>
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
        function clickCheckbox(element)
        {
            element.firstElementChild.click();
        }
        function disableDelete(element)
        {
            var parent=element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
            $(parent).slideToggle();
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
            var card=element;
            var categorie=card.parentElement.parentElement;
            var container=element.parentElement;
            var imgBox=card.firstElementChild;
            var img=card.firstElementChild.firstElementChild;
            var content=card.children[1];

            card.classList.add("item-card-size");
            img.style.width="120px";
            content.style.display="inline";
            container.style.width="100%";
        }
        function DisableAll()
        {
            var cards=$(".item-card");
            var containers=$(".container");
            var contents=$(".item-content");
            var imgs=$(".item-imgBox");
            for(var i=0;i<cards.length;i++)
            {
                
                cards[i].classList.remove("item-card-size");
                imgs[i].firstElementChild.style.width="200px";
                contents[i].style.display="none";
                containers[i].style.width="auto";
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
            var cartContent=document.getElementById("cart-content");
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

        }
        function RemoveFromCart(element)
        {
            var item=element.parentElement.parentElement;
            $(item).slideToggle('fast', function(){ $(item).remove(); });
        }

        
    </script>
</html>