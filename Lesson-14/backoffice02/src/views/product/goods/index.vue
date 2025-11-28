<template>
  <div>
    <h3>Goods商品資料管理</h3>
    <hr />
    <div v-show="!tinymceVisible">
      <el-card style="margin: 1% 0px">
        <CategorySelect @getClassid02="getClassid02"></CategorySelect>
      </el-card>
      <el-card>
        <div v-show="isShowTable">
          <!-- 表格新增按鈕 -->
          <el-button
            type="primary"
            round
            plain
            icon="el-icon-plus"
            @click="appendGoods"
            :disabled="!classId02"
            >新增</el-button
          >
          <el-table style="width: 100%; margin-top: 1%" border :data="list">
            <el-table-column
              prop="p_id"
              label="產品編號"
              width="35"
              align="center"
            >
            </el-table-column>
            <el-table-column prop="p_name" label="產品名稱" width="180">
            </el-table-column>
            <el-table-column prop="p_intro" label="產品簡介">
              <template slot-scope="{ row }">
                <!-- 只顯示前0-15個字 -->
                <span
                  >{{ row.p_intro ? row.p_intro.substring(0, 15) : "" }}…</span
                >
              </template>
            </el-table-column>
            <el-table-column prop="p_open" label="上/下架" width="150">
              <template slot-scope="{ row }">
                <el-switch
                  v-model="row.p_open"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                  active-text="上架"
                  inactive-text="下架"
                  :active-value="1"
                  :inactive-value="0"
                  @change="productOnline(row)"
                >
                </el-switch>
              </template>
            </el-table-column>
            <el-table-column
              prop="p_price"
              label="產品價格"
              width="55"
              align="center"
            >
            </el-table-column>
            <el-table-column prop="img_file" label="圖檔名稱">
              <template slot-scope="{ row }">
                <ImageShow v-bind:getP_id="row.p_id" :key="refresh"></ImageShow>
              </template>
            </el-table-column>
            <el-table-column prop="p_content" label="產品詳細規格">
              <template slot-scope="{ row }">
                <!-- 只顯示前0-20個字 -->
                <span
                  >{{
                    row.p_content ? row.p_content.substring(0, 20) : ""
                  }}…</span
                >
              </template>
            </el-table-column>
            <el-table-column
              prop="p_date"
              label="建立日期"
              width="100"
            ></el-table-column>
            <el-table-column prop="prop" label="操作" width="130" align="center">
              <template slot-scope="{ row }">
                <el-button
                  type="warning"
                  plain
                  circle
                  icon="el-icon-document"
                  size="mini"
                  @click="updateGoods(row)"
                  title="修改"

                ></el-button>
                <el-button
                  type="danger"
                  plain
                  circle
                  icon="el-icon-delete"
                  size="mini"
                  @click="deleteGoods(row)"
                  title="刪除"

                ></el-button>
                <el-button
                  type="info"
                  plain
                  circle
                  icon="el-icon-edit-outline"
                  size="mini"
                  @click="editP_Content(row)"
                  title="編輯產品詳細規格"
                ></el-button>
              </template>
            </el-table-column>
          </el-table>
          <!-- 分頁器的函數呼叫  -->
          <el-pagination
            style="margin-top: 20px; text-align: center"
            :current-page="page"
            :page-sizes="[3, 5, 10]"
            :page-size="limit"
            :total="total"
            @current-change="getProductList01"
            @size-change="handleSizeChange"
            layout="prev, pager, next, jumper,->, sizes,total"
          >
          </el-pagination>
        </div>
        <!-- 新增產品資料的表單 -->
        <el-col :span="18" v-show="!isShowTable">
          <el-form
            label-width="95px"
            :model="product"
            :rules="rules"
            ref="goodsRules"
          >
            <el-form-item label="次類別編號" prop="classid">
              <el-input v-model="product.classid" disabled></el-input>
            </el-form-item>
            <el-form-item label="產品名稱" prop="p_name">
              <el-input v-model="product.p_name"></el-input>
            </el-form-item>
            <el-form-item label="產品簡介" prop="p_intro">
              <el-input v-model="product.p_intro"></el-input>
            </el-form-item>
            <el-form-item label="產品單價" prop="p_price">
              <el-input v-model="product.p_price"></el-input>
            </el-form-item>
            <el-form-item label="上下架">
              <el-switch
                active-value="1"
                inactive-value="0"
                v-model="product.p_open"
              ></el-switch>
            </el-form-item>
            <el-form-item label="產品圖片上傳" prop="picFileList">
              <el-upload
                ref="upload"
                :action="upload_UrlFile"
                list-type="picture-card"
                :on-success="handleSuccess"
                :before-upload="beforeUpload"
                :data="sPath"
                :file-list="product.picFileList"
              >
                <i slot="default" class="el-icon-plus"></i>
                <div slot="file" slot-scope="{ file }">
                  <img
                    class="el-upload-list__item-thumbnail"
                    :src="file.url"
                    :alt="file.name"
                  />
                  <span class="el-upload-list__item-actions">
                    <span
                      v-if="!disabled"
                      class="el-upload-list__item-delete"
                      @click="handleRemove(file)"
                      :title="file.name"
                    >
                      <i class="el-icon-delete"></i>
                    </span>
                  </span>
                </div>
              </el-upload>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="writeGoods">{{
                product.p_id ? "更新資料" : "立即新增"
              }}</el-button>
              <el-button @click="cancelGoods">取消</el-button>
            </el-form-item>
          </el-form>
        </el-col>
      </el-card>
    </div>
    <el-card v-show="tinymceVisible">
      <div slot="header" class="clear-fix">
          <span style="margin-right:10px;">編輯產品詳細規格：</span>
          <el-button type="warning" @click="cancelP_Content">離 開</el-button>
          <el-button type="primary" @click="saveP_Content">存 檔{{
                p_contentModify ? "(未存檔)" : ""}}</el-button>
      </div>
      <div>
      <tinymce v-model="product.p_content" :height="400" ref="updateP_content" @chkModify="chkModify" />
      </div>
      <div class="editor-content" v-html="product.p_content"></div>
    </el-card>
  </div>
