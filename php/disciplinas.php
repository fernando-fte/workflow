<?php
/*
	{
		00 = $md5() //sku
		01 = {} // dados
		02 = disciplina // conteudo
		03 = unipar // instituicao
		04 = livro-digital-pos // projeto
		05 = Nome do livro // nome
		06 = ordem // item
	}

	'dados': {
		'disciplina':$nome-da-disciplina,
		'id':'',
		'caminho':$path>,
		'._.settings':{
			'._.selects':{
				
			}
		}
	}
*/
$temp['base'] = array(
	'conteudo' => 'disciplina',
	'instituicao' => 'unipar',
	'projeto' => 'livro-digital-pos',
	'nome' => 'Nome',
	'item' => 0,
);

$temp['disciplina'] = array (
	'Neuropedagogia e os Fundamentos para a Leitura e Escrita',
	'Metodologia do Ensino Superior',
	'Necessidades educacionais específicas e o trabalho pedagógico em AEE',
	'Fundamentos e Histórico da EAD',
	'Currículo, Organização e Avaliação do Trabalho Pedagógico',
	'História, Estética e o Ensino da Arte',
	'Tópicos de conteúdos da matemática',
	'Componentes gerenciais, financeiros e RH na gestão escolar',
	'Fisiopatologia em Oncologia',
	'Fisiopatologia da obesidade',
	'Nutrição Funcional e Estética no Exercício',
	'Políticas de Saúde para Atenção Integral aos Usuários de Álcool e outras Drogas',
	'Políticas Públicas de Saúde Mental',
	'Noções em geriatria e gerontologia',
	'Prescrição do exercício aeróbio e anaeróbio',
	'Educação Ambiental para Sustentabilidade ',
	'Perícia Florestal',
	'Gestão Ambiental',
	'Legislação Trabalhista',
	'Diagnóstico Empresarial',
	'Gestão de Negócios Agroindustriais',
	'Liderança e Motivação',
	'Técnicas em Pesquisa e Mercado',
	'Modelo de Negócio do Varejo e do Franchising',
	'Logística Empresarial'
);

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


// print_r($temp['dados']);
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
function create_disciplina($post, $func) {
	# # # DECLARA INSTANCIAS DO RESULTADO
	$result = array(
		'success' => null,
		'erro' => null,
		'this' => 'F::create_disciplina',
		'done' => null,
		'process' => array (
			'novo' => true,
		),
	);


	// # # # Define modelo basico
	// $reserve = array(
	// 	'disciplina' => $post['']
	// ),

	# # # Monta dados dos da disciplina
	print_r($post);

	# # # Retorna
	return $result;
}


for ($i=0; $i < count($temp['disciplina']); $i++) { 
	# Itens basicos
	$temp['base'] = array(
		'conteudo' => 'disciplina',
		'instituicao' => 'unipar',
		'projeto' => 'livro-digital-pos',
		'disciplina' => $temp['disciplina'][$i],
		'item' => 0,
	);
	print_r($temp['base']);
}

// create_settings($temp);
// print_r(json_encode(create_settings($temp)['done']));
// print_r(create_settings($temp)['done']);

?>
