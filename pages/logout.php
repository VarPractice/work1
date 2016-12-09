<?php
	require_once("includes/executers.php");
	session_unset();
	session_destroy();
	header("Location:".url);
?>