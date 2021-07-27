<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratlicence extends Zend_Pdf_Page {
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
          $this->setFont($this->_boldFont,14);
                                $this->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                                $this->drawRoundedRectangle(37,725,565,835,30);
                                $this->drawRoundedRectangle(42,730,560,830,30);
                                $this->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
								$this->setFillColor($noir);
                                $this->_boldFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                                $this->_boldFont1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
                                //unset($pdf->pages[0]);
                                $this->setFont($this->_boldFont,40);
                                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
		                        $this->drawText("M C N P",230,793,'UTF-8');
                                //Charger une image
                                $image = Zend_Pdf_Image::imageWithPath(APPLICATION_PATH.'/../public/images/logo.jpg');
                                $this->drawImage($image,55,775,105,825);
                                $this->setFont($this->_boldFont,14);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("Marché de Crédit en Nature Pérenne",180,779,'UTF-8');
                                
                                //déplacement du curseur vers la droite de 120 
                                $this->_boldFont1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("Arrêté N°10/1533/OAPI/DG portant enrégistrement de la MARQUE N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'UTF-8');
                                $this->drawText("Arrêté N°10/2131/OAPI/DG portant enrégistrement de la MARQUE N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'UTF-8');
                                //$this->drawText("227,Rue des Amandiers Tokoin-Nukafu B.P.:30038 LOME-TOGO Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,750, 'UTF-8');
                                
                                $this->_boldFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                                $this->setFont($this->_boldFont,10);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("SOUSCRIPTION AU CONTRAT INDIVIDUEL DE CONCESSION DE LICENCE DE LA MARQUE ",80,745,'UTF-8');            
                                $this->setFillColor($rouge);
                                $this->drawText("MCNP",180,734,'UTF-8');
								$this->setFillColor($noir);
                                $this->drawText("ET DE CESSION DE SON INFRASTRUCTURE",220,734,'UTF-8');
								$this->drawText("N° : ",400,714,'UTF-8');
                                $this->drawText($contrat->code_membre,430,714,'UTF-8');
								
								
								$this->setFont($this->_boldFont,12);
                                $this->drawText("1.  SOUSCRIPTEUR",240,694,'UTF-8');
								$this->drawLine(255,692,350,692);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("Il est souscrit dans le cadre de la concession de la licence du",40,680,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",333,680,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("et la cession de son infrastructure par :",375,680,'UTF-8');
								
								$this->drawText(" (M/Mme /Ets /Ste/ONG/Association) : …………………………………………………………………",40,668,'UTF-8');
                                if(substr($contrat->code_membre,19,1)=='P') {
                                    $this->drawText(stripslashes (html_entity_decode($contrat->nom_membre."     ".$contrat->prenom_membre)),260,668,'UTF-8');
                                }
                                else {
                                    $this->drawText($contrat->raison_sociale,260,668,'UTF-8');
                                }
								
								
								$this->drawText("d'une somme de",40,656,'UTF-8');
                                $this->drawText("dix mille (10 000) FCFA , en numéraire.",123,656,'UTF-8');
                                $this->drawText("Ces frais de souscription sont effectués de manière définitive, donc non remboursables.",40,644,'UTF-8');
								
								
								$this->setFont($this->_boldFont,12);
                                $this->drawText("2.  MONTANT DE SOUSCRIPTION",240,624,'UTF-8');
                                $this->drawLine(255,622,430,622);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("Le montant de souscription dans le cadre de ce présent contrat est fixé à la somme de dix mille (10 000) ",40,612,'UTF-8');
                                $this->drawText("FCFA indivisible.",40,600,'UTF-8');
								
								
								$this->setFont($this->_boldFont,12);
                                $this->drawText("3.  CONTREPARTIE POUR LA SOUSCRIPTION",240,580,'UTF-8');
                                $this->drawLine(255,578,504,578);
								
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("En contrepartie,le souscripteur devient membre de",40,566,'UTF-8');                                            
                                $this->setFont($this->_boldFont,12);
								$this->drawText("la GAC Togo",285,566,'UTF-8');
								
								$this->setFont($this->_boldFont1,12);
								$this->drawText("aussi longtemps qu’il justifie de son droit",360,566,'UTF-8');
								$this->drawText("de licence sur la marque",40,554,'UTF-8');
								
								$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",160,554,'UTF-8');
								
								
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("par cette présente souscription. Il bénéficie de facto, de tout avantage lié",198,554,'UTF-8');
								$this->drawText("au contrat de licence",40,542,'UTF-8');
								
								$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",145,542,'UTF-8');
								
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("concédée à",185,542,'UTF-8');
								$this->setFont($this->_boldFont,12);
                                $this->drawText("la GAC Togo.",245,542,'UTF-8');
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("A cet effet, à chaque clôture d’exercice, les gains économiques dégagés par l’exploitation du",40,530,'UTF-8');
								
								$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",490,530,'UTF-8');
								
								
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,12);
								$this->drawText("sont partagés équitablement sur le Compte Marchand de tout souscripteur,concessionnaire de droit de la licence.",40,518,'UTF-8');
								
								$this->setFont($this->_boldFont,12);
                                $this->drawText("4. QUOTA DES FRAIS DE SOUSCRIPTION",240,498,'UTF-8');
                                $this->drawLine(255,496,445,496);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("Les frais de souscription audit contrat ne peuvent dépasser le montant de dix mille (10 000) FCFA,  ",40,484,'UTF-8');
								$this->drawText("par conséquent ,il n’est souscrit que ce montant qui justifie sans équivoque, le droit équitable entre",40,472,'UTF-8');
	                            $this->drawText("tous les souscripteurs.",40,460,'UTF-8');
								
								
								$this->setFont($this->_boldFont,12);
                                $this->drawText("5. DROIT DE SOUSCRIRE AU PRESENT CONTRAT ",240,440,'UTF-8');
                                $this->drawLine(255,438,525,438);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("Le droit de souscrire à ce contrat est réservé à tout Togolais et à tout résident sur le territoire togolais désireux ",40,426,'UTF-8');
                                $this->drawText("de faire partir de la Constellation",40,414,'UTF-8');
				                $this->setFont($this->_boldFont,12);
								$this->drawText("GAC Togo",203,414,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("et d’avoir la qualité de concessionnaire de la marque",260,414,'UTF-8');
								 $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",516,414,'UTF-8');
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText(".",554,414,'UTF-8');
								
								$this->setFont($this->_boldFont,12);
                                $this->drawText("6.	OBLIGATIONS DU SOUSCRIPTEUR ",240,394,'UTF-8');
                                $this->drawLine(255,392,454,392);
								
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("En vertu de la solvabilité exigée sur la plateforme MCNP, dans l’intérêt du membre et pour le fait que le",40,380,'UTF-8');
			                    $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",40,368,'UTF-8');
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,12);
                                $this->drawText("a prévu le mécanisme d’accès aux ressources : Capitaux de Revalorisation et d’Accès aux Ressources ",80,368,'UTF-8');
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("Ressources (CRAR), il est formellement interdit au membre de recourir à un quelconque endettement en espèce",40,356,'UTF-8');
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("hors réseau à des fins de ses dépenses étant entendu que la solvabilité sur la plateforme suit sa modalité",40,344,'UTF-8');
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("de paiement notamment en nature ou en numérique Titre Privatif de Solvabilité (TPS) qui n‘est pas de l’espèce.",40,332,'UTF-8');
								$this->setFont($this->_boldFont1,12);
                                $this->drawText("Par conséquent, le concessionnaire de la licence",40,320,'UTF-8');
								$this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",275,320,'UTF-8');
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,12);
								$this->drawText("décline toute responsabilité vis-à-vis de l’exigence",315,320,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("de paiement en espèce hors réseau.",40,308,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("En vertu de la solvabilité exigée sur la plateforme",40,296,'UTF-8');
								$this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",283,296,'UTF-8');
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,12);
								$this->drawText(",dans l’intérêt des acteurs et pour le fait que le",323,296,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",40,284,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,12);
								$this->drawText("a prévu le mécanisme d’accès aux ressources : Capitaux de Revalorisation et d’Accès aux Ressources",80,284,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("(CRAR) ainsi que le mécanisme d’allocation des ressources aux acteurs producteurs transformateurs ",40,272,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("et distributeurs : Subvention Marchande des Coûts d’Investissement et de Production Nouvelle, il est ",40,260,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("formellement interdit aux acteurs de recourir à un quelconque endettement hors réseau à des fins ",40,248,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("d’approvisionnement de leurs marchandises étant entendu que la solvabilité sur la plateforme suit sa modalité",40,236,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("de paiement notamment en nature ou en numérique Titre Privatif de Solvabilité (TPS) qui n‘est pas de l’espèce.",40,224,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("Par conséquent,le concessionnaire de la licence",40,212,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,12);
                                $this->drawText("MCNP",271,212,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,12);
								$this->drawText("décline toute responsabilité vis-à-vis de l’exigence de ",311,212,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("paiement en espèce hors réseau.",40,200,'UTF-8');
								
								$this->setFont($this->_boldFont,12);
								$this->drawText("7. LIEU DE SOUSCRIPTION ",240,180,'UTF-8');
								$this->drawLine(255,178,396,178);
								$this->setFont($this->_boldFont1,12);
								$this->drawText("La présente souscription se fait aux différents endroits désignés par les Membres Fondateurs de l’association",40,166,'UTF-8');
								$this->drawText("Fondation – ReDéMaRe qui sont chargés de constituer la",40,154,'UTF-8');
								$this->setFont($this->_boldFont,12);
								$this->drawText("GAC Togo",320,154,'UTF-8');
								$this->setFont($this->_boldFont1,12);
								$this->drawText("conformément au « ",380,154,'UTF-8');
								$this->setFont($this->_boldFont,12);
								$this->drawText("Contrat de licence",476,154,'UTF-8');
								
								$this->setFillColor($rouge);
								$this->drawText("MCNP",40,142,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,12);
								$this->drawText("et de cession de son Infrastructure",80,142,'UTF-8');
								$this->setFont($this->_boldFont,12);
								$this->drawText("».",260,142,'UTF-8');
								
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
