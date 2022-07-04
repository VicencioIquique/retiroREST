<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$nroDsm = $_POST['nroDsm'];
	$consultaDSM ="SELECT * FROM [RP_VICENCIO].[dbo].[RP_DSM] where nrodsm ='".$nroDsm."'";
	$rsConsultaDSM = odbc_exec( $conn, $consultaDSM );
	if (!$rsConsultaDSM){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Bancos" );
	}	
	while($resultado = odbc_fetch_array($rsConsultaDSM)){
		$res[] = array(
			'Cantidad'=>$resultado['Cantidad'],
			'CodigoProducto'=>$resultado['CodigoProducto'],
			'DescripcionProducto'=>$resultado['DescripcionProducto'],
			'Estado'=>$resultado['Estado'],
		);
	}
	echo json_encode($res);
	
?>