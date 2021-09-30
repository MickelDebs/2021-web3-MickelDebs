<?php
    if(isset($_POST['id']))
    {
        include '../cnx.php';
        $id=$_POST['id'];
        $selectQuery="SELECT `number`,`time` FROM `sales` WHERE meal_id='".$id."' ORDER BY `time`";
        $resultSelect=mysqli_query($database,$selectQuery);
        
        $data=array();
        if(mysqli_num_rows($resultSelect) > 0)
        {
            while($row=mysqli_fetch_assoc($resultSelect))
            {
                $data[]=$row;
            }
        }
        $fixedData=array();
        foreach($data as $d)
        {
            $a=array();
            foreach($d as $k=>$v)
            {
                $s=$v;
                if($k=='number')
                {
                    $s=(int)$v;
                }
                $a[$k]=$s;
            }
            array_push($fixedData,$a);
        }
        $selectNameQuery="SELECT `name` FROM `meals` WHERE `Id`='".$id."'";
        $resultName=mysqli_query($database,$selectNameQuery);
        $name=array();
        if(mysqli_num_rows($resultName) == 1)
        {
            while($row=mysqli_fetch_assoc($resultName))
            {
                $name[]=$row;
            }
        }
        $mealname=$name[0]['name'];
        $return=array("title"=>$mealname,"data"=>$fixedData);
        echo(json_encode($return));
    }
?>