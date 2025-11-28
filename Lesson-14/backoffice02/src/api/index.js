// 將子目錄的模組，統一匯入到index.js
import * as carousel from './product/carousel';
import * as table from './table';
import * as category from './product/category';

//對外部輸出
export default{
    carousel,
    table,
    category,
}