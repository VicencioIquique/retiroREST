<?php
	require ('libreriaPresta.php');
	$id = $_POST['id'];
try {
	   // creating webservice access
	    $webService = new PrestaShopWebservice('www.vicencioperfumerias.cl/iquique','AKZZU9AGZNEW47C8SB6TGB3HJYA5GJF5', false); // se crea conexion
		$xml = $webService->get(array('resource' => 'order_payments'));
		//$opt['resource'] = 'orders';
		//$opt['display'] = 'full';
		//$opt['filter[id]'] = '1'; // cambiar por id post
		$opt = array(
			'resource'=>'order_payments',
			'display'=>'full',
			'filter[order_reference]'=>$id
		);
		$xml = $webService->get($opt);
		$resources = $xml->order_payments->order_payment->children(); 
		foreach ($resources as $key=>$resource){
			if($key=='payment_method'){ 
				@$pago->tipo =(string)$resource;
			}
			if($key=='transaction_id'){  
				$pago->numeroTrans =(string)$resource;
			}
			if($key=='card_number'){ 
				$pago->numeroTarjeta =(string)$resource;
			}
			if($key=='card_expiration'){ // codigo autorizacion definidos en prestashop por la falta de campos
				$pago->codAut =(string)$resource;
			}
			if($key=='card_holder'){ // Numero de cuotas definidos en prestashop por la falta de campos
				$pago->nCuotas =(string)$resource;
			}
			if($key=='card_brand'){ // tipo Debito o Credito definidos en prestashop por la falta de campos
				if((string)$resource == 'Venta en cuotas'){
					$pago->tipoTarjeta ='Credito';
				}else if((string)$resource ='Venta en cuotas'){
					$pago->tipoTarjeta ='Debito';
				}
				
			}
		 }
		$res = json_encode($pago);
		echo($res);
	}
	catch (PrestaShopWebserviceException $ex) {
		// Shows a message related to the error
		echo 'Other error: <br />' . $ex->getMessage();
	}
?>