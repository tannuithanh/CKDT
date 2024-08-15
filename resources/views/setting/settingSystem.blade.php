@extends('layouts.app')

@section('title', 'Cài đặt hệ thống')
@section('Css')
    <link rel="stylesheet" href="{{asset('css/setting/settingSystem.css')}}">
@endsection
@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Cài đặt hệ thống</h3>
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
        <a>Cài đặt hệ thống</a>
      </li>
    </ul>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <select id="filterDepartment" class="form-control">
                            <option value="">Phòng ban</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->NameDept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filterPosition" class="form-control">
                            <option value="">Chức vụ</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->NamePosition }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="nameUserAll" class="form-control">
                            <option value="">Tên Nhân sự</option>
                            @foreach($usersAll as $user)
                                <option value="{{ $user->id }}">{{ $user->FullName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="filterButton" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Danh sách nhân sự</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="height: 500px">
                <button class="btn btn-secondary" id="addUsers">
                    <span class="btn-label">
                      <i class="fa fa-plus"></i>
                    </span>
                    Thêm nhân sự
                </button>
                <table class="table-Rd">
                    <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Chức vụ</th>
                            <th scope="col">Mô tả chức vụ</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Phòng ban</th>
                            <th scope="col">Bộ phận</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Chữ ký</th>
                            <th scope="col">Admin</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="dataUsers">
                        @foreach($usersAll as $index => $user)
                        <tr>
                            <td>{{ ($usersAll->currentPage() - 1) * $usersAll->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->FullName }}</td>
                            <td>{{ $user->position->NamePosition ?? '' }}</td>
                            <td>{{ $user->PositionDetail }}</td>
                            <td>{{ $user->MailAddress }}</td>
                            <td>{{ $user->department->NameDept ?? '' }}</td>
                            <td>{{ $user->Division }}</td>
                            <td>
                                @if($user->Avatar)
                                    <img src="{{ asset($user->Avatar) }}" alt="Avatar" class="avatar">
                                @else
                                    <div class="placeholder">No Image</div>
                                @endif
                            </td>
                            <td>
                                @if($user->Signature)
                                    <img src="{{ asset($user->Signature) }}" alt="Signature" class="signature">
                                @else
                                    <div class="signature-placeholder">No Signature</div>
                                @endif
                            </td>
                            <td>{{ $user->Admin ? 'Admin' : 'Người dùng' }}</td>
                            <td>
                                <button class="action-btn btn-black edit-btn" data-id="{{ $user->id }}" title="Chỉnh sửa"><i class="fas fa-pen-square"></i></button>
                                <button class="action-btn btn-danger delete-btn" data-id="{{ $user->id }}" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="demo">
                    <ul id="paginationLinks" class="pagination pg-primary">
                        <!-- Các liên kết trang -->
                        @for ($page = 1; $page <= $usersAll->lastPage(); $page++)
                            <li class="page-item {{ $page == $usersAll->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="#" data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endfor
                    </ul>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="userId">
                    <div class="form-group">
                        <label for="fullName">Họ và tên</label>
                        <input type="text" class="form-control" id="fullName">
                    </div>
                    <div class="form-group">
                        <label for="position">Chức vụ</label>
                        <select class="form-control" id="position">
                            <option value="CEO">CEO</option>
                            <option value="CTO">CTO</option>
                            <option value="COO">COO</option>
                            <!-- Thêm các tùy chọn khác -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="positionDetail">Mô tả chức vụ</label>
                        <input type="text" class="form-control" id="positionDetail">
                    </div>
                    <div class="form-group">
                        <label for="mail">Mail</label>
                        <input type="email" class="form-control" id="mail">
                    </div>
                    <div class="form-group">
                        <label for="department">Phòng ban</label>
                        <select class="form-control" id="department">
                            <option value="Development">Development</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales">Sales</option>
                            <!-- Thêm các tùy chọn khác -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Division">Bộ phân</label>
                        <input type="Division" class="form-control" id="Division">
                    </div>
                    <div class="form-group">
                        <label for="admin">Admin</label>
                        <input type="checkbox" id="admin">
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Script')
<script src="{{ asset('js/setting/settingSystem.js') }}"></script>
@endsection
