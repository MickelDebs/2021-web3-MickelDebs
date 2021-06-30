<?php
    include 'cnx.php';
    
    $checkboxCount=0;
    $meals_array=array();
    $categories_array=array();
    $ingredients_array=array();
    $mealingredients_array=array();

    //getmeals
    $sql_getmeals="SELECT * FROM `meals`";
    $result_meals = mysqli_query($database, $sql_getmeals);

    while($row=mysqli_fetch_assoc($result_meals))
    {
      $meals_array[]=$row;
    }
    for($i=0;$i<count($meals_array);$i++){
    $mealingredients_array[$i]=explode(",",$meals_array[$i]['ingredients']);
    }
    
    //getcategories
    $sql_getcategories="SELECT * FROM `categories`";
    $result_categories = mysqli_query($database, $sql_getcategories);

    while($row=mysqli_fetch_assoc($result_categories))
    {
      $categories_array[]=$row;
    }


    //getingredients
    $sql_getingredients="SELECT * FROM `ingredients`";
    $result_ingredients = mysqli_query($database, $sql_getingredients);

    while($row=mysqli_fetch_assoc($result_ingredients))
    {
      $ingredients_array[]=$row;
    }


?>