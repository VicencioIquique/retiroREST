<?php
	require ('libreriaPresta.php');
	$id = $_POST['id'];
try{
	$webService = new PrestaShopWebservice('www.vicencioperfumerias.cl/iquique','AKZZU9AGZNEW47C8SB6TGB3HJYA5GJF5', false); // se crea conexion
	$xml = $webService->get(array('resource' => 'orders'));
	$opt = array(
		'resource'=>'orders',
		'display'=>'full',
		'filter[reference]'=>$id
	);
	$xml = $webService->get($opt);
	$resources = $xml->orders->order->children(); 
	foreach ($resources as $key=>$resource){
		if($key=='total_shipping'){ 
			@$transporte->flete =(int)$resource;
		}
	}
	$res = json_encode($transporte);
	echo($res);
}catch (PrestaShopWebserviceException $ex) {
   // Shows a message related to the error
   echo 'Other error: <br />' . $ex->getMessage();
}
?>