<?php
?>
<script type="text/javascript">
    function ShowNotification(result) {
        $.ajax({
            url: 'getnotification.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function (result) {
                console.log(result);
                if (result.result !== 0) {
                    if(!window.Notification){
                        console.log('Browser does not support notifications.');
                    } else {
                        if (Notification.permission === 'granted') {
                            console.log("Mo thong bao")
                            const notification = new Notification("Phần mềm CKDT - R&D ÔTÔ", {
                                body: "Bạn có " + result.result + " thông báo mới!",
                                icon: "../RD/images/KIA.png"
                            });
                            notification.onclick = function () {
                                //window.location.assign("http://10.20.12.6:4375/TKACManager/ManagerFile.php?page=1");
                                //location.href="http://10.20.12.6:4375/TKACManager/ManagerFile.php?page=1";
                                
                            }
                            setTimeout(notification.close.bind(notification), 9000000000);
                        }
                        else {
                            Notification.requestPermission().then(function (p) {
                                if (p === 'granted') {
                                    // show notification here
                                    var notify = new Notification('Hi there!', {
                                        body: 'How are you doing?',
                                        icon: 'https://bit.ly/2DYqRrh',
                                    });
                                } else {
                                    console.log('User blocked notifications.');
                                }
                            }).catch(function (err) {
                                console.error(err);
                            });
                        }
                    }
                }
            },
            error: function (error) {
                console.log(error.responseText);
            }
        });
    }
    var countgloba=0;
    function ClockApp()
    {
        AddAlert("1");
        countgloba++;
        //setTimeout(ClockApp, 10000);
    }
    function PrintDiv(){
        var mywindow = window.open();
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const result = urlParams.get('id');
        mywindow.document.write('<html><head><title>'+result+'</title>');
        mywindow.document.write('</head>')
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="css/printptc.css">');
        mywindow.document.write('<body >');
        mywindow.document.write(document.getElementById('review').innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();
        return true;
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
    var globa =0;
    function AddAlert(result)
    {
        $.ajax({
            url:'GetAlert.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                var div ="";
                if(result.result[0].length==0)
                {
                    globa=0;
                    document.getElementById('itemnotify').style.display='none';
                    $('.dropdown').removeClass('active');
                }
                else if(globa ==0 || globa !=result.result[0].length || countgloba==30) {
                    console.log("Reload");
                    if(Notification.permission==="granted" && globa !=result.result[0].length)
                    {
                        console.log("call notify");
                        var value = <?php echo $_SESSION['idmember']; ?>;
                        ShowNotification(value);
                    }
                    document.getElementById('itemnotify').innerText=result.result[0].length;
                    document.getElementById('itemnotify').style.display='block';
                    for (var i = 0; i < result.result[0].length; i++) {
                        div += "<div class='notify_item'>" +
                            "<div class='notify_image'>" +
                            "<img src='images/User.png' style='width: 60px'>" +
                            "</div><div class='notify_info'><p>" + result.result['0'][i]['FullName'] + " " + result.result['0'][i]['NameFunction'] + "</p><a href='" + result.result['0'][i]['Link'] + "' target='_blank'>Đường dẫn phiếu</a>";
                        if (result.result[2] == 0)
                            div += "<span class='notify_time'>" + result.result['0'][i]['Time'] + " trước</span></div></div>";
                        else {
                            div += "<div style='display: flex'><span class='notify_time'>" + result.result['0'][i]['Time'] + " trước</span>" +
                                "<input class='btnhiden' type='button' onclick='var idmember ="+'"'+result.result['0'][i]['IDMember']+'"'+";var idfile = "+'"'+result.result['0'][i]['IDFile']+'"'+"; var result2={idmember,idfile}; HidenAlert(result2)' value='Ẩn thông báo'></div></div></div>"
                        }
                    }
                    document.getElementById('dropdown').innerHTML = div;
                    globa=result.result[0].length;
                    countgloba=0;
                }
            },
            error:function(error){
                console.log(error.responseText);
            }
        })
    }
</script>
