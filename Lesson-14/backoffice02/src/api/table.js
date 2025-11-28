import request from '@/utils/request';
import { MD5 } from '@/utils/commlib';    //使用自訂函數MD5

// import defaultSettings from '@/settings' //連結平台環境設定參
// const db_Url = defaultSettings.ecPlatForm.db_Url; //取出電商平台資料庫網址
// import { mapGetters } from 'vuex';
// const db_Url = store.settings.ecPlatForm.db_Url; //取出電商平台資料庫網址
// const db_Url = this.$store.state.settings.ecPlatForm.ec_Url;
// debugger;

const db_Url = ""; //取出電商平台資料庫網址

//到資料庫uorder更新訂單狀態，並且新增orderstatus()
export const reqConfirmOrder=(row,msid)=>{
  debugger;
  let toDBstr;
  toDBstr="mode=Uorder_Modify&orderid="+row.orderid+"&remark="+row.remark+"&msid="+msid;     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//到Uorder=>product取出訂單的產品資料
export const reqUorderProduct01=(orderid)=>{
  let toDBstr;
  toDBstr="mode=UorderProduct01_Read&orderid="+orderid;     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//到資料庫Uorder取出訂單與收件人資料
export const reqUorder01=(orderid)=>{
  let toDBstr;
  toDBstr="mode=uorder01_Read&orderid="+orderid;     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//呼叫資料庫，取回會員訂單的分頁資料，表格為：uorder
export const reqGetUorder01 = (page, limit,table,keyWord,emailid) => {
  let dateRangeStr="";
  if(keyWord.dateRange[0]!=undefined){
    dateRangeStr=`&dateRange0=${keyWord.dateRange[0]}&dateRange1=${keyWord.dateRange[1]}`;
  }
  return request({ url: `${db_Url}reqTable.php?page=${page}&table=${table}&limit=${limit}&orderId=${keyWord.orderId}&account=${keyWord.account}&receiver=${keyWord.receiver}${dateRangeStr}&howpay=${keyWord.howpay}&status=${keyWord.status}&emailid=${emailid}`, method: 'GET' });
};
//多功能選擇器的資料，依msuplink屬於那一個msid編號讀出
export const reqMultiSelect=(msuplink)=>{
  let toDBstr;
  toDBstr="mode=multiSeclect_Read&msuplink="+msuplink;     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//會員密碼設定功能
export const reqMemberPW=(memberPW)=>{
  let toDBstr;
  toDBstr="emailid="+memberPW.emailid+
          "&pw1="+MD5(memberPW.pw1)+
          "&mode=member_SetPW";       //帳號密碼設定功能
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//會員帳號停用/啟用功能
export const reqMemberActive=(member)=>{
  let toDBstr;
  toDBstr="emailid="+member.emailid+
          "&active="+member.active+
          "&mode=member_Active";       //帳號(停用/啟用)功能
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//會員資料表member刪除模式
export const reqMemberDel=(emailid)=>{
  let toDBstr;
  toDBstr="emailid="+emailid+
          "&mode=member_Delete";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//會員帳號表單分為新增資料與更新資料兩種模式
export const reqMemberSave=(member)=>{
  let toDBstr;
  if (!member.emailid) {
    toDBstr="email="+member.email+
            "&cname="+member.cname+
            "&active="+member.active+
            "&pw1="+MD5(member.pw1)+
            "&tssn="+member.tssn+
            "&birthday="+member.birthday+
            "&mobile="+member.mobile+
            "&myzip="+member.myzip+
            "&address="+member.address+
            "&imgname="+member.imgname+
            "&mode=member_Append";       //資料新增模式
  } else {
    toDBstr="emailid="+member.emailid+
            "&cname="+member.cname+
            "&active="+member.active+
            "&tssn="+member.tssn+
            "&birthday="+member.birthday+
            "&imgname="+member.imgname+
            "&mode=member_Update";       //資料更新模式
  }
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//呼叫後端資料庫，取回會員帳號的分頁資料，表格為：Member
export const reqMemberList01 = (page, limit,table,keyWord) => {
  return request({ url: `${db_Url}reqTable.php?page=${page}&table=${table}&limit=${limit}&keyWord=${keyWord}`, method: 'GET' });
};
//收件人資料表addbook刪除模式
export const reqDelAddBook=(addressid)=>{
  let toDBstr;
  toDBstr="addressid="+addressid+
          "&mode=addbook_Delete";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//收件人資料表addbook寫入模式
export const reqAddBookSave=(row)=>{
  let toDBstr;
  toDBstr="addressid="+row.addressid+"&cname="+row.cname+"&emailid="+row.emailid+
          "&mobile="+row.mobile+"&myzip="+row.myzip+"&setdefault="+row.setdefault+
          "&address="+row.address+
          "&mode=addbook_Save";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//city&town資料表，郵遞區號讀取模式
export const reqZip01=()=>{
  let toDBstr;
  toDBstr="mode=zip_Read";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//收件人資料表addbook讀取列表模式
export const reqAddBook01=(emailid)=>{
  let toDBstr;
  toDBstr="emailid="+emailid+
          "&mode=addbook_Read";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//取得資料庫member email欄位符合驗證email所有帳號的計數
export const reqMemberCount = (email) => {
  return request({ url: `${db_Url}reqTableAll.php?mode=memberCount&email=${email}`, method: 'GET' });
};


//從Tree編輯的資料，保存到group_rights資料表
export const reqsaveGupPermission=(keyData,groupid)=>{
  let toDBstr;
  toDBstr="groupid="+groupid+
        "&keyData="+keyData.toString()+
        "&mode=groupRights_Save";           
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//功能資料表permission與group_rights讀取列表模式
export const reqPermissionTree01=(groupid)=>{
  let toDBstr;
  //查詢permission所有功能列資料，與group_rights的群組功能權限資料
  toDBstr="groupid="+groupid+
        "&mode=permission_Tree";       
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//功能資料表permission刪除主功能與子功能模式
export const reqDelPermission=(perId)=>{
  let toDBstr;
  toDBstr="perId="+perId+
          "&mode=permission_Delete";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//功能資料表permission讀取列表模式
export const reqGetPermissionInfo=(perId)=>{
  let toDBstr;
  toDBstr="perId="+perId+
          "&mode=permission_read";     
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//功能資料表permission(新增/更新)模式
export const reqSavePermission=(permission)=>{
  let toDBstr;
  if (!permission.perId) {
    toDBstr="perName="+permission.perName+
            "&perValue="+permission.perValue+
            "&routeValue="+permission.routeValue+
            "&perLevel="+permission.perLevel+
            "&perType="+permission.perType+
            "&perUpLink="+permission.perUpLink+
            "&mode=permission_Append";       //資料新增模式
  } else {
    toDBstr="perId="+permission.perId+
        "&perName="+permission.perName+
        "&perValue="+permission.perValue+
        "&routeValue="+permission.routeValue+
        "&mode=permission_Update";       //資料更新模式
  }
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//功能資料表permission讀取列表模式
export const reqPermissionList01=()=>{
  let toDBstr;
  toDBstr="mode=permission_List";       //查詢permission所有資料，不限條件
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};

//群組帳號停用/啟用功能
export const reqAdGroupActive=(adGroup)=>{
  let toDBstr;
  toDBstr="groupid="+adGroup.groupid+
          "&active="+adGroup.active+
          "&mode=adGroup_Active";       //群組帳號(停用/啟用)功能
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//群組帳號刪除功能模式
export const reqAdGroupDel=(adGroup)=>{
  let toDBstr;
  toDBstr="groupid="+adGroup.groupid+"&mode=adGroup_Delete";       //資料刪除模式
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//群組管理表單分為(新增/更新)資料兩種模式
export const reqAdGroupAccess=(adGroup)=>{
  let toDBstr;
  if (!adGroup.groupid) {
    toDBstr="gpname="+adGroup.gpname+
            "&gpename="+adGroup.gpename+
            "&active="+adGroup.active+
            "&remark="+adGroup.remark+
            "&mode=adGroup_Append";       //資料新增模式
  } else {
    toDBstr="groupid="+adGroup.groupid+
            "&gpname="+adGroup.gpname+
            "&gpename="+adGroup.gpename+
            "&active="+adGroup.active+
            "&remark="+adGroup.remark+
            "&mode=adGroup_Update";       //資料更新模式
  }
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//取得資料庫ad_group gpname欄位群組名稱是否重覆
export const reqAdGroupCount = (gpname) => {
  return request({ url: `${db_Url}reqTableAll.php?mode=adGroupCount&gpname=${gpname}`, method: 'GET' });
};
//呼叫後端資料庫，取回table的分頁資料，表格為：傳入table
export const reqDbList01 = (page, limit,table,keyWord) => {
  return request({ url: `${db_Url}reqTable.php?page=${page}&table=${table}&limit=${limit}&keyWord=${keyWord}`, method: 'GET' });
};
//管理者帳號停用/啟用功能
export const reqAdUserActive=(adUser)=>{
  let toDBstr;
  toDBstr="adid="+adUser.adid+
          "&active="+adUser.active+
          "&mode=adUser_Active";       //帳號(停用/啟用)功能
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//管理者密碼設定功能
export const reqAdUserPW=(adUserPW)=>{
  let toDBstr;
  toDBstr="adid="+adUserPW.adid+
          "&adname="+adUserPW.adname+
          "&adpasswd="+MD5(adUserPW.pw1)+
          "&mode=adUser_SetPW";       //帳號密碼設定功能
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//管理者帳號刪除功能模式
export const reqAdUserDel=(adUser)=>{
  let toDBstr;
  toDBstr="adid="+adUser.adid+"&mode=adUser_Delete";       //資料刪除模式
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//管理者帳號表單分為新增資料與更新資料兩種模式
export const reqAdUserAccess=(adUser)=>{
  let toDBstr;
  if (!adUser.adid) {
    toDBstr="adlogin="+adUser.adlogin+
            "&adname="+adUser.adname+
            "&active="+adUser.active+
            "&groupid="+adUser.groupid+
            "&adpasswd="+MD5(adUser.adpasswd)+
            "&ademail="+adUser.ademail+
            "&avatar="+adUser.avatar+
            "&allowip="+adUser.allowip+
            "&remark="+adUser.remark+
            "&mode=adUser_Append";       //資料新增模式
  } else {
    toDBstr="adid="+adUser.adid+
            "&adname="+adUser.adname+
            "&active="+adUser.active+
            "&groupid="+adUser.groupid+
            "&ademail="+adUser.ademail+
            "&avatar="+adUser.avatar+
            "&allowip="+adUser.allowip+
            "&remark="+adUser.remark+
            "&mode=adUser_Update";       //資料更新模式
  }
  return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
};
//取得資料庫adUser adlogin欄位符合驗證adlogin所有帳號的資料
export const reqadUserCount = (adlogin) => {
  return request({ url: `${db_Url}reqTableAll.php?mode=adUserCount&adlogin=${adlogin}`, method: 'GET' });
};
//呼叫backoffice後台images/avatar檔案目錄，取回目錄內管理者頭像圖片檔名
export const reqAvatarIcon = (sPath) => {
  let toPOSTstr="mode=getAvatarIcon&dirCtrl="+sPath.mode+`&sFolder=${sPath.sFolder}`;
  return request({ url: `${db_Url}file_control.php`, method: 'POST',data:toPOSTstr });
};
//呼叫資料庫，取回管理者群組資料，表格為：ad_group
export const reqAdGroupData = () => {
  // debugger;
  return request({ url: `${db_Url}reqTableAll.php?mode=adGroupData`, method: 'GET' });
};

//呼叫後端資料庫，取回管理者帳號的分頁資料，表格為：ad_user
export const reqAd_UserList01 = (page, limit,table,keyWord) => {
  return request({ url: `${db_Url}reqTable.php?page=${page}&table=${table}&limit=${limit}&keyWord=${keyWord}`, method: 'GET' });
};

//呼叫後端取得前端EC電商平台的預設路徑json
export const reqEc_Path = () => {
  return request({ url: `./ec_path.html`, method: 'GET' });
};

//呼叫backoffice後台images/avatar檔案目錄，取回目錄內管理者頭像圖片檔名
export const reqDelAvatarIcon = (fileName,sPath) => {
  //debugger;
  let toPOSTstr="mode=product_img_del&fileName="+fileName+"&dirCtrl="+sPath.mode+`&sFolder=${sPath.sFolder}`;
  return request({ url: `${db_Url}file_control.php`, method: 'POST',data:toPOSTstr });
};

//取得資料庫cart符合p_id所有的訂單總數
export const reqCartP_idCount = (p_id) => {
  return request({ url: `${db_Url}reqTableAll.php?mode=CartP_idCount&p_id=${p_id}`, method: 'GET' });
};
//取得資料庫product_img符合p_id所有圖案的檔名
export const reqProduct_img = (p_id) => {
  return request({ url: `reqTableAll.php?mode=product_img&p_id=${p_id}`, method: 'GET' });
};

// 取得資料庫的表格每一頁的內容，含table=carousel那個表格/{page}讀那一頁/{limit}每頁筆數限制，包含keyWord
export const reqProductList = (page, limit,table,keyWord) => {
    return request({ url: `reqTable.php?page=${page}&table=${table}&limit=${limit}&keyWord=${keyWord}`, method: 'GET' })
};

//呼叫mock測試用資料
export function getList(params) {
  return request({
    url: '/vue-admin-template/table/list',
    method: 'get',
    params
  })
}
