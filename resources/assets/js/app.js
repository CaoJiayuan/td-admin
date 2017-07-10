import VueRouter from "vue-router";
import routes from "./routes";
import {toastrNotification,deleteAlert} from "./app/Utils"
import ElementUI from 'element-ui'
import Permission from "./app/Permission";

require('./bootstrap');
require('sweetalert');
Vue.use(VueRouter);
Vue.use(ElementUI);
Vue.filter('ContractName',function(inst_id){
  var result=parseInt(inst_id);
  switch(result) {
    case 1:return 'Au(T+D)';
    case 2:return 'Ag(T+D)';
    case 3:return 'mAu(T+D)';
    default:return '未知合约';
  }
});

Vue.filter('ConvertExchType',function(exch_type){
  /* 交易类型(开多仓-1  开空仓-2  平多仓-3  平空仓-4) */
  var result=parseInt(exch_type);
  switch(result) {
    case 1:return '开多仓';
    case 2:return '开空仓';
    case 3:return '平多仓';
    case 4:return '平空仓';
    default:return '未知交易类型';
  }
});

//如果是空或者未定义
Vue.filter('isNullOrEmpty',function(text){
  if(text=='' || text== null){
    return '暂无';
  }
  else {
    return text;
  }
});

/*金额转换2位小数*/
Vue.filter('ConvertDouble',function(price){
  return parseFloat(price).toFixed(2);
});


Vue.filter('AccessWay',function(way){
  /* 交易类型(开多仓-1  开空仓-2  平多仓-3  平空仓-4) */
  var result=parseInt(way);
  switch(result) {
    case 1:return '存入';
    case 2:return '取出';
    default:return '未知';
  }
});

Vue.filter('IsToAccount',function(way){
  /* 交易类型(开多仓-1  开空仓-2  平多仓-3  平空仓-4) */
  var result=parseInt(way);
  switch(result) {
    case 1:return '是';
    case 2:return '否';
    default:return '未知';
  }
});





Vue.filter('limitString', (str, limit) => {
  typeof limit == 'number' || (limit = 16);
  if (typeof str != 'string') {
    return str;
  }
  if (str.length > limit) {
    return str.substring(0, limit - 1) + '...';
  }
  return str;
});

const router = new VueRouter({
  routes
});
Vue.router = router;
window.axios.interceptors.response.use(undefined, error => {
  if (error.response.status === 401) {
    localStorage.removeItem('jwt_auth');
    router.push('/login')
  }
  return Promise.reject(error)
});
window.toastrNotification = toastrNotification;
window.deleteAlert = deleteAlert;
require('./app/extend');
require('./app/requestCache');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
  router
});
window.vueApp = app;

app.$mount('#app');