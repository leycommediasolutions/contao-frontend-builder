$(document).ready(function(){
    $('.matchHeight').matchHeight();  
    // $('.tooltip').tooltipster({
    //     functionPosition: function(instance, helper, position){
    //         position.coord.top += 5;
    //         return position;
    //     }
    // });
    var footerHeight = 0,
        footerTop = 0,
        $footer = $("#fbly_footer");
    
    function positionFooter() {
             footerHeight = $footer.outerHeight();
             footerTop = ($(window).scrollTop()+$(window).height()-footerHeight )+"px";// - (footerHeight+$("#fbly_header").height()) 
            if ( ($("#fbly_type").outerHeight()+footerHeight) < $(window).height()) {
                $footer.css({
                     position: "absolute",
                     height: footerHeight,
                     
                }).animate({  
                  top: footerTop
                }, 500)
            } else {
                $footer.css({
                     position: "absolute",
                     height: "auto"
                })
            }
    }
    //positionFooter();
    function createStringFromJsonTag(tag){
        try{
            return $.parseJSON(tag.attr("data-createElement"));
        }catch(e){
            console.error(e);
            return {}; 
        }
    }
    function jsonparse(string){
        try{
            return JSON.parse(string); 
        }catch(e){
            console.error(e);
            return {}; 
        }
    }
    function jsonstringify(string){
        try{
            return JSON.stringify(string); 
        }catch(e){
            console.error(e);
            return {}; 
        }
    }
    function set_fbly_open_button(){
        var fbly_open_button_width = $("#fbly_open_button").outerWidth();
        $("#fbly_open_button").css({left: "-"+(fbly_open_button_width/2)+ "px"}) ;
    }
    function closeSidebar(){
        localStorage.open_Sidebar = 0; 
        $("#fbly").removeClass("show"); 
        $("html").css({width: "100%"});
        $("#fbly_open_button").removeClass("openSidebar");
    }
    function openSidebar(){
        localStorage.open_Sidebar = 1; 
        $("#fbly").addClass("show"); 
        $("html").css({width: "calc(100% - " +$("#fbly").outerWidth()+"px)"});
        $("#fbly_open_button").addClass("openSidebar");
    }

    function init_fbly_sidebar(){
        "use strict";
        var window_width = $(window).outerWidth(); 
        var fbly = $("#fbly"); 
        var fbly_width = $("#fbly").outerWidth(); 
        var fbly_open_button = $("#fbly_open_button"); 
        var createelement = "headline";
        var elementsetID = "0";
        var icon = "";
        var close = new Array(); 
        var id = 0; // PLACEHOLDER ID
        var load_count = 0; //IFRAME LOAD

        set_fbly_open_button();

        if(localStorage.attr_close){
            close = jsonparse(localStorage.attr_close); 
            for(var i = 0; i < close.length; i++){
                $("."+close[i]).children(".inside_fbly_select_itemHolder").slideUp(0, function(){
                    $(this).addClass("attr_close");
                });
            }
        }

        if(localStorage.open_Sidebar == 1 && window_width > 600){
            openSidebar();
        }else{
            closeSidebar();
        }
        fbly_open_button.on("click", function(){
            if(window_width > 600){
                if(localStorage.open_Sidebar == 1 ){
                    closeSidebar();
                }else{            
                    openSidebar();
                }
            }else{
                alert("Der Bildschirm ist zu klein! (min: 600px)");
                closeSidebar();
            }
        }); 

        //CREATE THE PLACEHOLDER
        var createElement_all = $("body").find('*').filter("[data-createElement]");
        createElement_all.each(function(index){
            var json = createStringFromJsonTag($(createElement_all[index]));
            if(json["links"]){
                if(json["links"]["article"]){ //PLACEHOLDER FOR MOD_ARTICLE
                    if(json["links"]["pastenew"]){
                        if(json["template"]){
                            $(createElement_all[index]).children(".inside").prepend('<div id="fbly_placeholder_'+id+'" class="fbly_placeholder fbly_pl_modarticle"  data-createElement-pastenewURL="'+json["links"]["pastenew"]["url"]+'"><div class="fbly_placeholder_inside" title="'+json["links"]["pastenew"]["label"]+' ('+json["template"]+')"><div class="holder" title="'+json["links"]["pastenew"]["label"]+'"><img src="bundles/frontendbuilder/icons/icon.svg"></div></div></div>');
                        }else{
                            $(createElement_all[index]).children(".inside").prepend('<div id="fbly_placeholder_'+id+'" class="fbly_placeholder fbly_pl_modarticle"  data-createElement-pastenewURL="'+json["links"]["pastenew"]["url"]+'"><div class="fbly_placeholder_inside" title="'+json["links"]["pastenew"]["label"]+'"><div class="holder" title="'+json["links"]["pastenew"]["label"]+'"><img src="bundles/frontendbuilder/icons/icon.svg"></div></div></div>');
                        }
                    }
                }else{ //PLACEHOLDER FOR ELEMENT
                    if(json["template"]){
                        $(createElement_all[index]).append('<div id="fbly_placeholder_'+id+'" class="fbly_placeholder"  data-createElement-pastenewURL="'+json["links"]["pastenew"]["url"]+'"><div class="fbly_placeholder_inside" title="'+json["links"]["pastenew"]["label"]+'"><div class="holder" title="'+json["links"]["pastenew"]["label"]+' ('+json["template"]+')"><img src="bundles/frontendbuilder/icons/icon.svg"></div></div></div>');
                    }
                    else{
                        $(createElement_all[index]).append('<div id="fbly_placeholder_'+id+'" class="fbly_placeholder"  data-createElement-pastenewURL="'+json["links"]["pastenew"]["url"]+'"><div class="fbly_placeholder_inside" title="'+json["links"]["pastenew"]["label"]+'"><div class="holder" title="'+json["links"]["pastenew"]["label"]+'"><img src="bundles/frontendbuilder/icons/icon.svg"></div></div></div>');
                    }
                }
            }
            id++;
        }); 

        //ACTION WITH ITEM
        $(".draggable_item").on("dragstart", function(event){
            createelement = $(this).attr("data-value");
            if(createelement == "elementset"){
                elementsetID = $(this).attr("data-elementset"); 
            }
            $(this).addClass("fbly_item_dragstart");
            icon = $(this).children(".image_container").children("img").attr("src");
        });
        $(".draggable_item").on("dragend", function(event){
            $(".fbly_item_dragstart").removeClass("fbly_item_dragstart");
            $(".fbly_activeCreate").removeClass("fbly_activeCreate");
        });
        $("[data-createElement]").on("dragenter", function(event){
            var json = createStringFromJsonTag($(this));
            if(json["links"]){
                if($(this).prop("tagName") != "BODY" && $(this).prop("tagName") != "SCRIPT" && $(this).prop("tagName") != "HTML"){
                    $(this).addClass("fbly_activeCreate");
                    if(icon != ""){
                        $(this).find(".fbly_placeholder").find("img").attr("src", icon);
                    }
                }
            }
        }); 
        $("[data-createElement]").on("dragleave", function(event){
            $(this).removeClass("fbly_activeCreate");
        }); 
        $("[data-createElement]").on("dragover", function(event){
            event.preventDefault();
            if($(this).prop("tagName") != "BODY" && $(this).prop("tagName") != "SCRIPT" && $(this).prop("tagName") != "HTML"){
                $(this).addClass("fbly_activeCreate");
            }

        }); 


        //ACTION WITH PLACEHOLDER
        $("body").on("drop", ".fbly_placeholder", function(event){
            event.preventDefault();
            if($(this).prop("tagName") != "BODY" && $(this).prop("tagName") != "SCRIPT" && $(this).prop("tagName") != "HTML"){


                var old_url = $(this).attr("data-createelement-pastenewurl"); 
                if(old_url){
                    if(elementsetID != 0){
                        //console.log(old_url);
                        var old_url = old_url.replace("create", "elementset_edit");
                        var url = old_url + "&elementset_id="+elementsetID;
                    }else{
                        var url = old_url + "&selectboxvalue="+createelement;
                    }

                    $("#fbly_iframe iframe").attr("src", url);
                    $("#fbly_iframe").addClass("show");
                }

            }
        }); 



        $("body").on("dragover", ".fbly_placeholder", function(event){
            //console.log($.isFunction(matchHeight));
            //console.log("function"==typeof define&&define.amd?define(["jquery"]));

            event.preventDefault();
            var json = "";

            if($(this).parent("[data-createElement]").length == 0){
                json = createStringFromJsonTag($(this).parent().parent("[data-createElement]"));
            }else{
                json = createStringFromJsonTag($(this).parent("[data-createElement]"));
            }
            if(json["template"]){
                $(this).addClass("fbly_activeCreate_dragover_withTemplate");
            }else{
                $(this).addClass("fbly_activeCreate_dragover");
            }

        });
        $("body").on("dragleave", ".fbly_placeholder", function(event){
            $(this).removeClass("fbly_activeCreate_dragover_withTemplate");
            $(this).removeClass("fbly_activeCreate_dragover");
        });



        //IFRAME
        $("#fbly_iframe_iframe").on("load", function(){
            load_count++; 
            if(load_count == 2 && createelement != "text"){
                $("#fbly_preloader").addClass("loaded");
            }else{
                //ABFRAGE
                if(createelement == "text" || elementsetID != 0){
                    $("#fbly_preloader").addClass("loaded");
                }
                setTimeout(function(){$("#fbly_preloader").addClass("loaded");}, 6000);
            }
        });
        $("#fbly_iframe_closeButton").click(function(){
            $("#fbly_iframe").removeClass("show"); 
            $("#fbly_iframe iframe").attr("src", " ");
            location.reload();
        })

        //SIDEBAR
        $("#tmenu .submenu").click(function(){
            $(this).toggleClass("active");
        })
        $(".fbly_select_itemHolder h3").click(function(){
            if(localStorage.attr_close){
                close = jsonparse(localStorage.attr_close); 
            }

            var attr_close = $(this).parent().attr("class").split(' ');     
            attr_close = attr_close[1];
            if(!$(this).siblings(".inside_fbly_select_itemHolder").hasClass("attr_close")){
                $(this).siblings(".inside_fbly_select_itemHolder").slideUp(200, function(){
                    $(this).addClass("attr_close");
                });
                if(!close.includes(attr_close)){
                    close.push(attr_close);
                }
            }else{
                $(this).siblings(".inside_fbly_select_itemHolder").slideDown(200, function(){
                    $(this).removeClass("attr_close");
                });
                
                if(close.includes(attr_close)){
                    close.splice(close.indexOf(attr_close),1)
                }
            }
            localStorage.attr_close = jsonstringify(close);   
            //setTimeout(function(){ positionFooter();   }, 300);
  
        });
    }
    init_fbly_sidebar();

    $(window).on("resize", function(){
        set_fbly_open_button();
        if(localStorage.open_Sidebar == 1){
            $("html").css({width: "calc(100% - " +$("#fbly").outerWidth()+"px)"});
        }
        if(localStorage.open_Sidebar == 1 && $(window).outerWidth() <= 600){
            closeSidebar();
            alert("Der Bildschirm ist zu klein! (min: 600px)");
        }
    });
});