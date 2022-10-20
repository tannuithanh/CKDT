<?php
if(isset($_POST['result'])) {
    $pagecurrent = $_POST['result'];
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT gvc.IDFile,member.FullName,dept.NameDept,gvc.Reason,DATE_FORMAT(gvc.TimeStampOut,'%H:%i:%s %d/%m/%Y') as TimeStampOut ,DATE_FORMAT(gvc.TimeStampIn,'%H:%i:%s %d/%m/%Y') as TimeStampIn,gvc.LicensePlates,gvc.Bring,gvc.Note,gvc.NameIn,gvc.Donvi, FROM managerfile,gvc,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = gvc.IDFile AND gvc.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 ORDER BY managerfile.Timestamp DESC";
//$sql = "SELECT gvc.IDFile,member.FullName,dept.NameDept,gvc.Reason,DATE_FORMAT(gvc.TimeStampOut,'%H:%i:%s %d/%m/%Y') as TimeStampOut ,DATE_FORMAT(gvc.TimeStampIn,'%H:%i:%s %d/%m/%Y') as TimeStampIn,gvc.LicensePlates,gvc.Bring,gvc.Note FROM managerfile,gvc,approve,member,managermember,dept WHERE member.IDMember = managerfile.IDMember AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND managerfile.IDFile = gvc.IDFile AND gvc.IDFile = approve.IDFile AND approve.No=2 AND approve.Approved=1 AND approve.Deny=0 AND managerfile.IDFile like '%".$value."%'ORDER BY managerfile.Timestamp DESC";
    $query = mysqli_query($con, $sql);
    $totalrow = $query->num_rows;
    $pagenum = ceil($totalrow / 50);
    $v = "";
    if ($pagenum > 1) {
        if($pagecurrent!=="1")
            $v .= "<a style='font-size: 14px;font-family: Tahoma;color: white' href='../RD/Baove.php?page=" . ($pagecurrent-1 ). "'>" .'Pre'. "</a>";
        for ($i = 1; $i <= $pagenum; $i++) {
            if($i<$pagecurrent-3)
                $v.= "";
            else if($i>$pagecurrent+3)
                $v.="";
            else if($i==$pagecurrent-3)
                $v .= "<span style='font-size: 14px;font-family: Tahoma;color: white'> ... </span>";
            else if($i==$pagecurrent+3)
                $v .= "<span style='font-size: 14px;font-family: Tahoma;color: white'> ... </span>";
            else if($i !== $pagecurrent*1)
                $v .= "<a style='width: 30px;font-size: 14px;font-family: Tahoma;color: white' href='http://http://113.161.6.179:8089/RD/Baove2.php?page=" . $i . "'>"." ". $i ." "."</a>";
            else
                $v .= "<span style='font-size: 14px;font-family: Tahoma;color: white'>"." ".$i." "."</span>";
        }
        if($pagecurrent!=$pagenum)
            $v .= "<a style='font-size: 14px;font-family: Tahoma;color: white' href='http://http://113.161.6.179:8089/RD/Baove2.php?page=" . ($pagecurrent+1 ). "'>" .'Next'. "</a>";
    }
    echo json_encode(['result' => $v, 'code' => 200,'page'=>$pagecurrent]);
}
else
    echo json_encode(['code'=>201]);