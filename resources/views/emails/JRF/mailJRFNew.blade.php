<!-- resources/views/emails/leave_form.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-size: 14px; font-family: 'Times New Roman';">
    <h5>Kính gửi Anh/chị!</h5>
    <table style="width: 100%; font-size: 14px; font-family: 'Times New Roman';">
        <p>{!! $name !!}</p>
        <tr>
            <td>Thông tin chi tiết:</td>
        </tr>
        <tr>
            <td>* Loại phiếu: <b>Phiếu yêu cầu</b></td>
        </tr>
        <tr>
            <td>* Mã phiếu: <b>{{ $code }}</b></td>
        </tr>
        <tr>
            <td>* Người gửi: <b>{{ $userCreatedJSF->FullName }}</b></td>
        </tr>
        <tr>
            <td>* Phòng ban: <b>{{ $userCreatedJSF->department->NameDept }}</b></td>
        </tr>
        <tr style="font-style: italic;">
            <td><a href="{{ route('checkRequestForms', $code) }}">Vui lòng bấm vào đây để xem chi tiết</a></td>
        </tr>
        <br/><br/><br/>
        <tr style="color: red; font-style: italic;">
            <td>Đây là mail tự động, vui lòng không trả lời mail này.</td>
        </tr>
    </table>
    <br/>
    <tr>
        <td>
            <strong>Nhóm Công Nghệ Thông Tin</strong><br>
            Phòng Quản trị dữ liệu<br>
            <strong>THACO AUTO - TRUNG TÂM R&D Ô TÔ</strong><br>
            Khu công nghiệp Tam Hiệp, Huyện Núi Thành, Tỉnh Quảng Nam, Việt Nam<br>
            Email: <a href="mailto:rd-cntt@thaco.com.vn">rd-cntt@thaco.com.vn</a><br>
            Tiêu chuẩn Kỹ thuật Thaco Auto<br>
        </td>
    </tr>
</body>
</html>
