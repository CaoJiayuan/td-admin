/**
 * Created by d on 17-2-23.
 */
import {toastrNotification} from './Utils';

function Auth() {

}
Auth.cacheUser = null;
Auth.attempt = function (url, credentials, redirectTo) {
  axios.post(url, credentials).then(response => {
    Auth.setToken(response.data.token);
    window.location = typeof redirectTo == 'string' ? redirectTo : '/'
  }).catch(error => {
    toastrNotification('error', error.response.data.message)
  })
};
Auth.user    = function (callback) {
  typeof callback == 'function' || (callback = user => {});
  if (Auth.cacheUser != null) {
    callback(Auth.cacheUser);
  } else {
    axios.get('/api/user').then(response => {
      var user = response.data;
      callback(user);
      Auth.cacheUser = user;
    });
  }
};

Auth.setToken = function (token) {
  localStorage.setItem('jwt_auth', token);
  return token;
};

Auth.getToken = function () {
  var token = localStorage.getItem('jwt_auth');
  if (token == null) {
    return null;
  }
  return 'bearer ' + token;
};

Auth.clearToken = function () {
  localStorage.removeItem('jwt_auth');
};

Auth.logout = function (redirect) {
  Auth.clearToken();
  typeof redirect == 'string' || (redirect = '/login');
  Vue.router.push(redirect)
};

export default Auth;