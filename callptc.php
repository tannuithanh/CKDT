<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
function callcheck1($idfile,$idmember,$iddept)
{
    $con = "";
    $v='';
    include ('Library/Connect_DB.php');
    $sql="SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='".$iddept."' AND position.IDPosition in (Select approveptc.Position2 FROM position,approveptc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptc.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $v= $row;
    }
    return $v;
}
function callcheck2($idfile,$idmember)
{
    $con = "";
    $v='';
    include ('Library/Connect_DB.php');
    $sql="SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptc.Position3 FROM position,approveptc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptc.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $v= $row;
    }
    return $v;
}
function callapprove($idfile,$idmember)
{
    $con = "";
    $v='';
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptc.Position4 FROM position,approveptc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptc.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function check($idfile,$idmember)
{
    $con = "";
    $v='';
    include('Library/Connect_DB.php');
    $sql = "SELECT TimeStamp,Approved,Deny,Note FROM approve WHERE IDFile='".$idfile."' AND IDMember='".$idmember."'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function location($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v='';
    $sql = "SELECT NameLocation FROM locationcar WHERE IDLocation='".$id."' AND Showed=1";
    $query = mysqli_query($con, $sql);
    if($query!== false && $query->num_rows>0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = $row['NameLocation'];
        }
    }
    return $v;
}
function eating($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v='';
    $sql = "SELECT NameEating FROM eating WHERE IDEating='".$id."'";
    $query = mysqli_query($con, $sql);
    if($query!== false && $query->num_rows>0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = $row['NameEating'];
        }
    }
    return $v;
}
function checkmember($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v='';
    $sql = "SELECT IDMember FROM managerfile WHERE IDFile='".$id."'";
    $query = mysqli_query($con, $sql);
    if($query!== false && $query->num_rows>0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = $row['IDMember'];
        }
    }
    return $v;
}
function checkdept($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v='';
    $sql = "SELECT IDDept FROM managermember WHERE IDMember='".$id."'";
    $query = mysqli_query($con, $sql);
    if($query!== false && $query->num_rows>0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = $row['IDDept'];
        }
    }
    return $v;
}
function CountLocation($value)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $result = array();
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
        $result[]= array("GroupLocation"=>$row['GroupLocation'],"18h30"=>$a,"20h45"=>$b,"22h15"=>$c,"24h00"=>$d,"ChuNhat"=>$e);
    }
    return $result;
}
function CountFood($value)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $result = array();
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
            $result[]=array("NameEating"=>$row['NameEating'],"Count"=>$v[$v2[$i]]);
        }
    }
    return $result;
}
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $value2 = array();
    $nsql="";
    $con = "";
    include ('Library/Connect_DB.php');
    $location=array();
    $food=array();
    $sql = "SELECT member.IDMember,member.FullName, position.NamePosition, Dept.NameDept,ptc.18h30,ptc.20h45,ptc.22h15,ptc.24h00,ptc.ChuNhat,ptc.IDLocation,ptc.IDEationg,ptc.Note,ptc.PIC,ptc.NSQL,ptc.PhoneNumber, DATE_FORMAT(ptc.ngaytao,'Ngày %d tháng %m năm %Y') as ngaytao FROM ptc,member,position,managermember, Dept WHERE managermember.IDMember = member.IDMember and member.IDMember = ptc.IDMember AND managermember.IDPosition = position.IDPosition AND managermember.IDDept=dept.IDDept AND ptc.IDFile='".$value."' ORDER BY position.IDPosition ASC";
    $query = mysqli_query($con,$sql);
    if($query!== false && $query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $value2[] = array("IDMember"=>$row['IDMember'],"FullName"=>$row['FullName'],"NamePosition"=>$row['NamePosition'],"NameDept"=>$row['NameDept'],"18h30"=>$row['18h30'],"20h45"=>$row['20h45'],"22h15"=>$row['22h15'],"24h00"=>$row['24h00'],"ChuNhat"=>$row['ChuNhat'],"Location"=>location($row['IDLocation']),"Eating"=>eating($row['IDEationg']),"PIC"=>$row['PIC'],"Note"=>$row['Note'],"ngaytao" => $row['ngaytao']);
            if($row['18h30']=="X")
            $location[]=array("18h30",$row['IDLocation']);
            if($row['20h45']=="X")
                $location[]=array("20h45",$row['IDLocation']);
            if($row['22h15']=="X")
                $location[]=array("22h15",$row['IDLocation']);
            if($row['24h00']=="X")
                $location[]=array("24h00",$row['IDLocation']);
            if($row['ChuNhat']=="X")
                $location[]=array("ChuNhat",$row['IDLocation']);
            $food[]=$row['IDEationg'];
            if($row['NSQL']==1)
            {
                $nsql = array("FullName"=>$row['FullName'],"NamePosition"=>$row['NamePosition'],"NameDept"=>$row['NameDept'],"PhoneNumber"=>$row['PhoneNumber']);
            }
        }
        $v = array("value"=>$value2,"nsql"=>$nsql,"Location"=>CountLocation($location),"Food"=>CountFood($food),"Check1"=>callcheck1($value,checkmember($value),checkdept(checkmember($value))),"Checked1"=>check($value,callcheck1($value,checkmember($value),checkdept(checkmember($value)))['IDMember']),"Check2"=>callcheck2($value,checkmember($value)),"Checked2"=>check($value,callcheck2($value,checkmember($value))['IDMember']),"Approve"=>callapprove($value,checkmember($value)),"Approved"=> check($value,callapprove($value,checkmember($value))['IDMember']));
        echo json_encode(['result'=>$v,'code'=>200,'query'=>$value]);
    }
}
else
    echo json_encode(['code'=>201]);
