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
$approve = array();
$kiemtra = array();
$dept = array();
if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) {
$sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='" . $iddept . "' AND position.IDPosition in (Select approvepcv.Position2 FROM position,approvepcv,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $check1[] = $row;
}

$sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv WHERE member.IDMember = managermember.IDMember AND managermember.IDDept='$iddept' AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvepcv.Position3 FROM position,approvepcv,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $kiemtra[] = $row;
}
$sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvepcv.Position4 FROM position,approvepcv,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv.Position1 AND member.IDMember='" . $idmember . "') ORDER BY position.IDPosition ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $approve[] = $row;
}
$sql = "SELECT IDDept,NameDept FROM dept WHERE IDDept <>'" . $iddept . "' AND ShowWork=1 ORDER BY IDDept ASC";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query)) {
    $dept[] = $row;
}
}else{
    $sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv1 WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND dept.IDDept='".$iddept."' AND position.IDPosition in (Select approvepcv1.Position2 FROM position,approvepcv1,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv1.Position1 AND member.IDMember='".$idmember."') ORDER BY position.IDPosition ASC";
    $query = mysqli_query($con,$sql);
    while ($row=mysqli_fetch_array($query))
    {
        $check1[] = $row;
    }
    $sql = "SELECT DISTINCT member.IDMember,member.FullName FROM member,position,dept,managermember,approvepcv1 WHERE member.IDMember = managermember.IDMember AND managermember.IDDept=dept.IDDept AND managermember.IDPosition = position.IDPosition AND position.IDPosition in (Select approvepcv1.Position3 FROM position,approvepcv1,member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDPosition = approvepcv1.Position1 AND member.IDMember='".$idmember."') ORDER BY position.IDPosition ASC";
    $query = mysqli_query($con,$sql);
    while ($row=mysqli_fetch_array($query))
    {
        $approve[] = $row;
    }
    $sql = "SELECT IDDept,NameDept FROM dept WHERE IDDept <>'".$iddept."' AND ShowWork=1 ORDER BY IDDept ASC";
    $query = mysqli_query($con,$sql);
    while ($row=mysqli_fetch_array($query))
    {
        $dept[] = $row;
    }
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
                    <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Phiếu yêu cầu công việc</h6>
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
                        <legend style="padding: 0px 5px 0px 10px;font-weight: bold;font-family: Tahoma;font-size: 16px">Nội dung:</legend>
                        <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Bộ phận tiếp nhận<h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <select id="deptneed" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                <?php foreach ($dept as $v) { ?>
                                    <option value="<?php echo $v['IDDept']; ?>"><?php echo $v['NameDept']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="main-nv3" class="input-group" style="align-items: center;width: 100%;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Nội dung yêu cầu <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <textarea id="txtlydo" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;height: 100px;resize: none"></textarea>
                        </div>
                        <div id="main-nv" class="input-group" style="align-items: center;width: 100%;height: 50px;flex-wrap: unset">
                            <div class="input-group" style="align-items: center;height: 50px;;flex-wrap: unset;width: 100%;margin-top: 10px;">
                                <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Thời gian hoàn thành <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                                <input id="timesend" type="datetime-local" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php
                                                                                                                                                                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                        echo date('Y-m-d\TH:i');
                                                                                                                                                                        ?>">
                            </div>
                        </div>
                        <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 124px">Ghi chú<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
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
                                <h6 style="font-size: 15px;font-family: Tahoma;width: 130px">Bộ phận yêu cầu:</h6>
                                <select id="check1" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                    <?php foreach ($check1 as $v) { ?>
                                        <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) { ?>
                                <div class="input-group" style="align-items: center; width: 25%;">
                                    <h6 style="font-size: 15px;font-family: Tahoma;width: 61px">Kiểm tra: </h6>
                                    <select id="kiemtra" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                        <?php foreach ($kiemtra as $v) { ?>
                                            <option value="<?php echo $v['IDMember']; ?>"><?php echo $v['FullName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="input-group" style="align-items: center; width: 25%;">
                                <h6 style="font-size: 15px;font-family: Tahoma;width: 130px">Bộ phận tiếp nhận:</h6>
                                <select id="check2" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                                </select>
                            </div>
                            <div class="input-group" style="align-items: center; width: 25%;">
                                <h6 style="font-size: 15px;font-family: Tahoma;width: 72px">Phê duyệt: </h6>
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
            <div id="review" style="z-index:3;display:none;padding-top:70px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
                <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:850px;height: 650px">
                    <div style="display: flex">
                        <div style="width: 30%">
                            <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                        </div>
                        <div style="width: 70%">
                        </div>
                    </div>
                    <div style="height: 523px;background: white">

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
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma">1. Nội dung yêu cầu</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label style="width: 100%;font-size: 15px;font-family: Tahoma"> </label>
                        </div>
                        <div style="display: flex;margin-left: 40px;margin-right: 20px;margin-top: 15px">
                            <label id="lblconten" style="font-size: 15px;font-family: Tahoma">1. Nội dung yêu cầu</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma">2. Thời gian hoàn thành:</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbltime" style="width: 100%;font-size: 15px;font-family: Tahoma; color: red">.................</label>
                        </div>
                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 15px">
                            <label style="width: 250px;font-size: 15px;font-family: Tahoma">3. Ghi chú</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label style="width: 100%;font-size: 15px;font-family: Tahoma"> </label>
                        </div>
                        <div style="display: flex;margin-left: 40px;margin-right: 20px;margin-top: 15px">
                            <label id="lblnote" style="font-size: 15px;font-family: Tahoma">3. Ghi chú</label>
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
                                <label style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận tiếp nhận</label>
                            </div>
                            <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) { ?>
                                <div style="width: 50%">
                                    <label style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Kiểm tra</label>
                                </div>
                            <?php } ?>
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
                            <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) { ?>
                                <div style="width: 50%">
                                    <label id="lblkiemtra" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                                </div>
                            <?php } ?>
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
    $("#txtlydo").focus(function() {
        if (document.getElementById('txtlydo').value === '') {
            document.getElementById('txtlydo').value += '- ';
        }
    });

    $("#txtlydo").keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            document.getElementById('txtlydo').value += '- ';
        }
        var txtval = document.getElementById('txtlydo').value;
        if (txtval.substr(txtval.length - 1) == '\n') {
            document.getElementById('txtlydo').value = txtval.substring(0, txtval.length - 1);
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
            url: 'addcheckpcv.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                console.log(result.result)
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
        if (document.getElementById('txtlydo').value == '') {
            swal.fire('Thông báo', 'Vui lòng điền đầy đủ thông tin ở các mục có gắng dấu sao (*)!', 'warning')
        } else {
            document.getElementById('lbldept1').innerText = document.getElementById('txtdept').value;
            document.getElementById('lbldept2').innerText = $('#deptneed option:selected').text();
            document.getElementById('lblconten').innerText = document.getElementById('txtlydo').value;
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
            document.getElementById('lbltime').innerText = dengio + " h " + denphut + " phút, Ngày " + denngay + "/" + denthang + "/" + dennam;
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
            <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) { ?>
                document.getElementById('lblkiemtra').innerText = $('#kiemtra option:selected').text();
            <?php } ?>
            document.getElementById('lblcheck2').innerText = $('#check2 option:selected').text();
            document.getElementById('lblapprove').innerText = $('#approve option:selected').text();
            document.getElementById('review').style.display = 'block';
        }
    }

    function Create() {
        document.getElementById('btnSuccess').style.display = 'none';
        var idmember = document.getElementById('txtidmember').value;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const idfunction = urlParams.get('id').substr(0, 5);
        var deptneed = document.getElementById('deptneed').value;
        var content = document.getElementById('txtlydo').value;
        var note = document.getElementById('txtnote').value;
        var ngaytao = document.getElementById('ngaytao').value; // ngày tạo phiếu
        var timesend = document.getElementById('timesend').value;
        var idcheck1 = document.getElementById('check1').value;
        <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) { ?>
        var idkiemtra = document.getElementById('kiemtra').value;
        <?php } ?>
        var idcheck2 = document.getElementById('check2').value;
        var idapprove = document.getElementById('approve').value;
        <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015' ) { ?>
            var result = {
                idmember,
                idfunction,
                deptneed,
                content,
                note,
                ngaytao,
                timesend,
                idcheck1,
                idcheck2,
                idkiemtra,
                idapprove
            };
        <?php } else { ?>
            var result = {
                idmember,
                idfunction,
                deptneed,
                content,
                note,
                ngaytao,
                timesend,
                idcheck1,
                idcheck2,
                idapprove
            };
        <?php } ?>


        SaveFile(result);
        console.log(result);
    }

    function SaveFile(result) {
        $.ajax({
            url: 'savefilepcv.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                console.log(result.result);
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Lưu thất bại. Vui lòng kiểm tra lại!', 'error');
                } else {
                    console.log(result.result);
                    var id = result.result;
                    var namefile = "Phiếu yêu cầu công việc";
                    var name = document.getElementById('txtfullname').value;
                    var dept = document.getElementById('txtdept').value
                    var member = name + " - " + dept;
                    var file = {
                        id,
                        member,
                        namefile
                    };
                    var subject = "Trình duyệt Phiếu yêu cầu công việc";
                    var link = "localhost/RD/F0013.php?id=" + result.result;
                    var idcheck = document.getElementById('check1').value;
                    console.log(idcheck);
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
                console.log(idcheck);
                console.log(result.result);
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