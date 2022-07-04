<?php
	require ('libreriaPresta.php');
try {
   // creating webservice access
      $webService = new PrestaShopWebservice('www.eximben.cl/presta/', 'I34UW1QBYAMQTE5WC2MYTMFPI856H4IP', false);
  
   // call to retrieve all clients
    $xml = $webService->get(array('resource' => 'customers'));
	$resources = $xml->customers->children();
	foreach ($resources as $resource){
		echo $resource->attributes();
	}
}
catch (PrestaShopWebserviceException $ex) {
   // Shows a message related to the error
   echo 'Other error: <br />' . $ex->getMessage();
}
?>