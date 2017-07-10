/**
 * Created by d on 17-3-8.
 */

function Permission(permissions) {
  this.permissions = permissions;
}


Permission.prototype.getPermissions = function () {
  return this.permissions;
};

Permission.prototype.can = function (action) {
  return this.find(action).granted;
};

Permission.prototype.find = function (action) {
  for (let i of this.permissions) {
    if (i.name == action) {
      return i;
    }
  }
  return {granted: false}
};

Permission.prototype.any = function (...action) {
  let count = 0;
  action.forEach(a => {
    if (this.can(a)) {
      count++;
    }
  });
  return count > 0;
};

export default Permission;