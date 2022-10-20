<?php
session_start();
if(isset($_POST['result'])) {
    $v = array();
    $con = "";
    include('Library/Connect_DB.php');
    $sql2 = "SELECT IDEating,NameEating FROM eating ORDER BY IDEating ASC";
    $query = mysqli_query($con, $sql2);
    while($row=mysqli_fetch_array($query)){
        $data[] = $row;
    }
    $value = $_POST['result'];
    $sql = "SELECT IDLine,IDEating FROM settingline WHERE IDTime='".$value."'";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $select = '<select class="linesetting nav-link dropdown-toggle" style="width: 100%">';
            foreach ($data as $va){
                if(trim($va['IDEating']) == trim($row['IDEating']))
                $select.='<option value="'.trim($va['IDEating']).'" selected>'.$va['NameEating'].'</option>';
                else
                    $select.='<option value="'.trim($va['IDEating']).'">'.$va['NameEating'].'</option>';
            }
            $select .= '</select>';
            $v[] = "<tr><td><div class='d-flex flex-column text-center align-items-center justify-content-center'><h6 class='mb-0 text-sm'>".$row['IDLine']."</h6></div></td><td><div class='d-flex flex-column justify-content-center'>".$select."</div></td></tr>";
        }
        echo json_encode(['result' => $v, 'code' => 200]);
    }
}
else echo json_encode(['code'=>201]);