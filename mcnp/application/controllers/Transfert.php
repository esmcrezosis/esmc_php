<?php
	function mettreaccents($phrase){
$tableau1 = array("&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Auml;", "&Aring;", "&Ccedil;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", "&Igrave;", "&Iacute;", "&Icirc;", "&Iuml;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Ugrave;", "&Uacute;", "&Ucirc;", "&Uuml;", "&agrave;", "&aacute;", "&acirc;", "&atilde;", "&auml;", "&aring;", "&ccedil;", "&egrave;", "&eacute;", "&ecirc;", "&euml;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&ugrave;", "&uacute;", "&ucirc;", "&uuml;");

$tableau2 = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");

$newphrase = str_replace($tableau1, $tableau2, $phrase);

//return $newphrase;
}
   


function enleveraccents($dest_fichier){
$dest_fichier = strtr($dest_fichier, '����������������������������������������������������/',
                                     'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy/');
//remplacer les caracteres autres que lettres, chiffres et point par _
$dest_fichier = preg_replace('/([^.a-z\/0-9]+)/i', '_', $dest_fichier);
return $dest_fichier;
}




function transfert_photo_bio($chemin,$file,$code_membre){
	
	// variables divers
	$details="";
	
	// petite variable qui permettra d'afficher les diff&eacute;rentes erreur dans notre formulaire
	$erreur="";
	
	// le formulaire a &eacute;t&eacute; valid&eacute;
	
		// on inclu notre class
		require_once("class.upload.php");
	
		// on contruit notre class
		// 1. on lui donne le chemin vers le r&eacute;pertoire de destination dans notre exemple c'est : '../fichiers/'
		// 2. on lui indique le nom de la balise INPUT FILE qui est 'MON_FICHIER_A_ENVOYER' (voir le formulaire)
		$obj = new upload($chemin.'/', $file);
		
		// D&eacute;claration des variables de la classe upload
		$obj->cl_taille_maxi = 104857600; // on attribut la taille maximum du fichier autoris&eacute;s (1 mo environ dans notre exemple)
		
		$obj->cl_extensions = array('.7z','.aiff','.asf','.avi','.bmp','.csv','.doc','.docx','.docx','.fla','.flv','.gif','.gz','.gzip','.jpeg','.jpg','.mid','.mov','.mp3','.mp4','.mpc','.mpeg','.mpg','.ods','.odt','.pdf','.png','.ppt','.pxd','.qt','.ram','.rar','.rm','.rmi','.rmvb','.rtf','.sdc','.sitd','.swf','.sxc','.sxw','.tar','.tgz','.tif','.tiff','.txt','.vsd','.wav','.wma','.wmv','.xls','.xlsx','.xml','.zip'); // on attribut les extensions autoris&eacute;es 
	
	//	$obj->cl_extensions = array('.gif','.jpg','.png','.jpeg'); // on attribut les extensions autoris&eacute;es 
	
		// on envoi le fichier grace � notre class
		if (!$obj->uploadFichier())
		{
			// on r&eacute;cup�re l'erreur en cas d'echec grace � notre class
			// et on l'affichera un peu plus bas dans notre code
			$erreur = $obj->affichageErreur();
		}
		else
		{
			// l'envoi c'est bien d&eacute;roul&eacute;, on confirme tout �a et on le laisse continuer
			// je met $erreur=""; pour pas faire vide mais on pourrais enlever le else
			// tout d&eacute;pend de votre programmation
			$erreur="";
	
			// on r&eacute;cup�re tous les d&eacute;tails de l'upload et on les affichera plus bas
			$details .= "<strong>Extension du fichier :</strong> ".$obj->cGetExtension()."<br />";
			$details .= "<strong>Nom du fichier avec extension :</strong> ".$obj->cGetNameFile()."<br />";
			$details .= "<strong>Nom du fichier sans extension :</strong> ".$obj->cGetNameFile(false)."<br />";
			$details .= "<strong>Nom du fichier final avec extension :</strong> ".$obj->cGetNameFileFinal()."<br />";
			$details .= "<strong>Nom du fichier final sans extension :</strong> ".$obj->cGetNameFileFinal(false)."<br />";
			$details .= "<strong>Taille du fichier en octet :</strong> ".$obj->cGetSizeFile()." Octets<br />";
			$details .= "<strong>Taille du fichier en kilo-octet :</strong> ".$obj->cGetSizeFile(2)." Ko<br />";
			$details .= "<strong>Taille du fichier en m&eacute;ga-octet :</strong> ".$obj->cGetSizeFile(3)." Mo<br />";
			$details .= "<strong>Chemin vers le r&eacute;pertoire de destination :</strong> ".$obj->cGetFolder()."<br />";
			$details .= "<strong>Chemin du r&eacute;pertoire temporaire :</strong> ".$obj->cGetNameTemp()."<br />";
			$details .= "<strong>Type de fichier :</strong> ".$obj->cGetTypeFile()."<br />";
		}
	
	
	
	$file = $obj->cGetNameFile();
	
	
	
	
		$parties=pathinfo($chemin."/".$file);
		$repp= $parties["dirname"];
		$fic= $parties["basename"];
		$ext= $parties["extension"];
		$name= basename($parties["basename"],".".$parties["extension"]);
	
		$file2 = enleveraccents($code_membre).".".$ext;

		rename($chemin."/".$file,$chemin."/".$file2);
	
		return $file2;
	
	}

