<?php
session_start();
if(isset($_SESSION['idmember']))
{
    $username = $_SESSION['Name'];
    $idmember = $_SESSION['idmember'];
    $namedept = $_SESSION['NameDept'];
    $iddept = $_SESSION['IDDept'];
    $nameposition = $_SESSION['NamePosition'];
    $idposition = $_SESSION['IDPosition'];
    if(isset($_SESSION['link']))
    {
        header("Location: "."../RD/F0014.php/Index.php");
    }
}
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
if($_FILES['inputGroupFile01']['name']!='')
{
    /*$filedata = fopen($_FILES['inputGroupFile01']['tmp_name'],"r");
    fgetcsv($filedata);
    while ($row = fgetcsv($filedata))
    {
        print_r($row);
    }*/
    $con = "";
    include ('Library/Connect_DB.php');
    $sql = "SELECT * FROM eating ORDER BY IDEating ASC";
    $query = mysqli_query($con, $sql);
    while($row=mysqli_fetch_array($query)){
        $data[] = $row;
    }
    $sql = "SELECT * FROM locationcar ORDER BY IDLocation ASC";
    $query = mysqli_query($con, $sql);
    while($row=mysqli_fetch_array($query)){
        $data2[] = $row;
    }
    $targetPath = 'FileUploads/' . $_FILES['inputGroupFile01']['name'];
    move_uploaded_file($_FILES['inputGroupFile01']['tmp_name'], $targetPath);

    $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadSheet = $Reader->load($targetPath);
    $excelSheet = $spreadSheet->getActiveSheet();
    $spreadSheetAry = $excelSheet->toArray();
    $sheetCount = count($spreadSheetAry);
    $row = "";
    $id = 0;
    for ($i = 5; $i <= $sheetCount; $i ++) {
        if (isset($spreadSheetAry[$i][1]) && isset($spreadSheetAry[$i][0])) {
            $sql = "SELECT COUNT(*) as ct FROM member,managermember WHERE member.IDMember = managermember.IDMember AND managermember.IDDept='".$iddept."' AND member.IDMember='".$spreadSheetAry[$i][2]."'";
            $query = mysqli_query($con, $sql);
            while($row=mysqli_fetch_array($query)){
                if($row['ct']!=0)
                {
                    $id++;
                    $tt ='<input id="c'.$id.'" type="radio" name="nspt" onclick="choosemanager();" value ="'.$id.'">';
                    if($spreadSheetAry[$i][7]=='x' || $spreadSheetAry[$i][7]=='X')
                        $c7 = '<input id="'.$id.'c7'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'none'".';ReCount()" type="radio" name="'.$id.'" checked>';
                    else
                        $c7='<input id="'.$id.'c7'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'none'".';ReCount()" type="radio" name="'.$id.'"';
                    if($spreadSheetAry[$i][8]=='x' || $spreadSheetAry[$i][8]=='X')
                        $c8 = '<input id="'.$id.'c8'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'" checked>';
                    else
                        $c8='<input id="'.$id.'c8'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'"';
                    if($spreadSheetAry[$i][9]=='x' || $spreadSheetAry[$i][9]=='X')
                        $c9 = '<input id="'.$id.'c9'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'" checked>';
                    else
                        $c9='<input id="'.$id.'c9'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'"';
                    if($spreadSheetAry[$i][10]=='x' || $spreadSheetAry[$i][10]=='X')
                        $c10 = '<input id="'.$id.'c10'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'" checked>';
                    else
                        $c10='<input id="'.$id.'c10'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'"';
                    if($spreadSheetAry[$i][11]=='x' || $spreadSheetAry[$i][11]=='X')
                        $c11 = '<input id="'.$id.'c11'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'" checked>';
                    else
                        $c11='<input id="'.$id.'c12'.'" onclick="document.getElementById('."'".$spreadSheetAry[$i][2]."'".').style.display='."'block'".';ReCount()" type="radio" name="'.$id.'"';
                    $location = '<select id="L'.$spreadSheetAry[$i][2].'" onchange="ReCount();" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;';
                    $location .= '">';
                    foreach ($data2 as $v)
                    {
                        $location.='<option value='.$v['IDLocation'].'';
                        if($spreadSheetAry[$i][12] == $v['VT'])
                            $location .= ' selected ';
                        $location .='>'.$v['NameLocation'].'</option>';
                    }
                    $location .='</select>';
                    $eat = '<select id="'.$spreadSheetAry[$i][2].'" onchange="ReCount();" class="form-control" style="border-radius: 5px;margin-left: 10px;margin-right: 10px;';
                    if($spreadSheetAry[$i][13] == '')
                        $eat .= 'display: none';
                    $eat .= '">';
                    foreach ($data as $v)
                    {
                        $eat.='<option value='.$v['IDEating'].'';
                        if($spreadSheetAry[$i][14] == $v['VT'])
                            $eat .= ' selected ';
                        $eat .='>'.$v['NameEating'].'</option>';
                    }
                    $eat .='</select>';
                    $row = '<tr>
<td>'.$tt.'</td>
<td>' . $id . '</td>
<td>' . $spreadSheetAry[$i][1] . '</td>
<td>' . $spreadSheetAry[$i][2] . '</td>
<td>' . $spreadSheetAry[$i][3] . '</td>
<td>' . $spreadSheetAry[$i][4] . '</td>
<td>' . $spreadSheetAry[$i][5] . '</td>
<td>' . $spreadSheetAry[$i][6] . '</td>
<td>' . $c7 . '</td>
<td>' . $c8 . '</td>
<td>' . $c9 . '</td>
<td>' . $c10 . '</td>
<td>' . $c11 . '</td>
<td>' . $location . '</td>
<td>' . $eat . '</td>
<td>' . $spreadSheetAry[$i][14] . '</td>
</tr>';
                    echo $row;
                }
            }
        }
    }
    unlink($targetPath);
}
?>