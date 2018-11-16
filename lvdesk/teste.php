<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- somente para ficar mais "bonito o layout" vamos dar um padding-bottom no select -->
<style type="text/css">
.col-lg-12{
   padding-bottom: 20px;
  } 
</style>
</head>
<body>
<input id="qtd" type="hidden" value="15">
<div class="all" id="conteudo">
	<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/planos-crud.php">
	<table class="table table-hover" id="tabela">
	<thead>
	  <tr class="filtro">
		<th>Id <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
		<th>Título <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
		<th>Limite <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
		<th>Preço <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
		<th>Status <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
		<th>Ações</th>
	  </tr>
	  <tr class="input-filtro" style="display:none;">
		<th><input type="text" class="form-control" id="txtColuna1"/></th>
		<th><input type="text" class="form-control" id="txtColuna2"/></th>
		<th><input type="text" class="form-control" id="txtColuna3"/></th>
		<th><input type="text" class="form-control" id="txtColuna4"/></th>
		<th><input type="text" class="form-control" id="txtColuna5"/></th>
		<th></th>
	  </tr> 
	</thead>
	<tbody>
	<?php
	include("controllers/actions.inc.php"); 
	include("controllers/model.inc.php");
	
	$query 			= "SELECT * FROM planos WHERE lixo = 0 ORDER BY id DESC LIMIT 15";

	$nomediv		= ".content-sized";			#nome da div onde o callback vai ocorrer
	$tabela  		= "planos";					#tabela principal, alvo da rotina
	$cbkedit		= "views/planos-crud.php";	#callback do botão Editar
	$cbkdel 		= "views/planos.php";  		#callback do botão Excluir
	$link			= "controllers/sys/crud.sys.php";
	$i = 0;
	$botoes = new Acoes();
	$a = new Model();
	$result = $a->queryFree($query);
	if($result){
		while($linhas = $result->fetch_assoc()){
			echo("
			<tr>
			<td>".$linhas['id']."</td>
			<td>".$linhas['nome']."</td>
			<td>".$linhas['limite']."</td>
			<td>".$a->moneyFormatReal($linhas['valor_unit'])."</td>
			<td>".($linhas['ativo'] == 1 ? '<span style=color:red;>Inativo</span>' : '<span style=color:green;>Ativo</span>')."</td>
			<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("<input type='hidden' id='plano_verifica' value='1' ></td>
			</tr>
			");	
			$i++;
		}
	}
	else{
		echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";	
	}
	?>	
	</tbody>
	</table>
</div>
<div id="pagi"></div> <!--div responsável por mostrar a paginação-->
</body>
</html>
<script type="text/javascript">
//acionamos o jquery para iniciar a paginação quando o documento estiver "pronto"
$(document).ready(function() {
	
	var mostrar_por_pagina = $('#qtd').val(); //Pegamos o valor selecionado default no select id="qtd"
	var numero_de_itens = $('#conteudo').children('.col-lg-3').size();//quantidade de divs
	var numero_de_paginas = Math.ceil(numero_de_itens / mostrar_por_pagina);//fazemos uma calculo simples para saber quantas paginas existiram
	$('#pagi').append('<div class=controls></div><input id=current_page type=hidden><input id=mostrar_por_pagina type=hidden>'); //Colocamos a div class controls dentro da div id pagi
	
	$('#current_page').val(0);
	$('#mostrar_por_pagina').val(mostrar_por_pagina);
	
	var nevagacao = '<li><a class="prev" onclick="anterior()">Anterior</a></li>';//Criamos os links de navegação
	var link_atual = 0;
	while (numero_de_paginas > link_atual) {
	  nevagacao += '<li><a class="page" onclick="ir_para_pagina(' + link_atual + ')" longdesc="' + link_atual + '">' + (link_atual + 1) + '</a></li>';
	  link_atual++;
	}
	nevagacao += '<li><a class="proxima" onclick="proxima()">Próxima</a></li>';
	//colocamos a nevegação dentro da div class controls
	$('.controls').html("<div class='paginacao'><ul class='pagination pagination-sm'>"+nevagacao+"</ul></div>");
	//atribuimos ao primeiro link a class active
	$('.controls .page:first').addClass('active');
	$('#conteudo').children().css('display', 'none');
	$('#conteudo').children().slice(0, mostrar_por_pagina).css('display', 'block');
});


function ir_para_pagina(numero_da_pagina) {
      //Pegamos o número de itens definidos que seria exibido por página
      var mostrar_por_pagina = parseInt($('#mostrar_por_pagina').val(), 0);
      //pegamos  o número de elementos por onde começar a fatia
      inicia = numero_da_pagina * mostrar_por_pagina;
     //o número do elemento onde terminar a fatia
      end_on = inicia + mostrar_por_pagina;
     $('#conteudo').children().css('display', 'none').slice(inicia, end_on).css('display', 'block');
     $('.page[longdesc=' + numero_da_pagina+ ']').addClass('active')
       .siblings('.active').removeClass('active');
    $('#current_page').val(numero_da_pagina);
  }

 function anterior() {
     nova_pagina = parseInt($('#current_page').val(), 0) - 1;
      //se houver um item antes do link ativo atual executar a função
      if ($('.active').prev('.page').length == true) {
          ir_para_pagina(nova_pagina);
      }
  }

function proxima() {
      nova_pagina = parseInt($('#current_page').val(), 0) + 1;
      //se houver um item após o link ativo atual executar a função
      if ($('.active').next('.page').length == true) {
          ir_para_pagina(nova_pagina);
      }
  }

  
// Pegamos o evento change do select id="qtd" e remontamos toda a paginação default
  $( "#qtd" ).change(function() {
    //Removemos os "controles" de paginação
      $(".controls").remove();
    //Pegamos o valor selecionado
      var mostrar_por_pagina = this.value;
     //remontamos a paginação
      var numero_de_itens = $('#conteudo').children('.col-lg-3').size();
      var numero_de_paginas = Math.ceil(numero_de_itens / mostrar_por_pagina);
      //Colocamos a div class controls dentro da div id pagi
    $('#pagi').append('<div class=controls></div><input id=current_page type=hidden><input id=mostrar_por_pagina type=hidden>');
      $('#current_page').val(0);
      $('#mostrar_por_pagina').val(mostrar_por_pagina);
  //Criamos os links de navegação
      var nevagacao = '<li><a class="prev" onclick="previous()">Prev</a></li>';
      var link_atual = 0;
      while (numero_de_paginas > link_atual) {
          nevagacao += '<li><a class="page" onclick="ir_para_pagina(' + link_atual + ')" longdesc="' 
          + link_atual + '">' + (link_atual + 1) + '</a></li>';
          link_atual++;
      }
      nevagacao += '<li><a class="next" onclick="next()">Next</a></li>';
   //colocamos a navegação dentro da div class controls
      $('.controls').html("<div class='paginacao'><ul class='pagination pagination-sm'>"+nevagacao+"</ul></div>");
      $('.controls .page:first').addClass('active');
      $('#conteudo').children().css('display', 'none');
      $('#conteudo').children().slice(0, mostrar_por_pagina).css('display', 'block');
    
  });
</script>
