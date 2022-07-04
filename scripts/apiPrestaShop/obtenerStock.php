<?php
header('Access-Control-Allow-Origin: *');
	set_time_limit(300);
	require_once("../../clases/conexionocdb.php");
	require ('libreriaPresta.php');
	require_once("packs.php");
	$upc = $_POST['upc'];
	$sku = $_POST['sku'];

try {
        if($upc ==''){ //PACK O NO PACK 
            
            $pack =0 ; // pack
        }else{
            $pack = $upc;
        }	
        if($pack ==0){
            $consultarStock="select sum(Cantidad) as Cantidad,itemName from rp_vicencio.dbo.si_lotesDisponibles where itemcode ='".$sku."' and bodega ='009' group by ItemCode,ItemName";
            $rsStock = odbc_exec( $conn, $consultarStock );
            $resultado = odbc_fetch_array($rsStock);
            $stock = (int)$resultado['Cantidad'];
            $res[] = array( // asignar el vector 
                "sku"=>$sku,
                "stock"=>$stock,
            );
        }else{
            foreach ($promociones as $item=>$value){
                if($pack==$value->getIdPack()){
                    foreach($value->getProductos() as $codProm=>$precioProm){
                        $consultarStock="select sum(Cantidad) as Cantidad,itemName from rp_vicencio.dbo.si_lotesDisponibles where itemcode ='".$codProm."' and bodega ='009' group by ItemCode,ItemName";
                        $rsStock = odbc_exec( $conn, $consultarStock );
                        $resultado = odbc_fetch_array($rsStock);
                        $stock = (int)$resultado['Cantidad'];
                        $res[] = array( // asignar el vector 
                            "sku"=>$codProm,
                            "stock"=>$stock,
                        );
                    }
                }				
            }			
        }				
        echo json_encode($res);

	// $sku='';
	//    // creating webservice access
	//    $webService = new PrestaShopWebservice('https://www.vicencioperfumerias.cl/clonvic','AKZZU9AGZNEW47C8SB6TGB3HJYA5GJF5', false); // se crea conexion
	// 	$xml = $webService->get(array('resource' => 'orders')); // se genera una variable que obtiene los datos del xml entero de ordenes
	// 	$opt = array(
	// 		'resource'=>'orders',
	// 		'display'=>'full',
	// 		'filter[reference]'=>$idPedido
	// 	);
	// 	$xml = $webService->get($opt);     // se realiza la obtencion de datos con la variable opt
	// 	$resources = $xml->orders->order->associations->order_rows->children(); // se asigna a la variable resource los hijos del xml de la orden 
	// 	foreach ($resources as $key=>$resource){ // para cada hijo key sera el nombre del valor y resource el valor 
	// 		foreach ($resource as $key2=>$resou2){ // para cda hijo del hijo 
	// 				if($key2 =='product_upc'){ //PACK O NO PACK 
	// 					if((string)$resou2==""){
	// 					$pack =0 ; // pack
	// 					}else{
	// 					$pack = $resou2;
	// 					}					
	// 				}
	// 				if($key2 =='product_name'){ // descripcion
	// 					$productoNombre =str_replace('&','',(string)$resou2);
	// 				}
	// 				if($key2 =='product_ean13'){ // descripcion
	// 					$sku =(string)$resou2 ;
	// 				}
	// 				if($key2 =='product_quantity'){ // cantidad del producto
	// 					$productoCantidad =(int)$resou2 ;
	// 				}
	// 				if($key2 =='unit_price_tax_excl'){
	// 					$productoPrecio =round((double)$resou2) ; // Precio del Producto
	// 				}
	// 		}
			// if($pack ==0){
			// 	$consultarStock="select sum(Cantidad) as Cantidad,itemName from rp_vicencio.dbo.si_lotesDisponibles where itemcode ='".$sku."' and bodega ='009' group by ItemCode,ItemName";
			// 	$rsStock = odbc_exec( $conn, $consultarStock );
			// 	$resultado = odbc_fetch_array($rsStock);
			// 	$stock = (int)$resultado['Cantidad'];
			// 	$res[] = array( // asignar el vector 
			// 		"sku"=>$sku,
			// 		"descripcion"=>$productoNombre,
			// 		"cantidad"=>$productoCantidad,
			// 		"precio"=>$productoPrecio,
			// 		"stock"=>$stock,
			// 	);
			// }else{
			// 	foreach ($promociones as $item=>$value){
			// 		if($pack==$value->getIdPack()){
			// 			foreach($value->getProductos() as $codProm=>$precioProm){
			// 				$consultarStock="select sum(Cantidad) as Cantidad,itemName from rp_vicencio.dbo.si_lotesDisponibles where itemcode ='".$codProm."' and bodega ='009' group by ItemCode,ItemName";
			// 				$rsStock = odbc_exec( $conn, $consultarStock );
			// 				$resultado = odbc_fetch_array($rsStock);
			// 				$stock = (int)$resultado['Cantidad'];
			// 				$res[] = array( // asignar el vector 
			// 					"sku"=>$codProm,
			// 					"descripcion"=>$resultado['itemName'],
			// 					"cantidad"=>$productoCantidad,
			// 					"precio"=>$precioProm,
			// 					"stock"=>$stock,
			// 				);
			// 			}
			// 		}				
			// 	}			
			// }
	// 	}
	// echo json_encode($res);
    }
catch (PrestaShopWebserviceException $ex) {
   echo 'Error: <br />' . $ex->getMessage();
}