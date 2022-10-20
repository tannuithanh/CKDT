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
<body data-spy="scroll" data-target=".navbar" data-offset="50" style="background-image: url('images/KIA.JPG')" onload="ClockApp()">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;display: flex;justify-content: center">
        <div class="card-header" id="divall">
            <div class="form-group">
                <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Giấy vào cổng</h6>
                <hr>
            </div>
            <div id="divconten" style="float: left;width: 100%" >
                <fieldset style="background: #fffcd5;">
                    <legend style="padding: 0px 5px 0px 10px;font-weight: bold;font-family: Tahoma;font-size: 16px">Thông tin nhân sự bảo lãnh:</legend>
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
                <div  id="main-nv" class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px">
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
                    <legend style="padding: 0px 5px 0px 10px;font-weight: bold;font-family: Tahoma;font-size: 16px">Thông tin nhân sự vào R&D làm việc:</legend>
                    <div id="main-nv" class="input-group" style="align-items: center;width: 100%;height: 50px;flex-wrap: unset">
                        <div id="main-tg-1" class="input-group" style="align-items: center;height: 50px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Thời gian Vào <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <input id="timein" type="datetime-local" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            echo date('Y-m-d\TH:i');
                            ?>">
                        </div>
                        <div id="main-tg-1" class="input-group" style="align-items: center;height: 50px;flex-wrap: unset">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Thời gian ra <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                            <input id="timeout" type="datetime-local" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px" value="<?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            echo date('Y-m-d\TH:i');
                            ?>">
                        </div>
                        <div id="main-tg-2" class="input-group" style="align-items: center;height: 50px;flex-wrap: unset">
                            
                            <div id="main-tg-3" class="input-group" style="align-items: center;flex-wrap: unset">
                            <div id="main-tg-4" class="input-group" style="align-items: center;width: 220px;flex-wrap: unset">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="main-nv2" class="input-group" style="align-items: center;width: 100%;height: 50px">
                        <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Họ và tên khách <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                        <input id="txthoten" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                    </div>
                    <div id="main-nv2" class="input-group" style="align-items: center;width: 100%;height: 50px">
                        <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Đơn vị công tác <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                        <input id="txtcongtac" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                    </div>
                    <div id="main-nv2" class="input-group" style="align-items: center;width: 100%;height: 50px">
                        <h6 style="font-size: 16px;font-family: Tahoma;width: 116px">Lý do vào cổng <h6 style="color: red;margin: 0px;padding: 0px">*</h6>: </h6>
                        <input id="txtlydo" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                    </div>
                    <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px">
                        <h6 style="font-size: 16px;font-family: Tahoma;width: 124px">Phương tiện<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
                        <input id="txtlicence" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                    </div>
                    <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px">
                        <h6 style="font-size: 16px;font-family: Tahoma;width: 124px">Mang theo<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
                        <input id="txtbring" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                    </div>
                    <div class="input-group" style="align-items: center;width: 100%;margin-top: 10px;height: 50px">
                        <h6 style="font-size: 16px;font-family: Tahoma;width: 124px">Ghi chú<h6 style="color: red;margin: 0px;padding: 0px"></h6>: </h6>
                        <input id="txtnote" type="text" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                    </div>
                </fieldset>
                <fieldset style="background: #fffcd5;margin-top: 10px">
                    <legend style="padding: 0px 5px 0px 10px;font-weight: bold ;font-family: Tahoma;font-size: 16px">Phê Duyệt:</legend>
                    <div id="main-pd" class="input-group" style="align-items: center;width: 100%;height: 50px">
                        <div id="main-pd-1" class="input-group" style="align-items: center">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 130px">Xem xét </h6>
                            <select id="check" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                            </select>
                        </div>
                        <div id="main-pd-1" class="input-group" style="align-items: center">
                            <h6 style="font-size: 16px;font-family: Tahoma;width: 130px">Phê duyệt </h6>
                            <select id="approve" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px">
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div id="errorlog" class="input-group" style="display: none;align-items: center;align-content: center;text-align: center;width: 100%;margin-top: 10px">
                    <label style="font-size: 14px;font-family: Tahoma;color: #c80000">Vui lòng nhập đủ thông tin ở các mục gắn dấu sao (*)!</label>
                </div>
                <div class="input-group" style="align-items: center;align-content: center;text-align: center;width: 100%;margin-top: 10px">
                    <button type="button" onclick="Showreview();/*Create();*/" class="btn btn-primary" style="margin: auto;min-width: 100px">Tạo phiếu</button>
                </div>
            </div>
        </div>
        <div id="review" style="z-index:3;display:none;padding-top:70px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
            <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:600px;height: 700px">
                <div style="display: flex">
                    <div style="width: 50%">
                        <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                    </div>
                </div>
                <div  style="height: 490px;background: white" >
                    <div style="width: 100%;display: block;margin-top: 10px">
                        <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px;font-weight: bold"> R&D Ô TÔ</h6>
                        <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">KCN THACO Chu Lai, xã Tam Hiệp,</h6>
                        <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">huyện Núi Thành, tỉnh Quảng Nam</h6>
                    </div>
                    <h6 style="margin: auto;text-align: center;margin-top: 20px;font-family: Tahoma;font-size: 25px;font-weight: bold;margin-bottom: 20px">GIẤY VÀO CỔNG</h6>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Nhân sự vào cổng</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblnhansuvaocong" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Đơn vị công tác</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblcongtac" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Lý do vào cổng</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblreason" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Có mang theo</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblbring" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Phương tiện</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbllicence" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Giờ vào</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbltimeout" style="width: 100%;font-size: 15px;font-family: Tahoma">.......h.......</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Giờ ra</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbltimein" style="width: 100%;font-size: 15px;font-family: Tahoma">.......h.......</label>
                    </div>
		    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px"></div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Nhân sự bảo lãnh</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbname" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Bộ phận</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbldept" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Ghi Chú</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblnote" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 14px;font-family: Tahoma;position: absolute;right: 20px">
                            <?php
                        //    date_default_timezone_set('Asia/Ho_Chi_Minh');
                            echo "Ngày ".date('d')." tháng ".date('m')." năm ".date('Y');
                            ?>
                        </label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 30px">
                        <div style="width: 50%">
                            <label style="text-align: center;font-size: 15px;font-family: Tahoma">LÃNH ĐẠO CÔNG TY</label>
                        </div>
                        <div style="width: 50%">
                            <label style="text-align: center;font-size: 15px;font-family: Tahoma">PHỤ TRÁCH BỘ PHẬN</label>
                        </div>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 60px">
                        <div style="width: 50%">
                            <label id="lblapprove" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                        </div>
                        <div style="width: 50%">
                            <label id="lblcheck" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</label>
                        </div>
                    </div>
                </div>
                <div style="background: white;margin: auto;text-align: center;margin-top: 100px;">
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
<?php include('Library/HidenAlert.php')?>
<script>
    $(document).ready(function (){
        $("#txtidmember").change(function (){
            var result = document.getElementById("txtidmember").value;
            console.log(result);
            ajax(result);
        });
        var idmember = document.getElementById('txtidmember').value;
        var iddept = "<?php echo $iddept?>";
        var result2 = {idmember,iddept};
        console.log(result2);
        addcheck(result2);
        addapprove(idmember);
    });
    function ajax(result){
        $.ajax({
            url:'CheckMember.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                    swal.fire('Thông báo','Mã số nhân viên không tồn tại!','error').then((result) => {
                        console.log(result);
                        document.getElementById('txtfullname').value = '';
                        document.getElementById('txtdept').value = '';
                        document.getElementById('txtposition').value = '';
                    });
                }
                else
                {
                    console.log(result.result);
                    document.getElementById('txtfullname').value=result.result[0].FullName;
                    document.getElementById('txtdept').value=result.result[0].NameDept;
                    document.getElementById('txtposition').value = result.result[0].NamePosition;
                    $('#check').children().remove().end();
                    $('#approve').children().remove().end();
                    var idmember = document.getElementById('txtidmember').value;
                    var iddept = "<?php echo $iddept?>";
                    var result = {idmember,iddept};
                    addcheck(result);
                    addapprove(idmember);
                }
            },
            error:function(error){
                swal.fire('Thông báo','Mã số nhân viên không tồn tại!','error').then((result) => {
                    console.log(error.responseText);
                    document.getElementById('txtfullname').value = '';
                    document.getElementById('txtdept').value = '';
                    document.getElementById('txtposition').value = '';
                });
            }
        })
    };
    function addcheck(result)
    {
        $.ajax({
            url:'addcheckgrc.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                console.log(result)
                if(typeof result.result =='undefined') {
                }
                else
                {
                    console.log(result);
                    $.each(result.result, function (i, item) {
                        $('#check').append($('<option>', {
                            value: item.IDMember,
                            text : item.FullName
                        }));
                    });
                }
            },
            error:function(error){
                console.log(error.responseText);
            }
        });
    }
    function addapprove(result)
    {
        $.ajax({
            url:'addapprovegrc.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                }
                else
                {
                    console.log(result.result);
                    $.each(result.result, function (i, item) {
                        $('#approve').append($('<option>', {
                            value: item.IDMember,
                            text : item.FullName
                        }));
                    });
                }
            },
            error:function(error){
                console.log(error.responseText);
            }
        });
    }
    function Showreview()
    {
        if(document.getElementById('txtidmember').value=='' || document.getElementById('txtlydo').value=='')
        {
            swal.fire('Thông báo','Vui lòng điền đầy đủ thông tin ở các mục có gắng dấu sao (*)!','warning')
        }
        else {
            document.getElementById('lblcongtac').innerText = document.getElementById('txtcongtac').value;
            document.getElementById('lblnhansuvaocong').innerText = document.getElementById('txthoten').value;
            document.getElementById('lbname').innerText = document.getElementById('txtfullname').value;
            document.getElementById('lbldept').innerText = document.getElementById('txtdept').value;
            document.getElementById('lblbring').innerText = document.getElementById('txtbring').value;
            document.getElementById('lblreason').innerText = document.getElementById('txtlydo').value;
            document.getElementById('lbllicence').innerText = document.getElementById('txtlicence').value;
            document.getElementById('lblnote').innerText = document.getElementById('txtnote').value;
            var nghiden = $('#timein').val();
            var nghiden_arry = nghiden.split("-");
            var dennam = nghiden_arry[0];
            var denthang = nghiden_arry[1];
            var ngaygio_arry = nghiden_arry[2].split("T");
            var denngay = ngaygio_arry[0];
            var giophut_arry = ngaygio_arry[1].split(":");
            var dengio = giophut_arry[0];
            var denphut = giophut_arry[1];
            document.getElementById('lbltimeout').innerText = dengio + " h " + denphut + " phút, Ngày " + denngay + "/" + denthang + "/" + dennam;
            var nghiden1 = $('#timeout').val();
            var nghiden_arry1 = nghiden1.split("-");
            var dennam1 = nghiden_arry1[0];
            var denthang1 = nghiden_arry1[1];
            var ngaygio_arry1 = nghiden_arry1[2].split("T");
            var denngay1 = ngaygio_arry1[0];
            var giophut_arry1 = ngaygio_arry1[1].split(":");
            var dengio1 = giophut_arry1[0];
            var denphut1 = giophut_arry1[1];
            document.getElementById('lbltimein').innerText = dengio1 + " h " + denphut1 + " phút, Ngày " + denngay1 + "/" + denthang1 + "/" + dennam1;
            document.getElementById('lblcheck').innerText = $('#check option:selected').text();
            document.getElementById('lblapprove').innerText = $('#approve option:selected').text();
            document.getElementById('review').style.display = 'block';
               }
    }
    function Create()
    {
        document.getElementById('btnSuccess').style.display='none';
            var idmember = document.getElementById('txtidmember').value;
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const idfunction = urlParams.get('id').substr(0,5);
            var Donvicongtac = $('#txtcongtac').val();
            var NameIn = document.getElementById('txthoten').value;
            var reason = document.getElementById('txtlydo').value;
            var licence = document.getElementById('txtlicence').value;
            var bring = document.getElementById('txtbring').value;
            var note = document.getElementById('txtnote').value;
            var timeout = document.getElementById('timein').value;
            var timein = document.getElementById('timeout').value;
            var idcheck = document.getElementById('check').value;
            var idapprove=document.getElementById('approve').value;
            var result ={idmember,idfunction,Donvicongtac,NameIn,reason,licence,bring,note,timeout,timein,idcheck,idapprove};
            console.log(result)

            SaveFile(result);
    }
    function SaveFile(result)
    {
        $.ajax({
            url:'savefilepvc.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){

                if(typeof result.result =='undefined') {
                    swal.fire('Thông báo','Lưu thất bại. Vui lòng kiểm tra lại!','error');
                }
                else
                {
                    console.log(result);
                    var id = result.result;
                    var namefile = "Giấy vào cổng";
                    var name = document.getElementById('lbname').innerText;
                    var dept = document.getElementById('lbldept').innerText
                    var member = name + " - "+ dept;
                    var file = {id,member,namefile};
                    var subject = "Trình duyệt giấy vào cổng";
		            var link = "http://113.161.6.179:8089/RD/F0020.php?id="+result.result;
                    var idcheck = document.getElementById('check').value;
                    var result = {file,subject,link,idcheck};
                    sendmail(result);
                }
            },
            error:function(error){
                console.log(error.responseText);
            }
        });
    }
    function sendmail(result){
        $.ajax({
            url:'Mail.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                    swal.fire('Thông báo','Lưu thất bại. Vui lòng kiểm tra lại!','error');
                }
                else
                {
                    console.log(result.result);
                    swal.fire('Thông báo','Bạn đã tạo phiếu thành công','success').then((result) => {location.reload();});
                }
            },
            error:function(error){
                console.log(error.responseText);
                swal.fire('Thông báo','Bạn đã tạo phiếu thành công','success').then((result) => {location.reload();});
            }
        });
    }
</script>
