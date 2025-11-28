<template>
  <div class="upload-container">
    <el-button :style="{background:color,borderColor:color}" icon="el-icon-upload" size="mini" type="primary" @click=" dialogVisible=true">
      upload
    </el-button>
    <el-dialog :visible.sync="dialogVisible">
      <!--上傳網址需更改成:action="upload_UrlFile"，並加入:data="sPath"上傳目錄 -->
      <el-upload
        :multiple="true"
        :file-list="fileList"
        :show-file-list="true"
        :on-remove="handleRemove"
        :on-success="handleSuccess"
        :before-upload="beforeUpload"
        class="editor-slide-upload"
        :action="upload_UrlFile" 
        list-type="picture-card"
        :data="sPath"
      >
        <el-button size="small" type="primary">
          Click upload
        </el-button>
      </el-upload>
      <el-button @click="dialogVisible = false">
        Cancel
      </el-button>
      <el-button type="primary" @click="handleSubmit">
        Confirm
      </el-button>
    </el-dialog>
  </div>
</template>

<script>
// import { getToken } from 'api/qiniu'
//檢查上傳的檔案格式是否符合
import { checkImage } from "@/filters";  
export default {
  name: 'EditorSlideUpload',
  props: {
    color: {
      type: String,
      default: '#1890ff'
    }
  },
  data() {
    return {
      dialogVisible: false,
      listObj: {},
      fileList: [],
      imageUrl: "", //上傳圖片至電商前台專屬圖片放置完整的URL路徑
      upload_UrlFile: "", //電商前台上傳的執行PHP路徑
      // sPath:{"sFolder":"p_contentImg"},
      //上傳圖片至伺服器的目錄
      sPath: { sFolder: "" },
    }
  },
  mounted(){
    //設定上傳圖片目錄：'p_contentImg';
    this.sPath.sFolder = 'p_contentImg';

    //上傳圖片至電商前台專屬圖片放置完整的URL路徑'http://front.edu/lesson-14/No_attache/p_contentImg'
    this.imageUrl =
      this.$store.state.settings.ecPlatForm.ec_Url + this.sPath.sFolder + "/";

    //上傳電商前台的PHP程式執行URL路徑+檔名'http://front.edu/lesson-14/No_attache/file_upload_parser01.php'
    this.upload_UrlFile =
      this.$store.state.settings.ecPlatForm.db_Url + "file_upload_parser01.php";
  },
  methods: {
    checkAllSuccess() {
      return Object.keys(this.listObj).every(item => this.listObj[item].hasSuccess);
    },
    handleSubmit() {
      const arr = Object.keys(this.listObj).map(v => this.listObj[v]);
      if (!this.checkAllSuccess()) {
        this.$message('Please wait for all images to be uploaded successfully. If there is a network problem, please refresh the page and upload again!')
        return false;
      }
      this.$emit('successCBK', arr)
      this.listObj = {};
      this.fileList = [];
      this.dialogVisible = false;
    },
    handleSuccess(response, file) {
      const uid = file.uid
      const objKeyArr = Object.keys(this.listObj)
      for (let i = 0, len = objKeyArr.length; i < len; i++) {
        if (this.listObj[objKeyArr[i]].uid === uid) {
          //接收上傳完成並返回的圖檔名稱
          this.listObj[objKeyArr[i]].url =this.imageUrl+response.fileName;
          this.listObj[objKeyArr[i]].hasSuccess = true;
          return;
        }
      }
    },
    handleRemove(file) {
      const uid = file.uid;
      const objKeyArr = Object.keys(this.listObj);
      for (let i = 0, len = objKeyArr.length; i < len; i++) {
        if (this.listObj[objKeyArr[i]].uid === uid) {
          delete this.listObj[objKeyArr[i]];
          return;
        }
      }
    },
    beforeUpload(file) {
      const _self = this;
      const _URL = window.URL || window.webkitURL;
      const fileName = file.uid;
      //上傳前檢查檔案格式是否符合
      let result = checkImage(file);
      if (result.code == 200) {
        if (result.status == "FAIL") {
          this.$message.error(result.message);
          return false;
        }
      }
      this.listObj[fileName] = {};
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = _URL.createObjectURL(file);
        img.onload = function() {
          _self.listObj[fileName] = { hasSuccess: false, uid: file.uid, width: this.width, height: this.height };
        }
        resolve(true);
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.editor-slide-upload {
  margin-bottom: 20px;
  ::v-deep .el-upload--picture-card {
    width: 100%;
  }
}
</style>
