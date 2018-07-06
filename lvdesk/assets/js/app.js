/**
* Theme: WebAdmin Template
* Author: Themesdesign
* Main Js
*/


/* constants and common elements - for caching */
var WebAdmin_VARS = {
    BODY: $("body"),
    WRAPPER: $("#wrapper"),
    LEFT_ITEMS: $(".left ul")
};

!function($) {
    "use strict";

    var Sidemenu = function() {
        this.$body = WebAdmin_VARS.BODY,
        this.$openLeftBtn = $(".open-left"),
        this.$menuItem = $("#sidebar-menu a"),
        this.$subDropItem = $(".subdrop"),
        this.$leftMenuToggle = $(".open-left"),
        this.$firstMenuChild = $("#sidebar-menu ul li.has_sub a.active")
    };
    Sidemenu.prototype.openLeftBar = function() {
        WebAdmin_VARS.WRAPPER.toggleClass("enlarged");
        WebAdmin_VARS.WRAPPER.addClass("forced");

        if (WebAdmin_VARS.WRAPPER.hasClass("enlarged") && WebAdmin_VARS.BODY.hasClass("fixed-left")) {
            WebAdmin_VARS.BODY.removeClass("fixed-left").addClass("fixed-left-void");
        } else if (!WebAdmin_VARS.WRAPPER.hasClass("enlarged") && WebAdmin_VARS.BODY.hasClass("fixed-left-void")) {
            WebAdmin_VARS.BODY.removeClass("fixed-left-void").addClass("fixed-left");
        }

        if (WebAdmin_VARS.WRAPPER.hasClass("enlarged")) {
            WebAdmin_VARS.LEFT_ITEMS.removeAttr("style");
        } else {
            this.$subDropItem.siblings("ul:first").show();
        }

        toggle_slimscroll(".slimscrollleft");
        WebAdmin_VARS.BODY.trigger("resize");
    },
    //menu item click
    Sidemenu.prototype.menuItemClick = function(e) {
        var $this = this;
        if (!WebAdmin_VARS.WRAPPER.hasClass("enlarged")) {
            if ($(this).parent().hasClass("has_sub")) {
                e.preventDefault();
            }
            if (!$(this).hasClass("subdrop")) {
                // hide any open menus and remove all other classes
                $("ul", $(this).parents("ul:first")).slideUp(350);
                $("a", $(this).parents("ul:first")).removeClass("subdrop");
                $("#sidebar-menu .pull-right i").removeClass("mdi-minus").addClass("mdi-plus");

                // open our new menu and add the open class
                $(this).next("ul").slideDown(350);
                $(this).addClass("subdrop");
                $(".pull-right i", $(this).parents(".has_sub:last")).removeClass("mdi-plus").addClass("mdi-minus");
                $(".pull-right i", $(this).siblings("ul")).removeClass("mdi-minus").addClass("mdi-plus");
            } else if ($(this).hasClass("subdrop")) {
                $(this).removeClass("subdrop");
                $(this).next("ul").slideUp(350);
                $(".pull-right i", $(this).parent()).removeClass("mdi-minus").addClass("mdi-plus");
            }
        }
    },

    //init sidemenu
    Sidemenu.prototype.init = function() {
        var $this = this;
        //bind on click
        $this.$leftMenuToggle.on('click', function (e) {
            e.stopPropagation();
            $this.openLeftBar();
        });

        // LEFT SIDE MAIN NAVIGATION
        $this.$menuItem.on('click', $this.menuItemClick);

        // NAVIGATION HIGHLIGHT & OPEN PARENT
        $this.$firstMenuChild.parents("li:last").children("a:first").addClass("active").trigger("click");

        // activating menu item based on url
        $this.$menuItem.each(function() {
            if (this.href == window.location.href) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                $(this).parent().parent().prev().trigger('click'); // click the item to make it drop
            }
        });
    },

    //init Sidemenu
    $.Sidemenu = new Sidemenu, $.Sidemenu.Constructor = Sidemenu

}(window.jQuery),


function($) {
    "use strict";

    var FullScreen = function() {
        this.$body = WebAdmin_VARS.BODY,
        this.$fullscreenBtn = $("#btn-fullscreen")
    };

    //turn on full screen
    // Thanks to http://davidwalsh.name/fullscreen
    FullScreen.prototype.launchFullscreen  = function(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    },
    FullScreen.prototype.exitFullscreen = function() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    },
    //toggle screen
    FullScreen.prototype.toggle_fullscreen  = function() {
        var $this = this;
        var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;
        if (fullscreenEnabled) {
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                $this.launchFullscreen(document.documentElement);
            } else {
                $this.exitFullscreen();
            }
        }
    },
    //init sidemenu
    FullScreen.prototype.init = function() {
        var $this = this;
        //bind
        $this.$fullscreenBtn.on('click', function () {
            $this.toggle_fullscreen();
        });
    },
     //init FullScreen
    $.FullScreen = new FullScreen, $.FullScreen.Constructor = FullScreen

}(window.jQuery),


