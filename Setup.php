<?php
session_start();
$username = $_SESSION['Name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./images/LOGO%20THACO%20AUTO.png">
    <title>
        THACO AUTO
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <?php include 'Library/librarycss.php'?>
</head>

<body class="g-sidenav-show bg-gray-200">
    <?php include('Library/menu.php') ?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <h6 class="font-weight-bolder mb-0">Quản lý thông tin</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="../RD/Main.php" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none" style="font-family: Tahoma"><?php echo $username?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize"  style="font-family: Tahoma">Tổng nhân sự</p>
                            <h4 id="allmember" class="mb-0">500</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize" style="font-family: Tahoma">Nhân sự hôm nay</p>
                            <h4 id="workmember" class="mb-0">480</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize" style="font-family: Tahoma">Số lượng tăng ca</p>
                            <h4 id="workmember2" class="mb-0">3,462</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize" style="font-family: Tahoma">Vắng</p>
                            <h4 id="memberout" class="mb-0">150</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-7 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6 id="txtmember">Báo cáo nhân sự đi làm</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary" style="width: 30px"></i>
                                    </a>
                                    <ul id="ultime2" class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="tbthead" class="table align-items-center mb-0 border">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Tên bộ phận</th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tổng số NS</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân sự hiện diện</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân sự vắng</th>
                                </tr>
                                </thead>
                                <tbody id="tbmember">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6 id="txteating">Thông tin suất ăn trưa</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end">
                                    <a class="cursor-pointer text-center" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary" style="width: 30px"></i>
                                    </a>
                                    <ul id="ultime" class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0 border">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Tên món ăn</th>
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Số lượng</th>
                                </tr>
                                </thead>
                                <tbody id="tbeatingday">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Cài đặt nhà ăn</h5>
                <p>Cài đặt món ăn tại nhà ăn.</p>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="material-icons">clear</i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body" style="max-height: 360px">
            <!-- Sidebar Backgrounds -->
            <div>
                <h6 class="mb-0">Cài đặt làn ăn</h6>
            </div>
            <div class="form-group d-flex">
                <h6 class="m-1 font-weight-bold text-center align-content-center align-items-center" style="line-height: 30px">Giờ ăn</h6>
                <select id="sltime" class="dropdown-toggle w-60"><option>A</option></select>
                <button id=btnsettime class="align-items-center align-content-center text-center ml-2 w-10"><span class='bi bi-clock'></span></button>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã làn ăn</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên món ăn</th>
                        </tr>
                        </thead>
                        <tbody id="tbsettingline">
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Sidenav Type -->

        </div>
        <div>
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-7 col-7" s>
                        <h6>Danh sách món ăn</h6>
                    </div>
                    <div class="col-lg-5 col-5 my-auto text-end">
                        <div class="dropdown float-lg-end pe-4">
                            <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                <li><a id="btnAddEating" class="dropdown-item border-radius-md" href="javascript:;">Thêm món</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên món ăn</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                        </tr>
                        </thead>
                        <tbody id="tbeating" class="max-height-160 overflow-auto" style="display: table-caption">
                        <tr class="d-table w-100">
                            <td>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Material XD Version</h6>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="review" style="z-index:1000;display:block;padding-top:70px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);border: 1px solid black;text-align: center;">
            <section>
    <div class="loader loader-2">
      <svg class="loader-star" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
            <polygon points="29.8 0.3 22.8 21.8 0 21.8 18.5 35.2 11.5 56.7 29.8 43.4 48.2 56.7 41.2 35.1 59.6 21.8 36.8 21.8 " fill="#18ffff" />
         </svg>
      <div class="loader-circles"></div>
    </div>
  </section>
  <p style="font-size:15px;font-family: Tahoma;color:white;">Đang tải dữ liệu vui lòng chờ...</p>
        </div>
</div>
<!--   Core JS Files   -->
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="./assets/js/plugins/chartjs.min.js"></script>
<?php include 'Library/libraryscript.php' ?>
<?php include('Library/ShowNotification.php') ?>
<?php include('Library/HidenAlert.php')?>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script>
    $('#tbsettingline').on('change','select',function (){
        var tr = $(this).parent().parent().parent().children();
        var td1 = $(tr[0]).children().children()[0].innerText;
        var td2 = $(tr[1]).children().children().val();
        var time = $('#sltime').val();
        var result = {td1,td2,time};
        Applysettingline(result);
    });

    function Applysettingline(result){
        $.ajax({
            url:'Applysettingline.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                LoadSetting();
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })
    }

    $(document).ready(function (){
        LoadGoogleSheet();
        LoadTime();
        LoadvalueDashboard();
        LoadEating();
    });

    function LoadGoogleSheet(){
        var result ="A";
        $.ajax({
            url:'CallGoogle.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                var arrayitem = new Array();
				console.log(result.result)
                $.each(result.result,function(i,item){
                    if(item[0]!="" && item.length==17){
                        var work = 0;
                        if(item[4].toUpperCase()=="X")
                            work=1;
                        var idtime="1";
                        var name = item[1]
                        var idmember = item[0]
                        var ideating = 'C';
                        var timeover="";
                        var result = {idmember,name,ideating,idtime,work,timeover};
                        arrayitem.push(result);
                        
                        if(item[8].toUpperCase()=="X")
                            timeover="18h30";
                        if(item[9].toUpperCase()=="X")
                            timeover="20h45";
                        if(item[10].toUpperCase()=="X")
                            timeover="22h15";
                        if(item[11].toUpperCase()=="X")
                            timeover="24h00";
                        if(item[12].toUpperCase()=="X")
                            timeover="07h30 AM";
                        ideating = item[15];
                        if(timeover!="" && ideating!="-"){
                            idtime="2";
                            result = {idmember,name,ideating,idtime,work,timeover};
                            arrayitem.push(result);

                        if(item[11].toUpperCase()=="X"){
                            idtime="3";
                            timeover="24h00";
                            ideating = item[16];
                            result = {idmember,name,ideating,idtime,work,timeover};
                            arrayitem.push(result);
                        }
                    }
                    }
                })
                var result = arrayitem;
                $.ajax({
                url:'saveregist1.php',
                type:'post',
                dataType:'json',
                data:{
                    result:result
                },
                success:function(result){
                    console.log(result);
                    LoadvalueDashboard();
                    loadeatingday("1");
                    LoadMemberDay("1");
                    $('#review')[0].style.display = "none";
                },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
            });
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })
    }

    function LoadTime(){
        var result = 'A';
        $.ajax({
            url:'loadtimeeating.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                $('#sltime').empty();
                $('#ultime').empty();
                $('#ultime2').empty();
                $.each(result.result, function (i, item) {
                    $('#sltime').append($('<option>', {
                        value: item[0],
                        text : item[1]
                    }));
                    $('#ultime').append("<li id='"+item[0]+"' class='d-flex'><a class='dropdown-item border-radius-md' href='javascript:;' style='font-family: Tahoma' '>"+item[1]+"</a><span style='color: red;display: none'>&#10003;</span></li>");
                    $('#ultime2').append("<li id='"+item[0]+"' class='d-flex'><a class='dropdown-item border-radius-md' href='javascript:;' style='font-family: Tahoma' '>"+item[1]+"</a><span style='color: red;display: none'>&#10003;</span></li>");
                });
                LoadSetting();
                $('#ultime span')[0].style.display='block';
                $('#ultime2 span')[0].style.display='block';
                loadeatingday("1");
                LoadMemberDay("1");
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })
    }

    $('#sltime').on('change',function (){
        LoadSetting();
    })

    $('#ultime').on('click','li',function (){
        var span = $('#ultime span');
        for(var i =0;i<span.length;i++){
            span[i].style.display='none';
        }
        var li = $(this)[0].id;
        loadeatingday(li);
        LoadvalueDashboard();
        var span2 = $(this).children();
        span2[1].style.display = 'block';
        if(li=="1") {
            $('#txteating').text("Thông tin xuất ăn trưa");
        }
        else {
            $('#txteating').text("Thông tin xuất ăn tăng ca");
        }
    });
    $('#ultime2').on('click','li',function (){
        var span = $('#ultime2 span');
        for(var i =0;i<span.length;i++){
            span[i].style.display='none';
        }
        var li = $(this)[0].id;
        LoadMemberDay(li);
        LoadvalueDashboard();
        var span2 = $(this).children();
        span2[1].style.display = 'block';
        var th = $('#tbthead tr').children();
        var th2 = $($(th[2])[0]);
        var th3 = $($(th[3])[0]);
        if(li=="1") {
            th2[0].innerText = "NHÂN SỰ HIỆN DIỆN";
            th3[0].innerText = "NHÂN SỰ VẮNG";
            $('#txtmember').text("Báo cáo nhân sự đi làm");
        }
        else {
            th2[0].innerText = "NHÂN SỰ TĂNG CA";
            th3[0].innerText = "NS KHÔNG TCA";
            $('#txtmember').text("Báo cáo nhân sự tăng ca");
        }
    });
    function LoadvalueDashboard(){
        var result = "A";
        $.ajax({
            url:'LoadvalueDashboard.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                $('#allmember').text(result.result[0]);
                $('#workmember').text(result.result[1]);
                $('#workmember2').text(result.result[2]);
                $('#memberout').text(result.result[3]);
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })
    }

    $('#btnAddEating').on('click',async function (){
        const { value: result } = await Swal.fire({
            title: 'Thêm món ăn',
            input: 'text',
            inputLabel: 'Nhập tên món ăn',
            inputPlaceholder: 'Nhập tên món ăn',
            inputAttributes: {
                maxlength: 40,
                autocapitalize: 'off',
                autocorrect: 'off'
            }
        })

        if (result) {
            $.ajax({
                url:'addeating.php',
                type:'post',
                dataType:'json',
                data:{
                    result:result
                },
                success:function(result){
                    if(result.result=="OK")
                        LoadEating();
                    else swal.fire('Thông báo','Món ăn đã tồn tại!','error')
                },
                error:function(error){
                    swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                        console.log(error.responseText);
                    });
                }
            })
        }
    });

    function LoadSetting(){
        var result = $('#sltime').val();
        $.ajax({
            url:'loadsettinglane.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                $('#tbsettingline').empty();
                $.each(result.result, function (i, item) {
                    $('#tbsettingline').append(item);
                });
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>

</html>