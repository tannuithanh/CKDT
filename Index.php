<?php
function GetPageStart($idmember){
    $con = "";
    $v="";
    include ('Library/Connect_DB.php');
    $sql = "SELECT PageOpen FROM member WHERE IDMember='".$idmember."'";
    $query = mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
        while ($row=$query->fetch_assoc()){
            $v=$row['PageOpen'];
        }
    }
    return $v;
}
if(isset($_POST['login']))
{
    if($_POST['username']==null){
        $message = "Vui lòng nhập mã số nhân viên!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else
        $u = $_POST['username'];
    if($_POST['password']==null){
        $message = "Vui lòng nhập mật khẩu!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else
        $p = $_POST['password'];
    if(isset($p) & isset($u))
    {
        $con = "";
        include ('Library/Connect_DB.php');
        $sql = "SELECT member.IDMember, member.FullName,dept.IDDept,dept.NameDept,position.IDPosition,position.NamePosition,position.IDGroup FROM member,dept,position,managermember WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND  managermember.IDDept = dept.IDDept AND member.IDMember='".$u."' AND member.Pass='".$p."'";
        $query = mysqli_query($con,$sql);
        if(mysqli_num_rows($query)==0)
        {
            $message = "Thông tin đăng nhập không đúng!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {

            while ($row=$query->fetch_assoc()){

                session_start();
                $_SESSION['Name']=$row['FullName'];
                $_SESSION['idmember']=$row['IDMember'];
                $_SESSION['NameDept']=$row['NameDept'];
                $_SESSION['IDDept']=$row['IDDept'];
                $_SESSION['NamePosition']=$row['NamePosition'];
                $_SESSION['IDPosition']=$row['IDPosition'];
                $_SESSION['IDGroup']=$row['IDGroup'];
                if(isset($_SESSION['LinkCur']))
                    header("location: ".$_SESSION['LinkCur']);
                else{
                    if(GetPageStart($row['IDMember'])!="")
                        header(GetPageStart($row['IDMember']));
                    else
                        header("Location: ../RD/Main.php");
                }
            }
        }
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
<body class="container" data-spy="scroll" data-target=".navbar" data-offset="50">
<form method="post" autocomplete="off">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div id = "loginbanner" style="width: 100%">
        <img src="images/KIA.png" style="height: 50px">
        <div style="align-items: end;position: absolute;right: 0px;bottom: 0px;margin: 10px">
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div id = "loginbanner" style="width: 100%">
        <div style="width: 360px" class="mr-3"></div>
        <img src="images/RD3.png" style="height: 80px">
        <div style="align-items: end;position: absolute; right: 0px;bottom: 0px;margin: 10px">
        </div>
    </div>
</nav>
<div style="color: Blue" class="breadcrumb breadcrumb-item">Vui lòng đăng nhập ứng dụng:</div>
<hr>

<div id="formchangepass" style="width: max-content;
    display: none;
    z-index: 1;
    position: fixed;
    margin: auto;
    font-family: Tahoma;
    background-color: rgba(0, 0, 0, 0.4);
    right: 0;
    left: 0;">
<div>
 <div class="card">
  <div class="card-header bg-primary" style="color:white; font-weight: bold;">ĐỔI MẬT KHẨU</div>
  <div class="card-body">
    <div class="form-horizontal" >
        <p>  <label style="color: red" class="control-label">Mã số nhân viên:</label>             
             <input class="form-control" id="msnv">
        </p>
        <p> <label style="color: red" >Mật khẩu cũ:</label>            
            <input type="password" class="form-control" name="pass_old" id="pass_old"> 
        </p>
        <p> <label style="color: red" >Mật khẩu mới:</label>         
           <input type="password" class="form-control" name="pass_new1" id="pass_new1">
        </p>
        <p><label style="color: red" >Nhập lại mật khẩu mới:</label>
          <input type="password" class="form-control" name="pass_new2" id="pass_new2">
        </p>  
        <p style="margin-top: 20px; text-align: center;">
            <div class="btn btn-success" onclick="ChangePass()">Đổi mật khẩu</div>
            <div class="btn btn-danger" onclick="Close()">Đóng</div>
        </p> 
    </div> 
  </div>
</div>
</div>
</div>

<div id="loginmain" style="border: 3px solid black;background-color: white;padding: 10px; text-align:center">
    <div id ="loginmain1" class="col-12">
        <div class="input-group flex-nowrap mb-2" style="align-items: baseline">
            <i class="fa fa-user mr-1" aria-hidden="true" style="width: 20px"></i>
            <h6 class="font-weight-bold mr-2" style="color: Blue; width: 100px">Tài khoản:</h6>
            <input id="username" name="username" type="text" class="form-control" placeholder="Nhập mã số nhân viên" aria-label="Tài khoản" aria-describedby="addon-wrapping">
        </div>
        <div class="input-group flex-nowrap mb-2" style="align-items: baseline">
            <i class="fa fa-key mr-1" aria-hidden="true" style="width: 20px"></i>
            <h6 class="font-weight-bold mr-2" style="color: Blue; width: 100px">Mật khẩu:</h6>
            <input id="password" name="password" type="password" class="form-control" placeholder="Nhập mật khẩu" aria-label="Mật khẩu" aria-describedby="addon-wrapping">
        </div>
        <div class="input-group flex-nowrap mb-2" style="align-items: baseline">
            <div style="width: 120px" class="mr-3"></div>
            <button id="login" name="login" class="btn btn-success" type="submit">Đăng nhập</button>
            <div  class="btn btn-link" onclick="btnchangepass()" style="color: Blue;font-style: italic;">Đổi mật khẩu</div>
        </div>
      
    </div>
</div>
<img src="./images/PhuNu.jpg" style="margin-top:6%;width:100%;">
</form>
<!--===============================================================================================-->
<?php include('Library/libraryscript.php') ?>
<script type="text/javascript">
    $(document).ready(function (){
        //CheckBrower();
    });
    function CheckBrower(){
        var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
        console.log(isChrome)
        if(isChrome==false)
            swal.fire('Thông báo','Bạn đang dùng trình duyệt không được hỗ trợ. Một số tính năng sẽ không hoạt động hoặc khoạt động không đúng!Vui lòng sử dụng trình duyệt Chrome để có trải nghiệm tốt hơn. Xin cảm ơn','error');
    }
    function btnchangepass(){
        // alert("dsad");
        document.getElementById('formchangepass').style.display='block';
    }
    function loginsystem(){
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var resuilt = {username,password}
        Checkuser(resuilt);
        //sessionStorage.setItem("Username", "Admin");
        //window.location.href='../RD/index.php';
    }
    function Close(){
        document.getElementById('formchangepass').style.display='none';
        document.getElementById('msnv').value="";
        document.getElementById('pass_old').value="";
        document.getElementById('pass_new1').value="";
        document.getElementById('pass_new2').value="";
    }
    function ChangePass(){
        var msnv = document.getElementById('msnv').value;
        var pass_old = document.getElementById('pass_old').value;
        var pass_new1 = document.getElementById('pass_new1').value;
        var pass_new2 = document.getElementById('pass_new2').value;
        var result = {msnv,pass_old,pass_new1,pass_new2}
        if(msnv=="" || pass_old == "" || pass_new1=="" || pass_new2==""){
            swal.fire('Thông báo','Vui lòng nhập các thông tin, không được để trống','error');
        }
        if (pass_new1==pass_new2) {
            Checkpass(result);
        }
        else{
            swal.fire('Thông báo','Xác nhận mật khẩu mới bị sai. Vui lòng kiểm tra lại!','error');
        }
    }
    function Checkuser(result){
        $.ajax({
            url:'checkusername.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                if(typeof result.result =='undefined') {
                    swal.fire('Thông báo','Thông tin đăng nhập không đúng!','error');
                }
                else
                {
                    console.log(result.result);
                    if(result.result!="") {
                        sessionStorage.setItem("idmember", result.result[0]);
                        sessionStorage.setItem("Name", result.result[1]);
                        sessionStorage.setItem("NameDept", result.result[3]);
                        sessionStorage.setItem("IDDept", result.result[2]);
                        sessionStorage.setItem("NamePosition", result.result[5]);
                        sessionStorage.setItem("IDPosition", result.result[4]);
                        sessionStorage.setItem("IDGroup", result.result[6]);
                        window.location.href='../RD/index.php';
                    }
                    else
                        swal.fire('Thông báo','Thông tin đăng nhập không đúng!','error');
                }
            },
            error:function(error){
                console.log(error.responseText);
                swal.fire('Thông báo','Thông tin đăng nhập không đúng!','error');
            }
        });
    }
    function Checkpass(result){
        $.ajax({
            url:'changepass.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                console.log(result.result);
                if (result.result==="OK")
                    {
                        // location.reload();
                        swal.fire('Thông báo','Đổi mật khẩu thành công!','success');
                        Close();
                    } else{
                if (result.result==="NG")
                    {
                        swal.fire('Thông báo','Vui lòng kiểm tra lại MSNV hoặc mật khẩu','error');
                    }
}
            },
            error:function(error){
                console.log(error.responseText);
                swal.fire('Thông báo','Thông tin đăng nhập không đúng!','error');
            }
        });
    }
</script>
</body>
</html>
