<?php
	require ('libreriaPresta.php');
try {
   // creating webservice access
   $webService = new PrestaShopWebservice('http://sql.cl/presta/','71UZUSQX2EC29ED7YRA9ADN6XQ5YBN1E', false);
  
   // call to retrieve all clients
    $xml = $webService->get(array('resource' => 'customers'));
	$resources = $xml->customers->children();
	
		// Define the resource
	$opt = array('resource' => 'customers');
	 
	// Define the resource id to modify
	$opt['id'] = '2';
	 
	// Call the web service, recuperate the XML file
	$xml = $webService->get( $opt );
	 
	// Retrieve resource elements in a variable (table)
	$resources = $xml->children()->children();
	 
	// customer form
	
	}
catch (PrestaShopWebserviceException $ex) {
   // Shows a message related to the error
   echo 'Other error: <br />' . $ex->getMessage();
}
?>