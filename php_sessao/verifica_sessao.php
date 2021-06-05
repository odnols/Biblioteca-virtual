<?php

if(!isset($_SESSION))
	session_start();

if(!isset($_SESSION["logado"]))
	header("Location: C:\wamp64\www\Conquistas\Sistema\index.php");