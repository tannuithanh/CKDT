@extends('layouts.app')

@section('title', 'Phiếu yêu cầu công việc')

@section('Css')
    <link rel="stylesheet" href="{{mix('css/forms/jobRequestForm.css')}}">
@endsection

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Phiếu yêu cầu công việc</h3>
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
            <a >Tạo phiếu</a>
        </li>
        <li class="separator">
            <i class="fas fa-chevron-right"></i>
        </li>
        <li class="nav-item active">
            <a >Phiếu yêu cầu công việc</a>
        </li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Thông tin công việc</div>
        </div>
        <div class="card-body">
            <form autocomplete="off" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                        <h4 class="w-auto px-2">Thông tin nhân sự:</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="txtidmember" class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
                                <input id="txtidmember"type="text" readonly class="form-control"  value="{{$users->MSNV}}">
                            </div>
                            <div class="col-md-6">
                                <label for="txtfullname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input id="txtfullname" type="text" readonly class="form-control" value="{{ $users->FullName }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="txtdept" class="form-label">Phòng ban <span class="text-danger">*</span></label>
                                <input id="txtdept" type="text" readonly class="form-control" value="{{$users->department->NameDept}}">
                            </div>
                            <div class="col-md-6">
                                <label for="txtposition" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                <input id="txtposition" type="text" readonly class="form-control" value="{{$users->PositionDetail}}">
                            </div>
                        </div>
                </div>
                <div class="form-section">
                        <h4 class="w-auto px-2">Nội dung công việc:</h4>
                        <div class="mb-3">
                            <label for="deptneed" class="form-label">Bộ phận tiếp nhận <span class="text-danger">*</span></label>
                            <select id="deptneed" class="form-control">
                                <option value="" selected disabled>Chọn bộ phận tiếp nhận</option>
                                @foreach($departmentAll as $department)
                                    <option value="{{ $department->id }}">{{ $department->NameDept }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txtNoiDungYeuCau" class="form-label">Nội dung yêu cầu <span class="text-danger">*</span></label>
                            <textarea id="txtNoiDungYeuCau" class="form-control" rows="4" style="resize: none;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="timesend" class="form-label">Thời gian hoàn thành <span class="text-danger">*</span></label>
                            <input id="timesend" type="datetime-local" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="mb-3">
                            <label for="txtnote" class="form-label">Ghi chú</label>
                            <textarea id="txtnote" class="form-control" rows="4" style="resize: none;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="ngaytao" class="form-label">Ngày tạo phiếu</label>
                            <input id="ngaytao" type="datetime-local" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                </div>
                <div class="form-section">
                        <h4 class="w-auto px-2">Phê duyệt:</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="kiemtra" class="form-label">Kiểm tra</label>
                                <select id="kiemtra" class="form-control">userConsider
                                    @foreach($userConsider as $user)
                                        <option value="{{ $user->MSNV }}">{{ $user->FullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="check2" class="form-label">Xem xét</label>
                                <select id="check2" class="form-control">
                                    <option value="" selected disabled>Chọn nhân viên</option>
                                    <!-- Dữ liệu bộ phận tiếp nhận sẽ được thêm vào đây -->
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="approve" class="form-label">Phê duyệt</label>
                                <select id="approve" class="form-control">
                                    <option value="" selected disabled>Chọn nhân viên</option>
                                    <!-- Dữ liệu phê duyệt sẽ được thêm vào đây -->
                                </select>
                            </div>
                        </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" id="xemPhieu">Tạo phiếu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal review -->
<div id="print" class="align-items-center" style="margin-top: 62px;width: 100%;display: none;justify-content: center">
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

                <div style="display: flex; margin-left: 20px; margin-right: 20px; margin-top: 90px">
                    <div style="width: 25%; text-align: center;">
                        <label id="lblapprove" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                    </div>
                    <div style="width: 25%; text-align: center;">
                        <label id="lblreview" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                    </div>
                    <div style="width: 25%; text-align: center;">
                        <label id="lblcheck" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
                    </div>
                    <div style="width: 25%; text-align: center;">
                        <label id="lblcreator" style="font-size: 15px !important; font-family: Tahoma;">HO VA TEN</label>
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
<script src="{{ mix('js/forms/jobRequestForm.js') }}"></script>
@endsection
