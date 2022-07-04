<?php
	require ('libreriaPresta.php'); // se llama libreria prestashop WEBService
	$id = $_POST['idCompra']; // CODIGO ALFANUMERICO DE PEDIDO (NO ES EL NUMERO DE PEDIDO)
	try{
		$webService = new PrestaShopWebservice('www.vicencioperfumerias.cl/clonvic','AKZZU9AGZNEW47C8SB6TGB3HJYA5GJF5', false); // se crea conexion
		$opt = array(
			'resource'=>'orders',
			'display'=>'full',
			'filter[reference]'=>$id
		);
		$xml = $webService->get($opt);
		//echo $xml;
		
		$resources = $xml->orders->order->children(); 
		foreach ($resources as $key=>$resource){
			if($key=='id'){
				$id =(int)$resource;
				//echo $id;
			}
		}
		$opt2 = array('resource' => 'orders'); 
		$opt2['id'] = $id;
		$xml2 = $webService->get($opt2);
		$resources2 = $xml2->children()->children();
		$resources2->current_state ='4';
		
		$opt2 = array('resource' => 'orders'); // asigna el nombre de xml
		$opt2['putXml'] = $xml2->asXML();
		$opt2['id'] = $id;
		//echo "".$xml->asXML();
		$xml2 = $webService->edit($opt2);
		echo 1;
	}
	catch (PrestaShopWebserviceException $ex){
			// Shows a message related to the error
			echo 'Error: <br />' . $ex->getMessage();
	}
?>