<?php

//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratsuitenext2 extends Zend_Pdf_Page {
   //variables de classe
   //position x du curseur
   private $_yPosition;
   //position y du curseur
   private $_xPosition;
   //marge à gauche
   private $_leftMargin;
   //marge à droite
   private $_rightMargin;
 
   //police normale
   private $_normalFont;
   //police bold
   private $_boldFont;
 
    public function  __construct($param1, $param2 = null, $param3 = null) {
		parent::__construct($param1, $param2, $param3);
		//à savoir: l'origine de la page démarre en bas à gauche !!!
		$this->_yPosition = $this->getHeight() - 50;
		$this->_xPosition = 50;
		$this->_leftMargin = 50;
		$this->_rightMargin = $this->getWidth() - 50;
 
		//définition des polices qui seront utilisées sur la page
		$this->_normalFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		$this->_boldFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
 
		//$this->createStyle();
		$this->setFooter();
    }
    
    
    public function createStyle()  {
		//création d'un style pour la page
		$style = new Zend_Pdf_Style();
		//couleur du texte
		$style->setFillColor(new Zend_Pdf_Color_Html('#333333'));
		//couleur des lignes
		//$style->setLineColor(new Zend_Pdf_Color_Html('#000000'));
        //$style->setFillColor(new Zend_Pdf_Color_GrayScale(0.0));
        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
		//épaisseur des lignes
		$style->setLineWidth(1);
		//définition de la police
		$style->setFont($this->_normalFont,8);
		//application du style à la page
		$this->setStyle($style);
    }
 
 
	//permet de définir un titre à notre page
    public function setPageTitle() {
		//modification de la police
		//$this->setFont($this->_boldFont, 16);
		//$this->drawText("CONTRAT DE SOUSCRIPTION DE MEMBRE DISTRIBUTEUR", $this->_xPosition, $this->_yPosition, 'UTF-8');
		//déplacement du curseur vers le bas de 15 pixels
		//$this->_yPosition -= 15;
		//$this->drawLine($this->_leftMargin, $this->_yPosition, $this->leftMargin +520, $this->_yPosition);
		//déplacement du curseur vers le bas de 50 pixels
		//$this->_yPosition -= 50;
    }
	 
	 
	 //définition du footer de la page
    public function setFooter() {
	    $this->setFont($this->_boldFont,8);
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
	    //$this->drawText("227, Rue des Amandiers Tokoin-Nukafu B.P. : 30038 Lomé - TOGO",160,15, 'UTF-8');
	    //$this->drawText("Tél:+(228) 22 26 06 62 / Site web: redemare.org / Adresse électronique: eumcnp@gmail.com",140,8, 'UTF-8');
		$this->drawText("5",300,8, 'UTF-8');
    }
 
 
	 //permet de vérifier la position du curseur
	 //de manière à savoir si nous pouvons continuer à écrire sur la page
           
    public function checkPosition() {
	    //s'il reste plus de 75 pixels, nous pouvons contnuer à écrire
	    //sinon il n'est plus possible d'écrire
	    if($this->_yPosition >1200) {
	      return true;
	    }
	    else {
	      return false;
	    }
    }
 
        
    //permet d'afficher les informations sur le contrat
    public function addContrat()  {
	
	       $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		   
		   $this->_yPosition -=  0;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.1.1 : Le crédit en Nature Prépayé  récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 280;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 307;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 52;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition  =  81;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est un revenu récurrent affecté directement aux BPS. Son prix d’achat est fonction de la Période de ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
	       $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Constitution du Capital (PCK) aujourd’hui à 5.6. La PCK peut varier. L’achat du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 390;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition  =  420;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est un débours et le", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 514;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("ne se cumule pas mais se renouvelle à chaque période de façon illimitée.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Cependant, le cumul du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 145;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition  =  172;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est autorisé en cas de suspension de son renouvellement pérenne par le titulaire.", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("A cet effet, le cumul observe le renouvellement pendant la période PCK pour la reconstitution en unité NN ainsi ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et PRK pour la reconstitution en nature.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("La période de renouvellement est de trente jours à ce jour. Elle peut varier en fonction du niveau de solvabilité sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   69;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", c’est-à-dire en fonction de la capacité de production effective des BPS.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -= 20;
		   $this->_xPosition =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("La version",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 85;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 115;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("dont le renouvellement est limité est destinée d’une part aux entreprises et industries(douze fois",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -= 15;
		   $this->_xPosition =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("à ce jour) et d’autre part aux ménages, variable selon le cas du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 318;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("kit Technopole nrPRE", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 425;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(".Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 440;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText(" CNPr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 472;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("limité ne",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -= 15;
		   $this->_xPosition =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("se reconstitue qu’en cas de non expression. Il ne peut être disponible qu’après l’observation des douze périodes de",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -= 15;
		   $this->_xPosition =  37;
		   $this->drawText("renouvellement.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.1.2 : Le crédit en Nature Prépayé non récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 295;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 327;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le Crédit en Nature Prépayé non récurrent(",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 230;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   262;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(") est la version non renouvelable du Crédit en Nature Prépayé ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("récurrent.Contrairement au",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 159;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   184;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 201;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   234;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("s’obtient de façon cumulée, non renouvelable et vise la réduction des ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("coûts des BPS aux bénéficiaires.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 52;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   85;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("désigne le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 133;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("RPGnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   169;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et l'",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 191;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("Inr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   207;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(".On distingue à cet effet, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 330;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnrPRK", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   386;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 408;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnrPRE", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   462;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(". En fonction de ses ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("variables PRK et PRE, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_xPosition = 152;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_xPosition =   187;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("se reconstitue par simple voie de conversion en d’autres unités sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 497;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   60;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.2 : Le Crédit en Nature Convertible Salaire (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 263;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCS", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   292;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.2.1 : Le Crédit en Nature Convertible Salaire non récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 345;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   385;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le Crédit en Nature Convertible Salaire non récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 280;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   320;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(") est le Titre Privatif de Solvabilité des salariés (forces", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("de production) qui s’obtient par voie d’achat par les employeurs secteurs public et privé pour le compte de leurs salariés.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Il est la contrepartie du travail effectif fourni aux entreprises et industries qui l’ont acheté.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 52;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   95;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("aux mains des salariés est destiné à l’achat des Titres Privatifs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 375;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   408;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(". Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 428;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 470;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("doit observer la période", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de maturité. Il peut cependant s’échanger librement (contre toute offre) sur le marché en ligne du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 468;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 500;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.2.2 : Le Crédit en Nature Convertible Salaire récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 325;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 358;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(")", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le Crédit en Nature Convertible Salaire récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 260;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 292;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(") est le Titre Privatif de Solvabilité des salariés (forces de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("production) qui s’obtient par voie de la", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 210;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("SMCPN", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 252;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("pour le cas du salaire social. Il est la contrepartie du travail effectif ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("fourni aux entreprises et industries qui l’ont acquis.Conservé auprès de l’employeur, le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 422;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 456;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("ne se transforme pas", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et peut être utilisé à tout moment.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 52;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition =   87;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("aux mains des salariés est destiné à l’achat des Titres Privatifs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 370;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition =   403;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(". Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 423;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 460;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("doit observer la période", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de maturité. Il peut cependant s’échanger librement (contre toute offre) sur le marché en ligne du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 468;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 500;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("Article 10 : Cas de force majeure", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("En cas de force majeure qui empêcherait l’une au moins des parties de remplir ses obligations aux termes du présent", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("contrat, les parties ne seront pas responsables des conséquences de l’inexécution ou d’une exécution tardive de leurs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("obligations si celles-ci résultaient du cas de force majeure.Quel que soit le cas de force majeure, le recommencement", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("reste l’ultime recours auquel doivent se fier les propriétaires de compte marchand.Les titulaires du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("sont codétenteurs du progiciel", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 175;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 205;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(". A cet effet, le moyen de production étant le progiciel", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 445;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 477;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(", sa remise en ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("exploitation sera toujours disponible, de mêmes que les données de sauvegarde. ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("Article 11 : Règlement de litige lié à l’utilisation du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 368;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Il faut préciser que des litiges entre les différents utilisateurs du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 402;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   435;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("pourraient survenir.C’est dans", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("ce cadre qu’un dispositif de règlement de litige à l’interne a été mis en place sur la plateforme.Ce dispositif est le triple", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("compte marchand de surveillance que sont : le Compte Marchand Détentrice, le Compte Marchand Surveillance et le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Compte Marchand Exécutante qui gèrent les sous comptes marchands de réglementation, d’audit-contrôle, des alertes", $this->_xPosition, $this->_yPosition, 'UTF-8');

		   
		   
		   
		   
		   
		   
		   
	
	
	}
	
	
	
	
    /*
	
	
	
	
	
	public function addContrat() {
	
	       $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		   
		   $this->_yPosition -=  0;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.1.1 : Le crédit en Nature Prépayé  récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 280;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 307;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 52;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition  =  81;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est un revenu récurrent affecté directement aux BPS. Son prix d’achat est fonction de la Période de ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
	       $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Constitution du Capital (PCK) aujourd’hui à 5.6. La PCK peut varier. L’achat du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 390;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition  =  420;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est un débours et le", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 514;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("ne se cumule pas mais se renouvelle à chaque période de façon illimitée.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Cependant, le cumul du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 145;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition  =  172;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est autorisé en cas de suspension de son renouvellement pérenne par le titulaire.", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("A cet effet, le cumul observe le renouvellement pendant la période PCK pour la reconstitution en unité NN ainsi ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et PRK pour la reconstitution en nature.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("La période de renouvellement est de trente jours à ce jour. Elle peut varier en fonction du niveau de solvabilité sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   69;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", c’est-à-dire en fonction de la capacité de production effective des BPS.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -= 20;
		   $this->_xPosition =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("La version",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 85;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 115;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("dont le renouvellement est limité est destinée d’une part aux entreprises et industries(douze fois",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -= 15;
		   $this->_xPosition =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("à ce jour) et d’autre part aux ménages, variable selon le cas du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 318;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("kit Technopole nrPRE", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 425;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(".Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 440;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText(" CNPr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 472;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("limité ne",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -= 15;
		   $this->_xPosition =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("se reconstitue qu’en cas de non expression. Il ne peut être disponible qu’après l’observation des douze périodes de",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -= 15;
		   $this->_xPosition =  37;
		   $this->drawText("renouvellement.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.1.2 : Le crédit en Nature Prépayé non récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 295;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 327;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le Crédit en Nature Prépayé non récurrent(",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 230;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   262;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(") est la version non renouvelable du Crédit en Nature Prépayé ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("récurrent.Contrairement au",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 159;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   184;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 201;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   234;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("s’obtient de façon cumulée, non renouvelable et vise la réduction des ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("coûts des BPS aux bénéficiaires.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 52;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   85;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("désigne le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 133;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("RPGnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   169;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et l'",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 191;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("Inr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   207;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(".On distingue à cet effet, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 330;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnrPRK", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   386;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 408;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnrPRE", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition =   462;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(". En fonction de ses ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("variables PRK et PRE, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_xPosition = 152;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_xPosition =   187;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("se reconstitue par simple voie de conversion en d’autres unités sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 497;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   60;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.2 : Le Crédit en Nature Convertible Salaire (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 263;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCS", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   292;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.2.1 : Le Crédit en Nature Convertible Salaire non récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 345;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   385;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(")", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le Crédit en Nature Convertible Salaire non récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 280;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   320;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(") est le Titre Privatif de Solvabilité des salariés (forces", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("de production) qui s’obtient par voie d’achat par les employeurs secteurs public et privé pour le compte de leurs salariés.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Il est la contrepartie du travail effectif fourni aux entreprises et industries qui l’ont acheté.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 52;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   95;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("aux mains des salariés est destiné à l’achat des Titres Privatifs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 375;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   408;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(". Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 428;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 470;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("doit observer la période", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de maturité. Il peut cependant s’échanger librement (contre toute offre) sur le marché en ligne du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 468;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 500;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("9.2.2 : Le Crédit en Nature Convertible Salaire récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 325;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 358;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(")", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Le Crédit en Nature Convertible Salaire récurrent (", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 260;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 292;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(") est le Titre Privatif de Solvabilité des salariés (forces de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("production) qui s’obtient par voie de la", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 210;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("SMCPN", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 252;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("pour le cas du salaire social. Il est la contrepartie du travail effectif ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("fourni aux entreprises et industries qui l’ont acquis.Conservé auprès de l’employeur, le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 422;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 456;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("ne se transforme pas", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("et peut être utilisé à tout moment.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 52;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition =   87;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("aux mains des salariés est destiné à l’achat des Titres Privatifs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 370;
		   $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
           $this->setFillColor($bleu);
		   $this->setFont($font,10);
           $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition =   403;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(". Le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 423;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCSr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 460;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("doit observer la période", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de maturité. Il peut cependant s’échanger librement (contre toute offre) sur le marché en ligne du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 468;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_xPosition = 500;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("Article 10 : Cas de force majeure", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("En cas de force majeure qui empêcherait l’une au moins des parties de remplir ses obligations aux termes du présent", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("contrat, les parties ne seront pas responsables des conséquences de l’inexécution ou d’une exécution tardive de leurs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("obligations si celles-ci résultaient du cas de force majeure.Quel que soit le cas de force majeure, le recommencement", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("reste l’ultime recours auquel doivent se fier les propriétaires de compte marchand.Les titulaires du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("sont codétenteurs du progiciel", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 175;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 205;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(". A cet effet, le moyen de production étant le progiciel", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 445;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 477;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(", sa remise en ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("exploitation sera toujours disponible, de mêmes que les données de sauvegarde. ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("Article 11 : Règlement de litige lié à l’utilisation du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 368;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Il faut préciser que des litiges entre les différents utilisateurs du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 402;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   435;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("pourraient survenir.C’est dans", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("ce cadre qu’un dispositif de règlement de litige à l’interne a été mis en place sur la plateforme.Ce dispositif est le triple", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("compte marchand de surveillance que sont : le Compte Marchand Détentrice, le Compte Marchand Surveillance et le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Compte Marchand Exécutante qui gèrent les sous comptes marchands de réglementation, d’audit-contrôle, des alertes", $this->_xPosition, $this->_yPosition, 'UTF-8');

    }*/	
	 
	 
    /*
    public function addContrat($contrat) {
            
		//if(substr($contrat->code_membre,19,1)=='P') {
        //$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
        //$font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$this->_yPosition -=  0;
			$this->_xPosition =   40;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("coopératif ou collectif InrPRE (Investissement non récurrent Période de Reconstitution Effective).",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			$this->_yPosition -=  30;
			$this->_xPosition =   40;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
			$this->setFillColor($noir);
			$this->setFont($font,12);
			$this->drawText("CONVENTIONS N° 3:",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  25;
			$this->_xPosition =   50;
			$this->setFillColor($noir);
			$this->setFont($font1,8);
			$this->drawText("O",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			$this->_xPosition =   60;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("Entre les structures Têtes de Division Exécutante Subvention Marchande des Coûts d’Investissement (S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			$this->_xPosition = 98;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("SMCI",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			$this->_xPosition =  123;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText(") et les Producteurs-Transformateurs des BPS du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 361;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("MCNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   389;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Les structures ESMC Têtes de Division Exécutante Subvention Marchande des Coûts d’Investissement (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =  503;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition = 40;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("SMCI",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =  65;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(") se mettent d’accord avec les Producteurs-Transformateurs des BPS du marché pour commander continuellement",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("les marchandises destinées aux réapprovisionnements des Distributeurs-Fournisseurs. La condition convenue est que les",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Producteurs-Transformateurs obtiennent la",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 234;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("SMCI",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =  262;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("pour acheter en retour les BPS auprès des Distributeurs-Fournisseurs",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =  40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("des BPS de consommation industrielle pour répondre aux commandes.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  25;
			$this->_xPosition =   50;
			$this->setFillColor($noir);
			$this->setFont($font1,8);
			$this->drawText("O",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			$this->_xPosition =   60;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("Entre les structures Têtes de Division Exécutante Partenaire Bancaires et Financiers (S-CM Exécutante PBF)",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("et les Partenaires Bancaires et Financiers du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 256;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("MCNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   284;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Les structures ESMC Têtes de Division Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   273;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM Exécutante PBF",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   378;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(") se mettent d’accord avec les Partenaires",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Bancaires et Financiers du marché pour acheter continuellement les créances de leurs divers produits financiers (les",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("escomptes des traites aux Distributeurs-Fournisseurs du marché et les crédits divers accordés aux clients) à condition",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("que les bénéficiaires de ces produits financiers fassent en retour toutes leurs dépenses de consommation et de production",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 67;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("MCNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =  95;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("La modalité convenue est celle du paiement par traites aux fournisseurs dont l’escompte par les banques est payé par",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("échéance à ces dernières. A titre d’exemple, 8 échéances par unité de traite escomptée et 22,4 échéances pour tous",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("crédits faits aux membres en vue du financement de leur capital d’achat du pouvoir d’achat.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Pour cela, les structures ESMC Têtes de Division Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   317;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM Exécutante PBF",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   422;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(") s’engagent à former la garantie",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("FGFN en guise de DAT en dehors du déposit.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Cependant, il est obtenu des Partenaires Bancaires et Financiers dans le cadre du marché commun le procédé de l’achat",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("en retour des biens, produits et services de leurs consommations usuelles auprès des structures ESMC Têtes de Division",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   97;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   125;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 177;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("BPS",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 197;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("), grâce à leurs intérêts et frais divers perçus sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 424;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("MCNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =  453;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  25;
			$this->_xPosition =   50;
			$this->setFillColor($noir);
			$this->setFont($font1,8);
			$this->drawText("O",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			$this->_xPosition =   60;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("Entre les structures Têtes de Division Exécutante Sous-Compte Marchand Exécutante Biens, Produits et",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("Services (S-CM Exécutante BPS) et les Distributeurs-Fournisseurs des BPS du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 417;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
			$this->setFont($font,10);
			$this->drawText("MCNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =  446;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Les structures ESMC Têtes de Division Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   273;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   302;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 355;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("BPS",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   375;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(") se mettent d’accord avec les Distributeurs-",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Fournisseurs des BPS du marché pour acheter continuellement leurs marchandises à condition que ceux-ci achètent en",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("retour leurs marchandises en guise de réapprovisionnement auprès des structures ESMC Têtes de Division Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("(",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   43;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 72;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 125;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("BPS",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   145;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("La modalité convenue est celle du paiement par traites (8 traites par exemple).",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Pour cela, les structures ESMC Têtes de Division Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   317;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 345;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 397;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("BPS",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 417;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(") s’engagent à faire avaliser lesdites",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("traites par les banques en guise de garantie. Cependant, l’exigibilité des redevances aux Distributeurs-Fournisseurs est",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("et reste le procédé de l’achat de BPS en retour auprès des structures ESMC Têtes de Division Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition =   517;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
			$this->_xPosition =   40;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 93;
			$this->setFillColor($noir);
			$this->setFont($font,10);
			$this->drawText("BPS",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 114;
			$this->setFillColor($noir);
			$this->setFont($font1,10);
			$this->drawText(").",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		    $this->_yPosition -= 20;
		    $this->_xPosition  = 40;
		    $this->setFillColor($noir);
		    $this->setFont($font,12);
		    $this->drawText("DISPOSITIONS FINALES",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
			
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Au vu de tout ce qui précède et étant donné que la disponibilité des unités incombe aux divisions administratrices, que la",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("disponibilité de l’espèce bancaire incombe à la division PBF et que la disponibilité des BPS incombe aux divisions",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("animatrices, la disponibilité des unités, de l’espèce bancaire et des BPS n’incombe nullement au vendeur de Compte ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Marchand et de la licence",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   160;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
		  $this->setFillColor($rouge);
		  $this->setFont($font,10);
		  $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   190;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(". La détention irrévocable du Compte Marchand désengage entièrement le donneur de ",$this->_xPosition, $this->_yPosition, 'UTF-8');		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("licence et le bénéficiaire des Frais de Solvabilité de toute responsabilité découlant de l’usage qu’en font les détenteurs.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font,10);
		  $this->drawText("En effet, la liquidité des unités, la liquidité de l’espèce bancaire et la disponibilité des BPS sont exclusivement de ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font,10);
		  $this->drawText("responsabilité des têtes de la Divisions : ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Filières, Technopoles, ACNEV et même de la personne physique chapeautés par les divisions de l’Exécutante, ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("de la Surveillance et de la Détentrice.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Cependant, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 105;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
		  $this->setFillColor($rouge);
		  $this->setFont($font,10);
		  $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   136;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("étant un Marché de Crédit en Nature Pérenne comme son nom l’indique, aucune de ces créances",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("n’est due en espèce bancaire et reste en nature pour la simple raison qu’il n’ y a que les Biens, Produits et Services réels ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("en demande qui soldent de façon absolue les redevances.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("En outre, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 95;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
		  $this->setFillColor($rouge);
		  $this->setFont($font,10);
		  $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   127;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("est conçu pour que personne ne doive à personne.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   			
	    //}
	
    }*/
   
    //permet d'afficher un texte d'une certaine taille sur plusieurs lignes
    public function addText($text){
        //positionnement du pointeur
        $this->_xPosition = 40;
	    //permet d'effectuer la césure d'une chaîne de caractère
	    //retourne le texte après avoir inséré \n tous les 95 caractères sans couper un mot
	    $textWrapped = wordwrap($text, 95, "\n", false);
 
	    //permet de couper une chaîne en segment
	    //chaque segment est ici délimité par \n
	    //à noter que deux arguments doivent être fournis lors du premier appel à la fonction strtok
	    //lors des appels suivant à strtok, seul le délimiteur sera indiqué
	    //strtok retourne false lorsque la chaîne est vide
	    $token = strtok($textWrapped, "\n");
	    //tant que la chaîne n'est pas vide
	    while($token !== false) {
			 //ajoute le texte à notre page à la position x et y
			 $this->drawText($token, $this->_xPosition, $this->_yPosition, 'UTF-8');
			 //strtok a déjà été appelé une première fois,
			 //nous pouvons donc maintenant indiquer uniquement le délimiteur
			 $token = strtok("\n");
			 //modification de la valeur de y pour la prochaine écriture
			 $this->_yPosition -= 15;
	    }
	} 
	
        
        //permet d'ajouter une ligne horizontal
        
    public function addLine() {
         $this->drawLine($this->_leftMargin, $this->_yPosition, $this->_rightMargin, $this->_yPosition);
         //déplacement du curseur vers le bas de 15 pixels
         $this->_yPosition -= 15;
    }
	
	
}
