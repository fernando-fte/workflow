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
$temp = array(
	'conteudo' => 'disciplina',
	'instituicao' => 'unipar',
	'projeto' => 'livro-digital-pos',
	'nome' => 'Nome',
	'item' => 0,
	'id' => '00000000'
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
				'path no post' => array ('success' => null)
			),
		);


		# # Seletor simples
		$reserve['select'] = array('type' => 'select','table' => null,'where' => array(0 => null),'regra' => array('limit' => 1),'return' => array('1'));

		$me = normalize_select($post, true)['done'];

		# # # Remove dados dos seletores
		if (array_key_exists(1, $me)) { unset($me[1]);}

		# # # Confere se existe tabela
		if (array_key_exists('table', $post)) {$me['table'] = $post['table'];}
		# # # Define a tabela como base
		else {$me['table'] = 'base';}

		# # # Valida se existe sku
		if (array_key_exists(0, $me)) { 

			# # # # Valida se existe esse id
			$reserve['select']['where'] = array(0 => $me[0]);
			$reserve['select']['table'] = $me['table'];

			$reserve['result'] = select($reserve['select'])['result'];

			if ($reserve['result']['lenght'] > 0) {
				
				# # # Define novo como falso
				$result['process']['novo'] = false;

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
			$result['done']['._.selectors']['table'] = $me['table'];

			# # $result['done']['._.selects'] = $me;
			$temp = array_keys($GLOBALS['settings']['select_db_list']);
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



?>
