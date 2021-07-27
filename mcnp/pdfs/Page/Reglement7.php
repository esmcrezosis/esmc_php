<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Reglement7 extends Zend_Pdf_Page
{
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
 
	public function  __construct($param1, $param2 = null, $param3 = null)
	{
		parent::__construct($param1, $param2, $param3);
 
		//à savoir: l'origine de la page démarre en bas à gauche !!!
		$this->_yPosition = $this->getHeight() - 50;
		$this->_xPosition = 50;
		$this->_leftMargin = 50;
		$this->_rightMargin = $this->getWidth() - 50;
 
		//définition des polices qui seront utilisées sur la page
		$this->_normalFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
		$this->_boldFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
 
		$this->createStyle();
		$this->setFooter();
	}
 
	public function createStyle()
	{
		//création d'un style pour la page
		$style = new Zend_Pdf_Style();
		//couleur du texte
		$style->setFillColor(new Zend_Pdf_Color_Html('#333333'));
		//couleur des lignes
		$style->setLineColor(new Zend_Pdf_Color_Html('#036FAB'));
		//épaisseur des lignes
		$style->setLineWidth(1);
		//définition de la police
		$style->setFont($this->_normalFont, 12);
		//application du style à la page
		$this->setStyle($style);
	}
 
	//permet de définir un titre à notre page
	public function setPageTitle()
	{
		//modification de la police
		$this->setFont($this->_boldFont, 16);
		$this->drawText("Facturation", $this->_xPosition, $this->_yPosition, 'UTF-8');
		//déplacement du curseur vers le bas de 15 pixels
		$this->_yPosition -= 15;
		$this->drawLine($this->_leftMargin, $this->_yPosition, $this->leftMarin + 210, $this->_yPosition);
		//déplacement du curseur vers le bas de 50 pixels
		$this->_yPosition -= 50;
	}
 
	//définition du footer de la page
	public function setFooter()
	{
		$this->drawText("", 50, 15, 'UTF-8');
		$this->drawText("", $this->getWidth() - 100, 15, 'UTF-8');
	}
 
	//permet de vérifier la position du curseur
	//de manière à savoir si nous pouvons continuer à écrire sur la page
	public function checkPosition()
	{
		//s'il reste plus de 75 pixels, nous pouvons contnuer à écrire
		//sinon il n'est plus possible d'écrire
		if($this->_yPosition > 75)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
 
	//permet d'afficher les informations du reglement de la facture
    public function addTraite($donnees) {
	       $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
		   $date_traite = new Zend_Date(Zend_Date::ISO_8601);
		   $date_traite = clone $date_traite;
	       $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $this->setFillColor($noir);
		   $this->setFont($font1,10);
		  
           //$this->drawLine(15,552,140,552);
            $this->drawText('Contre cette LETTRE DE CHANGE valeur en marchandises',340,580, 'UTF-8');
		    $this->drawText('stipulée SANS FRAIS',340,568,'UTF-8');
		    $this->drawText('veuillez payer la somme de',340,556, 'UTF-8');
		  //$this->drawText(lettre($donnees->mont_tranche, 75),470,534,'UTF-8');
		    $this->drawText("indiquée ci-dessous à l' ordre de :",340,544, 'UTF-8');
			$this->drawText($donnees->raison_sociale,475,544,'UTF-8');
			$this->drawText("ADRESSE",600,544,'UTF-8');
			$this->drawText($donnees->quartier_membre,650,544,'UTF-8');
			$this->drawText($donnees->ville_membre,750,544,'UTF-8');
			$this->drawText("CONTACT :",340,534,'UTF-8');
			$this->drawText($donnees->portable_membre,390,534,'UTF-8');
			$this->drawText($donnees->bp_membre,430,534,'UTF-8');
			
		    $this->setFont($font1,7);
		    $this->drawText('A ..LOME......LE........................',60,520,'UTF-8');
		    $this->drawText($date_traite->toString('dd/MM/yyyy'),120,520,'UTF-8');
		  
		    $this->drawText("MONTANT POUR CONTRÖLE ",63,500,'UTF-8');
		    $this->drawLine(60,476,219,476);
		    $this->drawText(number_format($donnees->mont_tranche,0,',',' '),85,478,'UTF-8');
		    //$this->drawText($donnees->mont_tranche,85,478,'UTF-8');
		    $this->drawLine(60,476,60,496);
		    $this->drawLine(219,476,219,496);
		  
		    $this->drawLine(70,450,70,465);
		    $this->drawLine(70,450,80,450);
		    $this->drawLine(70,465,80,465);
		  
		    $this->drawLine(470,450,470,465);
		    $this->drawLine(460,450,470,450);
		    $this->drawLine(460,465,470,465);
		  
		    $this->drawLine(500,450,500,465);
		    $this->drawLine(500,450,510,450);
		    $this->drawLine(500,465,510,465);
		  
		    $this->drawLine(648,450,648,465);
		    $this->drawLine(638,450,648,450);
		    $this->drawLine(638,465,648,465);
		  
		    $this->drawLine(665,450,665,465);
		    $this->drawLine(665,450,675,450);
		    $this->drawLine(665,465,675,465);
		  
		    $this->drawLine(710,450,710,465);
		    $this->drawLine(700,450,710,450);
		    $this->drawLine(700,465,710,465);
		  
		    $this->drawLine(60,418,60,440);
			$this->drawText("TG53",85,420,'UTF-8');
		    //$this->drawText("65",100,420,'UTF-8');
		    $this->drawLine(60,418,525,418);
		    
		    $this->drawLine(525,418,525,440);
			$this->drawLine(120,418,120,423);
			$this->drawText("TG13",135,420,'UTF-8');
			$this->drawLine(160,418,160,423);
			$this->drawText("8010",175,420,'UTF-8');
		    $this->drawLine(200,418,200,423);
			$this->drawText("0104",215,420,'UTF-8');
		    $this->drawLine(240,418,240,423);
			$this->drawText("0181",255,420,'UTF-8');
		    $this->drawLine(280,418,280,423);
			$this->drawText("6600",295,420,'UTF-8');
		    $this->drawLine(320,418,320,423);
			$this->drawText("0365",335,420,'UTF-8');
		    $this->drawText("IBAN DU TIRE",310,440,'UTF-8');
		    $this->drawLine(360,418,360,423);
		    $this->drawLine(400,418,400,423);
		    $this->drawLine(440,418,440,423);
		    $this->drawLine(480,418,480,423);
		    $this->drawText("ACCEPTATION OU AVAL",60,405,'UTF-8');
		    $this->drawLine(530,418,530,440);
		    $this->drawLine(530,440,565,440);
		    $this->drawLine(565,418,565,440);
		  
		    $this->drawText("Code nature",580,433,'UTF-8');
		    $this->drawText("économique",580,418,'UTF-8');
		  
		    $this->drawLine(648,440,668,440);
		    $this->drawText("DOMICILIATION",693,435,'UTF-8');
		    $this->drawLine(805,440,825,440);
		    $this->drawLine(648,418,648,440);
		   
		    $this->drawText("BAT (Banque Atlantique - Togo)",693,427,'UTF-8');
		    $this->drawText(".................................................................................................",648,425,'UTF-8');
		    $this->drawText(".................................................................................................",648,418,'UTF-8');
		    $this->drawText("TG13801001040181660003",693,420,'UTF-8');
		    $this->drawText("Signature du tireur",693,410,'UTF-8');
		  
		    $this->drawText("NOM et",395,400,'UTF-8');
		    $this->drawText("ADRESSE",385,390,'UTF-8');
		    $this->drawText("du TIRE",395,380,'UTF-8');
		  
		    $this->setFont($font1,7);
		    $this->drawLine(440,410,440,365);
		    $this->drawText('ENTREPRISE SOCIALE DE MARCHE COMMUN  ESMC SARLU',445,400,'UTF-8');
		    $this->drawText('Siège Social : Nukafu,angle Rue Sagouda,Kiyéou & Bandjéli,',445,390,'UTF-8');
		    $this->drawText('03 BP 30038 LOME-TOGO',445,380,'UTF-8');
		    $this->drawText('Tél. +(228) : 22193271 / 93666275 / 96001185',445,370,'UTF-8');
		  
		    $this->setFont($font1,7);
		  
		    $this->drawLine(825,418,825,440);
		    $this->drawLine(55,347,830,347);
		    $this->drawText("N° SIREN du TIRE",63,352,'UTF-8');
		  
		    $this->drawLine(290,352,290,357);
		    $this->drawLine(290,352,440,352);
		    $this->drawLine(440,352,440,357);
		  
		    $this->drawText("ne rien inscrire au-dessous de cette ligne",649,352,'UTF-8');
		  
		    $this->drawText("DATE DE CREATION",253,500,'UTF-8');
		    $this->drawLine(250,476,324,476);
		    $this->drawText($donnees->date_creation,270,478,'UTF-8');
		    $this->drawLine(250,476,250,496);
		    $this->drawLine(324,476,324,496);
		    $periodes = Util_Utils::getParametre('periode', 'valeur');
		    $this->drawText("ECHEANCE",363,500,'UTF-8');
		    $this->drawLine(360,476,438,476);
		    $this->drawText(($date_traite->addDay($periode * $periodes)->toString('dd/MM/yyyy')),385,478,'UTF-8');
		    $this->drawLine(360,476,360,496);
		    $this->drawLine(438,476,438,496);
		  
		  
		    $this->drawLine(477,495,662,495);
		    $this->drawLine(477,476,477,495);
		    $this->drawLine(662,476,662,495);
		    $this->drawLine(477,476,497,476);
		    $this->drawText("REF . TIRE",500,476,'UTF-8');
		    $this->drawLine(544,476,563,476);
		    $this->drawLine(563,476,563,492);
		    $this->drawLine(572,476,572,492);
		    $this->drawLine(572,476,592,476);
		    $this->drawLine(593,476,593,492);
		    $this->drawLine(601,476,601,492);
		    $this->drawLine(601,476,621,476);
		    $this->drawLine(621,476,621,492);
		  
		    $this->drawLine(628,476,663,476);
		    $this->drawLine(628,476,628,492);
		  
		    $this->drawText("CFA",750,522,'UTF-8');
		    $this->drawText("MONTANT",735,502,'UTF-8');
		    $this->drawLine(700,476,700,495);
		    $this->drawText(number_format($donnees->mont_tranche,0,',',' '),725,478,'UTF-8');
		    //$this->drawText($donnees->mont_tranche,725,478,'UTF-8');
		    $this->drawLine(700,476,800,476);
		    $this->drawLine(800,476,800,495);
	 
	 
	}
         
	
 
	//permet d'afficher un texte d'une certaine taille sur plusieurs lignes
	public function addText($text)
	{
                //positionnement du pointeur
                $this->_xPosition = 50;
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
		while($token !== false)
		{
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
	public function addLine()
	{
		$this->drawLine($this->_leftMargin, $this->_yPosition, $this->_rightMargin, $this->_yPosition);
		//déplacement du curseur vers le bas de 15 pixels
		$this->_yPosition -= 15;
	}
    
}