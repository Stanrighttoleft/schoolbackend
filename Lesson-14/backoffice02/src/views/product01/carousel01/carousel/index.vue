<template>
  <div>
    <h3>Carousel首頁輪播管理</h3>
    <hr>
    <el-button type="primary" round icon="el-icon-circle-plus-outline">新增</el-button>
    <el-table :data="list" border style="width: 100%; margin-top: 1%;">
      <el-table-column prop="caro_id" label="編號" width="35" align="center" />
      <el-table-column prop="caro_title" label="輪播標題" width="180" />
      <el-table-column prop="caro_content" label="內容介紹"  />
      <el-table-column prop="caro_online" label="上/下架" width="80">
        <template slot-scope="{row}">
          <el-switch
            v-model="row.caro_online"
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-text="上架"
            inactive-text="下架"
            active-value="1"
            inactive-value="0"
            @change="updateOnline(row)"
          />
        </template>
        <!-- <template slot-scope="{row}"></template> -->
      </el-table-column>
      <el-table-column prop="caro_sort" label="輪播排序" width="35" />
      <el-table-column prop="caro_pic" label="圖檔名稱" width="100">
        <template slot-scope="{row}">
          <img :src="`${imageUrl}${row.caro_pic}`" :alt="row.caro_title" style="width: 100%;height: auto;" :title="row.caro_pic" >
        </template>
      </el-table-column>
      <el-table-column prop="p_id" label="對應產品編號" width="200">
        <template slot-scope="{row}">
          <span :title="row.p_name">{{ row.p_name }}({{ row.p_id }})</span>
        </template>
      </el-table-column>
      <el-table-column prop="create_date" label="建立日期" width="100"/>
      <el-table-column prop="prop" label="操作" width="200">
        <template>
          <el-button type="warning" plain icon="el-icon-edit" size="mini">修改</el-button>
          <el-button type="warning" plain icon="el-icon-delete" size="mini">刪除</el-button>
        </template>
      </el-table-column>

      
  </el-table>
  <!-- 分頁器的函數呼叫
   @size-change="handleSizeChange"
   @current-change="handleCurrentChange"
    -->
  <el-pagination
    style="margin-top:20px; text-align:center"
    :current-page="page"
    :page-sizes="[3,5,10]"
    :page-size="limit"
    :total="total"
    @current-change="getPageList"
    @size-change="handleSizeChange"
    layout="prev, pager, next,jumper,->,sizes,total"
  />
  </div>
</template>

<script>
export default{
  name:"carousel01",
  data(){
    return {
      page:1, //目前的第幾頁
      limit:3,  //預設每頁筆數
      total:0,  //資料總筆數
      list:[],  //carousel資料存放陣列
      imageUrl:"" ,//上傳圖片致電商前台專屬圖片放置完整的URL路徑
      upload_UrlFile:"",//店商前台傳的執行PHP路徑
      sPath:{sFolder:""}, //上傳圖片至伺服器的目錄
    };
  },
  mounted(){
    this.sPath.sFolder=this.$store.state.settings.ecPlatForm.productImages;
    // 取得圖片上船的路徑：'product_img'
    this.imageUrl=this.$store.state.settings.ecPlatForm.ec_Url+this.sPath.sFolder+"/"; //上傳圖片致電商前台專屬圖片放置完整的Url路徑
    this.getPageList();
    
  },
  methods:{
    async updateOnline(row){
      // 上下架的功能設定
      let result=await this.$API.carousel.reqCarouselOnline(row);
      if(result.code==200){
        this.$message({
          type:"success",
          message:"更新成功！",
        });
      }
    },
    async getPageList(pager=1){
      this.page=pager;
      const {page,limit}=this;
      let result=await this.$API.carousel.reqCarouselList(page,limit);
      if(result.code==200){
        // 取得回傳的總筆數和列表資料
        this.total=result.data.total;
        this.list=result.data.records;
      }
    },
    handleSizeChange(limit){
      this.limit=limit;
      this.getPageList();
    }
    
  },
  
}
</script>

<style>

</style>