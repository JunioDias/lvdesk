<section class="new_content" style="padding: 5px 10px;">
<section class="titulo">
<h4>Cadastro de Perfil</h4>
<p>Gerenciador de perfis contratuais</p><br>
</section>
<section id="find-me">
	  
	<table class="table table-hover">
		<thead>
		  <tr>
			<th>Data</th>
			<th>Protocolo</th>
			<th>Nome do Cliente</th>        
			<th>Entidade</th>
			<th>Telefone</th>
			<th>Ações</th>
		  </tr>
		</thead>
		<tbody id="table_servicos_cgr">
			<tr><form id="x1">
				<td><input type="hidden" name="data" value="10/07/2018"/>10/07/2018</td>
				<td><input type="hidden" name="protocolo" value="20180710080357"/>20180710080357</td>
				<td><input type="hidden" name="nome" value="JOAO APARECIDO DOS SANTOS">JOAO APARECIDO DOS SANTOS</td>
				<td><input type="hidden" name="entidade" value="HubSoft"/>HubSoft</td>
				<td><input type="hidden" name="telefone" value="37988546861"/>37988546861</td>
				<td>			
				<input objeto="x1" class="btn btn-success btn_driver content_trigger_post" value="Dar entrada" type="button" >	
				</td>
			</form></tr>
			<tr><form id="x2">
				<td><input type="hidden" name="data" value="10/07/2018"/>10/07/2018</td>
				<td><input type="hidden" name="protocolo" value="20180710080357"/>20180710080357</td>
				<td><input type="hidden" name="nome" value="MARCELO DE OLIVEIRA"/>MARCELO DE OLIVEIRA</td>
				<td><input type="hidden" name="entidade" value="HubSoft"/>HubSoft</td>
				<td>
					<input type="checkbox" name="sexo" value="M"/>Masculino<br>
					<input type="checkbox" name="sexo" value="F"/>Feminino
				</td>
				<td>			
				<input objeto="x2" data-toggle='modal' data-target='#modal-send' input_hidden=".modal_input_hidden" class="btn btn-success btn_driver content_trigger_post" value="Dar entrada" type="button" >	
				</td>
			</form></tr>
		</tbody>
	</table>
</section>

<!--------------------- Modal de Inserção de Logs -------------------->
<div id="modal-send" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<form id="form-send">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Tem certeza que deseja fazer essa ação?</h4>
			</div>
			<div class="modal-footer">	
				<!------------------- Validadores --------------------->
				<section id="modal_input_hidden">
					<input type="hidden" name="flag" value="addLog" />
					<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
					<input type="hidden" name="retorno" value=".section_historico" />
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
</section> <!-- New_Content -->
<script type="text/javascript">
$(document).ready(function(){
$("body")
	.on('click', '.content_trigger_post', function(){
		var y = $(this).attr("input_hidden");
		var input_hidden = document.getElementById(y);
		var x = $(this).attr("objeto");		
		var z = document.getElementById(x);
		objeto = new FormData(z);
		for(var pair of objeto.entries()) {
			$(input_hidden).append("<input type='hidden' name='"+pair[0]+"' value='"+ pair[1]+"' />"); 
		}
		
		
		/* $.ajax({
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
					alert('Falha no feedback dos dados!')
				}								
			}
		}); */
		
	});
});
</script>