<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$nroDsm = $_POST['nroDsm'];
	$consultaDSM ="update [RP_VICENCIO].[dbo].[RP_DSM] set estado ='1' where nrodsm ='".$nroDsm."'";
	$rsConsultaDSM = odbc_exec( $conn, $consultaDSM );

	$sqlValidarTraspaso="INSERT INTO [RP_VICENCIO].[dbo].[RP_DEM]
	SELECT *FROM [RP_VICENCIO].[dbo].[RP_DSM]
	WHERE nrodsm ='".$nroDsm."'";
	$rsSqlValidarTraspaso = odbc_exec( $conn, $sqlValidarTraspaso );

	if (!$rsSqlValidarTraspaso){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}else{
		echo 1;
	}	
?>