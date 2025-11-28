<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string
require_once('conn_db.php');
//資料庫的寫入表格與模式
if (isset($_POST['mode']) && $_POST['mode'] != '') {
    $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
    $mode = $_POST['mode'];
    switch ($mode) {
        // &orderid="+row.orderid+"&remark="+row.remark+"&msid="+msid
        case 'Uorder_Modify':
            $orderid = $_POST['orderid'];
            $remark = $_POST['remark'];
            $msid = $_POST['msid'];
            $stepActive="1";
            $stepNumber="0";
            $adid="1";
            $msidOLD="14";
            $paystatus="";
            $SQL = sprintf("UPDATE `uorder` SET `status` = '%d', `remark` = '%s' WHERE `uorder`.`orderid` = '%s';INSERT INTO `orderstatus` (`orderid`, `stepActive`, `stepNumber`, `adid`, `msid`) VALUES ('%s', '%d', '%d', '%d', '%d');",$msid,$remark,$orderid,$orderid,$stepActive,$stepNumber,$adid,$msidOLD);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "訂單資料更新成功！", "status" => "OK");
            }
            break;
        case 'UorderProduct01_Read':
            $orderid = $_POST['orderid'];
            $SQL = sprintf("SELECT cart.qty,product.p_name,product.p_price,product_img.img_file,ms1.msname as status FROM cart,product,product_img, multiselect as ms1 WHERE cart.orderid='%d' AND ms1.msid=cart.status AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cart.create_date DESC", $orderid);
            $result = $link->query($SQL);
            if ($result) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                $retcode = array("code" => "200", "data" => $data, "message" => "", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'uorder01_Read':
            $orderid = $_POST['orderid'];
            $SQL = sprintf("SELECT uorder.orderid,uorder.create_date AS uorderDate,uorder.remark,ms1.msname AS howpay, ms2.msname AS status,member.email ,addbook.* FROM uorder,(SELECT addbook.*,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE addbook.myzip=town.Post AND town.AutoNo=city.AutoNo) AS addbook, multiselect AS ms1 ,multiselect AS ms2,member WHERE ms2.msid=uorder.status AND ms1.msid=uorder.howpay AND uorder.orderid='%d' AND uorder.emailid=member.emailid AND uorder.addressid=addbook.addressid;", $orderid);
            $result = $link->query($SQL);
            if ($result) {
                $SQL=sprintf("SELECT orderstatus.*,ad_user.adname,multiselect.msname,payinfo.payname FROM orderstatus,ad_user,multiselect,(SELECT uorder.orderid,uorder.howpay,multiselect.msname AS payname FROM uorder,multiselect WHERE uorder.orderid='%s' AND uorder.howpay=multiselect.msid) AS payInfo WHERE orderstatus.adid=ad_user.adid AND orderstatus.msid=multiselect.msid AND orderstatus.orderid='%s' AND orderstatus.orderid=payinfo.orderid",$orderid,$orderid);
                $result1=$link->query($SQL);
                $orderstatus=$result1->fetchAll(PDO::FETCH_ASSOC);
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                $retcode = array("code" => "200", "data" => $data, "message" => $orderstatus, "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'multiSeclect_Read':     //多功能選擇器，依(1,2..)返回對映的功能選擇區段
            $msuplink = $_POST['msuplink'];
            $SQL = sprintf("SELECT * FROM multiselect WHERE msuplink IN (%s) ORDER BY msuplink,msort;", $msuplink);
            $result = $link->query($SQL);
            if ($result) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                $retcode = array("code" => "200", "data" => $data, "message" => "", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'member_SetPW':     //member會員表格，帳號帳號停用/啟動模式
            $emailid = $_POST['emailid'];
            $pw1 = $_POST['pw1'];
            $SQL = sprintf("UPDATE member SET pw1='%s' WHERE member.emailid='%d';", $pw1, $emailid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "會員密碼更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'member_Active':     //member會員表格，帳號帳號停用/啟動模式
            $emailid = $_POST['emailid'];
            $active = $_POST['active'];
            $SQL = sprintf("UPDATE member SET active='%d' WHERE member.emailid='%d';", $active, $emailid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'member_Delete':     //member、addbook表格，資料刪除模式
            $emailid = $_POST['emailid'];
            $SQL = sprintf("DELETE FROM addbook WHERE addbook.emailid ='%d';DELETE FROM member WHERE member.emailid ='%d';", $emailid, $emailid); //member、addbook表格，同時刪除會員與收件人查詢
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "會員與收件人資料刪除成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'member_Update':     //member會員表格，資料更新模式
            $emailid = $_POST['emailid'];
            $cname = $_POST['cname'];
            $active = $_POST['active'];
            $tssn = $_POST['tssn'];
            $birthday = $_POST['birthday'];
            $imgname = $_POST['imgname'];
            $SQL = sprintf("UPDATE member SET active='%d', cname='%s', tssn='%s', birthday='%s', imgname='%s' WHERE member.emailid='%d';", $active, $cname, $tssn, $birthday, $imgname, $emailid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "會員資料更新成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'member_Append':     //member會員表格，資料新增模式
            $email = $_POST['email'];
            $cname = $_POST['cname'];
            $active = $_POST['active'];
            $pw1 = $_POST['pw1'];
            $tssn = $_POST['tssn'];
            $birthday = $_POST['birthday'];
            $mobile = $_POST['mobile'];
            $myzip = $_POST['myzip'];
            $address = $_POST['address'];
            $imgname = $_POST['imgname'];
            $SQL = sprintf("INSERT INTO member (email,pw1,active,cname,tssn,birthday,imgname) VALUES ('%s', '%s', '%d', '%s', '%s', '%s', '%s');", $email, $pw1, $active, $cname, $tssn, $birthday, $imgname);
            $result = $link->query($SQL);
            if ($result) {
                $emailid = $link->lastInsertId();
                $SQL = sprintf("INSERT INTO addbook (setdefault,emailid,cname,mobile,myzip,address) VALUES ('1', '%d', '%s', '%s', '%s', '%s');", $emailid, $cname, $mobile, $myzip, $address);
                $result = $link->query($SQL);
                $retcode = array("code" => "200", "data" => "", "message" => "會員資料儲存成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'addbook_Delete':     //addbook_Delete表格，資料刪除模式
            $addressid = $_POST['addressid'];
            $SQL = sprintf("DELETE FROM addbook WHERE addbook.addressid ='%d';", $addressid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "收件人資料刪除成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'addbook_Save':     //收件人表格，資料新增或更新模式
            $addressid = $_POST['addressid'];
            $cname = $_POST['cname'];
            $emailid = $_POST['emailid'];
            $mobile = $_POST['mobile'];
            $myzip = $_POST['myzip'];
            $setdefault = $_POST['setdefault'];
            $address = $_POST['address'];
            if ($addressid == "") {
                $SQL = sprintf("INSERT INTO addbook (setdefault,emailid,cname,mobile,myzip,address) VALUES ('0', '%d', '%s', '%s', '%s', '%s');", $emailid, $cname, $mobile, $myzip, $address);
            } else {
                $SQL = sprintf("UPDATE addbook SET setdefault='0',cname='%s',mobile='%s',myzip='%s',address='%s' WHERE addbook.addressid='%d';", $cname, $mobile, $myzip, $address, $addressid);
            }
            $result = $link->query($SQL);
            if ($result) {
                if ($addressid == "") {
                    $addressid = $link->lastInsertId();
                }
                if ($setdefault) {
                    $SQL = sprintf("UPDATE addbook SET setdefault='0' WHERE addbook.emailid='%d' AND setdefault='1';UPDATE addbook SET setdefault='1' WHERE addbook.addressid='%d' AND setdefault='0';", $emailid, $addressid);
                    $result = $link->query($SQL);
                }
                $retcode = array("code" => "200", "data" => "", "message" => "收件人資料儲存成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'zip_Read':  
            //city&&town 表格，讀取所有郵遞區號資料，並且整理成element-ui/select分組格式
            $complete = false;
            $options = array();
            $zipOptions = array();
            $SQL = "SELECT * FROM city WHERE 1";
            $result = $link->query($SQL);
            while ($data = $result->fetch()) {
                $SQL = sprintf("SELECT * FROM town WHERE AutoNo='%d'", $data['AutoNo']);
                $result1 = $link->query($SQL);
                while ($data1 = $result1->fetch()) {
                    $zipOptions[] = array("value" => $data1['Post'], "label" => $data1['Post'] . $data1['Name']);
                }
                $options[] = array("label" => $data['Name'], "options2" => $zipOptions);
                $zipOptions = array();
                $complete = true;
            }
            if ($complete) {
                $retcode = array("code" => "200", "data" => $options, "message" => "", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'addbook_Read':     //addbook收件人表格，讀取emailid編號的所有收件人資料
            $emailid = $_POST['emailid'];
            $SQL = sprintf("SELECT * FROM addbook WHERE emailid=%d ORDER BY addressid DESC", $emailid);
            $result = $link->query($SQL);
            if ($result) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                $retcode = array("code" => "200", "data" => $data, "message" => "", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'groupRights_Save':     //group_rights群組權限表格，資料更新模式
            $groupid = $_POST['groupid'];
            $keyData = explode(',', $_POST['keyData']);
            $rightAll = "";
            $SQL = sprintf("DELETE FROM group_rights WHERE groupid='%d'", $groupid); //先刪除原有資料
            $result = $link->query($SQL);
            if ($result) {
                if ($_POST['keyData']!="") {
                    foreach ($keyData as $value) {
                        $rightAll = $rightAll . sprintf("('%d','%d'),", $groupid, $value);
                    }
                    $rightAll = substr($rightAll, 0, -1);
                    //變更後資料全部一次新增寫入
                    $SQL = sprintf("INSERT INTO group_rights (groupid,perid) VALUES %s;", $rightAll);
                    $result = $link->query($SQL);
                }
                $retcode = array("code" => "200", "data" => "", "message" => "功能表權限資料儲存成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'permission_Tree':       //permission表格與group_rights，功能表權限Tree列表模式
            $groupid = $_POST['groupid'];
            $SQL = "SELECT perId,perName as label FROM permission WHERE perLevel=1 ORDER BY create_date";
            $result = $link->query($SQL);
            if ($result) {
                $dLevel1 = $result->fetchAll(); //查詢第一層所有資料
                for ($i = 0; $i < count($dLevel1); $i++) {
                    $SQL = sprintf("SELECT perId,perName as label FROM permission WHERE perLevel=2 AND perUpLink=%d ORDER BY create_date", $dLevel1[$i]['perId']);
                    $result1 = $link->query($SQL); //查詢第二層所有資料
                    $dLevel1[$i]['children'] = $result1->fetchAll(PDO::FETCH_ASSOC);
                    for ($j = 0; $j < count($dLevel1[$i]['children']); $j++) {
                        $SQL = sprintf("SELECT perId,perName as label FROM permission WHERE perLevel=3 AND perUpLink=%d ORDER BY create_date", $dLevel1[$i]['children'][$j]['perId']);
                        $result2 = $link->query($SQL); //查詢第三層按鈕所有資料
                        $dLevel1[$i]['children'][$j]['children'] = $result2->fetchAll(PDO::FETCH_ASSOC);
                    }
                }
                $SQL = sprintf("SELECT perId FROM group_rights WHERE groupid='%d' ", $groupid);
                $result = $link->query($SQL);
                $data = $result->fetchAll(PDO::FETCH_NUM);
                //資料回傳data=>回傳功能所有列表，message=>回傳群組權限設定
                $retcode = array("code" => "200", "data" => $dLevel1, "message" => $data, "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;

        case 'permission_Delete':     //permission表格，資料刪除模式
            $perId = $_POST['perId'];
            $SQL = sprintf("DELETE FROM permission WHERE perId IN (WITH RECURSIVE RecursiveHierarchy AS ( SELECT perId, perUpLink FROM permission WHERE perId = '%d' UNION ALL SELECT t.perId, t.perUpLink FROM permission t INNER JOIN RecursiveHierarchy rh ON t.perUpLink = rh.perId ) SELECT perId FROM RecursiveHierarchy);", $perId); //查詢功能表編號以及相依的子功能後，全部一併刪除
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "群組帳號刪除成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'permission_read':     //permission表格，讀取單一筆資料
            $perId = $_POST['perId'];
            $SQL = sprintf("SELECT * FROM permission WHERE perId=%d", $perId);
            $result = $link->query($SQL);
            if ($result) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                $retcode = array("code" => "200", "data" => $data, "message" => "", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'permission_Update':     //permission表格，資料更新模式
            $perId = $_POST['perId'];
            $perName = $_POST['perName'];
            $perValue = $_POST['perValue'];
            $routeValue = $_POST['routeValue'];
            $SQL = sprintf("UPDATE permission SET perName='%s', perValue='%s', routeValue='%s' WHERE permission.perId='%d';", $perName, $perValue, $routeValue, $perId);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "功能表資料更新成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'permission_Append':     //permission表格，資料新增模式
            $perName = $_POST['perName'];
            $perValue = $_POST['perValue'];
            $routeValue = $_POST['routeValue'];
            $perLevel = $_POST['perLevel'];
            $perType = $_POST['perType'];
            $perUpLink = $_POST['perUpLink'];
            $SQL = sprintf("INSERT INTO permission (perName,perValue,routeValue,perLevel,perType,perUpLink) VALUES ('%s', '%s', '%s', '%d', '%d','%d');", $perName, $perValue, $routeValue, $perLevel, $perType, $perUpLink);
            $result = $link->query($SQL);
            if ($result) {
                $lastID = $link->lastInsertId();
                $retcode = array("code" => "200", "data" => array("perId" => $lastID), "message" => "功能表資料新增成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'permission_List':       //permission表格，功能表權限列表模式
            $SQL = "SELECT * FROM permission WHERE perLevel=1 ORDER BY create_date";
            $result = $link->query($SQL);
            if ($result) {
                $dLevel1 = $result->fetchAll(); //查詢第一層所有資料
                for ($i = 0; $i < count($dLevel1); $i++) {
                    $SQL = sprintf("SELECT * FROM permission WHERE perLevel=2 AND perUpLink=%d ORDER BY create_date", $dLevel1[$i]['perId']);
                    $result1 = $link->query($SQL); //查詢第二層所有資料
                    $dLevel1[$i]['children'] = $result1->fetchAll(PDO::FETCH_ASSOC);
                    for ($j = 0; $j < count($dLevel1[$i]['children']); $j++) {
                        $SQL = sprintf("SELECT * FROM permission WHERE perLevel=3 AND perUpLink=%d ORDER BY create_date", $dLevel1[$i]['children'][$j]['perId']);
                        $result2 = $link->query($SQL); //查詢第三層按鈕所有資料
                        $dLevel1[$i]['children'][$j]['children'] = $result2->fetchAll(PDO::FETCH_ASSOC);
                    }
                }
                $retcode = array("code" => "200", "data" => $dLevel1, "message" => "", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adGroup_Active':          //adGroup表格，群組帳號停用/啟動模式
            $groupid = $_POST['groupid'];
            $active = $_POST['active'];
            $SQL = sprintf("UPDATE ad_group SET active='%d' WHERE ad_group.groupid='%d';", $active, $groupid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "群組(停用/啟動)更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adGroup_Delete':     //adgroup表格，資料刪除模式
            $groupid = $_POST['groupid'];
            $SQL = sprintf("DELETE FROM ad_group WHERE ad_group.groupid ='%d';", $groupid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "群組帳號刪除成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adGroup_Update':     //ad_group表格，資料更新模式
            $groupid = $_POST['groupid'];
            $gpname = $_POST['gpname'];
            $gpename = $_POST['gpename'];
            $active = $_POST['active'];
            $remark = $_POST['remark'];
            $SQL = sprintf("UPDATE ad_group SET gpname='%s', gpename='%s', active='%d', remark='%s'  WHERE ad_group.groupid='%d';", $gpname, $gpename, $active, $remark, $groupid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "系統群組帳號更新成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adGroup_Append':     //ad_group表格，資料新增模式
            $gpname = $_POST['gpname'];
            $gpename = $_POST['gpename'];
            $active = $_POST['active'];
            $remark = $_POST['remark'];
            $SQL = sprintf("INSERT INTO ad_group (gpname, gpename, active, remark) VALUES ('%s', '%s', '%d', '%s');", $gpname, $gpename, $active, $remark);
            $result = $link->query($SQL);
            if ($result) {
                $lastID = $link->lastInsertId();
                $retcode = array("code" => "200", "data" => array("addressid" => $lastID), "message" => "系統群組帳號新增成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adUser_Active':     //adUser表格，帳號帳號停用/啟動模式
            $adid = $_POST['adid'];
            $active = $_POST['active'];
            $SQL = sprintf("UPDATE ad_user SET active='%d' WHERE ad_user.adid='%d';", $active, $adid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adUser_SetPW':     //adUser表格，密碼變更設定模式
            $adid = $_POST['adid'];
            $adname = $_POST['adname'];
            $adpasswd = $_POST['adpasswd'];
            $SQL = sprintf("UPDATE ad_user SET adpasswd='%s' WHERE ad_user.adid='%d';", $adpasswd, $adid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "管理者：" . $adname . "密碼更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adUser_Delete':     //adUser表格，資料刪除模式
            $adid = $_POST['adid'];
            $SQL = sprintf("DELETE FROM ad_user WHERE ad_user.adid ='%d';", $adid);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "管理者帳號刪除成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adUser_Append':     //adUser表格，資料新增模式
            $adlogin = $_POST['adlogin'];
            $adname = $_POST['adname'];
            $active = $_POST['active'];
            $addressid = $_POST['addressid'];
            $adpasswd = $_POST['adpasswd'];
            $ademail = $_POST['ademail'];
            $avatar = $_POST['avatar'];
            $allowip = $_POST['allowip'];
            $remark = $_POST['remark'];
            $SQL = sprintf("INSERT INTO ad_user (adlogin, adname, active, addressid, adpasswd, ademail, avatar, allowip, remark) VALUES ('%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s');", $adlogin, $adname, $active, $addressid, $adpasswd, $ademail, $avatar, $allowip, $remark);
            $result = $link->query($SQL);
            if ($result) {
                $lastID = $link->lastInsertId();
                $retcode = array("code" => "200", "data" => array("adid" => $lastID), "message" => "管理者帳號新增成功！", "status" => "OK");     //建立回傳陣列
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'adUser_Update':     //adUser表格，資料更新模式
            $adid = $_POST['adid'];
            $adname = $_POST['adname'];
            $active = $_POST['active'];
            $addressid = $_POST['addressid'];
            $ademail = $_POST['ademail'];
            $avatar = $_POST['avatar'];
            $allowip = $_POST['allowip'];
            $remark = $_POST['remark'];
            $SQL = sprintf("UPDATE ad_user SET adname='%s', active='%d', addressid='%d', ademail= '%s', avatar='%s',allowip='%s', remark='%s'  WHERE ad_user.adid='%d';", $adname, $active, $addressid, $ademail, $avatar, $allowip, $remark, $adid);
            $result = $link->query($SQL);
            if ($result) {
                //建立回傳陣列
                $retcode = array("code" => "200", "data" => "", "message" => "管理者帳號更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;

        case 'p_Open_Update':     //product內產品上/下架p_open欄位資料更新
            $p_id = $_POST['p_id'];
            $p_open = $_POST['p_open'];
            $SQL = sprintf("UPDATE product SET p_open='%s' WHERE product.p_id='%d';", $p_open, $p_id);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "產品產品上/下架資料更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "200", "data" => "", "message" => "抱歉！資料無法寫入後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'P_Content_Update':     //product內產品詳細規格p_content資料更新
            $p_id = $_POST['p_id'];
            $p_content = $_POST['p_content'];
            $SQL = sprintf("UPDATE product SET p_content='%s' WHERE product.p_id='%d';", addslashes($p_content), $p_id);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "產品詳細規格資料更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "200", "data" => "", "message" => "抱歉！資料無法寫入後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'product_Append':     //product,product_img表格，資料新增模式，需寫入兩個表格
            $classid = $_POST['classid'];
            $p_name = $_POST['p_name'];
            $p_intro = $_POST['p_intro'];
            $p_price = $_POST['p_price'];
            $p_open = $_POST['p_open'];
            $SQL = sprintf("INSERT INTO `product` (classid, p_name, p_intro, p_price, p_open,p_content) VALUES ('%d', '%s', '%s', '%d', '%d','<p></p>');", $classid, $p_name, $p_intro, $p_price, $p_open);
            $result = $link->query($SQL);
            if ($result) {
                $lastID = $link->lastInsertId();
                $img_file = "";
                $sort = 1;
                $SQL01 = "INSERT INTO `product_img` (p_id, img_file, sort) VALUES (:p_id,:img_file,:sort)";
                $readyImg = $link->prepare($SQL01);
                $readyImg->bindParam(':p_id', $lastID);
                $readyImg->bindParam(':img_file', $img_file);
                $readyImg->bindParam(':sort', $sort);
                for ($i = 0; $i < count($_POST['img_file']); $i++) {
                    $img_file = $_POST['img_file'][$i];
                    $sort = $i + 1;
                    $readyImg->execute();
                }
                //建立回傳陣列
                $retcode = array("code" => "200", "data" => "", "message" => "產品資料新增成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
        case 'product_Update':     //產品product資料表格更新
            $p_id = $_POST['p_id'];
            $classid = $_POST['classid'];
            $p_name = $_POST['p_name'];
            $p_intro = $_POST['p_intro'];
            $p_price = $_POST['p_price'];
            $p_open = $_POST['p_open'];
            $SQL = sprintf("UPDATE product SET classid='%d', p_name='%s', p_intro='%s', p_price='%d', p_open='%d' WHERE product.p_id='%d';", $classid, $p_name, $p_intro, $p_price, $p_open, $p_id);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "產品資料更新成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "200", "data" => "", "message" => "抱歉！資料無法寫入後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;

        case 'product_img_del_db':  //刪除product_img所選擇的圖片
            $fileName = $_POST['fileName'];
            $p_id = $_POST['p_id'];
            //刪除所選擇的圖片
            $SQL = sprintf("DELETE FROM product_img WHERE product_img.p_id='%d' AND product_img.img_file='%s'", $p_id, $fileName);
            $result = $link->query($SQL);
            //刪除圖片後，設定圖片重新排序
            $SQL = sprintf("SELECT img_file FROM product_img WHERE product_img.p_id='%d'  ORDER BY sort", $p_id);
            $result = $link->query($SQL);
            if ($result->rowCount() != 0) {
                $data = $result->fetchAll();
                foreach ($data as $key => $item) {
                    $SQL = sprintf("UPDATE product_img SET sort='%d' WHERE product_img.p_id='%d' AND product_img.img_file='%s';", $key + 1, $p_id, $item['img_file']);
                    $result01 = $link->query($SQL);
                }
            }
            $retcode = array("code" => "200", "data" => "", "message" => "產品圖片資料刪除成功！", "status" => "OK");
            break;
        case 'ProductDel':          //刪除product與product_img表格所有圖片資料
            $p_id = $_POST['p_id'];
            $SQL = sprintf("DELETE FROM product WHERE product.p_id='%d';DELETE FROM product_img WHERE product_img.p_id='%d';", $p_id, $p_id);
            $result = $link->query($SQL);
            if ($result) {
                $retcode = array("code" => "200", "data" => "", "message" => "產品資料刪除成功！", "status" => "OK");
            } else {
                $retcode = array("code" => "200", "data" => "", "message" => "抱歉！資料無法寫入後台資料庫，請連絡管理人員。", "status" => "ERROR");
            }
            break;
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
