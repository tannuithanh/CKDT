<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
$con = "";
include 'Library/Connect_DB.php';
$check = array();
$approve = array();
$sql = "SELECT DISTINCT member.IDMember,member.FullName, dept.NameDept FROM member,position,dept,managermember,approveptc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='" . $iddept . "' AND position.IDPosition in (Select approveptc.Position2 FROM position,approveptc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptc.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $check1[] = $row;
}
$sql = "SELECT DISTINCT member.IDMember,member.FullName, dept.NameDept FROM member,position,dept,managermember,approveptc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptc.Position3 FROM position,approveptc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptc.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $check2[] = $row;
}
$sql = "SELECT DISTINCT member.IDMember,member.FullName, dept.NameDept FROM member,position,dept,managermember,approveptc WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptc.Position4 FROM position,approveptc,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptc.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $approve[] = $row;
}
$sql = "SELECT * FROM eating ORDER BY IDEating ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $data[] = $row;
}
$sql = "SELECT * FROM locationcar ORDER BY IDLocation ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $data2[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>THACO AUTO</title>
        <?php include 'Library/librarycss.php'?>
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG">
        <?php include 'Library/menu.php'?>
        <form autocomplete="off" method="post" enctype="multipart/form-data">
            <div class="align-items-center" style="margin-top: 5px;width: 100%;display: flex;justify-content: center">
                <div class="card-header" id="divall" style="width: 100%">
                    <div class="form-group">
                        <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Phiếu
                            báo tăng ca</h6>
                        <hr>
                    </div>
                    <div id="divconten" style="float: left;width: 100%">
                        <fieldset style="background: #fffcd5;margin-top: 10px">
                            <div class="d-flex justify-content-center">
                                <button name="upload" type="button" id='Addmember' class="btn btn-success"
                                    style="width: 200px;margin-bottom: 5px;margin-left: 5px">Thêm nhân viên tăng
                                    ca</button>
                            </div>
                        </fieldset>
                        <fieldset style="background: #fffcd5;margin-top: 10px">
                            <legend
                                style="padding: 0px 5px 0px 10px;font-weight: bold ;font-family: Tahoma;font-size: 16px">
                                DANH SÁCH NHÂN VIÊN TĂNG CA:</legend>
                            <div id="excel_area">
                                <table id="tableshow"
                                    class="table table-bordered align-items-center table-flush table-hover"
                                    style="background: white;color: black; text-align: center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="color: red;text-align: center">KÍCH CHỌN</th>
                                            <th rowspan="2" style="color: black;text-align: center">STT</th>
                                            <th rowspan="2" style="color: black;text-align: center">MSNV</th>
                                            <th rowspan="2" style="color: black;text-align: center">HỌ VÀ TÊN</th>
                                            <th rowspan="2" style="color: black;text-align: center">CHỨC VỤ</th>
                                            <th rowspan="2" style="color: black;text-align: center">TÊN PHÒNG</th>
                                            <th colspan="5" style="color: black;text-align: center">GIỜ TĂNG CA</th>
                                            <th rowspan="2" style="color: black;text-align: center">ĐIỂM ĐƯA ĐÓN</th>
                                            <th rowspan="2" style="color: black;text-align: center">SUẤT ĂN</th>
                                            <th rowspan="2" style="color: black;text-align: center">NỘI DUNG</th>
                                            <th rowspan="2" style="color: black;text-align: center">MỤC TIÊU HOÀN THÀNH</th>
                                        </tr>
                                        <tr>
                                            <th style="color: black;text-align: center">18h30</th>
                                            <th style="color: black;text-align: center">20h45</th>
                                            <th style="color: black;text-align: center">22h15</th>
                                            <th style="color: black;text-align: center">23h15</th>
                                            <th style="color: black;text-align: center">Chủ nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white; text-align: center">
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <p style="color: blue; font-size: 14px;font-family: Tahoma;font-weight: bold">*GHI CHÚ:
                                </p>
                                <label id="nsphutrach"></label>
                                <label id="chucvuphutrach"></label>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="table-responsive result">
                                        <table class="table table-bordered table-hover "
                                            style="background: white;color: black;font-family: Tahoma;font-size: 14px; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="2" style="color: black;text-align: center">
                                                        TỔNG SỐ LƯỢNG ĐĂNG KÝ TĂNG CA</th>
                                                </tr>
                                            </thead>
                                            <tbody id="time_over" class="body time_over">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive result">
                                        <table class="table table-bordered table-hover "
                                            style="background: white;color: black;font-family: Tahoma;font-size: 14px; text-align: center">
                                            <thead>
                                                <tr> 
                                                    <th colspan="6" style="color: black;text-align: center">TỔNG SỐ
                                                        LƯỢNG ĐĂNG KÝ XE ĐƯA ĐÓN</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Giờ tăng ca:</th>
                                                    <th style="color: black;text-align: center">18h30</th>
                                                    <th style="color: black;text-align: center">20h45</th>
                                                    <th style="color: black;text-align: center">22h15</th>
                                                    <th style="color: black;text-align: center">23h15</th>
                                                    <th style="color: black;text-align: center">Chủ nhật</th>
                                                </tr>
                                            </thead>
                                            <tbody id="location" class="body position">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="table-responsive result">
                                        <table class="table table-bordered table-hover "
                                            style="background: white;color: black;font-family: Tahoma;font-size: 14px; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="2" style="color: black;text-align: center">
                                                        TỔNG SỐ LƯỢNG ĐĂNG KÝ CƠM</th>
                                                </tr>
                                            </thead>
                                            <tbody id="food" class="body food">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                <!--Ngày tạo phiếu-->
                            <div style="display: flex;margin-left: 950px;margin-right: 20px;margin-top: 10px">
                            <h6 style="font-size: 16px;margin-left: 10px;margin-right: 10px">Ngày tăng ca: </h6>
                            <input id="ngaytao" type="datetime-local" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php
                                                                                                                                                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                    echo date('Y-m-d\TH:i');
                                                                                                                                                                    ?>">
                             </div>
                                <!--Ngày tạo phiếu-->
                        </fieldset>
                        <fieldset style="background: #fffcd5;margin-top: 10px">
                            <legend
                                style="padding: 0px 5px 0px 10px;font-weight: bold ;font-family: Tahoma;font-size: 16px">
                                Phê Duyệt:</legend>
                            <div id="main-pd" class="input-group" style="align-items: center;width: 100%;height: 50px">
                                <div id="main-pd-3" class="input-group" style="align-items: center">
                                    <h6 style="font-size: 16px;font-family: Tahoma;width: 130px;font-weight: bold">Người
                                        lập</h6>
                                    <select id="check1" class="form-control"
                                        style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                        <?php foreach ($check1 as $v) {?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div id="main-pd-3" class="input-group" style="align-items: center">
                                    <h6 style="font-size: 16px;font-family: Tahoma;width: 130px;font-weight: bold">Kiểm
                                        tra </h6>
                                    <select id="check2" class="form-control"
                                        style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                        <?php foreach ($check2 as $v) {?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div id="main-pd-3" class="input-group" style="align-items: center">
                                    <h6 style="font-size: 16px;font-family: Tahoma;width: 130px;font-weight: bold">Phê
                                        duyệt </h6>
                                    <select id="approve" class="form-control"
                                        style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                        <?php foreach ($approve as $v) {?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div id="errorlog" class="input-group"
                            style="display: none;align-items: center;align-content: center;text-align: center;width: 100%;margin-top: 10px">
                            <label style="font-size: 14px;font-family: Tahoma;color: #c80000">Vui lòng chọn chức năng thêm nhân viên tăng ca!</label>
                        </div>
                        <div class="input-group"
                            style="align-items: center;align-content: center;text-align: center;width: 100%;margin-top: 10px">
                            <button type="button" onclick=" Showreview();/*Create();*/" class="btn btn-primary"
                                style="margin: auto;min-width: 100px">Tạo phiếu</button>
                        </div>
                    </div>
                </div>
                <div id="manualMode" class="z-index-3 d-none pos-fixed top-0 left-0 w-100 h-100 overflow-auto"
                    style="justify-content: center;display: grid;background-color:rgba(0,0,0,0.4);">
                    <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:850px">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="$('#manualMode').addClass('d-none')">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="tableshow"
                                class="table table-bordered align-items-center table-flush table-hover"
                                style="background: white;color: black">
                                <thead class="thead-light">
                                <h5 class="modal-title" id="exampleModalLabel" >Danh sách nhân viên</h5>
                                    <tr>
                                        <th style="background: #00529c;color: white;text-align: center"><input
                                                type="checkbox" id="checkall"></input></th>
                                        <th style="background: #00529c;color: white;text-align: center">STT</th>
                                        <th style="background: #00529c;color: white;text-align: center">Họ và tên</th>
                                        <th style="background: #00529c;color: white;text-align: center">Mã số nhân viên
                                        </th>
                                        <th style="background: #00529c;color: white;text-align: center">Chức vụ</th>
                                    </tr>
                                </thead>
                                <tbody id="tbDataManual" style="font-family: Tahoma;font-size: 14px;background: white">
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="$('#manualMode').addClass('d-none')">Thoát</button>
                            <button type="button" class="btn btn-primary" id="btnsave">Lưu</button>
                        </div>
                    </div>
                </div>
                <div id="review"
                    style="z-index:3;display:none;padding-top:70px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
                    <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:95%">
                        <div style="display: flex">
                            <div style="width: 200px">
                                <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                                <img src="images/RD3.png" style="width: 200px">
                            </div>
                            <div style="width: 100%">
                                <div style="width: 100%;display: block;margin-top: 10px">
                                    <h6
                                        style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px;font-weight: bold">
                                        DANH SÁCH ĐĂNG KÝ TĂNG CA</h6>
                                    <!--Ngày tạo phiếu-->
                                    <h6 id="lblngaytao" style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px"></h6>
                                    <!--Ngày tạo phiếu-->
                                    <h6
                                        style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">
                                        ------------------***------------------</h6>
                                </div>
                            </div>
                        </div>
                        <div style="margin-left: 20px;margin-right: 20px">
                            <div id="excel_area">
                                <table class="table table-bordered align-items-center table-flush table-hover"
                                    style="background: white;color: black">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="color: black;text-align: center">STT</th>
                                            <th rowspan="2" style="color: black;text-align: center">MSNV</th>
                                            <th rowspan="2" style="color: black;text-align: center">HỌ VÀ TÊN</th>
                                            <th rowspan="2" style="color: black;text-align: center">CHỨC VỤ</th>
                                            <th rowspan="2" style="color: black;text-align: center">TÊN PHÒNG</th>
                                            <th colspan="5" style="color: black;text-align: center">GIỜ TĂNG CA</th>
                                            <th rowspan="2" style="color: black;text-align: center">ĐIỂM ĐƯA ĐÓN</th>
                                            <th rowspan="2" style="color: black;text-align: center">SUẤT ĂN</th>
                                            <th rowspan="2" style="color: black;text-align: center">NỘI DUNG</th>
                                            <th rowspan="2" style="color: black;text-align: center">MỤC TIÊU HOÀN THÀNH</th>
                                        </tr>
                                        <tr>
                                            <th style="color: black;text-align: center">18h30</th>
                                            <th style="color: black;text-align: center">20h45</th>
                                            <th style="color: black;text-align: center">22h15</th>
                                            <th style="color: black;text-align: center">23h15</th>
                                            <th style="color: black;text-align: center">Chủ nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbdata2" style="font-family: Tahoma;font-size: 14px;background: white;text-align: center">
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <p style="color: blue; font-size: 14px;font-family: Tahoma;font-weight: bold">*GHI CHÚ:
                                </p>
                                <Label id="sdtphutrach2"></Label>
                                <label id="nsphutrach2"></label>
                                <label id="chucvuphutrach2"></label>

                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="table-responsive result">
                                        <table class="table table-bordered table-hover "
                                            style="background: white;color: black;font-family: Tahoma;font-size: 14px;font-size: 14px; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="2" style="color: black;text-align: center">
                                                        TỔNG SỐ LƯỢNG ĐĂNG KÝ TĂNG CA</th>
                                                </tr>

                                            </thead>
                                            <tbody id="time_over2" class="body time_over">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive result">
                                        <table class="table table-bordered table-hover "
                                            style="background: white;color: black;font-family: Tahoma;font-size: 14px; font-size: 14px; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" style="color: black;text-align: center">
                                                    TỔNG SỐ LƯỢNG ĐĂNG KÝ XE ĐƯA ĐÓN</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Giờ tăng ca:</th>
                                                    <th style="color: black;text-align: center">18h30</th>
                                                    <th style="color: black;text-align: center">20h45</th>
                                                    <th style="color: black;text-align: center">22h15</th>
                                                    <th style="color: black;text-align: center">23h15</th>
                                                    <th style="color: black;text-align: center">Chủ nhật</th>
                                                </tr>
                                            </thead>
                                            <tbody id="location2" class="body position">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="table-responsive result">
                                        <table class="table table-bordered table-hover "
                                            style="background: white;color: black;font-family: Tahoma;font-size: 14px; font-size: 14px; text-align: center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="2" style="color: black;text-align: center">
                                                        TỔNG SỐ LƯỢNG ĐĂNG KÝ CƠM</th>
                                                </tr>
                                            </thead>
                                            <tbody id="food2" class="body food">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 30px">
                            <div class="col-4">
                                <label
                                    style="text-align: center;font-size: 15px;font-family: Tahoma; font-weight: bold">Phê
                                    duyệt</label>
                            </div>
                            <div class="col-4">
                                <label
                                    style="text-align: center;font-size: 15px;font-family: Tahoma; font-weight: bold">Kiểm
                                    tra</label>
                            </div>
                            <div class="col-4">
                                <label
                                    style="text-align: center;font-size: 15px;font-family: Tahoma; font-weight: bold">Người
                                    lập</label>
                            </div>
                        </div>
                        <div class="row" style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 60px">
                            <div class="col-4">
                                <label id="lblapprove"
                                    style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Phê
                                    duyệt</label>
                            </div>
                            <div class="col-4">
                                <label id="lblcheck2"
                                    style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Kiểm
                                    tra</label>
                            </div>
                            <div class="col-4">
                                <label id="lblcheck1"
                                    style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Người
                                    lập</label>
                            </div>
                        </div>
                        <div style="background: white;margin: auto;text-align: center">
                            <button style="width: 150px;margin-bottom: 10px" type="button" id="btnSuccess"
                                class="btn btn-primary" onclick="Create();">Hoàn thành</button>
                            <button style="width: 150px;margin-bottom: 10px"
                                onclick="document.getElementById('review').style.display='none'" type="button"
                                class="btn btn-danger">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>

</html>
<?php include 'Library/libraryscript.php'?>
<!-- <?php include 'Library/ShowNotification.php'?> -->
<!-- <?php include 'Library/HidenAlert.php'?> -->
<script>
$(document).ready(function() {
    $("#msnv").change(function() {
        var result = document.getElementById("msnv").value;
        console.log(result);
        ajax(result);
    });
    $('#inputGroupFile01').change(function() {
        var a = $('#inputGroupFile01').prop('files')[0];
        $('#upfile').text(a.name);
    });
});


$('#Addmember').on('click', () => {
    var data = "<?php echo $iddept ?>";
    $.ajax({
        url: 'getmember.php',
        type: 'post',
        dataType: 'json',
        cache: false,
        data: {
            result: data
        },
        success: function(result) {
            console.log(result.result)
            $('#tbDataManual').empty();
            $.each(result.result, (i, item) => {
                const td = '<tr><td class="text-center" class="text-center"><input id="' +
                    item.IDMember + '" type="checkbox" class="checkbox"></input></td>' +
                    '<td class="text-center">' + (i + 1) + '</td>' +
                    '<td>' + item.FullName + '</td>' +
                    '<td class="text-center">' + item.IDMember + '</td>' +
                    '<td>' + item.NamePosition + '</td>' +
                    '</tr>'
                $('#tbDataManual').append(td)
            })
        },
        error: function(error) {
            console.log(error)
        }
    })
    $('#manualMode').removeClass('d-none')
})

$('#checkall').on('change', () => {
    var checkall = $('#checkall')[0].checked
    if (checkall)
        $('.checkbox').attr('checked', 'checked')
    else $('.checkbox').removeAttr('checked', 'checked')
})


$('#btnsave').on('click', () => {
    var table = $('#tbDataManual').children()
    var data = []
    $.each(table, (i, item) => {
        if (($(item).children().find('input')[0].checked)) {
            var mem = []
            $.each($(item).children(), (i, item2) => {
                if (i > 0) {
                    mem.push($(item2)[0].innerText)
                }
            })
            data.push(mem)
        }
    })
    console.log(data)
    AddMember(data)
    $('#manualMode').addClass('d-none')
})

function ReadFile() {
    $('#tbdata').empty();
    $('#time_over').empty();
    var file_data = $('#inputGroupFile01').prop('files')[0];
    var form_data = new FormData();
    form_data.append('inputGroupFile01', file_data);
    $.ajax({
        url: 'upfile.php',
        method: 'POST',
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            $('#tbdata').append(data);
            CountValue();
        }
    });

}

function CountValue() {
    var
        total = [],
        time_18h30 = [],
        time_20h45 = [],
        time_22h15 = [],
        time_24h00 = [],
        time_ChuNhat = [],
        food = [],
        locationcar = [];
    $('#tbdata tr th:nth-child(1)').each(function() {
        total.push($(this).text());
    });
    $('#tbdata tr td:nth-child(7)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_18h30.push($(this).text());
    });
    $('#tbdata tr td:nth-child(8)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_20h45.push($(this).text());
    });
    $('#tbdata tr td:nth-child(9)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_22h15.push($(this).text());
    });
    $('#tbdata tr td:nth-child(10)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_24h00.push($(this).text());
    });
    $('#tbdata tr td:nth-child(11)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_ChuNhat.push($(this).text());
    });
    $('#tbdata tr td:nth-child(5)').each(function() {});
    var table = document.getElementById('tbdata');
    var total_ = table.rows.length;
    for (var i = 0; i < total_; i++) {
        var row = table.rows[i];
        var value = [];
        if (row.cells[6].firstChild.checked == true)
            value.push('18h30', row.cells[12].firstChild.value);
        if (row.cells[7].firstChild.checked == true)
            value.push('20h45', row.cells[12].firstChild.value);
        if (row.cells[8].firstChild.checked == true)
            value.push('22h15', row.cells[12].firstChild.value);
        if (row.cells[9].firstChild.checked == true)
            value.push('24h00', row.cells[12].firstChild.value);
        if (row.cells[10].firstChild.checked == true)
            value.push('ChuNhat', row.cells[12].firstChild.value);
        locationcar.push(value);
    }
    CountLocation(locationcar);
    console.log(locationcar);
    $('#tbdata tr td:nth-child(13)').each(function() {
        if ($(this)[0].firstChild.style.display != 'none') {
            food.push($(this)[0].firstChild.value);
        }
    });
    CountFood(food);

    var time_18h30_ = time_18h30.length;
    var time_20h45_ = time_20h45.length;
    var time_22h15_ = time_22h15.length;
    var time_24h00_ = time_24h00.length;
    var time_ChuNhat_ = time_ChuNhat.length;
    $('#tbdata').append("<tr><th colspan=" + 6 + ">TỔNG</th><td>" + time_18h30_ + "</td><td>" + time_20h45_ +
        "</td><td>" + time_22h15_ + "</td><td>" + time_24h00_ + "</td><td>" + time_ChuNhat_ + "</td><td></td><td></td><td></td><td></td></tr>");
    $('#time_over').append("" +
        "<tr>" +
        "<td>Đến 18h30</td>" +
        "<td>" + time_18h30_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Đến 20h45</td>" +
        "<td>" + time_20h45_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Đến 22h15</td>" +
        "<td>" + time_22h15_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Đến 23h15</td>" +
        "<td>" + time_24h00_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Chủ nhật</td>" +
        "<td>" + time_ChuNhat_ + "</td>" +
        "</tr>"
        );
        
}