function transfert($chemin,$file){

// variables divers
$details="";

// petite variable qui permettra d'afficher les diff&eacute;rentes erreur dans notre formulaire
$erreur="";

// le formulaire a &eacute;t&eacute; valid&eacute;

	// on inclu notre class
	require_once("class.upload.php");

	// on contruit notre class
	// 1. on lui donne le chemin vers le r&eacute;pertoire de destination dans notre exemple c'est : '../fichiers/'
	// 2. on lui indique le nom de la balise INPUT FILE qui est 'MON_FICHIER_A_ENVOYER' (voir le formulaire)
	$obj = new upload($chemin.'/', $file);
	
	// D&eacute;claration des variables de la classe upload
	$obj->cl_taille_maxi = 104857600; // on attribut la taille maximum du fichier autoris&eacute;s (1 mo environ dans notre exemple)
	
	$obj->cl_extensions = array('.7z','.aiff','.asf','.avi','.bmp','.csv','.doc','.docx','.docx','.fla','.flv','.gif','.gz','.gzip','.jpeg','.jpg','.mid','.mov','.mp3','.mp4','.mpc','.mpeg','.mpg','.ods','.odt','.pdf','.png','.ppt','.pxd','.qt','.ram','.rar','.rm','.rmi','.rmvb','.rtf','.sdc','.sitd','.swf','.sxc','.sxw','.tar','.tgz','.tif','.tiff','.txt','.vsd','.wav','.wma','.wmv','.xls','.xlsx','.xml','.zip'); // on attribut les extensions autoris&eacute;es 

//	$obj->cl_extensions = array('.gif','.jpg','.png','.jpeg'); // on attribut les extensions autoris&eacute;es 

	// on envoi le fichier grace � notre class
	if (!$obj->uploadFichier())
	{
		// on r&eacute;cup�re l'erreur en cas d'echec grace � notre class
		// et on l'affichera un peu plus bas dans notre code
		$erreur = $obj->affichageErreur();
	}
	else
	{
		// l'envoi c'est bien d&eacute;roul&eacute;, on confirme tout �a et on le laisse continuer
		// je met $erreur=""; pour pas faire vide mais on pourrais enlever le else
		// tout d&eacute;pend de votre programmation
		$erreur="";

		// on r&eacute;cup�re tous les d&eacute;tails de l'upload et on les affichera plus bas
		$details .= "<strong>Extension du fichier :</strong> ".$obj->cGetExtension()."<br />";
		$details .= "<strong>Nom du fichier avec extension :</strong> ".$obj->cGetNameFile()."<br />";
		$details .= "<strong>Nom du fichier sans extension :</strong> ".$obj->cGetNameFile(false)."<br />";
		$details .= "<strong>Nom du fichier final avec extension :</strong> ".$obj->cGetNameFileFinal()."<br />";
		$details .= "<strong>Nom du fichier final sans extension :</strong> ".$obj->cGetNameFileFinal(false)."<br />";
		$details .= "<strong>Taille du fichier en octet :</strong> ".$obj->cGetSizeFile()." Octets<br />";
		$details .= "<strong>Taille du fichier en kilo-octet :</strong> ".$obj->cGetSizeFile(2)." Ko<br />";
		$details .= "<strong>Taille du fichier en m&eacute;ga-octet :</strong> ".$obj->cGetSizeFile(3)." Mo<br />";
		$details .= "<strong>Chemin vers le r&eacute;pertoire de destination :</strong> ".$obj->cGetFolder()."<br />";
		$details .= "<strong>Chemin du r&eacute;pertoire temporaire :</strong> ".$obj->cGetNameTemp()."<br />";
		$details .= "<strong>Type de fichier :</strong> ".$obj->cGetTypeFile()."<br />";
	}



$file = $obj->cGetNameFile();




	$parties=pathinfo($chemin."/".$file);
	$repp= $parties["dirname"];
	$fic= $parties["basename"];
	$ext= $parties["extension"];
	$name= basename($parties["basename"],".".$parties["extension"]);

	$file2 = "MCNP-".date('dmYHis')."-".enleveraccents($name).".".$ext;

	rename($chemin."/".$file,$chemin."/".$file2);

	return $file2;

}

