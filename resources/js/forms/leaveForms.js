import Swal from 'sweetalert2';

//Review phiếu
$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#createFormButton').on('click', function() {
        // Get values from the form
        var Division = $('#Division').val();
        var fullName = $('#fullName').val();
        var employeeCode = $('#employeeCode').val();
        var department = $('#department').val();
        var position = $('#position').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var reason = $('#reason').val();
        var usersReplace = $('#usersReplace option:selected').val();
        var note = $('#note').val();
        var createdDate = $('#createdDate').val();
        var reviewName = $("#review option:selected").val();
        var approvalName = $("#approval option:selected").text();
        var approvalNameVal = $("#approval option:selected").val();
        var Division = $('#Division').val();
        // Check if required fields are filled
        if (!Division || !employeeCode || !fullName || !department || !position || !startDate || !endDate || !reason || !usersReplace || !createdDate || !reviewName || !approvalName || !Division) {
            Swal.fire({
                icon: 'error',
                title: 'Thiếu thông tin',
                text: 'Vui lòng điền đầy đủ các trường bắt buộc!'
            });
            return;
        }

        // Format dates
        startDate = new Date(startDate);
        endDate = new Date(endDate);
        createdDate = new Date(createdDate);

        // Check if start date is greater than end date
        if (startDate > endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Ngày không hợp lệ',
                text: 'Ngày bắt đầu không thể lớn hơn ngày kết thúc!'
            });
            return;
        }

        var startHours = startDate.getHours();
        var startMinutes = startDate.getMinutes();
        var startDay = ('0' + startDate.getDate()).slice(-2);
        var startMonth = ('0' + (startDate.getMonth() + 1)).slice(-2);
        var startYear = startDate.getFullYear();

        var endHours = endDate.getHours();
        var endMinutes = endDate.getMinutes();
        var endDay = ('0' + endDate.getDate()).slice(-2);
        var endMonth = ('0' + (endDate.getMonth() + 1)).slice(-2);
        var endYear = endDate.getFullYear();

        var createdDay = ('0' + createdDate.getDate()).slice(-2);
        var createdMonth = ('0' + (createdDate.getMonth() + 1)).slice(-2);
        var createdYear = createdDate.getFullYear();

        var formattedStartDate = startHours + " h " + startMinutes + " phút, Ngày " + startDay + "/" + startMonth + "/" + startYear;
        var formattedEndDate = endHours + " h " + endMinutes + " phút, Ngày " + endDay + "/" + endMonth + "/" + endYear;
        var formattedCreatedDate = "Núi Thành, Ngày " + createdDay + " tháng " + createdMonth + " năm " + createdYear;

        // Set values in the modal
        $('#lbname').text(fullName);
        $('#lbmsnv').text(employeeCode);
        $('#lbldept').text(department);
        $('#lblposition').text(position);
        $('#lbltimeout').text(formattedStartDate);
        $('#lbltimein').text(formattedEndDate);
        $('#lblreason').text(reason);
        $('#lblmember').text($('#usersReplace option:selected').text());
        $('#lblmember1').text($('#usersReplace option:selected').text());
        $('#lblnote').text(note);
        $('#lblngaytao').text(formattedCreatedDate);
        $('#lblcreator').text(fullName);
        $('#lblcheck').text($("#review option:selected").text());
        $('#lblapprove').text(approvalName);
        $('#lbldivision').text(Division);

        // Show the modal
        $('#print').css('display', 'flex');
    });
    // Handle "Hủy bỏ" button click
    $('#huyBo').on('click', function() {
        $('#print').css('display', 'none');
    });

    // Handle "Hoàn thành" button click
    $('#taoPhieu').on('click', function() {
        showLoading();
        // Collect form data
        var formData = {
            Division: $('#Division').val(),
            employeeCode: $('#employeeCode').val(),
            startDate: $('#startDate').val(),
            endDate: $('#endDate').val(),
            reason: $('#reason').val(),
            usersReplace: $('#usersReplace').val(), // ID của nhân sự bàn giao
            note: $('#note').val(),
            createdDate: $('#createdDate').val(),
            reviewName: $("#review option:selected").val(),
            approvalName: $("#approval option:selected").val(),
            _token: csrfToken
        };

        $.ajax({
            url: '/Forms/Save-Leave-Forms',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#taoPhieu').remove();
                hideLoading();
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: 'Đơn xin nghỉ phép đã được gửi thành công!',
                    timer: 2000, // Hiển thị thông báo trong 2 giây
                    showConfirmButton: false // Ẩn nút xác nhận
                }).then(() => {
                    // Chuyển hướng sau 2 giây
                    setTimeout(() => {
                        window.location.href = '/Forms-Management';
                    }, 1000); // Chuyển hướng sau 2 giây
                });
            },

            error: function(xhr) {
                hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Đã xảy ra lỗi khi gửi đơn xin nghỉ phép. Vui lòng thử lại!'
                });
            }
        });
    });
});


