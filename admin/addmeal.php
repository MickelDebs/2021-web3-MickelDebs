<?php
    $addMealError=false;
    $mealAlreadyExists=false;
    $mealAdded=false;
    if(isset($_POST['addmeal-submit']))
    {
        if(!empty($_POST['meal-name'])&&
        !empty($_POST['meal-price'])&&
        !empty($_POST['meal-description'])&&
        !empty($_POST['meal-image'])&&
        !empty($_POST['meal-ingredients'])&&
        !empty($_POST['meal-categorie'])){

            include 'cnx.php';

            $name=$_POST['meal-name'];
            $price=$_POST['meal-price'];
            $description=$_POST['meal-description'];
            $categorie=$_POST['meal-categorie'];
            $image='./images/'.$categorie.'/'.$_POST['meal-image'];
            $ingredients=$_POST['meal-ingredients'];
            $ingredients=str_replace(' ',',',$ingredients);
            $ingredients=substr($ingredients, 0, -1);
            $sql_mealname = "SELECT * FROM meals WHERE name='$name'";

            $result_mealname = mysqli_query($database, $sql_mealname);

            if(mysqli_num_rows($result_mealname) > 0)
            {
                $mealAlreadyExists=true;
            }else
            {
                $query = "INSERT INTO meals (name,price,description,ingredients,image,categorie) 
      	        VALUES ('$name', '$price', '$description','$ingredients','$image','$categorie')";
           
                $results = mysqli_query($database, $query);
                mysqli_close($database);
                $mealAdded=true;
                
            }

        }else
        {
            $addMealError=true;
        }
    }
?>