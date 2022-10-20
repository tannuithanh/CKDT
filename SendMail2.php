<?php
include "PHPMailer-master/src/PHPMailer.php";
include "PHPMailer-master/src/OAuth.php";
include "PHPMailer-master/src/POP3.php";
include "PHPMailer-master/src/SMTP.php";
session_start();
$username = $_SESSION['Name'];
$idmember = $_SESSION['idmember'];
use PHPMailer\PHPMailer\PHPMailer;
function Getmail($msnv){
    $con = "";
    $v="";
    include ('Library/Connect_DB.php');
    $sql = "SELECT MailAddress FROM member WHERE IDMember='".$msnv."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v = $row['MailAddress'];
        }
    }
    return $v;
}
function GetNV($msnv){
    $con = "";
    $v="";
    include ('Library/Connect_DB.php');
    $sql = "SELECT member.FullName,dept.NameDept FROM member,managermember,dept WHERE member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND member.IDMember='".$msnv."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v = $row['FullName']." - ".$row['NameDept'];
        }
    }
    return $v;
}

if(isset($_POST['result'])) {
    $value = $_POST['result'];
    $con = "";
    include ('Library/Connect_DB.php');
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    //cài đặt mail
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.thaco.com.vn;mail.thaco.com.vn';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'rdauto.info';                 // SMTP username
    $mail->Password = '@dmin@1234';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    //kiểm tra thông tin phiếu
    $subjectmail="";
    $email ="";
    $name = "";
    $loaiphieu = "";
    $member = "";
    $flag=false;
    $sql = "SELECT managerfile.IDFuntion,funtion.NameFunction,funtion.NumberApprove,managerfile.IDMemberCreate FROM managerfile,funtion WHERE managerfile.IDFuntion = funtion.IDFunction AND managerfile.IDFile='".$value['idfile']."'";
    $query = mysqli_query($con,$sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $sql = "SELECT * FROM approve WHERE IDFile ='".$value['idfile']."' AND IDMember='".$idmember."'";
            $query2 = mysqli_query($con,$sql);
            while($row2=mysqli_fetch_array($query2)){
                if(Substr($value['idfile'],0,5)=='F0022'){
                    $sql3 = "SELECT * FROM approve WHERE IDFile ='".$value['idfile']."' AND No=2";
                    $query3 = mysqli_query($con,$sql3);
                    while($row3=mysqli_fetch_array($query3)){
                        $email1 = Getmail($row3['IDMember']);
                    }
                    $sql4 = "SELECT * FROM approve WHERE IDFile ='".$value['idfile']."' AND No=1";
                    $query4 = mysqli_query($con,$sql4);
                    while($row4=mysqli_fetch_array($query4)){
                        $email2 = Getmail($row4['IDMember']);
                    }
                }
                if($row2['No']==$row['NumberApprove']){
                    $flag=true;
                    if($value['value']==1) {
                        $subjectmail = $row['NameFunction'] . " của Anh/Chị đã được phê duyệt";
                        $email = Getmail($row['IDMemberCreate']);
                        $name = $row['NameFunction'] . " của Anh/Chị đã được <b style='color: green'>PHÊ DUYỆT</b>";
                        $loaiphieu = $row['NameFunction'];
                        $member = GetNV($row['IDMemberCreate']);
                    }
                    else {
                        $subjectmail = $row['NameFunction'] . " của Anh/Chị đã bị từ chối";
                        $email = Getmail($row['IDMemberCreate']);
                        $name = $row['NameFunction'] . " của Anh/Chị đã bị <b style='color: red'>TỪ CHỐI</b>";
                        $loaiphieu = $row['NameFunction'];
                        $member = GetNV($row['IDMemberCreate']);
                    }
                }
                else{
                    if($value['value']==1) {
                        $nonew = $row2['No']+1;
                        $sql = "SELECT * FROM approve WHERE IDFile ='".$value['idfile']."' AND No='".$nonew."'";
                        $query3 = mysqli_query($con,$sql);
                        $subjectmail = "Trình duyệt ".$row['NameFunction'];
                        while($row3=mysqli_fetch_array($query3)) {
                            $email = Getmail($row3['IDMember']);
                            $name = "Anh/Chị có yêu cầu cần được phê duyệt từ phần mềm chữ ký điện tử";
                            $loaiphieu = $row['NameFunction'];
                            $member = GetNV($row['IDMemberCreate']);
                        }
                    }
                    else {
                        $subjectmail = $row['NameFunction'] . " của Anh/Chị đã bị từ chối";
                        $email = Getmail($row['IDMemberCreate']);
                        $name = $row['NameFunction'] . " của Anh/Chị đã bị <b style='color: red'>TỪ CHỐI</b>";
                        $loaiphieu = $row['NameFunction'];
                        $member = GetNV($row['IDMemberCreate']);
                    }
                }
            }
        }
    }
//Recipients
    $message = ' 
    <html> 
    <body style="font-size: 14px;font-family: Times New Roman;"> 
        <h5>Kính gửi Anh/Chị !</h5> 
        <table style="width: 100%; font-size: 14px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>' . $name . '</td> 
            </tr>     
            <tr style=""> 
                <td>Thông tin chi tiết:</td> 
            </tr> 
            <tr style=""> 
                <td>* Loại phiếu: <b>' . $loaiphieu . '</b></td> 
            </tr>
            <tr style=""> 
                <td>* Mã phiếu: <b>' . $value['idfile'] . '</b></td> 
            </tr>
            <tr style=""> 
                <td>* Người gửi: <b>' . $member . '</b></td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.161.6.179:8089/RD/';
        $message .= $value['id'];
        $message .= ".php?id=";
        $message .= $value['idfile'];
        $message .= '">';
        $message .= "Vui lòng bấm vào đây để xem chi tiết";
        $message .= '</a></td> 
            </tr>
            <br/>
            <br/>
            <br/>
            <tr style="color: red;font-style: italic;"> 
                <td>Đây là mail tự động, vui lòng không trả lời mail này.</td> 
            </tr> 
        </table> 
        <br/>
        <tr> 
        <td>Trân trọng cảm ơn.</td> 
        <p style="font-size: 16px;margin:0px">THACO AUTO</p>
    </body> 
    </html>';
    if($mail!='') {
        $mail->setFrom('rdauto.info@thaco.com.vn', 'Phần mềm chữ ký điện tử');
        $mail->addAddress($email); 
        if($flag==true){ 
        $mail->addCC($email1);
        $mail->addCC($email2);   // Add a recipient
        }
//Content
        $mail->isHTML(true);
        $mail->Subject = $subjectmail;
        $mail->Body = $message;
        $mail->send();
        echo json_encode(['result' => "OK","ID"=>substr($value['idfile'],0,5),'flag'=>$flag,"mail2"=>$email1, 'code' => 200]);
    }
    else
        echo json_encode(['result' => "NG", 'code' => 200]);
}
else
    echo json_encode(['code'=>201]);
