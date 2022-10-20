<?php
if(isset($_POST['result'])) {
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $result = '<tr>';
    $value = $_POST['result'];
    sort($value);
    $v = array_count_values($value);
    $v2 = array_keys($v);
    $in = count($v2);
    for($i=0;$i<$in;$i++)
    {
        $sql = "SELECT NameEating FROM eating WHERE IDEating='".$v2[$i]."'";
        $query = mysqli_query($con, $sql);
        while ($row=mysqli_fetch_array($query))
        {
            $result.='<td>'.$row['NameEating'].'</td><td>'.$v[$v2[$i]].'</td>';
        }
        $result.='</tr>';
    }
    echo json_encode(['result'=>$result,'code'=>200]);

}
else
    echo json_encode(['code'=>201]);