<html><head><title>CRUD Tutorial - Update example</title></head><body>
<?php
	define('DEBUG', true);
	define('PS_SHOP_PATH', 'http://sql.cl/presta/');
	define('PS_WS_AUTH_KEY', '71UZUSQX2EC29ED7YRA9ADN6XQ5YBN1E');
	require ('libreriaPresta.php'); // se llama libreria prestashop WEBService
	
	$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG); // genera la variable conexion para la base de datos
	$opt = array('resource' => 'customers'); 
	$opt['id'] = '2';
	$xml = $webService->get($opt);
	
	// Here we get the elements from children of customer markup which is children of prestashop root markup
	$resources = $xml->children()->children();
	$resources->email ='loji@gmail.com';
	/*foreach ($resources as $nodeKey => $node)
	{
		//$resources->$nodeKey = $_POST[$nodeKey];
		//echo $nodeKey ."-".$resources->$nodeKey."<br>";
	}*/
	$opt = array('resource' => 'customers'); // asigna el nombre de xml
	$opt['putXml'] = $xml->asXML();
	$opt['id'] = '2';
	//echo "".$xml->asXML();
	$xml = $webService->edit($opt);
	// if WebService don't throw an exception the action worked well and we don't show the following message
	echo "Successfully updated.";
?>
</body></html>