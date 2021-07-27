<?php

//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratsuite extends Zend_Pdf_Page {
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
    public function setFooter(){
	    $this->setFont($this->_boldFont,8);
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
	    //$this->drawText("227, Rue des Amandiers Tokoin-Nukafu B.P. : 30038 Lomé - TOGO",160,15, 'UTF-8');
	    //$this->drawText("Tél:+(228) 22 26 06 62 / Site web: redemare.org / Adresse électronique: eumcnp@gmail.com",140,8, 'UTF-8');
		$this->drawText("2",300,8, 'UTF-8');
    }
 
	 //permet de vérifier la position du curseur
	 //de manière à savoir si nous pouvons continuer à écrire sur la page
           
    public function checkPosition() {
	    //s'il reste plus de 75 pixels, nous pouvons contnuer à écrire
	    //sinon il n'est plus possible d'écrire
	    if($this->_yPosition >1200)
	    {
	      return true;
	    }
	    else
	    {
	      return false;
	    }
    }
 
        
    //permet d'afficher les informations sur le contrat
        
    
	public function addContrat() {
	       $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		   
		   $this->setFont($font1,10);
		   $this->_yPosition -=  0;
           $this->_xPosition  =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->drawText("Les divisions s’organisent en Créneaux Producteurs,Transformateurs et Distributeurs et regroupent :",$this->_xPosition,$this->_yPosition,'UTF-8');
	
	       $this->_yPosition -=  20;
           $this->_xPosition  =  37;
		   $this->drawText("- la Filière,",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- l’ACNEV (Achat Crédit en Nature Entrepôt et Ventes),",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- la Technopole,",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- les Grossistes,",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- les Semi – Grossistes et",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- les Détaillants.",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("Le Compte Marchand Personne Physique est le compte de tout individu sur le",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 384;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 417;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->setFont($font,10);
		   $this->_yPosition -=  20;
           $this->_xPosition  =  37;
		   $this->drawText("Article 3 : Conditions générales",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Peuvent acheter le Compte Marchand les personnes morales et les personnes physiques qui adhèrent au mode",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   37;
		   $this->drawText("d’entreprendre de Marché Commun (ESMC) /",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 242;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 277;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("dont les conditions sont les suivantes :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Accepter que le Revenu Périodique Garanti pérenne pour tous entretenu par le travail productif sur le marché",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   65;
		  
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  =   100;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("est un investissement,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Accepter le mode de payement en nature géré par la comptabilité intégrée au progiciel",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 455;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 488;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("dont la constitution ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   65;
		   $this->drawText("du Fonds de Garantie du Financement en Nature (FGFN) est le gage,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Accepter la solvabilité absolue de l’Humain par la monétisation du travail  productif  dont  il  est  porteur, ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Accepter que l’employé soit entrepreneur et que l’entrepreneur soit employé vis-à-vis des responsabilités de",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   67;
		   $this->drawText("l’entreprise qui bénéficie du crédit productif, Crédit en Nature Convertible Salaire (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 430;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 459;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(") et de l’investissement", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   67;
		   $this->drawText("en nature ( ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 117;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("I", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition  = 121;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(") sur le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 158;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("- Production et consommation respectant la nature,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Solvabilité absolue assurée par la compensation en nature entre Divisions organisées comme suit :Filière,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   68;
		   $this->drawText("Technopole,ACNEV,Grossistes, Semi-grossistes et Détaillants dans les créneaux Producteur, Transformateur", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   68;
		   $this->drawText("et Distributeur ;", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Production et consommation respectant l’économie d’usage qui avorte l’épargne et la thésaurisation,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Production et consommation respectant l’économie de service qui implique l’achat de services plutôt que ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   68;
		   $this->drawText("l’achat-possession,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Production et consommation respectant l’économie circulaire qui implique le renouvelable et le recyclable ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   68;
		   $this->drawText("plutôt que l’économie linéaire (consommer et jeter),", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Production et consommation respectant l’économie de circuit court (produire localement) et de cycle court", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   72;
		   $this->drawText("(formation et  apprentissage brefs ou accélérés) et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=   15;
		   $this->_xPosition  =   60;
		   $this->drawText("- Respecter les principes, les conventions ESMC et les normes d’utilisation du progiciel ", $this->_xPosition, $this->_yPosition, 'UTF-8');          
           $this->_xPosition = 448;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		   $this->_xPosition = 480;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->setFont($font,10);
		   $this->_yPosition -=  20;
           $this->_xPosition  =  37;
		   $this->drawText("Article 4 : Conditions spécifiques liées à l’achat d’un compte marchand",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->setFont($font1,10);
		   $this->_yPosition -=  20;
           $this->_xPosition  =  60;
		   $this->drawText("4.1 : Cout (Adhésion)",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
           $this->_xPosition  =  37;
		   $this->drawText("L’achat du Compte Marchand",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 172;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 210;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("est conditionné par le versement des frais suivants :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->setFont($font1,10);
		   $this->_yPosition -=  20;
           $this->_xPosition  =  70;
		   $this->drawText("4.1.1 : Personnes physiques",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- Frais de Solvabilité à (montant) : ……………………………………………. FCFA",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- Frais de Licence à (montant) : …………………..……………..………… FCFA",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->setFont($font1,10);
		   $this->_yPosition -=  20;
           $this->_xPosition  =  70;
		   $this->drawText("4.1.2 : Personnes morales",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
           $this->_xPosition  =  37;
		   $this->drawText("- Frais de Solvabilité à (montant) : ……………………………………………. FCFA",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("- Frais de Licence à (montant)      : ……………………………………….…… FCFA",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->setFont($font1,10);
		   $this->_yPosition -=  20;
           $this->_xPosition  =  60;
		   $this->drawText("4.2 : Résiliation du contrat",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
           $this->_xPosition  =  37;
		   $this->drawText("Les parties sont libres de résilier le contrat.",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("Toutefois, les frais payés à l’ouverture du compte ne sont pas remboursables",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("L’utilisation du Compte Marchand désengage entièrement le vendeur du compte et le bénéficiaire de frais de solvabilité",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
           $this->_xPosition  =  37;
		   $this->drawText("de toute responsabilité découlant de l’usage qu’en font les détenteurs.",$this->_xPosition,$this->_yPosition,'UTF-8');
	
	}
	
	


    /*    
    public function addContrat($contrat) {
   
        //$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
        //$font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		  
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		  
		$this->_yPosition -=  0;
		$this->_xPosition =   40;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->setFont($font,12);
		$this->drawText("CONDITIONS D’ACHAT DU COMPTE MARCHAND",$this->_xPosition, $this->_yPosition, 'UTF-8');
		$this->_xPosition = 332;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
		$this->setFont($font,12);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		$this->_yPosition -=   15;
		$this->_xPosition  =   40;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->setFont($font1,10);
		$this->drawText("L’achat du Compte Marchand",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 175;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  = 210;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("est conditionné par le versement des frais suivants :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("- Frais de Solvabilité à (montant) : ……………………………………………. FCFA",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("- Frais de Licence à (montant) : ……………………………………..………… FCFA",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   40;
		  $this->drawText("Le paiement de ces frais donne droit à : ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("- l’accès irrévocable au",$this->_xPosition, $this->_yPosition,'UTF-8');
		  $this->_xPosition = 167;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  $this->_xPosition  = 200;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("grâce au Frais de Licence,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("- l’ouverture irrévocable du Compte Marchand",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 265;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Les frais payés  sont non récupérables.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  30;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("LES AVANTAGES DU DETENTEUR DU COMPTE MARCHAND",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 393;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,12);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le Compte Marchand",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 138;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition =   170;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("permet à son détenteur d’obtenir les avantages suivants :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("• l’Achat  du Pouvoir d’Achat",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 190;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("• le Bail Nue – Propriété (BNP), c’est-à-dire au prêt financier ou bancaire cautionné par",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 447;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("• l’investissement nrPRE,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("• l’emploi social marchand rémunéré en unités",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 269;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition =  303;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("dites Crédit en Nature Convertible Salaire (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 494;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 522;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(") et",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("• l’enrôlement des entreprises et industries à l’investissement alloué en unités",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 407;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 442;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("dites Subvention Marchande ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   68;
		  $this->drawText("des Coûts d’Investissement et de Production Nouvelle (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 314;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("SMCIPN ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 356;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("). La",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 379;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("SMCIPN ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 420;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("est composée de l’investissement",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   68;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("qui rembourse les biens immédiats consommés par les entreprises et industries auprès d’autres entreprises ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   68;
		  $this->drawText("et industries ainsi que le salaire qui rémunère les forces de production (travailleurs du social marchand).",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  30;
		  $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("LES OBLIGATIONS DU DETENTEUR DU COMPTE MARCHAND",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 405;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,12);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   100;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("O Personne Physique :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("La Personne Physique titulaire du Compte Marchand",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 278;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 312;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("est seule responsable de la gestion de son Compte", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("et est garante de la productivité de sa communauté. A cet effet, elle dispose de l’outil d’enrôlement dit nrPRE Kit ", $this->_xPosition, $this->_yPosition,'UTF-8');

		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("Technopole pour :", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- s’éduquer, ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- apprendre, ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- se former, ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- faire les stages, ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- se recycler, ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- faire des recherches visant le développement, ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- s’enrôler à l’emploi dans l’une au moins des divisions au service de l’industrialisation du travail sur le ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 515;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("Elle est garante en dernier ressort de la solvabilité absolue et pérenne, de la liquidité absolue ainsi que de la disponibilité ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("absolue du travail sur le marché", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 185;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 217;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("dans le respect des normes du modèle de l’Economie Universelle(EU) liées aux ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("modalités de paiement en réponse aux attentes de sa communauté. ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  30;
		  $this->_xPosition =   100;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("O Personne Morale ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("En ce qui concerne les Personnes Morales regroupées en divisions (division administratrice et division animatrice du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  70;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("),", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  80;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("leurs obligations sont les suivantes : ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  100;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("- Pour la FILIERE ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("Elle est garante en dernier ressort sur le marché ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 258;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  292;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(":", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("• de la liquidité absolue de son Bien, Produit et Service,", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("• de la disponibilité absolue de son Bien, Produit et Service, (la liquidité et la disponibilité absolues qui sous entendent ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("la qualité et la quantité du Bien Produit et Service sont gage de lasolvabilité absolue et pérenne de ladite Filière),", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("• du respect des règles de gestion, des normes de l’économie circulaire, de l’économie d’usage, de l’économie de  ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $this->drawText("service et de l’économie de cycle court ainsi que le respect des normes du modèle EU liées aux modalités de paiement,", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  40;
		  $this->drawText("• de la réponse aux attentes du", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 183;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  215;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("face à la division.", $this->_xPosition, $this->_yPosition,'UTF-8');		  				 
              
    } */


	    //permet d'afficher un texte d'une certaine taille sur plusieurs lignes
    public  function addText($text){
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