function CountFood(result) {
    $('#food').empty();
    $.ajax({
        url: 'countfood.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {} else {
                $('#food').append(result.result);
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function CountLocation(result) {
    $('#location').empty();
    $.ajax({
        url: 'countlocation.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {} else {
                $('#location').append(result.result);
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function ReCount() {
    $('#tbdata tr:last').remove();
    $('#time_over').empty();
    var
        total = [],
        time_18h30 = [],
        time_20h45 = [],
        time_22h15 = [],
        time_24h00 = [],
        time_ChuNhat = [],
        food = [],
        locationcar = [],
        tamky = 0,
        tpqn = 0,
        qn = 0,
        cd = 0;
    $('#tbdata tr th:nth-child(2)').each(function() {

        total.push($(this).text());
    });
    $('#tbdata tr td:nth-child(7)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_18h30.push($(this).text());
    });
    $('#tbdata tr td:nth-child(8)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_20h45.push($(this).text());
    });
    $('#tbdata tr td:nth-child(9)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_22h15.push($(this).text());
    });
    $('#tbdata tr td:nth-child(10)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_24h00.push($(this).text());
    });
    $('#tbdata tr td:nth-child(11)').each(function() {
        if ($(this)[0].firstChild.checked == true) time_ChuNhat.push($(this).text());
    });
    var table = document.getElementById('tbdata');
    var total_ = table.rows.length;
    for (var i = 0; i < total_; i++) {
        var row = table.rows[i];
        var value = [];
        if (row.cells[6].firstChild.checked == true)
            value.push('18h30', row.cells[11].firstChild.value);
        if (row.cells[7].firstChild.checked == true)
            value.push('20h45', row.cells[11].firstChild.value);
        if (row.cells[8].firstChild.checked == true)
            value.push('22h15', row.cells[11].firstChild.value);
        if (row.cells[9].firstChild.checked == true)
            value.push('24h00', row.cells[11].firstChild.value);
        if (row.cells[10].firstChild.checked == true)
            value.push('ChuNhat', row.cells[11].firstChild.value);
        locationcar.push(value);
    }
    CountLocation(locationcar);
    $('#tbdata tr td:nth-child(13)').each(function() {
        if ($(this)[0].firstChild.style.display != 'none') {
            food.push($(this)[0].firstChild.value);
        }
    });
    CountFood(food);
    var time_18h30_ = time_18h30.length;
    var time_20h45_ = time_20h45.length;
    var time_22h15_ = time_22h15.length;
    var time_24h00_ = time_24h00.length;
    var time_ChuNhat_ = time_ChuNhat.length;
    $('#tbdata').append("<tr><th colspan=" + 6 + ">TỔNG</th><td>" + time_18h30_ + "</td><td>" + time_20h45_ +
        "</td><td>" + time_22h15_ + "</td><td>" + time_24h00_ + "</td><td>" + time_ChuNhat_ + "</td><td></td><td></td><td></td><td></td></tr>");
    $('#time_over').append("" +
        "<tr>" +
        "<td>Đến 18h30</td>" +
        "<td>" + time_18h30_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Đến 20h45</td>" +
        "<td>" + time_20h45_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Đến 22h15</td>" +
        "<td>" + time_22h15_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Đến 23h15</td>" +
        "<td>" + time_24h00_ + "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Chủ Nhật</td>" +
        "<td>" + time_ChuNhat_ + "</td>" +
        "</tr>");
}

function AddMember(arraymember) {
    $('#tbdata tr:last').remove();
    var id = $('#tbdata tr').length + 1;
    $.each(arraymember, (i, item) => {
        var msnv = item[2];
        var total = [];
        $('#tbdata tr td:nth-child(4)').each(function() {
            if ($(this).text() == msnv) total.push($(this).text());
        });
        var total_ = total.length;
        if (total_ == 0) {
            var tt = '<input id="c' + id + '" type="radio" checked="checked" name="nspt" onclick="choosemanager();" value ="' +
                id + '">';
            $name = item[1];
            $chucvu = item[3];
            $tenphong = '<?php echo $namedept ?>'
            $18h30 = '<input id="' + id + 'c7' + '"  onclick="document.getElementById(' + "'" + msnv +
                "'" +
                ').style.display=' + "'none'" + ';ReCount()" type="radio" name="' + msnv + '">';
            $20h45 = '<input id="' + id + 'c8' + '" checked onclick="document.getElementById(' + "'" + msnv + "'" +
                ').style.display=' + "'block'" + ';ReCount()" type="radio" name="' + msnv + '">';
            $22h15 = '<input id="' + id + 'c9' + '" onclick="document.getElementById(' + "'" + msnv + "'" +
                ').style.display=' + "'block'" + ';ReCount()" type="radio" name="' + msnv + '">';
            $24h00 = '<input id="' + id + 'c10' + '" onclick="document.getElementById(' + "'" + msnv + "'" +
                ').style.display=' + "'block'" + ';ReCount()" type="radio" name="' + msnv + '">';
            $ChuNhat = '<input id="' + id + 'c11' + '" onclick="document.getElementById(' + "'" + msnv + "'" +
                ').style.display=' + "'block'" + ';ReCount()" type="radio" name="' + msnv + '">';
            $noidung = "<input id='" + id + 'ndcv' + "' value='' class='form-control' style='border-radius: 5px;margin-left: 10px;margin-right: 10px;'></input>";
            $location2 = '<select id="L' + msnv +
                '" onchange="ReCount();" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;';
            $location2 += '">';
            <?php foreach ($data2 as $v) {
    ?>
            $location2 += '<option value=' + "<?php echo $v['IDLocation'] ?>" + '';
            $location2 += '>';
            $location2 += "<?php echo $v['NameLocation'] ?>" + '</option>';
            <?php }?>
            $location2 += '</select>';
            $eat2 = '<select id="' + msnv +
                '" onchange="ReCount();" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;';
            $eat2 += '">';
            <?php foreach ($data as $v) {
    ?>
            $eat2 += '<option value=' + "<?php echo $v['IDEating'] ?>" + '';
            $eat2 += '>';
            $eat2 += "<?php echo $v['NameEating'] ?>" + '</option>';
            <?php }?>
            $eat2 += '</select>';
            $('#tbdata').append("<tr><td>" + tt + "</td><td>" + id + "</td><td>" + msnv + "</td><td>" + $name +
                "</td><td>" + $chucvu + "</td><td>" + $tenphong + "</td><td>" + $18h30 + "</td><td>" +
                $20h45 + "</td><td>" + $22h15 + "</td><td>" + $24h00 + "</td><td>" + $ChuNhat + "</td><td>" + $location2 +
                "</td><td>" + $eat2 + "</td><td>" + $noidung + "</td><td><input class='form-control' style='border-radius: 5px;margin-left: 10px;margin-right: 10px;' id='" + id + 'note' +
                "'></input></td><td></td></tr>"
            );
        }
        id++;
    })
    $('#tbdata').append(
        "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>"
    );
    ReCount();
}

function choosemanager() {
    var id = $('input[name=nspt]:checked').val();
    var table = document.getElementById('tbdata');
    var row = table.rows[id - 1];
}

function ajax(result) {
    $.ajax({
        url: 'CheckMember.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {
                swal.fire('Thông báo', 'Mã số nhân viên không tồn tại!', 'error').then((result) => {
                    console.log(result);
                    document.getElementById('name').value = '';
                    document.getElementById('chucvu').value = '';
                    document.getElementById('tenphong').value = '';
                });
            } else {
                document.getElementById('name').value = result.result[0].FullName;
                document.getElementById('chucvu').value = result.result[0].NamePosition;
                document.getElementById('tenphong').value = result.result[0].NameDept;
            }
        },
        error: function(error) {
            swal.fire('Thông báo', 'Mã số nhân viên không tồn tại!', 'error').then((result) => {
                console.log(error.responseText);
                document.getElementById('name').value = '';
                document.getElementById('chucvu').value = '';
                document.getElementById('tenphong').value = '';
            });
        }
    })
};

