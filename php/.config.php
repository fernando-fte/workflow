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


	# # # /CONFIGURA SELETORES PADRÃO PARA O BANCO DE DADOS / # # # #
	$settings['select_db_list'] = array(
		0 => array('id', 'sku'),
		1 => array('values', 'data', 'contents'),
		2 => array('secao'),
		3 => array('grupo'),
		4 => array('tipo'),
		5 => array('item'),
	);
	# # # /CONFIGURA SELETORES PADRÃO PARA O BANCO DE DADOS / # # # #


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
