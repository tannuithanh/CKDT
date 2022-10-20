<?php
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
$namedept = $_SESSION['NameDept'];
$iddept = $_SESSION['IDDept'];
$nameposition = $_SESSION['NamePosition'];
$idposition = $_SESSION['IDPosition'];
$con="";
include ('Library/Connect_DB.php');
$sql = "SELECT * FROM eating ORDER BY IDEating ASC";
$query = mysqli_query($con, $sql);
while($row=mysqli_fetch_array($query)){
    $data[] = $row;
}
$sql = "SELECT * FROM locationcar ORDER BY IDLocation ASC";
$query = mysqli_query($con, $sql);
while($row=mysqli_fetch_array($query)){
    $data2[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>R&D Ô TÔ</title>
    <?php include ('Library/librarycss.php') ?>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50" style="background-image: url('images/KIA.JPG')">
<?php include('Library/menu.php') ?>
<form autocomplete="off" method="post" enctype="multipart/form-data">
    <div class="align-items-center" style="margin-top: 62px;width: 100%;display: flex;justify-content: center">
        <div class="card-header" id="divall" style="width: 100%">
            <div class="form-group dis-flex">
                <h6 class="m-0 font-weight-bold" style="color: #00529c;font-size: 25px;margin-left: 20px">Đăng ký món ăn</h6>
                <div class="form-group pos-absolute dis-flex" style="right: 20px">
                    <h6 class="m-0 font-weight-bold text-center align-content-center align-items-center mr-1" style="line-height: 30px">Giờ ăn</h6>
                    <select id="sltime" class="nav-link dropdown-toggle"><option>A</option></select>
                </div>
                <hr>
            </div>
            <div id="divconten" style="float: left;width: 100%" >
                <fieldset style="background: #fffcd5;margin-top: 10px">
                    <legend style="padding: 0px 5px 0px 10px;font-weight: bold ;font-family: Tahoma;font-size: 16px">Dữ liệu</legend>
                    <div id="excel_area">
                        <table id="tableshow" class="table table-bordered align-items-center table-flush table-hover" style="background: white;color: black">
                            <thead>
                            <tr>
                                <th style="color: black;text-align: center">STT</th>
                                <th style="color: black;text-align: center">HỌ VÀ TÊN</th>
                                <th style="color: black;text-align: center">MSNV</th>
                                <th style="color: black;text-align: center">CHỨC VỤ</th>
                                <th style="color: black;text-align: center">HIỆN DIỆN</th>
                                <th style="color: black;text-align: center">MÓN ĂN</th>
                                <th style="color: black;text-align: center">GHI CHÚ</th>
                            </tr>
                            </thead>
                            <tbody id="tbdata" style="font-family: Tahoma;font-size: 14px;background: white">
                            </tbody>
                        </table>
                    </div>
                </fieldset>
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
        
        loadtimeeating();
    });

    function LoadData(){
        var dept = '<?php echo $iddept?>';
        var time = $('#sltime').val();
        var result = {dept,time};
        $.ajax({
            url:'LoadCanteen1.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                console.log(result);
                if(typeof result.result =='undefined') {
                    swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                        console.log(result);
                    });
                }
                else
                {
                    $('#tbdata').empty();
                    $.each(result.result, function (i, item) {
                        var textappend = '<tr>' +
                            '<td class="align-middle text-center text-sm"><h6 class="mb-0 text-sm">'+(i+1)+'</h6></td>' +
                            '<td class="align-middle text-center text-sm"><h6 class="text-sm mb-0">'+item['FullName']+'</h6></td>' +
                            '<td class="align-middle text-center text-sm"><h6 class="text-sm mb-0">'+item['IDMember']+'</h6></td>' +
                            '<td class="align-middle text-center"><h6 class="text-sm mb-0">'+item['NamePosition']+'</h6></td>'+
                            '<td class="align-middle text-center">'+item['Work']+'</td>'+
                            '<td class="align-middle  text-center">'+item['MA']+'</td><td class="align-middle  text-center">'+item['note']+'</td>';
                        textappend+='</tr>';
                        $('#tbdata').append(textappend);
                    });
                }
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })
    }

    $('#sleating').on('change',function (){
        $('.selecteating').val($('#sleating').val());
    });

    function loadtimeeating(){
        var result ="A";
        $.ajax({
            url:'loadtimeeating.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                $('#sltime').empty();
                $.each(result.result, function (i, item) {
                    $('#sltime').append($('<option>', {
                        value: item[0],
                        text : item[1]
                    }));
                });
                LoadData();
            },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
        })

    }

    $('#btnsave1').on('click',function (){
        var table = $('#tbdata').children();
        var time = $('#sltime').val();
        for(var i =0;i<table.length;i++){
            var id = table[i].cells[1].innerText;
            var name = table[i].cells[2].innerText;
            var a1 = $.trim(table[i].cells[5].children[0].value);
            var a2 = table[i].cells[4].children[0].checked;
            var result = {id,name,a1,a2,time};
            $.ajax({
                url:'saveregist1.php',
                type:'post',
                dataType:'json',
                data:{
                    result:result
                },
                success:function(result){
                    console.log(result);
                    LoadData();
                },
            error:function(error){
                swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                    console.log(error.responseText);
                });
            }
            });
        }
        swal.fire("Thành công","Đăng ký thành công","success");
    });



    $('#sltime').on('change',function (){
        LoadData();
    });

    function ajax(result){
        $.ajax({
            url:'calldataptc.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                    console.log(result);
                    swal.fire('Thông báo','vui lòng đăng ký tại phiếu báo tăng ca','error');
                }
                else
                {
                    //tải dữ liệu
                    console.log(result.result);
                    $('#tbdata2').empty();
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
                            countc="4.0";
                        if(result.result['value'][i]['24h00']=="X")
                            countc="6.0";
                        $('#tbdata2').append("<tr><td style='border: 1px solid black;'>"+ j +"</td><td style='border: 1px solid black;'>"+ result.result['value'][i]['FullName'] +"</td><td style='border: 1px solid black;'>" + result.result['value'][i]['IDMember'] + "</td><td style='border: 1px solid black;'>"+result.result['value'][i]['NamePosition']+"</td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'>"+result.result['value'][i]['18h30']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['20h45']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['22h15']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['24h00']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['Location']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['Eating']+"</td><td style='border: 1px solid black;'>"+result.result['value'][i]['Note']+"</td></tr>")
                    }
                    CountValue();
                    $('#location').empty();
                    for(var i =0;i<result.result['Location'].length;i++)
                    {
                        j++;
                        $('#location').append("<tr><td style='border: 1px solid black;'>"+ result.result['Location'][i]['GroupLocation'] +"</td><td style='border: 1px solid black;'>" + result.result['Location'][i]['18h30'] + "</td><td style='border: 1px solid black;'>"+result.result['Location'][i]['20h45']+"</td><td style='border: 1px solid black;'>"+result.result['Location'][i]['22h15']+"</td><td style='border: 1px solid black;'>"+result.result['Location'][i]['24h00']+"</td></tr>")
                    }
                    $('#food').empty();
                    for(var i =0;i<result.result['Food'].length;i++)
                    {
                        j++;
                        $('#food').append("<tr><td style='border: 1px solid black;'>"+ result.result['Food'][i]['NameEating'] +"</td><td style='border: 1px solid black;'>" + result.result['Food'][i]['Count'] + "</td></tr>")
                    }
                }
            },
            error:function(error){
                console.log(error);
                //swal.fire('Thông báo','Phiếu không tồn tại','error').then((result) => {document.getElementById('review').style.display = 'none';});
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
            food = [],
            locationcar = [];
        $('#tbdata2 tr th:nth-child(1)').each(function() {
            total.push($(this).text());
        });
        $('#tbdata2 tr td:nth-child(6)').each(function() {
            if($(this).text()) time_18h30.push($(this).text());
        });
        $('#tbdata2 tr td:nth-child(7)').each(function() {
            if($(this).text()) time_20h45.push($(this).text());
        });
        $('#tbdata2 tr td:nth-child(8)').each(function() {
            if($(this).text()) time_22h15.push($(this).text());
        });
        $('#tbdata2 tr td:nth-child(9)').each(function() {
            if($(this).text()) time_24h00.push($(this).text());
        });
        var time_18h30_ = time_18h30.length;
        var time_20h45_ = time_20h45.length;
        var time_22h15_ = time_22h15.length;
        var time_24h00_ = time_24h00.length;
        $('#tbdata2').append("<tr><th colspan=" + 5 + " style='border: 1px solid black;'>TỔNG</th><td style='border: 1px solid black;'>" + time_18h30_ + "</td><td style='border: 1px solid black;'>" + time_20h45_ + "</td><td style='border: 1px solid black;'>" + time_22h15_ + "</td><td style='border: 1px solid black;'>" + time_24h00_ + "</td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'></td><td style='border: 1px solid black;'></td></tr>");
        $('#time_over').empty();
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
            "<td style='border: 1px solid black;'>Đến 24h00</td>" +
            "<td style='border: 1px solid black;'>" + time_24h00_ + "</td>" +
            "</tr>");
    }
</script>
