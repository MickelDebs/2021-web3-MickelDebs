<?php
    $mealDeleted=false;
    if(isset($_POST['delete-meal-submit']))
    {
        if(!empty($_POST['delete-meal-id'])){

            include 'cnx.php';

            $delete_id=$_POST['delete-meal-id'];

            $sql_delete_meal = "SELECT * FROM meals WHERE id='$delete_id'";

            $result_delete_meal = mysqli_query($database, $sql_delete_meal);

            if(mysqli_num_rows($result_delete_meal) == 0)
            {
                $mealDeleted=false;
            }else
            {
                
                $delete_query = "DELETE FROM meals WHERE id='$delete_id'";
           
                $delete_results = mysqli_query($database, $delete_query);
                mysqli_close($database);
                $mealDeleted=true;
                header("Refresh:0");
            }
            
        }else
        {
            $mealDeleted=false;
        }
    }else
    {
        $mealDeleted=false;
    }
?>