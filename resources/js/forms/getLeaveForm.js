import $ from 'jquery';
import Swal from 'sweetalert2';
import html2pdf from 'html2pdf.js';

// KIỂM TRA DỮ LIỆU
$(document).ready(function() {
    const handleCheckUrl = '/Forms/handle-check';
    const leaveFormCode = $('meta[name="leave-form-code"]').attr('content');

    $('#approveCheck').on('click', function() {
        showLoading();
        handleApproval('check', 'accept');
    });

    $('#denyCheck').on('click', function() {
        showLoading();
        handleApproval('check', 'reject');
    });

    $('#approveApprove').on('click', function() {
        showLoading();
        handleApproval('approve', 'accept');
    });

    $('#denyApprove').on('click', function() {
        showLoading();
        handleApproval('approve', 'reject');
    });

    function handleApproval(type, action) {
        const comments = $(`#comments-${type}`).val();
        // Gửi yêu cầu AJAX để cập nhật trạng thái phê duyệt
        $.ajax({
            url: handleCheckUrl,
            type: 'POST', // Phương thức POST
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            data: JSON.stringify({
                type: type,
                action: action,
                comments: comments,
                code: leaveFormCode
            }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                hideLoading();
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Cập nhật thành công',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Tải lại trang sau khi thông báo hoàn thành
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            },
            error: function() {
                hideLoading();
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        });
    }
});

//IN VÀ XUẤT PDF
document.getElementById('btnExport').addEventListener('click', function() {
    // Ẩn các phần tử overlay trước khi in
    $('.overlay-text, .overlay-text2').hide();

    var divToPrint = document.getElementById('review');
    var newWin = window.open('', 'Print-Window');

    newWin.document.open();
    newWin.document.write('<html><head><title>Print</title>');
    newWin.document.write('<style>@media print {body {margin: 0; padding: 0;} .text-center {text-align: center;} .image-container {position: relative;} .overlay-text, .overlay-text2 {position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; background-color: rgba(255, 255, 255, 0.7); padding: 5px; border-radius: 5px;} }</style>');
    newWin.document.write('</head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();

    setTimeout(function() {
        newWin.close();
        // Hiển thị lại các phần tử overlay sau khi in
        $('.overlay-text, .overlay-text2').show();
    }, 10);
});

document.getElementById('btnExportPDF').addEventListener('click', function() {
    var element = document.getElementById('pdf');

    // Tạo một bản sao của phần tử #pdf
    var clonedElement = element.cloneNode(true);

    // Thiết lập kích thước cho bản sao trước khi tạo PDF
    clonedElement.style.width = '8.27in';
    clonedElement.style.minHeight = '8.69in';


    // Thêm bản sao vào body để đảm bảo nó hiển thị đầy đủ khi tạo PDF
    document.body.appendChild(clonedElement);

    var opt = {
        margin: 0,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 1.0 }, // Chất lượng hình ảnh cao nhất
        html2canvas: {
            scale: 3, // Tăng scale để cải thiện chất lượng hình ảnh
            useCORS: true,
            scrollX: 0,
            scrollY: 0,
            windowWidth: clonedElement.scrollWidth,
            windowHeight: clonedElement.scrollHeight
        },
        jsPDF: {
            unit: 'in',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    // Sử dụng html2pdf để tạo và tải về file PDF
    html2pdf().from(clonedElement).set(opt).save().then(function() {
        // Xóa bản sao sau khi tạo PDF xong
        document.body.removeChild(clonedElement);
    });
});
