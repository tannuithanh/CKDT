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
    header("Location: "."Index.php");
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
                <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Thông tin giấy vào cổng</h6>
                    <div> 
                    </div>
                    <div class="d-flex" style="position: absolute;right: 20px">
                        <input id="txtidfile" class="form-control mr-1" type="search" placeholder="Tìm mã số nhân viên bảo lãnh">
                        <button onclick="SearchFile();" class="btn btn-outline-success" type="button" style="width: 150px">Tra phiếu</button>
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
                            <th style="background: #00529c;color: white;text-align: center">Nhân sự vào</th>
                            <th style="background: #00529c;color: white;text-align: center">Đơn vị</th>
                            <th style="background: #00529c;color: white;text-align: center">Thời gian vào</th>
                            <th style="background: #00529c;color: white;text-align: center">Thời gian ra</th>
                            <th style="background: #00529c;color: white;text-align: center">Lý do</th>
                            <th style="background: #00529c;color: white;text-align: center">Phương tiện</th>
                            <th style="background: #00529c;color: white;text-align: center">Mang theo</th>
                            <th style="background: #00529c;color: white;text-align: center">Nhân sự bảo lãnh</th>
                            <th style="background: #00529c;color: white;text-align: center">Bộ phận</th>
                            <th style="background: #00529c;color: white;text-align: center">Ghi chú</th>
                            <th style="background: #00529c;color: white;text-align: center">Xác nhận vào</th>
                            <th style="background: #00529c;color: white;text-align: center">Xác nhận ra</th>
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
        var page = "<?php echo $_GET['page']?>";
        $("#tbdata").empty();
        LoadFile(page);
        LoadPagination(page);
    });
    function LoadPagination(result){
        $.ajax({
            url: 'Pagination4.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                document.getElementById('Pagination').innerHTML=result.result;
            },
            error:function (error){
                 (error.responseText);
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
            url: 'dsbaove1.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                if(result.result.length!=0) {
                    var table = document.getElementById("tbdata")
                    var stt = 0;

                    for (var i = 0; i < result.result.length; i++) {
                        var file = "<a style='font-size: 14px;font-family: Tahoma;line-height: 20px' href='http://113.161.6.179:8089/RD/F0020.php?id="+result.result[i].IDFile+"' target='_blank'>"+result.result[i].IDFile+"</a>";
                        var row = table.insertRow(stt);
                        stt++;
                        var celll1 = row.insertCell(0);
                        var celll2 = row.insertCell(1);
                        var celll3 = row.insertCell(2);
                        var celll4 = row.insertCell(3);
                        var celll5 = row.insertCell(4);
                        var celll6 = row.insertCell(5);
                        var celll7 = row.insertCell(6);
                        var celll8 = row.insertCell(7);
                        var celll9 = row.insertCell(8);
                        var celll10 = row.insertCell(9);
                        var celll11 = row.insertCell(10);
                        var celll12 = row.insertCell(11);
                        var celll13 = row.insertCell(12);
                        var celll14 = row.insertCell(13);
                        celll1.innerHTML = stt;
                        celll2.innerHTML = file;
                        celll13.innerHTML = result.result[i].NameIn;
                        celll4.innerHTML = result.result[i].Donvi;
                        celll3.innerHTML = result.result[i].NameIn;
                        celll5.innerHTML = result.result[i].TimeStampOut;
                        celll6.innerHTML = result.result[i].TimeStampIn;
                        celll7.innerHTML = result.result[i].Reason;
                        celll8.innerHTML = result.result[i].LicensePlates;
                        celll9.innerHTML = result.result[i].Bring;
                        celll10.innerHTML = result.result[i].FullName;
                        celll11.innerHTML = result.result[i].NameDept;
                        celll12.innerHTML = result.result[i].Note;
                        if (result.result[i].AcceptOut!==null)
                            celll13.innerHTML=result.result[i].AcceptOut;
                        else
                            celll13.innerHTML="<button class='btn btn-primary' type='button' onclick='var result="+'"'+result.result[i].IDFile+'"'+";Acceptout(result);'>Accept</button>";
                        if (result.result[i].AcceptOut!==null){
                            if (result.result[i].TimeStampIn !== "00:00:00 00/00/0000"){
                                if (result.result[i].AcceptIn!==null){
                                    var day1= result.result[i].AcceptIn;
                                    let dayin1 = day1.split(' ')
                                    var timein1 = dayin1[0];
                                    dayin1 = dayin1[1].split('/');
                                    day1 = dayin1[2]+"-"+dayin1[1]+"-"+dayin1[0]+" "+timein1
                                    day1 = new Date(day1);
                                    var day2= result.result[i].AcceptOut;
                                    let dayin2 = day2.split(' ')
                                    var timein2 = dayin2[0];
                                    dayin2 = dayin2[1].split('/');
                                    day2 = dayin2[2]+"-"+dayin2[1]+"-"+dayin2[0]+" "+timein2;
                                    day2 = new Date(day2);
                                    var diff = Math.abs(day1-day2);

                                    var day3= result.result[i].TimeStampIn;
                                    let dayin3 = day3.split(' ')
                                    var timein3 = dayin3[0];
                                    dayin3 = dayin3[1].split('/');
                                    day3 = dayin3[2]+"-"+dayin3[1]+"-"+dayin3[0]+" "+timein3
                                    day3 = new Date(day3);
                                    var day4= result.result[i].TimeStampOut;
                                    let dayin4 = day4.split(' ')
                                    var timein4 = dayin4[0];
                                    dayin4 = dayin4[1].split('/');
                                    day4 = dayin4[2]+"-"+dayin4[1]+"-"+dayin4[0]+" "+timein4;
                                    day4 = new Date(day4);
                                    var diff2 = Math.abs(day3-day4);

                                    if(diff>diff2)
                                    celll14.innerHTML="<p style='color:red;font-family:Tahoma;font-size:13px'>"+result.result[i].AcceptIn+"</p>";
                                    else
                                    celll14.innerHTML="<p style='color:green;font-family:Tahoma;font-size:13px'>"+result.result[i].AcceptIn+"</p>";
                                }
                                else
                                celll14.innerHTML="<button id='btnAcceptin' class='btn btn-primary' type='button' onclick='var result="+'"'+result.result[i].IDFile+'"'+";Acceptin(result);'>Accept</button>";
                            }
                        }
                    }
                }
            },
            error:function (error){

            }
        })
    }
    function Searchfile(result){
        $.ajax({
            url: 'searchbaove1.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {

                if(result.result.length!=0) {
                    var table = document.getElementById("tbdata")
                    var stt = 0;

                    for (var i = 0; i < result.result.length; i++) {
                        var file = "<a style='font-size: 14px;font-family: Tahoma;line-height: 20px' href='http://113.161.6.179:8089/RD/F0020.php?id="+result.result[i].IDFile+"' target='_blank'>"+result.result[i].IDFile+"</a>";
                        var row = table.insertRow(stt);
                        stt++;
                        var celll1 = row.insertCell(0);
                        var celll2 = row.insertCell(1);
                        var celll3 = row.insertCell(2);
                        var celll4 = row.insertCell(3);
                        var celll5 = row.insertCell(4);
                        var celll6 = row.insertCell(5);
                        var celll7 = row.insertCell(6);
                        var celll8 = row.insertCell(7);
                        var celll9 = row.insertCell(8);
                        var celll10 = row.insertCell(9);
                        var celll11 = row.insertCell(10);
                        var celll12 = row.insertCell(11);
                        var celll13 = row.insertCell(12);
                        var celll14 = row.insertCell(13);
                        celll1.innerHTML = stt;
                        celll2.innerHTML = file;
                        celll13.innerHTML = result.result[i].NameIn;
                        celll4.innerHTML = result.result[i].Donvi;
                        celll3.innerHTML = result.result[i].NameIn;
                        celll5.innerHTML = result.result[i].TimeStampOut;
                        celll6.innerHTML = result.result[i].TimeStampIn;
                        celll7.innerHTML = result.result[i].Reason;
                        celll8.innerHTML = result.result[i].LicensePlates;
                        celll9.innerHTML = result.result[i].Bring;
                        celll10.innerHTML = result.result[i].FullName;
                        celll11.innerHTML = result.result[i].NameDept;
                        celll12.innerHTML = result.result[i].Note;
                        if (result.result[i].AcceptOut!==null)
                            celll13.innerHTML=result.result[i].AcceptOut;
                        else
                        celll13.innerHTML="<button class='btn btn-primary' type='button' onclick='var result="+'"'+result.result[i].IDFile+'"'+";Acceptout(result);'>Accept</button>";
                        if (result.result[i].AcceptOut!==null){
                            if (result.result[i].TimeStampIn !== "00:00:00 00/00/0000"){
                                if (result.result[i].AcceptIn!==null){
                                    var day1= result.result[i].AcceptIn;
                                    let dayin1 = day1.split(' ')
                                    var timein1 = dayin1[0];
                                    dayin1 = dayin1[1].split('/');
                                    day1 = dayin1[2]+"-"+dayin1[1]+"-"+dayin1[0]+" "+timein1
                                    day1 = new Date(day1);
                                    var day2= result.result[i].AcceptOut;
                                    let dayin2 = day2.split(' ')
                                    var timein2 = dayin2[0];
                                    dayin2 = dayin2[1].split('/');
                                    day2 = dayin2[2]+"-"+dayin2[1]+"-"+dayin2[0]+" "+timein2;
                                    day2 = new Date(day2);
                                    var diff = Math.abs(day1-day2);

                                    var day3= result.result[i].TimeStampIn;
                                    let dayin3 = day3.split(' ')
                                    var timein3 = dayin3[0];
                                    dayin3 = dayin3[1].split('/');
                                    day3 = dayin3[2]+"-"+dayin3[1]+"-"+dayin3[0]+" "+timein3
                                    day3 = new Date(day3);
                                    var day4= result.result[i].TimeStampOut;
                                    let dayin4 = day4.split(' ')
                                    var timein4 = dayin4[0];
                                    dayin4 = dayin4[1].split('/');
                                    day4 = dayin4[2]+"-"+dayin4[1]+"-"+dayin4[0]+" "+timein4;
                                    day4 = new Date(day4);
                                    var diff2 = Math.abs(day3-day4);

                                    if(diff>diff2)
                                    celll14.innerHTML="<p style='color:red;font-family:Tahoma;font-size:13px'>"+result.result[i].AcceptIn+"</p>";
                                    else
                                    celll14.innerHTML="<p style='color:green;font-family:Tahoma;font-size:13px'>"+result.result[i].AcceptIn+"</p>";
                                }
                                else
                                celll14.innerHTML="<button id='btnAcceptin' class='btn btn-primary' type='button' onclick='var result="+'"'+result.result[i].IDFile+'"'+";Acceptin(result);'>Accept</button>";
                            }
                        }
                    }
                }
                else {
                    if(result.Value!="") {
                        swal.fire('Thông báo', 'Mã phiếu không tồn tại. Vui lòng kiểm tra lại', 'error').then((resu) => {
                            var page = "<?php echo $_GET['page']?>";
                            LoadFile(page);
                        });
                    }
                }
            },
            error:function (error){

            }
        })
    }

    function btnAcceptoutClick(){
        var result = $(this).closest('tr');

        swal.fire('Thông báo', 'Xác nhận thành công', 'success');
    }

    function Acceptout(result){
        $.ajax({
            url: 'acceptout1.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {

                swal.fire('Thông báo', 'Xác nhận thành công', 'success').then((result2)=>{
                    var page = "<?php echo $_GET['page']?>";
                    $("#tbdata").empty();
                    LoadFile(page);
                });
                
            },
            error:function (error){

            }
        })
    }

    function Acceptin(result){
        $.ajax({
            url: 'acceptin1.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
            swal.fire('Thông báo', 'Xác nhận thành công', 'success').then((result2)=>{
                    var page = "<?php echo $_GET['page']?>";
                    $("#tbdata").empty();
                    LoadFile(page);
                });
                
            },
            error:function (error){

            }
        })
    }
</script>
