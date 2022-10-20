<?php
if(isset($_POST['result'])){
    $value = $_POST['result'];
    $con = "";
    $result= "";
    include ('Library/Connect_DB.php');
    $sql = "SELECT DISTINCT funtion.IDFunction,funtion.NameFunction FROM decentralization,funtion WHERE funtion.IDFunction = decentralization.FunctionChild AND decentralization.IDGroup ='".$value."' AND decentralization.FunctionParent='F0000'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $result .= '<div class="nav-item dropdown">
<a style="font-family: Tahoma;font-size: 14px;color: white" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
            .$row['NameFunction'].'</a><div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            $sql2 = "SELECT DISTINCT funtion.IDFunction,funtion.NameFunction FROM decentralization,funtion WHERE funtion.IDFunction = decentralization.FunctionChild AND decentralization.IDGroup ='".$value."' AND decentralization.FunctionParent='".$row['IDFunction']."'";
            $query2 = mysqli_query($con,$sql2);
            if($query2->num_rows>0){
                while($row2=mysqli_fetch_array($query2)){
                    $sql3 = "SELECT DISTINCT funtion.IDFunction,funtion.NameFunction FROM decentralization,funtion WHERE funtion.IDFunction = decentralization.FunctionChild AND decentralization.IDGroup ='".$value."' AND decentralization.FunctionParent='".$row2['IDFunction']."'";
                    $query3 = mysqli_query($con,$sql3);
                    if($query3->num_rows>0){
                        $result.='<a style="font-family: Tahoma;font-size: 14px" class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row2['NameFunction'].'</a><div class="dropdown-menu" aria-labelledby="navbarDropdown1">';
                        while($row3=mysqli_fetch_array($query3)){
                            $result.='<a style="font-family: Tahoma;font-size: 14px" class="dropdown-item" href="#">'.$row3['NameFunction'].'</a>';
                        }
                        $result.='</div>';
                    }
                    else
                        $result.='<a style="font-family: Tahoma;font-size: 14px" class="dropdown-item" href="#">'.$row2['NameFunction'].'</a>';
                }
            }
            $result.='</div></div>';
        }
    }
    echo json_encode(['result'=>$result,'code'=>200]);
}
else echo json_encode(['code'=>201]);
?>
