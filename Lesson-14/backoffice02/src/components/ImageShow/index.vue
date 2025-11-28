<template>
  <div>
    <img
      v-for="(imgItem, index) in img_file"
      :src="`${imageUrl}${imgItem.img_file}`"
      v-bind:title="imgItem.img_file"
      :key="index"
      style="width: 50%; height: auto; display: inline"
    />
  </div>
</template>
<script>
export default {
  props: ["getP_id"],
  name: "ImageShow",
  data() {
    return {
      img_file: [],
      imageUrl: "",
    };
  },
  watch: {
    //父層的p_id值有更改，再重新取出屬p_id的圖檔名稱
    getP_id: function (newValue, oldValue) {
      this.getProduct_img01(newValue);
    },
  },
  mounted() {
    //上傳圖片至電商前台專屬圖片放置完整的URL路徑'http://front.edu/lesson-14/No_attache/product_img'
    this.imageUrl =
      this.$store.state.settings.ecPlatForm.ec_Url +
      this.$store.state.settings.ecPlatForm.productImages +
      "/";
    this.getProduct_img01(this.getP_id);
  },
  methods: {
    //到資料庫取出屬p_id的圖檔名稱
    async getProduct_img01(p_id) {
      let result = await this.$API.table.reqProduct_img(p_id);
      if (result.code == 200) {
        this.img_file = result.data;
      }
    },
  },
};
</script>
<style>
</style>