//main app module
 function($) {
    "use strict";

    var WebAdmin = function() {
        this.VERSION = "1.0.0",
        this.AUTHOR = "ThemesDesign",
        this.SUPPORT = "#",
        this.pageScrollElement = "html, body",
        this.$body = WebAdmin_VARS.BODY
    };

    //initializing tooltip
    WebAdmin.prototype.initTooltipPlugin = function() {
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip()
    },

    //initializing popover
    WebAdmin.prototype.initPopoverPlugin = function() {
        $.fn.popover && $('[data-toggle="popover"]').popover()
    },

    //initializing nicescroll
    WebAdmin.prototype.initNiceScrollPlugin = function() {
        //You can change the color of scroll bar here
        $.fn.niceScroll &&  $(".nicescroll").niceScroll({ cursorcolor: '#9d9ea5', cursorborderradius: '0px'});
    },

     //on doc load
    WebAdmin.prototype.onDocReady = function(e) {
        FastClick.attach(document.body);
        Menufunction.push("initscrolls");
        Menufunction.push("changeptype");

        $('.animate-number').each(function () {
            $(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-duration")));
        });

        //RUN RESIZE ITEMS
        $(window).resize(debounce(resizeitems, 100));
        WebAdmin_VARS.BODY.trigger("resize");

        // Wow - for animation effect
        var wow = new WOW(
            {
                boxClass: 'wow', // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 50, // distance to the element when triggering the animation (default is 0)
                mobile: false        // trigger animations on mobile devices (true is default)
            }
        );
        wow.init();
    },

    //init
    WebAdmin.prototype.init = function() {
        var $this = this;
        this.initTooltipPlugin();
        this.initPopoverPlugin();
        this.initNiceScrollPlugin();

        //document load initialization
        $(document).on('ready', $this.onDocReady);
        //init side bar - left
        $.Sidemenu.init();
        //init fullscreen
        $.FullScreen.init();
    },

    $.WebAdmin = new WebAdmin, $.WebAdmin.Constructor = WebAdmin

}(window.jQuery),

//initializing main application module
function($) {
    "use strict";
    $.WebAdmin.init();
}(window.jQuery);



/* ------------ algumas funções de utility  ----------------------- */

var w,h,dw,dh;
var changeptype = function(){
    w = $(window).width();
    h = $(window).height();
    dw = $(document).width();
    dh = $(document).height();

    if (jQuery.browser.mobile === true) {
        WebAdmin_VARS.BODY.addClass("mobile").removeClass("fixed-left");
    }

    if (!WebAdmin_VARS.WRAPPER.hasClass("forced")) {
        if (w > 1024) {
            WebAdmin_VARS.BODY.removeClass("smallscreen").addClass("widescreen");
            WebAdmin_VARS.WRAPPER.removeClass("enlarged");
        } else {
            WebAdmin_VARS.BODY.removeClass("widescreen").addClass("smallscreen");
            WebAdmin_VARS.WRAPPER.addClass("enlarged");
            WebAdmin_VARS.LEFT_ITEMS.removeAttr("style");
        }
        if (WebAdmin_VARS.WRAPPER.hasClass("enlarged") && WebAdmin_VARS.BODY.hasClass("fixed-left")) {
            WebAdmin_VARS.BODY.removeClass("fixed-left").addClass("fixed-left-void");
        } else if (!WebAdmin_VARS.WRAPPER.hasClass("enlarged") && WebAdmin_VARS.BODY.hasClass("fixed-left-void")) {
            WebAdmin_VARS.BODY.removeClass("fixed-left-void").addClass("fixed-left");
        }

  }
  toggle_slimscroll(".slimscrollleft");
}


var debounce = function(func, wait, immediate) {
  var timeout, result;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) result = func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) result = func.apply(context, args);
    return result;
  };
}

function resizeitems(){
  if($.isArray(Menufunction)){
    for (i = 0; i < Menufunction.length; i++) {
        window[Menufunction[i]]();
    }
  }
}

function initscrolls(){
    if(jQuery.browser.mobile !== true){
      //SLIM SCROLL
      $('.slimscroller').slimscroll({
        height: 'auto',
        size: "5px"
      });

      $('.slimscrollleft').slimScroll({
          height: 'auto',
          position: 'right',
          size: "7px",
          color: '#bbb',
          wheelStep: 5
      });
  }
}
function toggle_slimscroll(item){
    if(WebAdmin_VARS.WRAPPER.hasClass("enlarged")){
      $(item).css("overflow","inherit").parent().css("overflow","inherit");
      $(item). siblings(".slimScrollBar").css("visibility","hidden");
    }else{
      $(item).css("overflow","hidden").parent().css("overflow","hidden");
      $(item). siblings(".slimScrollBar").css("visibility","visible");
    }
}

