import Swal from 'sweetalert2';
$(document).ready(function() {
    $('.edit-icon').on('click', function() {
        $('#avatar').click();
    });
});

$(document).ready(function() {
    $('#uploadSignature').on('click', function() {
        $('#signature-upload').click();
    });

    $('#signature-upload').on('change', function() {
        var fileInput = this;
        var formData = new FormData();
        var file = fileInput.files[0];

        // Kiểm tra loại file
        if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
            formData.append('signature', file);
            $.ajax({
                url: '/profile/upload-signature',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Chữ ký số đã được tải lên thành công.',
                            timer: 3000, // Thời gian hiển thị thông báo (1 giây)
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã xảy ra lỗi khi tải lên chữ ký số.',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã xảy ra lỗi khi tải lên chữ ký số.',
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Cảnh báo',
                text: 'Vui lòng chọn một tệp hình ảnh hợp lệ (JPEG hoặc PNG).',
            });
        }
    });
});

$(document).ready(function() {
    $('#edit-division').on('click', function(e) {
        e.preventDefault();

        $('#division-text').hide();
        $('#edit-division').hide();
        $('#edit-division-group').show();
    });

    $('#save-division').on('click', function() {
        var newDivision = $('#division-input').val();
        var userId = $(this).data('id');
        $.ajax({
            url: '/Edit-Division', // Sử dụng route editDivision
            method: 'POST',
            data: {
                division: newDivision,
                _token: $('meta[name="csrf-token"]').attr('content'),
                user_id: userId
            },
            success: function(response) {
                $('#division-text').text(newDivision).show();
                $('#edit-division-group').hide();
                $('#edit-division').show();
            },
            error: function() {
                alert('Đã xảy ra lỗi khi cập nhật thông tin.');
            }
        });
    });

    $('#cancel-division').on('click', function() {
        $('#division-text').show();
        $('#edit-division-group').hide();
        $('#edit-division').show();
    });
});

