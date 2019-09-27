<?php 
$ordenar=$_GET['col'];
if($_GET['orden']==1)
{
	$ordenar=$ordenar." ASC";
	$orden=2;
}
else
{
	$ordenar=$ordenar." DESC";
	$orden=1;
}

$valor_col1=$_GET[$col1];
$valor_col2=$_GET[$col2];
$valor_col3=$_GET[$col3];
$valor_col4=$_GET[$col4];
$valor_col5=$_GET[$col5];
$valor_col6=$_GET[$col6];
$valor_col7=$_GET[$col7];
$valor_col8=$_GET[$col8];

$img_orden=' <img src="../image/azbw.png" width="12" height="13" border="0" />';

$str_col=$col1.'='.$valor_col1.'&'.$col2.'='.$valor_col2.'&'.$col3.'='.$valor_col3.'&'.$col4.'='.$valor_col4.'&'.$col5.'='.$valor_col5.'&'.$col6.'='.$valor_col6.'&'.$col7.'='.$valor_col7.'&'.$col8.'='.$valor_col8;

$url_col1='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col1.'&orden='.$orden.'" ';
$url_col2='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col2.'&orden='.$orden.'" ';
$url_col3='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col3.'&orden='.$orden.'" ';
$url_col4='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col4.'&orden='.$orden.'" ';
$url_col5='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col5.'&orden='.$orden.'" ';
$url_col6='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col6.'&orden='.$orden.'" ';
$url_col8='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col8.'&orden='.$orden.'" ';

$url_col1_1=' class="textos_ordenar">'.$titulo_col1.$img_orden."</a>";
$url_col2_1=' class="textos_ordenar">'.$titulo_col2.$img_orden."</a>";
$url_col3_1=' class="textos_ordenar">'.$titulo_col3.$img_orden."</a>";
$url_col4_1=' class="textos_ordenar">'.$titulo_col4.$img_orden."</a>";
$url_col5_1=' class="textos_ordenar">'.$titulo_col5.$img_orden."</a>";
$url_col6_1=' class="textos_ordenar">'.$titulo_col6.$img_orden."</a>";
$url_col8_1=' class="textos_ordenar">'.$titulo_col8.$img_orden."</a>";

switch ($_GET['col']) {
    case $col1:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col1_1=' class="textos_ordenar_rojo">'.$titulo_col1.$img_orden."</a>";
        break;
	case $col2:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col2_1=' class="textos_ordenar_rojo">'.$titulo_col2.$img_orden."</a>";
        break;
    case $col3:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col3_1=' class="textos_ordenar_rojo">'.$titulo_col3.$img_orden."</a>";
        break;
	case $col4:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col4_1=' class="textos_ordenar_rojo">'.$titulo_col4.$img_orden."</a>";
        break;
    case $col5:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col5_1=' class="textos_ordenar_rojo">'.$titulo_col5.$img_orden."</a>";
        break;
    case $col6:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col6_1=' class="textos_ordenar_rojo">'.$titulo_col6.$img_orden."</a>";
        break;
    case $col8:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col8_1=' class="textos_ordenar_rojo">'.$titulo_col8.$img_orden."</a>";
        break;
}

$url_col1=$url_col1.$url_col1_1;
$url_col2=$url_col2.$url_col2_1;
$url_col3=$url_col3.$url_col3_1;
$url_col4=$url_col4.$url_col4_1;
$url_col5=$url_col5.$url_col5_1;
$url_col6=$url_col6.$url_col6_1;
$url_col8=$url_col8.$url_col8_1;
?>