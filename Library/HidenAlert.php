<?php
?>
<script type="text/javascript">
    function HidenAlert(result)
    {
        $.ajax({
            url:'hidenalert.php',
            type:'post',
            dataType:'json',
            data:{
                result:result
            },
            success:function(result){
                console.log(result);
                console.log("OK");
            },
            error:function(error){
                console.log(error.responseText);
            }
        })
    }

</script>
