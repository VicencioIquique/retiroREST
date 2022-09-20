<?php
require("../clases/conexionocdb.php");
$fecha=$_POST["fecha"];


	$sql = "SELECT case cab.TipoDocto
    when 1 then 'Boleta Fiscal'
    when 99 then 'Nula'
    when 4 then 'Boleta Manual'
    end as TipoDocto,
    cab.BillToCompany as Pedido,
    cab.NumeroDocto,
    cab.Total + RetencionCarnes as Total,
    case pagos.tipopago
    when 'TRANSFERENCIA' then SUM(Monto)
    else sum(0)
    end Transferencia,
    case pagos.tipopago
    when 'WEBPAYCREDITO' then SUM(Monto)
    else sum(0)
    end WebpayCredito,
    case pagos.tipopago
    when 'WEBPAYDEBITO' then SUM(Monto)
    else sum(0)
    end WebpayDebito,
    cab.Total as Productos,
    RetencionCarnes as Flete
    FROM [RP_VICENCIO].[dbo].[RP_ReceiptsCab_SAP] cab
    left join [RP_VICENCIO].[dbo].[RP_Receiptspagos_SAP] pagos on cab.ID =pagos.ID
    where cab.FechaDocto >='".$fecha."' and cab.fechadocto <='".$fecha." 23:59:59' and cab.bodega ='009'
    GROUP BY CAB.NumeroDocto,cab.TipoDocto,CAB.BillToCompany,CAB.Total,TipoPago,retencioncarnes";
	
    $rs= odbc_exec( $conn, $sql );
    if (!$rs){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL" );
	}	
    while($resultado = odbc_fetch_array($rs)){
		$res[] = array(
			"tipoDocto"=>$resultado['TipoDocto'],
			"pedido"=>$resultado['Pedido'],
			"numerodocto"=>$resultado['NumeroDocto'],	
			"total"=>(int)$resultado['Total'],
			"Transferencia"=>(int)$resultado['Transferencia'],
			"wpCredito"=>(int)$resultado['WebpayCredito'],	
			"wpDebito"=>(int)$resultado['WebpayDebito'],
			"productos"=>(int)$resultado['Productos'],
			"flete"=>(int)$resultado['Flete'],
		);
    }
	echo json_encode($res);
	
?>