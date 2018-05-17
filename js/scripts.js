function ajax(url, variaveis, conteudo) {
    var http = false;
    if(navigator.appName == "Microsoft Internet Explorer") {
      http = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
      http = new XMLHttpRequest();
    }
    http.onreadystatechange=function stateChanged() { 
    if (http.readyState == 4 || http.readyState=="complete"){ 
           document.getElementById(conteudo).innerHTML=http.responseText
        }else
           document.getElementById(conteudo).innerHTML="<i>Carregando...</i>";
    };
	http.open("POST",url,true);
    //http.open("GET",url+'?'+variaveis,true);
    http.send(null);
}
//Deslizar dos artigos na index
$(document).ready(function(){
	$("body")
	.on("mouseover", '.artigos_quartilho', function () {
		$(this).attr('style', $(this).find('.param2').attr('style'));
		$(this).find(".div_chamada_artigo_quartilho_alfa").show("slow");
		$(this).find(".div_chamada_artigo_quartilho_beta").hide("slow");
		$(this).find("a[leiaMais_beta]").show("slow");
	});
	$("body")
	.on("mouseleave", '.artigos_quartilho', function () {
		$(this).attr('style', $(this).find('.param1').attr('style'));
		$(this).find(".div_chamada_artigo_quartilho_alfa").hide("slow");
		$(this).find(".div_chamada_artigo_quartilho_beta").show("slow");
		$(this).find("a[leiaMais_beta]").hide("slow");	
	});
});
//Limitando caracteres em uma textarea
$(document).ready(function(){
	$("body")
	.on('keyup', 'textarea', function () {
		var limite = 300;
		var caracterDigitado = $(this).val();
		var caracterRestante = limite - caracterDigitado.length;	
		$("#exibe_limite").html("Restam " + caracterRestante + " caracteres.");
		if(caracterDigitado.length == limite - 1)
			$("#exibe_limite").html("Resta " + caracterRestante + " caractere.");
		if(caracterDigitado.length >= limite){
			$(this).val() = $(this).val().substr(0, limite);
			$("#exibe_limite").html("<span style='color:red;'>Você já atingiu o limite de caracteres permitido!</span>");
		}
	});
});
//botões de exclusão e edição  
$(document).ready(function(){
	$("body")
	.on('click', '.botAction', function () {
		var id = $(this).attr('id');		
		objeto = {};		
		objeto["id"] = $(this).attr('item');
		objeto["tbl"] = $(this).attr('tbl');		
		objeto["callback"] = $(this).attr('link');
		if(id == 'Exc'){
			objeto["flag"] = "exc";
			if ($(".arquivo").attr('src') != "undefined") {							
				objeto["arquivo"] = $(".arquivo").attr('src');	
				if ($(this).attr('id') != "undefined") {
					objeto["id_contato"] = $(".arquivo").attr('id');			
				}
			}
		}else {
			objeto["flag"] = "edt";
		}
		$.ajax({
			url: "sys/crud.sys.php",
			data: objeto,
			type: 'post',
			dataType:"json",
			complete: function(x){
				if( id == 'Exc'){
					if ($(this).attr('id') != "undefined") {
						$.ajax({
						url: objeto["callback"],
						data: {id_contato: objeto["id_contato"]},
						type: 'POST',
						success: function(valor){
							$('.conteudo').html(valor);
						}
					});
					return false;			
					}else{
						$(".conteudo").load(objeto["callback"]);
						return false;
					}
				}else{
					$.ajax({
						url:objeto["callback"],
						data:x.responseJSON,
						type:'post',
						dataType:"html",
						success: function(y){
							$(".conteudo").html(y);
						}
					});
					return false;
				}
			}
		});
	});
});

