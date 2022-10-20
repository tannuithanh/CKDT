<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$iddept = $_SESSION['IDDept'];
if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015'  ) {
function callcheck1($idfile,$idmember,$iddept)
{
    $con = "";
    $v='';
    include ('Library/Connect_DB.php');
    $sql="SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='".$iddept."' AND position.IDPosition in (Select approvepcv.Position2 FROM position,approvepcv,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
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
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvepcv.Position4 FROM position,approvepcv,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function callkiemtra($idfile, $idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.iddept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvepcv.Position3 FROM position,approvepcv,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv.Position1 AND member.IDMember='" . $idmember . "') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='" . $idfile . "')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function callcheck2($idfile,$iddept)
{
    $con = "";
    $v='';
    include('Library/Connect_DB.php');
    $sql = "SELECT member.IDMember,member.FullName FROM managermember,position,member WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND managermember.IDDept='".$iddept."' AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function check($idfile,$idmember)
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT TimeStamp,Approved,Deny,Note FROM approve WHERE IDFile='".$idfile."' AND IDMember='".$idmember."'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $v = $row;
    }
    return $v;
}
function checkdept($id)
{
    $con = "";
    include('Library/Connect_DB.php');
    $v='';
    $sql = "SELECT NameDept FROM dept WHERE IDDept='".$id."'";
    $query = mysqli_query($con, $sql);
    if($query!== false && $query->num_rows>0) {
        while ($row = mysqli_fetch_array($query)) {
            $v = $row['NameDept'];
        }
    }
    return $v;
}
if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $con = "";
    include ('Library/Connect_DB.php');
    $sql = "SELECT managerfile.IDFile,member.IDMember,dept.IDDept,dept.NameDept,pcv.IDDept as IDDept2,pcv.Content,pcv.Note,DATE_FORMAT(pcv.TimeStamp,'%H:%i:%s %d/%m/%Y') as TimeStamp, DATE_FORMAT(pcv.ngaytao,'Núi Thành, ngày %d tháng %m năm %Y') as ngaytao FROM managerfile,member,pcv,dept,managermember WHERE managerfile.IDFile = pcv.IDFile AND managerfile.IDMember = member.IDMember AND member.IDMember = managermember.IDMember AND dept.IDDept = managermember.IDDept AND managerfile.IDFile='".$value."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v = array("IDFile"=>$row['IDFile'],"NameDept"=>$row['NameDept'],"TimeStamp"=>$row['TimeStamp'],"ngaytao" => $row['ngaytao'],"Content"=>$row['Content'],"Note"=>$row['Note'],"DeptNeed"=>checkdept($row['IDDept2']),"Check1"=>callcheck1($row['IDFile'],$row['IDMember'],$row['IDDept']),"Checked1"=>check($row['IDFile'],callcheck1($row['IDFile'],$row['IDMember'], $row['IDDept'])['IDMember']), "Kiemtra" => callkiemtra($row['IDFile'], $row['IDMember'], $row['IDDept']),"Kiemtraked" => check($row['IDFile'], callkiemtra($row['IDFile'], $row['IDMember'], $row['IDDept'])['IDMember']),"Check2"=>callcheck2($row['IDFile'],$row['IDDept2']),"Checked2"=>check($row['IDFile'],callcheck2($row['IDFile'],$row['IDDept2'])['IDMember']),"Approve"=>callapprove($row['IDFile'],$row['IDMember']),"Approved"=> check($row['IDFile'],callapprove($row['IDFile'],$row['IDMember'])['IDMember']));
        }
        echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
    }
    else echo json_encode(['code'=>201,'query'=>$sql]);

}
else
    echo json_encode(['code'=>201]);
}else{
    function callcheck1($idfile,$idmember,$iddept)
    {
        $con = "";
        $v='';
        include ('Library/Connect_DB.php');
        $sql="SELECT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv1 WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='".$iddept."' AND position.IDPosition in (Select approvepcv1.Position2 FROM position,approvepcv1,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv1.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
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
        include('Library/Connect_DB.php');
        $sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv1 WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvepcv1.Position3 FROM position,approvepcv1,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv1.Position1 AND member.IDMember='".$idmember."') AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
        $query = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $v = $row;
        }
        return $v;
    }
    function callcheck2($idfile,$iddept)
    {
        $con = "";
        $v='';
        include('Library/Connect_DB.php');
        $sql = "SELECT member.IDMember,member.FullName FROM managermember,position,member WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND managermember.IDDept='".$iddept."' AND member.IDMember in (SELECT IDMember FROM approve WHERE IDFile='".$idfile."')";
        $query = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $v = $row;
        }
        return $v;
    }
    function check($idfile,$idmember)
    {
        $con = "";
        include('Library/Connect_DB.php');
        $sql = "SELECT TimeStamp,Approved,Deny,Note FROM approve WHERE IDFile='".$idfile."' AND IDMember='".$idmember."'";
        $query = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $v = $row;
        }
        return $v;
    }
    function checkdept($id)
    {
        $con = "";
        include('Library/Connect_DB.php');
        $v='';
        $sql = "SELECT NameDept FROM dept WHERE IDDept='".$id."'";
        $query = mysqli_query($con, $sql);
        if($query!== false && $query->num_rows>0) {
            while ($row = mysqli_fetch_array($query)) {
                $v = $row['NameDept'];
            }
        }
        return $v;
    }
    if(isset($_POST['result'])) {
        $value = $_POST['result'];
        $con = "";
        include ('Library/Connect_DB.php');
        $sql = "SELECT managerfile.IDFile,member.IDMember,dept.IDDept,dept.NameDept,pcv.IDDept as IDDept2,pcv.Content,pcv.Note,DATE_FORMAT(pcv.TimeStamp,'%H:%i:%s %d/%m/%Y') as TimeStamp, DATE_FORMAT(pcv.ngaytao,'Núi Thành, ngày %d tháng %m năm %Y') as ngaytao FROM managerfile,member,pcv,dept,managermember WHERE managerfile.IDFile = pcv.IDFile AND managerfile.IDMember = member.IDMember AND member.IDMember = managermember.IDMember AND dept.IDDept = managermember.IDDept AND managerfile.IDFile='".$value."'";
        $query = mysqli_query($con,$sql);
        if($query->num_rows>0){
            while($row=mysqli_fetch_array($query)){
                $v = array("IDFile"=>$row['IDFile'],"NameDept"=>$row['NameDept'],"TimeStamp"=>$row['TimeStamp'],"ngaytao" => $row['ngaytao'],"Content"=>$row['Content'],"Note"=>$row['Note'],"DeptNeed"=>checkdept($row['IDDept2']),"Check1"=>callcheck1($row['IDFile'],$row['IDMember'],$row['IDDept']),"Checked1"=>check($row['IDFile'],callcheck1($row['IDFile'],$row['IDMember'],$row['IDDept'])['IDMember']),"Check2"=>callcheck2($row['IDFile'],$row['IDDept2']),"Checked2"=>check($row['IDFile'],callcheck2($row['IDFile'],$row['IDDept2'])['IDMember']),"Approve"=>callapprove($row['IDFile'],$row['IDMember']),"Approved"=> check($row['IDFile'],callapprove($row['IDFile'],$row['IDMember'])['IDMember']));
            }
            echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
        }
        else echo json_encode(['code'=>201,'query'=>$sql]);
    
    }
    else
        echo json_encode(['code'=>201]);
}