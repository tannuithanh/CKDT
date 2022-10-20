<?php
session_start();
function CheckAdminUser()
{
    $con = "";
    $v ='';
    include ('Library/Connect_DB.php');
    $sql = "SELECT AdminUser FROM member WHERE IDMember='".$_SESSION['idmember']."'";
    $query=mysqli_query($con,$sql);
    while ($row=$query->fetch_assoc())
    {
        $v=$row['AdminUser'];
    }
    return $v;
}
if(isset($_POST['value'])) {
    $value = $_POST['value'];
    $v = array();
    $con = '';
    include ('Library/Connect_DB.php');
    $sql = "SELECT detailrequest.IDRequest, member.FullName, detailrequest.Content, detailrequest.Locationfile,DATE_FORMAT(detailrequest.TimeStamp,'%d/%m/%Y %H:%i:%s') as TimeStamp,DATE_FORMAT(detailrequest.TimeOut,'%d/%m/%Y %H:%i:%s') as TimeOut,detailrequest.TimeOut as TimeOut2, detailrequest.Note, detailrequest.LocationfileBG FROM detailrequest,member WHERE detailrequest.IDMember = member.IDMember AND detailrequest.IDRequest like '%".$value."%' ORDER BY detailrequest.IDRequest ASC";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $linkdownload = "FileUploads/".$row['Locationfile'];
            $fileBG = "FileBG/".$row['LocationfileBG'];
            if(CheckAdminUser()) {
                if ($row['TimeOut'] == '00/00/0000 00:00:00')
                    $v2 = "<a class='badge badge-danger' href='../RD/AcceptRequest.php?ID=".$row['IDRequest']."' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Chưa xác nhận</a>";
                else
                    $v2 = "<span class='badge badge-success' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã xác nhận</span>";
            }
            else
            {
                if ($row['TimeOut'] == '00/00/0000 00:00:00')
                    $v2 = "<span class='badge badge-danger' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Chưa xác nhận</span>";
                else
                    $v2 = "<span class='badge badge-success' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã xác nhận</span>";
            }
            if($row['TimeOut']=='00/00/0000 00:00:00')
                $v3 = "Chờ xác nhận";
            else if(( $row['LocationfileBG'])!='')
            {
                $v3 = "<span class='badge badge-primary' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Hoàn thành</span>";
            }
            else
            {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $date = date('Y-m-d');
                $date = strtotime('+5 day',strtotime($date));
                $date = date('Y-m-d 00:00:00',$date);
                $date2 = strtotime($row['TimeOut2']);
                $date2 = date('Y-m-d 00:00:00',$date2);
                if($date<=$date2)
                    $v3 = "<span class='badge badge-success' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Chờ hàng</span>";
                else
                {
                    $date = date('Y-m-d');
                    $date = strtotime('+3 day',strtotime($date));
                    $date = date('Y-m-d 00:00:00',$date);
                    if($date<=$date2) {
                        $v3 = "<span class='badge badge-warning' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Sắp trễ hàng</span>";
                    }
                    else {
                        $v3 = "<span class='badge badge-danger' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Trễ hàng</span>";
                    }
                }
            }
            if($row['LocationfileBG']!='')
                $v4= "<a href='"."FileBG/".$row['LocationfileBG']."' target='_blank'>".$row['LocationfileBG']."</a>";
            else
            {
                if(CheckAdminUser())
                {
                    $v4= '<button class="btn btn-primary detail" type="button">Nhập BBBG</button>';
                }
                else
                    $v4= '';
            }
            if($row['TimeOut']=='00/00/0000 00:00:00')
                $v5= '';
            else
                $v5= $row['TimeOut'];
            $v[] = array("IDRequest"=>$row['IDRequest'],"FullName"=>$row['FullName'],"Content"=>$row['Content'],"XN"=>$v2,"Locationfile"=>"<a href='".$linkdownload."'>".$row['Locationfile']."</a>","TimeStamp"=>$row['TimeStamp'],"TimeOut"=>$v5,"TT"=>$v3,"LocationfileBG"=>$v4,"Note"=>$row['Note']);
        }
        echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
    }
}
else
    echo json_encode(['code'=>201]);
