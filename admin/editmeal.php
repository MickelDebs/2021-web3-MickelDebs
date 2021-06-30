<?php
    $editMealError=false;
    if(isset($_POST['edit-meal-submit']))
    {
        /*if(!empty($_POST['edit-meal-name'])&&
        !empty($_POST['edit-meal-price'])&&
        !empty($_POST['edit-meal-description'])&&
        !empty($_POST['edit-meal-image'])&&
        !empty($_POST['edit-meal-ingredients'])&&
        !empty($_POST['edit-meal-categorie'])&&
        !empty($_POST['edit-meal-id'])){*/

            include 'cnx.php';

            $id=$_POST['edit-meal-id'];
            $name=$_POST['edit-meal-name'];
            $price=$_POST['edit-meal-price'];
            $description=$_POST['edit-meal-description'];
            $categorie=$_POST['edit-meal-categorie'];
            $image=$_POST['edit-meal-image'];
            $ingredients=$_POST['edit-meal-ingredients'];
            $ingredients=str_replace(' ',',',$ingredients);
            $ingredients=substr($ingredients, 0, -1);

            $sql_mealid = "SELECT * FROM meals WHERE Id='$id'";

            $result_mealid = mysqli_query($database, $sql_mealid);
            
            if(mysqli_num_rows($result_mealid) == 1)
            {
                
                $query = "UPDATE `meals` SET 
                        `name` = '$name', 
                        `price` = '$price', 
                        `description` = '$description', 
                        `ingredients` = '$ingredients', 
                        `image` = '$image',
                        `categorie` = '$categorie'
                        WHERE Id='$id'";
           
                $results = mysqli_query($database, $query);
                mysqli_close($database);
                
            }else
            {
                $editMealError=true;
            }

        /*}else
        {
            $editMealError=false;
        }*/
    }
?>