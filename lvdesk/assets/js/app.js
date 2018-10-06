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

$(document).keypress(function(e) {
    if(e.which == 13) $('#primario').click();
});

//Comportamento dos links do menu do painel administrativo
$(document).ready(function(){
	$("body")
	.on('click', '.regular-link', function(){ //links comuns para navegação casual.
   		NProgress.start();
		$(".content").load($(this).attr("link"));
		//NProgress.done();
	});
	
	$("body")
	.on('click', '.regular-link-msg', function(){ //links navegação em mensagens.
   		NProgress.start();
		//$("#input_lida_"+$(this).attr("data-item")).val('1');				
		var objeto = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));				
		/* for(var pair of objeto.values()) {
			console.log(pair);
		}  */
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
					NProgress.done();
				}else{
					$(".content-sized").html(retornoDados);	
					NProgress.done();
				}							
			}
		}); 
		NProgress.done();		
	});
	
	$("body")
	.on('click', '.envia-listagem-deliberar', function(){
		
		var linha = new FormData(document.querySelector("#"+$(this).attr("linha")));
		NProgress.start();
		for(var pair of linha.entries()) {
			$(".input_hidden").append("<input class='remove-me' type='hidden' name='"+pair[0]+"' value='"+ pair[1]+"' />"); 
		}
		NProgress.done();
	}); 
	
	$("body")
	.on("click", ".remove-inputs", function (event){ 
		$(".remove-me").remove();
	});
	
	$("body")
	.on("click", ".icone-filtro", function (){ 
		$(".input-filtro").slideToggle('900');
	});
	 
	//Captura o valor do option selecionado para conexão com provedores
	$("body")
	.on("change", "#select_provedor", function (event){ 
		$("input[name='flag']").val($("select option:selected").attr('data-tipo'));
		$("input[name='id_provedor']").val($("select option:selected").attr('value'));
		$("input[name='contrato']").val($("select option:selected").attr('data-contrato'));
		$("input[name='id_dados']").val($("select option:selected").attr('data-id-dados'));
	});
	
	$("body")
	.on("change", "#select_id_contratos", function (event){ 
		$("input[name='nome_provedor']").val($("#select_id_contratos option:selected").attr('data-nome'));
	});
	
	$("body")
	.on("change", "#id_cliente", function (event){ 
		$("input[name='email']").val($("select option:selected").attr('email'));
	});
	
	$("body")
	.on("change", "#atendentes-select-user", function (event){ 
		$("input[name='usuario']").val($("select option:selected").attr('data-user'));
		$("input[name='id_usuarios']").val($("select option:selected").attr('data-id'));
	});
	
	$("body")
	.on("click", "#solucionado", function (event){ 
		$(".input_hidden").append("<input type='hidden' name='idd' value='solucionado'>");
	});
	
	//Actions com envio para modal na mesma página.
	$("body")
	.on("click", ".envia-modal", function (event){ 
		var a = $(this).attr("item");
		var b = $(this).attr("cliente_id");		
		$("#protocol").attr("value", a);
		$("input[name='id']").attr("value", b);
		var objeto = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));
		objeto.append('id', b);
		NProgress.start();
		$.ajax({
			url: "controllers/sys/crud.sys.php", 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				if(objeto.get("retorno")){
					NProgress.done();
					var retorno = objeto.get("retorno");
					$(retorno).html(retornoDados);
				}else{
					NProgress.done();
					$("body").html(retornoDados);
				}								
			}
		});
		
	});
	
	$("body")
	.on("click", "#new_protcol", function (event){ 
		var a = function dataAtualFormatada(){
			var data = new Date();
			var dia = data.getDate();
			if (dia.toString().length == 1)
			  dia = "0"+dia;
			
			var mes = data.getMonth()+1;
			if (mes.toString().length == 1)
			  mes = "0"+mes;
			
			var ano = data.getFullYear();
            
			var time = data.getHours();
			if (time.toString().length == 1)         
              time = "0"+time;                
                
            var min = data.getMinutes();			
            if (min.toString().length == 1)
              min = "0"+min;
		  
		    var sec = data.getSeconds();			
            if (sec.toString().length == 1)
              sec = "0"+sec;
			return ano+mes+dia+time+min+sec;
		}
		$("#protocol").attr("value", a);
	});
	
	$("body")
	.on("click", ".rtrn-conteudo", function (event){ 
		
		if($(this).attr("doZero")){
			var meucheckbox = $("#"+$(this).attr("data-objeto")).find("input[type=checkbox]");
			if(meucheckbox){
				$.each(meucheckbox, function(key, val){
					if(!$(this).is(":checked")){
						$(this).attr('value', '0');
						$(this).attr('checked', 'checked');
					}
				});
			}
		}
		var objeto = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));	
		NProgress.start();
		$.ajax({
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				if(objeto.get("retorno")){
					if(objeto.get("retorno")==".modal-body-add"){
						for(var pair of retornoDados.entries()) {
							$("#addSoftware").append("<option value='"+ pair[0]+"' >"+ pair[1]+"</option>"); 
						} 
					}else{
						$(".modal-backdrop").hide();
						NProgress.done();
						var retorno = objeto.get("retorno");
						$(retorno).html(retornoDados);
					}
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
			if($(this).next("#plano_verifica").val() == 1){ // verifica se os planos estão vinculados a um contrato
				$(".modal-footer").append("<input type='hidden' name='flag' value='verifica_exc_plano'>");
			}else{
				$(".modal-footer").append("<input type='hidden' name='flag' value='"+$(this).attr("flag")+"'>");
			} 			
		}else{
			var objeto  = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));
			if($(this).attr("flag")){
				objeto.append("flag", $(this).attr("flag"));
			}
			if($(this).attr("item")){
				objeto.append("id", $(this).attr("item"));
			}
			if($(this).attr("caminho")){
				objeto.append("caminho", $(this).attr("caminho"));
			}
			if($(this).attr("idd")){
				objeto.append("idd", $(this).attr("idd"));			
			}
			NProgress.start();
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
						NProgress.done();
					}else{
						$(".content-sized").html(retornoDados);	
						NProgress.done();
					}							
				}
			}); 
		}
		
	});
	
	$("body")
	.on("click", ".rtrn-conteudo-listagem2", function (event){ 
		
		var id_div = $(this).attr("item");
		$('#rotulo'+id_div).hide();
		var objeto = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));
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
		NProgress.start();
		$.ajax({
			
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				$("#target-status"+id_div).html(retornoDados);	
				NProgress.done();				
			}
		});
	});
	
	$("body")
	.on("change", ".atribuiGrupo", function (){ 
		NProgress.start();	
		var objeto = new FormData(document.querySelector("#form-atribui"));	
		if(objeto.get("id_grupo") == '1'){
			$("#tbl").attr("value", "comunicacao_interna");
			$("#atribui_envio").attr("data-commit", "1");
		}else{
			$("#tbl").attr("value", "pav_inscritos");
			$("#atribui_envio").removeAttr("data-commit");
		}
		$.ajax({			
			url: "controllers/sys/crud.sys.php", 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				$("#callback-atribuiGrupo").html(retornoDados);	
				NProgress.done();				
			}
		}); 		 
	});
	
	$("body")
	.on("click", "#atribui_envio", function (event){ 
		if($(this).attr("data-commit")){
			$("#flag").remove(); //evita conflitos no envio do post
			var contatos = new FormData(document.querySelector("#form-atribui"));
			var objeto   = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));	
			for(var pair of contatos.entries()) {
				objeto.append(pair[0], pair[1]); 
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
						$("body").html(retornoDados);
					}		
					NProgress.done();
				}
			}); 
		}
	}); 
	
	//Ação para processamento das conexões com proveodores externos
	
	$("body")
	.on("click", ".rtrn-conteudo-conexao", function (event){ 
		
		var objeto = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));
		var objLnk = new FormData(document.querySelector("."+$(this).attr("objLnk")));
		
		for (var value of objLnk.values()) {
		   console.log(value); 
		}   
		
		for (var valor of objeto.values()) {
		   console.log(valor); 
		} 
		NProgress.start();
		$.ajax({
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				$(".content-sized").html(retornoDados);	
				NProgress.done();
			}
		});
	});
	
	$("body")
	.on("keyup", "#tabela input", function(){		        
		var index = $(this).parent().index();
		var nth = "#tabela td:nth-child("+(index+1).toString()+")";
		var valor = $(this).val().toUpperCase();
		$("#tabela tbody tr").show();
		$(nth).each(function(){
			if($(this).text().toUpperCase().indexOf(valor) < 0){
				$(this).parent().hide();
			}
		});		
	 
		$("#tabela input").blur(function(){
			$(this).val("");
		}); 
	});

	//Busca destinatário dinamicamente
	$("body")
	.on("keyup", '#buscaDestinatario', function(event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			var $this = $(this); 
			var valor = $this.next(".list-container").find(".list-search").find("input").val(); //definir valor 
			var nome = $("#span_nome_"+valor).text();
			$(".list-group").append("<span class='label label-success com-padding'><input type='hidden' id='input_responsavel_"+valor+"' name='grupo_responsavel[]' value='"+valor+"' />"+nome+"<a class='close x'> ×</a></span>");
			$this.next(".list-container").find(".list-search").find("span").remove();
			$(this).val("");
		}else{
			var pesquisa = $(this).val();
			var tecla = keycode;
			$.ajax({
				url: "controllers/sys/crud.sys.php", 
				data: {nome: pesquisa, flag: "pesquisaDestinatario", teste: tecla },
				type: 'post',
				processData: true,  
				success: function(retornoDados){
					$(".list-search").html(retornoDados);
					NProgress.done();
				}
			});
		}
	});		
	
	$("body")
	.on("click", '.x', function() {
		$(this).parent("span").remove();
		$(this).parents("span").remove();
	});
	
	$("body")
	.on("click", ".vincular", function() {
		var software_value = $("#addSoftware option:selected").val();
		var software_name  = $("#addSoftware option:selected").text();
		var software_tipo_bd = $("#addSoftware option:selected").attr("data-tipo");
		$("#vinculos").append('<span><form id="form-'+software_value+'"><input type="hidden" name="id_pav" value="'+software_value+'"><input type="hidden" name="tipo" value="'+software_tipo_bd+'"><div class="panel-group col-sm-10" id="accordion-test-'+software_value+'"><div class="panel panel-success panel-color"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-test-'+software_value+'" href="#collapseOne-'+software_value+'" aria-expanded="false" class="collapsed">'+software_name+'</a></h4></div><div id="collapseOne-'+software_value+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"><div class="panel-body"><div class="row"><div class="form-group col-sm-3"><label for="client_url">ID do Cliente</label><input type="text" class="form-control" name="client_id" /></div><div class="form-group col-sm-6"><label for="client_url">Host do Cliente</label><input type="text" class="form-control" name="client_url" /></div></div><div class="row"><div class="form-group col-sm-6"><label for="client_secret">Segredo</label><input type="text" class="form-control" name="client_secret"/></div><div class="form-group col-sm-3"><label for="client_user">Usuário do Cliente</label><input type="text" class="form-control" name="client_user" /></div><div class="form-group col-sm-3"><label for="client_pass">Password do Cliente</label><input type="text" class="form-control" name="client_pass" /></div></div></div></div></div></div><div class="form-group col-sm-2"><input class="btn btn-danger col-sm-12 x" value="Excluir" data-objeto="form-'+software_value+'" type="button" title="Remove o provedor"/></div></form></span>');
	});
	
	$("body")
	.on("click", '.run-provedores-magnify', function() {
		NProgress.start();
		var objeto = new FormData(document.querySelector("#"+$(this).attr("data-objeto")));
		var obj = {};		
		$("#vinculos span form").find("input").each(function(index){
            var name = $(this).attr("name");
			if($(this).val() != "Excluir"){
				obj[name] = $(this).val();				
			}else{
				objeto.append("provedores[]", JSON.stringify(obj));
			}
        });
		
		$.ajax({
			url: objeto.get("caminho"),
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false, 
			success: function(x){
				$(".content-sized").html(x);	
			}
		});
		NProgress.done();
	});
	
});
// para execução de funções retardatárias
var Menufunction = [];

//Máscaras
$('.dinheiro').mask('#.##0,00', {reverse: true});
$('.telefone').mask('(00) 00000-0000');
$('.telefonefixo').mask('(00) 0000-0000');
$('.estado').mask('AA');
$('.cpf').mask('000-000.000-00');
$('.cnpj').mask('00.000.000/0000-00');
$('.rg').mask('00.000.000-0');
$('.cep').mask('00000-000');
$('.dataNascimento').mask('00/00/0000');
$('.horasMinutos').mask('00:00');
$('.cartaoCredito').mask('0000 0000 0000 0000');