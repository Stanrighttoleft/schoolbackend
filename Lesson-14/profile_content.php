<div class="row">
  <div class="col-12 text-center">
    <h1>會員資料修改畫面</h1>
    <p>請輸入相關資料，*為必須輸入欄位</p>
  </div>
</div>
<div class="row" id="modify" name="modify">
  <div class="col-8 offset-2 text-left">
    <form action="" method="GET" id="reg" name="reg">
      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" v-model="member.email" placeholder="請輸入email帳號" autocomplete="off" readonly>
      </div>
     
      <div class="input-group mb-3">
        <input type="text" name="cname" id="cname" v-model="member.cname" class="form-control" placeholder="請輸入姓名" :readonly="readonly">
      </div>
      <div class="input-group mb-3">
        <input type="text" name="tssn" id="tssn" v-model="member.tssn"  class="form-control" placeholder="請輸入身份證字號" :readonly="readonly">
      </div>
      <div class="input-group mb-3">
        <input type="text" name="birthday" v-model="member.birthday" :readonly="readonly" id="birthday" onfocus="(this.type='date')" class="form-control" placeholder="請選擇生日">
      </div>
      
      <label for="fileToUpload" class="form-label">上傳照片：</label>
      <div class="input-group mb-3" v-show="!readonly">
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" title="請上傳相片圖片" accept="image/x-png,image/jpeg,image/git,image/jpg">
        <p><button class="btn btn-danger" id="uploadForm" name="uploadForm">開始上傳</button></p>

        <div id="progress-div01" class="progress" role="progressbar" aria-label="Default striped example" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"
        style="width:100%; display:none;">
          <div id="progress-bar01" class="progress-bar progress-bar-striped" style="width: 0%" role="progressbar">0%
          </div>
        </div>
        <input type="hidden" name="uploadname" id="uploadname" value=""/>
        <img src="" id="showimg" name="showimg" alt="photo" style="display: none;" class="img-fluid">
      </div>
      <div class="input-group mb-3" v-if="readonly">
        <img :src="`uploads/${(member.imgname)?member.imgname:'avatar.svg'}`" alt="photo" style="width:20%;" :title="`檔名：${(member.imgname)?member.imgname:'avatar.svg'}`">
      </div>
      <div class="row form-group mb-3" v-show="!readonly">
        <input type="hidden" name="captcha" v-model="captcha" id="captcha" value="">
        <a href="javascript:void(0);" title="按我更新認證" @click="getCaptcha();">
          <canvas id="can"></canvas>
        </a>
        <input type="text" name="recaptcha" id="recaptcha" class="form-control" placeholder="請輸入驗證碼">
      </div>
      <div class="input-group mb-3">
        <button type="button" class="btn btn-warning btn-lg me-2 text-white" @click="editMember" v-if="readonly">更新會員資料</button>
        <button type="button" class="btn btn-info btn-lg text-white" v-if="readonly" data-bs-toggle="modal" data-bs-target="#exampleModal">變更會員密碼</button>
        <button type="button" class="btn btn-primary btn-lg me-2 text-white" @click="saveMember" v-if="!readonly">儲存資料</button>
        <button type="button" class="btn btn-secondary btn-lg text-white" @click="readonly=true" v-if="!readonly">離開</button>
      </div>
    </form>
  </div>
  <!-- Modal會員密碼變更模組 -->
  <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-user-look me-2"></i> 會員密碼變更頁面</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="changePW" id="changePW" name="changePW">
          <div class="mb-3">
            <label for="PWOld" class="form-label">請輸入舊密碼</label>
            <input type="password" class="form-control" id="PWOld" name="PWOld" placeholder="Current Password" v-model="PWOld">
          </div>
          <div class="mb-3">
            <label for="PWNew1" class="form-label">請輸入新密碼</label>
            <input type="password" class="form-control" id="PWNew1" name="PWNew1" placeholder="New Password" v-model="PWNew1">
          </div>
          <div class="mb-3">
            <label for="PWNew2" class="form-label">請再確認新密碼</label>
            <input type="password" class="form-control" id="PWNew2" name="PWNew2" placeholder="Vertify Password" v-model="PWNew2">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="mClose" name="mClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">離開</button>
        <button type="button" class="btn btn-primary" @click="savePW();">儲存密碼</button>
      </div>
    </div>
  </div>
</div>