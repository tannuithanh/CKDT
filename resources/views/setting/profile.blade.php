@extends('layouts.app')

@section('title', 'Thông tin người dùng')

@section('Css')
    <link rel="stylesheet" href="{{asset('css/setting/profile.css')}}">
@endsection

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Thông tin cá nhân</h3>
    <ul class="breadcrumbs mb-3">
      <li class="nav-home">
        <a href="{{route('dashboard')}}">
          <i class="fas fa-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="fas fa-chevron-right"></i>
      </li>
      <li class="nav-item">
        <a>Thông tin cá nhân</a>
      </li>
    </ul>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-avatar">
                        @if($users->Avatar)
                            <img src="{{ asset($users->Avatar)}}" alt="Avatar" class="avatar">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar" class="avatar">
                        @endif
                        <span class="edit-icon">
                            <i class="fas fa-pen"></i>
                        </span>
                    </div>
                    <h3 class="mt-3">{{ $users->FullName }}</h3>
                    <p>{{ $users->PositionDetail }}</p>

                    <!-- Form upload avatar -->
                    <form id="avatar-form" action="{{ route('profile.uploadAvatar') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" name="avatar" id="avatar" accept="image/*" onchange="$('#avatar-form').submit();">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin chi tiết</h5>
                    <p><strong>Họ và tên:</strong> {{ $users->FullName }}</p>
                    <p><strong>Mã số nhân viên:</strong> {{ $users->MSNV }}</p>
                    <p><strong>Email:</strong> {{ $users->MailAddress }}</p>
                    <p><strong>Chức vụ:</strong> {{ $users->PositionDetail }}</p>
                    <p><strong>Phòng ban:</strong> {{ $users->department->NameDept }}</p>
                    <p>
                        <strong>Bộ phận:</strong>
                        <span id="division-text">{{ $users->Division }}</span>
                        <a href="#" id="edit-division" style="margin-left: 10px; color: blue; text-decoration: underline;">
                            Chỉnh sửa
                        </a>
                    </p>

                    <div id="edit-division-group" style="display: none; margin-top: 10px;">
                        <input type="text" class="form-control" id="division-input" value="{{ $users->Division }}" style="width: auto; display: inline-block;" />
                        <button class="btn btn-success" data-id="{{ $users->id }}" id="save-division" style="margin-left: 5px;">Lưu</button>
                        <button class="btn btn-secondary" id="cancel-division" style="margin-left: 5px;">Hủy</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chữ ký số</h5>
                    <div class="signature-container">
                        <div class="signature-placeholder">
                            @if($users->Signature)
                                <img src="{{ asset($users->Signature)}}" alt="Chữ ký số">
                            @else
                                <span>Chưa có chữ ký số</span>
                            @endif
                        </div>
                        <button class="upload-btn" id="uploadSignature">Tải lên chữ ký số</button>
                        <input type="file" name="signature" id="signature-upload" class="hidden-input" accept="image/jpeg, image/png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('Script')
<script src="{{ asset('js/setting/profile.js') }}"></script>
@endsection
