<?php require_once('../../Connections/conexion.php'); ?>
<?php 


mysql_select_db($database_conexion, $conexion);
$select = "SELECT ID_GRUPO, NOMBRE_GRUPO, FORMAT(SUM(MONTO_VENDIDO),2), FORMAT(SUM(MONTO_POR_VENDER),2), FORMAT(SUM(MONTO_COBRADO),2), FORMAT(SUM(MONTO_POR_COBRAR),2), FORMAT(SUM(MONTO_VENCIDO),2) FROM vista_rpt_ventas_inmuebles GROUP BY ID_GRUPO";

$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );

$fields = mysql_num_fields ( $export );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysql_field_name( $export , $i ) . "\t";
}

while( $row = mysql_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=your_desired_name.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";?>