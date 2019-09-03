if(window.attachEvent) {
    window.attachEvent('onload', reloadfunction);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            reloadfunction(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = reloadfunction;
    }
}
function parse_query_string(query) {
    var vars = query.split("&");
    var query_string = {};
    for (var i = 0; i < vars.length; i++) {
      var pair = vars[i].split("=");
      var key = decodeURIComponent(pair[0]);
      var value = decodeURIComponent(pair[1]);
      // If first entry with this name
      if (typeof query_string[key] === "undefined") {
        query_string[key] = decodeURIComponent(value);
        // If second entry with this name
      } else if (typeof query_string[key] === "string") {
        var arr = [query_string[key], decodeURIComponent(value)];
        query_string[key] = arr;
        // If third or later entry with this name
      } else {
        query_string[key].push(decodeURIComponent(value));
      }
    }
    return query_string;
  }
function reloadfunction(test){
    var parsed_qs = parse_query_string(window.location.href);
    var selectboxvalue = parsed_qs.selectboxvalue;
    if(selectboxvalue != undefined){
        var type_value = document.getElementById("ctrl_type");
        type_value = type_value.value
        if(selectboxvalue != type_value){
            var type = document.querySelector("#ctrl_type");    
            for(var i= 0; i < type.children.length; i++){
                for(var ii = 0; ii < type.children[i].children.length ; ii++){
                    if(type.children[i].children[ii].getAttribute("value") == selectboxvalue){
                       type.children[i].children[ii].setAttribute("selected", "");
                       location.reload();
                       //Backend.autoSubmit('tl_content');
                    }
                }
            }
        }        
    }
}