function lettre($nb, $alaligne) {

$chiffre[1]="un";
$chiffre[2]="deux";
$chiffre[3]="trois";
$chiffre[4]="quatre";
$chiffre[5]="cinq";
$chiffre[6]="six";
$chiffre[7]="sept";
$chiffre[8]="huit";
$chiffre[9]="neuf";
$chiffre[10]="dix";
$chiffre[11]="onze";
$chiffre[12]="douze";
$chiffre[13]="treize";
$chiffre[14]="quatorze";
$chiffre[15]="quinze";
$chiffre[16]="seize";
$chiffre[17]="dix-sept";
$chiffre[18]="dix-huit";
$chiffre[19]="dix-neuf";

$dizaine[1]="dix";
$dizaine[2]="vingt";
$dizaine[3]="trente";
$dizaine[4]="quarante";
$dizaine[5]="cinquante";
$dizaine[6]="soixante";
$dizaine[8]="quatre-vingt";

if ($nb >= 1) {
$resultat = "";




$varnum = intval($nb / 1000000000);
if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= $varlet . " milliard";
if ($varlet != "un") {$resultat .= "s";}

}


//$varnum = intval($nb) % 1000000000;
//$varnum = intval($varnum / 1000000);

$nb1 = floor($nb);
$nb2 = strval($nb1);
$size = strlen($nb2);
if($size > 9){
$varnum = intval(substr($nb2, $size - 9, -6));
}else{
$varnum = intval($nb / 1000000);
}






if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

if ($varlet != "un") {$resultat .= " " . $varlet;}

$resultat .= " million";
if ($varlet != "un") {$resultat .= "s";}

}





$nb1 = floor($nb);
$nb2 = strval($nb1);
$size = strlen($nb2);
if($size > 9){
$varnum = intval(substr($nb2, $size - 6, -3));
}else{
$varnum = intval($nb) % 1000000;
$varnum = intval($varnum / 1000);
}


if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);


if ($varlet != "un") {$resultat .= " " . $varlet;}
$resultat .= " mille";
}

//$varnum = intval($nb) % 1000;
$nb1 = floor($nb);
$nb2 = strval($nb1);
$size = strlen($nb2);

if($size > 9){
$varnum = intval(substr($nb2, -3));
}else{
$varnum = intval($nb) % 1000;
}


if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= " " . $varlet;
}
$resultat = ltrim($resultat);

if (strstr($varlet,"cent"))  {$resultat .= "s";}
if (strstr($varlet,"ingt"))  {$resultat .= "s";}
if (strstr($varlet,"lion"))  {$resultat .= " de";}
if (strstr($varlet,"ions"))  {$resultat .= " de";}
if (strstr($varlet,"liard"))  {$resultat .= " de";}
if (strstr($varlet,"iard"))  {$resultat .= " de";}

$resultat .= " franc";
if ($nb >= 2) {$resultat .= "s";}


