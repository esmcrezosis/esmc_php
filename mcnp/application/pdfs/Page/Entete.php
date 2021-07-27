<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Entete extends Zend_Pdf_Page {
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
		$this->drawText("",300,8, 'UTF-8');
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
	
	public function addContrat() {
	
	       $this->setFont($this->_normalFont,14);
           $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor(new Zend_Pdf_Color_Html('#978080'));
	       $this->drawText("Contrat d'Achat du Compte Marchand",200,800,'UTF-8');
		   $this->setLineColor(new Zend_Pdf_Color_Html('#978080'));
		   $this->drawLine(100,795,500,795);
		   $this->setLineWidth(2);
		   $this->drawLine(100,792,500, 792);
		   
		   $this->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
		   $noir = new Zend_Pdf_Color_Rgb(0,0,0);
		   $this->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
		   $this->setLineColor($noir);
		   $this->setLineWidth(1);
		   $this->drawRectangle(150,350,450,450);
		   
		   $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		   $this->setFont($font,18);
           $this->_xPosition = 190;
		   $this->_yPosition = 415;
           $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->drawText("CONTRAT  D'ACHAT  DU",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 180;
		   $this->_yPosition = 380;
		   $this->drawText("COMPTE  MARCHAND",$this->_xPosition, $this->_yPosition, 'UTF-8');
		   
		   $this->_xPosition = 383;
           $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $this->setFillColor($rouge);
		   $this->drawText("MCNP",$this->_xPosition, $this->_yPosition, 'UTF-8');
			
		   //$this->setFillColor(new Zend_Pdf_Color_Html('#EFEFEF'));
		   //$this->setFont($this->_normalFont,30);
			
		   //$this->_xPosition = 80;
		   //$this->_yPosition = 250;
		   //$this->drawText("esmc@gacsource.com",80,250,'UTF-8');
	
	
	}
	
    
    //permet d'ajouter une ligne horizontal    
    public function addLine() {
         $this->drawLine($this->_leftMargin, $this->_yPosition, $this->_rightMargin, $this->_yPosition);
         //déplacement du curseur vers le bas de 15 pixels
         $this->_yPosition -= 15;
    }
	
	
}
