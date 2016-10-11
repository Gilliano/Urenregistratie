// AjaxObj constructor
function AjaxObj(action, params, async = true, dataType, callback = null){
    this.url = "../main/php/ajax.php"; // TODO: Needs to be dynamic?
    this.action = action;
    this.params = params;
    this.data =  {'action' : action, 'params' : params};
    this.callback = callback;
    this.async = async;
    this.dataType = dataType;
    this.result = null;
    this.call(this);
}

// AjaxObj.post function
AjaxObj.prototype.call = function(ajaxObj){
    // Setup default callback
    // if none is provided
    if(this.callback == null)
        this.callback = function(response) {ajaxObj.result = response};

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