//Comportamento das mensagens de alerta
$(document).ready(function(){
$("body")
	.on('click', 'div[msg_dialog]', function () {
		$(this).slideUp(500);
		return false;
	});
	window.setTimeout(function() {
        $('div[msg_dialog]').slideUp(500);
    }, 5000);
});
//Comportamento dos links do menu do painel administrativo
$(document).ready(function(){
	$("body")
	.on('click', '.menu-control', function () {
		$(".conteudo").load($(this).attr("link"));		
	});
//Comportamento dos links do front
	$("body")
	.on('click', '.menu-nav, .menu-mapa, .regular-link', function(){
   		$(".container-fluid").load($(this).attr("link"));
	});
//Comportamento dos links leiaMais
	$("body")
	.on('click', '.leiaMais, .leia_slide', function(event){
		event.preventDefault();
   		$.ajax({
			url: "sys/crud.sys.php",
			type: "POST",
			data: {
				id: $(this).attr("link"),
				flag: "abreArtigoBlog",
			},
			success: function(retorno){
				$(".container").html(retorno);
			}
		});
	});	
//Botão para pagamento dos itens do carrinho de compras	
	$("body")
	.on("click", "#botPagamento", function (event){
		event.preventDefault();
		var objeto = new FormData(document.querySelector('#form_requisicao_pagamento'));
		objeto.append('flag', 'requisicaoPagamento');
		$.ajax({
			url: "sys/pagamento.sys.php", 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			success: function(retornoDados){
				$(".conteudo").html(retornoDados);				
			}
		});
	});
});
//Validação de senha e e-mail no cadastro de usuário
$(document).ready(function(){
	$("body")
	.on('change', '#confirmasenha', function () {
		var a = $("#senha").val();
		var b = $(this).val();
		if(a!=""){
			if(a == b){				
				$(this).attr("flag", "1");				
			}else{				
				$(this).attr("flag", "0");	
			}			
		}else{
			$(".cnfsenha").attr("style",'');
			$(this).attr("flag", "0");
		}
	});
	$("body")
	.on('blur', '#senha', function () {
		var e = $("#confirmasenha").val();
		var f = $(this).val();
		if(f!=""){
			if(e == f){				
				$("#confirmasenha").attr("flag", "1");				
			}else{				
				$("#confirmasenha").attr("flag", "0");	
			}			
		}else{
			$(".cnfsenha").attr("style",'');
			$(this).attr("flag", "0");
			$("#confirmasenha").attr("flag", "0");
		}
	});
	$("body")
	.on('change', '#confirmaemail', function () {
		var c = $("#email").val();
		var d = $(this).val();
		if(c!=""){
			if(c == d){				
				$(this).attr("flag", "1");
			}else{				
				$(this).attr("flag", "0");	
			}			
		}else{
			$(".cnfsenha").attr("style",'');
			$(this).attr("flag", "0");
		}
	});
	$("body")
	.on('blur', '#email', function () {
		var e = $("#confirmaemail").val();
		var f = $(this).val();
		if(f!=""){
			if(e == f){				
				$("#confirmaemail").attr("flag", "1");				
			}else{				
				$("#confirmaemail").attr("flag", "0");	
			}			
		}else{
			$(".cnfsenha").attr("style",'');
			$(this).attr("flag", "0");
			$("#confirmaemail").attr("flag", "0");
		}
	});	
	$("body")
	.on('change', 'input[name="nome"], input[name="usuario"], input[name="senha"]', function () {
		if($(this).val() != ""){
			$(this).attr("flag", "1");	
		}else{
			$(this).attr("flag", "0");	
		}
	});
	$("body")
	.on('change', 'input[name="usuario"]', function () {
		if($(this).val() != ""){
			$('.cnfuser').html("<img width='15' height='15' src='media/imagens/sys/icons/load.gif' />&nbsp;<i>Verificando e-mail...</i>");
			$.ajax({
				url: "sys/crud.sys.php",
				data: {usuario: $(this).val(), tbl:"usuarios", flag:"existeUser"},
				type: 'post',
				success: function(valor){
					$('.cnfuser').html(valor);
					if(valor != ''){
						$('#email').attr("flag", "0");	
					}else{
						$('#email').attr("flag", "1");	
					}
				}
			});	
		}
	});
	$("body")
	.on('blur', '.registroUser input[type="text"], .registroUser input[type="password"]', function(){
		var inputs = new Array();		
		$('.registroUser input[flag]').each(function(){
			inputs.push($(this).attr("flag"));
		});	
		if(inputs[2]==1){
			$(".cnfemail").attr("style","background-image:url('media/imagens/sys/icons/confsenha_ok.png');");
		}else{
			$(".cnfemail").attr("style","background-image:url('media/imagens/sys/icons/confsenha_falha.png')");
		}
		if(inputs[4]==1){
			$(".cnfsenha").attr("style","background-image:url('media/imagens/sys/icons/confsenha_ok.png');");
		}else{
			$(".cnfsenha").attr("style","background-image:url('media/imagens/sys/icons/confsenha_falha.png')");
		}
		if(inputs[0]==1 && inputs[1]==1 && inputs[2]==1 && inputs[3]==1 && inputs[4]==1){
			$("#salvar").show("slow");
		}else{
			$("#salvar").hide("slow");
		}
	});	
});

