<?php
if(isset($_POST['result'])) {
    $v='';
    $con = "";
    include ('Library/Connect_DB.php');
    $result = '';
    $value = $_POST['result'];
    $in = count($value);
    $sql = "SELECT DISTINCT GroupLocation FROM locationcar WHERE IDLocation <> 'L0018'";
    $query = mysqli_query($con, $sql);
    while ($row=mysqli_fetch_array($query))
    {
        $a = 0;$b=0;$c=0;$d=0;$e=0;
        for($i=0;$i<$in;$i++)
        {
            $sql = "SELECT COUNT(*) as ct FROM locationcar WHERE IDLocation='".$value[$i][1]."' AND GroupLocation='".$row['GroupLocation']."'";
            $query2 = mysqli_query($con, $sql);
            while ($row2=mysqli_fetch_array($query2))
            {
                if($row2['ct']!=0)
                {
                    if($value[$i][0]=='18h30')
                        $a++;
                    if($value[$i][0]=='20h45')
                        $b++;
                    if($value[$i][0]=='22h15')
                        $c++;
                    if($value[$i][0]=='24h00')
                        $d++;
                    if($value[$i][0]=='ChuNhat')
                        $e++;
                }
            }
        }
        $result.='<tr><td>'.$row['GroupLocation'].'</td><td>'.$a.'</td><td>'.$b.'</td><td>'.$c.'</td><td>'.$d.'</td><td>'.$e.'</td></tr>';
    }
    echo json_encode(['result'=>$result,'code'=>200]);

}
else
    echo json_encode(['code'=>201]);