<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<section id="find-me">
	  
	
</section>
<div>
<input class="rtrn-conteudo" type="button" value="Teste" objeto="form-send"/>
</div>
<!--------------------- Modal de Inserção de Logs -------------------->
<div id="modal-send" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<form id="form-send">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="modal-title" id="myModalLabel">Tem certeza que deseja fazer essa ação?</h3>
			</div>
			<div class="modal-footer">	
				<!------------------- Validadores --------------------->
				<section class="modal_input_hidden">
					<input type="hidden" name="flag" value="teste" />
					<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
					
				</section>
				<!------------------- Validadores --------------------->				
				<div class="row">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success waves-effect rtrn-conteudo" data-dismiss="modal" objeto="form-log">Salvar</button>		  
				</div>
			</div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal.dialog -->
	</form>
</div><!-- /#modal-log -->

<script type="text/javascript">
$(document).ready(function(){
$("body")
	.on("click", ".rtrn-conteudo", function (event){ 
		
		var objeto = new FormData(document.querySelector("#"+$(this).attr("objeto")));	
		
		$.ajax({
			url: objeto.get("caminho"), 
			data: objeto,
			type: 'post',
			processData: false,  
  			contentType: false,
			
			success: function(retornoDados){
				$('#modal-send').modal('toggle');	
				$("#find-me").html("<p>"+retornoDados+"</p>");
			}
		});
	});
});



</script>
</body>

