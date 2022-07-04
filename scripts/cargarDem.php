<?php 
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$nroDem = $_POST['nroDem'];
	$consultaDEM ="SELECT * FROM [RP_VICENCIO].[dbo].[RP_DEM] where nrodem ='".$nroDem."'";
	$rsConsultaDEM = odbc_exec( $conn, $consultaDEM );
	if (!$rsConsultaDEM){  //si la fila esta vacia no entra
		exit( "Error en la consulta SQL Bancos" );
	}	
	while($resultado = odbc_fetch_array($rsConsultaDEM)){
		$res[] = array(
			'Cantidad'=>$resultado['Cantidad'],
			'CodigoProducto'=>$resultado['CodigoProducto'],
			'DescripcionProducto'=>sanear_string(utf8_encode($resultado['DescripcionProducto'])),
			'Estado'=>$resultado['Estado'],
		);
	}
	echo json_encode($res);
	
	function sanear_string($string) {
		$string = trim($string);
	
		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);
	
		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);
	
		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);
	
		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);
	
		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);
	
		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);
	
		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
			array("\\", "¨", "º", "-", "~",
				 "#", "@", "|", "!", "\"",
				 "·", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "`", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				 ".", ""),
			'',
			$string
		);
	
		return $string;
	}
?>