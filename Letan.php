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
    header("Location: "."../RD/Index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>THACO AUTO</title>
    <?php include ('Library/librarycss.php') ?>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;min-width: 700px;display: flex;justify-content: center">
        <div class="card-header" style="width: 100%;background: white">
            <div class="form-group">
                <div style="display: flex;min-width: 700px">
                    <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Thông tin giấy xin phép</h6>
                    <div class="d-flex" style="position: absolute;right: 20px">
                        <input id="txtidfile" class="form-control mr-1" type="search" placeholder="Tìm mã số nhân viên">
                        <button onclick="SearchFile();" class="btn btn-outline-success" type="button" style="width: 120px">Tra phiếu</button>
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
                            <th style="background: #00529c;color: white;text-align: center">Lý do</th>
                            <th style="background: #00529c;color: white;text-align: center">Từ ngày</th>
                            <th style="background: #00529c;color: white;text-align: center">Đến ngày</th>
                            <th style="background: #00529c;color: white;text-align: center">Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <nav style="position: fixed;bottom: 0px;width: 100%" class="navbar navbar-dark bg-dark">
        <div id="Pagination" style="margin: auto">
        </div>
    </nav>
</form>
</body>
</html>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script type="text/javascript">
    $(document).ready(function (){
        document.getElementById('itemnotify').style.display='none';
        var page = "<?php echo $_GET['page']?>";
        $("#tbdata").empty();
        LoadFile(page);
        LoadPagination(page);
    });
    function LoadPagination(result){
        $.ajax({
            url: 'Pagination2.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                console.log(result);
                document.getElementById('Pagination2').innerHTML=result.result;
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }
    function SearchFile(){
        var result = document.getElementById('txtidfile').value;
        $("#tbdata").empty();
        Searchfile(result);
    }
    function LoadFile(result){
        $.ajax({
            url: 'dsnghiphep.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                console.log(result);
                if(result.result.length!=0) {
                    var table = document.getElementById("tbdata")
                    var stt = 0;
                    console.log(result);
                    for (var i = 0; i < result.result.length; i++) {
                        var file = "<a style='font-size: 14px;font-family: Tahoma;line-height: 20px' href='../RD/F0012.php?id="+result.result[i].IDFile+"' target='_blank'>"+result.result[i].IDFile+"</a>";
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
                      
                        cell1.innerHTML = stt;
                        cell2.innerHTML = file;
                        cell3.innerHTML = result.result[i].FullName;
                        cell4.innerHTML = result.result[i].NameDept;
                        cell5.innerHTML = result.result[i].Reason;
                        cell6.innerHTML = result.result[i].TimeStampStart;
                        cell7.innerHTML = result.result[i].TimeStampIn;
                        cell8.innerHTML = result.result[i].Note;
                        
                    }
                }
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }
    function Searchfile(result){
        $.ajax({
            url: 'searchletan.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                console.log(result);
                if(result.result.length!=0) {
                    var table = document.getElementById("tbdata")
                    var stt = 0;
                    console.log(result);
                    for (var i = 0; i < result.result.length; i++) {
                        var file = "<a style='font-size: 14px;font-family: Tahoma;line-height: 20px' href='../RD/F0012.php?id="+result.result[i].IDFile+"' target='_blank'>"+result.result[i].IDFile+"</a>";
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
                        cell1.innerHTML = stt;
                        cell2.innerHTML = file;
                        cell3.innerHTML = result.result[i].FullName;
                        cell4.innerHTML = result.result[i].NameDept;
                        cell5.innerHTML = result.result[i].Reason;
                        cell6.innerHTML = result.result[i].TimeStampStart;
                        cell7.innerHTML = result.result[i].TimeStampIn;
                        cell8.innerHTML = result.result[i].Note;
                    }
                }
                else {
                    if(result.Value!="") {
                        swal.fire('Thông báo', 'Mã phiếu không tồn tại. Vui lòng kiểm tra lại', 'error').then((resu) => {
                            var page ="<?php echo $_GET['page'];?> ";
                            LoadFile(page);
                        });
                    }
                }
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }
</script>
