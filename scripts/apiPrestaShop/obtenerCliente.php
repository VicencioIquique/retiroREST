<?php
	require ('libreriaPresta.php');
	$id = $_POST['id'];
	error_reporting(E_ERROR);
try {
	   // creating webservice access
	    $webService = new PrestaShopWebservice('www.vicencioperfumerias.cl/iquique','AKZZU9AGZNEW47C8SB6TGB3HJYA5GJF5', false); // se crea conexion
		$xml = $webService->get(array('resource' => 'orders','current_state'=>'3'));
		//$opt['resource'] = 'orders';
		//$opt['display'] = 'full';
		//$opt['filter[id]'] = '1'; // cambiar por id post
		$opt = array(
			'resource'=>'orders',
			'display'=>'full',
			'filter[reference]'=>$id
		);
		$xml = $webService->get($opt);
		$resources = $xml->orders->order->children(); 
		foreach ($resources as $key=>$resource){ 
			if($key=='id_cart'){
				$cliente->carro=(int)$resource;
			}
			if($key=='id'){
				$cliente->nPedido=(int)$resource;
			}
			if($key=='date_add'){
			$cliente->fechaPedido=(string)$resource;// fecha de creacion del pedido
			}
			if($key=='id_address_delivery'){
				$idCliente=(int)$resource; // id de la direccion
				
				$xmlClientes = $webService->get(array('resource'=>'addresses'));
				$optCliente['resource'] ='addresses';
				$optCliente['id'] = $idCliente;
				
				$xmlClientes = $webService->get($optCliente);
				$resourceCliente =$xmlClientes->address->children();
				foreach($resourceCliente as $key2=>$resou2){
					if($key2=='firstname'){ // sku en api lastname :DOE firstname :John email :pub@prestashop.com
						$cliente->nombre=(string)$resou2;
					}
					if($key2=='lastname'){
						@$cliente->apellido=(string)$resou2;
					}
					if($key2=='dni'){ 
						$cliente->rut=(string)$resou2;
						//$cliente->rut = '15-5';
					}
					if($key2=='address1'){ 
						$cliente->direccion1=(string)$resou2;
					}
					if($key2=='city'){ 
						$cliente->ciudad=(string)$resou2;
					}if($key2=='vat_number'){ 
						$cliente->fono=(string)$resou2;
					}
				}
			}
			if($key == 'id_customer'){
				$idUsuario = (int)$resource;
				$xmlUsuario = $webService->get(array('resource'=>'customers'));
				$optUsuario['resource'] ='customers';
				$optUsuario['id'] =$idUsuario;
				$xmlUsuario = $webService->get($optUsuario);
				$resourceUsuario =$xmlUsuario->customer->children();
				foreach($resourceUsuario as $key3=>$resou3){
					if($key3=='email'){ 
						$cliente->email=(string)$resou3;
					}
				}
			}
		}
	$res = json_encode($cliente);
	echo($res);
}catch (PrestaShopWebserviceException $ex) {
   echo 'error: <br />' . $ex->getMessage();
}
?>