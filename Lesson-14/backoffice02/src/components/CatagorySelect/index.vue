<template>
  <div>
    <el-form :inline="true" class="demo-form-inline" v-model="cForm">
      <el-form-item label="第一層主類別">
        <el-select
          placeholder="請選擇"
          v-model="cForm.Classid01"
          @change="getPyclass02"
        >
          <el-option
            :label="py01.cname"
            :value="py01.classid"
            v-for="py01 in pyClass01"
            :key="py01.classid"
          >
            <span :class="`fas ${py01.fonticon} fa-fw`"></span>
            <span>{{ py01.cname }}</span>
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="第二層次類別">
        <el-select
          placeholder="請選擇"
          v-model="cForm.Classid02"
          @change="getClassid02"
        >
          <el-option
            :label="py02.cname"
            :value="py02.classid"
            v-for="py02 in pyClass02"
            :key="py02.classid"
          >
            <span :class="`fas ${py02.fonticon} fa-fw`"></span>
            <span>{{ py02.cname }}</span>
          </el-option>
        </el-select>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
export default {
  name: "CategorySelect",
  data() {
    return {
      pyClass01: [], //資料庫回傳，第一層類別存放的陣列
      pyClass02: [], //資料庫回傳，第二層類別存放的陣列
      list: [], //確認第二層類別，從資料庫取回product產品資料
      cForm: {
        Classid01: "", //取得一層的類別classid
        Classid02: "", //取得二層的類別classid
      },
    };
  },
  mounted() {
    //取得資料庫的第一層資料放入pyClass01[]
    this.getPyclass01();
  },
  methods: {
    //到資料庫取回第一層主類別資料
    async getPyclass01() {
      let result = await this.$API.category.reqPyclass01();
      if (result.code == 200) {
        this.pyClass01 = result.data;
      }
    },
    //第一層類別更新後，即到資料庫取回對映的子類別資料
    async getPyclass02() {
      this.cForm.Classid02 = "";
      this.$emit("getClassid02", this.cForm.Classid02);
      let result = await this.$API.category.reqPyclass02(this.cForm.Classid01);
      if (result.code == 200) {
        this.pyClass02 = result.data;
      }
    },
    //確認第二層類別，從將表單的第二層Classid02資料，
    //回傳上面<CategorySelect></CategorySelect>的@getClassid02變數，並且產生事件觸發。
    getClassid02() {
      this.$emit("getClassid02", this.cForm.Classid02);
    },
  },
};
</script>
<style>
</style>