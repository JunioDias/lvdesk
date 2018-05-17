// JavaScript Document
$(document).ready(function(){
	$("body")
	.on('change', '#confirmasenha, #senha', function () {
		var a = $("#senha").val();
		var b = $('#confirmasenha').val();
		if(a!=""){
			if(a == b){				
				$('#confirmasenha, #senha').attr("flag", "1");				
			}else{				
				$('#confirmasenha, #senha').attr("flag", "0");	
			}			
		}else{
			$(".cnfsenha").attr("style",'');
			$(this).attr("flag", "0");
		}
	});
	$("body")
	.on('blur', '#confirmasenha, #senha', function () {
		var e = $("#confirmasenha").val();
		var f = $('#senha').val();
		if(f!=""){
			if(e == f){				
				$('#confirmasenha, #senha').attr("flag", "1");				
			}else{				
				$('#confirmasenha, #senha').attr("flag", "0");	
			}			
		}else{
			$(".cnfsenha").attr("style",'');
			$(this).attr("flag", "0");
			$("#confirmasenha").attr("flag", "0");
		}
	});
	$("body")
	.on('blur', '.frmPerfil input[type="password"]', function(){
		var inputs = new Array();		
		$('.frmPerfil input[flag]').each(function(){
			inputs.push($(this).attr("flag"));
		});	
		
		if(inputs[0]==1 && inputs[1]==1 ){
			$(".cnfsenha").attr("style","background-image:url('media/imagens/sys/icons/confsenha_ok.png');");
			$("#redefinir").show("slow");
		}else{
			$(".cnfsenha").attr("style","background-image:url('media/imagens/sys/icons/confsenha_falha.png')");
			$("#redefinir").hide("slow");
		}
	});
	//Envio de dados com formData no front 
	$("body")
	.on('click', '.redefinir', function (event) {
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
				$('.containtexto').html(valor);
				//return false;
			}
		});
	});	
});