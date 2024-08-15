import $ from 'jquery';
import Swal from 'sweetalert2';


//Hàm định dạng dd/mm/yyy hh:ii
function formatDate(dateStr) {
    const date = new Date(dateStr);

    // Lấy ngày, tháng, năm
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // getMonth() trả về 0-11 nên cần cộng thêm 1
    const year = date.getFullYear();

    // Lấy giờ, phút, giây
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const seconds = date.getSeconds().toString().padStart(2, '0');

    // Kết hợp ngày, tháng, năm với giờ, phút, giây
    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
}


$(document).ready(function() {
    showLoading(); // Hiển thị hiệu ứng loading

    // Lấy phần 'code' từ URL
    const urlPath = window.location.pathname;
    const code = urlPath.split('/').pop();  // Lấy phần cuối cùng của URL

    // Nếu 'code' có giá trị thì thực hiện AJAX
    if (code) {
        $.ajax({
            url: '/Get-Request-Forms',  // Đường dẫn tới route xử lý
            type: 'POST',
            data: { code: code },  // Gửi mã code lên server
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token để bảo mật
            },
            success: function(response) {
                hideLoading();  // Ẩn hiệu ứng loading

                const currentUserID = response.user_id;
                let allowNextNo = true; // Biến để kiểm soát việc hiển thị các nút

                // Kiểm tra số lượng approvejsf
                if (response.approvejsfCount === 3) {
                    $('#approveCheck').remove();
                    $('#lblcheck').parent().remove();
                    $('#imageCheck').parent().remove();
                    $('#timeAprrove3').parent().remove();
                    $('#noteCheck').parent().remove();

                    // Điều chỉnh lại giao diện canh giữa 3 phần còn lại
                    $('#approveHeader').css('width', '33.33%');
                    $('#approveConsider').css('width', '33.33%');
                    $('#approveCreated').css('width', '33.33%');
                    $('#lblapprove').parent().css('width', '33.33%');
                    $('#lblreview').parent().css('width', '33.33%');
                    $('#lblcreator').parent().css('width', '33.33%');
                    $('#imageApprove').parent().css('width', '33.33%');
                    $('#imageReview').parent().css('width', '33.33%');
                    $('#imageCreator').parent().css('width', '33.33%');
                    $('#timeAprrove1').parent().css('width', '33.33%');
                    $('#timeAprrove2').parent().css('width', '33.33%');
                    $('#timeAprrove4').parent().css('width', '33.33%');
                    $('#noteApprove').parent().css('width', '33.33%');
                    $('#noteReview').parent().css('width', '33.33%');
                    $('#noteCreator').parent().css('width', '33.33%');
                }

                // Gán dữ liệu cho các chữ ký và hình ảnh tương ứng
                response.jobRequestForm.approvejsfs.forEach(function(approve, index) {
                    let imgId = '';
                    let lblId = '';
                    let timeId = '';
                    let NoteId ='';
                    let buttonGroup = '';

                    // Kiểm tra xem No trước đó có được duyệt hay không
                    if (index > 0 && response.jobRequestForm.approvejsfs[index - 1].Status !== 1) {
                        allowNextNo = false;
                    }

                    if (response.approvejsfCount === 3) {
                        if (approve.No === 1) {
                            imgId = '#imageCreator';
                            lblId = '#lblcreator';
                            timeId= '#timeAprrove4';
                            NoteId= '#noteCreator';
                        } else if (approve.No === 2) {
                            imgId = '#imageReview';
                            lblId = '#lblreview';
                            timeId= '#timeAprrove2';
                            NoteId= '#noteReview';
                        } else if (approve.No === 3) {
                            imgId = '#imageApprove';
                            lblId = '#lblapprove';
                            timeId= '#timeAprrove1';
                            NoteId= '#noteApprove';
                        }
                    } else if (response.approvejsfCount === 4) {
                        if (approve.No === 1) {
                            imgId = '#imageCreator';
                            lblId = '#lblcreator';
                            timeId= '#timeAprrove4';
                            NoteId= '#noteCreator';
                        } else if (approve.No === 2) {
                            imgId = '#imageCheck';
                            lblId = '#lblcheck';
                            timeId= '#timeAprrove3';
                            NoteId= '#noteCheck';
                        } else if (approve.No === 3) {
                            imgId = '#imageReview';
                            lblId = '#lblreview';
                            timeId= '#timeAprrove2';
                            NoteId= '#noteReview';
                        } else if (approve.No === 4) {
                            imgId = '#imageApprove';
                            lblId = '#lblapprove';
                            timeId= '#timeAprrove1';
                            NoteId= '#noteApprove';
                        }
                    }
                    // Kiểm tra nếu trạng thái chưa được duyệt và IDMember khớp với user_id
                    if (allowNextNo && approve.Status === null && approve.IDMember === currentUserID) {
                        buttonGroup = `
                            <div class="approval-container">
                                <input id="comments-${approve.No}" placeholder="Nhập ghi chú" class="form-control">
                                <div class="button-group mt-2">
                                    <button class="btn btn-success approve-button" data-no="${approve.No}">Đồng ý</button>
                                    <button class="btn btn-danger deny-button" data-no="${approve.No}">Từ chối</button>
                                </div>
                            </div>
                        `;
                        $(lblId).parent().html(buttonGroup); // Thay thế label bằng các nút đồng ý, từ chối và input

                        // Sau khi hiện nút cho người dùng hiện tại, ngăn việc hiển thị các nút cho `No` tiếp theo
                        allowNextNo = false;
                    } else {
                        // Nếu status có giá trị, hiển thị chữ ký hoặc dấu từ chối
                        if (approve.Status === 0) {
                            $(imgId).attr('src', '/assets/img/DEN.png');
                        } else if (approve.Status === 1 && approve.member.Signature) {
                            $(imgId).attr('src', `/${approve.member.Signature}`);
                            $(timeId).text(`${formatDate(approve.TimeStamp)}`)
                            $(NoteId).text(approve.Note)
                        }

                        $(lblId).text(approve.member.FullName);
                    }
                });

                // Xử lý dữ liệu khác từ server (ví dụ như phần định dạng ngày)
                if (response.jobRequestForm && response.jobRequestForm.DateCreate) {
                    const date = new Date(response.jobRequestForm.DateCreate);
                    const day = date.getDate();
                    const month = date.getMonth() + 1; // Tháng bắt đầu từ 0, nên cần +1
                    const year = date.getFullYear();

                    // Định dạng ngày tháng theo yêu cầu
                    const formattedDate = `Núi Thành, ngày ${day} tháng ${month} năm ${year}`;
                    $('#lblngaytao').text(formattedDate);
                }

                // Gán dữ liệu vào các phần tử khác
                if (response.jobRequestForm) {
                    $('#lbldept1').text(response.jobRequestForm.department_request.NameDept);
                    $('#lbldept2').text(response.jobRequestForm.department_performing.NameDept);
                    $('#lblconten').html(response.jobRequestForm.Content);
                    $('#lblDeadline').text(response.jobRequestForm.TimeFinish);
                    $('#lblnote').html(response.jobRequestForm.Note);

                    // Ẩn nút hoàn thành và hủy bỏ
                    $('#taoPhieu').hide();
                    $('#huyBo').hide();
                }

                // Xử lý sự kiện click cho nút Đồng ý và Từ chối
                $('.approve-button').on('click', function() {
                    showLoading();
                    const no = $(this).data('no');
                    const comment = $(`#comments-${no}`).val();

                    // Gửi yêu cầu đồng ý
                    sendApprovalDecision(no, 1, comment,code); // 1 = đồng ý
                });

                $('.deny-button').on('click', function() {
                    showLoading();
                    const no = $(this).data('no');
                    const comment = $(`#comments-${no}`).val();

                    // Gửi yêu cầu từ chối
                    sendApprovalDecision(no, 0, comment,code); // 0 = từ chối
                });
            },
            error: function(xhr, status, error) {
                hideLoading();  // Ẩn hiệu ứng loading
                console.error('Lỗi khi gửi yêu cầu:', error);  // Ghi log lỗi
            }
        });
    } else {
        hideLoading();  // Ẩn hiệu ứng loading nếu không có mã code
        console.error('Không tìm thấy mã code trong URL');
    }
});

// Hàm gửi yêu cầu đồng ý hoặc từ chối
function sendApprovalDecision(no, decision, comment, code) {
    $.ajax({
        url: '/approveFormRequest', // Đường dẫn tới route xử lý quyết định phê duyệt
        type: 'POST',
        data: {
            no: no,
            decision: decision, // 1 = đồng ý, 0 = từ chối
            comment: comment,
            code: code
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            hideLoading();
            // Ẩn tất cả các nút và input sau khi phê duyệt thành công
            $('.approve-button, .deny-button, .approval-container').hide();

            // Hiển thị thông báo bằng SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: response.message,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload(); // Tải lại trang sau khi người dùng nhấn OK
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi gửi quyết định:', error);
            // Hiển thị thông báo lỗi nếu cần
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại.',
                confirmButtonText: 'OK'
            });
        }
    });
}


