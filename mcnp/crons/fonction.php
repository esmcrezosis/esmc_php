<?php

function moisfr ($mois) {
switch($mois) { 
    case '01': $mois = 'Janvier'; break; 
    case '02': $mois = 'Fevrier'; break; 
    case '03': $mois = 'Mars'; break; 
    case '04': $mois = 'Avril'; break; 
    case '05': $mois = 'Mai'; break; 
    case '06': $mois = 'Juin'; break; 
    case '07': $mois = 'Juillet'; break; 
    case '08': $mois = "Ao&ucirc;t"; break; 
    case '09': $mois = "Septembre"; break; 
    case '10': $mois = 'Octobre'; break; 
    case '11': $mois = 'Novembre'; break; 
    case '12': $mois = 'D&eacute;cembre'; break; 
  } 
  
  return $mois;
}

function moisfr2 ($mois) {
switch($mois) { 
    case '01': $mois = 'Jan'; break; 
    case '02': $mois = 'Fev'; break; 
    case '03': $mois = 'Mars'; break; 
    case '04': $mois = 'Avril'; break; 
    case '05': $mois = 'Mai'; break; 
    case '06': $mois = 'Juin'; break; 
    case '07': $mois = 'Juil'; break; 
    case '08': $mois = "Ao&ucirc;t"; break; 
    case '09': $mois = "Sept"; break; 
    case '10': $mois = 'Oct'; break; 
    case '11': $mois = 'Nov'; break; 
    case '12': $mois = 'D&eacute;c'; break; 
  } 
  
  return $mois;
}

function moisfraccent ($mois) {
switch($mois) { 
    case '01': $mois = 'Janvier'; break; 
    case '02': $mois = 'Fevrier'; break; 
    case '03': $mois = 'Mars'; break; 
    case '04': $mois = 'Avril'; break; 
    case '05': $mois = 'Mai'; break; 
    case '06': $mois = 'Juin'; break; 
    case '07': $mois = 'Juillet'; break; 
    case '08': $mois = "Août"; break; 
    case '09': $mois = "Septembre"; break; 
    case '10': $mois = 'Octobre'; break; 
    case '11': $mois = 'Novembre'; break; 
    case '12': $mois = 'Décembre'; break; 
  } 
  
  return $mois;
}
function datefr($date) {
	$annee=substr($date, 0, 4);
	$mois=substr($date, 5, 2);
	$jour=substr($date, 8, 2);
	$date=$jour." ".moisfr($mois)." ".$annee;
	return($date);
}

function datefr2($date) {
	$annee=substr($date, 0, 4);
	$mois=substr($date, 5, 2);
	$jour=substr($date, 8, 2);
	$date=$jour." ".moisfr2($mois)." ".$annee;
	return($date);
}
function datefr4($date) {
    $annee=substr($date, 0, 4);
    $mois=substr($date, 5, 2);
    $jour=substr($date, 8, 2);
    $date=$jour." ".moisfraccent($mois)." ".$annee;
    return($date);
}
function datefr3($date) {
	$annee=substr($date, 0, 4);
	$mois=substr($date, 5, 2);
	$jour=substr($date, 8, 2);
	$date=$jour." ".moisfr2($mois);
	return($date);
}

function jourfr($date) {
	$annee=substr($date, 0, 4);
	$mois=substr($date, 5, 2);
	$jour=substr($date, 8, 2);
	
	$heure=substr($date, 11, 2);
	$minute=substr($date, 14, 2);
	$seconde=substr($date, 17, 2);

	$date=$jour." à ".$heure."h".$minute;
	//$date="Le ".$jour." à ".$heure.":".$minute.":".$seconde;
	return($date);
}

function datejourfr($date) {
	$annee=substr($date, 0, 4);
	$mois=substr($date, 5, 2);
	$jour=substr($date, 8, 2);
	
	$heure=substr($date, 11, 2);
	$minute=substr($date, 14, 2);
	$seconde=substr($date, 17, 2);

	$date=$jour." ".moisfr($mois)." ".$annee." à ".$heure."H".$minute;
	//$date="Le ".$jour." à ".$heure.":".$minute.":".$seconde;
	return($date);
}

function datejourfr2($date) {
    $annee=substr($date, 0, 4);
    $mois=substr($date, 5, 2);
    $jour=substr($date, 8, 2);
    
    $heure=substr($date, 11, 2);
    $minute=substr($date, 14, 2);
    $seconde=substr($date, 17, 2);

    $date=$jour." ".moisfraccent($mois)." ".$annee." à ".$heure."H".$minute;
    //$date="Le ".$jour." à ".$heure.":".$minute.":".$seconde;
    return($date);
}
function moisen ($mois) {
switch($mois) { 
    case '01': $mois = 'January'; break; 
    case '02': $mois = 'February'; break; 
    case '03': $mois = 'March'; break; 
    case '04': $mois = 'April'; break; 
    case '05': $mois = 'May'; break; 
    case '06': $mois = 'June'; break; 
    case '07': $mois = 'July'; break; 
    case '08': $mois = "August"; break; 
    case '09': $mois = "September"; break; 
    case '10': $mois = 'October'; break; 
    case '11': $mois = 'November'; break; 
    case '12': $mois = 'December'; break; 
  } 
  
  return $mois;
}

