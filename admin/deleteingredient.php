<?php
    $ingredientDeleted=false;
    if(isset($_POST['delete-ingredient-submit']))
    {
        if(!empty($_POST['delete-ingredient-id'])){

            include 'cnx.php';

            $delete_id=$_POST['delete-ingredient-id'];

            $sql_delete_ingredient = "SELECT * FROM ingredients WHERE id='$delete_id'";

            $result_delete_ingredient = mysqli_query($database, $sql_delete_ingredient);

            if(mysqli_num_rows($result_delete_ingredient) == 0)
            {
                $ingredientDeleted=false;
            }else
            {
                
                $delete_query = "DELETE FROM ingredients WHERE id='$delete_id'";
           
                $delete_results = mysqli_query($database, $delete_query);
                mysqli_close($database);
                $ingredientDeleted=true;
                
            }
            
        }else
        {
            $ingredientDeleted=false;
        }
    }else
    {
        $ingredientDeleted=false;
    }
?>