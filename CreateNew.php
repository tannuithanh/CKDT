<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
if(!isset($username))
{
    header("Location: "."../RD/Index.php");
}
$con = "";
include ('Library/Connect_DB.php');
$sql = "SELECT COUNT(*) as ct FROM detailrequest";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
$totalrow =$row['ct'];
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 50;
$total_page = ceil($totalrow / $limit);
if ($current_page > $total_page){
    $current_page = $total_page;
}
else if ($current_page < 1){
    $current_page = 1;
}
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
function LoadData()
{
    $con = "";
    $v=array();
    include ('Library/Connect_DB.php');
    $sql = "SELECT COUNT(*) as ct FROM detailrequest";
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);
    $totalrow =$row['ct'];
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 50;
    if($totalrow!==0)
        $total_page = ceil($totalrow / $limit);
    else
        $total_page=0;
    if ($current_page > $total_page){
        $current_page = $total_page;
    }
    else if ($current_page < 1){
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    if($start<=0)
        $start=0;
    if(CheckAdminUser())
        $sql = "SELECT detailrequest.IDRequest,member.FullName,detailrequest.Content,detailrequest.Locationfile,DATE_FORMAT(detailrequest.TimeStamp,'%d/%m/%Y %H:%i:%s') as TimeStamp,DATE_FORMAT(detailrequest.TimeOut,'%d/%m/%Y %H:%i:%s') as TimeOut,detailrequest.TimeOut as TimeOut2,detailrequest.Note,detailrequest.LocationfileBG  FROM detailrequest,member WHERE detailrequest.IDMember = member.IDMember ORDER BY TimeStamp DESC LIMIT $start, $limit";
    else
        $sql = "SELECT detailrequest.IDRequest,member.FullName,detailrequest.Content,detailrequest.Locationfile,DATE_FORMAT(detailrequest.TimeStamp,'%d/%m/%Y %H:%i:%s') as TimeStamp,DATE_FORMAT(detailrequest.TimeOut,'%d/%m/%Y %H:%i:%s') as TimeOut,detailrequest.TimeOut as TimeOut2,detailrequest.Note,detailrequest.LocationfileBG  FROM detailrequest,member WHERE detailrequest.IDMember = member.IDMember AND detailrequest.IDMember = '".$_SESSION['idmember']."' ORDER BY TimeStamp DESC LIMIT $start, $limit";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0) {
        while ($row = mysqli_fetch_array($query)) {
            $v[] = $row;
        }
    }
    return $v;
}
function CheckIDRequest()
{
    $con='';
    $idrequest ='';
    include ('Library/Connect_DB.php');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $daynow = date('Ymd');
    $sql="SELECT COUNT(*) as ct from member where IDRequest like 'CNTT".$daynow."%'%)";
    $query=mysqli_query($con,$sql);
    while ($row=$query->fetch_assoc())
    {
        $idrequest = 'CNTT'.$daynow.sprintf('%03d',$row['ct']+1);
    }
    return $idrequest;
}
if(isset($_POST['btnSuccess']))
{
    $error = array();
    if(isset($_FILES['file']))
    {
        $target_dir = "FileUploads/";
        $target_file = $target_dir.basename($_FILES['file']['name']);
        if(file_exists($target_file))
        {
            $error['fileUpload'] = "File bạn chọn đã tồn tại trên hệ thống";
        }
        // Upload file
        if(empty($error)) {
            move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
            $con = '';
            include ('Library/Connect_DB.php');
            $idrequest ='';
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $daynow = date('Ymd');
            $sql="SELECT COUNT(*) as ct from detailrequest where IDRequest like 'CNTT".$daynow."%'";
            //echo '<script> alert("'.$sql.'")</script>';
            $query=mysqli_query($con,$sql);
            while ($row=$query->fetch_assoc())
            {
                $idrequest = 'CNTT'.$daynow.sprintf('%03d',$row['ct']+1);
            }
            $sql = "INSERT INTO detailrequest (IDRequest,IDMember,Content,Locationfile,TimeStamp,Note) VALUES ('".$idrequest."','".$idmember."','".$_POST['txtnoidung']."','".$_FILES['file']['name']."','".$_POST['txtngaygui']."','".$_POST['txtnote']."')";
            $query = mysqli_query($con,$sql);
        }
    }
}
if(isset($_POST['btnbbbg']))
{
    $error = array();
    if(isset($_FILES['filebg']))
    {
        $target_dir = "FileBG/";
        $target_file = $target_dir.basename($_FILES['filebg']['name']);
        if(file_exists($target_file))
        {
            $error['fileUpload'] = "File bạn chọn đã tồn tại trên hệ thống";
        }
        // Upload file
        if(empty($error)) {
            move_uploaded_file($_FILES['filebg']['tmp_name'], $target_file);
            $con = '';
            include ('Library/Connect_DB.php');
            $sql = "UPDATE detailrequest SET LocationfileBG ='".$_FILES['filebg']['name']."',Note='".$_POST['txtnote2']."' WHERE IDRequest='".$_POST['txtsophieu']."'";
            $query = mysqli_query($con,$sql);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>R&D Ô TÔ</title>
    <?php include ('Library/librarycss.php') ?>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;display: flex;justify-content: center">
        <div style="width: 100%">
            <div style="border: solid 1px gray;width: 100%;height: auto;margin: 0px auto;background: #fffcd5;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
                    <div>
                        <h6 class="m-0 font-weight-bold" style="color: #fffcd5">Quản lý đặt hàng CNTT - Thaco KIA</h6>
                    </div>
                    <div class="input-group" style="width: 400px">
                        <input id="txtID" class="form-control" type="text" placeholder="Search.." name="search">
                        <button onclick="setdata()" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                        <button onclick="document.getElementById('detail').style.display='block';" class="btn btn-success" type="button" style="margin-left: 10px">Tạo mới</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="min-height: 400px;font-family: Tahoma;font-size: 14px;margin: 0px 0px 10px 0px" >
                <table id="tableshow" class="table align-items-center table-flush table-hover" style="background: white;color: black">
                    <thead class="thead-light">
                    <tr>
                        <th style="background: #fffcd5;color: black">STT</th>
                        <th style="background: #fffcd5;color: black">Mã phiếu</th>
                        <th style="background: #fffcd5;color: black">Người tạo</th>
                        <th style="background: #fffcd5;color: black">Nội dung</th>
                        <th style="background: #fffcd5;color: black">Ngày gửi</th>
                        <th style="background: #fffcd5;color: black">Xác nhận</th>
                        <th style="background: #fffcd5;color: black">Ngày về</th>
                        <th style="background: #fffcd5;color: black">Tình trạng</th>
                        <th style="background: #fffcd5;color: black">Đính kèm YC</th>
                        <th style="background: #fffcd5;color: black">Đính kèm BBBG</th>
                        <th style="background: #fffcd5;color: black">Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white">
                    <?php
                    $id=0;
                    foreach (LoadData() as $value)
                    { $id++; ?>
                        <tr data-id="<?= $value['IDRequest'];?>">
                            <td><?php echo $id;?></td>
                            <td class="idnv" value='<?php echo$value['IDRequest']; ?>'><?php echo $value['IDRequest'];?></td>
                            <td><?php echo $value['FullName'];?></td>
                            <td><?php echo $value['Content'];?></td>
                            <td><?php echo $value['TimeStamp'];?></td>
                            <?php
                            if(CheckAdminUser()) {
                                if ($value['TimeOut'] == '00/00/0000 00:00:00')
                                    $v = "<a class='badge badge-danger' href='http://113.161.6.179:8089/RD/AcceptRequest.php?ID=".$value['IDRequest']."' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Chưa xác nhận</a>";
                                else
                                    $v = "<span class='badge badge-success' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã xác nhận</span>";
                            }
                            else
                            {
                                if ($value['TimeOut'] == '00/00/0000 00:00:00')
                                    $v = "<span class='badge badge-danger' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Chưa xác nhận</span>";
                                else
                                    $v = "<span class='badge badge-success' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã xác nhận</span>";
                            }
                            ?>
                            <td><?php echo $v;?></td>
                            <td><?php if($value['TimeOut']=='00/00/0000 00:00:00') echo ''; else echo $value['TimeOut'];?></td>
                            <td><?php
                                if($value['TimeOut']=='00/00/0000 00:00:00')
                                echo "Chờ xác nhận";
                                else if(( $value['LocationfileBG'])!='')
                                {
                                    echo "<span class='badge badge-primary' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Hoàn thành</span>";
                                }
                                else
                                {
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $date = date('Y-m-d');
                                    $date = strtotime('+5 day',strtotime($date));
                                    $date = date('Y-m-d 00:00:00',$date);
                                    $date2 = strtotime($value['TimeOut2']);
                                    $date2 = date('Y-m-d 00:00:00',$date2);
                                    if($date<=$date2)
                                    echo "<span class='badge badge-success' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Chờ hàng</span>";
                                    else
                                    {
                                        $date = date('Y-m-d');
                                        $date = strtotime('+3 day',strtotime($date));
                                        $date = date('Y-m-d 00:00:00',$date);
                                        if($date<=$date2) {
                                            echo "<span class='badge badge-warning' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Sắp trễ hàng</span>";
                                        }
                                        else {
                                            echo "<span class='badge badge-danger' style='width: 120px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Trễ hàng</span>";

                                        }
                                    }
                                }
                                ?></td>
                            <?php $linkdownload = "FileUploads/".$value['Locationfile'];?>
                            <td><a href="<?php echo $linkdownload?>" target="_blank"><?php echo $value['Locationfile'];?></a></td>
                            <td><?php
                                if($value['LocationfileBG']!='')
                                    echo "<a href='"."FileBG/".$value['LocationfileBG']."' target='_blank'>".$value['LocationfileBG']."</a>";
                                else
                                {
                                    if(CheckAdminUser())
                                    {
                                        echo '<button class="btn btn-primary detail" type="button">Nhập BBBG</button>';
                                    }
                                    else
                                        echo '';
                                }
                                ?></td>
                            <td><?php echo $value['Note'];?></td>
                        </tr>
                    <?php }
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="detail" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
                <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:500px;height: 120px">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c;height: 40px">
                        <h6 class="m-0 font-weight-bold" style="color: #fffcd5"><a id="hy">NHẬP THÔNG TIN PHIẾU YÊU CẦU</a></h6>
                    </div>
                    <div class="table-responsive" style="height: 190px;background: grey" >
                        <table style="background: white;width: 500px;font-family: Tahoma;font-size: 14px" class="table align-items-center table-flush">
                            <tr>
                                <td style="width: 200px">Nội dung yêu cầu: </td>
                                <td><input name="txtnoidung" style="width: 100%" id="txtnoidung" placeholder="Nhập nội dung phiếu yêu cầu."></td>
                            </tr>
                            <tr>
                                <td style="width: 200px">Ngày gửi: </td>
                                <td><input name="txtngaygui" id="txtngaygui" type="datetime-local" value="<?php
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    echo date('Y-m-d\TH:i');
                                    ?>" readonly></td>
                            </tr>
                            <tr>
                                <td style="width: 200px">Đính kèm phiếu: </td>
                                <td><input id="file" name="file" accept=".pdf,.JPG,.PNG,.JPEG" type="file"></td>
                            </tr>
                            <tr>
                                <td style="width: 200px">Ghi chú: </td>
                                <td><input id="txtnote" name="txtnote" style="width: 300px" placeholder="Nhập ghi chú"</td>
                            </tr>
                        </table>
                    </div>
                    <div style="background: white">
                        <button style="width: 150px;margin-left: 90px;margin-bottom: 10px" type="submit" name="btnSuccess" class="btn btn-primary">Hoàn thành</button>
                        <button style="width: 150px;margin-bottom: 10px" onclick="document.getElementById('detail').style.display='none'" type="button" class="btn btn-danger">Hủy bỏ</button>
                    </div>
                </div>
            </div>
            <div id="bbbg" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
                <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:500px;height: 120px">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c;height: 40px">
                        <h6 class="m-0 font-weight-bold" style="color: #fffcd5"><a id="hy">NHẬP BIÊN BẢN BÀN GIAO THIẾT BỊ</a></h6>
                    </div>
                    <div class="table-responsive" style="height: 190px;background: grey" >
                        <table style="background: white;width: 500px;font-family: Tahoma;font-size: 14px" class="table align-items-center table-flush">
                            <tr>
                                <td style="width: 200px">Số phiếu: </td>
                                <td><input name="txtsophieu" style="width: 100%" id="txtsophieu" <?php if(!CheckAdminUser()) echo 'readonly' ?>></td>
                            </tr>
                            <tr>
                                <td style="width: 200px">Ngày gửi: </td>
                                <td><input name="txtngaygui" id="txtngaygui" type="datetime-local" value="<?php
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    echo date('Y-m-d\TH:i');
                                    ?>" readonly></td>
                            </tr>
                            <tr>
                                <td style="width: 200px">Đính kèm BB: </td>
                                <td><input id="filebg" name="filebg" accept=".pdf,.JPG,.PNG,.JPEG" type="file"></td>
                            </tr>
                            <tr>
                                <td style="width: 200px">Ghi chú: </td>
                                <td><input id="txtnote2" name="txtnote2" style="width: 300px" placeholder="Nhập ghi chú"</td>
                            </tr>
                        </table>
                    </div>
                    <div style="background: white">
                        <button style="width: 150px;margin-left: 90px;margin-bottom: 10px" type="submit" name="btnbbbg" class="btn btn-primary">Hoàn thành</button>
                        <button style="width: 150px;margin-bottom: 10px" onclick="document.getElementById('bbbg').style.display='none'" type="button" class="btn btn-danger">Hủy bỏ</button>
                    </div>
                </div>
            </div>
            <nav class="navbar fixed-bottom bg-white text-right">
                <div class="table-responsive">
                    <?php
                    if ($current_page > 1 && $total_page > 1){
                        echo '<a href="../QualityDept/truyvetthongtin.php?page='.($current_page-1).'">Prev</a> | ';
                    }

                    // Lặp khoảng giữa
                    for ($i = 1; $i <= $total_page; $i++){
                        // Nếu là trang hiện tại thì hiển thị thẻ span
                        // ngược lại hiển thị thẻ a
                        if ($i == $current_page){
                            echo '<span>'.$i.'</span> | ';
                        }
                        else{
                            echo '<a href="../QualityDept/truyvetthongtin.php?page='.$i.'">'.$i.'</a> | ';
                        }
                    }

                    // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                    if ($current_page < $total_page && $total_page > 1){
                        echo '<a href="../QualityDept/truyvetthongtin.php?page='.($current_page+1).'">Next</a> | ';
                    }
                    ?>
                </div>
            </nav>
        </div>
    </div>
</form>
<?php include('Library/navbar.php') ?>
<!--===============================================================================================-->
<?php include ('Library/libraryscript.php')?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script>
    var IDRequest='';
    $('body').on('click', '.detail', function() {
        document.getElementById('bbbg').style.display='block';
        let _parent = $(this).closest("tr");
        IDRequest = _parent.data('id');
        console.log(IDRequest);
        document.getElementById('txtsophieu').value=IDRequest;
    });
    function save(result){
        $.ajax({
            url:'save.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                console.log(result);
                document.getElementById('txtnoidung').value='';
                document.getElementById('txtngaygui').value='';
                document.getElementById('txtnote').value = '';
                document.getElementById('detail').style.display='none';
                location.reload();

            },
            error:function(error){
                console.log(error.responseText);
            }
        })
    }
    function savedata()
    {
        var noidung = document.getElementById('txtnoidung').value;
        var ngaygui = document.getElementById('txtngaygui').value;
        var note = document.getElementById('txtnote').value;
        var file = $('#file').prop('files')[0].name;
        var value = {noidung,ngaygui,note,file};
        console.log(value);
        save(value);
    }

    function setdata()
    {
        var value = document.getElementById('txtID').value;
        console.log(value);
        getdata(value);
    }
    function getdata(value)
    {
        $.ajax({
            url: 'searchinfo.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    value:value
                },
            success:function (value)
            {
                console.log(value);
                var table = document.getElementById("tbdata")
                $("#tbdata").empty();
                var stt=0;
                for(var i=0;i<value.result.length;i++)
                {
                    var row = table.insertRow(stt);
                    stt++;
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    var cell6 = row.insertCell(5);
                    var cell7 = row.insertCell(6);
                    var cell8 = row.insertCell(7);
                    var cell9 = row.insertCell(8);
                    var cell10 = row.insertCell(9);
                    var cell11 = row.insertCell(10);
                    cell1.innerHTML = stt;
                    cell2.innerHTML = value.result[i].IDRequest;
                    cell3.innerHTML = value.result[i].FullName;
                    cell4.innerHTML = value.result[i].Content;
                    cell5.innerHTML = value.result[i].TimeStamp;
                    cell6.innerHTML = value.result[i].XN;
                    cell7.innerHTML = value.result[i].TimeOut;
                    cell8.innerHTML=value.result[i].TT;
                    cell9.innerHTML=value.result[i].Locationfile
                    cell10.innerHTML = value.result[i].LocationfileBG;
                    cell11.innerHTML = value.result[i].Note;
                }
            },
            error:function (error){
                $("#tbdata").empty();
                console.log(error);
                alert('Số phiếu không hợp lệ! Vui lòng kiểm tra lại');
            }
        })
    }
</script>