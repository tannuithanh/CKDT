import Swal from 'sweetalert2';
$(document).ready(function(){
//Lấy thông tin user hiện tại
        $(document).on('click', '.edit-btn', function(){
            showLoading();
            var userId = $(this).data('id');
            $.ajax({
                url: "/Get-User-By-Id/" + userId,
                method: 'GET',
                success: function(response) {
                    hideLoading()
                    var user = response.user;
                    var positions = response.positions;
                    var departments = response.departments;

                    // Điền thông tin người dùng vào form
                    $('#userId').val(user.id);
                    $('#fullName').val(user.FullName);
                    $('#positionDetail').val(user.PositionDetail);
                    $('#mail').val(user.MailAddress);
                    $('#Division').val(user.Division);
                    $('#admin').prop('checked', user.Admin);

                    // Xử lý select box chức vụ
                    var positionSelect = $('#position');
                    positionSelect.empty(); // Xóa các tùy chọn cũ
                    positions.forEach(function(position) {
                        var selected = user.position && user.position.id === position.id ? 'selected' : '';
                        positionSelect.append('<option value="'+position.id+'" '+selected+'>'+position.NamePosition+'</option>');
                    });

                    // Xử lý select box phòng ban
                    var departmentSelect = $('#department');
                    departmentSelect.empty(); // Xóa các tùy chọn cũ
                    departments.forEach(function(department) {
                        var selected = user.department && user.department.id === department.id ? 'selected' : '';
                        departmentSelect.append('<option value="'+department.id+'" '+selected+'>'+department.NameDept+'</option>');
                    });

                    // Hiển thị modal
                    $('#editModal').modal('show');
                }
            });
        });

//Chỉnh sửa user
    $('#editForm').on('submit', function(e){
        e.preventDefault();
        var userId = $('#userId').val();
        var fullName = $('#fullName').val();
        var position = $('#position').val();
        var positionDetail = $('#positionDetail').val();
        var mail = $('#mail').val();
        var department = $('#department').val();
        var division = $('#Division').val();
        var admin = $('#admin').is(':checked') ? 1 : 0;

        $.ajax({
            url: "/Edit-User-By-Id",
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                userId: userId,
                fullName: fullName,
                position: position,
                positionDetail: positionDetail,
                mail: mail,
                department: department,
                admin: admin,
                division: division
            },
            success: function(response) {
                var user = response.user;

                // Hiển thị thông báo SweetAlert
                swal("Thành công!", response.success, "success");

                // Cập nhật hàng trong bảng
                var row = $('button[data-id="' + user.id + '"]').closest('tr');
                row.find('td:eq(1)').text(user.FullName);
                row.find('td:eq(2)').text(user.position ? user.position.NamePosition : '');
                row.find('td:eq(3)').text(user.PositionDetail);
                row.find('td:eq(4)').text(user.MailAddress);
                row.find('td:eq(5)').text(user.department ? user.department.NameDept : '');
                row.find('td:eq(6)').text(user.Division ?? "");
                row.find('td:eq(9)').text(user.Admin ? 'Admin' : 'Người dùng');

                $('#editModal').modal('hide');
            },
            error: function(response) {
                alert('Error: ' + response.responseJSON.message);
            }
        });
    });

});


//Tìm kiếm change
$(document).ready(function() {
    function fetchUsers() {
        var departmentId = $('#filterDepartment').val();
        var positionId = $('#filterPosition').val();

        $.ajax({
            url: '/changeSettingSystem/filterUsers',
            method: 'POST',
            data: {
                departmentId: departmentId,
                positionId: positionId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                updateUserSelect(response);
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tải danh sách người dùng:', error);
                alert('Đã xảy ra lỗi khi tải danh sách người dùng.');
            }
        });
    }

    $('#filterDepartment').on('change', function() {
        fetchUsers();
    });

    $('#filterPosition').on('change', function() {
        fetchUsers();
    });

    function updateUserSelect(users) {
        var userSelect = $('#nameUserAll');
        userSelect.empty();
        userSelect.append('<option value="">Tên Nhân sự</option>');
        users.forEach(function(user) {
            userSelect.append('<option value="' + user.id + '">' + user.FullName + '</option>');
        });
    }
});

