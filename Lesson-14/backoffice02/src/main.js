import Vue from 'vue'

import 'normalize.css/normalize.css' // A modern alternative to CSS resets

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en' // lang i18n

import '@/styles/index.scss' // global css

import App from './App'
import store from './store'
import router from './router'

import '@/icons' // icon
import '@/permission' // permission control

/**
 * If you don't want to use mock-server
 * you want to use MockJs for mock api
 * you can execute: mockXHR()
 *
 * Currently MockJs will be used in the production environment,
 * please remove it before going online ! ! !
 */
if (process.env.NODE_ENV === 'production') {
  const { mockXHR } = require('../mock')
  mockXHR()
}

// set ElementUI lang to EN
Vue.use(ElementUI, { locale })
// 如果想要中文版 element-ui，按如下方式声明
// Vue.use(ElementUI)

Vue.config.productionTip = false
//引入相關API內的index.js對映函數
import API from '@/api';

//引入分類選擇元件模組為全域使用
import CategorySelect from '@/components/CatagorySelect';
import ImageShow from '@/components/ImageShow';
// 將src/api/index.js模組的vue.prototype指向API
// 專案內的任意的模組皆可以使用API內的函數
Vue.prototype.$API=API;

//註冊為全域區使用元件
Vue.component(CategorySelect.name,CategorySelect);
Vue.component(ImageShow.name,ImageShow);

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
