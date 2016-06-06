<?php 
	# # Funcão para tratar os seletores
	function normalize_select($post, $method) {
		/*// Recebe
		 // $post => array => "Valores de seleção do banco para normalização"
		 // $metho => boolean => true "para limpar tudo" 
		//*/

		# # # DECLARA INSTANCIAS DO RESULTADO
		$result = array(
			'success' => true,
			'erro' => null,
			'this' => 'F::normalize_select',
			'done' => null,
			'process' => null,
		);
		# # # # # //

		# # Reserva os dados de post
		$result['done'] = $post;

		# # Seleciona cada item do post
		$me = array_keys($post);
		for ($i=0; $i < count($me); $i++) { 

			# # # Seleciona cada item da matriz
			for ($u=0; $u < count($GLOBALS['settings']['select_db_list']); $u++) { 

				# # # # Valida se o item existe na solicitação
				if (gettype(array_search($me[$i], $GLOBALS['settings']['select_db_list'][$u])) != 'boolean') {

					# # # # Remove valor de $result['done']
					unset($result['done'][$me[$i]]);

					# # # # Adiciona o valor de acordo com a matriz em U
					$result['done'][$u] = $post[$me[$i]];
				}

				# # # # Valida os dados caso o metodo seja limpar tudo
				else if ($method == true) {
					# # # # Remove valor de $result['done']
					unset($result['done'][$me[$i]]);					
				}
			}
			unset($u);
		}
		unset($i, $me);

		return $result;
	}

	# # # Função para criar sku unico
	function new_sku($post, $table){
		/*// Recebe
		 // $post => string => "Valor para transformar em md5"
		 // $table => string => "Nome da tabela"
		//*/

		# # # DECLARA INSTANCIAS DO RESULTADO
		$result = array(
			'success' => null,
			'erro' => null,
			'this' => 'F::new_sku',
			'done' => null,
			'process' => array (
				'cria sku' => true,
				'revalida' => array ('success' => null)
			),
		);
		# # # DECLARA INSTANCIAS DO RESULTADO

		# # # Reserva md5 do post com micro time
		$sku =  md5($post.microtime().date('d-m-o U'));
		$sku =  substr($sku, 0, 5).substr($sku, -5); // Seleciona o inicio e o fim

		# # # Seleciona banco para validar o sku
		$select = array(
			'type' => 'select',
			'table' => $table,
			'where' => array(
				0 => $sku
			),
			'regra' => array('limit' => 1),
			'return' => array('0')
		);

		# # # Valida se o sku existe
		if(select($select)['result']['length'] > 0){

			$sku = sku($sku)['done'];
		}

		# imprime sku
		$result['done'] = $sku;

		# apaga sku e select
		unset($sku, $select);

		return $result;
	}
?>
