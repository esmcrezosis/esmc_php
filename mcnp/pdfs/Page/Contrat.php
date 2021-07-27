<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contrat extends Zend_Pdf_Page {
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
    
    
    public function createStyle() {
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
		$this->drawText("1",300,8, 'UTF-8');
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
	    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		   
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		
		$this->setFont($font1,10);
		$this->_yPosition -=  0;
        $this->_xPosition  =  37;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->drawText("Entre  les soussignés :",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("ESMC (Entreprise Sociale de Marché Commun) SARL U au capital de 1 000 000 F CFA ;Siège social : Lomé(TOGO),",$this->_xPosition,$this->_yPosition,'UTF-8');
	    
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Nukafu, Angle rue Sagouda,Kiyéou et Bandjéli BP 30038,immatriculé au RCCM sous le numéro TG-LOM 2014 B514,",$this->_xPosition,$this->_yPosition,'UTF-8');
	    
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("représenté par son Gérant Monsieur Essohamlon SAMA Ci-après dénommée « le Vendeur»,",$this->_xPosition,$this->_yPosition,'UTF-8');
	    
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("D’une part",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Et",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  45;
		$this->drawText(" o	      La collectivité   […………………………………………]",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  45;
		$this->drawText(" o	      LA SOCIETE […………………………………………]  au capital  de  [……………..] Immatriculée au RCCM,sous",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  70;
		$this->drawText("le numéro [………………..], dont le siège social est [……….], représentée par [………………..] dûment habilité",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  70;
		$this->drawText("aux fins des présentes / Ou",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  45;
		$this->drawText(" o	      Personne physique (référence………………….)",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Ci-après dénommée «l’acheteur»,",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("D’autre part",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  30;
        $this->_xPosition  =  37;
		$this->drawText("Il est convenu ce qui suit :",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->setFont($font,10);
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Article 1 : Objet",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->setFont($font1,10);
		$this->_yPosition -=  20;
        $this->_xPosition  =  70;
		$this->drawText("1.1: Pour la collectivité",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Ce contrat s’entend dans le cadre de l’exploitation collective du Compte Marchand d’administration",$this->_xPosition,$this->_yPosition,'UTF-8');
		$this->_xPosition = 475;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		$this->_xPosition = 505;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
        $this->drawText("(Marché de", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Crédit en Nature Pérenne) pour toute collectivité organisée d’aval en amont. Les collectivités ici désignées sont les",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("entités qui représentent la communauté dans le cadre de son développement sans-laissés pour compte impliquant",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("toutes les factions économiques d’une communauté qui s’agrège à l’organisation d’aval en amont dans un pays.",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->setFont($font1,8);
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Exemple de communauté organisée:les Communautés de Développement de Village(CDV),les Communautés de Développement de Quartier(CDQ). ",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->setFont($font1,10);
		$this->_yPosition -=  20;
        $this->_xPosition  =  70;
		$this->drawText("1.2 : Pour les personnes physiques et morales ",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Ce contrat tient lieu d’acquisition du Compte Marchand",$this->_xPosition,$this->_yPosition,'UTF-8');
		$this->_xPosition = 282;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		$this->_xPosition = 314;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
        $this->drawText("(Marché de Crédit en Nature Pérenne) pour toute", $this->_xPosition, $this->_yPosition, 'UTF-8');
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("physique ou morale. La caractéristique du compte marchand est son inter dépendance au sein de la communauté. ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->setFont($font,10);
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Article 2 : Caractéristiques du",$this->_xPosition,$this->_yPosition,'UTF-8');
		$this->_xPosition = 183;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		
		$this->setFont($font1,10);
		$this->_yPosition -=  20;
        $this->_xPosition  =  70;
		$this->drawText("2.1 : Définition",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Le",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_xPosition = 50;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->_xPosition = 82;
        $this->drawText("est le progiciel conçu pour la gestion de la solvabilité intégrée des transactions marchandes entre acteurs ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("offreurs et demandeurs du marché global.",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Le progiciel",$this->_xPosition,$this->_yPosition,'UTF-8');
		$this->_xPosition = 90;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->_xPosition = 121;
        $this->drawText("est porteur de Compte Marchand : personne physique et morale qui s’acquiert par voie d’achat mais ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("n’est pas transmissible.",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->setFont($font1,10);
		$this->_yPosition -=  20;
        $this->_xPosition  =  70;
		$this->drawText("2.2 : Particularité",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Le Compte Marchand",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_xPosition = 135;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		$this->_xPosition = 165;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->drawText("est le compte servant pour toute Personne Physique ou Morale à investir, à travailler ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("contre salaire, à vendre et à acheter grâce aux unités numériques émises par le",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_xPosition = 395;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_xPosition = 425;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->drawText(". Ces unités sont le pouvoir", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("d’achat, contrepartie de la monnaie bancaire dépensée par toute personne physique ou morale acteur du",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_xPosition = 506;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_xPosition = 535;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
		$this->drawText(".", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("La monnaie bancaire dépensée pour l’acquisition des unités forme le Fonds qui Garantit le Financement en Nature",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("(FGFN), caution du Marché de Crédit en Nature Pérenne.",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  70;
		$this->drawText("2.3 : Structure et organisation du compte marchand",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("Les  Comptes Marchands Personnes Morales se regroupent en divisions selon leur produit spécifique. Il y a les",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Comptes Marchands qui vendent appelés Opérateurs Economiques et ceux qui ne vendent pas appelés Opérateurs",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  15;
        $this->_xPosition  =  37;
		$this->drawText("Socio – Economiques.",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("On distingue deux sortes de divisions : ",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("- les divisions qui administrent le",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_xPosition = 184;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_xPosition = 217;
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $this->setFillColor($noir);
        $this->drawText("et ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		
		$this->_yPosition -=  20;
        $this->_xPosition  =  37;
		$this->drawText("- les divisions qui animent le",$this->_xPosition,$this->_yPosition,'UTF-8');
		
		$this->_xPosition = 167;
		$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
        $this->setFillColor($rouge);
        $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
	}
	
	
	/*
	public function addContrat($contrat) {
          
          $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
          //$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
          //$font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		  
		  $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
          $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		  
		  $this->setFont($font,14);
		  $this->_yPosition -=0;
          $this->_xPosition =120;
          $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->drawText("CONTRAT D’ACHAT DU COMPTE MARCHAND (", $this->_xPosition, $this->_yPosition, 'UTF-8');
          $this->_xPosition =445;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition =485;
          $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->drawText(" ) ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -= 4;
		  $this->drawLine(120,$this->_yPosition,492,$this->_yPosition);
		  
		  $this->setFont($font1,10);
		  $this->_yPosition -=  30;
          $this->_xPosition  =  40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->drawText("Ce contrat tient lieu de droit d’exploitation du Compte Marchand ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 325;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->setFont($font1,10);
		  $this->_xPosition = 356;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->drawText("(Marché de Crédit en Nature Pérenne) pour toute ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
          $this->_xPosition  =  40;
		  $this->drawText("Personne Physique ou Morale.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
          $this->_xPosition  =  40;
		  $this->drawText("Le ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 53;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 84;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("est le progiciel conçu pour la gestion de la solvabilité intégrée des transactions marchandes entre acteurs ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition = 40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("offreurs et demandeurs du marché global . ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Le Compte Marchand ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 140;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 173;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("est le compte servant pour toute Personne Physique ou Morale à investir,à travailler contre ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("salaire,à vendre et à acheter grâce aux unités numériques émises par le", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 363;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 395;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(".Ces unités sont le pouvoir d’achat,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("contrepartie de la monnaie bancaire dépensée par toute personne physique ou morale acteur du", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 473;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_xPosition = 507;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(". La monnaie ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("bancaire dépensée pour l’acquisition des unités forme le Fonds de Garantie du Financement en Nature,caution du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("Marché de Crédit en Nature Pérenne. Les Comptes Marchands Personnes Morales se regroupent en divisions selon leur ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("produit spécifique. Il y a les Comptes Marchands qui vendent appelés Opérateurs Economiques et ceux qui ne vendent ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("pas appelés Opérateurs Socio – Economiques.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("On distingue deux sortes de divisions :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- les  divisions qui administrent le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 210;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 242;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- les divisions qui animent le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 188;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Les divisions s’organisent en Créneaux Producteurs, Transformateurs et Distributeurs et regroupent :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("-  la Filière,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("-  l’ACNEV (Achat Crédit en Nature Entrepôt et Ventes),",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("-  la Technopole,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("-  les Grossistes,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("-  les Semi – Grossistes et",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("-  les Détaillants.",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   40;
		  $this->drawText("Le Compte Marchand Personne Physique est le compte de tout individu sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 390;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  30;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("CONDITIONS GENERALES",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Peuvent acheter le Compte Marchand les personnes morales et les personnes physiques qui adhèrent au mode",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   40;
		  $this->drawText("d’entreprendre de Marché Commun (ESMC) /",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition = 245;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_xPosition  = 280;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("dont les conditions sont les suivantes :",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=  30;
		  $this->_xPosition =   40;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font,12);
		  $this->drawText("Principes",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("1.Accepter que le Revenu Périodique Garanti pérenne pour tous entretenu par le travail productif sur le marché",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
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
		  $this->drawText("2.Accepter le mode de payement en nature géré par la comptabilité intégrée au progiciel",$this->_xPosition, $this->_yPosition, 'UTF-8');
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
		  $this->drawText("3.Accepter la solvabilité absolue de l’Humain par la monétisation du travail  productif  dont  il  est  porteur, ",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("4.Accepter que l’employé soit entrepreneur et que l’entrepreneur soit employé vis-à-vis des responsabilités de",$this->_xPosition, $this->_yPosition, 'UTF-8');
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
		  $this->drawText("5.Production et consommation respectant la nature,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("6.Solvabilité absolue assurée par la compensation en nature entre Divisions organisées comme suit :Filière,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   68;
		  $this->drawText("Technopole,ACNEV,Grossistes, Semi-grossistes et Détaillants dans les créneaux Producteur, Transformateur", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   68;
		  $this->drawText("et Distributeur ;", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("7.Production et consommation respectant l’économie d’usage qui avorte l’épargne et la thésaurisation,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("8.Production et consommation respectant l’économie de service qui implique l’achat de services plutôt que ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   68;
		  $this->drawText("l’achat-possession,", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("9.Production et consommation respectant l’économie circulaire qui implique le renouvelable et le recyclable ", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   68;
		  $this->drawText("plutôt que l’économie linéaire (consommer et jeter),", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("10.Production et consommation respectant l’économie de circuit court (produire localement) et de cycle court", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   72;
		  $this->drawText("(formation et  apprentissage brefs ou accélérés) et", $this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=   15;
		  $this->_xPosition  =   60;
		  $this->drawText("11.Respecter les principes, les conventions ESMC et les normes d’utilisation du progiciel MCNP.", $this->_xPosition, $this->_yPosition, 'UTF-8');          
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
