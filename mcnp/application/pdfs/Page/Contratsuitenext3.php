<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratsuitenext3 extends Zend_Pdf_Page {
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
		$this->drawText("6",300,8, 'UTF-8');
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
		   $this->setFont($font1,10);
		   $this->drawText(",des assurances,de protection qui forment en soi des instruments internes de règlements de litiges.", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Les avantages liés à la mise en place de ce dispositif porte sur l’efficacité des règlements axés sur la solvabilité", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("intégrée à la plateforme", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 147;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 177;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(" ; étant entendu que tout litige auquel allusion est faite se résume au défaut de paiement", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("ou à la non solvabilité les uns vis-à-vis des autres sur la plateforme.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Cependant, le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 104;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 139;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("étant un Marché de Crédit en Nature Pérenne, aucune créance n’est due en espèce bancaire", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("et reste en nature. Il n’existe que les Biens, Produits et services réels en demande qui soldent de façon absolue les", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("redevances.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("En signant, ce contrat, l’utilisateur accepte les principes, les conventions ESMC et les normes d’utilisation du progiciel", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
		   
		   $this->_yPosition -=  15;
	       $this->_xPosition =   37;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   
		   $this->_xPosition = 70;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("inscrits dans le présent contrat et s’engage à respecter toutes les conditions liées à l’usage de son compte", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
	       $this->_yPosition -=  15;
	       $this->_xPosition =   37;
		   $this->drawText("marchand.", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("Article 12 : Dispositions particulières relatives aux têtes de divisions Exécutantes", $this->_xPosition, $this->_yPosition, 'UTF-8');
	
	       $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font1,10);
		   $this->drawText("Les conventions qui suivent sont liées à l’utilisation du compte marchand", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
	       $this->_xPosition = 362;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Elles définissent, cependant, les clauses internes entre les différentes têtes de divisions existantes sur la plateforme", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("et leurs membres ou partenaires en vue d’asseoir toutes les bases de la solvabilité requise.", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       
	       $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("12.1Convention N° 1 :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Entre les structures Têtes de Division Exécutante Partenaires Bancaires et Financiers(S-CM Exécutante PBF),d’une part", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Les Acteurs Consommateurs du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 182;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   212;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", d’autre part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Il est convenu ce qui suit :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Dans le but de former continuellement le déposit et le DAT convenus avec les PBF, les structures ESMC têtes de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Division PBF se mettent d’accord avec les acteurs consommateurs du marché (individus, ménages, institutions,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("entreprises et industries) pour consommer permanemment les marchandises auprès des Distributeurs-Fournisseurs.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("En guise d’optimisation du pouvoir d’achat des consommateurs, les modalités de consommation convenues sont la ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("consommation récurrente et la consommation non récurrente.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Le capital d’achat variable de ces deux pouvoirs d’achat de consommation se fait 5,6 fois la consommation périodique", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("pour le récurrent et 5,6(1/8) fois la consommation une fois de bon pour le non récurrent.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10);
		   $this->drawText("12.2Convention N° 2 :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Entre les structures Têtes de Division Exécutante Partenaires Bancaires et Financiers(S-CM Exécutante PBF),d’une part", $this->_xPosition, $this->_yPosition, 'UTF-8');
	       $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Les Partenaires Bancaires et Financiers du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 230;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition =   260;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText(", d’autre part", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Il est convenu ce qui suit :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Les structures ESMC Têtes de Division Exécutante (S-CM Exécutante PBF) se mettent d’accord avec les Partenaires", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Bancaires et Financiers du marché pour acheter continuellement les créances de leurs divers produits financiers", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("(les escomptes des traites aux Distributeurs-Fournisseurs du marché et les crédits divers accordés aux clients) à ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("condition que les bénéficiaires de ces produits financiers fassent en retour toutes leurs dépenses de consommation", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("et de production sur le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 140;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 170;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("La modalité convenue est celle du paiement par traites aux fournisseurs dont l’escompte par les banques est payé par", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("échéance à ces dernières. A titre d’exemple, 8 échéances par unité de traite escomptée et 22,4 échéances pour tous", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("crédits faits aux membres en vue du financement de leur capital d’achat du pouvoir d’achat.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Pour cela, les structures ESMC Têtes de Division Exécutante (S-CM Exécutante PBF) s’engagent à former la garantie", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("FGFN en guise de DAT en dehors du déposit.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->drawText("Cependant, il est obtenu des Partenaires Bancaires et Financiers dans le cadre du marché commun le procédé de l’achat", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("en retour des biens, produits et services de leurs consommations usuelles auprès des structures ESMC Têtes de Division", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   $this->_yPosition -=  15;
		   $this->_xPosition =   37;
		   $this->drawText("Exécutante (S-CM Exécutante BPS), grâce à leurs  intérêts et frais divers perçus sur le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 426;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 460;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   
		   
		   
		   
	
	
	
	
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
