<?php
session_start();
if(isset($_SESSION['Name'])) {
    $username = $_SESSION['Name'];
    $idmember = $_SESSION['idmember'];
    $namedept = $_SESSION['NameDept'];
    $iddept = $_SESSION['IDDept'];
    $nameposition = $_SESSION['NamePosition'];
    $idposition = $_SESSION['IDPosition'];
}
else
{
    $CurPageURL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['LinkCur']=$CurPageURL;
    header("Location: "."../RD/Index.php");
}
$con="";
include ('Library/Connect_DB.php');
$select=array();
$sql = "SELECT statusfile.IDStatus,statusfile.NameStatus FROM changestatus,statusfile,member,groupmember,position,managermember  WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup=groupmember.IDGroup AND groupmember.IDGroup = changestatus.IDGroup AND changestatus.IDStatus = statusfile.IDStatus AND member.IDMember='".$idmember."' ORDER BY statusfile.IDStatus ASC";
$query = mysqli_query($con,$sql);
while ($row=mysqli_fetch_array($query))
{
    $select[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>THACO AUTO</title>
    <?php include ('Library/librarycss.php') ?>
    <body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG" onload="ClockApp()">
   <!-- <body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG"  onload="ClockApp()"> Bỏ chuông thông báo--> 
</head>
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;min-width: 700px;display: flex;justify-content: center">
        <div class="card-header" style="width: 100%;background: white">
            <div class="form-group">
            <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px;width: 50%">Quản lý hồ sơ</h6>
                <div style="display: flex;min-width: 700px">
                <div class="form-group" style="width: 50%;align-items: center;float: right">
                    <div id="mf-menu-sl" style="position: absolute;right: 0px;margin-right: 20px;display: flex;align-items: center">
                    <h6 style="color: #00529c;margin-right: 10px">Lọc hồ sơ:  </h6>
                    <select id="slmenu" onchange="change();" style="width: 200px;height: 30px;font-size: 15px;font-family: Tahoma">
                        <?php foreach ($select as $v)
                        {?>
                            <option value="<?php echo $v['IDStatus'];?>"><?php echo $v['NameStatus']; ?></option>
                        <?php }?>
                    </select>
                    </div>
                </div>
                </div>
                <hr>
            </div>
            <div class="form-group">
                <div style="width: 100%;background: white;">
                    <table id="tableshow" class="table table-bordered align-items-center table-flush table-hover" style="background: white;color: black">
                        <thead class="thead-light">
                        <tr>
                            <th style="background: #00529c;color: white;text-align: center">STT</th>
                            <th style="background: #00529c;color: white;text-align: center">Mã phiếu</th>
                            <th style="background: #00529c;color: white;text-align: center">Nhân sự</th>
                            <th style="background: #00529c;color: white;text-align: center">Bộ phận</th>
                            <th style="background: #00529c;color: white;text-align: center">Loại phiếu</th>
                            <th style="background: #00529c;color: white;text-align: center">Thời gian tạo</th>
                            <th style="background: #00529c;color: white;text-align: center">Trạng thái</th>
                            <th style="background: #00529c;color: white;text-align: center">Tiến trình duyệt</th>
                            <th style="background: #00529c;color: white;text-align: center">Chức năng</th>
                        </tr>
                        </thead>
                        <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script>
    $(document).ready(function (){
        var value = document.getElementById("slmenu").value;
        $("#tbdata").empty();
        LoadFile(value);
    });
    function change()
    {
        var value = document.getElementById("slmenu").value;
        $("#tbdata").empty();
        LoadFile(value);
    }
    function LoadFile(value)
    {
        $.ajax({
            url: 'getfile.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    value:value
                },
            success:function (value)
            {
                var table = document.getElementById("tbdata")
                var stt=0;
                console.log(value);
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
                    cell1.innerHTML = stt;
                    cell2.innerHTML = value.result[i].idfile;
                    cell3.innerHTML = value.result[i].fullname;
                    cell4.innerHTML = value.result[i].namedept;
                    cell5.innerHTML = value.result[i].namefunction;
                    cell6.innerHTML = value.result[i].time;
                    cell7.innerHTML = value.result[i].status;
                    cell8.innerHTML = value.result[i].checkposition;
                    cell9.innerHTML = value.result[i].function;
                }
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }
</script>