//Tìm kiếm hiển thị dữ liệu
$(document).ready(function() {
    $('#filterButton').on('click', function() {
        showLoading();
        fetchData();
    });


    function fetchData(page = 1) {
        var departmentId = $('#filterDepartment').val();
        var positionId = $('#filterPosition').val();
        var userId = $('#nameUserAll').val();

        $.ajax({
            url: '/changeSettingSystem/get-Data-Users?page=' + page,
            method: 'POST',
            data: {
                departmentId: departmentId,
                positionId: positionId,
                userId: userId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                hideLoading();
                // Sử dụng response để lấy dữ liệu và phân trang
                var perPage = response.per_page; // Số bản ghi trên mỗi trang
                var currentPage = response.current_page; // Trang hiện tại

                updateTable(response.data, currentPage, perPage); // Truyền các tham số cần thiết
                updatePagination(response); // Cập nhật liên kết phân trang
            },
            error: function(xhr, status, error) {
                hideLoading();
                console.error('Lỗi khi tải danh sách người dùng:', error);
                alert('Đã xảy ra lỗi khi tải danh sách người dùng.');
            }
        });
    }

    function updateTable(users, currentPage, perPage) {
        var tableBody = $('#dataUsers');
        tableBody.empty();

        if (users.length === 0) {
            var noDataRow = '<tr>' +
                '<td colspan="10" class="text-center">' +
                '<i class="fas fa-box-open" style="font-size: 40px; color: #ccc;"></i>' +
                '</td>' +
                '</tr>';
            tableBody.append(noDataRow);
        } else {
            users.forEach(function(user, index) {
                var row = '<tr>' +
                    // Tính toán STT dựa trên trang hiện tại và số lượng bản ghi trên mỗi trang
                    '<td>' + ((currentPage - 1) * perPage + index + 1) + '</td>' +
                    '<td>' + user.FullName + '</td>' +
                    '<td>' + (user.position ? user.position.NamePosition : '') + '</td>' +
                    '<td>' + user.PositionDetail + '</td>' +
                    '<td>' + user.MailAddress + '</td>' +
                    '<td>' + (user.department ? user.department.NameDept : '') + '</td>' +
                    '<td>' + (user.Division ? user.Division : '') + '</td>' +
                    '<td>' + (user.Avatar ? '<img src="' + user.Avatar + '" alt="Avatar" class="avatar">' : '<div class="placeholder">No Image</div>') + '</td>' +
                    '<td>' + (user.Signature ? '<img src="' + user.Signature + '" alt="Signature" class="signature">' : '<div class="signature-placeholder">No Signature</div>') + '</td>' +
                    '<td>' + (user.Admin ? 'Admin' : 'Người dùng') + '</td>' +
                    '<td>' +
                        '<button class="action-btn btn-black edit-btn" data-id="' + user.id + '" title="Chỉnh sửa"><i class="fas fa-pen-square"></i></button>' +
                        ' ' +
                        '<button class="action-btn btn-danger delete-btn" data-id="' + user.id + '" title="Xóa"><i class="fas fa-trash-alt"></i></button>' +
                    '</td>'
                    '</tr>';
                tableBody.append(row);
            });
        }
    }


    function updatePagination(response) {
        var pagination = $('#paginationLinks');
        pagination.empty();

        if (response.last_page > 1) {
            var prevClass = response.current_page == 1 ? 'disabled' : '';
            var nextClass = response.current_page == response.last_page ? 'disabled' : '';

            pagination.append('<li class="page-item ' + prevClass + '"><a class="page-link" href="#" data-page="' + (response.current_page - 1) + '">«</a></li>');

            for (var i = 1; i <= response.last_page; i++) {
                var activeClass = response.current_page == i ? 'active' : '';
                pagination.append('<li class="page-item ' + activeClass + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
            }

            pagination.append('<li class="page-item ' + nextClass + '"><a class="page-link" href="#" data-page="' + (response.current_page + 1) + '">»</a></li>');
        }
    }

    // Xử lý click vào các link phân trang
    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        fetchData(page);
    });


});

//Xóa dữ liệu
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    var userId = $(this).data('id');

    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa người dùng này?',
        text: "Hành động này không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/delete-User-By-Id',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: userId
                },
                success: function(response) {
                    Swal.fire(
                        'Đã xóa!',
                        'Người dùng đã được xóa.',
                        'success'
                    );

                    // Xóa dòng tương ứng với người dùng trong bảng
                    $('button[data-id="' + userId + '"]').closest('tr').remove();
                },
                error: function(xhr) {
                    Swal.fire(
                        'Lỗi!',
                        'Đã xảy ra lỗi khi xóa người dùng.',
                        'error'
                    );
                }
            });
        }
    });
});
