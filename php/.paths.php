<?php 
	# # # # # # # # # / CONFIGURA PATH DE TODOS OS ELEMENTOS / # # # # # # # # #
	# # # Configura localhost
	$settings['wwwproj'] = '/workflow'; // pasta atual do projeto
	$settings['wwwroot'] = 'http://'.$_SERVER['SERVER_NAME'].$settings['wwwproj']; // Configura seleção do servidor mais pasta local


	# # # Configura path de diretórios

	# diretorio de vendors
	$settings['dir']['vendor'] = $settings['wwwroot'].'/vendor'; // Configura seleção do servidor mais pasta local
	$settings['dir']['vendor-scripts'] = $settings['dir']['vendor'].'/scripts'; // Configura local dos frameworks scripts
	$settings['dir']['vendor-bootstrap'] = $settings['dir']['vendor'].'/bootstrap'; // Configura local dos frameworks scripts
	$settings['dir']['vendor-fontawesome'] = $settings['dir']['vendor'].'/FontAwesome'; // Configura local dos frameworks scripts

	# diretorio de settings
	$settings['dir']['php'] = $settings['wwwroot'].'/php'; // Local base de todos os dados

	# Diretorio de testes
	$settings['dir']['php'] = $settings['dir']['php'].'/teste'; // Local base de todos os dados

	# diretorio de aplicações e estilos
	$settings['dir']['app-style'] = $settings['wwwroot'].'/style'; // Configura seleção do servidor mais pasta local
	$settings['dir']['app-script'] = $settings['wwwroot'].'/script'; // Configura seleção do servidor mais pasta local

	# Diretorios de paginas
	$settings['dir']['contents'] = $settings['wwwroot'].'/contents'; // Local base de todos os dados
	$settings['dir']['app'] = $settings['dir']['contents'].'/app'; // Conjunto de  formuláros
	$settings['dir']['app-header'] = $settings['dir']['app'].'/headers'; // Paginas principais
	$settings['dir']['app-block'] = $settings['dir']['app'].'/blocks'; // Blocos de paginas
	$settings['dir']['app-basic'] = $settings['dir']['app'].'/basic'; // Elementos comuns
	$settings['dir']['app-user'] = $settings['dir']['app'].'/user'; // Elementos de usuarios
	$settings['dir']['teste'] = $settings['dir']['contents'].'/teste'; // Elementos teste


	# biblioteca de arquivos
	$settings['dir']['library'] = $settings['wwwroot'].'/library'; // Local base de todos os dados


	# # # Configura path arquivos e framework
	$settings['file'] = array(
		# VENDORS
		# # scripts
		'jquery' => $settings['dir']['vendor-scripts'].'/jquery.min.js',
		'coffee' => $settings['dir']['vendor-scripts'].'/coffee-script.js',
		'less' => $settings['dir']['vendor-scripts'].'/less.min.js',
		'bootstrap-js' => $settings['dir']['vendor-bootstrap'].'/bootstrap.min.js',

		# # scripts
		'bootstrap-css' => $settings['dir']['vendor-bootstrap'].'/bootstrap.min.css',
		'fontawesome' => $settings['dir']['vendor-fontawesome'].'/font-awesome.min.css',
		# # # # # #

		# APLICAÇÕES
		# # aplicativo default
		'style-css' => $settings['dir']['app-style'].'/app.css',
		'style-less' => $settings['dir']['app-style'].'/app.less',

		'app-js' => $settings['dir']['app-script'].'/app.js',
		'app-coffee' => $settings['dir']['app-script'].'/app.coffee',
		# # # #
	);
	# # # # # # # # # / CONFIGURA PATH DE TODOS OS ELEMENTOS / # # # # # # # # #
?>
