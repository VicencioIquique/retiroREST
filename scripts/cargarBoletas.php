<?php 
set_time_limit(60);
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	$numeroDocto = $_POST['numeroDocto'];
	$fecha = $_POST['fecha'];
	if($numeroDocto != ''){
		$consultaBoletas ="  select TipoDocto,NumeroDocto,FechaDocto,Total  FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP]
							 where Bodega ='".$bodega."' 
							 and Workstation ='".$workstation."'
							 and TipoDocto ='1' 
							 and numeroDocto ='".$numeroDocto."'
							 order by convert(int,NumeroDocto) desc";
	}else{
		$consultaBoletas ="select TipoDocto,NumeroDocto,FechaDocto,Total  FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP]
							 where Bodega ='".$bodega."'
							 and Workstation ='".$workstation."'
							 and TipoDocto ='1' 
							 and FechaDocto >'".$fecha." 00:00:00'
							 and FechaDocto <'".$fecha." 23:59:59'
							 order by convert(int,NumeroDocto) desc";
	}
	$rsConsultaBoletas = odbc_exec( $conn, $consultaBoletas );
	if (!$rsConsultaBoletas){  //si la fila esta vacia no entra
		echo( "Error en la consulta SQL" );
	}	
	while($resultado = odbc_fetch_array($rsConsultaBoletas)){
		$res[] = array(
			'tipoDocto'=>$resultado['TipoDocto'],
			'numeroDocto'=>$resultado['NumeroDocto'],
			'fechaDocto'=>$resultado['FechaDocto'],
			'monto'=>(int)$resultado['Total']
		);
	}
	echo json_encode($res);
?>