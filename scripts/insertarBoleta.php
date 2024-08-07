<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); //se hace referencia a la clase conexion que contiene los parametros para entrar a sql server	
	
	$jsonBoletaDetalle = $_POST["jsonBoletaDetalle"];			//recibir JSON con campos de detalle de boleta
	$jsonBoletaCabecera = $_POST['jsonBoletaCabecera'];			//recibir JSON con campos de cabecera de boleta
	$jsonBoletaPagos = $_POST['jsonBoletaPagos'];			//recibir JSON con campos de pagos de boleta
	
	$serieComp ='80';// serie de caja 3 mudulo 2002 
	$numeroDoctoComp = $jsonBoletaCabecera['numeroDocto'];
	$bodegaComp = $jsonBoletaCabecera['bodega'];
	$workstationComp = $jsonBoletaCabecera['workstation'];
	$tipoDoctoComp = $jsonBoletaCabecera['tipoDocto'];

	//----------------------------------------------------------------------------------------------------------------------------------------------------------------
	$sqlComprobarNoRepeticion = 
		"SELECT numeroDocto, bodega, workstation 
		FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
		WHERE numeroDocto = '".$numeroDoctoComp."' AND
			bodega = '".$bodegaComp."' AND
			workstation = '".$workstationComp."' AND
			TipoDocto = '".$tipoDoctoComp."' AND
			Serie ='".$serieComp."'";

	$rsComprobarNoRepeticion = odbc_exec( $conn, $sqlComprobarNoRepeticion );
	if (!$rsComprobarNoRepeticion){
		exit( "Error en la consulta SQL Comprobar repetición de boletas");
		echo( "Error en la consulta SQL Comprobar repetición de boletas");
	}	
	$resultadoNoRepeticion = odbc_fetch_array($rsComprobarNoRepeticion);
	if($resultadoNoRepeticion['numeroDocto'] != null || $resultadoNoRepeticion['numeroDocto'] != ''){
		echo 0; //Resultado de respuesta a control de repetición de boleta
	}else{
//OBTENER REC NUMBER--------------------------------------------------------------------------------
		for ($i=0;$i<count($jsonBoletaDetalle['tablaProdAluSplit']);$i++){
			$sqlRecNumber="SELECT RecNumber FROM rp_vicencio.dbo.rp_articulos where ALU ='".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."'";
			$rsRecNumber  = odbc_exec( $conn, $sqlRecNumber );
			$resultadoRecNumber =odbc_fetch_array($rsRecNumber);
			$jsonBoletaDetalle['tablaProdNumSplit'][$i]= $resultadoRecNumber['RecNumber'];
		}
//--------------------------------------------------------------------------------------------------
		//OBTENER DOLAR DEL DIA
		$sqlTipoCambio = 
			"SELECT TOP 1 [Monto]
			FROM [RP_VICENCIO].[dbo].[RP_MONEDA]
			ORDER BY FechaModificacion DESC";

		$rsTipoCambio = odbc_exec( $conn, $sqlTipoCambio );
		if (!$rsTipoCambio){
			exit( "Error en la consulta SQL Seleccionar tipo cambio" );
			echo( "Error en la consulta SQL Seleccionar tipo cambio" );
		}
		$resultadoTipoCambio = odbc_fetch_array($rsTipoCambio);
		$tipoCambio =str_replace(",",".",$resultadoTipoCambio['Monto']);

		//Acumuladores de resultados de Detalle para CABECERA
		$acumCIF = 0;
		
		//Obtener fecha actual del servidor para FechaCreacion
		@$fechaCreacion = date('Y-m-d H:i:s');
		
		//Factor temporal para el cálculo de la retenciónDL
		$factor = 0.0035; //update 31.03.24
		
		//Secuencia para inserción en tabla Detalle
		$secuencia = 1;

		//echo $tipoCambio;
		//FIN OBTENER DOLAR DEL DIA
		//echo 1;
	}

	//INSERTAR DETALLE
	//echo "\nINSERCION DE DETALLE \n";
	
	for ($i=0;$i<count($jsonBoletaDetalle['tablaProdAluSplit']);$i++){
		$cantAux=(int)$jsonBoletaDetalle['tablaProdCantidadSplit'][$i]; // variable para almacenar la cantidad a comprar de un producto
			
		//BUSCAR LOTE, CIF, FECHA, CANTIDAD
		$sqlCIFLotes=
			"SELECT Z,Cantidad,Cif,Fecha
			FROM RP_VICENCIO.dbo.LotesDisponibles
			WHERE ItemCode = '".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."' AND
				bodega='".$jsonBoletaDetalle['bodega']."'
				ORDER BY Fecha ASC";
			
		$rsCIFLotes = odbc_exec( $conn, $sqlCIFLotes );
		if (!$rsCIFLotes){  //si la fila esta vacia no entra
			exit( "Error en la consulta SQL Buscar LOTE, CIF, FECHA, CANTIDAD");
			echo( "Error en la consulta SQL Buscar LOTE, CIF, FECHA, CANTIDAD");
		}
		$cantAuxDiv; //Variable auxiliar para conversar el resto si se necesita más de un lote de un producto para la venta
			
		while($resultado = odbc_fetch_array($rsCIFLotes)){
			//echo "Cantidad de productos: ".$cantAux."\n";
			//Algoritmo para selección de lotes
			while($cantAux>0){
				if($cantAux<(int)$resultado['Cantidad']){
					//echo $cantAux." - Z: ".$resultado['Z']."- Fecha: ".$resultado['Fecha'];
					//BUSCAR COSTO EXT
					$sqlCostoExt=
						"SELECT AvgPrice
						FROM SBO_Imp_Eximben_SAC.dbo.OITM
						WHERE ItemCode = '".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."'";
						
					$rsCostoExt = odbc_exec( $conn, $sqlCostoExt );
					if (!$rsCostoExt){  //si la fila esta vacia no entra
						exit( "Error en la consulta SQL CostoExt" );
						exit( "Error en la consulta SQL CostoExt" );
					}
					$resultadoCostoExt = odbc_fetch_array($rsCostoExt);
						
					//INSERTAR DETALLE
					$sqlInsertarDetalle = 
						"IF NOT EXISTS (SELECT * FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP WHERE ID ='".$jsonBoletaDetalle['ID']."' AND secuencia ='".$secuencia."')
						INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
						VALUES('".$jsonBoletaDetalle['bodega']."',
								'".$jsonBoletaDetalle['tipoDocto']."',
								'".$jsonBoletaDetalle['numeroDocto']."',
								'".$secuencia."',
								'".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."',
								'".(int)$cantAux."',
								'".(-($jsonBoletaDetalle['tablaProdVOrigSplit'][$i] * 0.19)* $jsonBoletaDetalle['tablaProdCantidadSplit'][$i])."',
								'".$jsonBoletaDetalle['tablaProdDsctoSplit'][$i]."',
								'".$jsonBoletaDetalle['tablaProdVOrigSplit'][$i]."',
								'126',
								'".$resultado['Cif']*(int)$cantAux."',
								'".$resultado['Z']."',
								'".(($jsonBoletaDetalle['tablaProdVFinalSplit'][$i]/$jsonBoletaDetalle['tablaProdCantidadSplit'][$i])*$cantAux)."',
								'".$jsonBoletaDetalle['factor']."',
								'".$jsonBoletaDetalle['workstation']."',
								'".$jsonBoletaDetalle['ID']."',
								'".$resultadoCostoExt['AvgPrice']."',
								'".$jsonBoletaDetalle['numListaPrecio']."',
								'".$jsonBoletaDetalle['tablaProdNumSplit'][$i]."',
								'".$jsonBoletaDetalle['codigoBarra'][$i]."',
								'".$jsonBoletaDetalle['tablaProdIDPreventaSplit'][$i]."',
								'".$jsonBoletaDetalle['totalImpuesto']."',
								'".$jsonBoletaDetalle['porcentajeImpuesto']."',
								'".$jsonBoletaDetalle['aux']."',
								'".$jsonBoletaDetalle['attr']."',
								'".$jsonBoletaDetalle['codPromo']."')";

					$acumCIF = $acumCIF + ($resultado['Cif'] * (int)$cantAux);
					$cantAux=0;
					$cantAuxDiv = 0;
					$secuencia++;
					$rsInsertarDetalle = odbc_exec( $conn, $sqlInsertarDetalle );
					if (!$rsInsertarDetalle){  //si la fila esta vacia no entra
						exit( "Error en la inserción de Detalle" );
						exit( "Error en la inserción de Detalle" );
					}
					//echo $sqlInsertarDetalle."\n";
				}else if($cantAux==$resultado['Cantidad']){
					//echo $cantAux." - Z: ".$resultado['Z']."- Fecha: ".$resultado['Fecha']."\n";
					//BUSCAR COSTO EXT
					$sqlCostoExt=
						"SELECT AvgPrice
						FROM SBO_Imp_Eximben_SAC.dbo.OITM
						WHERE ItemCode = '".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."'";
						
					$rsCostoExt = odbc_exec( $conn, $sqlCostoExt );
					if (!$rsCostoExt){  //si la fila esta vacia no entra
						exit( "Error en la consulta SQL CostoExt" );
						echo( "Error en la consulta SQL CostoExt" );
					}
					$resultadoCostoExt = odbc_fetch_array($rsCostoExt);
						
					//INSERTAR DETALLE
					$sqlInsertarDetalle = 
						"IF NOT EXISTS (SELECT * FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP WHERE ID ='".$jsonBoletaDetalle['ID']."' AND secuencia ='".$secuencia."')
						INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsDet_SAP 
						VALUES('".$jsonBoletaDetalle['bodega']."',
								'".$jsonBoletaDetalle['tipoDocto']."',
								'".$jsonBoletaDetalle['numeroDocto']."',
								'".$secuencia."',
								'".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."',
								'".(int)$cantAux."',
								'".(-($jsonBoletaDetalle['tablaProdVOrigSplit'][$i] * 0.19)* $jsonBoletaDetalle['tablaProdCantidadSplit'][$i])."',
								'".$jsonBoletaDetalle['tablaProdDsctoSplit'][$i]."',
								'".$jsonBoletaDetalle['tablaProdVOrigSplit'][$i]."',
								'126',
								'".$resultado['Cif']*(int)$cantAux."',
								'".$resultado['Z']."',
								'".(($jsonBoletaDetalle['tablaProdVFinalSplit'][$i]/$jsonBoletaDetalle['tablaProdCantidadSplit'][$i])*$cantAux)."',
								'0',
								'".$jsonBoletaDetalle['workstation']."',
								'".$jsonBoletaDetalle['ID']."',
								'".$resultadoCostoExt['AvgPrice']."',
								'".$jsonBoletaDetalle['numListaPrecio']."',
								'".$jsonBoletaDetalle['tablaProdNumSplit'][$i]."',
								'".$jsonBoletaDetalle['codigoBarra'][$i]."',
								'".$jsonBoletaDetalle['tablaProdIDPreventaSplit'][$i]."',
								'".$jsonBoletaDetalle['totalImpuesto']."',
								'".$jsonBoletaDetalle['porcentajeImpuesto']."',
								'".$jsonBoletaDetalle['aux']."',
								'".$jsonBoletaDetalle['attr']."',
								'".$jsonBoletaDetalle['codPromo']."')";
			
					$acumCIF = $acumCIF + ($resultado['Cif'] * (int)$cantAux);
					$cantAux=0;
					$cantAuxDiv = 0;
					$secuencia++;
					$rsInsertarDetalle = odbc_exec( $conn, $sqlInsertarDetalle );
					if (!$rsInsertarDetalle){  //si la fila esta vacia no entra
						exit( "Error en la inserción de Detalle" );
						echo( "Error en la inserción de Detalle" );
					}
					//echo $sqlInsertarDetalle."\n";
				}else{
					//echo (int)$resultado['Cantidad']." - Z: ".$resultado['Z']."- Fecha:".$resultado['Fecha']."\n";
					//BUSCAR COSTO EXT
					$sqlCostoExt=
						"SELECT AvgPrice
						FROM SBO_Imp_Eximben_SAC.dbo.OITM
						WHERE ItemCode = '".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."'";
						
					$rsCostoExt = odbc_exec( $conn, $sqlCostoExt );
					if (!$rsCostoExt){  //si la fila esta vacia no entra
						exit( "Error en la consulta SQL CostoExt" );
						exit( "Error en la consulta SQL CostoExt" );
					}
					$resultadoCostoExt = odbc_fetch_array($rsCostoExt);
						
					//INSERTAR DETALLE
					$sqlInsertarDetalle = 
						"IF NOT EXISTS (SELECT * FROM RP_VICENCIO.dbo.RP_ReceiptsDet_SAP WHERE ID ='".$jsonBoletaDetalle['ID']."' AND secuencia ='".$secuencia."')
						INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsDet_SAP
						VALUES('".$jsonBoletaDetalle['bodega']."',
								'".$jsonBoletaDetalle['tipoDocto']."',
								'".$jsonBoletaDetalle['numeroDocto']."',
								'".$secuencia."',
								'".$jsonBoletaDetalle['tablaProdAluSplit'][$i]."',
								'".(int)$resultado['Cantidad']."',
								'".(-($jsonBoletaDetalle['tablaProdVOrigSplit'][$i] * 0.19)* $jsonBoletaDetalle['tablaProdCantidadSplit'][$i])."',
								'".$jsonBoletaDetalle['tablaProdDsctoSplit'][$i]."',
								'".$jsonBoletaDetalle['tablaProdVOrigSplit'][$i]."',
								'126',
								'".$resultado['Cif']*(int)$resultado['Cantidad']."',
								'".$resultado['Z']."',
								'".(($jsonBoletaDetalle['tablaProdVFinalSplit'][$i]/$jsonBoletaDetalle['tablaProdCantidadSplit'][$i])*$resultado['Cantidad'])."',
								'0',
								'".$jsonBoletaDetalle['workstation']."',
								'".$jsonBoletaDetalle['ID']."',
								'".$resultadoCostoExt['AvgPrice']."',
								'".$jsonBoletaDetalle['numListaPrecio']."',
								'".$jsonBoletaDetalle['tablaProdNumSplit'][$i]."',
								'".$jsonBoletaDetalle['codigoBarra'][$i]."',
								'".$jsonBoletaDetalle['tablaProdIDPreventaSplit'][$i]."',
								'".$jsonBoletaDetalle['totalImpuesto']."',
								'".$jsonBoletaDetalle['porcentajeImpuesto']."',
								'".$jsonBoletaDetalle['aux']."',
								'".$jsonBoletaDetalle['attr']."',
								'".$jsonBoletaDetalle['codPromo']."')";
					//Se utiliza $resultado['Cantidad'] porque es el número máximo que cotniene ese lote
					$acumCIF = $acumCIF + ($resultado['Cif']*(int)$resultado['Cantidad']);
					//Multiplicación por $resultado['Cantidad'] porque es la cantidad máxima que maneja el lote
					$cantAuxDiv = $cantAux - $resultado['Cantidad'];
					$cantAux = 0;
					$secuencia++;
					$rsInsertarDetalle = odbc_exec( $conn, $sqlInsertarDetalle );
					if (!$rsInsertarDetalle){  //si la fila esta vacia no entra
						exit( "Error en la inserción de Detalle" );
						echo( "Error en la inserción de Detalle" );
					}
					//echo $sqlInsertarDetalle."\n";
				}
			}
			$cantAux = $cantAuxDiv;
		}
	}
	//FIN INSERTAR DETALLE
		
	//INICIO INSERTAR CABECERA
		$fechaDocto = $jsonBoletaCabecera['fechaDocto'];
	//echo "\nINSERCION CABECERA\n";
	//Obtener Serie
	$resultadoSerie = '80';
		
	$retencionDL18219 = (($acumCIF * (double)$tipoCambio) * $factor); //Formula para obtener retenciónDL18219
	$sqlInsertarCabecera = 
		"INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
		VALUES ('".$jsonBoletaCabecera['bodega']."',
				'".$jsonBoletaCabecera['workstation']."',
				'".$jsonBoletaCabecera['tipoDocto']."',
				'".$jsonBoletaCabecera['numeroDocto']."',
				'".$fechaDocto."',
				'".$jsonBoletaCabecera['totNeto']."',
				'".$jsonBoletaCabecera['totDescuento']."',
				'".$jsonBoletaCabecera['totIva']."',
				'".$jsonBoletaCabecera['total']."',
				'',
				'',
				'".$jsonBoletaCabecera['cajera']."',
				'".round($retencionDL18219)."',
				'".$tipoCambio."',
				".number_format($acumCIF, 4, '.', '').",
				'".((int)$jsonBoletaCabecera['total'] - round($retencionDL18219))."',
				'".$jsonBoletaCabecera['vendedorNumero']."',
				'".$jsonBoletaCabecera['estado']."',
				'".$jsonBoletaCabecera['numeroDoctoRef']."',
				'".$jsonBoletaCabecera['fechaDoctoRef']."',
				'".$jsonBoletaCabecera['ID']."',
				'".$jsonBoletaCabecera['fechaCreacion']."',
				'".$resultadoSerie."',
				'".$jsonBoletaCabecera['retencionCarnes']."',
				'".$jsonBoletaCabecera['netoRetencionCarnes']."',
				'0.43',
				'".$jsonBoletaCabecera['billToCompany']."',
				'".number_format(($jsonBoletaCabecera['total'] - round($retencionDL18219)), 0, ',', '.')."',
				'".$jsonBoletaCabecera['type']."',
				'".$jsonBoletaCabecera['Status']."',
				'".$jsonBoletaCabecera['baseEntry']."')";
	//echo $sqlInsertarCabecera;
	$rsInsertarCabecera = odbc_exec( $conn, $sqlInsertarCabecera );
	if (!$rsInsertarCabecera){  //si la fila esta vacia no entra
		exit( "Error en la inserción de Cabecera" );
		echo( "Error en la inserción de Cabecera" );
	}
		
	//FIN INSERTAR CABECERA
		
	//INICIO INSERTAR PAGOS
		
	$secuenciaPagos = 0;
	//echo "\nINSERCION DE PAGOS\n";
		//echo "JSON ".$jsonBoletaPagos;
		//echo "<script>console.log('" . json_encode($jsonBoletaPagos) . "');</script>";
		$sqlInsertarPagos = 
			"INSERT INTO RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP
			VALUES('".$jsonBoletaPagos['bodega']."',
					'".$jsonBoletaPagos['tipoDocto']."',
					'".$jsonBoletaPagos['numeroDocto']."',
					'".($secuenciaPagos+1)."',
					'".$jsonBoletaPagos['tipoPago']."',
					'".$jsonBoletaPagos['NumeroDoc']."',
					'".$jsonBoletaPagos['fechaDoc']."',
					'".$jsonBoletaPagos['monto']."',
					'".$jsonBoletaPagos['desc1']."',
					'".$jsonBoletaPagos['desc2']."',
					'".$jsonBoletaPagos['desc3']."',
					'".$jsonBoletaPagos['desc4']."',
					'".$jsonBoletaPagos['CdCuenta']."',
					'".$jsonBoletaPagos['workstation']."',
					'".$jsonBoletaPagos['ID']."')";
		$rsInsertarPagos = odbc_exec( $conn, $sqlInsertarPagos );
		if (!$rsInsertarPagos){  //si la fila esta vacia no entra
			exit( "Error en la inserción de Pagos" );
			echo( "Error en la inserción de Pagos" );
		}
		//echo "Insert Pagos ".$sqlInsertarPagos;
	//FIN INSERTAR PAGOS
		
	//Actualizar ultimo folio de los documentos
	$ip= '192.168.1.4'; // IP PUNTO RETIRO
	if($jsonBoletaCabecera['tipoDocto'] == '1'){
		$sqlActualizarFolio = 
			"UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
			SET ultFolioFiscal = '".$jsonBoletaCabecera['numeroDocto']."'
			WHERE ip = '".$ip."'";

		$rsActualizarFolio = odbc_exec( $conn, $sqlActualizarFolio );
		if (!$rsActualizarFolio){  //si la fila esta vacia no entra
			exit( "Error actrualizando último Folio Fiscal" );
			echo( "Error actrualizando último Folio Fiscal" );
		}	
	}else if($jsonBoletaCabecera['tipoDocto'] == '2'){

		$sqlActualizarFolio = 
			"UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
			SET ultFactura = '".$jsonBoletaCabecera['numeroDocto']."'
			WHERE ip = '".$ip."'";

		$rsActualizarFolio = odbc_exec( $conn, $sqlActualizarFolio );
		if (!$rsActualizarFolio){  //si la fila esta vacia no entra
			exit( "Error actrualizando último Folio Factura" );
			echo( "Error actrualizando último Folio Factura" );
		}	
	}else if($jsonBoletaCabecera['tipoDocto'] == '3'){

		$sqlActualizarFolio = 
			"UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
			SET ultNotaCredito = '".$jsonBoletaCabecera['numeroDocto']."'
			WHERE ip = '".$ip."'";

		$rsActualizarFolio = odbc_exec( $conn, $sqlActualizarFolio );
		if (!$rsActualizarFolio){  //si la fila esta vacia no entra
			exit( "Error actrualizando último Folio Nota de crédito" );
			echo( "Error actrualizando último Folio Nota de crédito" );
		}	
	}else if($jsonBoletaCabecera['tipoDocto'] == '4'){

		$sqlActualizarFolio = 
			"UPDATE RP_VICENCIO.dbo.RP_IP_BODEGAS
			SET ultBoletaManual = '".$jsonBoletaCabecera['numeroDocto']."'
			WHERE ip = '".$ip."'";

		$rsActualizarFolio = odbc_exec( $conn, $sqlActualizarFolio );
		if (!$rsActualizarFolio){  //si la fila esta vacia no entra
			exit( "Error actrualizando último Folio Boleta Manual" );
			echo( "Error actrualizando último Folio Boleta Manual" );
		}	
	}
	//INSERTAR A TABLA VENTAS_CL PARA RUT DE CLIENTES ASOSCIADOS A LA BOLETA, ANTERIOR MENTE INGRESABAN EN CABECERA, AHORA SOLAMENTE EN CHEQUES INGRESARAN
	$sqlVenta_CL = "INSERT INTO RP_VICENCIO.dbo.Ventas_Cl 
								VALUES('".$jsonBoletaCabecera['ID']."',
										'".$jsonBoletaCabecera['rutCliente']."',
										'')";
	$rsInsertarVentas_CL = odbc_exec( $conn, $sqlVenta_CL );
	if (!$rsInsertarVentas_CL){  //si la fila esta vacia no entra
			exit( "Error registrando Venta cliente");
			echo( "Error registrando Venta cliente" );
	}	
	//--------------------------------------------------------------------------------------------------------------------------------------------------
	echo 1;
	odbc_close( $conn );
?>