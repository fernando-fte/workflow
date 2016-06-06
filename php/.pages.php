<?php
	# # # # # # # # # /  DEFINE PAGINAS DA APLICAÇÃO / # # # # # # # # #
	// Syntax = '@query' => array( '@group' => array( 1 => 2 ), '@double' => true '@next' => array( 'id', 'sku'))
	$settings['pages'] = array(

		// Aparametros padrão que todos os elemento herdarão
		'@default' => array(

			'@head' => array(
				'@meta' => array(
					'@config' => array(
						array('charset'=>'utf-8'),
						array('http-equiv'=>'X-UA-Compatible', 'content'=>'IE=edge'),
						array('name'=>'viewport', 'content'=>'width=device-width, initial-scale=1')
					),
					'description' => null,
					'keywords' => null,
					'author' => 'FTE Developer by VG Consultoria'
				),

				'@title' => 'Worklfow - home',

				'@style' => array(
					'bootstrap-css' => 'css',
					'fontawesome' => 'css',
					// 'style-less'  => 'less'
				),
			),

			'@body_end' => array(

				'@script' => array( 
					'jquery' => 'script',
					'bootstrap-js' => 'script',
					'coffee' => 'script',
					// 'less' => 'script',
					'app-coffee' => 'script-coffee'
				)
			),

			'@include' => array(
				$settings['dir']['app-basic'].'/menu.html'
			)
		),

		'home' => array(
			'@head' => array(
				'@title' => 'Bem vindo',
			),
			'@include' => array(
				$settings['dir']['app-header'].'/home.html',
			)
		),

		'teste' => array(
			'@head' => array(
				'@title' => 'Teste'
			),

			'@include' => array(
				$settings['dir']['app-teste'].'/index.html',
			)
		),

		'disciplina' => array(
			'@head' => array(
				'@title' => 'Disciplinas'
			),

			'@include' => array(
				$settings['dir']['app-header'].'/disciplinas.html',
				$settings['dir']['app-block'].'/disciplina.lista.html',
			),

			'novo' => array(
				'@head' => array(
					'@title' => 'Nova disciplina'
				),

				'@include' => array(
					$settings['dir']['app-header'].'/disciplinas.novo.html',
					$settings['dir']['app-block'].'/disciplina.painel.html',
				)
			),

			'editar' => array(
				'@head' => array(
					'@title' => 'Editar disciplina'
				),

				'@include' => array(
					$settings['dir']['app-header'].'/disciplinas.editar.html',
					$settings['dir']['app-block'].'/disciplina.painel.html',
				)
			)
		)
	)
	# # # # # # # # # /  DEFINE PAGINAS DA APLICAÇÃO / # # # # # # # # #
?>
