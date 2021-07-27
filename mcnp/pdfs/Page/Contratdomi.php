<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratdomi extends Zend_Pdf_Page {
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
	    $this->drawText("227, Rue des Amandiers Tokoin-Nukafu B.P. : 30038 Lomé - TOGO",160,15, 'UTF-8');
	    $this->drawText("Tél:+(228) 22 26 06 62 / Site web: redemare.org / Adresse électronique: eumcnp@gmail.com",140,8, 'UTF-8');
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
        
        
   public function addContratdomi($contrat) {
				
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
                                $this->setFont($this->_boldFont,13);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("CONTRAT DE PERENNISATION ET / OU DE DOMICILIATION SUR LE ",50,745,'UTF-8');
                                $this->setFont($this->_boldFont,13);
                                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->drawText("MCNP",485,745,'UTF-8');
                                //$noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                //$this->setFillColor($noir);
                                //$this->drawText("ET",450,740,'UTF-8');
                                //$bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                //$this->setFillColor($bleu);
                                //$this->drawText("CNPnr",467,740,'UTF-8');
                                //$noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                //$this->setFillColor($noir);
                                //$this->drawText(")",496,740,'UTF-8');
                                
                                //déplacement du curseur vers la droite de 120 pixels
		                        $this->_boldFont1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                $this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                
                                //déplacement du curseur vers la droite 
                                $this->drawText("Entre les soussignés : ………………………………………………………………………………………………………………………………",40,715, 'UTF-8');
                                $this->drawText("L’exploitant du",40,705,'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->drawText("MCNP ",95,705,'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("désigné par prestataire d’une part et ",122,705,'UTF-8');
                                $this->drawText("(M. Mme/Mlle/Ets/Sté/ONG/Association)………………………………………………………………………………………………………………………………",40,695, 'UTF-8');
				                if(substr($contrat->code_membre,19,1) =='P') {
                                $this->drawText($contrat->nom_membre."     ".$contrat->prenom_membre,200,695,'UTF-8');
                                }
                                else {
								   
                                   $this->drawText($contrat->raison_sociale,200,695,'UTF-8');
                                }
                                $this->drawText("d’autre part",40,685,'UTF-8');
								
                                $this->drawText("En signant ce contrat, le membre accepte les conditions générales du Crédit en Nature Prépayé (",40,675, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNP",385,675, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText(" ) du Marché de Crédit en Nature ",400,675, 'UTF-8');
                                $this->drawText("Pérenne (",40,665, 'UTF-8');
                                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("MCNP",76,665, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText(").",100,665, 'UTF-8');
                                $this->setFont($this->_boldFont,9);
                                $this->drawText("LE CREDIT EN NATURE PREPAYE (",40,650,'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFont($this->_boldFont1,9);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,9);
                                $this->drawText("CNP",194,650,'UTF-8');
                                $this->setFont($this->_boldFont,9);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont,9);
                                $this->drawText(" )",211,650,'UTF-8');
                                
                                $this->_boldFont1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("Le Crédit en Nature Prépayé",40,640, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNP",144,640,'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("est un Titre Privatif Numérique du Marché de Crédit en Nature Pérenne",163,640,'UTF-8');
                                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("MCNP ",419,640,'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText(". ",445,640,'UTF-8');
                                $this->drawText("Les Titres Privatifs Numériques sont des créances du ",40,630, 'UTF-8');
                                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("MCNP",233,630,'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("dont le Fonds de Garantie du Financement en Nature",260,630,'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("(FGFN)",450,630,'UTF-8');
                                $this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("est le",480,630,'UTF-8');
                                $this->drawText("payeur en dernier ressort. Le",40,620, 'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("FGFN",148,620, 'UTF-8');
                                $this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("est la somme des recettes numéraires des Titres Privatifs Numériques déposés auprès des",175,620, 'UTF-8');
                                $this->drawText("banques pour garantir tout échange desdits titres contre de l’espèce bancaire en cas de solde déficitaire des agrégats : GCpPBF, vs", 40,610,'UTF-8');
                                $this->_yPosition  = 600;
                                $this->_xPosition  = 40;
                                $this->setFont($this->_boldFont1,8);
		                        $this->drawText("EACPR et/ou ", $this->_xPosition, $this->_yPosition, 'UTF-8');
					            $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
								$this->_yPosition  = 600;
                                $this->_xPosition  = 90;
								$this->setFont($this->_boldFont,8);
								$this->drawText("GCnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
								$noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
								$this->_yPosition  = 600;
                                $this->_xPosition  = 113;
								$this->setFont($this->_boldFont1,8);
								$this->drawText("vs ", $this->_xPosition, $this->_yPosition, 'UTF-8');
								$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                                $this->setFillColor($rouge);
								$this->_yPosition  = 600;
                                $this->_xPosition  = 125;
								$this->setFont($this->_boldFont,8);
								$this->drawText("GCnr ", $this->_xPosition, $this->_yPosition, 'UTF-8');
								
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("aux partenaires. ",148,600, 'UTF-8');
								$this->drawText("Le Titre ",40,590, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText(" CNP ",69,590, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("peut être récurrent ou non récurrent. Son montant en espèce dit",92,590, 'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("CAPA",322,590, 'UTF-8');
                                $this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("varie selon qu’il soit récurrent ou non récurrent.",349,590, 'UTF-8');
                                
								$this->setFont($this->_boldFont,9);
                                $this->drawText("LE CREDIT EN NATURE PREPAYE récurrent (",40,575,'UTF-8');
								$this->setFont($this->_boldFont1,9);
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,9);
                                $this->drawText("CNPr",234,575,'UTF-8');
                                
                                $this->setFont($this->_boldFont,9);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont,9);
                                $this->drawText(")",257,575,'UTF-8');
								
								$this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
								
								$this->setFont($this->_boldFont1,8);
                                $this->drawText("Le Crédit en Nature Prépayé récurrent",40,565, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr ",180,565,'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("regroupe deux types de titres : le ",204,565,'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("RPGr ",323,565, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("(Revenu Périodique Garanti récurrent) et l’",344,565, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("Ir",496,565, 'UTF-8');
								
								$noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("(Investissement récurrent).",40,555, 'UTF-8');
								
								$this->drawText("Le ",40,545, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr",53,545, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("est un revenu récurrent affecté directement aux ",77,545, 'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("BPS",248,545, 'UTF-8');
                                $this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
								
								$this->drawText(". Il ne se cumule pas mais se renouvelle à chaque période de façon",266,545, 'UTF-8');
                                $this->drawText("illimitée pour le ",40,535, 'UTF-8');
								$bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("RPGr",95,535, 'UTF-8');
								$noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
								$this->drawText("et à durée déterminée pour le",120,535, 'UTF-8');
								$this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("Ir",230,535, 'UTF-8');
								$this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
								$this->drawText(".La période de renouvellement est de trente jours à ce jour.Cette période",240,535, 'UTF-8');
								$this->drawText("peut varier.",40,525, 'UTF-8');
								$this->drawText("Le ",40,515, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("RPGr",53,515, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("peut se transmettre de génération en génération aussi longtemps que durera la productivité exponentielle des Entreprises",76,515, 'UTF-8');
                                $this->drawText("et Industries.",40,505, 'UTF-8');
								
								$this->drawText("Le capital du",40,495, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr",90,495, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("est un débours et non une épargne. Il est fonction de la",115,495, 'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("PCK.",315,495, 'UTF-8');
								
								$this->setFont($this->_boldFont,9);
                                $this->drawText("Le",40,480, 'UTF-8');
                                $this->setFont($this->_boldFont1,8);
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,9);
                                $this->drawText("CNPr",53,480, 'UTF-8');
                                $this->setFont($this->_boldFont,9);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont,9);
                                $this->drawText(", un revenu non cumulable",75,480,'UTF-8');
								
								$this->setFont($this->_boldFont1,8);
                                $this->drawText("Le détenteur du titre",40,470, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr ",113,470, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("ne peut avoir l’option de cumul.",137,470,'UTF-8');
								
								$this->drawText("Tout Crédit en Nature Prépayé récurrent",40,460, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr ",188,460, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("est un titre dont le revenu n’est pas cumulable. Le ",211,460,'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr ",390,460, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("doit être consommé",412,460, 'UTF-8');
								$this->drawText("périodiquement. S’il n’est pas consommé dans sa période indiquée, cette consommation n’est plus récupérable. Le revenu du",40,450, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr ",488,450, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("attendra donc la période prochaine pour être renouvelé.",40,440, 'UTF-8');
								
								$this->setFont($this->_boldFont,9);
                                $this->drawText("LA RECONSTITUTION PAR DOMICILIATION DU ",40,425, 'UTF-8');
                                $this->setFont($this->_boldFont,9);
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->drawText("CNPr",253,425, 'UTF-8');
								$noir = new Zend_Pdf_Color_Rgb(0,0,0);
								
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("Le capital du ",40,415, 'UTF-8');
                                $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
                                $this->setFillColor($bleu);
                                $this->setFont($this->_boldFont,8);
                                $this->drawText("CNPr ",88,415, 'UTF-8');
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("peut à la demande et par sa suspension être reconstitué en Numérique Noir (NN) ou en nature par le procédé dit",112,415, 'UTF-8');
                                
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText(" KrR.",40,405, 'UTF-8');
								
								$this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->setFont($this->_boldFont1,8);
                                $this->drawText("- Le capital du récurrent se reconstitue en Numérique Noir ",40,395, 'UTF-8');
                                $this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("(NN)",250,395, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("et peut en ce moment s’échanger sur le marché ACNEV TPS vs ",270,395,'UTF-8');
								$this->drawText("TPS sur le",40,385, 'UTF-8');
								$this->setFillColor($rouge);
                                $this->setFont($this->_boldFont,8);
								$this->drawText("MCNP",80,385, 'UTF-8');
								$noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("à concurrence  de son montant qui est fonction de la ",109,385,'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("PCK",290,385, 'UTF-8');
                                $this->setFont($this->_boldFont1,8);
                                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                                $this->setFillColor($noir);
                                $this->drawText("(Période de constitution du Capital).",310,385, 'UTF-8');
								$this->drawText("- Le capital se reconstitue en nature lorsqu’il achète par anticipation en domiciliant le renouvellement du récurrent au terminal",40,375, 'UTF-8');
								$this->drawText("du fournisseur à concurrence de la",40,365, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("PRK",166,365, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("(Période de reconstitution du Capital).",186,365, 'UTF-8');
								$this->drawText("A l’issue de ces deux sortes de reconstitution, le capital du récurrent s’achève.",40,355, 'UTF-8');
								
								
								$this->setFont($this->_boldFont,8);
								$this->drawText("LE CREDIT EN NATURE PREPAYE non récurrent (",40,340, 'UTF-8');
								$this->setFillColor($bleu);
								$this->drawText("CNPnr",228,340, 'UTF-8');
								$this->setFillColor($noir);
								$this->drawText(")",253,340, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("Le",40,330, 'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $this->setFillColor($bleu);
								$this->drawText("CNPnr",54,330, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("regroupe aussi deux types de titres : le",82,330, 'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $this->setFillColor($bleu);
								$this->drawText("RPGnr",224,330, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("(Revenu Périodique Garanti non récurrent) et l’",250,330, 'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $this->setFillColor($bleu);
								$this->drawText("Inr",417,330, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("(Investissement non",430,330, 'UTF-8');
								$this->drawText("récurrent).",40,320, 'UTF-8');
								$this->drawText("Le",40,310, 'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $this->setFillColor($bleu);
								$this->drawText("CNPnr",54,310, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("est affecté de façon cumulée, directement aux",82,310, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("BPS.",250,310, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("Il ne se renouvelle pas puisque son capital ne vise pas la pérennité du ",268,310, 'UTF-8');
								$this->drawText("revenu aux titulaires.",40,300, 'UTF-8');
								$this->drawText("Le",40,290, 'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $this->setFillColor($bleu);
								$this->drawText("CNPnr",54,290, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("est fonction des variables",82,290, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("PCK",175,290, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("et",194,290, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("PRK.",204,290, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("Son capital est un débours et non une épargne. ",225,290, 'UTF-8');
								
								$this->setFont($this->_boldFont,8);
								$this->drawText("RECONSTITUTION PAR DOMICILIATION du",40,275, 'UTF-8');
								$this->setFillColor($bleu);
								$this->drawText("CNPnr",216,275, 'UTF-8');
								$this->setFillColor($noir);
								
								$this->setFont($this->_boldFont1,8);
								$this->drawText("Le",40,265, 'UTF-8');
								$this->setFont($this->_boldFont,8);
                                $this->setFillColor($bleu);
								$this->drawText("CNPnr",54,265, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->setFillColor($noir);
								$this->drawText("constitue une domiciliation du remboursement périodique qui garantit la solvabilité du",82,265, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("BPS",387,265, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("consommé sur le",407,265, 'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,8);
								$this->drawText("MCNP",470,265, 'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,8);
								$this->drawText(".",495,265, 'UTF-8');
								$this->drawText("- Le capital du",40,255, 'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("CNPnr",95,255, 'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,8);
								$this->drawText("peut à la demande et par sa suspension être reconstitué par le procédé d’échange en Numérique Noir",125,255, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("(NN)",492,255, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("ou en nature. ",40,245, 'UTF-8');
								$this->drawText("- Le capital du non récurrent  se reconstitue en",40,235, 'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("NN ",208,235, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("et s’échange sur le marché ACNEV TPS vs TPS sur le",222,235, 'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,8);
								$this->drawText("MCNP",420,235, 'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,8);
								$this->drawText("lorsqu’il est",450,235, 'UTF-8');
								$this->drawText("revendu aux tiers à concurrence du montant de son",40,225, 'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("CAPA .",225,225, 'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("La reconstitution du capital",40,215, 'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("CNPnr",140,215,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,8);
								$this->drawText("s’épuise avec  le remboursement aux distributeurs. La domiciliation du capital du non récurrent",167,215,'UTF-8');
								$this->drawText("se fait à l’issue d’engagement entre les distributeurs et les consommateurs. ",40,205, 'UTF-8');
								
								$this->setFont($this->_boldFont,8);
								$this->drawText("RECONSTITUTION PAR DOMICILIATION DE LA",40,190, 'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("GC",230,190,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",241,190,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("La",40,180,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("GC",56,180,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",67,180,'UTF-8');
								$this->drawText("(Grande Consommation préfinancée)",75,180,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("est la recette des distributeurs sur le",205,180,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,8);
								$this->drawText("MCNP",330,180,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,8);
								$this->drawText("aux",357,180,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("TEGC",374,180,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",396,180,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText(". Sa reconstitution se fait",403,180,'UTF-8');
								$this->drawText("par des échanges soit en unités d’investissement et de consommation",40,170,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("aux accès 11 et 12",290,170,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("soit en",354,170,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("EACPR",382,170,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("à",412,170,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("l’accès 13",419,170,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("dans le cas",453,170,'UTF-8');
								$this->drawText("des importations et des",40,160,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("GC",125,160,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",136,160,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("détenues par les entreprises agréées à cet échange.",143,160,'UTF-8');
								$this->drawText("- En cas de reconstitution en",40,150,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,8);
								$this->drawText("CNCS",146,150,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont1,8);
								$this->drawText(",la partie de la",170,150,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("GC",224,150,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",235,150,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("destinée à cet échange passe par la domiciliation au",242,150,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("TE",430,150,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,8);
								$this->drawText("SMCIPN",440,150,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p.",471,150,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("- En cas de reconstitution en Numérique Noir (NN), la",40,140,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("GC",232,140,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",244,140,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("attend la maturité de ses traites qu’elle constitue. Ainsi à la maturité,",254,140,'UTF-8');
								$this->drawText("les traites deviennent du Numérique Noir",40,130,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("(NN)",187,130,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("qui peut aisément s’échanger sur le",208,130,'UTF-8');
								$this->setFillColor($rouge);
								$this->setFont($this->_boldFont,8);
								$this->drawText("MCNP",338,130,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText(".",364,130,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("- S’agissant des importateurs opérateurs économiques et des Entreprises Publiques à caractère Commercial et Industriel",40,120,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("(EPIC)",473,120,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("leurs",40,110,'UTF-8');
								$this->setFillColor($bleu);
								$this->setFont($this->_boldFont,8);
								$this->drawText("GC",60,110,'UTF-8');
								$this->setFillColor($noir);
								$this->setFont($this->_boldFont,8);
								$this->drawText("p",72,110,'UTF-8');
								$this->setFont($this->_boldFont1,8);
								$this->drawText("se reconstituent par voie d’escompte bancaire, par demande de crédit bail, ou de crédit documentaire auprès des",81,110,'UTF-8');
								$this->drawText("Partenaires Bancaires et Financiers qui logent les ressources du",40,100,'UTF-8');
								$this->setFont($this->_boldFont,8);
								$this->drawText("FGFN.",273,100,'UTF-8');
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
                                
              
   
   
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
