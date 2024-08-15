@extends('layouts.app')

@section('title', 'Giấy xin phép')

@section('Css')
    <link rel="stylesheet" href="{{asset('css/forms/leaveForms.css')}}">
@endsection

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Giấy xin phép</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="fas fa-chevron-right"></i>
        </li>
        <li class="nav-item">
            <a>Tạo phiếu</a>
        </li>
        <li class="separator">
            <i class="fas fa-chevron-right"></i>
        </li>
        <li class="nav-item">
            <a>Giấy xin phép</a>
        </li>
    </ul>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Thông tin nghỉ phép</div>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="form-section">
                    <h4>Thông tin nhân sự</h4>
                    <div class="row mb-3">
                        <div class="col-md-6 required">
                            <label for="employeeCode" class="form-label">Mã nhân viên</label>
                            <input type="text" class="form-control" id="employeeCode" value="{{$users->MSNV}}" name="employeeCode"
                                @if(!($users->Admin == 1 || in_array($users->IDPosition, [13, 14]))) readonly @endif>
                        </div>
                        <div class="col-md-6 required">
                            <label for="fullName" class="form-label">Họ và tên</label>
                            <input type="text" readonly class="form-control" id="fullName" value="{{$users->FullName}}" name="fullName">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 required">
                            <label for="department" class="form-label">Phòng ban</label>
                            <input type="text" readonly class="form-control" id="department" value="{{$users->department->NameDept}}" name="department">
                        </div>
                        <div class="col-md-6 required">
                            <label for="position" class="form-label">Chức vụ</label>
                            <input type="text" readonly class="form-control" id="position" value="{{$users->PositionDetail}}" name="position">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 required">
                            <label for="Division" class="form-label">Bộ phận</label>
                            <input type="text"  class="form-control" readonly id="Division" value="{{ $users->Division }}" name="Division">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4>Nội dung</h4>
                    <div class="row mb-3">
                        <div class="col-md-6 required">
                            <label for="startDate" class="form-label">Từ ngày</label>
                            <input type="datetime-local" class="form-control" id="startDate" name="startDate">
                        </div>
                        <div class="col-md-6 required">
                            <label for="endDate" class="form-label">Đến ngày</label>
                            <input type="datetime-local" class="form-control" id="endDate" name="endDate">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 required">
                            <label for="reason" class="form-label">Lý do nghỉ</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 required">
                            <label for="usersReplace" class="form-label">Nhân sự bàn giao</label>
                            <select class="form-control" id="usersReplace" name="usersReplace">
                                <option value="">Chọn nhân sự bàn giao</option>
                                @foreach($usersReplace as $user)
                                    <option value="{{ $user->id }}">{{ $user->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3 required">
                        <div class="col-md-12">
                            <label for="createdDate" class="form-label">Ngày tạo phiếu</label>
                            <input type="date" class="form-control" id="createdDate" name="createdDate">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4>Phê Duyệt</h4>
                    <div class="row mb-3">
                        <div class="col-md-6 required">
                            <label for="review" class="form-label">Xem xét</label>
                            <select class="form-control" id="review" name="review">
                                <option value="">Chọn người xem xét</option>
                                @foreach($usersConsider as $user)
                                    <option value="{{ $user->id }}">{{ $user->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="approval" class="form-label">Phê Duyệt</label>
                            <select class="form-control" id="approval" name="approval">
                                <option value="331">Phan Quỳnh Trung</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="button" class="btn btn-primary" id="createFormButton">Tạo phiếu</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- BIẾU MẪU -->
<div id="print" class="align-items-center" style="margin-top: 62px;width: 100%;display: none;justify-content: center">
    <div id="review" style="z-index:1002;padding-top:62px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,80%);border: 1px solid black">
        <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;width:900px;height: 800px">
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
                {{-- <div style="position: absolute; right: 20px; top: 50px; width: 200px; height: 200px;">
                    <div style="border: 2px solid #fff; background-color: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <img id="avatarImage" src="" alt="Ảnh thẻ" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        <!-- ẢNH THẺ -->
                    </div>
                </div> --}}

                <div style="display: flex;margin-left: 20px;margin-right: 20px">
                    <div style="display: flex;width: 50%">
                        <label style="width: 186px;font-size: 15px;font-family: Tahoma">Tôi tên là</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbname" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;width: 50%">
                        <label style="width: 150px;font-size: 15px;font-family: Tahoma">MSNV</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbmsnv" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <div style="display: flex;width: 50%">
                        <label style="width: 186px;font-size: 15px;font-family: Tahoma">Phòng ban</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbldept" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                    <div style="display: flex;width: 50%">
                        <label style="width: 150px;font-size: 15px;font-family: Tahoma">Chức vụ</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lblposition" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <div style="display: flex;width: 50%">
                        <label style="width: 186px;font-size: 15px;font-family: Tahoma">Bộ phận</label>
                        <label style="width: 30px;font-size: 14px;font-family: Tahoma">: </label>
                        <label id="lbldivision" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                    </div>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="font-size: 15px;font-family: Tahoma">Nay tôi làm đơn này kính trình Ban Giám đốc cho tôi được nghỉ phép <span id="soNgayNghiPhep"></span>:</label>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <div style="display: flex;width: 50%;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 103px;font-size: 15px;font-family: Tahoma">+ Từ ngày</label>
                        <label style="width: 25px;font-size: 15px;font-family: Tahoma">: </label>
                        <label id="lbltimeout" style="font-size: 15px;font-family: Tahoma">.......h.......</label>
                    </div>
                    <div style="display: flex;width: 50%;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                        <label style="width: 100px;font-size: 15px;font-family: Tahoma">Đến ngày</label>
                        <label style="width: 30px;font-size: 15px;font-family: Tahoma">: </label>
                        <label id="lbltimein" style="font-size: 15px;font-family: Tahoma">.......h........</label>
                    </div>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="width: 125px;font-size: 15px;font-family: Tahoma;margin-left: 20px;">+ Lý do</label>
                    <label style="width: 30px;font-size: 15px;font-family: Tahoma">: </label>
                    <label id="lblreason" style="width: 100%;font-size: 15px;font-family: Tahoma">.................</label>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="font-size: 15px;font-family: Tahoma">Tôi đã bàn giao công việc trong thời gian nghỉ phép lại cho ông (bà): </label>
                    <label id="lblmember" style="font-size: 15px;font-family: Tahoma">.................</label>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="font-size: 15px;font-family: Tahoma">Ông(bà): </label>
                    <label id="lblmember1" style="font-size: 15px;font-family: Tahoma"> .................</label>
                    <label style="font-size: 15px;font-family: Tahoma;margin-left: 5px"> sẽ thay thế tôi hoàn thành tốt nhiệm vụ được giao theo quy định.</label>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="font-size: 15px;font-family: Tahoma">Ghi chú: </label>
                    <label id="lblnote" style="font-size: 15px;font-family: Tahoma"> .................</label>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="font-size: 15px;font-family: Tahoma">Kính trình Ban lãnh đạo công ty xem xét phê duyệt.</label>
                </div>
                <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label style="font-size: 15px;font-family: Tahoma">Trân trọng!</label>
                </div>

                 <!--Ngày tạo phiếu-->
                 <div style="display: flex;margin-left: 20px;margin-right: 20px;margin-top: 10px">
                    <label id="lblngaytao" style="font-size: 15px;font-family: Tahoma;position: absolute;right: 20px"></label>
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
                <div style="display: flex; margin-left: 20px; margin-right: 20px; margin-top: 90px">
                    <div style="width: 33.33%; text-align: center;">
                        <label id="lblapprove" style="font-size: 15px !important; font-family: Tahoma;">HỌ VÀ TÊN</label>
                    </div>
                    <div style="width: 33.33%; text-align: center;">
                        <label id="lblcheck" style="font-size: 15px !important; font-family: Tahoma;">HỌ VÀ TÊN</label>
                    </div>
                    <div style="width: 33.33%; text-align: center;">
                        <label id="lblcreator" style="font-size: 15px !important; font-family: Tahoma;">HỌ VÀ TÊN</label>
                    </div>
                </div>
                <div style="background: white;margin: auto;text-align: center; margin-top: 20px;">
                    <button style="width: 150px;margin-bottom: 10px" type="button" id="taoPhieu" class="btn btn-primary">Hoàn thành</button>
                    <button style="width: 150px;margin-bottom: 10px" type="button" id="huyBo" class="btn btn-danger">Hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('Script')
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/forms/leaveForms.js') }}"></script>
@endsection