/**
* Tema: LV Desk
* Autor: Adan Ribeiro
* JQuery
* Data: 12/05/2018
*/

//Comportamento dos links do menu do painel administrativo
$(document).ready(function(){
	$("body")
	.on('click', '.regular-link', function(){ //links comuns para navegação casual.
   		$(".content").load($(this).attr("link"));
	});
	
	//Captura o valor do option selecionado para conexão com provedores
	$("body")
	.on("change", "#select_provedor", function (event){ 
		$("input[name='flag']").val($("select option:selected").attr('tipo'));
		$("input[name='id_provedor']").val($("select option:selected").attr('value'));
	});
	
	$("body")
	.on("click", "#solucionado", function (event){ 
		$(".input_hidden").append("<input type='hidden' name='idd' value='solucionado'>");
	});
	//Actions com envio para modal na mesma página.
	$("body")
	.on("click", ".envia-modal", function (event){ 
		var a = $(this).attr("item");
		var b = $(this).attr("desc");
		$("#recebeValor").attr("value", a);
		var wysihtml5Editor = $('#log').data("wysihtml5").editor;
		wysihtml5Editor.composer.commands.exec("insertHTML", b);		
	});
	
	$("body")
	.on("click", ".rtrn-conteudo", function (event){ 
		
		if($(this).attr("doZero")){
			var meucheckbox = $("#"+$(this).attr("objeto")).find("input[type=checkbox]");
			if(meucheckbox){
				$.each(meucheckbox, function(key, val){
					if(!$(this).is(":checked")){
						$(this).attr('value', '0');
						$(this).attr('checked', 'checked');
					}
				});
			}
		}
		var objeto = new FormData(document.querySelector("#"+$(this).attr("objeto")));	
		
		$.ajax({
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				if(objeto.get("retorno")){
					$(".modal-backdrop").hide();
					var retorno = objeto.get("retorno");
					$(retorno).html(retornoDados);
				}else{
					$("body").html(retornoDados);
				}								
			}
		});
	});
	
	//Actions com retorno de conteúdo para listagens.
	
	$("body")
	.on("click", ".rtrn-conteudo-listagem", function (event){ 
		if($(this).attr('flag') == 'exc'){
			$(".modal-footer").append("<input type='hidden' name='id' value='"+$(this).attr("item")+"'>");
			$(".modal-footer").append("<input type='hidden' name='caminho' value='"+$(this).attr("caminho")+"'>");
			$(".modal-footer").append("<input type='hidden' name='flag' value='"+$(this).attr("flag")+"'>");
		}else{
			var objeto  = new FormData(document.querySelector("#"+$(this).attr("objeto")));
			objeto.append("flag", $(this).attr("flag"));
			objeto.append("id", $(this).attr("item"));
			objeto.append("caminho", $(this).attr("caminho"));
			if($(this).attr("idd")){
				objeto.append("idd", $(this).attr("idd"));			
			}
			$.ajax({
				url: objeto.get("caminho"), 
				data: objeto,
				type: 'post',
				processData: false,  
				contentType: false,
				success: function(retornoDados){
					if(objeto.get("retorno")){
						var retorno = objeto.get("retorno");
						$(retorno).html(retornoDados);
					}else{
						$(".content-sized").html(retornoDados);	
					}							
				}
			}); 
		}
		
	});
	
	$("body")
	.on("click", ".rtrn-conteudo-listagem2", function (event){ 
		
		var id_div = $(this).attr("item");
		$('#rotulo'+id_div).hide();
		var objeto = new FormData(document.querySelector("#"+$(this).attr("objeto")));
		objeto.append("flag", $(this).attr("flag"));
		objeto.append("id", $(this).attr("item"));
		objeto.append("caminho", $(this).attr("caminho"));
		
		var elem = document.getElementById("barra"+id_div);   
		var width = 1;
		var id = setInterval(frame, 10);
		function frame() {
			if (width >= 100) {
			  clearInterval(id);
			} else {
			  width++; 
			  elem.style.width = width + '%'; 
			}
		}		
		
		$.ajax({
			
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				$("#target-status"+id_div).html(retornoDados);				
			}
		});
	});
	
	//Ação para processamento das conexões com proveodores externos
	
	$("body")
	.on("click", ".rtrn-conteudo-conexao", function (event){ 
		
		var objeto = new FormData(document.querySelector("#"+$(this).attr("objeto")));
		var objLnk = new FormData(document.querySelector("."+$(this).attr("objLnk")));
		
		for (var value of objLnk.values()) {
		   console.log(value); 
		}   
		
		for (var valor of objeto.values()) {
		   console.log(valor); 
		} 
		$.ajax({
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				$(".content-sized").html(retornoDados);				
			}
		});
	});
		
});

// para execução de funções retardatárias
var Menufunction = [];