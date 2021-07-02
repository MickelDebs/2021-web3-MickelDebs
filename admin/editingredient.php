<?php
    $editingredientError=false;
    $ingredientEditAlreadyExists=false;
    $ingredientEdited=false;
    if(isset($_POST['edit-ingredient-submit']))
    {
        if(!empty($_POST['edit-ingredient-name'])&&
        !empty($_POST['edit-ingredient-originalname'])&&
        !empty($_POST['edit-ingredient-image'])&&
        !empty($_POST['edit-ingredient-id'])){

            include 'cnx.php';

            $id=$_POST['edit-ingredient-id'];
            $name=$_POST['edit-ingredient-name'];
            $originalname=$_POST['edit-ingredient-originalname'];
            $image=$_POST['edit-ingredient-image'];

            if($originalname!=$name)
            {
            $sql_ingredientname = "SELECT * FROM ingredients WHERE name='$name'";

            $result_ingredientname = mysqli_query($database, $sql_ingredientname);
                if(mysqli_num_rows($result_ingredientname)>0)
                {
                    $ingredientEditAlreadyExists=true;
                }
            }
            
             if($ingredientEditAlreadyExists==false){
            
                $sql_ingredientid = "SELECT * FROM ingredients WHERE Id='$id'";

                $result_ingredientid = mysqli_query($database, $sql_ingredientid);
                
                if(mysqli_num_rows($result_ingredientid) == 1)
                {
                    
                    $query = "UPDATE `ingredients` SET 
                            `name` = '$name', 
                            `image` = '$image'
                            WHERE Id='$id'";
            
                    $results = mysqli_query($database, $query);
                    mysqli_close($database);
                    $ingredientEdited=true;
                    
                }
            }

        }else
        {
            $editingredientError=true;
        }
    }
?>