function addcheck(result) {
    $.ajax({
        url: 'addcheckgrc.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {} else {
                $.each(result.result, function(i, item) {
                    $('#check').append($('<option>', {
                        value: item.IDMember,
                        text: item.FullName,
                    }));
                });
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function addapprove(result) {
    $.ajax({
        url: 'addapprovegrc.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {} else {
                $.each(result.result, function(i, item) {
                    $('#approve').append($('<option>', {
                        value: item.IDMember,
                        text: item.FullName,
                        text: item.NameDept
                    }));
                });
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function Showreview() {
    if ($('#tbdata tr').length == 0) {
        $('#errorlog').css('display', 'block');
    } else {
        $('#tbdata2').empty();
        $('#location2').empty();
        $('#food2').empty();
        $('#time_over2').empty();
        var table = document.getElementById('tbdata');
        var total_ = table.rows.length;
        for (var i = 0; i < total_ - 1; i++) {
            var row = table.rows[i];
            var tc1 = '',
                tc2 = '',
                tc3 = '',
                tc4 = '',
                ChuNhat = '',
                loca = '',
                eat = '';
            if (row.cells[6].firstChild.checked == true)
                tc1 = 'X';
            if (row.cells[7].firstChild.checked == true)
                tc2 = 'X';
            if (row.cells[8].firstChild.checked == true)
                tc3 = 'X';
            if (row.cells[9].firstChild.checked == true)
                tc4 = 'X';
            if (row.cells[10].firstChild.checked == true)
                ChuNhat = 'X';
            if (row.cells[11].firstChild.value != 'L0018')
                loca = row.cells[11].firstChild.selectedOptions[0].innerText;
            if (row.cells[12].firstChild.style.display != 'none')
                eat = row.cells[12].firstChild.selectedOptions[0].innerText;
            console.log($('#' + row.cells[1].innerText + "ndcv").val())
            $('#tbdata2').append("<tr><td>" + row.cells[1].innerText + "</td><td>" + row.cells[2].innerText +
                "</td><td>" + row.cells[3].innerText + "</td><td>" + row.cells[4].innerText + "</td><td>" + row
                .cells[5].innerText + "</td><td>" + tc1 + "</td><td>" + tc2 + "</td><td>" + tc3 + "</td><td>" +
                tc4 + "</td><td>" + ChuNhat + "</td><td>" + loca + "</td><td>" + eat + "</td><td>" + $('#' + row.cells[1].innerText +
                    "ndcv").val() + "</td><td>" + $('#' + row.cells[1].innerText + "note").val() + "</td></tr>")
        }
        row = table.rows[total_ - 1];
        $('#tbdata2').append("<tr><th colspan=" + 5 + ">TỔNG</th><td>" + row.cells[1].innerText + "</td><td>" + row
            .cells[2].innerText + "</td><td>" + row.cells[3].innerText + "</td><td>" + row.cells[4].innerText +
            "</td><td>" + row.cells[5].innerText + "</td><td></td><td></td><td></td><td></td></tr>");
        var localt = document.getElementById('time_over');
        var localt_ = localt.rows.length;
        for (var i = 0; i < localt_; i++) {
            var row2 = localt.rows[i];
            $('#time_over2').append("<tr><td>" + row2.cells[0].innerText + "</td><td>" + row2.cells[1].innerText +
                "</td></tr>")
        }
        var localt2 = document.getElementById('location');
        var localt2_ = localt2.rows.length;
        for (var i = 0; i < localt2_; i++) {
            var row3 = localt2.rows[i];
            $('#location2').append("<tr><td>" + row3.cells[0].innerText + "</td><td>" + row3.cells[1].innerText +
                "</td><td>" + row3.cells[2].innerText + "</td><td>" + row3.cells[3].innerText + "</td><td>" + row3
                .cells[4].innerText + "</td><td>" + row3.cells[5].innerText + "</td></tr>") 
        }
        var localt3 = document.getElementById('food');
        var localt3_ = localt3.rows.length;
        for (var i = 0; i < localt3_; i++) {
            var row4 = localt3.rows[i];
            $('#food2').append("<tr><td>" + row4.cells[0].innerText + "</td><td>" + row4.cells[1].innerText +
                "</td></tr>")
        }
            // Ngày tạo phiếu 
            var nghiden1 = $('#ngaytao').val();
            var nghiden_arry1 = nghiden1.split("-");
            var dennam1 = nghiden_arry1[0];
            var denthang1 = nghiden_arry1[1];
            var ngaygio_arry1 = nghiden_arry1[2].split("T");
            var denngay1 = ngaygio_arry1[0];
            var giophut_arry1 = ngaygio_arry1[1].split(":");
            var dengio1 = giophut_arry1[0];
            var denphut1 = giophut_arry1[1];
            document.getElementById('lblngaytao').innerText = "Ngày " + denngay1 + " tháng " + denthang1 + " năm " + dennam1;
            // Ngày tạo phiếu
        document.getElementById('lblcheck1').innerText = $('#check1 option:selected').text();
        document.getElementById('lblcheck2').innerText = $('#check2 option:selected').text();
        document.getElementById('lblapprove').innerText = $('#approve option:selected').text();
        document.getElementById('review').style.display = 'block';
    }
}

function Create() {
    document.getElementById('btnSuccess').style.display = 'none';
    var idmember = <?php echo $idmember ?>;
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const idfunction = urlParams.get('id').substr(0, 5);
    var idcheck1 = document.getElementById('check1').value;
    var idcheck2 = document.getElementById('check2').value;
    var idapprove = document.getElementById('approve').value;
    //Ngày tăng ca
    var ngaytao = document.getElementById('ngaytao').value;
    //Ngày tăng ca
    var table = document.getElementById('tbdata');
    var total_ = table.rows.length;
    var value = [];
    for (var i = 0; i < total_ - 1; i++) {
        var row = table.rows[i];
        var value2 = [];
        value2.push(row.cells[2].innerText);
        value2.push($(row.cells[13]).find('input').val());
        var tc1 = '',
            tc2 = '',
            tc3 = '',
            tc4 = '',
            ChuNhat= '',
            loca = '',
            eat = '';
        if (row.cells[6].firstChild.checked == true)
            tc1 = 'X';
        if (row.cells[7].firstChild.checked == true)
            tc2 = 'X';
        if (row.cells[8].firstChild.checked == true)
            tc3 = 'X';
        if (row.cells[9].firstChild.checked == true)
            tc4 = 'X';
        if (row.cells[10].firstChild.checked == true)
            ChuNhat = 'X';
        value2.push(tc1);
        value2.push(tc2);
        value2.push(tc3);
        value2.push(tc4);
        value2.push(ChuNhat);
        loca = row.cells[11].firstChild.selectedOptions[0].value;
        value2.push(loca);
        if (row.cells[12].firstChild.style.display != 'none')
            eat = row.cells[12].firstChild.selectedOptions[0].value;
        value2.push(eat);
        value2.push($(row.cells[14]).find('input').val())
        value.push(value2);
    }
    var nsql = [];
    var id = $('input[name=nspt]:checked').val();
    var table = document.getElementById('tbdata');
    var row = table.rows[id - 1];
    nsql.push(row.cells[3].innerText);
    nsql.push(document.getElementById('sdtphutrach').value);
    var result = {
        idmember,
        idfunction,
        idcheck1,
        idcheck2,
        idapprove,
        value,
        nsql,
        //Ngày tăng ca
        ngaytao
        //Ngày tăng ca

    };
    SaveFile(result);
}

function SaveFile(result) {
    $.ajax({
        url: 'savefileptc.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {
                swal.fire('Thông báo', 'Lưu thất bại. Vui lòng kiểm tra lại!', 'error');
            } else {
                console.log(result);
                var id = result.result;
                var namefile = "Phiếu báo tăng ca";
                var name = "<?php echo $username ?>";
                var dept = "<?php echo $namedept ?>";
                var member = name + " - " + dept;
                var file = {
                    id,
                    member,
                    namefile
                };
                var subject = "Trình duyệt phiếu báo tăng ca";
                var link = "http://113.161.6.179:8089/RD/F0014.php?id=" + result.result;
                var idcheck = document.getElementById('check2').value;
                var result = {
                    file,
                    subject,
                    link,
                    idcheck
                };
                sendmail(result);
                //swal.fire('Thông báo','Bạn đã tạo phiếu thành công','success').then((result) => {location.reload();});
                //location.reload();
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function sendmail(result) {
    $.ajax({
        url: 'Mail.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            if (typeof result.result == 'undefined') {
                swal.fire('Thông báo', 'Lưu thất bại. Vui lòng kiểm tra lại!', 'error');
            } else {
                console.log(result.result);
                swal.fire('Thông báo', 'Bạn đã tạo phiếu thành công', 'success').then((result) => {
                    location.reload();
                });
            }
        },
        error: function(error) {
            console.log(error.responseText);
            swal.fire('Thông báo', 'Bạn đã tạo phiếu thành công', 'success').then((result) => {
                location.reload();
            });
        }
    });
}
</script>
<!-- Không được XÓA- Lỗi -->
<input id="sdtphutrach">
