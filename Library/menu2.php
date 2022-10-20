<?php
if(isset($_SESSION['idmember']))
{
    $username = $_SESSION['Name'];
    $idmember = $_SESSION['idmember'];
    $namedept = $_SESSION['NameDept'];
    $iddept = $_SESSION['IDDept'];
    $nameposition = $_SESSION['NamePosition'];
    $idposition = $_SESSION['IDPosition'];
    $idgroup = $_SESSION['IDGroup'];
}
else
{
    $username = "No Name";
    header("Location: "."../RD/Index.php");
}
function checknamefunction($id)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $v="";
    $sql="SELECT NameFunction FROM funtion WHERE IDFunction='".$id."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $v=$row['NameFunction'];
    }
    return $v;
}
function checkstatus($idfunction,$idfile)
{
    $con = "";
    include ('Library/Connect_DB.php');
    $numberapprove=0;
    $v="";
    $status="";
    $sql="SELECT NumberApprove FROM funtion WHERE IDFunction='".$idfunction."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        $numberapprove = $row['NumberApprove'];
    }
    $sql="SELECT COUNT(*) as ct FROM approve WHERE IDFile='".$idfile."' AND Approved=1";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($row['ct']==$numberapprove) {
            $v = "<span class='badge badge-success' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã duyệt</span>";
            $status="S0003";
        }
        else {
            $v = "<span class='badge badge-warning' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đang duyệt</span>";
            $status="S0002";
        }
    }

    $sql2 ="SELECT * FROM approve WHERE IDFile='".$idfile."' AND Approved=0";
    $query2 = mysqli_query($con,$sql2);
    while ($row = mysqli_fetch_array($query2))
    {
        if($_SESSION['idmember'] == $row['IDMember'])
        {
            if($row['No']>1) {
                $nonew = $row['No']-1;
                $sql3 = "SELECT COUNT(*) as ct FROM approve WHERE Approved=1 AND No='" . $nonew . "' AND IDFile='" . $idfile . "'";
                $query3 = mysqli_query($con, $sql3);
                while ($row2 = mysqli_fetch_array($query3)) {
                    if ($row2['ct'] > 0) {
                        $v = "<span class='badge badge-primary' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Cần duyệt</span>";
                        $status = "S0005";
                    }
                }
            }
            else
            {
                $v = "<span class='badge badge-primary' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Cần duyệt</span>";
                $status = "S0005";
            }
        }
    }
    $sql="SELECT Deny FROM managerfile WHERE IDFile='".$idfile."'";
    $query = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($query))
    {
        if($row['Deny']==1) {
            $v = "<span class='badge badge-danger' style='width: 100px;height: 30px;font-size: 14px;font-family: Tahoma;line-height: 20px'>Đã từ chối</span>";
            $status="S0004";
        }
    }

    return array($v,$status);
}
$show = 0;
$show2 = 0;
if($idgroup=='G0001') {
    $con = "";
    $id = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT managerfile.IDFile,member.FullName,funtion.NameFunction,managerfile.Timestamp FROM managerfile,member,funtion,dept,managermember WHERE managerfile.IDMember=member.IDMember AND managerfile.IDFuntion = funtion.IDFunction AND member.IDMember = managermember.IDMember AND managermember.IDDept = dept.IDDept AND funtion.IDFunction in (SELECT funtion.IDFunction from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND member.IDMember='" . $idmember . "') ORDER BY managerfile.Timestamp DESC";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $id = substr($row['IDFile'], 0, 5);
            $status = checkstatus(substr($row['IDFile'], 0, 5), $row['IDFile']);
            if ($status[1] == "S0005") {
                $show = 1;
                $link = "../RD/" . $id . ".php?id=" . $row['IDFile'];
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currenday = date('Y-m-d\TH:i');
                $day = (strtotime($currenday) - strtotime($row['Timestamp']));
                if ($day < 60)
                    $notify[] = array("FullName" => $row['FullName'], "Time" => $day . " giây", "Link" => $link, "NameFunction" => "trình duyệt ".checknamefunction($id));
                else if (floor($day / 60) < 60)
                    $notify[] = array("FullName" => $row['FullName'], "Time" => floor($day / 60) . " phút", "Link" => $link, "NameFunction" => "trình duyệt ".checknamefunction($id));
                else if (floor($day / (60 * 60)) < 24)
                    $notify[] = array("FullName" => $row['FullName'], "Time" => floor($day / (60 * 60)) . " giờ", "Link" => $link, "NameFunction" => "trình duyệt ".checknamefunction($id));
                else $notify[] = array("FullName" => $row['FullName'], "Time" => floor($day / (60 * 60 * 24)) . " ngày", "Link" => $link, "NameFunction" => "trình duyệt ".checknamefunction($id));
            }
        }
    }
}
else if($idgroup !=='G0006')
{
    $con = "";
    include('Library/Connect_DB.php');
    $sql = "SELECT IDFile FROM managerfile WHERE IDMemberCreate = '".$idmember."' AND IDFile IN (SELECT IDFile FROM approve WHERE ShowNotify=0) ORDER BY Timestamp DESC";
    $query = mysqli_query($con, $sql);
    if ($query->num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $sql2="SELECT approve.IDFile,member.IDMember,approve.Approved,member.FullName,approve.Deny,approve.TimeStamp FROM approve,member WHERE member.IDMember = approve.IDMember AND ShowNotify = 0 AND approve.IDFile='".$row['IDFile']."'";
            $query2 = mysqli_query($con, $sql2);
            if ($query2->num_rows > 0) {
                while ($row2 = mysqli_fetch_array($query2)) {
                    $show=1;$show2=1;
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $currenday = date('Y-m-d\TH:i');
                    $day = (strtotime($currenday) - strtotime($row2['TimeStamp']));
                    $id = substr($row2['IDFile'], 0, 5);
                    $link = "../RD/" . $id . ".php?id=" . $row['IDFile'] . "";
                    if($row2['Approved']==1)
                    {
                        if ($day < 60)
                            $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => $day . " giây", "Link" => $link, "NameFunction" => "đã duyệt ".checknamefunction($id));
                        else if (floor($day / 60) < 60)
                            $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => floor($day / 60) . " phút", "Link" => $link, "NameFunction" => "đã duyệt ".checknamefunction($id));
                        else if (floor($day / (60 * 60)) < 24)
                            $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60)) . " giờ", "Link" => $link, "NameFunction" => "đã duyệt ".checknamefunction($id));
                        else $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60 * 24)) . " ngày", "Link" => $link, "NameFunction" => "đã duyệt ".checknamefunction($id));
                    }
                    if($row2['Deny']==1)
                    {
                        if ($day < 60)
                            $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => $day . " giây", "Link" => $link, "NameFunction" => "đã từ chối ".checknamefunction($id));
                        else if (floor($day / 60) < 60)
                            $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => floor($day / 60) . " phút", "Link" => $link, "NameFunction" => "đã từ chối ".checknamefunction($id));
                        else if (floor($day / (60 * 60)) < 24)
                            $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60)) . " giờ", "Link" => $link, "NameFunction" => "đã từ chối ".checknamefunction($id));
                        else $notify[] = array("IDFile"=>$row2['IDFile'],"IDMember"=>$row2['IDMember'],"FullName" => $row2['FullName'], "Time" => floor($day / (60 * 60 * 24)) . " ngày", "Link" => $link, "NameFunction" => "đã từ chối ".checknamefunction($id));
                    }
                }
            }
        }
    }
}
?>
<nav class="navbar bg-white navbar-white fixed-top mt-0" style="height: 60px;box-shadow: 5px 10px 8px #888888">
    <div class=".container-fluid" style="width: 100%;min-width: 1080px">
        <div id="main-menu" class="row navabar">

            <div id="main-logo" class="col-2.6">
                <a href="Main.php" class="ml-2">
                    <img src="images/LOGO%20THACO%20AUTO.png" height="50" alt="Banner"/>
                </a>
            </div>
            <div id="main-title" class="col-2 ml-0 mt-1">
                <div style="clear: left"><h7 >R&D Ô TÔ</h7></div>
            </div>
            <div id="menu-banner" class="col">
                <nav id="main-menu-banner">
                    <ul>
                        <?php
                        $con="";
                        include ('Library/Connect_DB.php');
                        $sql = "SELECT funtion.LinkFunction,funtion.NameFunction,funtion.IDFunction,funtion.MultiPage from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND decentralization.FunctionParent='F0000' AND member.IDMember='".$idmember."'";
                        $query = mysqli_query($con,$sql);
                        if(mysqli_num_rows($query)!=0)
                        {
                            while ($row=$query->fetch_assoc())
                            {
                                ?>
                                <li><a href='<?php if($row['LinkFunction']!='#')  { if($row['MultiPage']    ) {echo $row['LinkFunction'].'?page=1';} else {echo $row['LinkFunction'];}} else echo $row['LinkFunction']; ?>' title='<?php echo $row["NameFunction"]?>' ><?php echo $row["NameFunction"]?><span class='ml-2' style='margin-top: 25px;font-size:9px'>&#9660</span></a>
                                    <?php
                                $sql2 = "SELECT funtion.LinkFunction,funtion.NameFunction,funtion.IDFunction,funtion.MultiPage from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND decentralization.FunctionParent='".$row['IDFunction']."' AND member.IDMember='".$idmember."'";
                                $query2 = mysqli_query($con,$sql2);
                                if(mysqli_num_rows($query2)!=0)
                                {?>
                                    <ul id="sub-menu-banner">
                                        <?php
                                        while ($row2=$query2->fetch_assoc()){?>
                                            <li><a href="<?php if($row2['LinkFunction']!='#')  { if($row2['MultiPage']) {echo $row2['LinkFunction'].'?page=1';} else {echo $row2['LinkFunction'];}} else echo $row2['LinkFunction']; ?>" title="<?php echo $row2['NameFunction'] ?>"><?php echo $row2['NameFunction'] ?></a>
                                            <?php
                                            $sql3 = "SELECT funtion.LinkFunction,funtion.NameFunction,funtion.IDFunction,funtion.MultiPage from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND decentralization.FunctionParent='".$row2['IDFunction']."' AND member.IDMember='".$idmember."'";
                                            $query3 = mysqli_query($con,$sql3);
                                            if(mysqli_num_rows($query3)!=0)
                                            {?>
                                                <ul id="sub-menu-banner2">
                                                <?php
                                                while ($row3=$query3->fetch_assoc()){?>
                                                    <li><a href="<?php if($row3['LinkFunction']!='#')  { if($row3['MultiPage']) {echo $row3['LinkFunction'].'?page=1';} else {echo $row3['LinkFunction'];}} else echo $row3['LinkFunction']; ?>" title="<?php echo $row3['NameFunction'] ?>"><?php echo $row3['NameFunction'] ?></a>
                                                        <?php
                                                        $sql4 = "SELECT funtion.LinkFunction,funtion.NameFunction,funtion.IDFunction,funtion.MultiPage from funtion,decentralization,member,managermember,position,groupmember WHERE funtion.IDFunction = decentralization.FunctionChild AND member.IDMember = managermember.IDMember AND managermember.IDPosition = position.IDPosition AND position.IDGroup = groupmember.IDGroup AND groupmember.IDGroup = decentralization.IDGroup AND decentralization.FunctionParent='".$row3['IDFunction']."' AND member.IDMember='".$idmember."'";
                                                        $query4 = mysqli_query($con,$sql4);
                                                        if(mysqli_num_rows($query4)!=0)
                                                        {?>
                                                        <ul id="sub-menu-banner3">
                                                            <?php
                                                            while ($row4=$query4->fetch_assoc()){?>
                                                                <li><a href="<?php if($row4['LinkFunction']!='#')  { if($row4['MultiPage']) {echo $row4['LinkFunction'].'?page=1';} else {echo $row4['LinkFunction'];}} else echo $row4['LinkFunction']; ?>" title="<?php echo $row4['NameFunction'] ?>"><?php echo $row4['NameFunction'] ?></a></li>
                                                                <?php } ?>
                                                        </ul>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                                </ul>
                                            <?php }?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php }
                            }
                        }
                        ?>
                        <li id="sub-logout"><a href="Library/logout.php" style="text-decoration: underline;font-family: Tahoma" title="Đăng xuất">Đăng xuất</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Tắt chuông thông báo -->
            <div id="main-aleft" class="col-0.5" style="margin-top: 15px;width: 50px">
                <div class="wrapper">
                    <div class="notification_wrap">
                        <div class="notification_icon">
                            <button onclick="$('.dropdown').toggleClass('active');console.log('open');" style="display: grid">
                            <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#707070" d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"></path></svg>
                                <span id = "itemnotify" class="itemnotify" id="not-count">

                                </span>
                            </button>
                        </div>
                        <div id="dropdown" class="dropdown" style="max-height: 300px;overflow: auto;margin: 0px -150px">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tắt chuông thông báo -->
            <div id="main-user" class="col-1.5"  style="margin-top: 14px">
                <p style="color: bule; font-family: Tahoma">Hi! <a style="color: bule; font-family: Tahoma"><?php  echo $username;?></a></p>
            </div>
            <div id="main-logout" class="col-1 "  style="margin-top: 14px">
                <a href="Library/logout.php" style="color: red;text-decoration: underline;font-family: Tahoma" title="Đăng xuất">Đăng xuất</a>
            </div>
        </div>
    </div>
</nav>