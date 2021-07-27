<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratsuitenext4 extends Zend_Pdf_Page {
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
		$this->drawText("7",300,8, 'UTF-8');
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
		   
		   $this->_yPosition -=  0;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("12.3Convention N° 3 :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Entre les structures Têtes de Division Exécutante Subvention Marchande des Coûts de Production Nouvelle (S-CM",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 91;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("SMCPN", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 130;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("), d’une part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("et",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Les Acteurs salariés du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 143;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 173;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(", d’autre part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Il est convenu ce qui suit :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Les structures ESMC Têtes de Division Exécutante (S-CM Exécutante",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 353;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("SMCPN", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 391;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(") se mettent d’accord avec les acteurs", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("salariés des trois créneaux : Producteurs, Transformateurs et Distributeurs du marché pour continuellement rémunérer",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("leur travail effectivement accompli, à condition que la rémunération serve à la consommation récurrente et non récurrente",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 63;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 93;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("12.4Convention N° 4 :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Entre les structures Têtes de Division Exécutante Subvention Marchande des Coûts d’Investissement (S-CM Exécutante", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
		   $this->drawText("SMCI", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 62;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("), d’une part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Les Producteurs-Transformateurs des BPS du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition =   246;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
		   $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition = 276;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(", d’autre part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Il est convenu ce qui suit :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Les structures ESMC Têtes de Division Exécutante Subvention Marchande des Coûts d’Investissement(S-CM Exécutante", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
		   $this->drawText("SMCI", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 62;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(") se mettent d’accord avec les Producteurs-Transformateurs des BPS du marché pour commander continuellement", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("les marchandises destinées aux réapprovisionnements des Distributeurs-Fournisseurs.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("La condition convenue est que les Producteurs-Transformateurs obtiennent la", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   385;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
		   $this->drawText("SMCI", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 415;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("pour acheter en retour les BPS", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("auprès des Distributeurs- Fournisseurs des BPS de consommation industrielle pour répondre aux commandes.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("12.5Convention N° 5 :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font1,10);
		   $this->drawText("Entre les structures Têtes de Division Exécutante Sous-Compte Marchand Exécutante Biens, Produits et Services ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("(S-CM Exécutante BPS), d’une part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Les Distributeurs-Fournisseurs des BPS du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   232;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
		   $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   262;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", d’autre part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Il est convenu ce qui suit :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Les structures ESMC Têtes de Division Exécutante (S-CM Exécutante BPS) se mettent d’accord avec", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("les Distributeurs-Fournisseurs des BPS du marché pour acheter continuellement leurs marchandises à condition que", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("ceux-ci achètent en retour leurs marchandises en guise de réapprovisionnement auprès des structures ESMC Têtes de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Division Exécutante (S-CM Exécutante BPS).", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("La modalité convenue est celle du paiement par traites (8 traites par exemple). Pour cela, les structures ESMC Têtes", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de Division Exécutante (S-CM Exécutante BPS) s’engagent à faire avaliser lesdites traites par les banques en guise de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("garantie.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Cependant, l’exigibilité des redevances aux Distributeurs-Fournisseurs est et reste le procédé de l’achat de BPS en ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("retour auprès des structures ESMC Têtes de Division Exécutante (S-CM Exécutante BPS).", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("Article 13 :DISPOSITIONS FINALES ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font1,10);
		   $this->drawText("Au vu de tout ce qui précède et étant donné que la disponibilité des unités incombe aux divisions administratrices,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("que la disponibilité de l’espèce bancaire incombe à la division PBF et que la disponibilité des BPS incombe aux", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("divisions animatrices, la disponibilité des unités, de l’espèce bancaire et des BPS n’incombe nullement au vendeur de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("la licence", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_xPosition =   82;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
		   $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =  112;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("En effet, la liquidité des unités, la liquidité de l’espèce bancaire et la disponibilité des BPS sont exclusivement", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("de la responsabilité des têtes de Divisions : Filières, Technopoles, ACNEV et même de la personne physique,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("chapeautés par les divisions de l’Exécutante, de la Surveillance et de la Détentrice. ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
	
	
	
	
	}
	
	
    /*        
    public function addContrat($contrat) {
            
		if(substr($contrat->code_membre,19,1)=='P') {
		
            //$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
            //$font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			
		  $this->_yPosition -= 0;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("En signant ce contrat, le détenteur accepte l’achat irrévocable de son Compte Marchand contre les Frais de Solvabilité ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("et de Licence et s’engage à respecter toutes les conditions liées à son usage, conditions qui toutes concourent  à ce que ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("personne ne doive à personne.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			
			
		    $this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,12);
		    $this->drawText("Coordonnées du souscripteur :",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Nom : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			 //déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->nom_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Prénom : ……..……………………………………………………………….…………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			//déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->prenom_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Profession : ……..……………………………………………………………….………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			//déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->profession_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Nationalité  : ……..……………………………………………………………….………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			//déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->nationalite, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("BP  : ……..……………………………………………………………….…………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			//déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->bp_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Tél  : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			//déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->tel_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Ville  : ……..……………………………………………………………….………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			 //déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->ville_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Adresse  : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			 //déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->quartier_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  20;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("N° CM  : ……..……………………………………………………………….………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			//déplacement du curseur vers la droite de 50 pixels
			 $this->_yPosition +=  2;
             $this->_xPosition = 100;
			 $this->setFont($font1,10);
		     $this->drawText($contrat->code_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			
			$this->_yPosition -=  30;
		    $this->_xPosition =   360;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,10);
		    $this->drawText("Fait à ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			
			$this->_xPosition = 392;
			$datecontrat = new Zend_Date($contrat->date_contrat, Zend_Date::ISO_8601);
		    $this->drawText(stripslashes (html_entity_decode($contrat->ville_membre)).' ,le '.$datecontrat,$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			} else {
			        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                    $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		            $this->_yPosition -=  0;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,12);
		            $this->drawText("Coordonnées du souscripteur :",$this->_xPosition, $this->_yPosition, 'UTF-8');
				   
				   
				    $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("Raison sociale : ……..……………………………………………………………….…………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->raison_sociale, $this->_xPosition, $this->_yPosition, 'UTF-8');
				   
				    $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("Objet social : ……..……………………………………………………………….…………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->code_statut, $this->_xPosition, $this->_yPosition, 'UTF-8');
				   
				   
				    $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("N° RCCM/RECEPISSE : ……..……………………………………………………………….………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->num_registre_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
				   
				   
				    $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("Nationalité : ……..……………………………………………………………….………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->nationalite, $this->_xPosition, $this->_yPosition, 'UTF-8');
				   
				   
		            $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("BP  : ……..……………………………………………………………….…………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->bp_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("Tél  : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->tel_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("Ville  : ……..……………………………………………………………….………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->ville_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        $this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("Adresse  : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			        //déplacement du curseur vers la droite de 50 pixels
					$this->_yPosition +=  2;
                    $this->_xPosition = 200;
			        $this->setFont($font1,10);
		            $this->drawText($contrat->quartier_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			 
			        $table = new Application_Model_DbTable_EuActeur();
                    $select = $table->select();
			        $select->where('code_membre LIKE ?', $contrat->code_membre);
			        $resultSet = $table->fetchAll($select);
			        $ligneacteur = $resultSet->current();
			 
			 if($ligneacteur->code_activite == 'FILIERE' || $ligneacteur->code_activite == 'ACNEV' 
			    || $ligneacteur->code_activite == 'TECHNOPOLE' || $ligneacteur->type_acteur == 'gac_surveillance'
				|| $ligneacteur->type_acteur == 'gac_executante') {
				      $appeloffre = new Application_Model_EuAppeloffres();
				      $appeloffre_mapper = new Application_Model_EuAppeloffresMapper();
				      $findoffre = $appeloffre_mapper->findappeloffre($contrat->code_membre);
				      $this->_yPosition -=  20;
		              $this->_xPosition =   40;
		              $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                      $this->setFillColor($noir);
		              $this->setFont($font,10);
		              $this->drawText("N° Contrat  : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			          //déplacement du curseur vers la droite de 50 pixels
					  $this->_yPosition +=  2;
                      $this->_xPosition = 200;
			          $this->setFont($font1,10);
		              $this->drawText($findoffre->getNum_appeloffres(), $this->_xPosition, $this->_yPosition, 'UTF-8');
				
			 } elseif($ligneacteur->type_acteur == 'gac_detentrice') {
			 
			          $licence = new Application_Model_EuLicence();
				      $licence_mapper = new Application_Model_EuLicenceMapper();
				      $findlicence = $licence_mapper->findlicencebymembre($contrat->code_membre);
					  
					  $this->_yPosition -=  20;
		              $this->_xPosition =   40;
		              $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                      $this->setFillColor($noir);
		              $this->setFont($font,10);
		              $this->drawText("N° Contrat  : ……..……………………………………………………………….……………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			          //déplacement du curseur vers la droite de 50 pixels
					  $this->_yPosition +=  2;
                      $this->_xPosition = 200;
			          $this->setFont($font1,10);
		              $this->drawText($findlicence->getNum_licence(), $this->_xPosition, $this->_yPosition, 'UTF-8');
			 
			 
			 
			 
			 } else {
			 
					$this->_yPosition -=  20;
		            $this->_xPosition =   40;
		            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
		            $this->setFont($font,10);
		            $this->drawText("N° Agréments :",$this->_xPosition, $this->_yPosition, 'UTF-8');
					
					$agrement = new Application_Model_EuAgrement();
				    $agrement_mapper = new Application_Model_EuAgrementMapper();
				    $findagrementf = $agrement_mapper->findagrementfilierebymembre($contrat->code_membre);
					$findagrementa = $agrement_mapper->findagrementacnevbymembre($contrat->code_membre);
					$findagrementtechno = $agrement_mapper->findagrementtechnobymembre($contrat->code_membre);
					
					$this->_yPosition -=  20;
		            $this->_xPosition =   80;
					$this->drawText("1)	 ACNEV ….………………………………………………………………………………………..",$this->_xPosition, $this->_yPosition, 'UTF-8');
					
					
					//déplacement du curseur vers la droite de 50 pixels
					  $this->_yPosition +=  2;
                      $this->_xPosition = 200;
			          $this->setFont($font1,10);
		              $this->drawText($findagrementa->getNum_agrement(), $this->_xPosition, $this->_yPosition,'UTF-8');
					
					
					$this->_yPosition -=  20;
		            $this->_xPosition =   80;
					$this->setFont($font,10);
					$this->drawText("2)	 TECHNOPOLE ………………………………………………………………………………..",$this->_xPosition, $this->_yPosition, 'UTF-8');
					
					  //déplacement du curseur vers la droite de 50 pixels
					  $this->_yPosition +=  2;
                      $this->_xPosition = 200;
			          $this->setFont($font1,10);
		              $this->drawText($findagrementtechno->getNum_agrement(), $this->_xPosition, $this->_yPosition,'UTF-8');
					
					$this->_yPosition -=  20;
		            $this->_xPosition =   80;
					$this->setFont($font,10);
					$this->drawText("3)	 FILIERE …………..………………………………………………………………………………   ",$this->_xPosition, $this->_yPosition, 'UTF-8');
					
					//déplacement du curseur vers la droite de 50 pixels
					  $this->_yPosition +=  2;
                      $this->_xPosition = 200;
			          $this->setFont($font1,10);
		              $this->drawText($findagrementtechno->getNum_agrement(), $this->_xPosition, $this->_yPosition,'UTF-8');
					  
			  }
			 
			  $this->_yPosition -=  20;
		      $this->_xPosition =   40;
		      $noir = new Zend_Pdf_Color_Rgb(0,0,0);
              $this->setFillColor($noir);
		      $this->setFont($font,10);
		      $this->drawText("N° CM  : ……..……………………………………………………………….………………………………………………………",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			  //déplacement du curseur vers la droite de 50 pixels
			  $this->_yPosition +=  2;
              $this->_xPosition = 200;
			  $this->setFont($font1,10);
		      $this->drawText($contrat->code_membre, $this->_xPosition, $this->_yPosition, 'UTF-8');
			
			
			  $this->_yPosition -=  30;
		      $this->_xPosition =   360;
		      $noir = new Zend_Pdf_Color_Rgb(0,0,0);
              $this->setFillColor($noir);
		      $this->setFont($font,10);
		      $this->drawText("Fait à ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			  $this->_xPosition = 392;
			  $datecontrat = new Zend_Date($contrat->date_contrat, Zend_Date::ISO_8601);
		      $this->drawText(stripslashes (html_entity_decode($contrat->ville_membre)).' ,le '.$datecontrat,$this->_xPosition, $this->_yPosition, 'UTF-8'); 			
			}		 
    }
	
	*/
	
   
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
