<?php
$temp['values'] = array(
	'disciplina' => $temp['disciplina'][1],
	'id' => 'SKU',
	'._.settings' => array(
		2 => $temp['conteudo'],
		3 => $temp['instituicao'],
		4 => $temp['projeto'],
		5 => $temp['nome'],
		6 => $temp['item']
	)
);


# # # Função para criar novo seletor
function create_selects($post, $func) {
	// $post = Recebe conjunto de valores

	# # # DECLARA INSTANCIAS DO RESULTADO
	$result = array(
		'success' => null,
		'erro' => null,
		'this' => 'F::create_selects',
		'done' => null,
		'process' => array (
			'novo' => true,
		),
	);

	# # Seletor simples
	$reserve['select'] = array('type' => 'select','table' => null,'where' => array(0 => null),'regra' => array('limit' => 1),'return' => array('1'));

	# # # Confere se existe tabela
	if (array_key_exists('table', $post)) {$table = $post['table'];}
	# # # Define a tabela como base
	else {$table = 'base';}

	# # # # 

	$me = normalize_select($post, $table, true)['done'];

	# # # Remove dados dos seletores
	if (array_key_exists(1, $me)) { unset($me[1]);}


	# # # Valida se existe sku
	if (array_key_exists(0, $me)) { 

		# # # # Valida se existe esse id
		$reserve['select']['where'] = array(0 => $me[0]);
		$reserve['select']['table'] = $table;

		$reserve['result'] = select($reserve['select'])['result'];

		if ($reserve['result']['lenght'] > 0) {
			
			# # # Define novo como falso
			$result['process']['novo'] = false;

			# TODO: Reserva os dados em "$GLOBALS['settings']['banco']['reserve']"

			# TODO: Cria função para tratar caso exista
		}

		# apaga result
		unset($reserve['result']);
	}

	# # # Inicia tratamento de um novo item no banco
	if ($result['process']['novo'] == true) {

		# # define sku em 0 caso ele nao tenha sido criado
		if (!array_key_exists(0, $me)) {  $me[0] = new_sku($me)['done']; }

		# # # Define tabela
		$result['done']['._.selectors']['table'] = $table;

		# # $result['done']['._.selects'] = $me;
		$temp = array_keys($GLOBALS['settings']['banco']['table'][$table]);
		for ($i=0; $i < count($temp); $i++) { 

			# # #  Caso o seletor seja diferente de ID e Values em 0 e 1
			if ($temp[$i] != 1) {

				# # # Valida se não foi declarado o seletor, define como null
				if (!array_key_exists($i, $me)) { $me[$i] = ($i == (count($temp) - 1)? 0:'@null'); }

				# # # # Reserva os dado em done
				$result['done']['._.selectors'][$i] = $me[$i];
			}
		}
		unset($i, $temp);
	}

	# # # Retorna
	return $result;
}

# # # Função para criar settings e iniciar o seletor
function create_settings($post, $func){

	# # # DECLARA INSTANCIAS DO RESULTADO
	$result = array(
		'success' => null,
		'erro' => null,
		'this' => 'F::create_settings',
		'done' => null,
		'process' => array (
			'novo' => true,
		),
	);

	# # # Adiciona os seletores
	$result['done']['._.settings'] = create_selects($post)['done'];

	# # # Verifica se o valor foi encontrado no banco e foi reservado // Depende de create_selects($post)
	if (array_key_exists($result['done']['._.settings']['._.selectors'][0], $GLOBALS['settings']['banco']['reserve'])) {

		# # # # Define novo como falso
		$result['process']['novo'] = false;
		$result['done']['._.settings']['._.history']['modify'][date('Y-m-d H:i:s ').microtime()] = '#idhistory';
	}

	# # # Inicia tratamento caso seja novo
	if ($result['process']['novo'] == true) {

		# # # # Separa data do histórico
		$result['done']['._.settings']['._.history']['create'] = date('Y-m-d H:i:s ').microtime();
	}

	# # # Retorna
	return $result;
}

# # # Função para criar valores
function trata_form($form, $input, $func) {
	// $form = string // Recebe o nome do formulario
	// $input = array // Uma lista com o campo e o valor
	// $func = ? // Recebe as diretrizes para uma sub solicitação

	# # # DECLARA INSTANCIAS DO RESULTADO
	$result = array(
		'success' => null,
		'erro' => null,
		'this' => 'F::monta_data',
		'done' => array(),
		'process' => array (
			'iniciar' => array(
				'success' =>true
			),
		),
	);


	# # VALIDA SE É UMA SUB SOLICITAÇÃO # #
	if ($func != false) {
		$result['this'] = 'me';
	}
	# # VALIDA SE É UMA SUB SOLICITAÇÃO # #

	# # SELECIONA CADA INPUT # #
	foreach ($input as $key => $value) {

		if ($result['this'] == 'me') {
			$reserve['matriz'] = $func;
		}

		if ($result['this'] != 'me') {
			$reserve['matriz'] = explode(':/:', $GLOBALS['settings']['banco']['form'][$form][$key]);
		}

		# Reserva nome do array
		$me = $reserve['matriz'][0];

		# # # SELECIONA CADA ITEM DA LISTA # # #
		if (count($reserve['matriz']) > 1) {

			# Remove o nivel atual da matriz
			unset($reserve['matriz'][0]);

			# Re inicia indice
			$reserve['matriz'] = array_values($reserve['matriz']);

			# Retorna para done a função
			$reserve['done'][$me] = trata_form($form, array($key=>$value), $reserve['matriz'])['done'];
		}

		# # # Caso seja o ultimo nivel
		else if (count($reserve['matriz']) == 1) {

			# Aloca o valor no final do  ultimo item
			$reserve['done'][$me] = $value;
		}
		# # # SELECIONA CADA ITEM DA LISTA # # #

		# # # FINALIZA PROCESSAMENTO # # #
		if ($result['this'] == 'me') {
			$result['done'][$me] = $reserve['done'][$me];
		}

		if ($result['this'] != 'me') {

			// $result['done'][] = $reserve['done'];
			$result['done'] = array_replace_recursive($reserve['done'], $result['done']);
		}
		# # # FINALIZA PROCESSAMENTO # # #
	}
	# # SELECIONA CADA INPUT # #

	# # # Retorna
	return $result;
}

// print_r(trata_form('form_1', array('label_1' => 'Fernando', 'label_2' => 'Evangelista'))['done']);

?>
