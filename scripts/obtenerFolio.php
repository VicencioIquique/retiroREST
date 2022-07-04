<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$ip = $_POST['ip'];
	
	$consultarFolio="SELECT ultNotaCredito FROM RP_VICENCIO.dbo.RP_IP_BODEGAS
					WHERE ip = '".$ip ."'"; // consulta sql
	$rsFolio = odbc_exec( $conn, $consultarFolio );
	if (!$rsFolio){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}	
	$resultado = odbc_fetch_array($rsFolio);
		echo (int)$resultado['ultNotaCredito'];

?>