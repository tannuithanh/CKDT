function cal() {
    var self = this;
    this.readExcel = () => {


        var file_data = $('#inputGroupFile01').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //alert(form_data);
        $.ajax({
            url: 'upfile.php',
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response) {
                $('.detail').html(php_script_response);
                $('.result').removeClass('d-none');
                //console.log(php_script_response);
                console.log($('.body th').length);

            },
            error: function(error) {
                alert('Lỗi định dạng file Excel!'.error.responseText);
            }
        });
    }
    this.Amount = (tongso) => {
        var html = '';

    }
}
var cal = new cal();