function moisen2 ($mois) {
switch($mois) { 
    case '01': $mois = 'Jan'; break; 
    case '02': $mois = 'Feb'; break; 
    case '03': $mois = 'Mar'; break; 
    case '04': $mois = 'Apr'; break; 
    case '05': $mois = 'May'; break; 
    case '06': $mois = 'Jun'; break; 
    case '07': $mois = 'Jul'; break; 
    case '08': $mois = 'Aug'; break; 
    case '09': $mois = 'Sep'; break; 
    case '10': $mois = 'Oct'; break; 
    case '11': $mois = 'Nov'; break; 
    case '12': $mois = 'Dec'; break; 
  } 
  
  return $mois;
}

function dateen($date)
{
	$annee=substr($date, 0, 4);
	$mois=substr($date, 5, 2);
	$jour=substr($date, 8, 2);
	$date=$mois." ".$jour.", ".$annee;
	return($date);
}



function ajoutezero($numero)
{
if(strlen($numero) == 1){
	$numero = "0000".$numero;
}else if(strlen($numero) == 2){
	$numero = "000".$numero;
}else if(strlen($numero) == 3){
	$numero = "00".$numero;
}else if(strlen($numero) == 4){
	$numero = "0".$numero;
	}
	return $numero;
}

function ajoute1zero($numero)
{
if(strlen($numero) == 1){
	$numero = "0".$numero;
	}
	return $numero;
}


function date_fr_en($date)
{
	$date = date('Y-m-d', ($date - 25569) * 24 * 60 * 60);
	
	/*$datee=explode("/", $date);
	$annee=$datee[2];
	$mois=$datee[1];
	$jour=$datee[0];

	$date=$annee."-".$mois."-".$jour;*/
	return($date);
}

function date_fr_en3($date)
{	
	$datee=explode("/", $date);
	$annee=trim($datee[2]);
	$mois=trim($datee[1]);
	$jour=trim($datee[0]);

	$date=$annee."-".$mois."-".$jour;
	return($date);
}

function date_fr_en2($date)
{
	$datee=explode("-", $date);
	$annee=trim($datee[2]);
	$mois=trim($datee[1]);
	$jour=trim($datee[0]);
	
	
switch($mois) { 
    case 'Jan': $mois = '01'; break; 
    case 'Feb': $mois = '02'; break; 
    case 'Mar': $mois = '03'; break; 
    case 'Apr': $mois = '04'; break; 
    case 'May': $mois = '05'; break; 
    case 'Jun': $mois = '06'; break; 
    case 'Jul': $mois = '07'; break; 
    case 'Aug': $mois = '08'; break; 
    case 'Sep': $mois = '09'; break; 
    case 'Oct': $mois = '10'; break; 
    case 'Nov': $mois = '11'; break; 
    case 'Dec': $mois = '12'; break; 
  } 
		
	$date=$annee."-".$mois."-".$jour;
	return($date);
}


function verif_img($name)
{
$path_parts = pathinfo($name);

$dirname = $path_parts['dirname'];
$basename = $path_parts['basename'];
$extension = $path_parts['extension'];
$filename = $path_parts['filename']; 

if($extension == "jpg" || $extension == "JPG" || $extension == "jpeg" || $extension == "JPEG" || $extension == "png" || $extension == "PNG" || $extension == "pdf" || $extension == "PDF"){
	return 1;
	}else{
	return 0;
		}
}



function libelletypebon($type)
{
switch ($type) {
    case "BAn":
        echo "Bon d'Achat neutre";
        break;
    case "BA":
        echo "Bon d'Achat";
        break;
    case "BCr":
        echo "Bon de Consommation récurrent";
        break;
    case "BCnr":
        echo "Bon de Consommation non récurrent";
        break;
    case "BC":
        echo "Bon de Commande";
        break;
    case "BL":
        echo "Bon de Livraison";
        break;
    case "BS":
        echo "Bon de Salaire";
        break;
}
}



function joursemaine($nombre)
{
switch($nombre) { 
    case 1: $nombre = 'Lundi'; break; 
    case 2: $nombre = 'Mardi'; break; 
    case 3: $nombre = 'Mercredi'; break; 
    case 4: $nombre = 'Jeudi'; break; 
    case 5: $nombre = 'Vendredi'; break; 
    case 6: $nombre = 'Samedi'; break; 
    case 7: $nombre = 'Dimanche'; break; 
  } 
        return($nombre);
}


