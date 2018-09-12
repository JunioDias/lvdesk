$total_de_mensagens = imap_num_msg($mail_box);
		echo "<h4>Total de Mensagens: ".$total_de_mensagens."</h4>";
		echo "
		<table class='table table-hover' id='tabela'>
		<thead>
			<tr class='filtro'>
				<th>Remetente<a><i class='mdi mdi-filter-variant icone-filtro'></i></a></th>
				<th>Data<a><i class='mdi mdi-filter-variant icone-filtro'></i></a></th>
				<th>Assunto<a><i class='mdi mdi-filter-variant icone-filtro'></i></a></th>
			</tr>
			<tr class='input-filtro' style='display:none;'>
				<th><input type='text' class='form-control' id='txtColuna1'/></th>
				<th><input type='text' class='form-control' id='txtColuna2'/></th>
				<th><input type='text' class='form-control' id='txtColuna3'/></th>
			</tr>
		</thead>
		<tbody>
		";
		if ($total_de_mensagens > 0) {
			for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {
				$header = imap_headerinfo($mail_box, $mensagem);
				var_dump($header);die();
				$oldString = $header->subject;
				$assunto = convert_encoding($oldString, 'UTF-8');			
				echo "
				<tr>
					<td rowspan='2'>".$header->senderaddress."</td>			
					<td rowspan='2'>".date('d-m-Y H:i:s', strtotime($header->date))." </td>
					<td rowspan='2' colspan='2'><a href='.'>".$assunto."</a></td>
				</tr>";
			}
			echo "</tbody></table>";
		}