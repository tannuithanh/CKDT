<?php
require 'vendor/autoload.php';
require 'vendor/PHPExcel/Classes/PHPExcel.php';
include 'vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
function InsertMember($idmember, $fullname, $iddept, $idpositon)
{
    $con = "";
    include 'Library/Connect_DB.php';
    $sql = "SELECT COUNT(*) as ct FROM member WHERE IDMember='" . $idmember . "'";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            if ($row['ct'] == 0) {
                $sql = "INSERT INTO member(IDMember, FullName, Pass, AdminUser, MailAddress) VALUES ('" . $idmember . "','" . $fullname . "','123','0','')";
                $query2 = mysqli_query($con, $sql);
            }
        }
    }
    $sql = "SELECT COUNT(*) AS ct FROM managermember WHERE IDMember='" . $idmember . "' AND IDDept='" . $iddept . "'";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            if ($row['ct'] == 0) {
                $sql = "INSERT INTO managermember(IDMember, IDDept, IDPosition) VALUES ('" . $idmember . "','" . $iddept . "','" . $idpositon . "')";
                $query2 = mysqli_query($con, $sql);
            }
        }
    }
}

function CheckIDPositon($nameposition)
{
    $con = "";
    include 'Library/Connect_DB.php';
    $value = "A";
    $sql = "SELECT IDPosition FROM position WHERE UPPER(NamePosition) = '" . strtoupper($nameposition) . "'";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $value = $row['IDPosition'];
        }
    }
    return $value;
}
if ($_FILES['inputGroupFile01']['name'] != '') {
    $targetPath = 'FileUploads/' . $_FILES['inputGroupFile01']['name'];
    move_uploaded_file($_FILES['inputGroupFile01']['tmp_name'], $targetPath);
    $fileType = PHPExcel_IOFactory::identify($targetPath);

    $objReader = PHPExcel_IOFactory::createReader($fileType);
    $objPHPExcel = $objReader->load($targetPath);
    $workbook = $objPHPExcel->setActiveSheetIndex(0);
    $row = $workbook->getHighestRow();
    // $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    // $spreadSheet = $Reader->load($targetPath);
    // $countsheet = $spreadSheet->getSheetCount();
    $iddept = $_POST['dept'];
    // for($i=0;$i<$countsheet;$i++) {
    //     $excelSheet = $spreadSheet->getSheet(0);
    //     $spreadSheetAry = $excelSheet->toArray();
    //     $sheetCount = count($spreadSheetAry);
    $test1 = "";
    for ($i = 2; $i <= $row; $i++) {
        $idposition = CheckIDPositon($workbook->getCellByColumnAndRow(2, $i)->getValue());
        $test1 = $idposition;
        if ($idposition == "") {
            $idposition = "P0017";
        }
        InsertMember($workbook->getCellByColumnAndRow(0, $i)->getValue(), $workbook->getCellByColumnAndRow(1, $i)->getValue(), $iddept, $idposition);
        // if (isset($spreadSheetAry[$i][1]) && isset($spreadSheetAry[$i][0])){
        //     $idposition = CheckIDPositon($spreadSheetAry[$i][2]);
        //     if ($idposition == "") $idposition="P0017";
        //     InsertMember($spreadSheetAry[$i][0],$spreadSheetAry[$i][1],$iddept,$idposition);
        // }
    }
    // }
    unlink($targetPath);
    echo $_POST['dept'];
}
