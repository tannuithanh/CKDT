<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giấy xin phép</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Fonts and icons -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="leave-form-code" content="{{ $leaveForm->CodeLeaveForm }}">
    <style>
        .overlay-text {
            color: red;
            width: 150px;
            font-size: 12px;
            position: absolute;
            top: 80%;
            left: 53%;
            transform: translateY(-50%);
            background-color: rgb(255 255 255 / 0%);
            border-radius: 5px;
            z-index: 2;
            text-align: left;
        }
        .overlay-text2 {
            color: red;
            width: 150px;
            font-size: 12px;
            position: absolute;
            top: 80%;
            left: 28%;
            transform: translateY(-50%);
            background-color: rgb(255 255 255 / 0%);
            border-radius: 5px;
            z-index: 2;
            text-align: left;
        }
        .overlay-text3 {
            color: red;
            width: 150px;
            font-size: 12px;
            position: absolute;
            top: 88%;
            left: 54%;
            transform: translateY(-50%);
            background-color: rgb(255 255 255 / 0%);
            border-radius: 5px;
            z-index: 2;
            text-align: left;
        }
        .overlay-text4 {
            color: red;
            width: 150px;
            font-size: 12px;
            position: absolute;
            top: 88%;
            left: 21%;
            transform: translateY(-50%);
            background-color: rgb(255 255 255 / 0%);
            border-radius: 5px;
            z-index: 2;
            text-align: left;
        }
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
    <button id="btnExport" type="button" class="btn btn-outline-primary" style="z-index: 300; height: 50px;width: 150px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 25px;right: 200px">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
        </svg> In phiếu
    </button>
    <button id="btnExportPDF" type="button" class="btn btn-outline-primary" style="z-index: 300; height: 50px;width: 150px;background-color: #231F20;opacity: 0.6;position: absolute;bottom: 25px;right: 25px">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h4.5L14 4.5zM8.5 4a.5.5 0 0 1-.5-.5V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V5h-3.5a.5.5 0 0 1-.5-.5zM5.27 8.36a.5.5 0 0 0 .13.55c.02.01.07.03.14.04h.5l.3-.42-.33-.5h-.43c-.06.01-.12.03-.15.05zm1.44.12a.5.5 0 0 0-.37-.18H6a.5.5 0 0 0-.37.18L5.11 9l.52.75c.09.14.27.25.37.25h.04c.1 0 .27-.11.37-.25L7.5 9 7.11 8.5h-.4zM5.85 11.5a.5.5 0 0 0-.47.32l-.7 1.38a.5.5 0 1 0 .9.36l.7-1.38a.5.5 0 0 0-.43-.68zm2.15.5a.5.5 0 0 0-.48.32l-.38.76a.5.5 0 0 0 .91.36l.38-.76a.5.5 0 0 0-.43-.68zm2.27-1.82a.5.5 0 0 0-.13-.55c-.02-.01-.07-.03-.14-.04h-.5l-.3.42.33.5h.43c.06-.01.12-.03.15-.05zm-1.44-.12a.5.5 0 0 0 .37.18h.11c.1 0 .27-.11.37-.25L10.89 9l-.52-.75a.5.5 0 0 0-.37-.25H10c-.1 0-.27.11-.37.25L8.5 9l.39.5h.39zm-.69 3.32a.5.5 0 0 0 .48-.32l.7-1.38a.5.5 0 0 0-.9-.36l-.7 1.38a.5.5 0 0 0 .42.68zM8 9.5l.27-.36c.06-.08.12-.17.16-.26a.5.5 0 0 0-.16-.66L8 7.5a.5.5 0 0 0-.84.37l.84 1.13.84-1.13a.5.5 0 0 0-.84-.37l-.27.18.27.36z"/>
        </svg> Xuất PDF
    </button>
    <div id="print" class="align-items-center" style="margin-top: 62px;width: 100%;justify-content: center">
        <div id="review" style="z-index:99;padding-top:62px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,70%);border: 1px solid black">
            <div id="pdf" style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:900px;height: 800px">
                <div style="display: flex">
                    <div style="width: 30%">
                        <img src="{{asset('assets/img/logo.png')}}" style="width: 200px">
                    </div>
                    <div style="width: 40%">
                        <div style="width: 100%;display: block;margin-top: 10px">
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px;font-weight: bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h6>
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 16px">Độc lập - Tự do - Hạnh phúc</h6>
                            <h6 style="margin: auto;text-align: center;font-family: Tahoma;font-size: 12px;font-weight: bold">-------***-------</h6>
                        </div>
                    </div>
                </div>
                <div style="height: 700px;background: white">
                    <h6 style="margin: auto;text-align: center;margin-top: 20px;font-family: Tahoma;font-size: 25px;font-weight: bold;margin-bottom: 20px">ĐƠN XIN NGHỈ PHÉP</h6>
                    <div style="margin-bottom: 20px; font-family: Tahoma; font-size: 15px; display: flex; flex-direction: column; align-items: flex-start; margin-left: 185px;">
                        <div style="display: flex; align-items: center;">
                            <label style="margin: 0; font-weight: bold;">Kính gửi:</label>
                            <label style="margin: 0; margin-left: 5px;">- Ban lãnh đạo công ty</label>
                        </div>
                        <div style="padding-left: 74px;">
                            <label style="margin: 0;">- Quản lý trực tiếp</label>
                        </div>
                    </div>

                    <!-- Thêm khung chứa ảnh thẻ vào đây -->
                    <div style="position: absolute; right: 20px; top: 50px; width: 200px; height: 200px;">
                        <div style="border: 2px solid #fff; background-color: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; height: 100%;">
                            <img id="avatarImage" src="{{ asset($leaveForm->memberLeave->Avatar) }}" alt="Ảnh thẻ" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            <!-- ẢNH THẺ -->
                        </div>
                    </div>

                    <div style="display: flex;margin-left: 20px;margin-right: 20px">
                        <div style="display: flex;width: 50%">
                            <label style="width: 186px;font-size: 15px;font-family: Tahoma">Tôi tên là</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbname" style="width: 100%;font-size: 15px;font-family: Tahoma">  {{ $leaveForm->memberLeave->FullName }}</label>
                        </div>
                        <div style="display: flex;width: 50%">
                            <label style="width: 150px;font-size: 15px;font-family: Tahoma">MSNV</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbmsnv" style="width: 100%;font-size: 15px;font-family: Tahoma"> {{ $leaveForm->memberLeave->MSNV }}</label>
                        </div>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <div style="display: flex;width: 50%">
                            <label style="width: 186px;font-size: 15px;font-family: Tahoma">Phòng ban</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbldept" style="width: 100%;font-size: 15px;font-family: Tahoma"> {{ $leaveForm->memberLeave->department->NameDept }}</label>
                        </div>
                        <div style="display: flex;width: 50%">
                            <label style="width: 150px;font-size: 15px;font-family: Tahoma">Chức vụ</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lblposition" style="width: 100%;font-size: 15px;font-family: Tahoma"> {{ $leaveForm->memberLeave->position->NamePosition }}</label>
                        </div>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <div style="display: flex;width: 50%">
                            <label style="width: 186px;font-size: 15px;font-family: Tahoma">Bộ phận</label>
                            <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                            <label id="lbldept" style="width: 100%;font-size: 15px;font-family: Tahoma"> {{ $leaveForm->memberLeave->Division }}</label>
                        </div>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 15px;font-family: Tahoma">Nay tôi làm đơn này kính trình Ban Giám đốc cho tôi được nghỉ phép <span id="soNgayNghiPhep"></span>:</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <div style="display: flex;width: 50%;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                            <label style="width: 103px;font-size: 15px;font-family: Tahoma">+ Từ ngày</label>
                            <label style="width: 25px;font-size: 15px;font-family: Tahoma">: </label>
                            <label id="lbltimeout" style="font-size: 15px;font-family: Tahoma">
                                {{ \Carbon\Carbon::parse($leaveForm->TimeLeaveStart)->format('H:i d/m/Y') ?? '.......h.......'}}
                            </label>
                        </div>
                        <div style="display: flex;width: 50%;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                            <label style="width: 100px;font-size: 15px;font-family: Tahoma">Đến ngày</label>
                            <label style="width: 30px;font-size: 15px;font-family: Tahoma">: </label>
                            <label id="lbltimein" style="font-size: 15px;font-family: Tahoma">
                                {{ \Carbon\Carbon::parse($leaveForm->TimeLeaveEnd)->format('H:i d/m/Y') ?? '.......h.......'}}
                            </label>
                        </div>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 125px;font-size: 15px;font-family: Tahoma;margin-left: 20px;">+ Lý do</label>
                        <label style="width: 30px;font-size: 15px;font-family: Tahoma">: </label>
                        <label id="lblreason" style="width: 100%;font-size: 15px;font-family: Tahoma">{{ $leaveForm->Reason }}</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 15px;font-family: Tahoma">Tôi đã bàn giao công việc trong thời gian nghỉ phép lại cho ông (bà): </label>
                        <label id="lblmember" style="font-size: 15px;font-family: Tahoma"> {{ $leaveForm->memberreplace->FullName }}</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 15px;font-family: Tahoma">Ông(bà): </label>
                        <label id="lblmember1" style="font-size: 15px;font-family: Tahoma"> {{$leaveForm->memberreplace->FullName}}</label>
                        <label style="font-size: 15px;font-family: Tahoma;margin-left: 5px"> sẽ thay thế tôi hoàn thành tốt nhiệm vụ được giao theo quy định.</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 15px;font-family: Tahoma">Ghi chú: </label>
                        <label id="lblnote" style="font-size: 15px;font-family: Tahoma"> {{$leaveForm->Note}}</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 15px;font-family: Tahoma">Kính trình Ban lãnh đạo công ty xem xét phê duyệt.</label>
                    </div>
                    <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="font-size: 15px;font-family: Tahoma">Trân trọng!</label>
                    </div>

                     <!--Ngày tạo phiếu-->
                     <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label id="lblngaytao" style="font-size: 15px; font-family: Tahoma; position: absolute; right: 20px">
                            Núi Thành, Ngày {{ $formattedDateCreated }}
                        </label>
                    </div>
                    <!--Ngày tạo phiếu-->
                    <div style="display: flex; margin-left: 20px; margin-right: 20px; margin-top: 30px">
                        <div style="width: 33.33%; text-align: center;">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">LÃNH ĐẠO CÔNG TY</h6>
                        </div>
                        <div style="width: 33.33%; text-align: center;">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">XEM XÉT</h6>
                        </div>
                        <div style="width: 33.33%; text-align: center;">
                            <h6 style="font-size: 15px; font-family: Tahoma; margin: auto; font-weight: bold">NGƯỜI TẠO PHIẾU</h6>
                        </div>
                    </div>
                    <div style="display: flex; margin-left: 20px; margin-right: 20px; margin-top: 10px">
                        <!-- lblapprove -->
                        <div class="text-center" style="width: 33.33%;">
                            <div class="image-container">
                                @if ($showApproveButtons)
                                    <div class="approval-container">
                                        <textarea id="comments-approve" placeholder="Nhập nhận xét của bạn" class="form-control"></textarea>
                                        <div class="button-group mt-2">
                                            <button class="btn btn-success" id="approveApprove">Đồng ý</button>
                                            <button class="btn btn-danger" id="denyApprove">Từ chối</button>
                                        </div>
                                    </div>
                                @elseif ($showApproveSignature)
                                    <img src="{{ $approvelf1['Status'] == 0 ? asset('assets/img/DEN.png') : asset($approvelf1['member']['Signature']) }}" style="height: 80px; text-align: center; display: block; margin: auto;">
                                    <p class="overlay-text2">{{$approvelf1['Note']}} </p>
                                    <p class="overlay-text4"> {{ \Carbon\Carbon::parse($approvelf1['TimeStamp'])->format('d/m/Y H:i:s') ?? '.......h.......' }}</p>
                                @else
                                    <img src="" style="height: 80px; text-align: center; display: block; margin: auto;">
                                @endif
                            </div>
                            <label id="lblapprove" style="font-size: 15px !important; font-family: Tahoma;">
                                {{ $approvelf1['member']['FullName'] }}
                            </label>
                        </div>

                        <!-- lblcheck -->
                        <div class="text-center" style="width: 33.33%;">
                            <div class="image-container">
                                @if ($showCheckButtons)
                                    <div class="approval-container">
                                        <input id="comments-check" placeholder="Nhập nhận xét của bạn" class="form-control">
                                        <div class="button-group mt-2">
                                            <button class="btn btn-success" id="approveCheck">Đồng ý</button>
                                            <button class="btn btn-danger" id="denyCheck">Từ chối</button>
                                        </div>
                                    </div>
                                @elseif ($showCheckSignature)
                                    <img src="{{ $approvelf0['Status'] == 0 ? asset('assets/img/DEN.png') : asset($approvelf0['member']['Signature']) }}" style="height: 80px; text-align: center; display: block; margin: auto;">
                                    <p class="overlay-text">{{$approvelf0['Note']}} </p>
                                    <p class="overlay-text3"> {{ \Carbon\Carbon::parse($approvelf0['TimeStamp'])->format('d/m/Y H:i:s') ?? '.......h.......' }}</p>
                                @else
                                    <img src="" style="height: 80px; text-align: center; display: block; margin: auto;">
                                @endif
                            </div>
                            <label id="lblcheck" style="font-size: 15px !important; font-family: Tahoma;">
                                {{ $approvelf0['member']['FullName'] }}
                            </label>
                        </div>
                        <div style="width: 33.33%; text-align: center;">
                            <img  src="{{ asset($leaveForm->memberCreated->Signature)}}" style="height: 80px; text-align: center; display: block; margin: auto;">
                            <label id="lblcreator" style="font-size: 15px !important; font-family: Tahoma;">{{$leaveForm->memberCreated->FullName}}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/loadingView.js') }}"></script>
    <script src="{{ asset('js/forms/getLeaveForm.js') }}"></script>
</html>
