<?php
include('Connections/conexion.php');
	$db = mysql_connect($hostname_conexion,$username_conexion,$password_conexion);
	if(!$db)
		echo "Imposible conectar";
	
	mysql_select_db($database_conexion);
	mysql_query('ALTER DATABASE CHARACTER SET utf8');
	
	$result=mysql_query('show tables');
	
	while($tables = mysql_fetch_array($result)) 
		foreach ($tables as $key => $value) 
			mysql_query("ALTER TABLE $value CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	echo "Modificaciones correctas";
	
	//SELECT CONCAT('ALTER TABLE ',table_schema,'.',table_name,' engine=InnoDB;') FROM information_schema.tables WHERE ENGINE = 'MyISAM';
	
	//para modificar el motor de base de datos
?>
