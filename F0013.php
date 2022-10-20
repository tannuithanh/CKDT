<?php
session_start();
if (isset($_SESSION['idmember'])) {
    $idmember = $_SESSION['idmember'];
    $iddept = $_SESSION['IDDept'];
    $idgroup = $_SESSION['IDgroup'];
} else {
    $CurPageURL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['LinkCur'] = $CurPageURL;
    header("Location: " . "../RD/Index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>THACO AUTO</title>
    <?php include('Library/librarycss.php') ?>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50" background="images/KIA.JPG" onload="ClockApp()">
    <?php include('Library/menu.php') ?>
    <form autocomplete="off" method="post" enctype="multipart/form-data">
        <div class="align-items-center" style="margin-top: 62px;width: 100%;display: flex;justify-content: center">
            <div id="review" style="z-index:3;padding-top:62px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
                <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:70%;min-width: 700px">
                    <div style="display: flex">
                        <div style="width: 200px">
                            <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                        </div>
                        <div style="width: 100%">

                        </div>
                    </div>
                    <div style="margin-left: 20px;margin-right: 20px">
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

                        <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                            <label id="lblngaytao" style="font-size: 15px;font-family: Tahoma;position: absolute;right: 20px"></label>
                        </div>
                        <!--Ngày tạo phiếu-->
                        
                        <div class="row" style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 30px;width: 100%">
                        <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015'   ) { ?>
                            <div class="col-3" style="width: 33%">
                                <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Phê duyệt</h6>
                            </div>
                            <div class="col-3" style="width: 33%">
                                <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận tiếp nhận</h6>
                            </div>
                           
                                <div class="col-3" style="width: 33%">
                                    <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Kiểm tra</h6>
                                </div>
                            <div class="col-3" style="width: 33%">
                                <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận yêu cầu</h6>
                            </div>
                    <?php }else{ ?>
                        <div class="col-4" style="width: 33%">
                        <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Phê duyệt</h6>
                    </div>
                    <div class="col-4" style="width: 33%">
                        <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận tiếp nhận</h6>
                    </div>
                    <div class="col-4" style="width: 33%">
                        <h6 style="text-align: center;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận yêu cầu</h6>
                    </div>
                    <?php } ?>
                    <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015'   ) { ?>
                            <div style="height: 523px;background: white;width: 100%">
                                <div class="row" style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px;min-width: 600px;width: 100%">
                                    <div class="col-3" style="width: 33%">
                                        <textarea id="idapprovenote" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                                        <div id="appsign" style="background: white;margin: auto;text-align: center;">
                                            <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('idapprovenote').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
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
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                                        </div>
                                        <div id="Appsigned" style="display: none">
                                            <img id="imappdeny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                            <img id="imappapp" src="images/APPROVE.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                        </div>
                                        <h6 id="lblapprove" style="text-align: center;font-size: 15px;font-family: Tahoma;margin-right:35px;">HỌ VÀ TÊN</h6>
                                        <h7 id="lbappnote" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                                    </div>
                                    <div class="col-3" style="width: 33%">
                                        <textarea id="ipcheck2note" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                                        <div id="check2sign" style="background: white;margin: auto;text-align: center">
                                            <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck2note').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                            <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck2note').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                                        </div>
                                        <div id="signed2" style="display: none">
                                            <img id="imcheck2deny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                            <img id="imcheck2app" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                        </div>
                                        <h6 id="lblcheck2" style="text-align: center;font-size: 15px;font-family: Tahoma;margin-right:35px;">HỌ VÀ TÊN</h6>
                                        <h7 id="lbcheck2note" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                                    </div>
                                        <div class="col-3" style="width: 25%">
                                            <textarea id="ipkiemtra" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                                            <div id="checkkiemtrasign" style="background: white;margin: auto;text-align: center">
                                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipkiemtra').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                                <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipkiemtra').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                                            </div>
                                            <div id="signedkiemtra" style="display: none">
                                                <img id="imcheckkiemtradeny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                                <img id="imcheckkiemtraapp" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                            </div>
                                            <h6 id="lblcheckkiemtra" style="text-align: center;font-size: 15px;font-family: Tahoma;margin-right:30px;">HỌ VÀ TÊN</h6>
                                            <!-- người duyệt 1 -->
                                            <h7 id="lbcheckkiemtranote" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                                        </div>
                                    <div class="col-3" style="width: 25%">
                                        <textarea id="ipcheck1note" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                                        <div id="check1sign" style="background: white;margin: auto;text-align: center">
                                            <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck1note').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                            <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck1note').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                                        </div>
                                        <div id="signed" style="display: none">
                                            <img id="imcheck1deny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                            <img id="imcheck1app" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto" />
                                        </div>
                                        <h6 id="lblcheck1" style="text-align: center;font-size: 15px;font-family: Tahoma; margin-right:40px;">HỌ VÀ TÊN</h6>
                                        <!-- người duyệt 1 -->
                                        <h7 id="lbcheck1note" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                                    </div>
                                </div>
                            </div>
                    <?php }else{ ?>
                        <div style="height: 523px;background: white;width: 100%" >
                    <div class="row" style="display: flex;margin-left: 2px;margin-right: 20px;margin-top: 10px;min-width: 600px;width: 100%">
                        <div class="col-4"  style="width: 33%">
                            <textarea id="idapprovenote" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="appsign" style="background: white;margin: auto;text-align: center;">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('idapprovenote').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
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
                                var id = 'F0013';
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
                        <div class="col-4"  style="width: 33%">
                            <textarea  id="ipcheck2note" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="check2sign" style="background: white;margin: auto;text-align: center">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck2note').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck2note').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                            </div>
                            <div id="signed2" style="display: none">
                                <img id="imcheck2deny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                                <img id="imcheck2app" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                            </div>
                            <h6 id="lblcheck2" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                            <h7 id="lbcheck2note" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                        </div>
                        <div class="col-4"  style="width: 25%">
                            <textarea  id="ipcheck1note" style="color: red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="check1sign" style="background: white;margin: auto;text-align: center">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck1note').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Đồng ý</button>
                                <button style="width: 100px;" type="button" class="btn btn-danger" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck1note').value;
                                var value ='0';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0013';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                            </div>
                            <div id="signed" style="display: none">
                                <img id="imcheck1deny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                                <img id="imcheck1app" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                            </div>
                            <h6 id="lblcheck1" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                            <!-- người duyệt 1 -->
                            <h7 id="lbcheck1note" style="color: red;text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                        </div>
                    </div>
                </div>
                <?php } ?>
                        </div>
                    </div>
                </div>
                <div id="btndownload" style="display: none;z-index: 4;width: 100%;height: 83%;position:fixed;left:0;top:0;overflow:auto;background-color: transparent;margin-top: 120px">
                    <button id="btnExport" onclick="PrintDiv();" type="button" class="btn btn-outline-primary" style="height: 50px;width: 150px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 0;right: 0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg> In phiếu</button>
                </div>
    </form>
