import Swal from 'sweetalert2';
//Lấy thông tin người dùng xem xét và phê duyệt
$(document).ready(function() {
    // Khi người dùng thay đổi bộ phận tiếp nhận
    $('#deptneed').on('change', function() {
        showLoading();
        var departmentId = $('#deptneed').val();
        // Kiểm tra nếu bộ phận tiếp nhận đã được chọn
        if (departmentId) {
            // Gửi yêu cầu AJAX để lấy danh sách nhân sự theo phòng ban
            $.ajax({
                url: '/Forms/get-user-by-department',
                type: 'POST',
                data: {
                    department_id: departmentId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)
                    hideLoading();
                    // Xóa dữ liệu cũ trong các ô chọn
                    $('#check2').empty();
                    $('#approve').empty();

                    // Thêm tùy chọn mặc định
                    $('#check2').append('');
                    $('#approve').append('');

                    // Thêm nhân sự xem xét vào ô chọn check2
                    $.each(response.userConsider, function(key, user) {
                        $('#check2').append('<option value="' + user.MSNV + '">' + user.FullName + '</option>');
                    });

                    // Thêm nhân sự phê duyệt vào ô chọn approve
                    $.each(response.userApprove, function(key, user) {
                        console.log(user);
                        $('#approve').append('<option value="' + user.MSNV + '">' + user.FullName + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    console.error('Error fetching users:', error);
                }
            });
        }
    });
});

//Xem review phiếu
$(document).ready(function() {
    $('#xemPhieu').on('click', function() {
        // Lấy dữ liệu từ các trường trong form
        var dept1 = $('#txtdept').val();
        var dept2 = $('#deptneed').val();
        var content = $('#txtNoiDungYeuCau').val();
        var deadline = $('#timesend').val();
        var creatorDate = $('#ngaytao').val();

        var checkPersonId = $('#kiemtra').val(); // Lấy ID của người kiểm tra
        var reviewPersonId = $('#check2').val(); // ID người xem xét
        var approvePersonId = $('#approve').val(); // ID người phê duyệt
        var creatorId = $('#txtidmember').val(); // ID người tạo phiếu

        var note = $('#txtnote').val(); // Ghi chú
        // Kiểm tra nếu các trường bắt buộc không có dữ liệu
        if (!dept2 || !content || !deadline || !creatorDate || !checkPersonId || !reviewPersonId || !approvePersonId) {
            Swal.fire({
                icon: 'error',
                title: 'Thiếu dữ liệu',
                text: 'Vui lòng điền đầy đủ thông tin vào các trường bắt buộc!',
            });
            return; // Dừng lại nếu thiếu dữ liệu
        }

        // Định dạng thời gian hoàn thành
        var deadlineDate = new Date(deadline);
        var formattedDeadline = ('0' + deadlineDate.getDate()).slice(-2) + '/' +
                                ('0' + (deadlineDate.getMonth() + 1)).slice(-2) + '/' +
                                deadlineDate.getFullYear() + ' ' +
                                ('0' + deadlineDate.getHours()).slice(-2) + ':' +
                                ('0' + deadlineDate.getMinutes()).slice(-2);

        // Định dạng ngày tạo phiếu
        var creatorDateObj = new Date(creatorDate);
        var formattedCreatorDate = 'Núi Thành, ngày ' +
                                   creatorDateObj.getDate() + ' tháng ' +
                                   (creatorDateObj.getMonth() + 1) + ' năm ' +
                                   creatorDateObj.getFullYear();

        // Thay thế ký tự xuống dòng bằng <br> để hiển thị đúng định dạng
        content = content.replace(/\n/g, '<br>');
        note = note.replace(/\n/g, '<br>');

        // Gán dữ liệu vào phần tử review
        $('#lbldept1').text(dept1);
        $('#lbldept2').text($('#deptneed option:selected').text());
        $('#lblconten').html(content); // Sử dụng .html() để hiển thị với <br>
        $('#lblDeadline').text(formattedDeadline);
        $('#lblnote').html(note); // Sử dụng .html() để hiển thị với <br>
        $('#lblngaytao').text(formattedCreatorDate);

        $('#lblcheck').text($('#kiemtra option:selected').text());
        $('#lblreview').text($('#check2 option:selected').text());
        $('#lblapprove').text($('#approve option:selected').text());
        $('#lblcreator').text($('#txtfullname').val()); // Hiển thị tên người tạo phiếu

        // Kiểm tra nếu người tạo và người kiểm tra giống nhau bằng ID
        if (creatorId === checkPersonId) {
            // Ẩn phần kiểm tra cả trong phần header và phần nội dung
            $('#approveCheck').hide(); // Ẩn phần header "KIỂM TRA"
            $('#lblcheck').parent().hide(); // Ẩn phần nội dung "KIỂM TRA"

            // Căn chỉnh lại các phần tử còn lại
            $('#approveHeader').css('width', '33.33%');
            $('#approveConsider').css('width', '33.33%');
            $('#approveCreated').css('width', '33.33%');
            $('#lblapprove').parent().css('width', '33.33%');
            $('#lblreview').parent().css('width', '33.33%');
            $('#lblcreator').parent().css('width', '33.33%');
        } else {
            // Hiển thị phần kiểm tra và đặt lại chiều rộng khi không giống nhau
            $('#approveCheck').show();
            $('#lblcheck').parent().show();
            $('#approveHeader').css('width', '25%');
            $('#approveConsider').css('width', '25%');
            $('#approveCreated').css('width', '25%');
            $('#lblapprove').parent().css('width', '25%');
            $('#lblreview').parent().css('width', '25%');
            $('#lblcreator').parent().css('width', '25%');
            $('#lblcheck').parent().css('width', '25%');
        }

        // Hiển thị phần review
        $('#print').show();

        // Gọi hàm để gửi dữ liệu lên controller sau khi đã hiển thị review
        $('#taoPhieu').on('click', function() {
            $('#taoPhieu').hide();
            showLoading();
            saveJobRequestForm(dept1, dept2, content, deadline, note, creatorDate, checkPersonId, reviewPersonId, approvePersonId, creatorId);
        });
    });

    $('#huyBo').on('click', function() {
        // Ẩn modal review
        $('#print').hide();

        // Reset lại các giá trị trong modal
        $('#lbldept1').text('.................');
        $('#lbldept2').text('.................');
        $('#lblconten').html('.................');
        $('#lblDeadline').text('.................');
        $('#lblnote').html('.................');
        $('#lblngaytao').text('Núi Thành, ngày ... tháng ... năm ...');
        $('#lblcheck').parent().show(); // Đảm bảo hiển thị lại phần kiểm tra khi reset
        $('#approveCheck').show(); // Đảm bảo hiển thị lại header kiểm tra khi reset
        $('#lblcheck').text('HO VA TEN');
        $('#lblreview').text('HO VA TEN');
        $('#lblapprove').text('HO VA TEN');
        $('#lblcreator').text('HO VA TEN');

        // Reset lại chiều rộng các phần tử về mặc định
        $('#approveHeader').css('width', '25%');
        $('#approveConsider').css('width', '25%');
        $('#approveCreated').css('width', '25%');
        $('#approveCheck').css('width', '25%');
        $('#lblapprove').parent().css('width', '25%');
        $('#lblreview').parent().css('width', '25%');
        $('#lblcreator').parent().css('width', '25%');
        $('#lblcheck').parent().css('width', '25%');
    });
});

function saveJobRequestForm(dept1, dept2, content, deadline, note, creatorDate, checkPersonId, reviewPersonId, approvePersonId, creatorId) {
    $.ajax({
        url: '/Forms/Save-Request-Forms', // Đường dẫn tới route xử lý
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), // Lấy token CSRF từ meta tag
            IDDepartmentRequest: dept1,
            IDDepartmentPerforming: dept2,
            Content: content,
            TimeFinish: deadline,
            Note: note,
            DateCreate: creatorDate,
            checkPersonId: checkPersonId,
            reviewPersonId: reviewPersonId,
            approvePersonId: approvePersonId,
            creatorId: creatorId
        },
        success: function(response) {
            hideLoading();
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Phiếu yêu cầu công việc đã được lưu thành công!',
            }).then(function() {
                // Reset lại form hoặc điều hướng nếu cần
                location.reload(); // Hoặc location.href = '/path-to-redirect';
            });
        },
        error: function(xhr, status, error) {
            hideLoading();
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Đã xảy ra lỗi khi lưu phiếu yêu cầu. Vui lòng thử lại sau.',
            });
        }
    });
}



//Thêm dấu - đầu dòng
$(document).ready(function() {
    // Hàm để thêm dấu "-" khi người dùng bắt đầu nhập liệu
    $('#txtNoiDungYeuCau, #txtnote').on('input', function() {
        if ($(this).val() === "") {
            $(this).val('- '); // Thêm dấu "-" khi bắt đầu nhập liệu
        }
    });

    // Hàm để thêm dấu "-" khi người dùng nhấn phím Enter
    $('#txtNoiDungYeuCau, #txtnote').on('keydown', function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Ngăn việc tạo dòng mới tự động
            let cursorPos = this.selectionStart;
            let textBefore = $(this).val().substring(0, cursorPos);
            let textAfter = $(this).val().substring(cursorPos);
            $(this).val(textBefore + '\n- ' + textAfter);
            this.selectionEnd = cursorPos + 3; // Đặt con trỏ sau dấu "-"
        }
    });
});




