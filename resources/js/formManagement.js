import Swal from 'sweetalert2';
//Hàm định dạng dd/mm/yyy
function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // getMonth() trả về 0-11 nên cần cộng thêm 1
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

//Xóa phiếu xin phép
$(function() {
    $('.delete-btn').on('click', function() {
        var formId = $(this).data('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        var row = $(this).closest('tr'); // Lấy hàng (row) hiện tại

        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa phiếu này?',
            text: "Bạn sẽ không thể hoàn tác hành động này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/delete-GXP',
                    type: 'POST',
                    data: {
                        _token: token,
                        form_id: formId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Đã xóa!',
                                response.success,
                                'success'
                            ).then(() => {
                                // Sử dụng fade out để xóa hàng ra khỏi giao diện
                                row.fadeOut(500, function() {
                                    $(this).remove();
                                });
                            });
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                response.error,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Có lỗi xảy ra!',
                            'Vui lòng thử lại.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

//Lấy mã số nhân viên
$(function() {
    const $userInput = $('#userAll'); // Định nghĩa $userInput
    const $datalist = $('#employeeList'); // Định nghĩa $datalist

    // Định nghĩa hàm fetchUsers để lấy dữ liệu từ server
    function fetchUsers() {
        $.ajax({
            url: '/get-UsersAll-Input',
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (Array.isArray(response)) {
                    populateDatalist(response); // Truyền trực tiếp nếu response là mảng
                } else {
                    console.error('Expected an array, but got:', response);
                }
            },

            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    }

    function populateDatalist(users) {
        $datalist.empty(); // Xóa các tùy chọn cũ

        if (!Array.isArray(users)) {
            console.error('Expected an array, but got:', users);
            return; // Dừng nếu `users` không phải là mảng
        }

        users.forEach(function(user) {
            const option = $('<option></option>').val(user.MSNV).text(user.FullName); // Tạo thẻ option với MSNV là giá trị và tên là văn bản hiển thị
            $datalist.append(option); // Thêm option vào datalist
        });
    }




    // Hàm lọc danh sách khi người dùng nhập liệu
    function filterList() {
        const query = $userInput.val().toLowerCase();
        $datalist.find('option').each(function() {
            const $option = $(this);
            if ($option.val().toLowerCase().includes(query)) {
                $option.show();
            } else {
                $option.hide();
            }
        });
    }

    // Gọi hàm fetchUsers khi trang tải
    fetchUsers(); // Đảm bảo hàm fetchUsers được gọi sau khi định nghĩa

    // Gắn sự kiện oninput để lọc danh sách khi nhập liệu
    $userInput.on('input', filterList);
});

// Tìm kiếm lấy dữ liệu
$(function() {
    function fetchData(page = 1) {
        showLoading();
        const employeeName = $('#userAll').val();
        const status = $('select[name="status"]').val();
        const startDate = $('input[name="start_date"]').val();
        const endDate = $('input[name="end_date"]').val();

        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc.');
            hideLoading();
            return;
        }

        const requestData = {
            employee_name: employeeName,
            status: status,
            start_date: startDate,
            end_date: endDate,
            page: page // Thêm tham số trang vào yêu cầu AJAX
        };

        $.ajax({
            url: '/search-LeaveForm-Data',
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: requestData,
            success: function(response) {
                hideLoading();
                $('#dataForms').empty();

                if (response.data.length === 0) {
                    let noDataRow = '<tr>' +
                                    '<td colspan="10" class="text-center">' +
                                    '<i class="fas fa-box-open" style="font-size: 40px; color: #ccc;"></i>' +
                                    '<p>Không có dữ liệu</p>' +
                                    '</td>' +
                                    '</tr>';
                    $('#dataForms').append(noDataRow);
                } else {
                    response.data.forEach(function(form, index) {
                        let statusClass = '';
                        if (form.status === 'Đang kiểm tra') {
                            statusClass = 'status-checking';
                        } else if (form.status === 'Đang chờ duyệt') {
                            statusClass = 'status-pending';
                        } else if (form.status === 'Từ chối') {
                            statusClass = 'status-rejected';
                        } else {
                            statusClass = 'status-approved';
                        }

                        const newRow = `
                            <tr>
                                <td style="text-align: center">${index + 1 + (response.current_page - 1) * response.per_page}</td>
                                <td style="text-align: center">
                                    <a href="/getLeaveForms/${form.CodeLeaveForm}" target="_blank">
                                        ${form.CodeLeaveForm}
                                    </a>
                                </td>
                                <td style="text-align: center">${form.member_created.FullName}</td>
                                <td style="text-align: center">${form.member_created.department.NameDept}</td>
                                <td style="text-align: center">${new Date(form.DateCreated).toLocaleDateString('vi-VN')}</td>
                                <td style="text-align: center">
                                    <button class="status-btn ${statusClass}">${form.status}</button>
                                </td>
                                <td style="text-align: center">
                                    ${form.approvelfs && form.approvelfs[0]['No'] === 1 && form.approvelfs[0]['Status'] === null && users.id === form.IDMemberCreated ?
                                        `<button class="action-btn btn-danger delete-btn" data-id="${form.id}" title="Xóa"><i class="fas fa-trash-alt"></i></button>` : ''}
                                </td>
                            </tr>
                        `;

                        $('#dataForms').append(newRow);
                    });

                    // Cập nhật liên kết phân trang
                    $('#paginationLinks').empty();
                    for (let i = 1; i <= response.last_page; i++) {
                        $('#paginationLinks').append(
                            '<li class="page-item ' + (i == response.current_page ? 'active' : '') + '">' +
                            '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>' +
                            '</li>'
                        );
                    }
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                console.error('Error fetching search results:', error);
            }
        });
    }

    $('#searchLeaveForms').on('click', function() {
        showLoading();
        fetchData();
    });

    $(document).on('click', '#paginationLinks a', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchData(page);
    });
});

//Lấy danh sách và tìm kiếm phiếu yêu cầu công việc
$(function() {
    $('#PYC').click(function() {
        $('#searchLeaveForms').off('click');
        $('.profileForms').each(function() {
            $(this).find('input, select').prop('disabled', true); // Disable các input và select
            $(this).hide(); // Ẩn toàn bộ phần tử input-group
        });
        $('#searchLeaveForms').attr('id', 'searchJobRequestForm');
        $('#searchJobRequestForm').on('click', function() {
            // Kiểm tra giá trị ngày tháng
            const startDate = $('input[name="start_date"]').val();
            const endDate = $('input[name="end_date"]').val();

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Ngày bắt đầu không thể lớn hơn ngày kết thúc.',
                });
                return;
            }

            // Gửi yêu cầu AJAX để tìm kiếm PYC công việc
            $.ajax({
                url: '/search-JobRequestForm-Data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    hideLoading();
                    $('#dataForms').empty();

                    if (response.length === 0) {
                        let noDataRow = '<tr>' +
                                        '<td colspan="10" class="text-center">' +
                                        '<i class="fas fa-box-open" style="font-size: 40px; color: #ccc;"></i>' +
                                        '<p>Không có dữ liệu</p>' +
                                        '</td>' +
                                        '</tr>';
                        $('#dataForms').append(noDataRow);
                    } else {
                        response.forEach(function(form, index) {
                            // Áp dụng màu sắc tương ứng cho số thứ tự dựa trên trạng thái của form
                            let statusClass = '';
                            switch(form.status) {
                                case 'Đang kiểm tra':
                                    statusClass = 'status-checking';
                                    break;
                                case 'Chờ duyệt':
                                    statusClass = 'status-pending';
                                    break;
                                case 'Từ chối':
                                    statusClass = 'status-rejected';
                                    break;
                                case 'Phiếu đã được duyệt':
                                    statusClass = 'status-approved';
                                    break;
                                default:
                                    statusClass = ''; // Nếu không khớp bất kỳ trạng thái nào
                            }

                            // Xây dựng URL động dựa trên route
                            let requestUrl = `/Forms/Check-Request-Forms/${form.CodeJobRequestForms}`;

                            let newRow = `<tr>
                                <td style="text-align: center" >${index + 1}</td>
                                <td style="text-align: center">
                                    <a href="${requestUrl}" target="_blank">${form.CodeJobRequestForms}</a>
                                </td>
                                <td style="text-align: center">${form.approvejsfs.find(a => a.No === 1)?.member?.FullName || ''}</td>
                                <td style="text-align: center">${form.department_request.NameDept}</td>
                                <td style="text-align: center">${formatDate(form.DateCreate)}</td>
                                <td style="text-align: center"><button class="status-btn ${statusClass}">${form.status}</button></td>
                                <td style="text-align: center"><button class="action-btn btn-danger delete-btn-PYC" data-id="${form.id}" title="Xóa"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`;

                            $('#dataForms').append(newRow);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    console.error('Error:', error);
                }
            });
        });

        // Hiển thị loading trước khi gửi yêu cầu
        showLoading();
        $.ajax({
            url: '/get-PYC',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                hideLoading();
                $('#dataForms').empty();

                if (response.length === 0) {
                    let noDataRow = `
                        <tr>
                            <td colspan="10" class="text-center">
                                <i class="fas fa-box-open" style="font-size: 40px; color: #ccc;"></i>
                                <p>Không có dữ liệu</p>
                            </td>
                        </tr>`;
                    $('#dataForms').append(noDataRow);
                } else {
                    response.forEach(function(form, index) {
                        let statusClass = '';
                        switch (form.status) {
                            case 'Đang kiểm tra':
                                statusClass = 'status-checking';
                                break;
                            case 'Chờ duyệt':
                                statusClass = 'status-pending';
                                break;
                            case 'Từ chối':
                                statusClass = 'status-rejected';
                                break;
                            case 'Phiếu đã được duyệt':
                                statusClass = 'status-approved';
                                break;
                            default:
                                statusClass = '';
                        }

                        // Xây dựng URL động dựa trên route
                        let requestUrl = `/Forms/Check-Request-Forms/${form.CodeJobRequestForms}`;

                        let newRow = `
                            <tr>
                                <td style="text-align: center">${index + 1}</td>
                                <td style="text-align: center">
                                    <a href="${requestUrl}" target="_blank">${form.CodeJobRequestForms}</a>
                                </td>
                                <td style="text-align: center">${form.approvejsfs.find(a => a.No === 1)?.member?.FullName || ''}</td>
                                <td style="text-align: center">${form.department_request.NameDept}</td>
                                <td style="text-align: center">${formatDate(form.DateCreate)}</td>
                                <td style="text-align: center"><button class="status-btn ${statusClass}">${form.status}</button></td>
                                <td style="text-align: center"><button class="action-btn btn-danger delete-btn-PYC" data-id="${form.id}" title="Xóa"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`;

                        $('#dataForms').append(newRow);
                    });
                }
            },

            error: function(xhr, status, error) {
                hideLoading();
                console.error('Error:', error);
            }
        });
    });
});




