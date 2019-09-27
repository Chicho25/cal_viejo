<?php //$tabla="vista_contabilidad_partidas"; ?>
<?php $tabla="partidas"; ?>
<?php $campo="TIPO between 1 and 2 AND ID_GRUPO"; ?>
<?php $orden=" ORDER BY ID"; ?>
<?php //if(isset($_GET['ID_EMPRESAS']) && $_GET['ID_EMPRESAS']!=" "){$empresa="AND ID_EMPRESA=".$_GET['ID_EMPRESAS'];} else {$empresa=" ";} ?>
<ul id='navigation'>
<?php $sql="SELECT ID, DESCRIPCION FROM " .$tabla." WHERE TIPO between 1 and 2 AND NIVEL=1 ".$orden;
 //$sql="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=111 ".$orden;
//echo $sql;
$rst_consulta = mysql_query( $sql, $conexion) or die(mysql_error());
$totalRows = mysql_num_rows($rst_consulta);
if ($totalRows > 0){
while($filamenu = mysql_fetch_assoc($rst_consulta)) { ?>
	<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filamenu['ID']; ?>"><?php //echo $filamenu['ID']; ?> <?php echo $filamenu['DESCRIPCION']; ?> <?php //echo $filamenu['NIVEL']; ?></a>
 	<ul>
 	<?php $id=$filamenu['ID']; ?>
	<?php $submenu="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=". $id.$orden;
	$rst_consultas = mysql_query($submenu, $conexion) or die(mysql_error());
	$totalRowss = mysql_num_rows($rst_consultas);
	if ($totalRowss > 0){
	while($filasub = mysql_fetch_assoc($rst_consultas)){ ?> 
    	 		<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub['ID']; ?>"><?php //echo $filasub['ID']; ?> <?php echo $filasub['DESCRIPCION']; ?> <?php //echo $filasub['NIVEL']; ?></a>
				<ul>
				<?php $id_sub_1=$filasub['ID']; ?>
				<?php $sql_1="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=".$id_sub_1.$orden;
				$submenu_1 = mysql_query( $sql_1, $conexion) or die(mysql_error());
				$totalRows_submenu_1 = mysql_num_rows($submenu_1);
				if ($totalRows_submenu_1 > 0){
				while($filasub_1 = mysql_fetch_assoc($submenu_1)){ ?>
					<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub_1['ID']; ?>"><?php //echo $filasub_1['ID']; ?> <?php echo $filasub_1['DESCRIPCION']; ?> <?php //echo $filasub_1['NIVEL']; ?></a>
					<ul>
				  	<?php $id_sub_2=$filasub_1['ID']; ?>
				    <?php $sql_2="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=". $id_sub_2.$orden;
					$submenu_2 = mysql_query( $sql_2, $conexion) or die(mysql_error());
					$totalRows_submenu_2 = mysql_num_rows($submenu_2);
					if ($totalRows_submenu_2 > 0){
					while($filasub_2=mysql_fetch_assoc($submenu_2)){ ?>
				    	<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub_2['ID']; ?>"><?php //echo $filasub_2['ID']; ?> <?php echo $filasub_2['DESCRIPCION']; ?> <?php //echo $filasub_2['NIVEL']; ?></a>
				  		<ul>
				    	<?php $id_sub_3=$filasub_2['ID']; ?>
				    	<?php $sql_3="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=".$id_sub_3.$orden;
						$submenu_3 = mysql_query( $sql_3, $conexion) or die(mysql_error());
						$totalRows_submenu_3 = mysql_num_rows($submenu_3);
						if ($totalRows_submenu_3 > 0){
						while($filasub_3=mysql_fetch_assoc($submenu_3)){ ?>
				    		<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub_3['ID']; ?>"><?php //echo $filasub_3['ID']; ?> <?php echo $filasub_3['DESCRIPCION']; ?> <?php //echo $filasub_3['NIVEL']; ?></a>
				   			<ul>
				      		<?php $id_sub_4=$filasub_3['ID']; ?>
				      		<?php $sql_4="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=".$id_sub_4.$orden;
							$submenu_4 = mysql_query( $sql_4, $conexion) or die(mysql_error());
							$totalRows_submenu_4 = mysql_num_rows($submenu_4);
							if ($totalRows_submenu_4 > 0){
							while($filasub_4=mysql_fetch_assoc($submenu_4)){ ?>
				      			<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub_4['ID']; ?>"><?php //echo $filasub_4['ID']; ?> <?php echo $filasub_4['DESCRIPCION']; ?> <?php //echo $filasub_4['NIVEL']; ?></a>
				     			<ul>
				        		<?php $id_sub_5=$filasub_4['ID']; ?>
				        		<?php $sql_5="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=".$id_sub_5.$orden;
								$submenu_5 = mysql_query( $sql_5, $conexion) or die(mysql_error());
								$totalRows_submenu_5 = mysql_num_rows($submenu_5);
								if ($totalRows_submenu_5 > 0){
								while($filasub_5=mysql_fetch_assoc($submenu_5)){ ?>
				        			<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub_5['ID']; ?>"><?php //echo $filasub_5['ID']; ?> <?php echo $filasub_5['DESCRIPCION']; ?> <?php //echo $filasub_5['NIVEL']; ?></a>
						        	<ul>
							    	<?php $id_sub_6=$filasub_5['ID']; ?>
							    	<?php $sql_6="SELECT ID, DESCRIPCION FROM " .$tabla. " WHERE ".$campo."=".$id_sub_6.$orden;
									$submenu_6 = mysql_query( $sql_6, $conexion) or die(mysql_error());
									$totalRows_submenu_6 = mysql_num_rows($submenu_6);
									if ($totalRows_submenu_6 > 0){
									while($filasub_6=mysql_fetch_assoc($submenu_6)){ ?>
							     		<li><a href="index.php?titulo_formulario=<?php echo $_GET['titulo_formulario'] ?>&id_grupo=<?php echo $filasub_6['ID']; ?>"><?php //echo $filasub_6['ID']; ?> <?php echo $filasub_6['DESCRIPCION']; ?> <?php //echo $filasub_6['NIVEL']; ?></a>
								   	    <?php } ?>
                                        <?php } ?>
				        			</ul>
                                    </li>
							    <?php } ?>
                                <?php } ?>
		  				      </ul>
                              </li>
						<?php } ?>
                        <?php } ?>
				      </ul>
                      </li>
								    <?php } ?>
                                    <?php } ?>
				  </ul></li>
								    <?php } ?>
                                    <?php } ?>
					
				        		</ul></li>

								   <?php } ?>
                                   <?php } ?>
			        			   </ul></li>
								   <?php } ?>
                                   <?php } ?>
                                </ul></li>
								   <?php } ?>
                                   <?php } ?>

				        </ul>
