<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
$con = "";
include('Library/Connect_DB.php');
$check1 = array();
$Kiemtra = array();
$approve = array();
$dept = array();
$sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptn WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='" . $iddept . "' AND position.IDPosition in (Select approveptn.Position2 FROM position,approveptn,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptn.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $check1[] = $row;
}
$sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptn WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptn.Position3 FROM position,approveptn,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptn.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $Kiemtra[] = $row;
}

$sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approveptn WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approveptn.Position4 FROM position,approveptn,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approveptn.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $approve[] = $row;
}
$sql = "SELECT IDDept,NameDept FROM dept WHERE IDDept <>'" . $iddept . "' AND ShowWork=2 ORDER BY IDDept ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $dept[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>THACO AUTO</title>
    <?php include('Library/librarycss.php') ?>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50" style="background-image: url('images/KIA.JPG')" onload="ClockApp()">
    <?php include('Library/menu.php') ?>
    <form autocomplete="off" method="post" enctype="multipart/form-data">
        <div class="align-items-center" style="margin-top: 62px;width: 100%;display: flex;justify-content: center">
            <div class="card-header" id="divall">
                <div class="form-group">
                    <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Phiếu yêu cầu phòng thử nghiệm</h6>
                    <hr>
                </div>
                <div id="divconten" style="float: left;width: 100%">
                    <fieldset style="background: #fffcd5;">
                        <legend style="padding: 0px 5px 0px 10px;font-weight: bold;font-family: Tahoma;font-size: 16px">Thông tin nhân sự:</legend>
                        <div id="main-nv" class="input-group" style="align-items: center;height: 50px">
                            <div id="main-nv-1" class="input-group" style="align-items: center;">
                                <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Mã nhân viên <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                                <input id="txtidmember" type="number" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php echo $idmember ?>">
                            </div>
                            <div id="main-nv-1" class="input-group" style="align-items: center;">
                                <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Họ và tên<h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                                <input id="txtfullname" type="text" readonly class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php echo $username ?>">
                            </div>
                        </div>
                        <div id="main-nv" class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px">
                            <div id="main-nv-1" class="input-group" style="align-items: center">
                                <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Phòng ban<h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                                <input id="txtdept" type="text" class="form-control" readonly style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php echo $namedept ?>">
                            </div>
                            <div id="main-nv-1" class="input-group" style="align-items: center">
                                <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Chức vụ<h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                                <input id="txtposition" type="text" class="form-control" readonly style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php echo $nameposition ?>">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset style="background: #fffcd5;margin-top: 10px">
                        <legend style="padding: 0px 5px 0px 10px;font-weight: bold;font-family: Tahoma;font-size: 16px">Thông tin yêu cầu:</legend>
                        <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Bộ phận tiếp nhận<h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <select id="deptneed" readonly class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                <?php foreach ($dept as $v) { ?>
                                    <option value="<?php echo $v['IDDept']; ?>"><?php echo $v['NameDept']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="main-nv1" class="input-group" style="align-items: center;width: 100%;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">1. Thông tin sản phẩm <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <textarea id="txtThongtinSP" type="text" required class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;height: 100px;resize: none"></textarea>
                        </div>
                        <div id="main-nv2" class="input-group" style="align-items: center;width: 100%;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">2. Mục đích thử nghiệm <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <textarea id="txtMucdichthunghiem" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;height: 100px;resize: none"></textarea>
                        </div>
                        <div id="main-nv3" class="input-group" style="align-items: center;width: 100%;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">3. Nội dung yêu cầu <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                        </div>
                        <fieldset style="background: #fffcd5;margin-top: 10px">
                            <div class="d-flex justify-content-center">
                                <button name="upload" type="button" id='Addmember' onclick="document.getElementById('manualMode').style.display = 'block';" class="btn btn-success" style="width: 190px;margin-bottom: 5px;margin-left: 5px">Thêm công việc</button>
                            </div>
                        </fieldset>
                        <div id="excel_area">
                            <table id="tableshow" class="table table-bordered align-items-center table-flush table-hover" style="color: black">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="color: black;text-align: center;border: 1px solid black;background-color: white">STT</th>
                                        <th style="color: black;text-align: center;border: 1px solid black;background-color: white">Nội dung yêu cầu thử nghiệm</th>
                                        <th style="color: black;text-align: center;border: 1px solid black;background-color: white">Tiêu chí đánh giá</th>
                                        <th style="color: black;text-align: center;border: 1px solid black;background-color: white">Tiêu chuẩn áp dụng</th>
                                        <th style="color: black;text-align: center;border: 1px solid black;background-color: white">Ghi chú</th>
                                        <th style="color: black;text-align: center;border: 1px solid black;background-color: white">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white;border: 1px solid black">
                                </tbody>
                            </table>
                        </div>
                        <div id="main-nv4" class="input-group" style="align-items: center;width: 100%;height: 50px;flex-wrap: unset">
                            <div class="input-group" style="align-items: center;height: 50px;;flex-wrap: unset;width: 100%;margin-top: 10px;">
                                <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">4. Ngày hoàn thành <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                                <input id="timesend" type="datetime-local" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php
                                                                                                                                                                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                        echo date('Y-m-d\TH:i');
                                                                                                                                                                        ?>">
                            </div>
                        </div>
                        <div id="main-nv5" class="input-group" style="align-items: center;width: 100%;flex-wrap: unset;margin-top: 15px">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">5. Người liên hệ tác nghiệp: <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                        </div>
                        <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 124px"> - Họ và tên:<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
                            <input id="txtNguoitacnghiep" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                        </div>
                        <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 124px"> - Số điện thoại:<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
                            <input id="txtSdt" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                        </div>
                        <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 124px">6. Ghi chú<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
                            <textarea id="txtnote" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;height: 100px;resize: none"></textarea>
                        </div>
                        <!--Ngày tạo phiếu-->
                        <div style="display: flex;margin-left: 950px;margin-right: 20px;margin-top: 10px">
                            <h6 style="font-size: 16px;margin-left: 10px;margin-right: 10px">Ngày tạo phiếu: </h6>
                            <input id="ngaytao" type="datetime-local" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php
                                                                                                                                                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                    echo date('Y-m-d\TH:i');
                                                                                                                                                                    ?>">
                        </div>
                        <!--Ngày tạo phiếu-->
                    </fieldset>
                    <fieldset style="background: #fffcd5;margin-top: 10px">
                        <legend style="padding: 0px 5px 0px 10px;font-weight: bold ;font-family: Tahoma;font-size: 16px">Phê Duyệt:</legend>
                        <div id="main-pd" class="input-group" style="align-items: center;width: 100%;height: 50px">
                            <div class="input-group" style="align-items: center; width: 25%;">
                                <h6 style="font-size: 15px;font-family: Tahoma;width: 60px">Bộ phận yêu cầu:</h6>
                                <select id="check1" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                    <?php foreach ($check1 as $v) { ?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div  class="input-group" style="align-items: center; width: 25%;">
                                <h6 style="font-size: 15px;font-family: Tahoma;width: 60px">Kiểm tra: </h6>
                                <select id="kiemtra" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                    <?php foreach ($Kiemtra as $v) { ?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div  class="input-group" style="align-items: center; width: 25%;">
                                <h6 style="font-size: 15px;font-family: Tahoma;width: 60px">Phòng thử nghiệm:</h6>
                                <select id="check2" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                </select>
                            </div>
                            <div  class="input-group" style="align-items: center; width: 25%;">
                            <h6 style="font-size: 15px;font-family: Tahoma;width: 60px;">Phê duyệt: </h6>
                                <select id="approve" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                    <?php foreach ($approve as $v) { ?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="input-group" style="align-items: center;align-content: center;text-align: center;width: 100%;margin-top: 10px">
                        <button type="button" onclick="Showreview();" class="btn btn-primary" style="margin: auto;min-width: 100px">Tạo phiếu</button>
                    </div>
                </div>
            </div>
            <div id="manualMode" class="z-index-3 d-none pos-fixed top-0 left-0 w-100 h-100 overflow-auto" style="justify-content: center;display: grid;background-color:rgba(0,0,0,0.4);">
                <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:850px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#manualMode').addClass('d-none')">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tableshow" class="table table-bordered align-items-center table-flush table-hover" style="background: white;color: black">
                            <thead class="thead-light">
                                <div class="d-flex justify-content-center">
                                    <h5 class="modal-title" id="exampleModalLabel" style="width: 250px;font-size: 16px;font-family: Tahoma;font-weight: bold">THÊM NỘI DUNG CÔNG VIỆC</h5>
                                </div>
                                <div class="form-group">
                                    <label for="noidung" class="col-form-label" style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">Nội dung yêu cầu thử nghiệm:</label>
                                    <textarea class="form-control" id="Content" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tieuchi" class="col-form-label" style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">Tiêu chí đánh giá:</label>
                                    <textarea class="form-control" id="Tieuchidanhgia" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tieuchuan" class="col-form-label" style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">Tiêu chuẩn áp dụng:</label>
                                    <textarea class="form-control" id="Tieuchuanapdung" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="ghichu" class="col-form-label" style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">Ghi chú:</label>
                                    <textarea class="form-control" id="Ghichu1"></textarea>
                                </div>
                            </thead>
                            <tbody id="tbDataManual" style="font-family: Tahoma;font-size: 14px;background: white">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('manualMode').style.display = 'none';">Thoát</button>
                        <button type="button" class="btn btn-primary" id="btnsave">Lưu</button>
                    </div>
                </div>
            </div>
            <div id="review" style="z-index:3;display:none;padding-top:70px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
                <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:850px;height: 800px">
                    <div style="display: flex">
                        <div style="width: 30%">
                            <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                        </div>
                        <div style="width: 70%">
                        </div>
                    </div>
                    <div style="height: 800px;background: white">
                        <h6 style="margin: auto;margin-left: 650px;font-family: Tahoma;font-size: 15px;font-weight: bold;margin-bottom: 20px">QT.RDOT.TTTN/02-BM01</h6>

                        <h6 style="margin: auto;text-align: center;margin-top: 20px;font-family: Tahoma;font-size: 25px;font-weight: bold;margin-bottom: 20px">PHIẾU YÊU CẦU</h6>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 30px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận yêu cầu</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbldept1" style="width: 100%;font-size: 15px;font-family: Tahoma;font-weight: bold">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận thực hiện</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbldept2" style="width: 100%;font-size: 15px;font-family: Tahoma;font-weight: bold">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">1.Thông tin sản phẩm</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lblThongtinSP" style="width: 100%;font-size: 15px;font-family: Tahoma;">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">2. Mục đích thử nghiệm</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lblMucdichthunghiem" style="width: 100%;font-size: 15px;font-family: Tahoma;">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;;font-weight: bold">3. Nội dung yêu cầu </label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label style="width: 100%;font-size: 15px;font-family: Tahoma"> </label>
                        </div>
                        <table class="table table-bordered align-items-center table-flush table-hover" style="background: white;color: black">
                            <thead>
                                <tr>
                                    <th style="color: black;text-align: center;border: 1px solid black">STT</th>
                                    <th style="color: black;text-align: center;border: 1px solid black">Nội dung yêu cầu thử nghiệm</th>
                                    <th style="color: black;text-align: center;border: 1px solid black">Tiêu chí đánh giá</th>
                                    <th style="color: black;text-align: center;border: 1px solid black">Tiêu chuẩn áp dụng</th>
                                    <th style="color: black;text-align: center;border: 1px solid black">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody id="tbdata2" style="font-family: Tahoma;font-size: 14px;background: white; text-align: center">
                            </tbody>
                        </table>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">4. Thời gian hoàn thành</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbltime" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma; font-weight: bold">5. Người liên hệ tác nghiệp</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma">- Họ và tên</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lblNguoitacnghiep" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma">- Số điện thoại</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lblSdt" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma;font-weight: bold">6. Ghi chú</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lblnote" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                        </div>

                        <!--Ngày tạo phiếu-->
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                            <label id="lblngaytao" style="font-size: 15px;font-family: Tahoma;position: absolute;right: 20px"></label>
                        </div>
                        <!--Ngày tạo phiếu-->
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 30px">
                            <div style="width: 50%">
                                <label style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Phê duyệt</label>
                            </div>
                            <div style="width: 50%">
                                <label style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Phòng thử nghiệm</label>
                            </div>
                            <div style="width: 50%">
                                <label style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Kiểm tra</label>
                            </div>
                            <div style="width: 50%">
                                <label style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận yêu cầu</label>
                            </div>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 55px">
                            <div style="width: 50%">
                                <label id="lblapprove" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                            </div>
                            <div style="width: 50%">
                                <label id="lblcheck2" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                            </div>
                            <div style="width: 50%">
                                <label id="lblkiemtra" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                            </div>
                            <div style="width: 50%">
                                <label id="lblcheck1" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                            </div>
                            
                        </div>
                    </div>
                    <div style="background: white;margin: auto;text-align: center">
                        <button style="width: 150px;margin-bottom: 10px" type="button" id="btnSuccess" class="btn btn-primary" onclick="Create();">Hoàn thành</button>
                        <button style="width: 150px;margin-bottom: 10px" onclick="document.getElementById('review').style.display='none'" type="button" class="btn btn-danger">Hủy bỏ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php') ?>
<script type="text/javascript">
    $(document).on("click", "#deleteWork", function() {  
        $(this).parent().parent().remove();
    });

    $('#Addmember').on('click', () => {
        console.log('click');
        var data = "<?php echo $iddept ?>";
        $.ajax({
            url: 'callphieuthunghiem.php',
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                result: data
            },
            success: function(result) {
                $('#tbDataManual').empty();
            },
            error: function(error) {
            }
        })
        $('#manualMode').removeClass('d-none')
    })
    $('#btnsave').on('click', () => {
        if (document.getElementById('Content').value == "" || document.getElementById('Tieuchidanhgia').value == "" || document.getElementById('Tieuchuanapdung').value == "") {
            swal.fire('Thông báo', 'Vui lòng điền đầy đủ thông tin!', 'warning')
        } else {
            var table = $('#tbDataManual').children()
            var data = []
            $.each(table, (i, item) => {
                if (($(item).children().find('input')[0].checked)) {
                    var mem = []
                    $.each($(item).children(), (i, item2) => {
                        if (i > 0) {
                            mem.push($(item2)[0].value)
                        }
                    })
                    data.push(mem)
                }
            })
            console.log(data)
            AddMember(data)

        }
    })

    function AddMember() {
        //Chú ý 1
        // $('#tbdata tr:last').remove();
        var tt = $('#tbdata tr').length + 1;
        //Chú ý 1
        Content = document.getElementById('Content').value;
        Tieuchidanhgia = document.getElementById('Tieuchidanhgia').value;
        Tieuchuanapdung = document.getElementById('Tieuchuanapdung').value;
        Ghichu1 = document.getElementById('Ghichu1').value;
        $('#tbdata').append("<tr><td style='border: 1px solid black'>" + tt + "</td><td id='content' style='border: 1px solid black'>" + Content + "</td><td id='teuchidanhgia' style='border: 1px solid black'>" + Tieuchidanhgia + "</td><td id='tieuchuanapdung' style='border: 1px solid black'>" + Tieuchuanapdung + "</td><td id='ghichu1' style='border: 1px solid black'>" + Ghichu1 + "</td><td style='border: 1px solid black;'><button id='deleteWork' type='button' class='btn btn-danger Delete_work' >Xóa</buuton></td></tr>");
        $('#tbdata').append("<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
        // $('.Delete_work').on('click',function(){
            
        //     // Content = $('#Content').value == '';
        //     // Tieuchidanhgia = $('#Tieuchidanhgia').value == '';
        //     // Tieuchuanapdung = $('#Tieuchuanapdung').value == '';
        //     // Ghichu1 = $('Ghichu1').value == '';
        // });
        ReCount();
        document.getElementById('manualMode').style.display = 'none';
    }

    function ReCount() {
        $('#tbdata tr:last').remove();
        $('#time_over').empty();
        var table = document.getElementById('tbdata');
        var total_ = table.rows.length + 1; //Chú ý
        for (var i = 0; i < total_; i++) {
            var row = table.rows[i];
            var value = [];
        }
    }

    $("#txtThongtinSP").focus(function() {
        if (document.getElementById('txtThongtinSP').value === '') {
            document.getElementById('txtThongtinSP').value += '- ';
        }
    });

    $("#txtThongtinSP").keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            document.getElementById('txtThongtinSP').value += '- ';
        }
        var txtval = document.getElementById('txtThongtinSP').value;
        if (txtval.substr(txtval.length - 1) == '\n') {
            document.getElementById('txtThongtinSP').value = txtval.substring(0, txtval.length - 1);
        }
    });
    $("#txtMucdichthunghiem").focus(function() {
        if (document.getElementById('txtMucdichthunghiem').value === '') {
            document.getElementById('txtMucdichthunghiem').value += '- ';
        }
    });

    $("#txtMucdichthunghiem").keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            document.getElementById('txtMucdichthunghiem').value += '- ';
        }
        var txtval = document.getElementById('txtMucdichthunghiem').value;
        if (txtval.substr(txtval.length - 1) == '\n') {
            document.getElementById('txtMucdichthunghiem').value = txtval.substring(0, txtval.length - 1);
        }
    });
    $("#txtNguoitacnghiep").focus(function() {
        if (document.getElementById('txtNguoitacnghiep').value === '') {
            document.getElementById('txtNguoitacnghiep').value += ' ';
        }
    });
    $("#txtNguoitacnghiep").keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            document.getElementById('txtNguoitacnghiep').value += ' ';
        }
        var txtval = document.getElementById('txtNguoitacnghiep').value;
        if (txtval.substr(txtval.length - 1) == '\n') {
            document.getElementById('txtNguoitacnghiep').value = txtval.substring(0, txtval.length - 1);
        }
    });
    $("#txtSdt").focus(function() {
        if (document.getElementById('txtSdt').value === '') {
            document.getElementById('txtSdt').value += ' ';
        }
    });
    $("#txtSdt").keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            document.getElementById('txtSdt').value += ' ';
        }
        var txtval = document.getElementById('txtSdt').value;
        if (txtval.substr(txtval.length - 1) == '\n') {
            document.getElementById('txtSdt').value = txtval.substring(0, txtval.length - 1);
        }
    });
    $("#txtnote").focus(function() {
        if (document.getElementById('txtnote').value === '') {
            document.getElementById('txtnote').value += '- ';
        }
    });

    $("#txtnote").keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            document.getElementById('txtnote').value += '- ';
        }
        var txtval = document.getElementById('txtnote').value;
        if (txtval.substr(txtval.length - 1) == '\n') {
            document.getElementById('txtnote').value = txtval.substring(0, txtval.length - 1);
        }
    });
    $(document).ready(function() {
        var result = document.getElementById("deptneed").value;
        console.log(result);
        AddCheck2(result);
        $("#deptneed").change(function() {
            var result = document.getElementById("deptneed").value;
            console.log(result);
            AddCheck2(result);
        });
    });

    function AddCheck2(result) {
        $.ajax({
            url: 'addcheckptn.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                if (typeof result.result == 'undefined') {} else {
                    $('#check2').empty();
                    $.each(result.result, function(i, item) {
                        $('#check2').append($('<option>', {
                            value: item.IDMember,
                            text: item.FullName
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
        if (document.getElementById('txtMucdichthunghiem').value == "" || document.getElementById('txtThongtinSP').value == "") {
            swal.fire('Thông báo', 'Vui lòng điền đầy đủ thông tin ở các mục có gắng dấu sao (*)!', 'warning')
        } else {
            $('#tbdata2').empty();
            var table = document.getElementById('tbdata');
            var total_ = table.rows.length + 1;
            for (var i = 0; i < total_ - 1; i++) {
                var row = table.rows[i];
                $('#tbdata2').append("<tr><td style='border: 1px solid black'>" + row.cells[0].innerText + "</td><td style='border: 1px solid black'>" + row.cells[1].innerText + "</td><td style='border: 1px solid black'>" + row.cells[2].innerText + "</td><td style='border: 1px solid black'>" + row.cells[3].innerText + "</td><td style='border: 1px solid black'>" + row.cells[4].innerText + "</td></tr>")
            }
            var table = document.getElementById('tbdata');
            document.getElementById('lbldept1').innerText = document.getElementById('txtdept').value;
            document.getElementById('lbldept2').innerText = $('#deptneed option:selected').text();
            document.getElementById('lblThongtinSP').innerText = document.getElementById('txtThongtinSP').value;
            document.getElementById('lblMucdichthunghiem').innerText = document.getElementById('txtMucdichthunghiem').value;
            document.getElementById('lblNguoitacnghiep').innerText = document.getElementById('txtNguoitacnghiep').value;
            document.getElementById('lblSdt').innerText = document.getElementById('txtSdt').value;
            document.getElementById('lblnote').innerText = document.getElementById('txtnote').value;
            var nghiden = $('#timesend').val();
            var nghiden_arry = nghiden.split("-");
            var dennam = nghiden_arry[0];
            var denthang = nghiden_arry[1];
            var ngaygio_arry = nghiden_arry[2].split("T");
            var denngay = ngaygio_arry[0];
            var giophut_arry = ngaygio_arry[1].split(":");
            var dengio = giophut_arry[0];
            var denphut = giophut_arry[1];
            document.getElementById('lbltime').innerText = dengio + " giờ " + denphut + " phút, Ngày " + denngay + "/" + denthang + "/" + dennam;
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
            document.getElementById('lblngaytao').innerText = "Núi Thành, Ngày " + denngay1 + " tháng " + denthang1 + " năm " + dennam1;
            // Ngày tạo phiếu
            document.getElementById('lblcheck1').innerText = $('#check1 option:selected').text();
            document.getElementById('lblkiemtra').innerText = $('#kiemtra option:selected').text();
            document.getElementById('lblcheck2').innerText = $('#check2 option:selected').text();
            document.getElementById('lblapprove').innerText = $('#approve option:selected').text();
            document.getElementById('review').style.display = 'block';
        }
    }

    function Create() {
        var table = document.getElementById('tbdata');

        var total_ = table.rows.length;
        var value = [];
        for (var i = 0; i < total_ - 1; i++) {
            var row = table.rows[i];
        }
        document.getElementById('btnSuccess').style.display = 'none';
        var idmember = document.getElementById('txtidmember').value;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const idfunction = urlParams.get('id').substr(0, 5);
        var deptneed = document.getElementById('deptneed').value;
        var ThongtinSP = document.getElementById('txtThongtinSP').value;
        var Mucdichthunghiem = document.getElementById('txtMucdichthunghiem').value;
        var Nguoitacnghiep = document.getElementById('txtNguoitacnghiep').value;
        var Sdt = document.getElementById('txtSdt').value;
        var note = document.getElementById('txtnote').value;
        var timesend = document.getElementById('timesend').value;
        var ngaytao = document.getElementById('ngaytao').value;
        var idcheck1 = document.getElementById('check1').value;
        var idkiemtra = document.getElementById('kiemtra').value;
        var idcheck2 = document.getElementById('check2').value;
        var idapprove = document.getElementById('approve').value;
        //Chú ý
        //  var tt = $('#tbdata tr').length+1;
        var Content = document.getElementById('Content').value;

        var content = [];
        var teuchidanhgia = [];
        var tieuchuanapdung = [];
        var ghichu1 = [];

        $('td#content').each(function(index, value){
            var data = $(this).text();
            content.push(data);
        });

        $('td#teuchidanhgia').each(function(index, value){
            var data = $(this).text();
            teuchidanhgia.push(data);
        });

        $('td#tieuchuanapdung').each(function(index, value){
            var data = $(this).text();
            tieuchuanapdung.push(data);
        });

        $('td#ghichu1').each(function(index, value){
            var data = $(this).text();
            ghichu1.push(data);
        });

        var count = content.length;
     
        //chú ý
        var table = document.getElementById('tbdata');

        var result = [];

        var defaut_result = {
            idmember,
            idfunction,
            deptneed,
            ThongtinSP,
            Mucdichthunghiem,
            Nguoitacnghiep,
            Sdt,
            note,
            timesend,
            ngaytao,
            idcheck1,
            idkiemtra,
            idcheck2,
            idapprove
        };

        for(var i = 0 ; i < count ; i ++ ) {
            var Content = content[i];
            var Tieuchidanhgia = teuchidanhgia[i];
            var Tieuchuanapdung = tieuchuanapdung[i];
            var Ghichu1 = ghichu1[i];

            result[i] = {
                idmember,
                idfunction,
                deptneed,
                ThongtinSP,
                Mucdichthunghiem,
                Nguoitacnghiep,
                Sdt,
                note,
                timesend,
                ngaytao,
                Content,
                Tieuchidanhgia,
                Tieuchuanapdung,
                Ghichu1,
                idcheck1,
                idkiemtra,
                idcheck2,
                idapprove
            }
          
        }

        SaveFile(result, defaut_result);
    }

    function SaveFile(result, defaut_result) {
        $.ajax({ 
            url: 'savefilethunghiem.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result,
                defaut_result : defaut_result
            },
            success: function(result) {
                console.log(result);
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Lưu thất bại. Vui lòng kiểm tra lại!', 'error');
                } else {
                    var id = result.result;
                    var namefile = "Phiếu yêu cầu công việc";
                    var name = "<?php echo $username ?>";
                    var dept = "<?php echo $namedept ?>";
                    var member = name + " - " + dept;
                    var file = {
                        id,
                        member,
                        namefile
                    };
                    var subject = "Trình duyệt phiếu yêu cầu công việc phòng Thử nghiệm";
                    var link = "http://113.161.6.179:8089/RD/F0022.php?id=" + result.result;
                    var idcheck = document.getElementById('check1').value;
                    var result = {
                        file,
                        subject,
                        link,
                        idcheck
                    };
                    sendmail(result);
                    // swal.fire('Thông báo','Bạn đã tạo phiếu thành công','success').then((result) => {location.reload();});
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