</template>
<script>
import { checkImage } from "@/filters";
import Tinymce from "@/components/Tinymce";
export default {
  components: { Tinymce },
  name: "goods",
  data() {
    return {
      classId02: "", //子元件回傳的第二層類別編號
      page: 1, //目前的第幾頁
      limit: 3, //預設的每頁筆數
      total: 0, //資料的總筆數
      list: [], //資料存放的陣列
      isShowTable: true,
      imageUrl: "", //上傳圖片至電商前台專屬圖片放置完整的URL路徑
      upload_UrlFile: "", //電商前台上傳的執行PHP路徑
      // sPath:{"sFolder":"product_img"}, 上傳圖片至伺服器的目錄
      sPath: { sFolder: "", p_id: "" },
      picFileList: [], //傳回產品圖片上傳存放陣列
      disabled: false, //圖片上傳後提供移除的按鈕顯示
      product: {
        //存放產品資料物件
        p_id: "",
        classid: 0,
        p_name: "",
        p_intro: "",
        p_price: "",
        p_open: "1",
        p_content: "",
        picFileList: [],
      },
      rules: {
        //表單檢查規則
        classid: [
          { required: true, message: "需選擇第二層次類別", trigger: "change" },
        ],
        p_name: [
          { required: true, message: "需輸入產品名稱", trigger: "blur" },
        ],
        p_intro: [
          { required: true, message: "需輸入產品簡介", trigger: "blur" },
        ],
        p_price: [
          { required: true, message: "需輸入產品價格", trigger: "blur" },
          {
            type: "integer",
            message: "需輸入數字",
            trigger: "blur",
            transform: Number,
          },
        ],
        picFileList: [{ required: true, message: "需上傳成功的圖檔" }],
      },
      refresh: true, //顯示圖片的ImageShow設定強制刷新內容
      tinymceVisible: false, //用來控制p_content的tinymce編輯對話誆
      p_contentModify:false,  //用以檢查p_content內容是否修改
      // buttons:this.$store.state.user.person.buttons,    //取得vuex功能權限按鈕資料
    };
  },

  mounted() {
    //取得上傳圖片路徑：'product_img',;
    this.sPath.sFolder = this.$store.state.settings.ecPlatForm.productImages;

    //上傳圖片至電商前台專屬圖片放置完整的URL路徑'http://front.edu/lesson-14/No_attache/product_img'
    this.imageUrl =
      this.$store.state.settings.ecPlatForm.ec_Url + this.sPath.sFolder + "/";

    //上傳電商前台的PHP程式執行URL路徑+檔名'http://front.edu/lesson-14/No_attache/file_upload_parser01.php'
    this.upload_UrlFile =
      this.$store.state.settings.ecPlatForm.db_Url + "file_upload_parser01.php";
  },
  methods: {
    //產品上/下架的功能
    async productOnline(row){
      let result = await this.$API.category.reqProductOnline(row);
          if (result.code == 200) {
            this.$message({
              type: "success",
              message: "更新成功!",
            });
          }
    },
    //上傳後刪除的處理
    async handleRemove(file) {
      //增加刪除圖檔並且移除product_img資料表記錄
      if (this.product.p_id) {
        if (this.product.picFileList.length == 1) {
          this.$alert("由於平台限制，產品最少需要一張圖片內容", "系統提示！", {
            confirmButtonText: "確定",
          });
          return true;
        } else {
          this.$API.category.reqProduct_Img_Del_Db(
            "product_img_del_db",
            file.name,
            this.product.p_id
          );
        }
      }
      let result = await this.$API.category.reqFileControl(
        "product_img_del",
        file.name
      );
      if (result.code == 200) {
        if (result.status === "OK") {
          for (let i = 0; i < this.product.picFileList.length; i++) {
            if (this.product.picFileList[i]["name"] === file.name) {
              this.product.picFileList.splice(i, 1);
              break;
            }
          }
          this.$message({ message: result.message, type: "success" });
        } else {
          this.$message.error(result.message);
          return false;
        }
      }
    },
    //上傳成功後的處理
    handleSuccess(res, file) {
      if (res.success == "true") {
        if (this.product.p_id) {
          //資料更新模式，圖檔完成上傳後，直接寫入資料庫
          let sort = this.product.picFileList.length + 1; //圖片排在最後一個
          this.$API.category.reqInsertProductImg(
            "InsertProductImg",
            res.fileName,
            this.product.p_id,
            sort
          );
        }
        //若上傳成功則傳回fileName，與完整的URL路徑+fileName存入picFileList陣列
        this.product.picFileList.push({
          name: res.fileName,
          url: this.imageUrl + res.fileName,
        });
      } else {
        alert(res.error);
      }
    },
    //上傳之前的圖檔格式與檔案大小判斷
    beforeUpload(file) {
      let result = checkImage(file);
      if (result.code == 200) {
        if (result.status == "FAIL") {
          this.$message.error(result.message);
          return false;
        }
      }
    },
    //CategorySelect子元件動作會觸發內容classId02更新
    getClassid02(classId02) {
      this.classId02 = classId02;
      this.product.classid = classId02;
      this.getProductList01();
    },
    //確認第二層類別，從資料庫取回product產品資料
    async getProductList01(pager = 1) {
      this.page = pager;
      const { page, limit } = this;
      let result = await this.$API.category.reqProductList01(
        page,
        limit,
        "product01",
        "",
        this.classId02
      );
      if (result.code == 200) {
        this.total = result.data.total;
        this.list = result.data.records;
      }
    },
    writeGoods() {
      //按立即新增則先檢查資料，通過後並資料寫入後台
      this.$refs.goodsRules.validate(async (valid) => {
        if (valid) {
          let result = await this.$API.category.reqProductAccess(this.product);
          if (result.code == 200) {
            this.$message({
              showClose: true,
              message: result.message,
              type: "success",
            });
            this.isShowTable = true;
            this.refresh = !this.refresh;
            //TABLE重新讀取資料，若為為更新模式，TABLE頁面需停在目前編輯頁，若為新增模式TABLE為第一頁
            this.getProductList01(this.product.p_id ? this.page : 1);
          }
        } else {
          return false;
        }
      });
    },
    handleSizeChange(limit) {
      this.limit = limit;
      this.getProductList01();
    },
    async updateGoods(row) {
      //將表格的資料存入product物件內提供編輯
      this.product.p_id = row.p_id;
      this.product.p_name = row.p_name;
      this.product.p_intro = row.p_intro;
      this.product.p_price = row.p_price;
      this.product.p_open = row.p_open;
      this.product.picFileList = [];
      //取得產品的圖片資料
      let result = await this.$API.table.reqProduct_img(this.product.p_id);
      if (result.code == 200) {
        for (let i = 0; i < result.data.length; i++) {
          this.product.picFileList.push({
            name: result.data[i].img_file,
            url: this.imageUrl + result.data[i].img_file,
          });
        }
      }
      //隱藏原有的產品表格，並且顯示產品表單
      this.isShowTable = false;
    },
    //進行產品的資料刪除
    async deleteGoods(row) {
      //先從資料庫統計此產品編號，被多少訂單使用到
      let result00 = await this.$API.table.reqCartP_idCount(row.p_id);
      if (result00.code == 200) {
        //跳出對話框，確認是否要刪除
        this.$confirm(
          `${row.p_name}，目前與${result00.data[0].P_idCount}筆訂單關連，你確定是否刪除？`,
          "是否刪除？",
          {
            confirmButtonText: "確定",
            cancelButtonText: "取消",
            type: "warning",
          }
        )
          .then(async () => {
            //確定要進行刪除處理，程序為1.取得產品圖片檔名，2.刪除圖片，3.刪除product,product_img資料表的記錄
            //取得產品的圖片資料
            let result01 = await this.$API.table.reqProduct_img(row.p_id);
            if (result01.code == 200 && result01.data.length > 0) {
              let picFileList = [];
              for (let i = 0; i < result01.data.length; i++) {
                picFileList.push({
                  name: result01.data[i].img_file,
                  url: this.imageUrl + result01.data[i].img_file,
                });
              }
              //移除產品的圖片檔案
              this.$API.category.reqRemoveImages(picFileList);
            }
            //刪除product,product_img資料表的記錄
            let result02 = await this.$API.category.reqProductDel(row);
            if (result02.code == 200) {
              this.$message({ type: "success", message: "删除成功!" });
              this.getProductList01(
                this.list.length > 1 || this.page == 1
                  ? this.page
                  : this.page - 1
              );
            }
          })
          .catch(() => {
            this.$message({ type: "info", message: "已取消删除" });
          });
      }
    },
    //使用tinymce進行p_content編輯
    editP_Content(row) {
      this.product.p_id = row.p_id; //取得目前這筆的產品編號
      this.p_contentModify=false;   //設定p_contentModify進入tinymce前還沒有被修改
      // 更新子元件tinymce的內容
      this.$refs.updateP_content.setContent(row.p_content);
      //開啟tinymce編輯功能
      this.tinymceVisible = true;
    },
    //離開tinymce的編輯
    cancelP_Content(){
      if(this.p_contentModify){
        this.$confirm("產品詳細資訊欄位有修改，你確定是否離開？","是否離開？",
          {confirmButtonText: "確定", cancelButtonText: "取消", type: "warning",}
        )
          .then(() => {
            this.tinymceVisible = false; //確認放棄離開
          })
          .catch(() => { return false; });
      }else{
        this.tinymceVisible = false; //p_content沒修改直接離開
      }
    },
    //tinymce子元件回傳p_content欄位內容是否修改
    chkModify(receive){
      this.p_contentModify=receive;
    },
    //p_content欄位資料存到後端資料庫中
    async saveP_Content(){
      let result = await this.$API.category.reqP_Content(this.product);
        if (result.code == 200) {
          this.$message({
            showClose: true,
            message: result.message,
            type: "success",
          });
          this.isShowTable = true;
          //TABLE重新讀取資料，p_content更新模式
          this.getProductList01(this.page);
          this.p_contentModify=false;
        }
    },
    appendGoods() {
      //清除產品表單物件內的資料
      this.product.p_id = "";
      this.product.p_name = "";
      this.product.p_intro = "";
      this.product.p_price = "";
      this.product.p_open = "1";
      this.product.p_content = "";
      this.product.picFileList = [];
      //隱藏原有的產品表格，並且顯示新增表單
      this.isShowTable = false;
    },
    //取消產品新增
    async cancelGoods() {
      if (!this.product.p_id && this.product.picFileList.length != 0) {
        //若有圖檔上傳，如果取消新增需要刪除已經上傳的圖片
        let result = await this.$API.category.reqRemoveImages(
          this.product.picFileList
        );
        if (result.code == 200 && result.status == "FAIL") {
          this.$message.error(
            result.message[0].fileName + ":" + result.message[0].msg
          );
        }
      }
      this.isShowTable = true;
      this.refresh = !this.refresh; //顯示圖片的ImageShow設定強制刷新內容
    },
  },
};
</script>
<style>
</style>