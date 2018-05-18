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

//Comportamento dos links do menu do painel administrativo
$(document).ready(function(){
	$("body")
	.on('click', '.menu-control', function () {
		$(".conteudo").load($(this).attr("link"));		
	});
//Comportamento dos links do front
	$("body")
	.on('click', '.menu-nav, .regular-link, .btn', function(){
   		$(".container-fluid").load($(this).attr("link"));
	});

});