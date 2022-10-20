function LoadEating(){
    var result ="A";
    $.ajax({
        url:'loadeating.php',
        type:'post',
        dataType:'json',
        data:{
            result:result
        },
        success:function(result){
            $('#tbeating').empty();
            $.each(result.result, function (i, item) {
                var tr = "<tr class='w-100'><td class='align-middle  text-center'><i class='material-icons opacity-10 ql-color-red cursor-pointer'>restore_from_trash</i></td><td><div class='d-flex flex-column justify-content-center'><h6 class='mb-0 text-sm'>"+item['NameEating']+
                    "</h6></div></td>" +
                    "</tr>";
                $('#tbeating').append(tr);
                $('#sleating').empty();
                $.each(result.result, function (i, item) {
                    $('#sleating').append($('<option>', {
                        value: item[0],
                        text : item[1]
                    }));
                });
            });
        },
        error:function(error){
            swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                console.log(error.responseText);
            });
        }
    })
}
$('#btnsettime').on('click',function (){
    var value = $('#sltime').val();
    $.ajax({
        url:'loadsetingline.php',
        type:'post',
        dataType:'json',
        data:{
            value:value
        },
        success: function(result){
            console.log(result)
            var timestart = result.result["StartTime"];
            var timeend = result.result["EndTime"];
            Swal.fire({
                title: 'Thay đổi thời gian quét thẻ',
                html:
                '<div class="d-flex align-items-center align-content-center text-center"><h6>thời gian bắt đầu: </h6><input type="time" id="swal-input1" value="'+timestart+'" class="swal2-input w-100"></div>' +
                '<div class="d-flex align-items-center align-content-center text-center"><h6>thời gian bắt đầu: </h6><input type="time" id="swal-input2" value="'+timeend+'" class="swal2-input w-100"></div>',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                    timestart = document.getElementById('swal-input1').value,
                    timeend = document.getElementById('swal-input2').value
                    ]
                }
            }).then((result2)=>{
                if(result2.isConfirmed){
                    var newtime = {value,timestart,timeend};
                    console.log(newtime);
                    Savesettingtimeline(newtime);
                }
            })
        },
        error:function(error){
            swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                console.log(error.responseText);
            });
        }
    })
})

function Savesettingtimeline(result){
    $.ajax({
        url:'Savesettingtimeline.php',
        type:'post',
        dataType:'json',
        data:{
            result:result
        },
        success: function(result){
            console.log(result)
            swal.fire("Thông báo","Cập nhật giờ quét thẻ thành công!","success");
        },
        error:function(error){
            swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                console.log(error.responseText);
            });
        }
    })
}

$('#tbeating').on('click','i',function (){
    var result = $($(this).parent().parent().children()[1]).children().children()[0].innerText;
    Swal.fire({
        title: 'Xóa món ăn?',
        text: "Bạn muốn xóa món "+result,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có!',
        cancelButtonText: 'Không!'
    }).then((result2) => {
        if (result2.isConfirmed) {
            $.ajax({
                url:'deleteeating.php',
                type:'post',
                dataType:'json',
                data:{
                    result:result
                },
                success:function(result){
                    console.log(result)
                    if(result.result=="OK")
                        LoadEating();
                    else swal.fire('Thông báo','Món ăn không tồn tại!','error')
                },
                error:function(error){
                    swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                        console.log(error.responseText);
                    });
                }
            })
        }
    })

})


function loadeatingday(result){
    $.ajax({
        url:'loadeatingday.php',
        type:'post',
        dataType:'json',
        data:{
            result:result
        },
        success:function(result){
            $('#tbeatingday').empty();
            $.each(result.result, function (i, item) {
                var tr = "<tr>" +
                    "<td><div class='d-flex flex-column text-center justify-content-center'><h6 class='mb-0 text-sm'>"+item[0]+"</h6></div></td>" +
                "<td><div class='d-flex flex-column text-center justify-content-center'><h6 class='mb-0 text-sm'>"+item[1]+"</h6></div></td></tr>";
                $('#tbeatingday').append(tr);
            });
        },
        error:function(error){
            swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                console.log(error.responseText);
            });
        }
    })
}


function LoadMemberDay(result){
    $.ajax({
        url:'loadmemberday.php',
        type:'post',
        dataType:'json',
        data:{
            result:result
        },
        success:function(result){
            $('#tbmember').empty();
            $.each(result.result, function (i, item) {
                var tr = "<tr><td class='align-middle text-sm'><span class='text-xs font-weight-bold'>"+item[0]+"</span></td>" +
                    "<td class='align-middle text-center text-sm'><span class='text-xs font-weight-bold'>"+item[1]+"</span></td>" +
                    "<td class='align-middle text-center text-sm'><span class='text-xs font-weight-bold'>"+item[2]+"</span></td>" +
                    "<td class='align-middle text-center text-sm'><span class='text-xs font-weight-bold'>"+item[3]+"</span></td></tr>";
                $('#tbmember').append(tr);
            });
        },
        error:function(error){
            swal.fire('Thông báo','Lỗi dữ liệu. Vui lòng liên hệ CNTT!','error').then((result) => {
                console.log(error.responseText);
            });
        }
    })
}