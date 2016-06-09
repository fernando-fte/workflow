<?php

	# Oculta todos os erros do php
	error_reporting(0);

	# # # # # # # # # / CONFIGURA DADOS DE GET E POST / # # # # # # # # #
	// Move post e get para array separada
	$post = $_POST;
	$get = $_GET;


	# # # / VALIDA SE FOI RECEBIDO UM CONJUNTO DE QUERY / # # #
	if (parse_url($_SERVER['REQUEST_URI'])['query'] != false) {
		
		# # Explode as variaves
		$me = explode('&', parse_url($_SERVER['REQUEST_URI'])['query']);

		# # Reserva dados 
		$temp['query_decode']['get'] = array();

		# # # Seleciona cada argumento
		for ($i=0; $i < count($me); $i++) { 

			$temp['query_decode']['me'] = explode('=', $me[$i]);
			$temp['query_decode']['get'][$temp['query_decode']['me'][0]] = ($temp['query_decode']['me'][1] ? $temp['query_decode']['me'][1] : '');
		}
		unset($i);

		# # # Mescla os dados de @get
		$get = array_replace_recursive($temp['query_decode']['get'], $get);

		# # # Apaga dados usados
		unset($temp, $me);
	}
	# # # / VALIDA SE FOI RECEBIDO UM CONJUNTO DE QUERY / # # #


	# # # /CONFIGURA DADOS PADRAO PARA O BANCO DE DADOS / # # # #

	# # # # Configura seletores de acordo com a tabela
	$settings['banco']['table'] = array(
		'base' => array(
			0 => array('id', 'sku'),
			1 => array('values', 'data', 'contents'),
			2 => array('secao', 'conteudo'),
			3 => array('grupo', 'instituicao'),
			4 => array('classe', 'projeto'),
			5 => array('tipo', 'nome'),
			6 => array('item', 'ordem')
		)
	);

	# # # # Configura reserva de dados selecionados
	$settings['banco']['reserve'] = array();

	# # # Configura matriz para dormularios
	$settings['banco']['form'] = array(
		'form_1' => array(
			'label_1' => 'no1:/:no1.1',
			'label_2' => 'no1:/:no1.2',
		),
	);

	# # # /CONFIGURA DADOS PADRAO PARA O BANCO DE DADOS / # # # #


	// Config page default
	# if (array_key_exists('page', $get)) { $get['page'] = 'home'; }
	if (!array_key_exists('page', $get)) { $get['page'] = array('home'); }
	# # # # # # # # # / CONFIGURA DADOS DE GET E POST / # # # # # # # # #


	# # # / Inclui configuração de caminhos / # # #
	include '.paths.php';

	# # # / Inclui configuração de paginas / # # #
	include '.pages.php';

	# # # / Inclui conjuntos de função para configurações / # # #
	include '.functions.php';


	# # # # # / Configura nagevação / # # # # #
	$temp = parse_navgation()['done'];

	if ($temp['path'] != false) {
		$get['page'] = $temp['path'];
	}
	if ($temp['query'] != false) {
		$get = array_replace_recursive($temp['query'], $get);
	}
	unset($temp);
	# # # # # / Configura nagevação / # # # # #
?>