$varnum = intval(($nb - intval($nb)) * 100);

 if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= " et " . $varlet . " centime";
if ($varnum > 1) {$resultat .= "s";}
} 

} else {
$resultat = "z&eacute;ro";
}

$resultat = str_ireplace("sss", "s", $resultat);
$resultat = str_ireplace("ss", "s", $resultat);
$resultat = str_ireplace("xs", "x", $resultat);

$tab = explode(" ", $resultat);
if($tab[0] == "milliard" || $tab[0] == "million"){
$resultat = "un ".$resultat;
	}

$resultat = ucfirst($resultat);

if($alaligne > 0 && $alaligne < strlen($resultat)){
$partie = substr($resultat, 0, $alaligne);
$position = strripos($partie, " ");

$partie1 = substr($resultat, 0, $position + 1);
$partie2 = substr($resultat, $position + 1);

$resultat = $partie1."<br>".$partie2;
}
	return $resultat;
}





function lettre1($nb) {

$chiffre[1]="un";
$chiffre[2]="deux";
$chiffre[3]="trois";
$chiffre[4]="quatre";
$chiffre[5]="cinq";
$chiffre[6]="six";
$chiffre[7]="sept";
$chiffre[8]="huit";
$chiffre[9]="neuf";
$chiffre[10]="dix";
$chiffre[11]="onze";
$chiffre[12]="douze";
$chiffre[13]="treize";
$chiffre[14]="quatorze";
$chiffre[15]="quinze";
$chiffre[16]="seize";
$chiffre[17]="dix-sept";
$chiffre[18]="dix-huit";
$chiffre[19]="dix-neuf";

$dizaine[1]="dix";
$dizaine[2]="vingt";
$dizaine[3]="trente";
$dizaine[4]="quarante";
$dizaine[5]="cinquante";
$dizaine[6]="soixante";
$dizaine[8]="quatre-vingt";

if ($nb >= 1) {
$resultat = "";
} else {
$resultat = "z&eacute;ro";
}

$varnum = intval($nb / 1000000);
if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat = $varlet . " million";
if ($varlet != "un") {$resultat .= "s";}
}

$varnum = intval($nb) % 1000000;
$varnum = intval($varnum / 1000);
if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

if ($varlet != "un") {$resultat .= " " . $varlet;}
$resultat .= " mille";
}

$varnum = intval($nb) % 1000;
if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= " " . $varlet;
}
$resultat = ltrim($resultat);

if (strstr($varlet,"cent"))  {$resultat .= "s";}
if (strstr($varlet,"ingt"))  {$resultat .= "s";}
if (strstr($varlet,"lion"))  {$resultat .= " de";}
if (strstr($varlet,"ions"))  {$resultat .= " de";}

$resultat .= " franc";
if ($nb >= 2) {$resultat .= "s";}

$varnum = intval(($nb - intval($nb)) * 100);

 if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= " et " . $varlet . " centime";
if ($varnum > 1) {$resultat .= "s";}
} 

$resultat = ucfirst($resultat);

//echo $resultat;
	return $resultat;
}




function lettre2($nb, $alaligne) {

$chiffre[1]="un";
$chiffre[2]="deux";
$chiffre[3]="trois";
$chiffre[4]="quatre";
$chiffre[5]="cinq";
$chiffre[6]="six";
$chiffre[7]="sept";
$chiffre[8]="huit";
$chiffre[9]="neuf";
$chiffre[10]="dix";
$chiffre[11]="onze";
$chiffre[12]="douze";
$chiffre[13]="treize";
$chiffre[14]="quatorze";
$chiffre[15]="quinze";
$chiffre[16]="seize";
$chiffre[17]="dix-sept";
$chiffre[18]="dix-huit";
$chiffre[19]="dix-neuf";

$dizaine[1]="dix";
$dizaine[2]="vingt";
$dizaine[3]="trente";
$dizaine[4]="quarante";
$dizaine[5]="cinquante";
$dizaine[6]="soixante";
$dizaine[8]="quatre-vingt";

if ($nb >= 1) {
$resultat = "";




$varnum = intval($nb / 1000000000);
if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= $varlet . " milliard";
if ($varlet != "un") {$resultat .= "s";}

}


//$varnum = intval($nb) % 1000000000;
//$varnum = intval($varnum / 1000000);

$nb1 = floor($nb);
$nb2 = strval($nb1);
$size = strlen($nb2);
if($size > 9){
$varnum = intval(substr($nb2, $size - 9, -6));
}else{
$varnum = intval($nb / 1000000);
}






if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

//if ($varlet != "un") {$resultat .= " " . $varlet;}
$resultat .= " " . $varlet;

$resultat .= " million";
if ($varlet != "un") {$resultat .= "s";}

}





