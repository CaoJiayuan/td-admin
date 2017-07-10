/**
 * Created by d on 17-5-3.
 */
import {parseUrl, setQuery} from "./Utils";
window.Vue.cache = {};
var nowDate = new Date();
var year = nowDate.getFullYear();
var month = nowDate.getMonth() + 1 < 10 ? "0" + (nowDate.getMonth() + 1)
  : nowDate.getMonth() + 1;
var day = nowDate.getDate() < 10 ? "0" + nowDate.getDate() : nowDate
  .getDate();
var dateStr = year + "/" + month + "/" + day, dateEnd = dateStr;

window.Vue.cacheKeyDefault = {
  filter: '',
  page  : 1,
  date  : '',
  begin : dateStr,
  end   : dateEnd
};

window.axios.interceptors.request.use(config => {
  if (config.method.toUpperCase() == 'POST') {
    return config;
  }
  let urlData = parseUrl(config.url), query = urlData.query, cacheKey = window.Vue.cacheKeyDefault;
  let path    = location.href.split('#', 2)[1];
  let cache   = window.Vue.cache[path] || {};
  for (let i in cacheKey) {
    if (!query.hasOwnProperty(i)) {
      query[i] = cache[i] ? cache[i] : cacheKey[i];
    } else {
      cache[i]               = query[i];
      window.Vue.cache[path] = cache;
    }
  }
  config.url = setQuery(config.url, query);
  return config;
});