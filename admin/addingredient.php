<?php
    $addingredientError=false;
    $ingredientAlreadyExists=false;
    $ingredientAdded=false;
    if(isset($_POST['add-ingredient-submit']))
    {
        if(!empty($_POST['ingredient-name'])&&
        !empty($_POST['ingredient-image'])){

            include 'cnx.php';

            $name=$_POST['ingredient-name'];
            $image=$_POST['ingredient-image'];

            $sql_ingredientname = "SELECT * FROM ingredients WHERE name='$name'";

            $result_ingredientname = mysqli_query($database, $sql_ingredientname);

            if(mysqli_num_rows($result_ingredientname) > 0)
            {
                $ingredientAlreadyExists=true;
            }else
            {
                $query = "INSERT INTO ingredients (name,image) 
      	        VALUES ('$name','$image')";
           
                $results = mysqli_query($database, $query);
                mysqli_close($database);
                $ingredientAdded=true;
                
            }

        }else
        {
            $addingredientError=true;
        }
    }
?>