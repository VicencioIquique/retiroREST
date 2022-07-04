<?php
$dsn = "prueba"; 
$usuario ="sa";
$clave="U4xyyBLk56";
$conn=odbc_connect($dsn, $usuario, $clave);
if (!$conn)
{
	exit( "Error al establecer la conexion: ".$conn);
}

?>		
