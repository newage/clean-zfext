/* 
 * JQuery Form Validator
 * Version 1.0
 * @requires jquery 1.2
 */

$.coreValidator = {
    "login": {
        0:{
            "RegEx":"/^+{3,20}$/",
            "Error":"Error Length"
        },
        1:{
            "RegEx":"/^[0-9a-zA-Z]+$/",
            "Error":"Error Alnum"
        }
    },
    "password": {
        "StringLength":{
            "RegEx":"/^+{3,20}$/",
            "Error":"Error Length"
        },
        "Alnum":{
            "RegEx":"/^[0-9a-zA-Z]+$/",
            "Error":"Error Alnum"
        }
    }

};

 $(":submit").click(function() {

     $(":input").each(function(element) {
        debugger;
     });

     for (var i=0; i<$(":input").length; i++) {
        validator = elementId[i].id;
        rules = $.coreValidator[validator];
        if (!rules) {
            continue;
        }

        for (var e=0; e<rules.length; e++) {
            alert(rules.e.RegEx);
        }
     }
     return false;
 });
