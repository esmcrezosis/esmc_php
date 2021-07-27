<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratsuitenext1 extends Zend_Pdf_Page {
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
     public function setFooter()
   {
	    $this->setFont($this->_boldFont,8);
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
	    //$this->drawText("227, Rue des Amandiers Tokoin-Nukafu B.P. : 30038 Lomé - TOGO",160,15, 'UTF-8');
	    //$this->drawText("Tél:+(228) 22 26 06 62 / Site web: redemare.org / Adresse électronique: eumcnp@gmail.com",140,8, 'UTF-8');
		$this->drawText("4",300,8, 'UTF-8');
     }
 
	 //permet de vérifier la position du curseur
	 //de manière à savoir si nous pouvons continuer à écrire sur la page
           
     public function checkPosition()
     {
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
		   
		   $this->_yPosition -=  0;
		   $this->_xPosition =   70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("8.2.2 : Pour l’ACNEV", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("L’ACNEV tout comme la Filière et la Technopole sont les trois entités, têtes de division qui agréent des Entreprises et", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText(" Industries membres et partenaires dans leurs Créneaux : Production, Transformation et Distribution composé chacun", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de Grossistes, Semi-Grossistes et Détaillants grâce au Compte Marchand d’administration ACNEV", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		   $this->_yPosition -=  15;
		   $this->_xPosition  =  37;
		   $this->drawText("L’ACNEV se charge de l’achat des intrants, de la centralisation des demandes et des ventes du BPS de la division sur", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			
		   $this->_yPosition -=  15;
		   $this->_xPosition  =  37;
		   $this->drawText("le marché ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		   $this->_xPosition  = 87;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		   $this->_xPosition  =  119;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("dans le respect des normes du modèle EU liées aux modalités de paiement.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		   $this->_yPosition -=  15;
		   $this->_xPosition  =  37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("Il est garant en dernier ressort :",$this->_xPosition,$this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- de la solvabilité absolue et pérenne de son BPS, ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- de la liquidité absolue de son BPS ainsi que ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- de la disponibilité absolue de son BPS sur le marché",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			
		    $this->_xPosition  =  303;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		    $this->_xPosition  =  335;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
			$this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU en ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
			$this->drawText("réponse aux attentes du",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  150;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  185;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
			$this->setFont($font1,10);
            $this->drawText("face à la division. ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   70;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("8.2.3 : Pour la TECHNOPOLE", $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   37;
		    $this->drawText("La Technopole tout comme la Filière et l’ACNEV sont les trois entités, têtes de division qui agréent des Entreprises et", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		    $this->_yPosition -=  15;
		    $this->_xPosition =   37;
		    $this->drawText(" Industries membres et partenaires dans leurs Créneaux : Production, Transformation et Distribution composé chacun", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		    $this->_yPosition -=  15;
		    $this->_xPosition =   37;
		    $this->drawText("de Grossistes, Semi-Grossistes et Détaillants grâce au Compte Marchand d’administration Technopole .", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		    $this->_yPosition -=  15;
		    $this->_xPosition =   37;
		    $this->drawText("Pour la sécurité de tous sur le", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  172;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  202;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText(", tout titulaire de Compte Marchand est responsable de toute utilisation de ses", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition =   37;
		    $this->drawText("moyens d’authentification (biométrie et cartes) ainsi que du rôle pour lequel le compte lui est affecté.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		    $this->_yPosition -=  15;
		    $this->_xPosition =   37;
		    $this->drawText("La Technopole est garante:", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- de l’éducation,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- de l’apprentissage,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- de la formation,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- des stages,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- du recyclage,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- des recherche et développement et",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  60;
			$this->drawText("- du plein emploi de la division au service de l’industrialisation du BPS sur le marché",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  435;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU liées aux modalités de paiement.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
			$this->drawText("Elle est garante en dernier ressort de la solvabilité absolue et pérenne, de la liquidité absolue ainsi que de la disponibilité", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
			$this->drawText("absolue du BPS sur le marché", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  177;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  210;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU en réponse aux attentes du", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  530;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
			$this->drawText("face à la division.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition  =  37;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
			$this->drawText("Article 9 : Descriptif des unités", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 188;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Les unités",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_xPosition = 85;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  117;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("sont les titres privatifs de solvabilité qui se regroupent en deux catégories : le pouvoir d’achat appelé ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
			$this->drawText("Crédit en Nature Prépayé (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_xPosition = 156;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 175;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(" ) et le crédit productif appelé Crédit en Nature Convertible Salaire (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  470;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			
			$this->_xPosition  =  498;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(") .",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition  =  60;
			$this->drawText("9.1 : Le Crédit en Nature Prépayé (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 215;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
			
			$this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			$this->_xPosition  =  235;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 54;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  77;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("est le Titre Privatif  Numérique qui fait office de pouvoir d’achat libérateur, c’est-à-dire soldé d’avance par le ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("bénéficiaire sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  117;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  146;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Cependant, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 103;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  127;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("est la créance du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  = 207;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  240;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("à solder en nature grâce à l’usage du titre privatif de solvabilité le ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  532;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("qui lui fait office de crédit productif. ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le Titre ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 74;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  97;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("peut être récurrent ou non récurrent.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("C’est le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 73;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  96;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("qui permet de former le Fonds de Garantie du Financement en Nature (FGFN) nominal non décaissable,",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("tandis que le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  97;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  132;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("permet de former le FGFN réel: Biens, Produits et Services, c’est-à-dire que le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  484;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 515;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("est la ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("rémunération des forces productrices des entreprises et industries.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le FGFN en ses deux versions (nominal et réel) est le gage du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  319;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 351;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("vis-à-vis de tout partenaire bancaire et financier ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("ainsi que de tout fournisseur extérieur de Biens, Produits et Services.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  37;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le Titre ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 74;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  97;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("peut être récurrent ou non récurrent.",$this->_xPosition, $this->_yPosition, 'UTF-8');
	
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
		  $this->drawText("LE CREDIT EN NATURE PREPAYE récurrent (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 302;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,12);
          $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition  = 334;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le Crédit en Nature Prépayé récurrent (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 217;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  = 243;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  =  253;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("désigne le Revenu Périodique Garanti récurrent (", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition =473;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("RPGr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  = 500;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText(").", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 55;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  =  84;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("est un revenu récurrent affecté directement aux BPS. Son prix d’achat est fonction de la Période de ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Constitution du Capital (PCK) aujourd’hui à 5.6. La PCK peut varier.L’achat du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_xPosition = 390;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_xPosition  =  420;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("est un débours et non une épargne.", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 55;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  =  87;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("ne se cumule pas mais se renouvelle à chaque période de façon illimitée.", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Cependant, le cumul du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 148;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("RPGr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition  =  178;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("est autorisé en cas de suspension de son renouvellement pérenne par le titulaire.", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("A cet effet, le cumul observe le renouvellement pendant la période PCK pour la reconstitution en unité NN ainsi ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("qu’en espèce (cas de CACB et CSCOE) et PRK pour la reconstitution en nature.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("La période de renouvellement est de trente jours à ce jour. Elle peut varier en fonction du niveau de solvabilité sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   72;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(", c’est-à-dire en fonction de la capacité de production effective des BPS.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  30;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("LE CREDIT EN NATURE PREPAYE non récurrent (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 326;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,12);
          $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   364;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le Crédit en Nature Prépayé non récurrent(",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 233;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   265;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(") est la version non renouvelable du Crédit en Nature Prépayé ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("récurrent.Contrairement au",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 162;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   187;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(", le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 204;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   237;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("s’obtient de façon cumulée, non renouvelable et vise la réduction des ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("coûts des BPS aux bénéficiaires.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 55;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   88;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("désigne le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 136;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("RPGnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   172;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("et le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 194;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("Inr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   210;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".On distingue à cet effet, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 333;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnrPRK", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   389;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("et le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 411;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnrPRE", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   465;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(". En fonction de ses ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("variables PRK et PRE, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_xPosition = 155;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnr", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_xPosition =   190;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("se reconstitue par simple voie de conversion en d’autres unités sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_xPosition = 500;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("CONVENTIONS",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("CONVENTION N° 1 :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Entre les structures Têtes de Division Exécutante Partenaire Bancaires et Financiers (S-CM Exécutante PBF) et les",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Acteurs CONSOMMATEURS du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 190;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =220;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Dans le but de former continuellement le déposit et le DAT convenus avec les PBF, les structures ESMC têtes de",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Division PBF se mettent d’accord avec  les acteurs consommateurs du marché (individus, ménages,entreprises et",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("industries)  pour  consommer   permanemment  les marchandises  auprès des Distributeurs-Fournisseurs. En guise",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("d’optimisation du pouvoir d’achat des consommateurs, les modalités de consommation convenues sont la consommation",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("récurrente et la consommation non récurrente.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le capital d’achat variable de ces deux pouvoirs d’achat de consommation se fait 5,6 fois la consommation périodique",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("pour le récurrent et  5,6(1/8) fois la consommation une fois de bon pour le non récurrent. ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		  
		  $this->_yPosition -=  30;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("Le Crédit en Nature Convertible Salaire (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 270;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,12);
          $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   306;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le Crédit en Nature Convertible Salaire(",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 218;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   246;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(") est le Titre Privatif de Solvabilité des salariés (forces de production)",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("qui s’obtient contre le travail fourni aux entreprises et industries des divisions. Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 400;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   432;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("est destiné à l’achat des Titres",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Privatifs",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_xPosition = 78;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("CNPnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   110;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   54;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
		  $this->drawText("CNCS",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   86;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("doit observer la période de maturité. Il peut cependant s’échanger librement (contre toute offre) sur le marché ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("en ligne du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 93;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   122;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  
		  $this->_yPosition -= 20;
		  $this->_xPosition  = 40;
		  $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("CONVENTION N° 2 :  ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font,10);
		  $this->drawText("Entre les structures Têtes de Division Exécutante Subvention Marchande des Coûts de Production Nouvelle",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font,10);
		  $this->drawText("(S-CM Exécutante SMCPN)  et les Acteurs salariés du MCNP.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Les structures ESMC Têtes de Division Exécutante (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   273;
		  $this->setFillColor($noir);
		  $this->setFont($font,10);
		  $this->drawText("S-CM Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 357;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("SMCPN", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   394;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(") se mettent d’accord avec les acteurs",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("salariés des trois créneaux : Producteurs, Transformateurs et Distributeurs du marché pour continuellement rémunérer",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("leur travail effectivement accompli, à condition que la rémunération serve à la consommation récurrente et non",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("récurrente sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 115;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 144;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
	
		  $this->_yPosition -=  30;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("La Grande Consommation préfinancée (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   267;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,12);
		  $this->drawText("GC",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   285;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("p) ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("La Grande Consommation préfinancée (",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   217;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
		  $this->drawText("GC",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   232;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("p) est le Titre Privatif de Solvabilité qui s’obtient contre le ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   486;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
		  $this->drawText("CNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   510;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("des acheteurs",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("grâce à l’échange des BPS préfinancés par les entreprises et industries distributrices agréées par les têtes de divisions.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("La",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   56;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
		  $this->drawText("GC",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   71;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("p est ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   95;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("destinée à l’achat des Titres Privatifs",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 260;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
		  $this->drawText("CNPnr",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =  297;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("et",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 311;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("CNCS", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =  343;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("pour la consommation des BPS de production et la ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("rémunération des forces productrices pour le compte des entreprises et industries titulaires. S’agissant de l’achat du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =  70;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(", la",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   85;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
		  $this->drawText("GC",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   100;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("p doit observer la période de maturité. Elle peut cependant s’échanger librement (contre toute offre) sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("marché en ligne du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 130;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   160;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  //$this->_yPosition -=  15;
		  $this->_xPosition =   168;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 182;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("CNCS ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =  212;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("et la ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   232;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
		  $this->drawText("GC",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition =   247;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("p à la période de maturité peuvent valablement participer à l’investissement ",$this->_xPosition, $this->_yPosition, 'UTF-8');	  	
   
    } */
	
	
	
	
	
   
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
