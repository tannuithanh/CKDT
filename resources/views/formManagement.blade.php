@extends('layouts.app')

@section('title', 'Quản lý phiếu')
@section('Css')
<link rel="stylesheet" href="{{ mix('css/formManagement.css') }}" />
@endsection

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Quản lý phiếu</h3>
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
            <a>Quản lý phiếu</a>
        </li>
    </ul>
</div>

<div class="col-md-12">
    <!-- Search Card -->
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="card-title">Tìm kiếm</h4>
        </div>
        <div class="card-header">
            <button class="btn btn-primary btn-border" id="GXP">Giấy xin phép</button>
            <button class="btn btn-primary btn-border" id="PYC">Phiếu Y/C công việc</button>
            <button class="btn btn-primary btn-border">Phiếu tăng ca</button>
            <button class="btn btn-primary btn-border">Phiếu Y/C thử nghiệm</button>

            <div class="input-group mt-3 profileForms">
                @if(in_array($users->IDPosition, [6, 7, 14, 15, 1, 2, 3, 4, 5]))
                    <input type="text" name="employee_name" id="userAll" class="form-control" placeholder="Mã số nhân viên" list="employeeList">
                    <datalist id="employeeList"></datalist>
                @endif
                <select name="status" class="form-select" style="margin-left: 10px">
                    <option value="">Tình trạng</option>
                    <option value="1">Đã duyệt</option>
                    <option value="0">Đã từ chối</option>
                </select>
            </div>
            <div class="input-group mt-3 profileTime">
                <input type="date" name="start_date" class="form-control" placeholder="Từ ngày A">
                <input type="date" name="end_date" class="form-control ms-2" placeholder="Đến ngày B">
            </div>

            <div class="input-group mt-3">
                <button type="button" id="searchLeaveForms" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="card-title">Danh sách phiếu</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 500px">
                <table class="table-Rd">
                    <thead>
                        <tr>
                            <th style="text-align: center" scope="col">Stt</th>
                            <th style="text-align: center" scope="col">Mã phiếu</th>
                            <th style="text-align: center" scope="col">Người tạo</th>
                            <th style="text-align: center" scope="col">Phòng ban</th>
                            <th style="text-align: center" scope="col">Ngày tạo</th>
                            <th scope="col" style="text-align: center">Tình trạng</th>
                            <th style="text-align: center" scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="dataForms">
                        @foreach($forms as $index => $form)
                            <tr>
                                <td style="text-align: center">{{ $index + 1 }}</td>
                                <td style="text-align: center">
                                    <a href="{{ route('getLeaveForms', $form->CodeLeaveForm) }}" target="_blank">
                                        {{ $form->CodeLeaveForm }}
                                    </a>
                                </td>
                                <td style="text-align: center">{{ $form->memberCreated->FullName }}</td>
                                <td style="text-align: center">{{ $form->memberCreated->department->NameDept }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($form->DateCreated)->format('d/m/Y') }}</td>
                                <td style="text-align: center">
                                    @if($form->status == 'Đang kiểm tra')
                                        <button class="status-btn status-checking">{{ $form->status }}</button>
                                    @elseif($form->status == 'Đang chờ duyệt')
                                        <button class="status-btn status-pending">{{ $form->status }}</button>
                                    @elseif($form->status == 'Từ chối')
                                        <button class="status-btn status-rejected">{{ $form->status }}</button>
                                    @else
                                        <button class="status-btn status-approved">{{ $form->status }}</button>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    @if(isset($forms[0]['approvelfs']))
                                        @foreach($forms[0]['approvelfs'] as $approval)
                                            @if($approval['No'] == 1 && is_null($approval['Status']) && $users->id == $forms[0]['IDMemberCreated'])
                                                <button class="action-btn btn-danger delete-btn" data-id="{{ $form->id }}" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('Script')
    <script src="{{ mix('js/formManagement.js') }}"></script>
@endsection
