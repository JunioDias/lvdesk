if(isset($dados['grupo_responsavel'])){
	foreach($dados['grupo_responsavel'] as $id_atendente_responsavel){
		$query_comunica = "INSERT INTO comunicacao_interna_movimentos (protocol, descricao, id_autor, id_destinatario, nome_provedor, data, id_contratos, atendente_responsavel) VALUES('".$dados['protocol']."', '".$dados['historico']."', '".$dados['autor']."', '".$value_id_contato."', '".$dados['nome_provedor']."', '".$dados['data_abertura']."', '".$dados['id_contratos']."', '".$id_atendente_responsavel."')";
		$a->queryFree($query_comunica);
	}
}else{


array(4) { 
	["status"]=> string(7) "success" 
	["msg"]=> string(29) "Dados consultados com sucesso" 
	["clientes"]=> array(1) { 
		[0]=> array(16) { 
			["id_cliente"]=> int(1239) 
			["codigo_cliente"]=> int(73) 
			["nome_razaosocial"]=> string(26) "ANA CRISTINA WERNECK LEITE" 
			["nome_fantasia"]=> NULL 
			["tipo_pessoa"]=> string(2) "pf" 
			["cpf_cnpj"]=> string(11) "04632505676" 
			["telefone_primario"]=> string(11) "37999790704" 
			["telefone_secundario"]=> string(11) "37999790704" 
			["telefone_terciario"]=> string(0) "" 
			["rg"]=> string(7) "8995291" 
			["rg_emissao"]=> NULL 
			["inscricao_municipal"]=> NULL 
			["inscricao_estadual"]=> NULL 
			["data_cadastro"]=> string(19) "2015-12-22 00:00:00" 
			["data_nascmento"]=> string(19) "1969-12-31 00:00:00" 
			["servicos"]=> array(1) { 
				[0]=> array(16) { 
					["id_cliente_servico"]=> int(1274) 
					["numero_plano"]=> int(1) 
					["nome"]=> string(9) "Radio_2MB" 
					["valor"]=> float(71.5) 
					["status"]=> string(19) "Serviço Habilitado" 
					["status_prefixo"]=> string(18) "servico_habilitado" 
					["login"]=> string(15) "anacristina0463" 
					["senha"]=> string(6) "123456" 
					["ipv4"]=> string(10) "10.99.0.38" 
					["ipv6"]=> NULL 
					["interface"]=> array(3) { 
						["nome"]=> string(21) "PAINEL INTELBRAS 5.8" 
						["tipo"]=> string(8) "ethernet" 
						["called_sid"]=> NULL 
					} 
					["equipamento_conexao"]=> array(3) { 
						["nome"]=> string(17) "NXT | VILA ROMANA" 
						["ipv4"]=> string(13) "172.17.22.188" 
						["ipv6"]=> NULL 
					} 
					["endereco_fiscal"]=> array(10) { 
						["completo"]=> string(69) "RUA CARAGUATATUBA, 251 - JARDIM DAS OLIVEIRAS, DIVINÓPOLIS/MG - CASA" ["logradouro"]=> string(3) "RUA" ["endereco"]=> string(13) "CARAGUATATUBA" ["numero"]=> string(3) "251" ["complemento"]=> string(4) "CASA" ["bairro"]=> string(20) "JARDIM DAS OLIVEIRAS" ["cep"]=> string(9) "35502-110" ["estado"]=> string(2) "MG" ["uf"]=> string(12) "MINAS GERAIS" ["cidade"]=> string(12) "DIVINÓPOLIS" 
					} 
					["endereco_cobranca"]=> array(10) { 
						["completo"]=> string(69) "RUA CARAGUATATUBA, 251 - JARDIM DAS OLIVEIRAS, DIVINÓPOLIS/MG - CASA" ["logradouro"]=> string(3) "RUA" ["endereco"]=> string(13) "CARAGUATATUBA" ["numero"]=> string(3) "251" ["complemento"]=> string(4) "CASA" ["bairro"]=> string(20) "JARDIM DAS OLIVEIRAS" ["cep"]=> string(9) "35502-110" ["estado"]=> string(2) "MG" ["uf"]=> string(12) "MINAS GERAIS" ["cidade"]=> string(12) "DIVINÓPOLIS" 
					} 
					["endereco_cadastral"]=> array(10) { 
						["completo"]=> string(69) "RUA CARAGUATATUBA, 251 - JARDIM DAS OLIVEIRAS, DIVINÓPOLIS/MG - CASA" ["logradouro"]=> string(3) "RUA" ["endereco"]=> string(13) "CARAGUATATUBA" ["numero"]=> string(3) "251" ["complemento"]=> string(4) "CASA" ["bairro"]=> string(20) "JARDIM DAS OLIVEIRAS" ["cep"]=> string(9) "35502-110" ["estado"]=> string(2) "MG" ["uf"]=> string(12) "MINAS GERAIS" ["cidade"]=> string(12) "DIVINÓPOLIS" 
					} 
					["endereco_instalacao"]=> array(10) { 
						["completo"]=> string(69) "RUA CARAGUATATUBA, 251 - JARDIM DAS OLIVEIRAS, DIVINÓPOLIS/MG - CASA" ["logradouro"]=> string(3) "RUA" ["endereco"]=> string(13) "CARAGUATATUBA" ["numero"]=> string(3) "251" ["complemento"]=> string(4) "CASA" ["bairro"]=> string(20) "JARDIM DAS OLIVEIRAS" ["cep"]=> string(9) "35502-110" ["estado"]=> string(2) "MG" ["uf"]=> string(12) "MINAS GERAIS" ["cidade"]=> string(12) "DIVINÓPOLIS" 
					} 
				} 
			}
		} 
	} 
	["id"]=> string(1) "2" 
} 

*222