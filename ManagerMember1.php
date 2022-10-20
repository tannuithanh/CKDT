<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>THACO AUTO</title>
    <?php include ('Library/librarycss.php') ?>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;min-width: 700px;display: flex;justify-content: center">
        <div class="card-header" style="width: 100%;background: white">
            <div class="form-group">
                <div style="display: flex;min-width: 700px">
                    <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px;width: 50%">Quản lý nhân sự</h6>
                    <div class="form-group" style="width: 50%;align-items: center;float: right">
                        <div id="mf-menu-sl" style="position: absolute;right: 0px;margin-right: 20px;display: flex;align-items: center">
                            <button class="btn btn-success" type="button" onclick="document.getElementById('ppNewMember').style.display='block'">Thêm nhân sự</button>
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
                            <th style="background: #00529c;color: white;text-align: center">Họ và tên</th>
                            <th style="background: #00529c;color: white;text-align: center">Mã số nhân viên</th>
                            <th style="background: #00529c;color: white;text-align: center">Bộ phận / Xưởng</th>
                            <th style="background: #00529c;color: white;text-align: center">Chức vụ</th>
                            <th style="background: #00529c;color: white;text-align: center">Địa chỉ mail</th>
                            <th style="background: #00529c;color: white;text-align: center;width: 100px">Chức năng</th>
                        </tr>
                        </thead>
                        <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="ppEdit" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
        <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:600px;height: 300px">
            <div class="table-responsive" style="float: left;background: white;" >
                <div class="navbar navbar-dark bg-dark">
                    <h5 class="navbar-brand">Thêm Người dùng mới</h5>
                    <button type="button" class="close" aria-label="Close" onclick="document.getElementById('ppEdit').style.display='none'">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div>
                    <table style="background: white;width: 100%;font-family: Tahoma;font-size: 14px" class="table align-items-center table-flush">
                        <tr>
                            <td style="width: 200px">Mã số nhân viên: </td>
                            <td><input name="txtidmember" style="width: 100%" id="txtidmember" readonly></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Họ và tên: </td>
                            <td><input name="txtfullname" style="width: 100%" id="txtfullname"></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Bộ phận: </td>
                            <td><select class="form-select" style="height: 30px;width: 200px;font-size: 14px;font-family: Tahoma" name="sldept" id="sldept"></select></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Địa chỉ Mail: </td>
                            <td><input name="txtMail" style="width: 100%" id="txtMail"></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Mật khẩu: </td>
                            <td><input id="txtpass" name="txtpass" style="width: 300px" type="password" placeholder="Nhập mật khẩu" ></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Chức vụ: </td>
                            <td><select class="form-select" style="height: 30px;width: 200px;font-size: 14px;font-family: Tahoma" name="slposition" id="slposition"></select></td>
                        </tr>
                    </table>
                </div>
                <div style="background: white;text-align: center">
                    <button style="width: 150px;margin-bottom: 10px" type="button" name="btnSuccess" onclick="EditMember()" class="btn btn-primary">Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>

    <div id="ppNewMember" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
        <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:600px;height: 300px">
            <div class="table-responsive" style="float: left;background: white;" >
                <div class="navbar navbar-dark bg-dark">
                    <h5 class="navbar-brand">Thêm Người dùng mới</h5>
                    <button type="button" class="close" aria-label="Close" onclick="document.getElementById('ppNewMember').style.display='none'">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div>
                    <table style="background: white;width: 100%;font-family: Tahoma;font-size: 14px" class="table align-items-center table-flush">
                        <tr>
                            <td style="width: 200px">Mã số nhân viên: </td>
                            <td><input name="txtidmember1" style="width: 100%" id="txtidmember1" placeholder="Nhập mã số nhân viên"></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Họ và tên: </td>
                            <td><input name="txtfullname1" style="width: 100%" id="txtfullname1" placeholder="Nhập họ tên nhân viên"></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Bộ phận: </td>
                            <td><select class="form-select" style="height: 30px;width: 200px;font-size: 14px;font-family: Tahoma" name="sldept1" id="sldept1"></select></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Địa chỉ Mail: </td>
                            <td><input name="txtMail1" style="width: 100%" id="txtMail1" placeholder="Nhập địa chỉ mail Thaco (Nếu có)"></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Mật khẩu: </td>
                            <td><input id="txtpass1" name="txtpass1" style="width: 300px" type="password" placeholder="Nhập mật khẩu" ></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Chức vụ: </td>
                            <td><select class="form-select" style="height: 30px;width: 200px;font-size: 14px;font-family: Tahoma" name="slposition1" id="slposition1"></select></td>
                        </tr>
                        <tr>
                            <td style="width: 200px">Tải file excel: </td>
                            <td style="display:flex;">
                                <div class="input-group select_file form-inline my-2 my-lg-0 mr-sm-2" >
                                    <div class="custom-fileform-control mr-sm-2" style="font-family: Tahoma;font-size: 15px;margin-left: 10px;margin-right: 10px">
                                        <input type="file" accept=".xls,.xlsx,.csv" class="custom-file-input" id="inputGroupFile01" name="inputGroupFile01">
                                        <label class="custom-file-label" id="upfile" for="inputGroupFile01">Chọn tập tin</label>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="button" onclick="ReadExcel();">Tải</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="background: white;text-align: center">
                    <button style="width: 150px;margin-bottom: 10px" type="button" name="btnSuccess" class="btn btn-primary" onclick="NewMember();">Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include('Library/navbar.php') ?>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
