<?php 
function lettre($nb) {

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

echo $resultat;
}
?>
