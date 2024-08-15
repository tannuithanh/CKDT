<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Lỗi</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .error-container h1 {
            font-size: 72px;
            margin: 0;
            color: #ff6b6b;
        }

        .error-container h2 {
            font-size: 24px;
            margin: 20px 0;
            color: #333;
        }

        .error-container p {
            font-size: 18px;
            margin: 20px 0;
            color: #777;
        }

        .error-container a {
            text-decoration: none;
            color: white;
            background-color: #ff6b6b;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .error-container a:hover {
            background-color: #e55a5a;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Lỗi!</h1>
        <h2>Phiếu bạn tìm kiếm không có hoặc đã bị lỗi</h2>
        <p>Xin lỗi, chúng tôi không thể tìm thấy phiếu bạn đang tìm kiếm. Nó có thể đã bị xóa hoặc chưa từng tồn tại.</p>
        <a href="{{route('dashboard')}}">Trở về trang chủ</a>
    </div>
</body>
</html>
