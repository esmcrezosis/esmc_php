<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratsuitenext extends Zend_Pdf_Page {
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
		$this->drawText("3",300,8, 'UTF-8');
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
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font,10); 
		   $this->drawText("Article 5 : Durée", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font1,10);
		   $this->drawText("Ce contrat est à durée indéterminé.", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font,10);
		   $this->drawText("Article 6 : Lieu d’exécution du", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 182;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		   $this->drawText("Les opérations liées au", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 142;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 174;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("pourront s’opérer sur l’ensemble du Territoire National.", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font,10);
		   $this->drawText("Article 7: Avantages  liés  à  l’ouverture  de  compte  marchand", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_yPosition -=  20;
		   $this->_xPosition =   37;
		   $this->setFont($font1,10);
		   $this->drawText("Le Compte Marchand", $this->_xPosition, $this->_yPosition,'UTF-8');
		   
		   $this->_xPosition = 137;
		   $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->setFont($font,10);
           $this->drawText("MCNP", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 168;
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
           $this->drawText("permet à son détenteur d’obtenir les avantages suivants :", $this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- l’Achat  du Pouvoir d’Achat",$this->_xPosition, $this->_yPosition, 'UTF-8');
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
		  $this->drawText("- le Bail Nue – Propriété (BNP), c’est-à-dire au prêt financier ou bancaire cautionné par",$this->_xPosition, $this->_yPosition, 'UTF-8');
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
		  $this->drawText("- l’investissement nrPRE,",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  $this->_yPosition -=  15;
		  $this->_xPosition =   60;
		  $this->drawText("- l’emploi social marchand rémunéré en unités",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
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
		  $this->drawText("- l’enrôlement des entreprises et industries à l’investissement alloué en unités",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
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
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   37;
		  $this->setFont($font,10);
		  $this->drawText("Article 8 : Les  obligations  du  détenteur  du  Compte  Marchand  MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   60;
		  $this->setFont($font1,10);
		  $this->drawText("8.1 :Obligations liées aux personnes physiques", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   37;
		  $this->setFont($font1,10);
		  $this->drawText("La Personne Physique titulaire du Compte Marchand", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 275;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 307;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("est seule responsable de la gestion de son Compte et est ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   37;
		  $this->drawText("de la productivité de sa communauté. A cet effet, elle dispose de l’outil d’enrôlement dit", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 427;
		  $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
          $this->setFillColor($bleu);
		  $this->setFont($font,10);
          $this->drawText("nrPRE Kit Technopole", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 539;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("pour :", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
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
		  $this->_xPosition =   37;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("Elle est garante en dernier ressort de la solvabilité absolue et pérenne, de la liquidité absolue ainsi que de la disponibilité ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   37;
		  $this->drawText("absolue du travail sur le marché", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 182;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 214;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("dans le respect des normes du modèle de l’Economie Universelle(EU) liées aux ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   37;
		  $this->drawText("modalités de paiement en réponse aux attentes de sa communauté. ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   60;
		  $this->setFont($font1,10);
		  $this->drawText("8.2 : Obligations liées aux Personnes Morales", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=   20;
		  $this->_xPosition  =   35;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("Concernant les Personnes Morales regroupées en divisions (division administratrice et division animatrice du",$this->_xPosition, $this->_yPosition, 'UTF-8');
		  
		  //$this->_yPosition -=  15;
		  $this->_xPosition  =  520;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  550;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("),", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  37;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("leurs obligations sont les suivantes : ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   70;
		  $this->setFont($font1,10);
		  $this->drawText("8.2.1 : Pour la FILIERE", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  20;
		  $this->_xPosition =   35;
		  $this->drawText("La Filière tout comme l’ACNEV et la Technopole sont les trois entités, têtes de division qui agréent des Entreprises et", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   35;
		  $this->drawText(" Industries membres et partenaires dans leurs Créneaux : Production, Transformation et Distribution composé chacun", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition =   35;
		  $this->drawText("de Grossistes, Semi-Grossistes et Détaillants grâce au Compte Marchand d’administration Filière.", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  37;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("Elle est garante en dernier ressort sur le marché ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 255;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  289;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText(":", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  60;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("- de la liquidité absolue de son Bien, Produit et Service,", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  60;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("- de la disponibilité absolue de son Bien, Produit et Service, (la liquidité et la disponibilité absolues qui sous ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  37;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
          $this->drawText("entendent la qualité et la quantité du Bien Produit et Service sont gage de la solvabilité absolue et pérenne de,", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  37;
		  $this->drawText("ladite Filière),", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		   $this->_yPosition -=  15;
		  $this->_xPosition  =  60;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("- du respect des règles de gestion, des normes de l’économie circulaire, de l’économie d’usage, de l’économie de  ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  37;
		  $this->drawText("service et de l’économie de cycle court ainsi que le respect des normes du modèle EU liées aux modalités de paiement,", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_yPosition -=  15;
		  $this->_xPosition  =  60;
		  $this->drawText("- de la réponse aux attentes du", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition = 203;
		  $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
          $this->setFillColor($rouge);
		  $this->setFont($font,10);
          $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
		  
		  $this->_xPosition  =  235;
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $this->setFillColor($noir);
		  $this->setFont($font1,10);
		  $this->drawText("face à la division.", $this->_xPosition, $this->_yPosition,'UTF-8');
	}
	
	
     
    /*    
    public function addContrat($contrat) {
             
			//$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
            //$font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
		    $this->_yPosition -=  10;
		    $this->_xPosition =   40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10); 
			$this->drawText("La Filière tout comme l’ACNEV et la Technopole sont les trois entités, têtes de division qui agréent la mise sur chaîne ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_yPosition -=  10;
		    $this->_xPosition =   40;
			$this->drawText("des Entreprises et Industries membres et partenaires dans leurs Créneaux : Production, Transformation et Distribution ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  10;
		    $this->_xPosition =   40;
			$this->drawText("composé chacun de Grossistes, Semi-Grossistes et Détaillants grâce à son Compte Marchand PM.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("- Pour l' ACNEV ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("L’ACNEV se charge de l’achat des intrants, de la centralisation des demandes et des ventes du BPS de la division sur", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("le marché ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 90;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		    $this->_xPosition  =  122;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU liées aux modalités de paiement.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
			$this->setFont($font1,10);
            $this->drawText("Il est garant en dernier ressort :",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• de la solvabilité absolue et pérenne de son BPS, ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• de la liquidité absolue de son BPS ainsi que ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• de la disponibilité absolue de son BPS sur le marché",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			
		    $this->_xPosition  =  343;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		    $this->_xPosition  =  375;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
			$this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  108;
			$this->drawText("en réponse aux attentes du",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  235;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  268;
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
			$this->setFont($font1,10);
            $this->drawText("face à la division. ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("L’ACNEV tout comme la Filière et la Technopole sont les trois entités, têtes de division qui agréent la mise sur chaîne",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("des Entreprises et Industries membres et partenaires dans leurs Créneaux : Production, Transformation et Distribution ",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("composé chacun de Grossistes, Semi-Grossistes et Détaillants grâce à son Compte Marchand PM.",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("- 	Pour la TECHNOPOLE ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("La Technopole est garante :", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• de l’éducation,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• de l’apprentissage,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• de la formation,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• des stages,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• du recyclage,",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• des recherche et développement et",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  100;
			$this->drawText("• du plein emploi de la division au service de l’industrialisation du BPS sur le marché",$this->_xPosition,$this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  475;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  108;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU liées aux modalités de paiement.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("Elle est garante en dernier ressort de la solvabilité absolue et pérenne, de la liquidité absolue ainsi que de la disponibilité", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("absolue du BPS sur le marché", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  180;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  213;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("dans le respect des normes du modèle EU en réponse aux attentes du", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  530;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  508;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
            $this->drawText("", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("face à la division.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("La Technopole tout comme la Filière et l’ACNEV sont les trois entités, têtes de division qui agréent la mise sur chaîne ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("des Entreprises et Industries membres et partenaires dans leurs Créneaux : Production, Transformation et Distribution  ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("composé Grossistes, Semi-Grossistes et Détaillants grâce à son Compte Marchand PM.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->setFillColor($noir);
		    $this->setFont($font,10);
            $this->drawText("Pour la sécurité de tous sur le", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  185;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
		    $this->_xPosition  =  217;
			$this->setFillColor($noir);
		    $this->setFont($font,10);
            $this->drawText(", tout titulaire de Compte Marchand est responsable de toute utilisation", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->setFillColor($noir);
		    $this->setFont($font,10);
            $this->drawText("de ses moyens d’authentification (biométrie et cartes) ainsi que du rôle pour lequel le compte lui est affecté.", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  40;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,12);
		    $this->drawText("CARACTERISTIQUES DES UNITES",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_xPosition = 244;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,12);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Les unités",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_xPosition = 88;
		    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  120;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("sont les titres privatifs de solvabilité qui se regroupent en deux catégories : le pouvoir d’achat appelé ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
			$this->drawText("Crédit en Nature Prépayé(",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_xPosition = 157;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 177;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(") et le crédit productif appelé Crédit en Nature Convertible Salaire (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  472;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			
			$this->_xPosition  =  500;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(") .",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			
			$this->_yPosition -=  40;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,12);
		    $this->drawText("Le Crédit en Nature Prépayé (",$this->_xPosition, $this->_yPosition, 'UTF-8');
			$this->_xPosition = 208;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,12);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			$this->_xPosition  =  233;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font,12);
		    $this->drawText(")",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 57;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  80;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("est le Titre Privatif  Numérique qui fait office de pouvoir d’achat libérateur, c’est-à-dire soldé d’avance par le ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("bénéficiaire sur le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  120;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  149;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText(".",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Cependant, le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 106;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  130;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("est la créance du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  = 210;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  243;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("à solder en nature grâce à l’usage du titre privatif de solvabilité le ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  535;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("qui lui fait office de crédit productif. ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le Titre ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 77;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  100;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("peut être récurrent ou non récurrent.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("C’est le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition = 76;
		    $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
		    $this->setFont($font,10);
            $this->drawText("CNP ", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  99;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("qui permet de former le Fonds de Garantie du Financement en Nature (FGFN) nominal non décaissable,",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("tandis que le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  100;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  =  135;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("permet de former le FGFN réel, Biens, Produits et Services, c’est-à-dire que le",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  487;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("CNCS", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 518;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("est la ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("rémunération des forces productrices des entreprises et industries.",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("Le FGFN en ses deux versions (nominal et réel) est le gage du",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_xPosition  =  322;
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
		    $this->setFont($font,10);
            $this->drawText("MCNP", $this->_xPosition, $this->_yPosition,'UTF-8');
			
			$this->_xPosition  = 354;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("vis-à-vis de tout partenaire bancaire et financier ",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
			$this->_yPosition -=  15;
		    $this->_xPosition  =  40;
		    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
		    $this->setFont($font1,10);
		    $this->drawText("ainsi que de tout fournisseur extérieur de Biens, Produits et Services.",$this->_xPosition, $this->_yPosition, 'UTF-8');      
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
