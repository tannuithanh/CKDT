<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
if(!isset($username))
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
<body data-spy="scroll" data-offset="50">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post">
    <nav class="navbar navbar-light bg-light" style="margin-top: 80px">
        <div>
            <span class="navbar-brand h7">Chọn nhóm quyền:</span>
            <select id="slGroup" class="form-select navbar-toggler" aria-label="Default select example" onchange="LoadMenu();">
                <option selected>Chọn nhóm quyền</option>
            </select>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="#">
            <img src="images/LOGO%20THACO%20AUTO.png" height="50" alt="Banner"/>
        </a>
        <div id="main-title" class="col-2 ml-0 mt-1">
            <div style="clear: left;color: white"><h7 >R&D Ô TÔ</h7></div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav" id="dropmenubar">
        </div>
        <div style="position: absolute;right: 10px;display: flex">
            <div id="main-user" class="col-1.5"  style="margin-top: 14px;color: white">
                <p style="font-family: Tahoma;color: white">Hi! Username</p>
            </div>
        </div>
    </nav>
    <div class="container d-flex mt-2">
        <div class="col-3 d-flex" style="text-align: center">
            <h6 class="mr-2" style="line-height: 30px">Chọn menu:</h6>
            <select id="slmenu" class="form-select" aria-label="Default select example" onchange="ChangeMenu();" style="height: 30px">
                <option selected>Chọn chức năng</option>
            </select>
        </div>
        <div id="listfunction" class="col-6">
        </div>
    </div>
    <hr style="border: 1px solid red">
    <fieldset style="margin-top: 10px">
        <legend style="padding: 0px 5px 0px 10px;font-weight: bold ;font-family: Tahoma;font-size: 16px">Cài đặt phê duyệt</legend>
        <div class="input-group" style="align-items: center;width: 100%;height: 50px">
            <h6>Giấy ra cổng và Giấy xin phép</h6>
            <div style="width: 100%">
                <table class="table table-bordered align-items-center" style="width: 100%">
                    <thead>
                    <tr>
                        <th style="color: black;text-align: center">Chức danh gửi</th>
                        <th style="color: black;text-align: center">Chức danh kiểm tra</th>
                        <th style="color: black;text-align: center">Chức danh duyệt</th>
                        <th style="color: black;text-align: center">Chức năng</th>
                    </tr>
                    <tr>
                        <th style="color: black;text-align: center">
                            <select id="slpositionprc1" class="form-select" aria-label="Default select example" onchange="SelectPositionprc();" style="height: 30px;width: 100%">
                                <option selected>Chọn chức năng</option>
                            </select>
                        </th>
                        <th style="color: black;text-align: center">
                            <select id="slpositionprc2" class="form-select" aria-label="Default select example" style="height: 30px;width: 100%">
                                <option selected>Chọn chức năng</option>
                            </select>
                        </th>
                        <th style="color: black;text-align: center">
                            <select id="slpositionprc3" class="form-select" aria-label="Default select example" style="height: 30px;width: 100%">
                                <option selected>Chọn chức năng</option>
                            </select>
                        </th>
                        <th style="color: black;text-align: center">
                            <button class="btn btn-primary" type="button" onclick="AddNewPRC();" style="width: 100px;height: 40px">Save</button>
                        </th>
                    </tr>
                    </thead>
                </table>

                <table class="table table-bordered align-items-center mt-2" style="width: 100%">
                    <thead>
                    <tr>
                        <th style="color: black;text-align: center">Chức danh gửi</th>
                        <th style="color: black;text-align: center">Chức danh kiểm tra</th>
                        <th style="color: black;text-align: center">Chức danh duyệt</th>
                        <th style="color: black;text-align: center">Chức năng</th>
                    </tr>
                    </thead>
                    <tbody id="tbdataprc" style="font-family: Tahoma;font-size: 14px;background: white">
                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>