</body>

</html>
<?php include('Library/libraryscript.php') ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php') ?>
<script>
    $(document).ready(function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const result = urlParams.get('id');
        ajax(result);
    });

    function ajax(result) {
        $.ajax({
            url: 'callpcv.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Phiếu không tồn tại', 'error').then((result) => {
                        document.getElementById('review').style.display = 'none';
                    });
                    console.log(result.result);

                } else {
                    //tải dữ liệu
                    console.log(result.result);
                    document.getElementById('lbldept1').innerText = result.result['NameDept'];
                    document.getElementById('lbldept2').innerText = result.result['DeptNeed'];
                    document.getElementById('lblconten').innerText = result.result['Content'];
                    document.getElementById('lbltime').innerText = result.result['TimeStamp'];
                    document.getElementById('lblnote').innerText = result.result['Note'];
                    // Ngày tạo phiếu
                    document.getElementById('lblngaytao').innerText = result.result['ngaytao'];
                    // Ngày tạo phiếu

                    // Thêm phần duyệt
                    document.getElementById('lblcheck1').innerText = result.result['Check1']['FullName'];
                    document.getElementById('lblcheck1').value = result.result['Check1']['IDMember'];
                    <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015'   ) { ?>
                        document.getElementById('lblcheckkiemtra').innerText = result.result['Kiemtra']['FullName'];
                        document.getElementById('lblcheckkiemtra').value = result.result['Kiemtra']['IDMember'];
                    <?php } ?>
                    document.getElementById('lblcheck2').innerText = result.result['Check2']['FullName'];
                    document.getElementById('lblcheck2').value = result.result['Check2']['IDMember'];
                    document.getElementById('lblapprove').innerText = result.result['Approve']['FullName'];
                    document.getElementById('lblapprove').value = result.result['Approve']['IDMember'];
                    var idmember = "<?php echo $idmember ?>";
                    <?php if ($iddept == 'D0002' || $iddept == 'D0010' || $iddept == 'D0015'   ) { ?>
                    if (result.result['Checked1'][1] == 1) {
                        document.getElementById('ipcheck1note').style.display = 'none';
                        document.getElementById('check1sign').style.display = 'none';
                        document.getElementById('signed').style.display = 'block';
                        if (result.result['Checked1'][2] == 1) {
                            document.getElementById('imcheck1deny').style.display = 'block';
                            document.getElementById('lbcheck1note').style.color = 'red';
                        } else
                            document.getElementById('imcheck1app').style.display = 'block';
                        document.getElementById('lbcheck1note').innerText = result.result['Checked1'][3];

                    } else {
                        if (idmember == result.result['Check1']['IDMember']) {
                            document.getElementById('ipcheck1note').style.display = 'block';
                            document.getElementById('check1sign').style.display = 'block';
                            document.getElementById('signed').style.display = 'none';
                        } else {
                            document.getElementById('ipcheck1note').style.display = 'none';
                            document.getElementById('check1sign').style.display = 'none';
                            document.getElementById('signed').style.display = 'none';
                        }
                    }
                    if (result.result['Checked1'][1] == 1) {
                        if (result.result['Kiemtraked'][1] == 1) {
                            document.getElementById('ipkiemtra').style.display = 'none';
                            document.getElementById('checkkiemtrasign').style.display = 'none';
                            document.getElementById('signedkiemtra').style.display = 'block';
                            if (result.result['Kiemtraked'][2] == 1) {
                                document.getElementById('imcheckkiemtradeny').style.display = 'block';
                                document.getElementById('lbcheckkiemtranote').style.color = 'red';
                            } else
                                document.getElementById('imcheckkiemtraapp').style.display = 'block';
                            document.getElementById('lbcheckkiemtranote').innerText = result.result['Kiemtraked'][3];
                        } else {
                            if (idmember == result.result['Kiemtra']['IDMember']) {
                                if (result.result['Kiemtraked'][2] == 1) {
                                    document.getElementById('ipkiemtra').style.display = 'none';
                                    document.getElementById('checkkiemtrasign').style.display = 'none';
                                    document.getElementById('signedkiemtra').style.display = 'none';
                                } else {
                                    document.getElementById('ipkiemtra').style.display = 'block';
                                    document.getElementById('checkkiemtrasign').style.display = 'block';
                                    document.getElementById('signedkiemtra').style.display = 'none';
                                }

                            } else {
                                document.getElementById('ipkiemtra').style.display = 'none';
                                document.getElementById('checkkiemtrasign').style.display = 'none';
                                document.getElementById('signedkiemtra').style.display = 'none';
                            }
                        }
                    } else {
                        document.getElementById('ipkiemtra').style.display = 'none';
                        document.getElementById('checkkiemtrasign').style.display = 'none';
                        document.getElementById('signedkiemtra').style.display = 'none';
                    }
                    if (result.result['Checked1'][1] == 1) {
                        if (result.result['Kiemtraked'][1] == 1) {
                            if (result.result['Checked2'][1] == 1) {
                                document.getElementById('ipcheck2note').style.display = 'none';
                                document.getElementById('check2sign').style.display = 'none';
                                document.getElementById('signed2').style.display = 'block';
                                if (result.result['Checked2'][2] == 1) {
                                    document.getElementById('imcheck2deny').style.display = 'block';
                                    document.getElementById('lbcheck2note').style.color = 'red';
                                } else
                                    document.getElementById('imcheck2app').style.display = 'block';
                                document.getElementById('lbcheck2note').innerText = result.result['Checked2'][3];
                            } else {
                                if (idmember == result.result['Check2']['IDMember']) {
                                    if (result.result['Checked2'][2] == 1) {
                                        document.getElementById('ipcheck2note').style.display = 'none';
                                        document.getElementById('check2sign').style.display = 'none';
                                        document.getElementById('signed2').style.display = 'none';
                                    } else {
                                        document.getElementById('ipcheck2note').style.display = 'block';
                                        document.getElementById('check2sign').style.display = 'block';
                                        document.getElementById('signed2').style.display = 'none';
                                    }

                                } else {
                                    document.getElementById('ipcheck2note').style.display = 'none';
                                    document.getElementById('check2sign').style.display = 'none';
                                    document.getElementById('signed2').style.display = 'none';
                                }
                            }
                        } else {
                            document.getElementById('ipcheck2note').style.display = 'none';
                            document.getElementById('check2sign').style.display = 'none';
                            document.getElementById('signed2').style.display = 'none';
                        }
                    } else {
                        document.getElementById('ipcheck2note').style.display = 'none';
                        document.getElementById('check2sign').style.display = 'none';
                        document.getElementById('signed2').style.display = 'none';
                    }

                    if (result.result['Checked1'][1] == 1) {
                        if (result.result['Kiemtraked'][1] == 1) {
                            if (result.result['Checked2'][1] == 1) {
                                if (result.result['Approved'][1] == 1) {
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
                                } else {
                                    if (idmember == result.result['Approve']['IDMember']) {
                                        if (result.result['Checked'][2] == 1) {
                                            document.getElementById('idapprovenote').style.display = 'none';
                                            document.getElementById('appsign').style.display = 'none';
                                            document.getElementById('Appsigned').style.display = 'none';
                                        } else {
                                            document.getElementById('idapprovenote').style.display = 'block';
                                            document.getElementById('appsign').style.display = 'block';
                                            document.getElementById('Appsigned').style.display = 'none';
                                        }

                                    } else {
                                        document.getElementById('idapprovenote').style.display = 'none';
                                        document.getElementById('appsign').style.display = 'none';
                                        document.getElementById('Appsigned').style.display = 'none';
                                    }
                                }
                            } else {
                                document.getElementById('idapprovenote').style.display = 'none';
                                document.getElementById('appsign').style.display = 'none';
                                document.getElementById('Appsigned').style.display = 'none';
                            }
                        } else {
                            document.getElementById('idapprovenote').style.display = 'none';
                            document.getElementById('appsign').style.display = 'none';
                            document.getElementById('Appsigned').style.display = 'none';
                        }
                    } else {
                        document.getElementById('idapprovenote').style.display = 'none';
                        document.getElementById('appsign').style.display = 'none';
                        document.getElementById('Appsigned').style.display = 'none';
                    }
                }
                <?php }else{ ?>
                    if(result.result['Checked1'][1]==1)
                    {
                        document.getElementById('ipcheck1note').style.display='none';
                        document.getElementById('check1sign').style.display='none';
                        document.getElementById('signed').style.display='block';
                        if(result.result['Checked1'][2]==1) {
                            document.getElementById('imcheck1deny').style.display='block';
                            document.getElementById('lbcheck1note').style.color='red';
                        }
                        else
                            document.getElementById('imcheck1app').style.display='block';
                        document.getElementById('lbcheck1note').innerText = result.result['Checked1'][3];

                    }
                    else
                    {
                        if(idmember == result.result['Check1']['IDMember'])
                        {
                            document.getElementById('ipcheck1note').style.display='block';
                            document.getElementById('check1sign').style.display='block';
                            document.getElementById('signed').style.display='none';
                        }
                        else
                        {
                            document.getElementById('ipcheck1note').style.display='none';
                            document.getElementById('check1sign').style.display='none';
                            document.getElementById('signed').style.display='none';
                        }
                    }
                    if(result.result['Checked1'][1]==1)
                    {
                        if(result.result['Checked2'][1]==1)
                        {
                            document.getElementById('ipcheck2note').style.display = 'none';
                            document.getElementById('check2sign').style.display = 'none';
                            document.getElementById('signed2').style.display = 'block';
                            if (result.result['Checked2'][2] == 1) {
                                document.getElementById('imcheck2deny').style.display = 'block';
                                document.getElementById('lbcheck2note').style.color = 'red';
                            } else
                                document.getElementById('imcheck2app').style.display = 'block';
                            document.getElementById('lbcheck2note').innerText = result.result['Checked2'][3];
                        }
                        else
                        {
                            if(idmember == result.result['Check2']['IDMember'])
                            {
                                if(result.result['Checked2'][2]==1)
                                {
                                    document.getElementById('ipcheck2note').style.display='none';
                                    document.getElementById('check2sign').style.display='none';
                                    document.getElementById('signed2').style.display='none';
                                }
                                else {
                                    document.getElementById('ipcheck2note').style.display='block';
                                    document.getElementById('check2sign').style.display='block';
                                    document.getElementById('signed2').style.display='none';
                                }

                            }
                            else
                            {
                                document.getElementById('ipcheck2note').style.display='none';
                                document.getElementById('check2sign').style.display='none';
                                document.getElementById('signed2').style.display='none';
                            }
                        }
                    }
                    else
                    {
                        document.getElementById('ipcheck2note').style.display='none';
                        document.getElementById('check2sign').style.display='none';
                        document.getElementById('signed2').style.display='none';
                    }
                    if(result.result['Checked1'][1]==1)
                    {
                        if(result.result['Checked2'][1]==1){
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
                    else
                    {
                        document.getElementById('idapprovenote').style.display='none';
                        document.getElementById('appsign').style.display='none';
                        document.getElementById('Appsigned').style.display='none';
                    }
                }
                <?php } ?>
            },
            error: function(error) {
                console.log(error);
                swal.fire('Thông báo', 'Phiếu không tồn tại', 'error').then((result) => {
                    document.getElementById('review').style.display = 'none';
                });
            }
        })
    }


    function Check(result) {
        $.ajax({
            url: 'saveapprove.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                if (typeof result.result == 'undefined') {
                    swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                    console.log(result);
                } else {
                    console.log(result.result);
                    // window.close();
                    location.reload();
                }
            },
            error: function(error) {
                swal.fire('Thông báo', 'Mã nhân viên không tồn tại', 'error');
                console.log(error.responseText);
            }
        })
    }

    function Sendmail(result) {
        $.ajax({
            url: 'SendMail1.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                swal.fire('Thông báo', 'Gửi mail thành công', 'success');
                location.reload();
            },
            error: function(error) {
                swal.fire('Thông báo', 'Gửi mail thành công', 'success');
                console.log(error.responseText);
                location.reload();
            }
        })
    }
</script>