$nb1 = floor($nb);
$nb2 = strval($nb1);
$size = strlen($nb2);
if($size > 9){
$varnum = intval(substr($nb2, $size - 6, -3));
}else{
$varnum = intval($nb) % 1000000;
$varnum = intval($varnum / 1000);
}


if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);


if ($varlet != "un") {$resultat .= " " . $varlet;}
$resultat .= " mille";
}

//$varnum = intval($nb) % 1000;
$nb1 = floor($nb);
$nb2 = strval($nb1);
$size = strlen($nb2);

if($size > 9){
$varnum = intval(substr($nb2, -3));
}else{
$varnum = intval($nb) % 1000;
}


if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);

$resultat .= " " . $varlet;
}
$resultat = ltrim($resultat);

if (strstr($varlet,"cent"))  {$resultat .= "s";}
if (strstr($varlet,"ingt"))  {$resultat .= "s";}
if (strstr($varlet,"lion"))  {$resultat .= " de";}
if (strstr($varlet,"ions"))  {$resultat .= " de";}
if (strstr($varlet,"liard"))  {$resultat .= " de";}
if (strstr($varlet,"iard"))  {$resultat .= " de";}

$resultat .= " Bons d&rsquo;Achat";
if ($nb >= 2) {$resultat .= "s";}


$varnum = intval(($nb - intval($nb)) * 100);

 if ($varnum > 0) {

$varlet = "";
if ($varnum >= 100) {
$varlet = $chiffre[intval($varnum / 100)];
$varnum = $varnum % 100;
if ($varlet == "un") 
{$varlet = "cent "; }
else 
{$varlet .= " cent ";}
}
if ($varnum <= 19) {
    if ($varnum > 0) {$varlet .= $chiffre[$varnum];}
} 
else {
$varnumd = intval($varnum / 10);
$varnumu = $varnum % 10;
switch ($varnumd) {
case 1: $varlet .= $dizaine[1]; break;
case 2: $varlet .= $dizaine[2]; break;
case 3: $varlet .= $dizaine[3]; break;
case 4: $varlet .= $dizaine[4]; break;
case 5: $varlet .= $dizaine[5]; break;
case 6: $varlet .= $dizaine[6]; break;
case 7: $varlet .= $dizaine[6]; break;
case 8: $varlet .= $dizaine[8]; break;
case 9: $varlet .= $dizaine[8]; break;
}
if ($varnumu == 1 && $varnumd < 8) {
$varlet .= " et ";
} else {
if ($varnumu != 0 || $varnumd == 7 || $varnumd == 9) {$varlet .= "-";}
}
if ($varnumd == 7 || $varnumd == 9) {$varnumu += 10;}
if ($varnumu != 0) {$varlet .= $chiffre[$varnumu];}
}
$varlet = trim($varlet);


$resultat .= " et " . $varlet . " centime";
if ($varnum > 1) {$resultat .= "s";}
} 

} else {
$resultat = "z&eacute;ro";
}

$resultat = str_ireplace("sss", "s", $resultat);
$resultat = str_ireplace("ss", "s", $resultat);
$resultat = str_ireplace("xs", "x", $resultat);

$tab = explode(" ", $resultat);
if($tab[0] == "milliard" || $tab[0] == "million"){
$resultat = "un ".$resultat;
	}

$resultat = ucfirst($resultat);

if($alaligne > 0 && $alaligne < strlen($resultat)){
$partie = substr($resultat, 0, $alaligne);
$position = strripos($partie, " ");

$partie1 = substr($resultat, 0, $position + 1);
$partie2 = substr($resultat, $position + 1);

$resultat = $partie1."<br>".$partie2;
}
	return $resultat;
}


