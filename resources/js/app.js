
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue"
import App from "./App.vue"
import {sync} from 'vuex-router-sync'
import VueRouter from 'vue-router'
import store from './store/index'
import router from './router/index'
import Multiselect from 'vue-multiselect'
import vClickOutside from 'v-click-outside'
import Datepicker from "vue-datepicker"
import Notifications from 'vue-notification'
import {HasError, AlertError, AlertSuccess} from 'vform'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en';
import VueProgressBar from 'vue-progressbar';
import 'vue-multiselect/dist/vue-multiselect.min.css'

import LocalStorage from './plugins/local-storage';
import infiniteScroll from 'vue-infinite-scroll';
require('./bootstrap');

window.Vue = require('vue');
window.$ = require('jquery');
window.jQuery = require('jquery');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.moment = require('moment-timezone');
window.moment.tz.setDefault('Asia/Ho_Chi_Minh');

Vue.use(ElementUI, { locale });
Vue.use(LocalStorage);
Vue.use(infiniteScroll);


const VueProgressBarOptions = {
  color: '#5587d7',
  failedColor: '#db6e6e',
  thickness: '3px'
};
Vue.component('multiselect', Multiselect);
Vue.component('datepicker', Datepicker);
Vue.component('vClickOutside', vClickOutside);

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertSuccess.name, AlertSuccess);


/**
 * A small lirary that helps us with supporting Emojis in Voten's
 * Great Markdown editor.
 */
window.emojione = require('./libs/emojione.min');


Vue.use(VueRouter);
Vue.use(vClickOutside);
Vue.use(Notifications);

Vue.prototype.$eventHub = new Vue();


Vue.prototype.formateDateTime = () => {
  let date = Date(Date.now()).split(" ");
  return (
    date[2] + "/" + Vue.prototype.handleMonth(date[1].toLowerCase()) + "/" + date[3]
  );
};

Vue.prototype.formateDateTimeAdvance = () => {
  let date = Date(Date.now()).split(" ");
  return (
    Vue.prototype.handleMonth(date[1].toLowerCase()) + "/" + date[2] + "/" + date[3]
  );
};

Vue.prototype.handleMonth = (month) => {
  switch (month) {
    case "jan":
      return "01";
    case "feb":
      return "02";
    case "mar":
      return "03";
    case "apr":
      return "04";
    case "may":
      return "05";
    case "jun":
      return "06";
    case "jul":
      return "07";
    case "aug":
      return "08";
    case "sep":
      return "09";
    case "oct":
      return "10";
    case "nov":
      return "11";
    case "dec":
      return "12";
    default:
      return month;
  }
};

Vue.prototype.setValidateEmail = (email) => {
  let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
};

Vue.prototype.download = (file) => {
  let link = document.createElement("a");
  link.download = file.file_name;
  link.href = file.file_path;
  link.click();
  document.body.removeChild(link);
}

Vue.prototype.copy = (file_path) => {
  let hostName = window.location.hostname;
  let url = hostName + '/' + file_path;
  const el = document.createElement('textarea');
  el.value = url;
  document.body.appendChild(el);
  el.select();
  document.execCommand('copy');
  document.body.removeChild(el);
}

Vue.mixin({
  data() {
    return {
      validFileExtensions: ["jpg", "jpeg", "png", "pdf", "xls", "xlsx", "ppt", "pptx", "doc", "docx", "zip", "msword"],
      extensionImages: ["jpg", "png", "jpeg", "gif", "bmp"],
    }
  }
});

sync(store, router);



new Vue({
  el: '#app',
  router,
  store,
  components: {App},
  template: '<App/>',
});
