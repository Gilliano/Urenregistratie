// AjaxObj constructor
function AjaxObj(action, params, callback = null){
    this.url = "../main/php/ajax.php"; // TODO: Needs to be dynamic?
    this.action = action;
    this.params = params;
    this.data =  {'action' : action, 'params' : params};
    this.callback = callback;
};

// AjaxObj.post function
AjaxObj.prototype.post = function(){
    // jQuery post
    $.post(this.url, this.data, this.callback);
};