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
        <div id="review" style="z-index:3;padding-top:62px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black">
            <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:90%">
                <div style="display: flex">
                    <div style="width: 200px">
                        <img src="images/LOGO%20THACO%20AUTO.png" style="width: 200px">
                        <img src="images/RD3.png" style="width: 200px">
                    </div>
                    <div style="width: 100%">
                        <div style="width: 100%;display: block;margin-top: 10px">
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px;font-weight: bold">DANH SÁCH ĐĂNG KÝ TĂNG CA</h6>
                            <!--Ngày tạo phiếu-->
                                <h6 id="lblngaytao" style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px"></h6>
                            <!--Ngày tạo phiếu-->
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">------------------***------------------</h6>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 20px;margin-right: 20px">
                    <div id="excel_area">
                        <table class="table table-bordered align-items-center table-flush" style="background: white;color: black;width: 100%;overflow-y: auto;max-height: 400px;border-collapse: collapse;border: 1px solid black">
                            <thead class="thead-light">
                            <tr style="border: 1px solid black;">
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">STT</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">MSNV</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">HỌ VÀ TÊN</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">CHỨC VỤ</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">TÊN PHÒNG</th>   
                                <th colspan="5" style="border: 1px solid black;color: black;text-align: center">GIỜ TĂNG CA</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">ĐIỂM ĐƯA ĐÓN</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">SUẤT ĂN</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">NỘI DUNG</th>
                                <th rowspan="2" style="border: 1px solid black;color: black;text-align: center">MỤC TIÊU HOÀN THÀNH</th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid black;color: black;text-align: center">18h30</th>
                                <th style="border: 1px solid black;color: black;text-align: center">20h45</th>
                                <th style="border: 1px solid black;color: black;text-align: center">22h15</th>
                                <th style="border: 1px solid black;color: black;text-align: center">23h15</th>
                                <th style="border: 1px solid black;color: black;text-align: center">Chủ nhật</th>
                            </tr>
                            </thead>
                            <tbody id="tbdata" class="customtable" style="font-family: Tahoma;font-size: 14px;background: white;overflow-y: auto;max-height: 400px">
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <p style="color: blue; font-size: 14px;font-family: Tahoma;font-weight: bold">*GHI CHÚ:</p>
                    </div>
                    <div class="row" style="display: flex;width: 100%">
                        <div class="col-3"  style="width: 25%">
                            <div class="table-responsive result">
                                <table class="table table-bordered table-hover " style="border: 1px solid black;border-collapse: collapse;background: white;color: black;font-family: Tahoma;font-size: 14px;text-align: center">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2" style="border: 1px solid black;text-align: center">TỔNG SỐ LƯỢNG ĐĂNG KÝ TĂNG CA</th>
                                    </tr>
                                    </thead>
                                    <tbody id="time_over" class="body time_over">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6"  style="width: 50%">
                            <div class="table-responsive result">
                                <table class="table table-bordered table-hover " style="border: 1px solid black;border-collapse: collapse;background: white;color: black;font-family: Tahoma;font-size: 14px; text-align: center">
                                    <thead>
                                    <tr>
                                        <th colspan="6" style="color: black;border: 1px solid black;text-align: center">TỔNG SỐ LƯỢNG ĐĂNG KÝ XE ĐƯA ĐÓN</th>
                                    </tr>
                                    <tr>
                                        <th style="color: black;border: 1px solid black">Giờ tăng ca:</th>
                                        <th style="color: black;border: 1px solid black;text-align: center">18h30</th>
                                        <th style="color: black;border: 1px solid black;text-align: center">20h45</th>
                                        <th style="color: black;border: 1px solid black;text-align: center">22h15</th>
                                        <th style="color: black;border: 1px solid black;text-align: center">23h15</th>
                                        <th style="color: black;border: 1px solid black;text-align: center">Chủ nhật</th>
                                    </tr>
                                    </thead>
                                    <tbody id="location" class="body position">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-3"  style="width: 25%">
                            <div class="table-responsive result">
                                <table class="table table-bordered table-hover " style="background: white;color: black;font-family: Tahoma;font-size: 14px; text-align: center">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2" style="border: 1px solid black;text-align: center">TỔNG SỐ LƯỢNG ĐĂNG KÝ CƠM</th>
                                    </tr>
                                    </thead>
                                    <tbody id="food" class="body food">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 30px;width: 100%">
                    <div class="col-4" style="width: 33%">
                        <h6 style="text-align: center;font-size: 15px;font-family: Tahoma; font-weight: bold">Phê duyệt</h6>
                    </div>
                    <div class="col-4" style="width: 33%">
                        <h6 style="text-align: center;font-size: 15px;font-family: Tahoma; font-weight: bold">Kiểm tra</h6>
                    </div>
                    <div class="col-4" style="width: 33%">
                        <h6 style="text-align: center;font-size: 15px;font-family: Tahoma; font-weight: bold">Người lập</h6>
                    </div>
                </div>
                <div style="height: 523px;background: white;width: 100%" >
                    <div class="row" style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px;width: 100%">
                        <div class="col-4"  style="width: 33%">
                            <textarea  id="idapprovenote" style="color:red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="appsign" style="background: white;margin: auto;text-align: center;">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('idapprovenote').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0014';
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
                                var id = 'F0014';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                            </div>
                            <div id="Appsigned" style="display: none">
                                <img id="imappdeny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                                <img id="imappapp" src="images/APPROVE.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                            </div>
                            <h6 id="lblapprove" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                            <h7 id="lbappnote" style="color:red; text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                        </div>
                        <div class="col-4" style="width: 33%">
                            <textarea id="ipcheck2note" style="color:red; width: 100%;height: 40px;border: 1px solid black;border-radius: 5px;margin-bottom: 10px"></textarea>
                            <div id="check2sign" style="background: white;margin: auto;text-align: center">
                                <button style="width: 100px;" type="button" name="btnSuccess" class="btn btn-success" onclick="
                                const queryString = window.location.search;
                                const urlParams = new URLSearchParams(queryString);
                                const idfile = urlParams.get('id');
                                var note = document.getElementById('ipcheck2note').value;
                                var value ='1';
                                var result ={idfile,note,value};
                                Check(result);
                                var id = 'F0014';
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
                                var id = 'F0014';
                                var re = {id,idfile,value,note};
                                Sendmail(re);">Từ chối</button>
                            </div>
                            <div id="signed2" style="display: none">
                                <img id="imcheck2deny" src="images/DENY.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                                <img id="imcheck2app" src="images/APPR.png" style="height: 80px;text-align: center;display: none;margin: auto"/>
                            </div>
                            <h6 id="lblcheck2" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                            <h7 id="lbcheck2note" style="color:red; text-align: center;font-size: 15px;font-family: Tahoma"></h7>
                        </div>
                        <!--Người lập phiếu tăng ca-->
                        <div class="col-4" style="width: 25%; text-align:center">
                            <img src="images/APPR.png" style="height: 80px;text-align:center">
                            <h6 id="lblcheck1" style="text-align: center;font-size: 15px;font-family: Tahoma">HỌ VÀ TÊN</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="btndownload" style="display: none;z-index: 4;width: 100%;height: 83%;position:fixed;left:0;top:0;overflow:auto;background-color: transparent;margin-top: 120px">
        <button id="btnExport" onclick="PrintDiv();" type="button" class="btn btn-outline-primary" style="height: 50px;width: 150px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 0;left: 0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
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
            url:'callptc.php',
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
                    //tải dữ liệu
                    console.log(result.result);
                    // Ngày tạo phiếu
                        document.getElementById('lblngaytao').innerText = result.result['value'][0]['ngaytao'];
                    // Ngày tạo phiếu
                    var j=0;
                    for(var i =0;i<result.result['value'].length;i++)
                    {
                        j++;
                        var countc = "";
                        if(result.result['value'][i]['18h30']=="X")
                            countc="2.0";
                        if(result.result['value'][i]['20h45']=="X")
                            countc="3.5";
                        if(result.result['value'][i]['22h15']=="X")
                            countc="5.0";
                        if(result.result['value'][i]['24h00']=="X")
                            countc="7.0";
                        if(result.result['value'][i]['ChuNhat']=="X")
                            countc="8.5";
                        $('#tbdata').append("<tr><td style='border: 1px solid black;'>"+ j +"</td><td style='border: 1px solid black;'>"+ result.result['value'][i]['IDMember'] +"</td><td style='border: 1px solid black;'>" + result.result['value'][i]['FullName'] + "</td><td style='border: 1px solid black;'>"+result.result['value'][i]['NamePosition']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['NameDept']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['18h30']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['20h45']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['22h15']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['24h00']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['ChuNhat']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['Location']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['Eating']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['PIC']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['Note']+"</td></tr>")
                    }
                    CountValue();
                    for(var i =0;i<result.result['Location'].length;i++)
                    {
                        j++;
                        $('#location').append("<tr><td style='border: 1px solid black;'>"+ result.result['Location'][i]['GroupLocation'] +"</td><td style='border: 1px solid black;'>" + result.result['Location'][i]['18h30'] + "</td><td style='border: 1px solid black;'>"+result.result['Location'][i]['20h45']+"</td><td style='border: 1px solid black;'>"+result.result['Location'][i]['22h15']+"</td><td style='border: 1px solid black;'>"+result.result['Location'][i]['24h00']+"</td><td style='border: 1px solid black;'>" + result.result['Location'][i]['ChuNhat'] + "</td></tr>")
                    }
                    for(var i =0;i<result.result['Food'].length;i++)
                    {
                        j++;
                        $('#food').append("<tr><td style='border: 1px solid black;'>"+ result.result['Food'][i]['NameEating'] +"</td><td style='border: 1px solid black;'>" + result.result['Food'][i]['Count'] + "</td></tr>")
                    }
                    // Thêm phần duyệt
                    
                    document.getElementById('lblcheck2').innerText=result.result['Check2']['FullName'];
                    document.getElementById('lblcheck2').value=result.result['Check2']['IDMember'];
                    document.getElementById('lblapprove').innerText=result.result['Approve']['FullName'];
                    document.getElementById('lblapprove').value=result.result['Approve']['IDMember'];
                    document.getElementById('lblcheck1').innerText=result.result['Check1']['FullName'];

                    var idmember = "<?php echo $idmember?>";
                    if(result.result['Checked2'][1]==1)
                    {
                        document.getElementById('ipcheck2note').style.display='none';
                        document.getElementById('check2sign').style.display='none';
                        document.getElementById('signed2').style.display='block';
                        if(result.result['Checked2'][2]==1) {
                            document.getElementById('imcheck2deny').style.display='block';
                            document.getElementById('lbcheck2note').style.color='red';
                        }
                        else
                            {
                            document.getElementById('imcheck2app').style.display='block';
                            }
                        document.getElementById('lbcheck2note').innerText = result.result['Checked2'][3];

                    }
                    else
                    {
                        if(idmember == result.result['Check2']['IDMember']) //Chú ý Check2
                        {
                            document.getElementById('ipcheck2note').style.display='block';
                            document.getElementById('check2sign').style.display='block';
                            document.getElementById('signed2').style.display='none';
                        }
                        else
                        {
                            document.getElementById('ipcheck2note').style.display='none';
                            document.getElementById('check2sign').style.display='none';
                            document.getElementById('signed2').style.display='none';
                        }
                    }
                    if(result.result['Checked2'][1]==1)
                    {
                        if(result.result['Approved'][1]==1)
                        {
                            document.getElementById('idapprovenote').style.display = 'none';
                            document.getElementById('appsign').style.display = 'none';
                            document.getElementById('Appsigned').style.display = 'block';
                            if (result.result['Approved'][2] == 1) {
                                document.getElementById('imappdeny').style.display = 'block';
                                document.getElementById('lbappnote').style.color = 'red';
                            } else 
                                {
                                    document.getElementById('imappapp').style.display = 'block';
                                    document.getElementById('btndownload').style.display = 'block';
                                }
                                document.getElementById('lbappnote').innerText = result.result['Approved'][3];
                        }
                        else
                        {
                            if(idmember == result.result['Approve']['IDMember'])
                            {
                                if(result.result['Checked2'][2]==1)
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
                    // Chú ý 1
                    else
                    {
                        document.getElementById('idapprovenote').style.display='none';
                        document.getElementById('appsign').style.display='none';
                        document.getElementById('Appsigned').style.display='none';
                    }
                    
                }
            },
            error:function(error){
                console.log(error);
                swal.fire('Thông báo','Phiếu không tồn tại','error').then((result) => {document.getElementById('review').style.display = 'none';});
            }
        })
    }
    function CountValue()
    {
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
        $('#tbdata tr td:nth-child(6)').each(function() {
            if($(this).text()) time_18h30.push($(this).text());
        });
        $('#tbdata tr td:nth-child(7)').each(function() {
            if($(this).text()) time_20h45.push($(this).text());
        });
        $('#tbdata tr td:nth-child(8)').each(function() {
            if($(this).text()) time_22h15.push($(this).text());
        });
        $('#tbdata tr td:nth-child(9)').each(function() {
            if($(this).text()) time_24h00.push($(this).text());
        });
        $('#tbdata tr td:nth-child(10)').each(function() {
            if($(this).text()) time_ChuNhat.push($(this).text());
        });
        var time_18h30_ = time_18h30.length;
        var time_20h45_ = time_20h45.length;
        var time_22h15_ = time_22h15.length;
        var time_24h00_ = time_24h00.length;
        var time_ChuNhat_ = time_ChuNhat.length;
        $('#tbdata').append("<tr><th colspan=" + 5 + " style='border: 1px solid black;'>TỔNG</th><td style='border: 1px solid black;'>" + time_18h30_ + "</td><td style='border: 1px solid black;'>" + time_20h45_ + "</td><td style='border: 1px solid black;'>" + time_22h15_ + "</td><td style='border: 1px solid black;'>" + time_24h00_ + "</td><td style='border: 1px solid black;'>" + time_ChuNhat_ + "</td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'></td></tr>");
        $('#time_over').append("" +
            "<tr>" +
            "<td style='border: 1px solid black;'>Đến 18h30</td>" +
            "<td style='border: 1px solid black;'>" + time_18h30_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td style='border: 1px solid black;'>Đến 20h45</td>" +
            "<td style='border: 1px solid black;'>" + time_20h45_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td style='border: 1px solid black;'>Đến 22h15</td>" +
            "<td style='border: 1px solid black;'>" + time_22h15_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td style='border: 1px solid black;'>Đến 23h15</td>" +
            "<td style='border: 1px solid black;'>" + time_24h00_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td style='border: 1px solid black;'>Chủ nhật</td>" +
            "<td style='border: 1px solid black;'>" + time_ChuNhat_ + "</td>" +
            "</tr>");
    }


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
                    location.reload();
                    // window.close();
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
                swal.fire('Thông báo','Gửi mail thành công','success');
                location.reload();
            },
            error:function(error){
                swal.fire('Thông báo','Gửi mail thành công','success');
                console.log(error.responseText);
                location.reload();
            }
        })
    }
</script>