</form>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script type="text/javascript">
    $(document).ready(function (){
        LoadGroup("ABC");
        LoadPositon1("ABC");
        LoadPositon2("ABC");
        LoadPositon3("ABC");
    });

    function SelectPositionprc(){
        $('#tbdataprc').empty();
        var pos = document.getElementById('slpositionprc1').value;
        GetPositionprc(pos);
    }

    function AddNewPRC(){
        var id1 = document.getElementById('slpositionprc1').value;
        var id2 = document.getElementById('slpositionprc2').value;
        var id3 = document.getElementById('slpositionprc3').value;
        var result = {id1,id2,id3};
        SavePRC(result);
    }

    function SavePRC(result){
        $.ajax({
            url: 'saveapproveprc.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data:
                {
                    result:result
                },
            success:function (result)
            {
                console.log(result)
                if(result.result=="OK")
                    Swal.fire('Thêm mới thành công!', '', 'success').then((result3)=>{SelectPositionprc()});
                else if(result.result=="TRUNG")
                    Swal.fire('Mục đã tồn tại!', '', 'warning').then((result3)=>{SelectPositionprc()});
                else
                    Swal.fire('Lỗi khi thêm dữ liệu!', '', 'error').then((result3)=>{SelectPositionprc()});
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }

    function ShowEdit(result){
        $("#slpositionprc2").val(result.id2).change();
        $("#slpositionprc3").val(result.id3).change();
    }

    function Deleteprc(result){
        Swal.fire({
            title: 'Bạn có muốn xóa mục đã chọn?',
            showDenyButton: true,
            confirmButtonText: 'Có',
            denyButtonText: `Không`,
            icon: 'question'
        }).then((result2) => {
            if (result2.isConfirmed) {
                $.ajax({
                    url: 'deleteprc.php',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data:
                        {
                            result:result
                        },
                    success:function (result)
                    {
                        console.log(result)
                        Swal.fire('Xóa thành công!', '', 'success').then((result3)=>{SelectPositionprc()});
                    },
                    error:function (error){
                        console.log(error.responseText);
                    }
                })
            }
        })
    }

    function GetPositionprc(result){
        $.ajax({
            url: 'GetPositionprc.php',
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
                var table = document.getElementById("tbdataprc")
                var stt=0;
                for(var i=0;i<result.result.length;i++)
                {
                    var row = table.insertRow(stt);
                    stt++;
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    cell1.innerHTML = result.result[i].Name1;
                    cell2.innerHTML = result.result[i].Name2;
                    cell3.innerHTML = result.result[i].Name3;
                    cell4.innerHTML = result.result[i].Function;
                }
            },
            error:function (error){
                console.log(error.responseText);
            }
        })
    }
    function LoadGroup(result){
        $.ajax({
            url: 'GetGroup.php',
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
                        $('#slGroup').append($('<option>', {
                            value: item.IDGroup,
                            text : item.NameGroup
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

    function LoadMenu(){
        var idgroup = $('#slGroup').val();
        AddMenu(idgroup);
        $('#slmenu').empty();
        LoadList(idgroup);
    }

    function AddMenu(result){
        $.ajax({
            url: 'GetMenu.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                document.getElementById('dropmenubar').innerHTML=result.result;
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function LoadList(result){
        $.ajax({
            url: 'Getlistmenu1.php',
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
                        $('#slmenu').append($('<option>', {
                            value: item.IDFunction,
                            text : item.NameFunction
                        }));
                    });
                }
                ChangeMenu();
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function ChangeMenu(){
        var group = $('#slGroup').val();
        var funtion = $('#slmenu').val();
        var result = {funtion,group};
        Parent(result);
    }

    function Parent(result){
        $.ajax({
            url: 'Getlistmenu2.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                console.log(result.result);
                var div = "";
                $.each(result.result, function (i, item) {
                    var check ="";
                    if(item.checked==true)
                        check="checked";
                    div+='<div class="custom-control custom-switch"><input type="checkbox" onchange="GetStatus('+"'"+item.IDFunction+"'"+');" class="custom-control-input" id="'+item.IDFunction+'" '+check+'><label class="custom-control-label" for="'+item.IDFunction+'">'+item.NameFunction+'</label></div>';
                });
                document.getElementById('listfunction').innerHTML=div;
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }
    function GetStatus(idfunction){
        var status = $('#'+idfunction)[0].checked;
        if(status == true){
            Swal.fire({
                title: 'Bạn có muốn bật tính năng?',
                showDenyButton: true,
                confirmButtonText: 'Có',
                denyButtonText: `Không`,
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    var group = $('#slGroup').val();
                    var funtion = $('#slmenu').val();
                    var result = {group, funtion, idfunction, status};
                    console.log(result);
                    Savechange(result);
                } else if (result.isDenied) {
                    if(status==true)
                        $('#'+idfunction)[0].checked=false;
                    else $('#'+idfunction)[0].checked = true;
                }
            })
        }
        else {
            Swal.fire({
                title: 'Bạn có muốn tắt tính năng?',
                showDenyButton: true,
                confirmButtonText: 'Có',
                denyButtonText: `Không`,
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    var group = $('#slGroup').val();
                    var funtion = $('#slmenu').val();
                    var result = {group, funtion, idfunction, status};
                    console.log(result);
                    Savechange(result);
                } else if (result.isDenied) {
                    if(status==true)
                        $('#'+idfunction)[0].checked=false;
                    else $('#'+idfunction)[0].checked = true;
                }
            })
        }
    }

    function Savechange(result){
        $.ajax({
            url: 'savedec.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                console.log(result);
                Swal.fire('Đã lưu!', '', 'success')
            },
            error: function (error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }


    function LoadPositon1(result){
        $.ajax({
            url: 'Getposition.php',
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
                        $('#slpositionprc1').append($('<option>', {
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
    function LoadPositon2(result){
        $.ajax({
            url: 'Getposition.php',
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
                       $('#slpositionprc2').append($('<option>', {
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
    function LoadPositon3(result){
        $.ajax({
            url: 'Getposition.php',
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
                        $('#slpositionprc3').append($('<option>', {
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
</script>
