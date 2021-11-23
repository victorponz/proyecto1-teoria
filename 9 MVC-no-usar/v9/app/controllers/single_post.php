<?php
	session_start();
	$title = "Blog";
	require_once "./utils/utils.php";
	include("app/views/single_post.view.php");