function filterEmailtoCGR($flag){
		if($flag != false){
			$query_grupos_por_contato_agenda = "SELECT contatos AS emails FROM agenda_contatos WHERE lixo = 0";
			$foo = $this->queryFree($query_grupos_por_contato_agenda);
			if($foo){
				while($grupos = $foo->fetch_assoc()){
					$query_testa_contatos = "
					SELECT emails.*, clientes.id AS ClienteID FROM emails 
					INNER JOIN clientes 
					INNER JOIN agenda_contatos 
					INNER JOIN emails_fromaddress 
					ON agenda_contatos.contatos = emails_fromaddress.mailcompleto AND clientes.id = agenda_contatos.id_cliente 
					WHERE emails.fromaddress LIKE '%".$grupos['emails']."%' GROUP BY emails.id";
					$woo = $this->queryFree($query_testa_contatos);
					$teste = $woo->fetch_assoc();
					if($teste['id'] != ''){ # Nenhuma relação encontrada. E-mail não possui contatos na agenda (?)
						if($teste['ClienteID'] != ''){
							$this->movingEmailToCGR($teste, $teste['ClienteID']);
						}else{
							$this->movingEmailToCGR($teste);
						}
					}
				}
			}
		}
	}