<?php
include "PHPMailer-master/src/PHPMailer.php";
include "PHPMailer-master/src/OAuth.php";
include "PHPMailer-master/src/POP3.php";
include "PHPMailer-master/src/SMTP.php";
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
if(isset($_POST['result'])){
    $value = $_POST['result'];
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
    $mail->Port = 587;
    //Recipients
    $mail->setFrom('rdauto.info@thaco.com.vn', 'Phần mềm chữ ký điện tử');
    $mail->addAddress(Getmail($value['idcheck']));     // Add a recipient
    //Content
    $mail->isHTML(true);
    $mail->Subject = $value['subject'];
    {
        $message = ' 
    <html> 
    <body style="font-size: 14px;font-family: Times New Roman;"> 
        <h5>Kính gửi Anh/Chị !</h5> 
        <table style="width: 100%; font-size: 14px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Anh/Chị có yêu cầu cần được phê duyệt từ phần mềm chữ ký điện tử</td> 
            </tr>     
            <tr style=""> 
                <td>Thông tin chi tiết:</td> 
            </tr> 
            <tr style=""> 
                <td>* Loại phiếu: <b>'.$value['file']['namefile'].'</b></td> 
            </tr>
            <tr style=""> 
                <td>* Mã phiếu: <b>'.$value['file']['id'].'</b></td> 
            </tr>
            <tr style=""> 
                <td>* Người gửi: <b>'.$value['file']['member'].'</b></td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="';
        $message .= $value['link'];
        $message .= '">';
        $message .=  "Vui lòng bấm vào đây để xem chi tiết";
        $message .= '</a></td> 
            </tr>
            <br/>
            <br/>
            <br/>
            <tr style="color: red;font-style: italic;"> 
                <td>Đây là mail tự động, vui lòng không trả lời mail này.</td> 
            </tr> 
            <tr> 
            <td>Trân trọng cảm ơn.</td> 
            <p style="font-size: 16px;margin:0px">THACO AUTO</p>
            </tr> 
        </table> 
        <br/>
    </body> 
    </html>';
    }
    $mail->Body = $message;
    if(Getmail($value['idcheck']) !="")
        $mail->send();
    echo json_encode(['result'=>"OK",'code'=>200]);
}
else
    echo json_encode(['code'=>201]);