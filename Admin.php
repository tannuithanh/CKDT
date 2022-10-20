<?php
if(isset($_POST['login']))
{
    if($_POST['username']==null){
        $message = "Vui lòng nhập mã nhân viên!";
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
        $sql = "SELECT member.IDMember, member.FullName,dept.IDDept,dept.NameDept,position.IDPosition,position.NamePosition,position.IDGroup FROM member,dept,position,managermember WHERE managermember.IDMember = member.IDMember AND managermember.IDPosition = position.IDPosition AND  managermember.IDDept = dept.IDDept AND member.IDMember='".$u."' AND member.Pass='".$p."'AND member.AdminUser=1";
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
                $message = "Xin chào: ".$_SESSION['Name'];
                echo "<script type='text/javascript'>alert('$message');</script>";
                if(isset($_SESSION['link']))
                    header("location: ".$_SESSION['link']);
                else
                    header("Location: ../RD/Manager.php");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include('Library/librarycss.php') ?>
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter" >
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(images/BG.JPG);">
					<span class="login100-form-title-1" style="font-family: Tahoma">
						ĐĂNG NHẬP HỆ THỐNG
					</span>
            </div>

            <form action="" method="post" class="login100-form">
                <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                    <span class="label-input100" style="font-family: Tahoma">Username</span>
                    <input autofocus class="input100" type="text" name="username" placeholder="Enter username" style="font-family: Tahoma">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                    <span class="label-input100" style="font-family: Tahoma">Password</span>
                    <input autofocus class="input100" type="password" name="password" placeholder="Enter password" style="font-family: Tahoma">
                    <span class="focus-input100"></span>
                </div>
                <div class="container-login100-form-btn">
                    <input name="login" type="submit" class="login100-form-btn" value="Login" style="font-family: Tahoma">
                </div>
            </form>
            <div class="copyright">
                <span class="copyright">Copyright &copy;2022 by Quản trị CNTT</span>
            </div>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<?php include('Library/libraryscript.php') ?>
</body>
</html>