function telephonecompagnie2($pays, $numero)
{
$telephonie = "";
if($pays == 228){

if (strlen($numero) == 8) {

    $nombre = substr($numero, 0, 3);

    switch($nombre) { 

    case 222: $telephonie = 'ILLICO'; break; 
    case 223: $telephonie = 'ILLICO'; break; 
    case 224: $telephonie = 'ILLICO'; break; 
    case 225: $telephonie = 'ILLICO'; break; 
    case 226: $telephonie = 'ILLICO'; break; 
    case 227: $telephonie = 'ILLICO'; break; 
    case 232: $telephonie = 'ILLICO'; break; 
    case 233: $telephonie = 'ILLICO'; break; 
    case 244: $telephonie = 'ILLICO'; break; 
    case 255: $telephonie = 'ILLICO'; break; 
    case 266: $telephonie = 'ILLICO'; break; 
    case 277: $telephonie = 'ILLICO'; break; 

    case 900: $telephonie = 'TOGOCEL'; break;
    case 901: $telephonie = 'TOGOCEL'; break;
    case 902: $telephonie = 'TOGOCEL'; break;
    case 903: $telephonie = 'TOGOCEL'; break;
    case 907: $telephonie = 'TOGOCEL'; break;
    case 908: $telephonie = 'TOGOCEL'; break;
    case 909: $telephonie = 'TOGOCEL'; break;
    case 914: $telephonie = 'TOGOCEL'; break;
    case 916: $telephonie = 'TOGOCEL'; break;
    case 917: $telephonie = 'TOGOCEL'; break;
    case 918: $telephonie = 'TOGOCEL'; break;
    case 919: $telephonie = 'TOGOCEL'; break;
    case 911: $telephonie = 'TOGOCEL'; break;
    case 912: $telephonie = 'TOGOCEL'; break;
    case 913: $telephonie = 'TOGOCEL'; break;
    case 915: $telephonie = 'TOGOCEL'; break;
    case 922: $telephonie = 'TOGOCEL'; break;
    case 923: $telephonie = 'TOGOCEL'; break;
    case 924: $telephonie = 'TOGOCEL'; break;
    case 925: $telephonie = 'TOGOCEL'; break;
    case 926: $telephonie = 'TOGOCEL'; break;

    case 981: $telephonie = 'MOOV'; break;
    case 982: $telephonie = 'MOOV'; break;
    case 983: $telephonie = 'MOOV'; break;
    case 985: $telephonie = 'MOOV'; break;
    case 980: $telephonie = 'MOOV'; break;
    case 984: $telephonie = 'MOOV'; break;
    case 986: $telephonie = 'MOOV'; break;
    case 987: $telephonie = 'MOOV'; break;
    case 992: $telephonie = 'MOOV'; break;
    case 993: $telephonie = 'MOOV'; break;
    case 990: $telephonie = 'MOOV'; break;
    case 991: $telephonie = 'MOOV'; break;
    case 994: $telephonie = 'MOOV'; break;
    case 995: $telephonie = 'MOOV'; break;
    case 996: $telephonie = 'MOOV'; break;

  } 

} else {
    $telephonie = 1;
}


}else{
$telephonie = "AUTRES";
}

        return($telephonie);
}




function telephonecompagnie($pays, $numero)
{
$telephonie = "";
if($pays == 228){

if (strlen($numero) == 8) {

    $nombre = substr($numero, 0, 2);

    switch($nombre) { 

    case 22: $telephonie = 'ILLICO'; break; 
    case 23: $telephonie = 'ILLICO'; break; 
    case 24: $telephonie = 'ILLICO'; break; 
    case 25: $telephonie = 'ILLICO'; break; 
    case 26: $telephonie = 'ILLICO'; break; 
    case 27: $telephonie = 'ILLICO'; break; 

    case 90: $telephonie = 'TOGOCEL'; break;
    case 91: $telephonie = 'TOGOCEL'; break;
    case 92: $telephonie = 'TOGOCEL'; break;
    case 93: $telephonie = 'TOGOCEL'; break;
    case 94: $telephonie = 'TOGOCEL'; break;
    
    case 95: $telephonie = 'MOOV'; break;
    case 96: $telephonie = 'MOOV'; break;
    case 97: $telephonie = 'MOOV'; break;
    case 98: $telephonie = 'MOOV'; break;
    case 99: $telephonie = 'MOOV'; break;

  } 

} else {
    $telephonie = 1;
}


}else{
$telephonie = "AUTRES";
}

        return($telephonie);
}

