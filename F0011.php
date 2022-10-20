<?php
session_start();
if(isset($_SESSION['idmember'])) {
    $idmember = $_SESSION['idmember'];
}
else{
    $CurPageURL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['LinkCur']=$CurPageURL;
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
<body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG" onload="ClockApp()">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;display: flex;justify-content: center">
        <div id="review" style="padding-top: 62px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
            <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:600px;height: 630px">
                <div style="display: flex">
                    <div style="width: 50%">
                        <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                    </div>
                </div>
                <div style="height: 490px;background: white" >
                    <div style="width: 100%;display: block;margin-top: 10px">
                        <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px;font-weight: bold">R&D Ô TÔ</h6>
                        <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">KCN THACO Chu Lai, Xã: Tam Hiệp,</h6>
                        <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">Huyện: Núi Thành, Tỉnh: Quảng Nam</h6>
                    </div>
                    <h6 style="margin: auto;text-align: center;margin-top: 20px;font-family: Tahoma;font-size: 25px;font-weight: bold;margin-bottom: 20px">GIẤY RA CỔNG</h6>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Họ và tên</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbname" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Đơn vị</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbldept" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Lý do ra cổng</label>
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
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Giờ ra</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbltimeout" style="width: 100%;font-size: 15px;font-family: Tahoma">.......h.......</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Giờ vào</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbltimein" style="width: 100%;font-size: 15px;font-family: Tahoma">.......h........</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 150px;font-size: 14px;font-family: Tahoma">Ghi chú:</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblnote" style="width: 100%;font-size: 15px;font-family: Tahoma">.......h........</label>
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
                            <h6 style="text-align: center;font-size: 15px;font-family: Tahoma">LÃNH ĐẠO CÔNG TY</h6>
                        </div>
                        <div style="width: 50%">
                            <h6 style="text-align: center;font-size: 15px;font-family: Tahoma">PHỤ TRÁCH BỘ PHẬN</h6>
                        </div>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <div style="width: 50%">
                        <textarea  id="idapprovenote" style= "color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="appsign" style="background: white;margin: auto;text-align: center;">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('idapprovenote').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0011';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('idapprovenote').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0011';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                            </div>
                            <div id="Appsigned" style="display: none">
                                <img id="imappdeny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                                <img id="imappapp" src="images/APPROVE.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                            </div>
                            <h6 id="lblapprove" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                            <h7 id="lbappnote" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                        </div>
                        <div style="width: 50%">
                            <textarea  id="ipchecknote" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="checksign" style="background: white;margin: auto;text-align: center">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipchecknote').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0011';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipchecknote').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0011';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                            </div>
                            <div id="signed" style="display: none">
                                <img id="imcheckdeny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                                <img id="imcheckapp" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                            </div>
                            <h6 id="lblcheck" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                            <h7 id="lbchecknote" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="btndownload" style="display: none;z-index: 4;width: 100%;height: 83%;position:fixed;left:0;top:0;overflow:auto;background-color: transparent;margin-top: 120px">
        <button id="btnExport" onclick="PrintDiv();" type="button" class="btn btn-outline-primary" style="height: 50px;width: 150px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 0;right: 0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg> In phiếu</button>
    </div>
</form>
</body>
</html>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script>
    $(document).ready(function (){
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const result = urlParams.get('id');
        ajax(result);
    });
    function ajax(result){
        $.ajax({
            url:'callgrc.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                    console.log(result);
                    swal.fire('Thông báo','Phiếu không tồn tại','error').then((result) => {document.getElementById('review').style.display = 'none';});
                }
                else
                {
                    console.log(result.result);
                    document.getElementById('lbname').innerText=result.result['FullName'];
                    document.getElementById('lbldept').innerText=result.result['NameDept'];
                    document.getElementById('lblreason').innerText = result.result['Reason'];
                    document.getElementById('lblbring').innerText=result.result['Bring'];
                    document.getElementById('lbllicence').innerText = result.result['LicensePlates'];
                    document.getElementById('lblnote').innerText = result.result['Note'];
                    document.getElementById('lbltimeout').innerText = result.result['TimeStampOut'];
                    if(result.result['TimeStampIn']=='00:00:00 00/00/0000')
                        document.getElementById('lbltimein').innerText="Không vào lại";
                    else
                        document.getElementById('lbltimein').innerText = result.result['TimeStampIn'];
                    document.getElementById('lblcheck').innerText=result.result['Check']['FullName'];
                    document.getElementById('lblcheck').value=result.result['Check']['IDMember'];
                    document.getElementById('lblapprove').innerText=result.result['Approve']['FullName'];
                    document.getElementById('lblapprove').value=result.result['Approve']['IDMember'];
                    var idmember = "<?php echo $idmember?>";
                    if(result.result['Checked'][1]==1)
                    {
                        document.getElementById('ipchecknote').style.display='none';
                        document.getElementById('checksign').style.display='none';
                        document.getElementById('signed').style.display='block';
                        if(result.result['Checked'][2]==1) {
                            document.getElementById('imcheckdeny').style.display='block';
                            document.getElementById('lbchecknote').style.color='red';
                        }
                        else {
                            document.getElementById('imcheckapp').style.display = 'block';

                        }
                        document.getElementById('lbchecknote').innerText = result.result['Checked'][3];

                    }
                    else
                    {
                        if(idmember == result.result['Check']['IDMember'])
                        {
                            document.getElementById('ipchecknote').style.display='block';
                            document.getElementById('checksign').style.display='block';
                            document.getElementById('signed').style.display='none';
                        }
                        else
                        {
                            document.getElementById('ipchecknote').style.display='none';
                            document.getElementById('checksign').style.display='none';
                            document.getElementById('signed').style.display='none';
                        }
                    }
                    if(result.result['Checked'][1]==1)
                    {
                        if(result.result['Approved'][1]==1)
                        {
                            document.getElementById('idapprovenote').style.display = 'none';
                            document.getElementById('appsign').style.display = 'none';
                            document.getElementById('Appsigned').style.display = 'block';
                            if (result.result['Approved'][2] == 1) {
                                document.getElementById('imappdeny').style.display = 'block';
                                document.getElementById('lbappnote').style.color = 'red';
                            } else {
                                document.getElementById('imappapp').style.display = 'block';
                                document.getElementById('btndownload').style.display = 'block';
                            }
                            document.getElementById('lbappnote').innerText = result.result['Approved'][3];
                        }
                        else
                        {
                            if(idmember == result.result['Approve']['IDMember'])
                            {
                                if(result.result['Checked'][2]==1)
                                {
                                    document.getElementById('idapprovenote').style.display='none';
                                    document.getElementById('appsign').style.display='none';
                                    document.getElementById('Appsigned').style.display='none';
                                }
                                else {
                                    document.getElementById('idapprovenote').style.display='block';
                                    document.getElementById('appsign').style.display='block';
                                    document.getElementById('Appsigned').style.display='none';
                                }

                            }
                            else
                            {
                                document.getElementById('idapprovenote').style.display='none';
                                document.getElementById('appsign').style.display='none';
                                document.getElementById('Appsigned').style.display='none';
                            }
                        }
                    }
                    else
                    {
                        document.getElementById('idapprovenote').style.display='none';
                        document.getElementById('appsign').style.display='none';
                        document.getElementById('Appsigned').style.display='none';
                    }
                }
            },
            error:function(error){
                console.log(error.responseText);
                swal.fire('Thông báo','Phiếu không tồn tại','error').then((result) => {document.getElementById('review').style.display = 'none';});
            }
        })
    };
    function Check(result)
    {
        $.ajax({
            url:'saveapprove.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                    swal.fire('Thông báo','Mã nhân viên không tồn tại','error');
                    console.log(result);
                }
                else
                {
                    console.log(result.result);
                    // window.close();
                    location.reload();
                }
            },
            error:function(error){
                swal.fire('Thông báo','Mã nhân viên không tồn tại','error');
                console.log(error.responseText);
            }
        })
    }
    function Sendmail(result){
        $.ajax({
            url:'SendMail.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                location.reload();
            },
            error:function(error){
                console.log(error.responseText);
                location.reload();
            }
        })
    }
</script>
