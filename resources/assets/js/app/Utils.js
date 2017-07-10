/**
 * Created by d on 17-2-23.
 */
import Auth from "./Auth";
import Permission from "./Permission";
export function redirectAfterLogin(to, from, next) {
  if (Auth.getToken() != null) {
    next('/')
  } else {
    next();
  }
}
export function redirectBeforeLogin(to, from, next) {
  if (Auth.getToken() == null) {
    next('/login')
  } else {
    axios.get('/api/permission/permissions').then(response => {
      Vue.prototype.permission = new Permission(response.data);
      next();
    });
  }
}

export function toastrNotification(type, message, overloadOptions) {
  // type有4种，success、info、warning、error
  toastr.options = {
    "debug"            : false,
    "newestOnTop"      : false,
    "positionClass"    : "toast-top-center",
    "preventDuplicates": true,
    "onclick"          : null,
    "showDuration"     : "300",
    "hideDuration"     : "1000",
    "timeOut"          : "3000",
    "extendedTimeOut"  : "1000",
    "showEasing"       : "swing",
    "hideEasing"       : "linear",
    "showMethod"       : "fadeIn",
    "hideMethod"       : "fadeOut"
  };

  if (typeof overloadOptions == 'object') {
    for (var i in overloadOptions) {
      toastr.options[i] = overloadOptions[i];
    }
  }

  return toastr[type](message);
}

export function deleteAlert(uri, onConfirm, overloadOptions) {
  var opts = {
    title             : '确认刪除?',
    text              : '你将无法恢复所刪除数据!',
    type              : 'warning',
    showCancelButton  : true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText : '是,确定删除!',
    cancelButtonText  : '不,取消删除',
    closeOnConfirm    : false,
    closeOnCancel     : false
  };

  if (typeof overloadOptions == 'object') {
    for (var i in overloadOptions) {
      opts[i] = overloadOptions[i];
    }
  }

  sweetAlert(opts,
    function (isConfirm) {
      if (isConfirm) {
        axios.delete(uri).then(response=> {
          typeof onConfirm == 'function' && onConfirm(response.data);
          sweetAlert("成功", "数据删除成功", "success");
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      } else {
        sweetAlert("取消", "数据沒有刪除!", "error");
      }
    });
}
/**
 *
 * @param {String} url
 * @param {Object} query
 * @returns {string}
 */
export function setQuery(url, query) {
  let obj = parseUrl(url);
  let q   = obj.query;

  for (let i in  query) {
    var item = query[i];
    if (_.isString(item)) {
        item.length > 0 && (q[i] = item);
    } else {
      q[i] = item;
    }
  }

  return obj.domain + '?' + httpQueryString(q);
}

/**
 *
 * @param {String} url
 * @returns {Object}
 */
export function parseUrl(url) {
  let part = url.split('?', 2);
  if (part.length < 2) {
    return {
      domain     : part[0],
      queryString: '',
      query      : {}
    }
  }
  let qs    = part[1].split('&');
  let query = {};
  qs.forEach(function (item) {
    let p = item.split('=');
    if (p.length > 1) {
      query[p[0]] = p[1];
    }
  });

  return {
    domain     : part[0],
    queryString: part[1],
    query      : query
  }
}
/**
 *
 * @param {Object} query
 * @returns {string}
 */
export function httpQueryString(query) {
  let qs = '';
  for (let i in query) {
    qs += '&' + i + '=' + query[i];
  }
  return qs.length >= 1 ? qs.substr(1) : qs;
}