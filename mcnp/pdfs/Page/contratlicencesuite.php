<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratlicencesuite extends Zend_Pdf_Page {
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
        
        
    public function addContratlicence($contrat) {
          
                    $this->_boldFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                    $this->_boldFont1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
                    

					
				    $this->setFont($this->_boldFont,12);
					$this->drawText("8.	REGLEMENT DES LITIGES ",240,800,'UTF-8');
					$this->drawLine(255,798,407,798);
					$this->setFont($this->_boldFont1,12);
					$this->drawText("Les parties s’engagent à régler à l’amiable toutes les contestations pouvant naître entre elles à l’occasion de",40,786,'UTF-8');
					$this->drawText("de l’exécution du présent contrat. En cas d’échec du règlement à l’amiable, tous différends découlant de ce",40,774,'UTF-8');
					$this->drawText("contrat ou en relation avec lui y compris toute question concernant son existence, sa validité ou son expiration,",40,762,'UTF-8');
					$this->drawText("seront soumis à l’arbitrage sous l’égide de la Cour d’Arbitrage de la Chambre de Commerce et d’Industrie du ",40,750,'UTF-8');
                    $this->drawText("Togo et seront définitivement tranchés suivant son règlement d’arbitrage tel qu’il est en vigueur à la date ",40,738,'UTF-8');
                    $this->drawText("du présent contrat.",40,726,'UTF-8');

					
					
					
                    $this->setFont($this->_boldFont,12);
					$this->drawText("9.	MODALITE D’ARBITRAGE ",240,706,'UTF-8');
					$this->drawLine(255,704,407,704);
					$this->setFont($this->_boldFont1,12);
					$this->drawText("L’arbitrage se fait par un collège de trois arbitres comme suit :",40,688,'UTF-8');
					
					$this->drawText("-	Un arbitre désigné par l’exploitant des marques",60,676,'UTF-8');
			        $this->drawText("-	Un arbitre désigné par le membre,",60,664,'UTF-8');
			        $this->drawText("-	Le troisième arbitre est désigné par les deux premiers arbitres et est d’office le président. ",60,652,'UTF-8');
			        $this->drawText("Toutefois, les trois arbitres désignés doivent avoir compétence à siéger  à la",40,640,'UTF-8');
			        $this->setFont($this->_boldFont,12);
			        $this->drawText("CATO",410,640,'UTF-8');
			        $this->setFont($this->_boldFont1,12);
			        $this->drawText(", c’est-à-dire être",450,640,'UTF-8');
					$this->drawText("confirmés par le Comité de Médiation et d’Arbitrage de la Cour.",40,628,'UTF-8');
					$this->drawText("La loi applicable à la procédure et au fond du litige est celle adoptée par la Cour d’Arbitrage du Togo (",40,616,'UTF-8');
					$this->setFont($this->_boldFont,12);
			        $this->drawText("CATO",533,616,'UTF-8');
					$this->setFont($this->_boldFont1,12);
					$this->drawText(")",567,616,'UTF-8');
					
					
			
			        $this->setFont($this->_boldFont,12);
			        $this->drawText("10. LANGUE D’INTERPRETATION ET D’ARBITRAGE",240,596,'UTF-8');
					$this->drawLine(255,594,545,594);
			        $this->setFont($this->_boldFont1,12);
			        $this->drawText("Ce contrat peut être traduit dans toutes les langues ayant un intérêt avec ledit contrat. Toutefois, le français est",40,582,'UTF-8');
			        $this->drawText("et reste la langue de référence pour toute interprétation des clauses du présent contrat et le cas échéant la langue ",40,570,'UTF-8');
			        $this->drawText("d’arbitrage.",40,558,'UTF-8');
			
			
					$this->setFont($this->_boldFont,12);
			        $this->drawText("11. ANNEXE",240,538,'UTF-8');
					$this->drawLine(255,536,310,536);
					$this->setFont($this->_boldFont1,12);
			        $this->drawText("La souscription au présent contrat  emporte la signature du «",40,524,'UTF-8');
					
					
					$this->setFont($this->_boldFont,12);
			        $this->drawText("Contrat de licence",334,524,'UTF-8');
					$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
					$this->setFillColor($rouge);
				    $this->drawText("MCNP",431,524,'UTF-8');
					$noir = new Zend_Pdf_Color_Rgb(0,0,0);
					$this->setFillColor($noir);
					$this->setFont($this->_boldFont,12);
					$this->drawText("et de cession de ",471,524,'UTF-8');
					
					
					$this->setFillColor($noir);
					$this->setFont($this->_boldFont,12);
					$this->drawText("Infrastructure",40,512,'UTF-8');
					$this->setFont($this->_boldFont1,12);
					$this->drawText("» pour lequel la présente souscription est faite et annexée.",120,512,'UTF-8');
					
					
					
					
					$this->drawText("Fait à Lomé, le…………………………",360,472,'UTF-8');
					$this->drawText($contrat->DATECONTRAT,450,472,'UTF-8');
					
					
					
					
					
					$this->drawText("Pour le souscripteur",40,422,'UTF-8');
                    $this->setFont($this->_boldFont,12);
                    $this->drawText("Essohamlon SAMA",240,380,'UTF-8');
					$this->drawLine(240,378,342,378);
					
					
					
					



					
					
					
					
					
					
					
					$this->setFont($this->_boldFont,8);
                    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $this->setFillColor($noir);
                    $this->drawText("227, Rue des Amandiers Tokoin-Nukafu B.P. : 30038 Lomé - TOGO",160,15, 'UTF-8');
		            $this->drawText("Tél:+(228) 22 26 06 62 / Site web: redemare.org / Adresse électronique: eumcnp@gmail.com",140,8, 'UTF-8'); 
										
		   
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
	
        
        //permet d'ajouter une ligne horizontal
        
    public function addLine() {
         $this->drawLine($this->_leftMargin, $this->_yPosition, $this->_rightMargin, $this->_yPosition);
         //déplacement du curseur vers le bas de 15 pixels
         $this->_yPosition -= 15;
    }
	
	
}
