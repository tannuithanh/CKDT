<?php
session_start();
if(isset($_POST['result'])) {
    $v=array();
    $con = "";
    include ('Library/Connect_DB.php');
    $value = $_POST['result'];
    $sql = "SELECT p1.IDPosition as ID1,p1.NamePosition as Name1,p2.IDPosition as ID2,p2.NamePosition as Name2,p3.IDPosition as ID3,p3.NamePosition as Name3 FROM approvegrc,position p1, position p2,position p3 WHERE approvegrc.Position1 = p1.IDPosition AND approvegrc.Position2 = p2.IDPosition AND approvegrc.Position3 = p3.IDPosition AND approvegrc.Position1 = '".$value."'";
    $query = mysqli_query($con, $sql);
    if($query->num_rows>0){
        while($row=mysqli_fetch_array($query)){
            $v[] = array("ID1"=>$row['ID1'],"Name1"=>$row['Name1'],"ID2"=>$row['ID2'],"Name2"=>$row['Name2'],"ID3"=>$row['ID3'],"Name3"=>$row['Name3'],"Function"=>"<button class='settings' type='button' onclick='var id1 = ".'"'.$row['ID1'].'"'.";id2 = ".'"'.$row['ID2'].'"'.";id3 = ".'"'.$row['ID3'].'"'.";var result = {id1,id2,id3};ShowEdit(result)' title data-toggle='tooltip' data-original-title='Cài đặt'><i class='material-icons' style='color: #3abaf4'>settings</i></button><button class='delete' type='button' onclick='var id1 = ".'"'.$row['ID1'].'"'.";id2 = ".'"'.$row['ID2'].'"'.";id3 = ".'"'.$row['ID3'].'"'.";var result = {id1,id2,id3};Deleteprc(result)' title data-toggle='tooltip' data-original-title='Xóa'><i class='material-icons' style='color: red'>delete</i></button>");
        }
    }
    echo json_encode(['result'=>$v,'code'=>200,'query'=>$sql]);
}
else
    echo json_encode(['code'=>201]);