<?php
    session_start();
	$title = "Home";
	require_once "./database/Connection.php";
	require_once "./entity/Asociado.php";
	require_once "./entity/ImagenGaleria.php";
	require_once "./repository/AsociadoRepository.php";
	require_once "./repository/ImagenGaleriaRepository.php";
	require_once "./utils/utils.php";


	$config = require_once 'app/config.php';
	App::bind('config', $config);
	App::bind('connection', Connection::make($config['database']));

	$repositorio = new ImagenGaleriaRepository();
	$galeria = $repositorio->findAll();

	$repositorioAsociados = new AsociadoRepository();
	$asociados = $repositorioAsociados->findAll();

	$asociados = getAsociados($asociados);

	include("app/views/index.view.php");
