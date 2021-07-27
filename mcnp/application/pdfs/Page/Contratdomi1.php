<?php
//nous allons étendre Zend_Pdf_Page de manière à modifier cette classe en fonction de nos besoins
class Default_Pdf_Page_Contratdomi1 extends Zend_Pdf_Page {
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
        
        
   public function addContratdomi1($contrat) {
        
            $this->_boldFont = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
            $this->_boldFont1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFont($this->_boldFont,8);
		    $this->drawText("OBLIGATIONS DU MEMBRE PERSONNE PHYSIQUE ET MORALE",40,800,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("En vertu de la solvabilité exigée sur la plateforme",40,790,'UTF-8');
			 
            $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
			$this->drawText("MCNP",218,790,'UTF-8');
			$this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
			$this->drawText(",dans l’intérêt du membre et pour le fait que le",243,790,'UTF-8');
			
            $this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
			$this->drawText("MCNP",410,790,'UTF-8');
			$this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
			$this->drawText("a prévu le mécanisme d’accès aux",437,790,'UTF-8');
			$this->drawText("ressources : Capitaux de Revalorisation et d’Accès aux Ressources (CRAR), il est formellement interdit au membre de recourir à un",40,780,'UTF-8');
            $this->drawText("quelconque endettement en espèce hors réseau à des fins de ses dépenses étant entendu que la solvabilité sur la plateforme suit sa",40,770,'UTF-8');
            $this->drawText("modalité de paiement notamment en nature ou en numérique Titre Privatif de Solvabilité (TPS) qui n‘est pas de l’espèce. Par ",40,760,'UTF-8');
            $this->drawText("conséquent, le concessionnaire de la licence",40,750,'UTF-8');
            $this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
			$this->drawText("MCNP",202,750,'UTF-8');
			$this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
			$this->drawText("décline toute responsabilité vis-à-vis de l’exigence de paiement en espèce hors réseau.",227,750,'UTF-8');
			$this->drawText("En vertu de la solvabilité exigée sur la plateforme",40,740,'UTF-8');
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
			$this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
			$this->drawText("MCNP",218,740,'UTF-8');
			$this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
			$this->drawText(",dans l’intérêt des acteurs et pour le fait que le",242,740,'UTF-8');
			$this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
			$this->drawText("MCNP",410,740,'UTF-8');
			$this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
			$this->drawText("a prévu le mécanisme d’accès aux",436,740,'UTF-8');
			$this->drawText("ressources : Capitaux de Revalorisation et d’Accès aux Ressources (CRAR) ainsi que le mécanisme d’allocation des ressources aux acteurs",40,730,'UTF-8');
			$this->drawText("producteurs transformateurs et distributeurs : Subvention Marchande des Coûts d’Investissement et de Production Nouvelle, il est formellement",40,720,'UTF-8');
			$this->drawText("interdit aux acteurs de recourir à un quelconque endettement hors réseau à des fins d’approvisionnement de leurs marchandises étant",40,710,'UTF-8');
			$this->drawText("entendu que la solvabilité sur la plateforme suit sa modalité de paiement notamment en nature ou en numérique Titre Privatif de",40,700,'UTF-8');
			$this->drawText("Solvabilité (TPS) qui n‘est pas de l’espèce. Par conséquent, le concessionnaire de la licence",40,690,'UTF-8');
			$this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
			$this->drawText("MCNP",370,690,'UTF-8');
			$this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
			$this->drawText("décline toute responsabilité vis-à-",395,690,'UTF-8');
			$this->drawText("vis de l’exigence de paiement en espèce hors réseau.",40,680,'UTF-8');
			
			$this->setFont($this->_boldFont,8); 
            $this->drawText("FORCE MAJEURE",40,665,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("Le ",40,655,'UTF-8');
            $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
            $this->drawText("MCNP",53,655,'UTF-8');
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
            $this->drawText("peut être interrompu en cas de force majeure.",80,655,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("(Article 1148 du Code Civil)",243,655,'UTF-8');
                                
            $this->setFont($this->_boldFont,8);
            $this->drawText("INTERRUPTION DE L’EXPLOITATION DU ",40,640,'UTF-8');
			$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
            $this->setFont($this->_boldFont,9);
            $this->drawText("MCNP",200,640,'UTF-8');
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
            $this->setFont($this->_boldFont,8);
            $this->drawText("EN CAS DE FORCE MAJEURE",232,640,'UTF-8');
            $this->setFont($this->_boldFont1,8);
			$this->drawText("Ce contrat de pérennisation et/ou de domiciliation peut être interrompu en cas de force majeure et que si le cas de force majeure",40,630,'UTF-8');
            $this->drawText("dépasse les limites de reprise des activités,le contrat pourra être résilié après quarante huit heures (48H) de la survenance du cas de force",40,620,'UTF-8');
            $this->drawText("majeure sans qu’aucune partie puisse prétendre à une quelconque indemnité ou dommage intérêt;ceci à condition que le",40,610,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("FGFN",471,610,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("ne soit",497,610,'UTF-8');
            $this->drawText("affecté du fait de la responsabilité de l’hébergeur Partenaire bancaire ou financier du",40,600,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("FGFN .",341,600,'UTF-8');
			
			
			$this->setFont($this->_boldFont1,8);
            $this->drawText("En outre,dans le cas de force majeur,la liquidation des actifs résultant du ",40,590,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("FGFN",300,590,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText(",tiendra compte de la procédure du règlement à l’amiable",323,590,'UTF-8');
            $this->drawText("dans l’ordre ci-après.",40,580,'UTF-8');
                                
                                
            $this->drawText("-  le règlement des",40,570,'UTF-8');
            $bleu = new Zend_Pdf_Color_Rgb(0,0,1);
            $this->setFillColor($bleu);
            $this->setFont($this->_boldFont,8);
            $this->drawText("GC",109,570,'UTF-8');
            $this->setFillColor($noir);
            $this->setFont($this->_boldFont,8);
            $this->drawText("p PBF,",121,570,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("- le règlement des effets de commerce des Entreprises et Industries,",40,560,'UTF-8');
            $this->drawText("- le règlement des titres privatifs de solvabilité non récurrents,",40,550,'UTF-8');
            $this->drawText("- le règlement des titres récurrents selon le procédé : dernier venu, premier servi, dans l’ordre suivant :",40,540,'UTF-8');
            $this->drawText("o titres récurrents privatifs de solvabilité des ménages,",60,530,'UTF-8');
            $this->drawText("o titres récurrents privatifs de solvabilité des Entreprises/Industries.",60,520,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("NB :",40,510,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("Les Crédits en Nature Convertible Salaire (",60,510,'UTF-8');
            $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $this->setFillColor($rouge);
            $this->setFont($this->_boldFont,8);
            $this->drawText("CNCS",212,510,'UTF-8');
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $this->setFillColor($noir);
            $this->setFont($this->_boldFont1,8);
            $this->drawText(")",234,510,'UTF-8');
            $this->drawText("et l’Investissement",239,510,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("( I )",309,510,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("issus de la Subvention Marchande des Coûts ",324,510,'UTF-8');
            $this->drawText("d’Investissement et de Production Nouvelle non encore exprimés en ",40,500,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("CAPA",285,500,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("ne sont pas concernés par le présent règlement étant",310,500,'UTF-8');
            $this->drawText("entendu que les salariés feront leur réclamation auprès de leur employeur tandis que l’Investissement",40,490,'UTF-8');
            $this->setFont($this->_boldFont,8);
            $this->drawText("( I )",403,490,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("demeure une subvention non",420,490,'UTF-8');
            $this->drawText("encore exprimée.",40,480,'UTF-8');
            
			
            $this->setFont($this->_boldFont,8);
            $this->drawText("REGLEMENT DES LITIGES ",40,465,'UTF-8');
			$this->setFont($this->_boldFont1,8);
			$this->drawText("Les parties s’engagent à régler à l’amiable toutes les contestations pouvant naître entre elles à l’occasion de l’exécution du présent ",40,455,'UTF-8');
			$this->drawText("contrat.",40,445,'UTF-8');
			$this->drawText("En cas d’échec du règlement à l’amiable, tous différends découlant de ce contrat ou en relation avec lui y compris toute question",40,435,'UTF-8');
			$this->drawText("concernant son existence, sa validité ou son expiration, seront soumis à l’arbitrage sous l’égide de la Cour d’Arbitrage de la ",40,425,'UTF-8');
			$this->drawText("Chambre de Commerce et d’Industrie du Togo et seront définitivement tranchés suivant son règlement d’arbitrage tel qu’il est en",40,415,'UTF-8');
			$this->drawText("vigueur à la date du présent contrat. ",40,405,'UTF-8');
			$this->setFont($this->_boldFont,8);
            $this->drawText("MODALIE D’ARBITRAGE ",40,390,'UTF-8');
			$this->setFont($this->_boldFont1,8);
			$this->drawText("L’arbitrage se fait par un collège de trois arbitres comme suit : ",40,380,'UTF-8');
			$this->drawText("-	Un arbitre désigné par l’exploitant des marques",60,370,'UTF-8');
			$this->drawText("-	Un arbitre désigné par le membre,",60,360,'UTF-8');
			$this->drawText("-	Le troisième arbitre est désigné par les deux premiers arbitres et est d’office le président. ",60,350,'UTF-8');
			$this->drawText("Toutefois, les trois arbitres désignés doivent avoir compétence à siéger  à la",40,340,'UTF-8');
			$this->setFont($this->_boldFont,8);
			$this->drawText("CATO",314,340,'UTF-8');
			$this->setFont($this->_boldFont1,8);
			$this->drawText(", c’est-à-dire être confirmés par le Comité de ",337,340,'UTF-8');
			$this->drawText("Médiation et d’Arbitrage de la Cour. ",40,330,'UTF-8');
			$this->drawText("La loi applicable à la procédure et au fond du litige est celle adoptée par la Cour d’Arbitrage du Togo",40,320,'UTF-8');
			$this->setFont($this->_boldFont,8);
			$this->drawText("(CATO).",398,320,'UTF-8');
			
			
			$this->drawText("LANGUE D’INTERPRETATION ET D’ARBITRAGE",40,305,'UTF-8');
			$this->setFont($this->_boldFont1,8);
			$this->drawText("Ce contrat peut être traduit dans toutes les langues ayant un intérêt avec ledit contrat. Toutefois, le français est et reste la langue de",40,295,'UTF-8');
			$this->drawText("référence pour toute interprétation des clauses du présent contrat et le cas échéant la langue d’arbitrage.",40,285,'UTF-8');
			
			$this->setFont($this->_boldFont,8);
            $this->drawText("ENTREE EN VIGUEUR",40,270,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("Ce présent contrat entre en vigueur dès sa signature et tient lieu de loi aux parties qui doivent l’exécuter de bonne foi conformément",40,260,'UTF-8');
            $this->drawText("à l’article 1104 du Code Civil.",40,240,'UTF-8');
                                
            $this->setFont($this->_boldFont,8);
            $this->drawText("ELECTION DE DOMICILE",40,225,'UTF-8');
            $this->setFont($this->_boldFont1,8);
            $this->drawText("Pour l’exécution du présent contrat, les parties soussignées élisent leur domicile en leur demeure respective.",40,215,'UTF-8');
                                
            $this->setFont($this->_boldFont,8);
            $this->drawText("Coordonnées du souscripteur :",40,200,'UTF-8');
            $this->setFont($this->_boldFont1,8);
								
			if(substr($contrat->code_membre,19,1)=='M') {				
				$representation = new Application_Model_DbTable_EuMembre();
                $selection      = $representation->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $selection->setIntegrityCheck(false)
                          ->join('EU_REPRESENTATION','EU_REPRESENTATION.code_membre = EU_MEMBRE.code_membre')
                          ->join('EU_PAYS','EU_PAYS.ID_PAYS = EU_PAYS.ID_PAYS')												 
                          ->where('EU_REPRESENTATION.code_membre_MORALE = ?',$contrat->code_membre)
						  ->where('EU_REPRESENTATION.TITRE LIKE ?','Representant');
                $donnees = $representation->fetchAll($selection);
                foreach($donnees as $d) {
					$this->drawText("Nom :........................................................................................................................................................................................................................",40,190,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($d->nom_membre)),150,190, 'UTF-8');
                    $this->drawText("Prenom :....................................................................................................................................................................................................................",40,180,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($d->prenom_membre)),150,180,'UTF-8');
                    $this->drawText("Profession :...............................................................................................................................................................................................................",40,170,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($d->profession_membre)),150,170,'UTF-8');
                    $this->drawText("Nationalité :...............................................................................................................................................................................................................",40,160,'UTF-8');
                    $this->drawText($d->nationalite,150,160,'UTF-8');
                    $this->drawText("BP :...........................................................................................................................................................................................................................",40,150,'UTF-8');
                    $this->drawText($d->bp_membre,150,150, 'UTF-8');
                    $this->drawText("Ville :.........................................................................................................................................................................................................................",40,140,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($d->ville_membre)),150,140, 'UTF-8');
                    $this->drawText("Adresse :...................................................................................................................................................................................................................",40,130,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($d->quartier_membre)),150,130, 'UTF-8');
                                               
									   
				}
            } else  {
                    $this->drawText("Nom :........................................................................................................................................................................................................................",40,190,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($contrat->nom_membre)),150,190, 'UTF-8');
                    $this->drawText("Prenom :....................................................................................................................................................................................................................",40,180,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($contrat->prenom_membre)),150,180,'UTF-8');
                    $this->drawText("Profession :...............................................................................................................................................................................................................",40,170,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($contrat->profession_membre)),150,170,'UTF-8');
                    $this->drawText("Nationalité :...............................................................................................................................................................................................................",40,160,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($contrat->nationalite)),150,160,'UTF-8');
                    $this->drawText("BP :...........................................................................................................................................................................................................................",40,150,'UTF-8');
                    $this->drawText($contrat->bp_membre,150,150, 'UTF-8');
                    $this->drawText("Ville :.........................................................................................................................................................................................................................",40,140,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($contrat->ville_membre)),150,140, 'UTF-8');
                    $this->drawText("Adresse :...................................................................................................................................................................................................................",40,130,'UTF-8');
                    $this->drawText(stripslashes (html_entity_decode($contrat->quartier_membre)),150,130, 'UTF-8');
                                
            }
                    $this->drawText("Membre identifié N° :.................................................................................................................................................................................................",40,115,'UTF-8');
                    $this->setFont($this->_boldFont,8);
				    $this->drawText('Pour l’exploitant du',40,100, 'UTF-8');
					$this->setFillColor($rouge);
					$this->drawText('MCNP',118,100, 'UTF-8');
			        $this->setFont($this->_boldFont1,8);
                    $this->setFillColor($noir);					
				    $this->drawText($contrat->code_membre,150,115, 'UTF-8');
                    $this->drawText('Fait à Lomé ,le..................................................',360,100, 'UTF-8'); 
                    $this->drawText($contrat->DATECONTRAT,420,100, 'UTF-8');
                    $this->setFont($this->_boldFont,8);
                    $this->drawText('Signature précédée de la mention',360,90, 'UTF-8');
                    $this->setFont($this->_boldFont1,8);
                    $this->drawText('Lu et approuvé',492,90, 'UTF-8');
                                 
				    //$this->setFont($this->_boldFont,8);
                    //$this->drawText("P.O GAC Centrale Régionale",40,560, 'UTF-8');
                    //$this->drawText("l'exploitant du ",40,560, 'UTF-8');
                    //$rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                    // $this->setFillColor($rouge);
                    // $this->drawText("MCNP",90,560, 'UTF-8');
					
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
