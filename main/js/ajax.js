// AjaxObj constructor
function AjaxObj(action, params, callback = null, async = true){
    this.url = "../main/php/ajax.php"; // TODO: Needs to be dynamic?
    this.action = action;
    this.params = params;
    this.data =  {'action' : action, 'params' : params};
    this.callback = callback;
    this.async = async;
    this.dataType = "text";
};

// AjaxObj.post function
AjaxObj.prototype.call = function(){
    // jQuery call
    $.ajax({
        type: 'POST',
        url: this.url,
        data: this.data,
        dataType: this.dataType,
        success: this.callback,
        async: this.async
    });
};