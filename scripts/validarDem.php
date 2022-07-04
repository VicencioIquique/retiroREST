<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$nroDem = $_POST['nroDem'];
	$consultaDEM ="update [RP_VICENCIO].[dbo].[RP_DEM] set estado ='1' where nrodem ='".$nroDem."'";
	$rsConsultaDEM = odbc_exec( $conn, $consultaDEM );
	if (!$rsConsultaDEM){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Bancos" );
	}else{
		echo 1;
	}	
?>