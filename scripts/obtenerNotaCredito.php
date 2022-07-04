<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$numeroDocto = $_POST['numeroDocto'];
	$bodega = $_POST['bodega'];
	$workstation = $_POST['workstation'];
	$tipoDocto = $_POST['tipoDocto'];
	
	$sqlVentaNotaCredito="SELECT 
								ALU,
								DESC2,
								RutCliente,
								DESC3,
								Cantidad, 
								Descuento,
								PrecioFinal,
								PrecioExtendido,
								RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Vendedor,
								RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.ID,
								FechaDocto 
							FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
							LEFT JOIN RP_VICENCIO.dbo.RP_Articulos ON RP_VICENCIO.dbo.RP_Articulos.ALU = RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Sku
							LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsCab_SAP ON RP_VICENCIO.dbo.RP_ReceiptsCab_SAP.ID = RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.ID
						WHERE 
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.NumeroDocto = '".$numeroDocto."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.Bodega = '".$bodega."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.WorkStation = '".$workstation."' AND
							RP_VICENCIO.dbo.RP_ReceiptsDet_SAP.tipoDocto = '".$tipoDocto."'
							AND FechaDocto >'2016-07-01'"; // consulta sql la fecha fue agregada por la duplicidad de los folios de CAJA 2 EN EL LOCAL 1132
							
							
	$rsVentaNC = odbc_exec( $conn, $sqlVentaNotaCredito );
	if (!$rsVentaNC){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Venta NC" );
	}	
	while($resultado = odbc_fetch_array($rsVentaNC)){
		$res[] = array(
			"ALU"=>$resultado['ALU'],
			"DESC2"=>$resultado['DESC2'],
			"DESC3"=>$resultado['DESC3'],
			"Cantidad"=>(int)$resultado['Cantidad'],
			"Descuento"=>(int)$resultado['Descuento'],
			"PrecioFinal"=>(int)$resultado['PrecioFinal'],
			"PrecioExtendido"=>(int)$resultado['PrecioExtendido'],
			"Vendedor"=>(int)$resultado['Vendedor'],
			"ID" => $resultado['ID'],
			"FechaDocto"=>$resultado['FechaDocto'],
			"RUT"=>$resultado['RutCliente']
		);
	}
	echo json_encode($res);
?>