<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu yêu cầu công việc</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Fonts and icons -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Bỏ thanh cuộn */
        }
        body {
            background: url("{{ asset('assets/img/BG1.jpg') }}") no-repeat center center fixed;
            background-size: cover; /* Đảm bảo hình ảnh bao phủ toàn bộ trang */
        }
         #btnExport {
            z-index: 100; /* Đảm bảo nút "In phiếu" luôn nằm trên cùng */
        }
    </style>
    <style>
        #loadingContainer {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            width: 300px;
            height: 300px;
            background-color: rgb(249 245 245 / 0%);
            border-radius: 15px;
        }

        #loadingOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(255 255 255 / 59%);
            z-index: 9998;
        }
    </style>
</head>
<body>
    <div id="loadingOverlay"></div>
    <div id="loadingContainer"></div>
    <button id="btnExport" type="button" class="btn btn-outline-primary mt-4" style="z-index: 3000; height: 50px;width: 130px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 25px;right: 175px">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
        </svg> In phiếu
    </button>
    <button id="btnExportPDF" type="button" class="btn btn-outline-primary mt-4" style="z-index: 3000; height: 50px;width: 130px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 25px;right: 25px">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h4.5L14 4.5zM8.5 4a.5.5 0 0 1-.5-.5V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V5h-3.5a.5.5 0 0 1-.5-.5zM5.27 8.36a.5.5 0 0 0 .13.55c.02.01.07.03.14.04h.5l.3-.42-.33-.5h-.43c-.06.01-.12.03-.15.05zm1.44.12a.5.5 0 0 0-.37-.18H6a.5.5 0 0 0-.37.18L5.11 9l.52.75c.09.14.27.25.37.25h.04c.1 0 .27-.11.37-.25L7.5 9 7.11 8.5h-.4zM5.85 11.5a.5.5 0 0 0-.47.32l-.7 1.38a.5.5 0 1 0 .9.36l.7-1.38a.5.5 0 0 0-.43-.68zm2.15.5a.5.5 0 0 0-.48.32l-.38.76a.5.5 0 0 0 .91.36l.38-.76a.5.5 0 0 0-.43-.68zm2.27-1.82a.5.5 0 0 0-.13-.55c-.02-.01-.07-.03-.14-.04h-.5l-.3.42.33.5h.43c.06-.01.12-.03.15-.05zm-1.44-.12a.5.5 0 0 0 .37.18h.11c.1 0 .27-.11.37-.25L10.89 9l-.52-.75a.5.5 0 0 0-.37-.25H10c-.1 0-.27.11-.37.25L8.5 9l.39.5h.39zm-.69 3.32a.5.5 0 0 0 .48-.32l.7-1.38a.5.5 0 0 0-.9-.36l-.7 1.38a.5.5 0 0 0 .42.68zM8 9.5l.27-.36c.06-.08.12-.17.16-.26a.5.5 0 0 0-.16-.66L8 7.5a.5.5 0 0 0-.84.37l.84 1.13.84-1.13a.5.5 0 0 0-.84-.37l-.27.18.27.36z"/>
        </svg> Xuất PDF
    </button>
    <div id="print" class="align-items-center" style="margin-top: 62px;width: 100%;display: block   ;justify-content: center">
        <div id="review" style="z-index:1002;padding-top:62px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,80%);border: 1px solid black">
            <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:900px;height: auto">
                <div style="display: flex">
                    <div style="width: 27%">
                        <img src="{{asset('assets/img/logo.png')}}" style="width: 200px;margin-top: 5px;">
                    </div>
                    <div style="width: 45%">
                        <div style="width: 100%;display: block;margin-top: 10px">
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px;font-weight: bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px">Độc lập - Tự do - Hạnh phúc</h6>
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">-------***-------</h6>
                        </div>
                    </div>
                </div>
                <div style="height: auto;background: white">
                    <h6 style="margin: auto;text-align: center;margin-top: 20px;font-family: Tahoma;font-size: 25px;font-weight: bold;margin-bottom: 20px">PHIẾU YÊU CẦU CÔNG VIỆC</h6>

                    <div style="margin-left: 20px;margin-right: 20px;margin-top: 20px">
                        <div style="display: flex;">
                            <label style="width: 200px;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận yêu cầu</label>
                            <label style="width: 10px;font-size: 15px;font-family: Tahoma;font-weight: bold">: </label>
                            <label id="lbldept1" style="width: calc(100% - 210px);font-size: 15px;font-family: Tahoma;font-weight: bold">.................</label>
                        </div>
                        <div style="display: flex;margin-top: 10px;">
                            <label style="width: 200px;font-size: 15px;font-family: Tahoma;font-weight: bold">Bộ phận tiếp nhận</label>
                            <label style="width: 10px;font-size: 15px;font-family: Tahoma;font-weight: bold">: </label>
                            <label id="lbldept2" style="width: calc(100% - 210px);font-size: 15px;font-family: Tahoma;font-weight: bold">.................</label>
                        </div>
                        <div style="display: flex;margin-top: 10px;">
                            <label style="width: 200px;font-size: 15px;font-family: Tahoma;font-weight: bold">Nội dung công việc</label>
                            <label style="width: 10px;font-size: 15px;font-family: Tahoma;font-weight: bold">: </label>
                        </div>
                        <div style="margin-left: 80px;margin-top: 10px;">
                            <label id="lblconten" style="font-size: 15px;font-family: Tahoma">.................</label>
                        </div>
                        <div style="display: flex;margin-top: 10px;">
                            <label style="width: 200px;font-size: 15px;font-family: Tahoma;font-weight: bold">Thời gian hoàn thành</label>
                            <label style="width: 10px;font-size: 15px;font-family: Tahoma;font-weight: bold">: </label>
                            <label id="lblDeadline" style="width: calc(100% - 210px);font-size: 15px;font-family: Tahoma">.................</label>
                        </div>
                        <div style="display: flex;margin-top: 10px;">
                            <label style="width: 200px;font-size: 15px;font-family: Tahoma;font-weight: bold">Ghi chú</label>
                            <label style="width: 10px;font-size: 15px;font-family: Tahoma;font-weight: bold">: </label>
                        </div>
                        <div style="margin-left: 80px;margin-top: 10px;">
                            <label id="lblnote" style="font-size: 15px;font-family: Tahoma">.................</label>
                        </div>
                    </div>

                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 20px">
                        <label style="font-size: 15px;font-family: Tahoma;font-weight: bold">Kính trình Ban lãnh đạo công ty xem xét phê duyệt.</label>
                    </div>

                    <!--Ngày tạo phiếu-->
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label id="lblngaytao" style="font-size: 15px;font-family: Tahoma;position: absolute;right: 20px">Núi Thành, ngày 13 tháng 07 năm 2024</label>
                    </div>
                    <!--Ngày tạo phiếu-->

                    <div style="display: flex; margin-left: 20px; margin-right: 20px; margin-top: 30px">
                        <div style="width: 25%; text-align: center;" id="approveHeader">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">PHÊ DUYỆT</h6>
                        </div>
                        <div style="width: 25%; text-align: center;" id="approveConsider">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">XEM XÉT</h6>
                        </div>
                        <div style="width: 25%; text-align: center;" id="approveCheck">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">KIỂM TRA</h6>
                        </div>
                        <div style="width: 25%; text-align: center;" id="approveCreated">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">NGƯỜI TẠO PHIẾU</h6>
                        </div>
                    </div>

                    <div style="display: flex; margin-left: 20px; margin-right: 20px;">
                        <div style="width: 25%; text-align: center; position: relative;">
                            <img id="imageApprove" src="" style="height: 80px; text-align: center; display: block; margin: auto;">
                            <p id="timeAprrove1" style="font-size:0.77rem;line-height: 0.82; margin-bottom: 0rem;color: red"></p>
                            <p id="noteApprove" style="z-index: 9999;font-size: 1rem; line-height: 1; margin-bottom: 0rem; word-break: break-word;color: red; position: absolute; top: 0; left: 50%; transform: translate(45%, 0);"></p>
                            <label id="lblapprove" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                        </div>
                        <div style="width: 25%; text-align: center; position: relative;">
                            <img id="imageReview" src="" style="height: 80px; text-align: center; display: block; margin: auto;">
                            <p id="timeAprrove2" style="font-size:0.77rem;line-height: 0.82; margin-bottom: 0rem;color: red"></p>
                            <p id="noteReview" style="z-index: 9999;font-size: 1rem; line-height: 1; margin-bottom: 0rem; word-break: break-word;color: red; position: absolute; top: 0; left: 50%; transform: translate(45%, 0);"></p>
                            <label id="lblreview" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                        </div>
                        <div style="width: 25%; text-align: center; position: relative;">
                            <img id="imageCheck" src="" style="height: 80px; text-align: center; display: block; margin: auto;">
                            <p id="timeAprrove3" style="font-size:0.77rem;line-height: 0.82; margin-bottom: 0rem;color: red"></p>
                            <p id="noteCheck" style="z-index: 9999;font-size: 1rem; line-height: 1; margin-bottom: 0rem; word-break: break-word;color: red; position: absolute; top: 0; left: 50%; transform: translate(35%, 0);"></p>
                            <label id="lblcheck" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                        </div>
                        <div style="width: 25%; text-align: center;">
                            <img id="imageCreator" src="" style="height: 80px; text-align: center; display: block; margin: auto;">
                            <p id="timeAprrove4" style="font-size:0.77rem;line-height: 0.82; margin-bottom: 0rem;color: red"></p>
                            <p id="noteCreator" style="z-index: 9999;font-size: 1rem; line-height: 1; margin-bottom: 0rem; word-break: break-word;color: red"></p>
                            <label id="lblcreator" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/loadingView.js') }}"></script>
    <script src="{{ asset('js/forms/getJobRequestForm.js') }}"></script>
</html>