</body>
<script type="text/javascript">
    $(document).ready(function (){
        $('#inputGroupFile01').change(function() {
            var a = $('#inputGroupFile01').prop('files')[0];
            $('#upfile').text(a.name);
        });
        LoadData();
        LoadPosition("AB");
        LoadDept("AB");
        LoadPosition1("AB");
        LoadDept1("AB");
    });
    function NewMember(){
        var idmember = document.getElementById('txtidmember1').value;
        var fullname = document.getElementById('txtfullname1').value;
        var dept = $('#sldept1').val();
        var mail = document.getElementById('txtMail1').value;
        var pass = document.getElementById('txtpass1').value;
        var position = $('#slposition1').val();
        var result = {idmember,fullname,dept,mail,pass,position};
        console.log(result);
        SaveNew(result);
    }

    function SaveNew(result){
        $.ajax({
            url: 'SaveNew.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if(result.result=="OK") {
                    swal.fire('Thông báo', 'Cập nhật thành công', 'success').then((result) => {
                        LoadData();
                        document.getElementById('ppNewMember').style.display = 'none';
                        LoadData();
                    });
                }
                else {
                    swal.fire('Thông báo', 'Lỗi cập nhật dữ liệu vui lòng kiểm tra lại', 'error');
                    console.log(result.result)
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Lỗi cập nhật dữ liệu vui lòng kiểm tra lại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function LoadData(){
        $('#tbdata').empty();
        var result = "<?php echo $iddept?>";
        GetListMember(result);
    }
    function GetListMember(result){
        $.ajax({
            url: 'getmember.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                var table = document.getElementById("tbdata")
                var stt=0;
                for(var i=0;i<result.result.length;i++)
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
                    cell1.innerHTML = stt;
                    cell2.innerHTML = result.result[i].FullName;
                    cell3.innerHTML = result.result[i].IDMember;
                    cell4.innerHTML = result.result[i].NameDept;
                    cell5.innerHTML = result.result[i].NamePosition;
                    cell6.innerHTML = result.result[i].Email;
                    cell7.innerHTML = result.result[i].Function;
                }
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }
    function DeleteMember(result){
        Swal.fire({
            title: 'Thông báo',
            text: "Bạn có muốn xóa nhân sự "+result['fullname']+"!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result2) => {
            if (result2.isConfirmed) {
                $.ajax({
                    url: 'deletemember.php',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data:
                        {
                            result:result
                        },
                    success:function (result)
                    {
                        if(result.result==="OK") {
                            Swal.fire(
                                'Thành công!',
                                'Bạn đã xóa người dùng.',
                                'success'
                            );
                            LoadData();
                        }
                    },
                    error:function (error){
                        console.log(error.responseText);
                        Swal.fire(
                            'Thất bại!',
                            'Xóa người dùng thất bại.',
                            'error'
                        )
                    }
                })
            }
        })
    }
    function ShowEdit(idmember){
        document.getElementById('ppEdit').style.display='block';
        document.getElementById('txtidmember').value = idmember;
        CheckMember(idmember);
    }

    function CheckMember(result){
        $.ajax({
            url: 'CheckMember.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                    console.log(result);
                } else {
                    document.getElementById('txtfullname').value = result.result[0]['FullName'];
                    document.getElementById('txtpass').value = result.result[0]['Pass'];
                    document.getElementById('txtMail').value = result.result[0]['MailAddress'];
                    $("#slposition").val(result.result[0]['IDPosition']).change();
                    $("#sldept").val(result.result[0]['IDDept']).change();
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function LoadPosition(result){
        $.ajax({
            url: 'GetPosition.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                } else {
                    $.each(result.result, function (i, item) {
                        $('#slposition').append($('<option>', {
                            value: item.IDPosition,
                            text : item.NamePosition
                        }));
                    });
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function LoadPosition1(result){
        $.ajax({
            url: 'GetPosition.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                } else {
                    $.each(result.result, function (i, item) {
                        $('#slposition1').append($('<option>', {
                            value: item.IDPosition,
                            text : item.NamePosition
                        }));
                    });
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function LoadDept(result){
        $.ajax({
            url: 'GetDept.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                    console.log(result);
                } else {
                    $.each(result.result, function (i, item) {
                        $('#sldept').append($('<option>', {
                            value: item.IDDept,
                            text : item.NameDept
                        }));
                    });
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }
    function LoadDept1(result){
        $.ajax({
            url: 'GetDept.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                    console.log(result);
                } else {
                    $.each(result.result, function (i, item) {
                        $('#sldept1').append($('<option>', {
                            value: item.IDDept,
                            text : item.NameDept
                        }));
                    });
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function EditMember(){
        var idmember = document.getElementById('txtidmember').value;
        var fullname = document.getElementById('txtfullname').value;
        var iddept = $("#sldept").val();
        var idposition = $("#slposition").val();
        var mail = document.getElementById('txtMail').value;
        var pass = document.getElementById('txtpass').value;
        var result = {idmember,fullname,iddept,idposition,mail,pass};
        SaveEdit(result);
    }

    function SaveEdit(result){
        $.ajax({
            url: 'SaveEdit.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                if(result.result=="OK") {
                    swal.fire('Thông báo', 'Cập nhật thành công', 'success').then((result) => {
                        LoadData();
                        document.getElementById('ppEdit').style.display = 'none';
                    });
                }
                else {
                    swal.fire('Thông báo', 'Lỗi cập nhật dữ liệu vui lòng kiểm tra lại', 'error');
                    console.log(result.result)
                }
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function ReadExcel(){
        var iddept = <?php echo "'".$iddept."'"?>;
        var form_data = new FormData();
        var file_data = $('#inputGroupFile01').prop('files')[0];
        form_data.append('inputGroupFile01', file_data);
        form_data.append('dept',iddept);
        console.log(form_data);
        $.ajax({
            url:'updatefile.php',
            method:'POST',
            data:form_data,
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
                console.log(data);
                document.getElementById('ppNewMember').style.display='none';
                LoadData();
            },
            error:function(error){
                console.log(error.responseText);
            }
        });
    }
</script>