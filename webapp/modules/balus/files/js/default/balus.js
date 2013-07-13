var clsBalus = Class.create();
var balusCls = Array();

clsBalus.prototype = {
	initialize: function(id) {
		this.id = id;
	},
	destroy: function(confirmMes) {
		if (!commonCls.confirm(confirmMes)) {
			return false;
		}
		var redirect_url = _nc_base_url;
		var params = new Object();
		params['callbackfunc'] = function(res) {
			// TODO この辺にアニメーションを入れたい
			location.href = redirect_url;
		}.bind(this);
		commonCls.sendPost(this.id, {'action':'balus_action_main_destroy'}, params);
	}
};