//Envio de dados pelas rotinas do menu de controle com "each" dinamizando a colheita dos atributos em admin.php
$(document).ready(function(){
$("body")
	.on('click', '.submete', function () {
		objeto = {};		
		$("input").each(function(index) {
			objeto[$(this).attr("name")] = $(this).val();
		});
		$.ajax({
			url: objeto["caminho"],
			data: objeto,
			type: 'post',
			success: function(valor){
				$('.conteudo').html(valor);
				return false;
			}
		});
	}); 
//Envio de dados com formData para layout-admin e para botão "parâmetros"
	$("body")
	.on('click', '.submeteZ', function () {
		var path = $('.caminho').val();
		var objeto = new FormData(document.querySelector("#form_upload"));
		$(".progresso").html("<i>Carregando, aguarde por favor...</i><br>");
		$.ajax({
			url: path,
			data: objeto,
			type: 'POST',
			processData: false,  
  			contentType: false,
			success: function(valor){
				$('.conteudo').html(valor);
			}
		});
	}); 
//Envio do formulário de addProdutos com tratamento para os campos decimais	
	$("body")
	.on('click', '.submeteProdutos', function () {
		var path = $('.caminho').val();
		var objeto = new FormData(document.querySelector("#form_upload"));
		objetoFrete = {};
		$("#referencia_frete input").each(function(index) {
			objetoFrete[$(this).attr("name")] = $(this).val();
			var str = objetoFrete[$(this).attr("name")];
			if(str.search(',')!= -1){
				objeto.append([$(this).attr("name")] , str.replace(',', '.'));
			}
		});
		$(".progresso").html("<i>Carregando, aguarde por favor...</i><br>");
		$.ajax({
			url: path,
			data: objeto,
			type: 'POST',
			processData: false,  
  			contentType: false,
			success: function(valor){
				$('.conteudo').html(valor);
			}
		});
	}); 
	$("body")
	.on('click', '.submeteConfig', function () {
		var path = $('.caminho').val();
		var objeto = new FormData(document.querySelector("#form_upload"));
		$(".progresso").html("<i>Carregando, aguarde por favor...</i>");
		$.ajax({
			url: path,
			data: objeto,
			type: 'POST',
			processData: false,  
  			contentType: false,
			success: function(valor){
				$('body').load('admin.php');
				//return false;
			}
		});
	});
//Comportamento do link de amostragens no administrativo
	$("body")
	.on('click', '.nav-amostra', function(event){
		event.preventDefault();
		var path = $(this).attr('link');
		var obj = {};
		obj['id_contato'] = $("input[name='id_contato']").val();			
		$(".progressoGaleria").html("<i>Carregando, aguarde por favor...</i>");
		
		$.ajax({
			url: path,
			data: obj,
			type: 'POST',
			success: function(valor){
				$('.conteudo').html(valor);
			}
		});
	});
// Botão de compra
	$("body")
		.on('click', '.botComprarProduto', function(event) {
			event.preventDefault();
			var path = $(this).attr('link');
			var obj = new FormData(document.querySelector("#form_compra"));
			$.ajax({
				url: path,
				data: obj,
				type: 'POST',
				processData: false,  
	  			contentType: false,
				success: function(rtrn){
					$('#meus_produtos').show('slow');
					$('#meus_produtos').html(rtrn);
				}
			});			
	});

$("body")
	.on('click', '#botCalculaFrete', function () {
		var path = $('.caminho').val();
		var objeto = new FormData(document.querySelector("#form_calculo_frete"));
		$('#section_retorno_frete').show('slow');
		$("#section_retorno_frete").html("<center><i>Consultando os Correios, aguarde por favor...</i><br><br><img width='15' height='15' src='media/imagens/sys/icons/load.gif' /></center>");
		$.ajax({
			url: path,
			data: objeto,
			type: 'POST',
			processData: false,  
  			contentType: false,
			success: function(valor){
				$('#section_retorno_frete').html(valor);				
			}
		});
	}); 
//Comportamento do botão de cálclo do frete
	$("body")
	.on('click', '#botApressarFreteProduto', function(){
		$("#section_calculo_frete").show("slow");
	});	
//Botão de cancelamento do cálculo do frete
	$('body')
	.on('click', '#botCancelarFrete', function () {
		$("#section_calculo_frete").hide("slow");	
	});
	$('body')
	.on('click', '#botFechar', function () {
		$("#section_retorno_frete").hide("slow");	
	});
//Envio de dados com formData no front 
	$("body")
	.on('click', '.submeteX', function (event) {
		event.preventDefault();
		var path = $('.caminho').val();
		var objeto = new FormData(document.querySelector("form"));	
		$(".progresso").html("<i>Carregando, aguarde por favor...</i><br><img id='load' src='media/imagens/sys/icons/load.gif' /><br>");
		$.ajax({
			url: path,
			data: objeto,
			type: 'POST',
			processData: false,  
  			contentType: false,
			success: function(valor){
				$('.container').html(valor);
				//return false;
			}
		});
	});
	//Comportamento do botão Detalhes da página Produtos
	$("body")
	.on('click', '.submeteItem', function (event) {
		//event.preventDefault();
		var path = $(this).attr('link');
		var id = $(this).attr("name");
		/*var objeto = new FormData(document.querySelector("#form_produtos_"+id));*/		
		$.ajax({
			url: path,
			data: {'id': id},
			type: 'POST',			
			success: function(valor){
				$(".container").html(valor);
				return false;
			}
   		});
	}); 
});
//Função para fechamento de sessão e conexão aberta
$(document).ready(function(){
	$('.sair').click(function() {
		$(".conteudo").html("<center><i>Fazendo logout na sessão, aguarde por favor...</i>&nbsp;<img width='15' height='15' src='media/imagens/sys/icons/load.gif' /></center>");
		$.ajax({
			url: "sys/login.sys.php" ,
			data: {flag:"logout"},
			type: 'post',
			success: function(valor){
				$('html').load(valor);				
				return false;
			}
		});
	});
//Função para fechamento de sessão e conexão aberta 	
	$('.sairLogin').click(function() {
		$.ajax({
			url: "sys/login.sys.php" ,
			data: {flag:"logout"},
			type: 'post',
			success: function(valor){
				$('.login_user').attr('style', 'display: none;');	
				//$('html').load('index.php');			
				$("body").html(valor);
				return false;
			}
		});
	});
});
//Slides
$(document).ready(function () {
    $('#slide a:eq(0) img').addClass('ativo').show();
    var time   = $('#slide').attr('tempo');
    var nome   = $('.ativo').attr('nome');
    var texto  = $('.ativo').attr('data-description');
	var qtde   = document.getElementById("slider_count").childNodes;
    $('#slide').prepend('<div id="div_titulo"><h1>' + nome + '</h1></div><p>' + texto + '</p>');
    intervalo = setInterval(vai, time);
    function vai() {
        if ($(".ativo").parent().next().size()) {
            $(".ativo").fadeOut().removeClass("ativo").parent().next().children(0).fadeIn().addClass("ativo");
        } else {
            $(".ativo").fadeOut().removeClass("ativo");
            $("#slide a:eq(0) img").fadeIn().addClass("ativo");
        }
		var nome = $('.ativo').attr('nome');
		var texto = $('.ativo').attr('data-description');
		$("#slide h1").hide().html(nome).delay(500).fadeIn();
		$("#slide p").hide().html(texto).delay(500).fadeIn();
    }
    function volta() { 
	 	if ($(".ativo").parent().prev().size()) {
            $(".ativo").fadeOut().removeClass("ativo").parent().prev().children(0).fadeIn().addClass("ativo");			
        } else {
            $(".ativo").fadeOut().removeClass("ativo");
            $("#slide a:eq(-1) img").fadeIn().addClass("ativo");
        }      		
		var nome = $('.ativo').attr('nome');
		var texto = $('.ativo').attr('data-description');
		$("#slide h1").hide().html(nome).delay(500).fadeIn();
		$("#slide p").hide().html(texto).delay(500).fadeIn();
    }
    $('#next').click(function () {
        clearInterval(intervalo);
        vai();
        intervalo = setInterval(vai, time);
    });
    $('#prev').click(function () {
        clearInterval(intervalo);
        volta();
        intervalo = setInterval(vai, time);
    });

});
//máscara de telefone (99) 99999-9999
$(document).ready(function() {
	$('body')
	.on('blur', '.telefone', function () {
		$(this).mask("(99) 9999-9999?9").ready(function(event) {
			var target, phone, element;
			target = (event.currentTarget) ? event.currentTarget : event.srcElement;
			phone = target.value.replace(/\D/g, '');
			element = $(target);
			element.unmask();
			if(phone.length > 10) {
				element.mask("(99) 99999-999?9");
			} else {
				element.mask("(99) 9999-9999?9");
			}
		});		
	});
//Checkbox Filho Especial
	$('body')
	.on('click', 'input[name="filho_especial"]', function () {		
			$("#field_filhos_especiais").toggle("slow");
			$("#field_filhos_especiais").prop('disabled',function(i, v) { return !v; });
	});
});
//Link da galeria
$(document).ready(function() {
$('body')
	.on('click', 'img[thumbimg]', function () {
		event.preventDefault();
		objeto = {};		
		objeto['indice'] = $(this).attr("data-description");
		objeto['image'] = $(this).attr('src');
		if ($(this).attr('flag') != "undefined") {
			objeto["flag"] = $(this).attr('flag');
			objeto["id"] = $(this).attr("id");			
		}
		$.ajax({
			url: "sys/galeria.sys.php",
			data: objeto,
			type: 'POST',			
			success: function(valor){
				$('.container').html(valor);
				//return false;
			}
		});
	});
});
//Funcionamento do PAV
$(document).ready(function(){
	$("body")
	.on('click', '.habilitar_PAV', function (event) {
		event.preventDefault();
		objeto = {};			
		objeto['id'] = $(this).attr('id');
		objeto['habilitado'] = $(this).attr('habilitado');
		objeto['id_pav'] = $(this).attr('id_pav');
		objeto['id_presente'] = $(this).attr('id_presente');
		objeto['data_envio'] = $(this).attr('data_envio');
		objeto['flag'] = $(this).attr('flag');
		$.ajax({
			url: "sys/pav.sys.php",
			data: objeto,
			type: "POST",
			success: function(retorno){
				$(".container").html(retorno);
			}
		});   	
	});
	$("body")
	.on('click', '#fechar_PAV', function(event){
		event.preventDefault();
		$("#pav").hide("slow");
	});
	$("body")
	.on('click', '#bot_salvar_email', function(event){
		event.preventDefault();
		if($('#email').val() != ''){
			var objeto = new FormData(document.querySelector("#pav_form_inscritos"));			
			objeto.append("flag", "inscrever");
			$.ajax({
				url: "sys/pav.sys.php",
				data: objeto,
				type: "POST",
				contentType: false,
				processData: false,
				success: function(retorno){
					$("#pav_msg").html(retorno);
					$("#pav").hide("slow");
				}
			});
		}else{
			$("#pav_msg").html("<div msg_dialog class='alerta' title='Clique para fechar.'>E-mail de contato não informado!</div>");
		}	
	});
});
$(document).ready(function(){
	$("body").on('click', '#tudo', function () {
		if($(this).is(":checked")){
			$(".all").prop("checked", true);
		}else{
			$(".all").prop("checked", false);
		}
	});
	$("body").on('click', '.botExportacao', function () {
		switch($(this).attr("id")){
			case "selectExpt":
				var objeto = new FormData(document.querySelector(".form_email"));
				objeto.append("flag", "exportar");
				$.ajax({
					url: "sys/pav.sys.php",
					data: objeto,
					type: "POST",
					contentType: false,
					processData: false,
					success: function(retorno){
						$(".conteudo").html(retorno);
					}
				});				
			break;
			case "indivExpt":
				var objeto = {flag: "exportarUm", id: $(this).attr("item")};
				$.ajax({
					url: "sys/pav.sys.php",
					data: objeto,
					type: "POST",
					success: function(retorno){
						$(".conteudo").html(retorno);
					}
				});
			break;	
		}
	});
});