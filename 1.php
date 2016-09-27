<?php
include('lib.php');
$db = new Database_pro; $con = $db->conecta();
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if ($action == 'ajax') {
	$puntero = (isset($_REQUEST['puntero']) && !empty($_REQUEST['puntero']))?$_REQUEST['puntero']:1;
	$query = pg_query($con, "select nom_pro, det_pro, producto.med, medida.med from producto, medida where id_pro=$puntero and producto.med = medida.id_med");
	while ($var = pg_fetch_row($query)) {
		$nom_pro = $var[0]; $det_pro = $var[1];
		$id_med  = $var[2]; $med     = $var[3];
	}
	print "<input type='text' value='".$puntero."' hidden name='id_pro' id='id_pro'>";
	print "<div class='form-group'>";
	print "<b>Producto</b> ";
	print "<input type='text' value='".$nom_pro."' name='nom_pro' id='nom_pro' class='form-control' required>";
	print "</div>";
	print "<div class='form-group'>";
	print "<b>Detalle</b> ";
	print "<input type='text' value='".$det_pro."' name='det_pro' id='det_pro' class='form-control' required>";
	print "</div>";
	print "<div class='form-group'>";
	print "<b>Medida</b> ";
	print "<select name='med' id='med' class='form-control'>
		    	<option value='".$id_med."'>'".$med."'</option>
		   </select> ";
	print "</div>";
}

if ($action == 'eliminar') {
	$puntero = (isset($_REQUEST['puntero']) && !empty($_REQUEST['puntero']))?$_REQUEST['puntero']:1;
	$query = pg_query($con,"delete from producto where id_pro=$puntero");
}

if ($action == 'modificar') {
	$id_pro = (isset($_REQUEST['id_pro']) && !empty($_REQUEST['id_pro']))?$_REQUEST['id_pro']:1;
	$nom_pro = (isset($_REQUEST['nom_pro']) && !empty($_REQUEST['nom_pro']))?$_REQUEST['nom_pro']:1;
	$det_pro = (isset($_REQUEST['det_pro']) && !empty($_REQUEST['det_pro']))?$_REQUEST['det_pro']:1;
	$id_med = (isset($_REQUEST['id_med']) && !empty($_REQUEST['id_med']))?$_REQUEST['id_med']:1;
	// print "<br>".$id_pro."<br>".$nom_pro."<br>".$det_pro."<br>".$id_med;
	$query = pg_query($con,"update producto SET nom_pro = '$nom_pro', det_pro = '$det_pro', med = $id_med where id_pro = $id_pro");
	// print $query;
}

if ($action == 'agregar') {
	$nom_pro = (isset($_REQUEST['nom_pro']) && !empty($_REQUEST['nom_pro']))?$_REQUEST['nom_pro']:1;
	$det_pro = (isset($_REQUEST['det_pro']) && !empty($_REQUEST['det_pro']))?$_REQUEST['det_pro']:1;
	$med     = (isset($_REQUEST['med']) && !empty($_REQUEST['med']))?$_REQUEST['med']:1;

	$query = pg_query($con, "insert into producto(nom_pro,det_pro,med) values ('$nom_pro', '$det_pro', $med)");
	
}

if ($action == 'hist1') {
	$b64 =     (isset($_REQUEST['b64']) && !empty($_REQUEST['b64']))?$_REQUEST['b64']:1;
	$nom_pac = (isset($_REQUEST['nom_pac']) && !empty($_REQUEST['nom_pac']))?$_REQUEST['nom_pac']:1;
	$ape_pac = (isset($_REQUEST['ape_pac']) && !empty($_REQUEST['ape_pac']))?$_REQUEST['ape_pac']:1;
	$tp_ced =  (isset($_REQUEST['tp_ced']) && !empty($_REQUEST['tp_ced']))?$_REQUEST['tp_ced']:1;
	$ced_pac = (isset($_REQUEST['ced_pac']) && !empty($_REQUEST['ced_pac']))?$_REQUEST['ced_pac']:1;
	$ced = $tp_ced."-".$ced_pac;
	$fh_nac =  (isset($_REQUEST['fh_nac']) && !empty($_REQUEST['fh_nac']))?$_REQUEST['fh_nac']:1;
	$edad =    (isset($_REQUEST['edad']) && !empty($_REQUEST['edad']))?$_REQUEST['edad']:1;
	$gen = 	   (isset($_REQUEST['gen']) && !empty($_REQUEST['gen']))?$_REQUEST['gen']:1;
	$tlf =     (isset($_REQUEST['tlf']) && !empty($_REQUEST['tlf']))?$_REQUEST['tlf']:1;
	$direcc =  (isset($_REQUEST['direcc']) && !empty($_REQUEST['direcc']))?$_REQUEST['direcc']:1;
	$esp =     (isset($_REQUEST['esp']) && !empty($_REQUEST['esp']))?$_REQUEST['esp']:1;
	$tra =     (isset($_REQUEST['tra']) && !empty($_REQUEST['tra']))?$_REQUEST['tra']:1;

	$sql="insert into paciente(nom_pac, ape_pac, ced_pac, fh_nac, direcc, edad, gen, tlf, esp, tra)
					values('$nom_pac','$ape_pac','$ced',to_date('$fh_nac','dd-mm-yyyy'),'$direcc',$edad,'$gen','$tlf',$esp,'$tra')";
	$query = pg_query($con,$sql);
}

if ($action == 'trat') {
	print (isset($_REQUEST['fh_trat']) && !empty($_REQUEST['fh_trat']))?$_REQUEST['fh_trat']:1;
	print (isset($_REQUEST['tit_trat']) && !empty($_REQUEST['tit_trat']))?$_REQUEST['tit_trat']:1;
	print (isset($_REQUEST['trat']) && !empty($_REQUEST['trat']))?$_REQUEST['trat']:1;
}

// $sql = "WITH doble AS 
// (INSERT INTO producto(nom_pro,det_pro,med) 
// VALUES ('$nom_pro','$det_pro',$med) returning id_pro )
// INSERT INTO inventario(id_pro, exis)
// VALUES ((select id_pro from doble), $exis)";

// $sql = "WITH doble AS 
// (INSERT INTO producto(nom_pro,det_pro,med) 
// VALUES ('$nom_pro','$det_pro',$med) returning id_pro )
// INSERT INTO inventario(id_pro, exis)
// VALUES ((select id_pro from doble), $exis)";

// $sql = "WITH doble AS
// 		(DELETE FROM inventario WHERE id_pro = $id_pro returning id_pro)
// 		DELETE FROM producto WHERE id_pro = (select id_pro from doble)";
?>