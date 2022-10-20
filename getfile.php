<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
$idgroup = $_SESSION['IDGroup'];
function checkstatus($idfunction,$idfile)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $numberapprove=0;
    $v="";
    $status="";
    $sql="SELECT NumberApprove FROM funtion WHERE IDFunction='".$idfunction."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $numberapprove = $row['NumberApprove'];
    }
    $sql="SELECT COUNT(*) as ct FROM approve WHERE IDFile='".$idfile."' AND Approved=1";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($row['ct']==$numberapprove) {
            $v = "<span class='badge badge-success' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã duyệt</span>";
            $status="S0003";
        }
        else {
            $v = "<span class='badge badge-warning' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đang duyệt</span>";
            $status="S0002";
        }
    }
    $sql ="SELECT * FROM approve WHERE IDFile='".$idfile."' AND Approved=0";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($_SESSION['idmember'] == $row['IDMember'])
        {
            if($row['No']>1) {
                $nonew = $row['No']-1;
                $sql = "SELECT COUNT(*) as ct FROM approve WHERE Approved=1 AND No='" . $nonew . "' AND IDFile='" . $idfile . "'";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    if ($row['ct'] > 0) {
                        $v = "<span class='badge badge-primary' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Cần duyệt</span>";
                        $status = "S0005";
                    }
                }
            }
            else
            {
                $v = "<span class='badge badge-primary' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Cần duyệt</span>";
                $status = "S0005";
            }
        }
    }
    $sql="SELECT Deny FROM managerfile WHERE IDFile='".$idfile."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($row['Deny']==1) {
            $v = "<span class='badge badge-danger' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã từ chối</span>";
            $status="S0004";
        }
    }

    return array($v,$status);
}
function CheckPosition($idfile)
{
    $con = "";
    $v ="<div id='sbcontainer'><ul id='steppogbar'><li class='active'>Đã gửi</li>";
    include ('Library/Connect_DB.php');
    $numberapprove=0;
    $sql="SELECT COUNT(*) as ct FROM approve WHERE IDFile='".$idfile."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $numberapprove = $row['ct'];
    }
    $deny=0;
    for($i=1;$i<=$numberapprove;$i++)
    {
        $v.="<li";
        $idmember = $_SESSION['idmember'];
        $no="";
        $sql = "SELECT No,Approved,Deny,IDMember FROM approve WHERE No='".$i."' AND IDFile='".$idfile."'";
        $query = mysqli_query($con,$sql);
        while ($row = mysqli_fetch_array($query))
        {
            if($row['No'] !== $numberapprove)
                $no = $row['No'];
            else
                $no = "Đã duyệt";
            if($row['Deny']==1) {
                $v .= " class='deny'>" . $no . "</li>";
                $deny=1;
            }
            else if($row['Approved']==1)
            $v.=" class='active'>".$no."</li>";
            else {
                if($deny==0) {
                    if($idmember !== $row['IDMember'])
                    $v .= " class='cheking'>" . $no . "</li>";
                    else
                        $v .= " class='mycheking'>" . $no . "</li>";
                }
                else
                    $v .= ">" . $no . "</li>";
            }
        }
    }
    $v.="</ul></div>";
    return $v;
}
if(isset($_POST['value'])) {
    $value = $_POST['value'];
    $v = array();
    $con = "";
    $id="";
    include ('Library/Connect_DB.php');
    if($idgroup == 'G0006')
        $sql = "SELECT DISTINCT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='".$idmember."') ORDER BY managerfile.Timestamp DESC";
    else {
        if($idgroup=='G0005' )
            $sql = "SELECT DISTINCT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,member,funtion,dept,managermember WHERE (managerfile.IDMember=member.IDMember OR managerfile.IDMemberCreate=member.IDMember) AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND member.IDMember = '" . $idmember . "' AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC ";
        else if($idgroup=='G0003' || $idgroup=='G0011')$sql = "SELECT DISTINCT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND dept.IDDept = '" . $iddept . "' AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
        else $sql ="SELECT DISTINCT managerfile.IDFile,member.FullName,Dept.NameDept,funtion.NameFunction,DATE_FORMAT(managerfile.Timestamp,'%H:%i:%s %d/%m/%Y') as Timestamp FROM managerfile,member,funtion,dept,managermember WHERE (managerfile.IDMember=member.IDMember OR managerfile.IDMemberCreate=member.IDMember) AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND (dept.IDDept = '" . $iddept . "' OR managerfile.IDFile IN (SELECT IDFile FROM approve WHERE IDMember='" . $idmember . "')) AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
    }
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $id=substr($row['IDFile'],0,5);
            $status = checkstatus(substr($row['IDFile'],0,5),$row['IDFile']);
            if($value=="S0001")
                $v[] = array('idfile'=>$row['IDFile'],'fullname'=>$row['FullName'],'namedept'=>$row['NameDept'],'namefunction'=>$row['NameFunction'],'time'=>$row['Timestamp'],'status'=>$status[0],'checkposition'=>CheckPosition($row['IDFile']),'function'=>"<a class='badge badge-info' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px' href='/RD/".$id.".php?id=".$row['IDFile']."' target='_blank'>Xem chi tiết</a>");
            else
            {
                if($value==$status[1])
                    $v[] = array('idfile'=>$row['IDFile'],'fullname'=>$row['FullName'],'namedept'=>$row['NameDept'],'namefunction'=>$row['NameFunction'],'time'=>$row['Timestamp'],'status'=>$status[0],'checkposition'=>CheckPosition($row['IDFile']),'function'=>"<a class='badge badge-info' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px' href='/RD/".$id.".php?id=".$row['IDFile']."' target='_blank'>Xem chi tiết</a>");
            }
        }
        echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql,'group'=>$idgroup]);
    }
}
else
    echo json_encode(['code'=>201]);
