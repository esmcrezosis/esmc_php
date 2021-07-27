<?php
class EuPdfRegltController extends Zend_Controller_Action {
    
	public function traiteAction() {
	    //récupération des données
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
	    $tpagcp = new Application_Model_DbTable_EuTpagcp();
	    $id_tpagcp = $_POST["id_tpagcp"];
        $select = $tpagcp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_tpagcp.code_membre') 
               ->where('eu_tpagcp.id_tpagcp = ?',$id_tpagcp); 
        $data = $tpagcp->fetchAll($select);
		
		//création du document pdf
        $pdf = new Default_Pdf_Reglement(); 
        $pdf->pages = array_reverse($pdf->pages);
        
		$traite1 = new Default_Pdf_Page_Reglement(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
        $pdf->pages[] = $traite1;
		
		//$traite1 = new Default_Pdf_Page_Reglement(Zend_Pdf_Page::SIZE_A4);
        //$pdf->pages[] = $traite1;
		 
		/*$traite2 = new Default_Pdf_Page_Reglement1(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite2;
		 
		$traite3 = new Default_Pdf_Page_Reglement2(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite3;
		 
		$traite4 = new Default_Pdf_Page_Reglement3(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite4;
		 
		$traite5 = new Default_Pdf_Page_Reglement4(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite5;
		 
		$traite6 = new Default_Pdf_Page_Reglement5(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite6;
		 
		$traite7 = new Default_Pdf_Page_Reglement6(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite7;
		 
		$traite8 = new Default_Pdf_Page_Reglement7(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $traite8; 
		*/
		
		
		
		foreach($data as $donnees) {
			$traite1->addTraite($donnees);
			
			/*$traite2->addTraite($donnees);
			$traite3->addTraite($donnees);
			$traite4->addTraite($donnees);
			$traite5->addTraite($donnees);
			$traite6->addTraite($donnees);
			$traite7->addTraite($donnees);
			$traite8->addTraite($donnees);
			*/
		  
		}
		
		    //permet de spécifier l'en-tête http
		    header('Content-Type: application/pdf; charset=utf-8');
		    //affichage de notre pdf
		    echo $pdf->render();
            $this->view->data = $pdf->render(); 
		    //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		    //permet de désactiver l'affichage de la vue de l'action list 
		    $this->_helper->viewRenderer->setNoRender(true);
		    //permet de désactiver l'affichage du layout
		    $this->_helper->layout->disableLayout();	
	
	}
	
	
	
	
	public function traiteoldAction() {
	    //récupération des données
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
	    $tpagcp = new Application_Model_DbTable_EuTpagcp();
	    $id_tpagcp = $_POST["id_tpagcp"];
        $select = $tpagcp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_tpagcp.code_membre') 
               ->where('eu_tpagcp.id_tpagcp = ?',$id_tpagcp); 
        $data = $tpagcp->fetchAll($select);
		
		if(($user->code_groupe_create == 'detentrice') || ($user->code_groupe_create == 'surveillance') || ($user->code_groupe_create == 'executante')) {
		    $groupe_parent = $user->code_groupe_create;     
		}
		else {
		  $parent = explode("_",$user->code_groupe_create);
		  $groupe_parent = $parent[0];
		}
		
		//création du document pdf
        $pdf = new Default_Pdf_Reglement(); 
        $pdf->pages = array_reverse($pdf->pages);
        // Création d'une nouvelle page attachée au document
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
        //$pdf->pages[] = ($page = $pdf->newPage('A4'));
		$pdf->pages[] = $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
        $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
		$date_traite = new Zend_Date(Zend_Date::ISO_8601);
		$date_traite = clone $date_traite;
		
		/*$page->setFont($font,50); 
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
        $page->drawText("e s m c",215,793,'utf-8');
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
		$page->drawRoundedRectangle(30,784,565,788,0);
        $page->drawRoundedRectangle(30,784,565,788,0);
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
		$page->setFont($font,20);
		$page->drawText("entreprise sociale de marche  commun",70,765,'utf-8');
		$page->setFillColor($noir);
		$page->setFont($font,8);
		$page->drawText("Conseils en Organisation des Affaires Commerciales, Recherche & Développement de Logiciels,Exploitation de Progiciel mcnp,        Commerce sur Internet",35,757,'utf-8');
		$page->drawText("rccm N° : tg-lom 2014 b 514 - N° fiscal 145587D - N° cnss 42425",190,745,'utf-8');
		*/
		
		foreach($data as $donnees) {
		    
			$noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $page->setFillColor($noir);
		    $page->setFont($font1,7);
		  
            //$page->drawLine(15,552,140,552);
            $page->drawText('Contre cette lettre de change valeur en marchandises',340,580, 'utf-8');
		    $page->drawText('stipulée sans frais',340,568, 'utf-8');
		    $page->drawText('veuillez payer la somme indiquée ',340,556, 'utf-8');
		    $page->drawText("ci-dessous à l' ordre de :",340,544, 'utf-8');
			$page->drawText($donnees->raison_sociale,410,544,'utf-8');
			$page->drawText("adresse",460,544,'utf-8');
			$page->drawText($donnees->quartier_membre,500,544,'utf-8');
			$page->drawText($donnees->ville_membre,550,544,'utf-8');
			$page->drawText("contact :",340,534,'utf-8');
			$page->drawText($donnees->portable_membre,390,534,'utf-8');
			$page->drawText($donnees->bp_membre,430,534,'utf-8');
          	
				  
		    /*$page->drawText('date de creation',20,522, 'utf-8');
		    $page->drawLine(15,500,140,500);
		    $page->drawText($donnees->date_creation,50,503,'utf-8');
		    $page->drawText('montant',50,470, 'utf-8');
		    $page->drawLine(15,448,140,448);
		    $page->drawText(number_format($donnees->mont_gcp,3,',',' '),40,451,'utf-8');
		    $page->drawText('echeance',50,418, 'utf-8');
		    $page->drawLine(15,396,140,396);
		    $page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",65,399,'utf-8');
		    $page->drawText('tire',50,366, 'utf-8');
		    $page->drawLine(15,344,140,344);
		    $page->drawText($donnees->raison_sociale,20,347,'utf-8');
		    $page->drawLine(15,318,140,318);
		  
		    $page->drawLine(15,292,140,292);
		  
		    $page->drawLine(15,266,140,266);
		    $page->drawText('domiciliation',30,236, 'utf-8');
		    $page->drawLine(15,214,140,214);
		  
		    $page->drawLine(15,188,140,188);
		    $page->drawLine(15,162,140,162);
		    $page->drawText('N° de compte',30,132, 'utf-8');
		    $page->drawLine(15,110,140,110);
		    $page->setFont($font1,9);
		    $page->drawText('nf k 11-030-2',50,90, 'utf-8');
		    */
			
		   $page->setFont($font1,7);
		   $page->drawText('A ..LOME......LE........................',60,520,'utf-8');
		   
		   $page->drawText($date_traite->toString('dd/mm/yyyy'),120,520,'utf-8');
		  
		   $page->drawText("MONTANT POUR CONTROLE ",63,500,'utf-8');
		   $page->drawLine(60,476,219,476);
		   $page->drawText(number_format($donnees->mont_gcp,3,',',' '),85,478,'utf-8');
		   $page->drawLine(60,476,60,496);
		   $page->drawLine(219,476,219,496);
		  
		   $page->drawLine(70,450,70,465);
		   $page->drawLine(70,450,80,450);
		   $page->drawLine(70,465,80,465);
		  
		   $page->drawLine(470,450,470,465);
		   $page->drawLine(460,450,470,450);
		   $page->drawLine(460,465,470,465);
		  
		   $page->drawLine(500,450,500,465);
		   $page->drawLine(500,450,510,450);
		   $page->drawLine(500,465,510,465);
		  
		   $page->drawLine(648,450,648,465);
		   $page->drawLine(638,450,648,450);
		   $page->drawLine(638,465,648,465);
		  
		   $page->drawLine(665,450,665,465);
		   $page->drawLine(665,450,675,450);
		   $page->drawLine(665,465,675,465);
		  
		   $page->drawLine(710,450,710,465);
		   $page->drawLine(700,450,710,450);
		   $page->drawLine(700,465,710,465);
		  
		   $page->drawLine(60,418,60,440);
		   $page->drawText("65",100,420,'utf-8');
		   $page->drawLine(60,418,525,418);
		   $page->drawLine(525,418,525,440);
		   $page->drawLine(200,418,200,423);
		   $page->drawLine(240,418,240,423);
		   $page->drawLine(280,418,280,423);
		   $page->drawLine(320,418,320,423);
		   $page->drawText("iban du tire",310,440,'utf-8');
		   $page->drawLine(360,418,360,423);
		   $page->drawLine(400,418,400,423);
		   $page->drawLine(440,418,440,423);
		   $page->drawLine(480,418,480,423);
		   $page->drawText("acceptation ou aval",60,405,'utf-8');
		   $page->drawLine(530,418,530,440);
		   $page->drawLine(530,440,565,440);
		   $page->drawLine(565,418,565,440);
		  
		   $page->drawText("Code nature",580,433,'utf-8');
		   $page->drawText("économique",580,418,'utf-8');
		  
		   $page->drawLine(648,440,668,440);
		   $page->drawText("domiciliation",693,435,'utf-8');
		   $page->drawLine(805,440,825,440);
		   $page->drawLine(648,418,648,440);
		   
		   $page->drawText("BAT (Banque Atlantique - Togo)",693,427,'utf-8');
		   $page->drawText(".................................................................................................",648,425,'utf-8');
		   $page->drawText(".................................................................................................",648,418,'utf-8');
		   $page->drawText("TG13801001040181660003",693,420,'utf-8');
		   $page->drawText("Signature du tireur",693,410,'utf-8');
		  
		   $page->drawText("NOM ET",395,400,'utf-8');
		   $page->drawText("ADRESSE",385,390,'utf-8');
		   $page->drawText("DU TIRE",395,380,'utf-8');
		  
		   $page->setFont($font1,7);
		   $page->drawLine(440,410,440,365);
		   $page->drawText('ENTREPRISE SOCIALE DE MARCHE COMMUN ESMC SARLU',445,400,'utf-8');
		   $page->drawText('Siège Social : Nukafu,angle Rue Sagouda,Kiyéou & Bandjéli,',445,390,'utf-8');
		   $page->drawText('03 BP 30038 LOME-TOGO',445,380,'utf-8');
		   $page->drawText('Tél. +(228) : 22193271 / 93666275 / 96001185',445,370,'utf-8');
		  
		   $page->setFont($font1,7);
		  
		   $page->drawLine(825,418,825,440);
		   $page->drawLine(55,347,830,347);
		   $page->drawText("N° siren du tire",63,352,'utf-8');
		  
		   $page->drawLine(290,352,290,357);
		   $page->drawLine(290,352,440,352);
		   $page->drawLine(440,352,440,357);
		  
		   $page->drawText("ne rien inscrire au-dessous de cette ligne",649,352,'utf-8');
		  
		   $page->drawText("DATE DE CREATION",253,500,'utf-8');
		   $page->drawLine(250,476,324,476);
		   $date_creation = new Zend_Date($row->date_deb, Zend_Date::ISO_8601);
		   $page->drawText($date_creation->toString('dd/MM/yyyy'),270,478,'utf-8');
		   $page->drawLine(250,476,250,496);
		   $page->drawLine(324,476,324,496);
		  
		   $page->drawText("echeance",363,500,'utf-8');
		   $page->drawLine(360,476,438,476);
		   $page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",380,478,'utf-8');
		   $page->drawLine(360,476,360,496);
		   $page->drawLine(438,476,438,496);
		  
		  
		   $page->drawLine(477,495,662,495);
		   $page->drawLine(477,476,477,495);
		   $page->drawLine(662,476,662,495);
		   $page->drawLine(477,476,497,476);
		   $page->drawText("REF . TIRE",500,476,'utf-8');
		   $page->drawLine(544,476,563,476);
		   $page->drawLine(563,476,563,492);
		   $page->drawLine(572,476,572,492);
		   $page->drawLine(572,476,592,476);
		   $page->drawLine(593,476,593,492);
		   $page->drawLine(601,476,601,492);
		   $page->drawLine(601,476,621,476);
		   $page->drawLine(621,476,621,492);
		  
		   $page->drawLine(628,476,663,476);
		   $page->drawLine(628,476,628,492);
		  
		   $page->drawText("CFA",750,522,'utf-8');
		   $page->drawText("MONTANT",735,502,'utf-8');
		   $page->drawLine(700,476,700,495);
		   $page->drawText(number_format($donnees->mont_gcp,3,',',' '),725,478,'utf-8');
		   $page->drawLine(700,476,800,476);
		   $page->drawLine(800,476,800,495);
		  
			/*
			$page->setFont($font1,9);
            $page->drawText("compte marchand distributeur ",40,650,'utf-8');
			$page->drawLine(40, 620,200, 620);
			$page->drawText($donnees->code_membre_morale,45,625,'utf-8');
			$page->drawLine(40, 650,40, 620);
			$page->drawLine(200, 650,200, 620);
			
			$page->setFont($font1,9);
            $page->drawText("date  creation ",230,650,'utf-8');
			$page->drawLine(230, 620,305, 620);
			$page->drawText($donnees->date_creation,235,625,'utf-8');
			$page->drawLine(230, 650,230, 620);
			$page->drawLine(305, 650,305, 620);
			
			$page->setFont($font1,9);
            $page->drawText("echeance ",335,650,'utf-8');
			$page->drawLine(335, 620,387, 620);
			$page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",340,625,'utf-8');
			$page->drawLine(335, 650,335, 620);
			$page->drawLine(387, 650,387, 620);
			
			$page->setFont($font1,9);
            $page->drawText("montant ",440,650,'utf-8');
			$page->drawLine(407, 620,520, 620);
			$page->drawText(number_format($donnees->mont_gcp,3,',',' ')."  "."f CfA",410,625,'UTf-8');
			
			$page->drawLine(407, 650,407, 620);
			$page->drawLine(520, 650,520, 620);
			
			$page->setFont($font1,9);
            $page->drawText("nom  et",240,580,'utf-8');
			$page->drawText("adresse ",240,560,'utf-8');
			$page->drawLine(320, 600,320, 550);
			$page->drawText($donnees->raison_sociale,325,580,'utf-8');
			$page->drawText($donnees->quartier_membre,325,560,'utf-8');
			
			$page->drawText("signature de l'operateur / operatrice de lA gac"." ".strtoupper($groupe_parent),50,500, 'utf-8');
            $page->drawText('signature du client',420,500, 'utf-8');
			
		    $page->setFont($font,12);
		    $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,430, 'utf-8');
		
		    $page->setFont($font1,12);
		    $page->drawText('a ..lome...le........................',40,290, 'utf-8');
			$page->drawText($date_traite->toString('dd/mm/yyyy'),128,290, 'utf-8');
			
			$page->setFont($font1,9);
            $page->drawText("compte marchand distributeur ",40,240,'utf-8');
			$page->drawLine(40, 210,200, 210);
			$page->drawText($donnees->code_membre_morale,45,215,'utf-8');
			$page->drawLine(40, 240,40, 210);
			$page->drawLine(200, 240,200,210);
			
			$page->setFont($font1,9);
            $page->drawText("date  creation ",230,240,'utf-8');
			$page->drawLine(230,210,305,210);
			$page->drawText($donnees->date_creation,235,215,'utf-8');
			$page->drawLine(230,240,230, 210);
			$page->drawLine(305,240,305, 210);
			

			$page->setFont($font1,9);
            $page->drawText("echeance ",335,240,'utf-8');
			$page->drawLine(335,210,387,210);
			$page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",340,215,'utf-8');
			$page->drawLine(335,240,335,210);
			$page->drawLine(387,240,387,210);
			
			$page->setFont($font1,9);
            $page->drawText("montant ",440,240,'utf-8');
			$page->drawLine(407,210,520,210);
			$page->drawText(number_format($donnees->mont_gcp,3,',',' ')."  "."f CfA",410,215,'UTf-8');
			$page->drawLine(407,240,407,210);
			$page->drawLine(520,240,520,210);
			
			$page->setFont($font1,9);
            $page->drawText("nom  et",240,170,'utf-8');
			$page->drawText("adresse ",240,150,'utf-8');
			$page->drawLine(320,190,320,140);
			$page->drawText($donnees->raison_sociale,325,170,'utf-8');
			$page->drawText($donnees->quartier_membre,325,150,'utf-8');
			
			$page->drawText("signature de l'operateur / operatrice de lA gac"." ".strtoupper($groupe_parent),50,90,'utf-8');
            $page->drawText('signature du client',420,90, 'utf-8');*/
		
		}
		
		/*$page->setFont($font,50); 
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
        $page->drawText("e s m c",215,383,'utf-8');
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
		$page->drawRoundedRectangle(30,374,565,378,0);
        $page->drawRoundedRectangle(30,374,565,378,0);
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
		$page->setFont($font,20);
		$page->drawText("entreprise sociale de marche  commun",70,355,'utf-8');
		$page->setFillColor($noir);
		$page->setFont($font,8);
		$page->drawText("Conseils en Organisation des Affaires Commerciales, Recherche & Développement de Logiciels, Exploitation de Progiciel mcnp,        Commerce sur Internet",35,347,'utf-8');
		$page->drawText("rccm N° : tg-lom 2014 b 514 - N° fiscal 145587D - N° cnss 42425",190,335,'utf-8');
		*/
		
		//permet de spécifier l'en-tête http
		header('Content-Type: application/pdf; charset=utf-8');
 
		//affichage de notre pdf
		echo $pdf->render();
        $this->view->data = $pdf->render();
                
		//comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		//permet de désactiver l'affichage de la vue de l'action list
		$this->_helper->viewRenderer->setNoRender(true);
                
		//permet de désactiver l'affichage du layout
		$this->_helper->layout->disableLayout();	
	}
	
	
	
	
	public function traite1Action() {
	    //récupération des données
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
	    $tpagcp = new Application_Model_DbTable_EuTpagcp();
	    $id_tpagcp = $_POST["id_tpagcp"];
        $select = $tpagcp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_tpagcp.code_membre',array("to_char((eu_tpagcp.date_deb),'dd/mm/yyyy') date_creation",'eu_tpagcp.*','eu_membre_morale.*')) 
               ->where('eu_tpagcp.id_tpagcp = ?',$id_tpagcp); 
        $data = $tpagcp->fetchAll($select);
		
		if(($user->code_groupe_create == 'detentrice') || ($user->code_groupe_create == 'surveillance') || ($user->code_groupe_create == 'executante')) {
		     $groupe_parent = $user->code_groupe_create;     
		}
		else {
		  $parent = explode("_",$user->code_groupe_create);
		  $groupe_parent = $parent[0];
		}
		
		
		//création d document pdf
        $pdf = new Default_Pdf_Reglement(); 
        $pdf->pages = array_reverse($pdf->pages);
        // Création d'une nouvelle page attachée au document
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
        //$pdf->pages[] = ($page = $pdf->newPage('A4'));
		$pdf->pages[] = $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
        $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
		$date_traite = new Zend_Date(Zend_Date::ISO_8601);
		$date_traite = clone $date_traite;
		
		/*$page->setFont($font,50); 
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
        $page->drawText("e s m c",215,793,'utf-8');
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
		$page->drawRoundedRectangle(30,784,565,788,0);
        $page->drawRoundedRectangle(30,784,565,788,0);
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
		$page->setFont($font,20);
		$page->drawText("entreprise sociale de marche  commun",70,765,'utf-8');
		$page->setFillColor($noir);
		$page->setFont($font,8);
		$page->drawText("Conseils en Organisation des Affaires Commerciales, Recherche & Développement de Logiciels,Exploitation de Progiciel mcnp, Commerce sur Internet",35,757,'utf-8');
		$page->drawText("rccm N° : tg-lom 2014 b 514 - N° fiscal 145587D - N° cnss 42425",190,745,'utf-8');
		*/
		
		foreach($data as $donnees) {
		  $noir = new Zend_Pdf_Color_Rgb(0,0,0);
          $page->setFillColor($noir);
		  $page->setFont($font1,11);
		  
          $page->drawLine(15,552,140,552);
          $page->drawText('Contre cette lettre de change',340,552, 'utf-8');
		  $page->drawText('stipulée sans frais',340,540, 'utf-8');
		  $page->drawText('veuillez payer la somme indiquée',340,528, 'utf-8');
		  $page->drawText('ci-dessous à l ordre de :',340,516, 'utf-8');
          		  
		  $page->drawText('date de creation',20,522, 'utf-8');
		  $page->drawLine(15,500,140,500);
		  $page->drawText($donnees->date_creation,50,503,'utf-8');
		  $page->drawText('montant',50,470, 'utf-8');
		  $page->drawLine(15,448,140,448);
		  $page->drawText(number_format($donnees->mont_gcp,3,',',' '),40,451,'utf-8');
		  $page->drawText('echeance',50,418, 'utf-8');
		  $page->drawLine(15,396,140,396);
		  $page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",65,399,'utf-8');
		  $page->drawText('tire',50,366, 'utf-8');
		  $page->drawLine(15,344,140,344);
		  $page->drawText($donnees->raison_sociale,20,347,'utf-8');
		  $page->drawLine(15,318,140,318);
		  
		  $page->drawLine(15,292,140,292);
		  
		  $page->drawLine(15,266,140,266);
		  $page->drawText('domiciliation',30,236, 'utf-8');
		  $page->drawLine(15,214,140,214);
		  
		  $page->drawLine(15,188,140,188);
		  
		  $page->drawLine(15,162,140,162);
		  $page->drawText('N° de compte',30,132, 'utf-8');
		  $page->drawLine(15,110,140,110);
		  $page->setFont($font1,9);
		  $page->drawText('nf k 11-030-2',50,90, 'utf-8');
		  
		  $page->setFont($font1,11);
		  $page->drawText('a ..lome...le........................',160,448, 'utf-8');
		  $page->drawText($date_traite->toString('dd/mm/yyyy'),248,448, 'utf-8');
		  
		  $page->drawText("montant pour CONTRÖle ",163,396,'utf-8');
		  $page->drawLine(160,344,319,344);
		  $page->drawText(number_format($donnees->mont_gcp,3,',',' '),166,349,'utf-8');
		  $page->drawLine(160,344,160,396);
		  $page->drawLine(319,344,319,396);
		  
		  $page->drawLine(170,308,170,333);
		  $page->drawLine(170,308,190,308);
		  $page->drawLine(170,333,190,333);
		  
		  $page->drawLine(485,308,485,333);
		  $page->drawLine(465,308,485,308);
		  $page->drawLine(465,333,485,333);
		  
		  $page->drawLine(505,308,505,333);
		  $page->drawLine(505,308,525,308);
		  $page->drawLine(505,333,525,333);
		  
		  $page->drawLine(658,308,658,333);
		  $page->drawLine(638,308,658,308);
		  $page->drawLine(638,333,658,333);
		  
		  $page->drawLine(670,308,670,333);
		  $page->drawLine(670,308,690,308);
		  $page->drawLine(670,333,690,333);
		  
		  $page->drawLine(735,308,735,333);
		  $page->drawLine(715,308,735,308);
		  $page->drawLine(715,333,735,333);
		  
		  $page->drawLine(160,251,160,292);
		  $page->drawLine(160,251,525,251);
		  $page->drawLine(525,251,525,292);
		  $page->drawLine(200,251,200,256);
		  $page->drawLine(240,251,240,256);
		  $page->drawLine(280,251,280,256);
		  $page->drawLine(320,251,320,256);
		  $page->drawText("iban du tire",310,276,'utf-8');
		  $page->drawLine(360,251,360,256);
		  $page->drawLine(400,251,400,256);
		  $page->drawLine(440,251,440,256);
		  $page->drawLine(480,251,480,256);
		  $page->drawText("acceptation ou aval",160,236,'utf-8');
		  $page->drawLine(530,251,530,292);
		  $page->drawLine(530,292,565,292);
		  $page->drawLine(565,251,565,292);
		  
		  $page->drawText("Code nature",580,266,'utf-8');
		  $page->drawText("économique",580,256,'utf-8');
		  
		  $page->drawLine(648,292,668,292);
		  $page->drawText("domiciliation",693,288,'utf-8');
		  $page->drawLine(805,292,825,292);
		  $page->drawLine(648,292,648,236);
		  $page->drawText("................................................................",648,256,'utf-8');
		  $page->drawText("................................................................",648,236,'utf-8');
		  $page->drawText("Signature du tireur",693,214,'utf-8');
		  
		  $page->drawText("nom et",395,204,'utf-8');
		  $page->drawText("adresse",385,190,'utf-8');
		  $page->drawText("du tire",395,176,'utf-8');
		  
		  $page->setFont($font1,9);
		  $page->drawLine(440,160,440,230);
		  $page->drawText($donnees->raison_sociale,445,204,'utf-8');
		  $page->drawText('Siège Social : Nukafu,angle Rue Sagouda,Kiyéou & Bandjéli,',445,190,'utf-8');
		  $page->drawText('03 bp 30038 lome-togo',445,176,'utf-8');
		  $page->drawText('Tél. +(228) : 22193271 / 93666275 / 96001185',445,162,'utf-8');
		  
		  $page->setFont($font1,11);
		  
		  $page->drawLine(825,236,825,292);
		  $page->drawLine(155,110,830,110);
		  $page->drawText("N° siren du tire",163,115,'utf-8');
		  
		  $page->drawLine(290,115,290,150);
		  $page->drawLine(290,115,440,115);
		  $page->drawLine(440,115,440,150);
		  
		  $page->drawText("ne rien inscrire au-dessous de cette ligne",649,115,'utf-8');
		  
		  $page->drawText("date de creation",327,396,'utf-8');
		  $page->drawLine(324,344,437,344);
		  $page->drawText($donnees->date_creation,330,349,'utf-8');
		  $page->drawLine(324,344,324,396);
		  $page->drawLine(437,344,437,396);
		  
		  $page->drawText("echeance",450,396,'utf-8');
		  $page->drawLine(442,344,520,344);
		  $page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",448,349,'utf-8');
		  $page->drawLine(442,344,442,396);
		  $page->drawLine(520,344,520,396);
		  
		  $page->drawLine(525,396,710,396);
		  $page->drawLine(525,344,525,396);
		  $page->drawLine(710,344,710,396);
		  $page->drawLine(525,344,539,344);
		  $page->drawText("ref . tire",540,340,'utf-8');
		  $page->drawLine(591,344,610,344);
		  $page->drawLine(610,344,610,390);
		  $page->drawLine(619,344,619,390);
		  $page->drawLine(619,344,639,344);
		  $page->drawLine(639,344,639,390);
		  $page->drawLine(648,344,648,390);
		  $page->drawLine(648,344,668,344);
		  $page->drawLine(668,344,668,390);
		  
		  $page->drawLine(675,344,710,344);
		  $page->drawLine(675,344,675,390);
		  
		  $page->drawText("cfa",750,448,'utf-8');
		  $page->drawText("montant",735,396,'utf-8');
		  $page->drawLine(715,344,715,396);
		  $page->drawText(number_format($donnees->mont_gcp,3,',',' '),721,349,'utf-8');
		  $page->drawLine(715,344,815,344);
		  $page->drawLine(815,344,815,396);
		  
			/*
			$page->setFont($font1,9);
            $page->drawText("compte marchand distributeur ",40,650,'utf-8');
			$page->drawLine(40, 620,200, 620);
			$page->drawText($donnees->code_membre_morale,45,625,'utf-8');
			$page->drawLine(40, 650,40, 620);
			$page->drawLine(200, 650,200, 620);
			
			$page->setFont($font1,9);
            $page->drawText("date  creation ",230,650,'utf-8');
			$page->drawLine(230, 620,305, 620);
			$page->drawText($donnees->date_creation,235,625,'utf-8');
			$page->drawLine(230, 650,230, 620);
			$page->drawLine(305, 650,305, 620);
			
			$page->setFont($font1,9);
            $page->drawText("echeance ",335,650,'utf-8');
			$page->drawLine(335, 620,387, 620);
			$page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",340,625,'utf-8');
			$page->drawLine(335, 650,335, 620);
			$page->drawLine(387, 650,387, 620);
			
			$page->setFont($font1,9);
            $page->drawText("montant ",440,650,'utf-8');
			$page->drawLine(407, 620,520, 620);
			$page->drawText(number_format($donnees->mont_gcp,3,',',' ')."  "."f CfA",410,625,'UTf-8');
			
			$page->drawLine(407, 650,407, 620);
			$page->drawLine(520, 650,520, 620);
			
			$page->setFont($font1,9);
            $page->drawText("nom  et",240,580,'utf-8');
			$page->drawText("adresse ",240,560,'utf-8');
			$page->drawLine(320, 600,320, 550);
			$page->drawText($donnees->raison_sociale,325,580,'utf-8');
			$page->drawText($donnees->quartier_membre,325,560,'utf-8');
			
			$page->drawText("signature de l'operateur / operatrice de lA gac"." ".strtoupper($groupe_parent),50,500, 'utf-8');
            $page->drawText('signature du client',420,500, 'utf-8');
			
		    $page->setFont($font,12);
		    $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,430, 'utf-8');
		
		    $page->setFont($font1,12);
		    $page->drawText('a ..lome...le........................',40,290, 'utf-8');
			$page->drawText($date_traite->toString('dd/mm/yyyy'),128,290, 'utf-8');
			
			$page->setFont($font1,9);
            $page->drawText("compte marchand distributeur ",40,240,'utf-8');
			$page->drawLine(40, 210,200, 210);
			$page->drawText($donnees->code_membre_morale,45,215,'utf-8');
			$page->drawLine(40, 240,40, 210);
			$page->drawLine(200, 240,200,210);
			
			$page->setFont($font1,9);
            $page->drawText("date  creation ",230,240,'utf-8');
			$page->drawLine(230,210,305,210);
			$page->drawText($donnees->date_creation,235,215,'utf-8');
			$page->drawLine(230,240,230, 210);
			$page->drawLine(305,240,305, 210);
			
			$page->setFont($font1,9);
            $page->drawText("echeance ",335,240,'utf-8');
			$page->drawLine(335,210,387,210);
			$page->drawText(8 * abs($donnees->date_fin_tranche - $donnees->date_deb_tranche)."  "."jours",340,215,'utf-8');
			$page->drawLine(335,240,335,210);
			$page->drawLine(387,240,387,210);
			
			$page->setFont($font1,9);
            $page->drawText("montant ",440,240,'utf-8');
			$page->drawLine(407,210,520,210);
			$page->drawText(number_format($donnees->mont_gcp,3,',',' ')."  "."f CfA",410,215,'UTf-8');
			$page->drawLine(407,240,407,210);
			$page->drawLine(520,240,520,210);
			
			$page->setFont($font1,9);
            $page->drawText("nom  et",240,170,'utf-8');
			$page->drawText("adresse ",240,150,'utf-8');
			$page->drawLine(320,190,320,140);
			$page->drawText($donnees->raison_sociale,325,170,'utf-8');
			$page->drawText($donnees->quartier_membre,325,150,'utf-8');
			
			$page->drawText("signature de l'operateur / operatrice de lA gac"." ".strtoupper($groupe_parent),50,90,'utf-8');
            $page->drawText('signature du client',420,90, 'utf-8');*/
		
		}
		
		/*$page->setFont($font,50); 
        $noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
        $page->drawText("e s m c",215,383,'utf-8');
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
		$page->drawRoundedRectangle(30,374,565,378,0);
        $page->drawRoundedRectangle(30,374,565,378,0);
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
		$noir = new Zend_Pdf_Color_Rgb(0,0,0);
        $page->setFillColor($noir);
		$page->setFont($font,20);
		$page->drawText("entreprise sociale de marche  commun",70,355,'utf-8');
		$page->setFillColor($noir);
		$page->setFont($font,8);
		$page->drawText("Conseils en Organisation des Affaires Commerciales, Recherche & Développement de Logiciels, Exploitation de Progiciel mcnp, Commerce sur Internet",35,347,'utf-8');
		$page->drawText("rccm N° : tg-lom 2014 b 514 - N° fiscal 145587D - N° cnss 42425",190,335,'utf-8');
		*/
		
		//permet de spécifier l'en-tête http
		header('Content-Type: application/pdf; charset=utf-8');
 
		//affichage de notre pdf
		echo $pdf->render();
        $this->view->data = $pdf->render();
                
		//comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		//permet de désactiver l'affichage de la vue de l'action list
		$this->_helper->viewRenderer->setNoRender(true);
                
		//permet de désactiver l'affichage du layout
		$this->_helper->layout->disableLayout();	
	}
	
	
	
	
	public function consoAction() { 
        //récupération des données
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        
        $operation = new Application_Model_DbTable_EuOperation();
        $compteur = $_POST["compteur"];
        $select = $operation->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_membre', 'eu_membre.code_membre = eu_operation.code_membre')
               //->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_operation.id_utilisateur') 
               ->where('eu_operation.id_operation = ?',$compteur); 
        $data = $operation->fetchAll($select); 
         
        
         //création d document pdf
         $pdf = new Default_Pdf_Reglement(); 
         $pdf->pages = array_reverse($pdf->pages);
         // Création d'une nouvelle page attachée au document
         $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
         $pdf->pages[] = ($page = $pdf->newPage('A4'));
         $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
         $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                
         foreach($data as $donnees) {  
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
            //$page->drawRectangle(37,725,560,830);
		    $page->drawRoundedRectangle(37,725,565,835,30);
            $page->drawRoundedRectangle(42,730,560,830,30);
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $page->setFillColor($noir);
            $page->setFont($font,40); 
            $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $page->setFillColor($rouge);
            $page->drawText("m c n p",240,793,'utf-8');
            //Charger une image
            $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
            $page->drawImage($image,55,775,105,825);
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $page->setFillColor($noir);
            $page->setFont($font,14);
            $page->drawText("Marché de Crédit en Nature Pérenne",190,779,'utf-8');
                                
            //déplacement du curseur vers la droite de 120 
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
            $page->setFont($font1,8);
            $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
            $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
           
           $page->setFont($font,14);
           $page->drawText("recu de vente au tegcp ",185,730,'utf-8');
                        
           $page->setFont($font1,12);
           $page->drawText("Compte Marchand du distributeur           :",50,700,'utf-8');
           $page->drawText($user->code_membre,260,700,'utf-8');
            
           $membre = new Application_Model_DbTable_EuMembre();
           $sel = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $sel->where('eu_membre.code_membre = ?',$user->code_membre); 
           $data1 = $membre->fetchAll($sel);
           foreach($data1 as $agences)
	       {
               $page->drawText("Raison sociale du distributeur                 :",50,680,'utf-8');    
               $page->drawText($agences->raison_sociale,260,680,'utf-8');
           }
           
           $page->drawText("Compte Marchand de l'acheteur              :",50,660,'utf-8');
           $page->drawText($donnees->code_membre,260,660,'utf-8');
           
           if($donnees->type_membre=='p') {
              $page->drawText("Nom && Prénom                                    :",50,640,'utf-8');    
              $page->drawText($donnees->nom_membre."     ".$donnees->prenom_membre,260,640,'utf-8');
           }
           else {
              $page->drawText("Raison sociale de l'acheteur          :",50,640,'utf-8');    
              $page->drawText($donnees->raison_sociale,260,640,'utf-8');
           }
              $page->drawText("Montant consommé                                 :",50,620,'utf-8');
              $page->drawText($donnees->montant_op."  "."fcfa",260,620,'utf-8');
                            
              $page->drawText("Type opération                                         :",50,600,'utf-8');
              $page->drawText($donnees->lib_op."   ".$donnees->code_produit,260,600,'utf-8');
              $dateop = new Zend_Date($donnees->date_op,Zend_Date::ISO_8601);
                     
              $page->drawText("Date opération                                          :",50,580,'utf-8');
              $page->drawText($dateop->toString('dd/mm/yyyy'),260,580, 'utf-8');
                            
              $users = new Application_Model_DbTable_EuUtilisateur();
              $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
              $sel->setIntegrityCheck(false)        
                  ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                  ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
              $data1 = $users->fetchAll($sel);
              foreach($data1 as $agences)
	          {
                 $page->drawText("Opérateur/Opératrice                               :",50,560,'utf-8');
                 $page->drawText($agences->nom_utilisateur."  ".$agences->prenom_utilisateur,260,560, 'utf-8'); 
                 $page->drawText("Agence                                                     :",50,540,'utf-8');
                 $page->drawText($agences->libelle_agence,260,540, 'utf-8');
              }
                 $page->drawText("Signature de l'opérateur/opératrice",50,500, 'utf-8');
                 $page->drawText('Signature du client',360,500, 'utf-8');
                 //$page->drawLine(50,450,560,450);
                     
                 $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,450, 'utf-8');
                     
                $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                $page->drawRectangle(37,282,560,390);
				//$page->drawRoundedRectangle(37,725,565,835,30);
                //$page->drawRoundedRectangle(42,730,560,830,30);
                $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                $page->setFillColor($noir);
                $page->setFont($font,18); 
                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                $page->setFillColor($rouge);
		        $page->drawText("mcnp",280,355,'utf-8');
                     
                //Charger une image
                $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                $page->drawImage($image,55,330,105,380);
                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                $page->setFillColor($noir);
                $page->setFont($font,14);
                $page->drawText("Marché de Crédit en Nature Pérenne",185,339,'utf-8');
                                
                //déplacement du curseur vers la droite de 120 
                $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                $page->setFont($font1,8);
                $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,328, 'utf-8');
                $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,318, 'utf-8');
                $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,308, 'utf-8');
                $page->setFont($font,14);
                $page->drawText("recu de vente au tegcp ",185,288,'utf-8');
                
      
                     
                $page->setFont($font1,12);
                $page->drawText("Compte Marchand du distributeur          :",50,258,'utf-8');
                $page->drawText($user->code_membre,260,258,'utf-8');
              
                $membre = new Application_Model_DbTable_EuMembre();
                $sel = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $sel->where('eu_membre.code_membre = ?',$user->code_membre); 
                $data1 = $membre->fetchAll($sel);
              
                foreach($data1 as $agences) {
                 $page->drawText("Raison sociale du distributeur                 :",50,238,'utf-8');    
                 $page->drawText($agences->raison_sociale,260,238,'utf-8');
                }
              
                $page->drawText("Compte Marchand de l'acheteur             :",50,218,'utf-8');
                $page->drawText($donnees->code_membre,260,218,'utf-8');
              
              
              if($donnees->type_membre=='p') {
                 $page->drawText("Nom && Prénom                                    :",50,198,'utf-8');    
                 $page->drawText($donnees->nom_membre."     ".$donnees->prenom_membre,260,198,'utf-8');
              }
              else {
                 $page->drawText("Raison sociale de l'acheteur          :",50,198,'utf-8');    
                 $page->drawText($donnees->raison_sociale,260,198,'utf-8');
             }
              
                 $page->drawText("Montant consommé                                 :",50,178,'utf-8');
                 $page->drawText($donnees->montant_op."  "."fcfa",260,178,'utf-8');
                     
                 //$page->drawText("Montant crédit :",50,640,'utf-8');
                 //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                 $page->drawText("Type opération                                        :",50,158,'utf-8');
                 $page->drawText($donnees->lib_op."   ".$donnees->code_produit,260,158,'utf-8');
                 $dateop = new Zend_Date($donnees->date_op,Zend_Date::ISO_8601);
                     
                 $page->drawText("Date opération                                         :",50,138,'utf-8');
                 $page->drawText($dateop->toString('dd/mm/yyyy'),260,138, 'utf-8');
                     
                 //$page->drawText("Opérateur/Opératrice :",50,118,'utf-8');
                 //$page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,160,118, 'utf-8');
                     
                 $users = new Application_Model_DbTable_EuUtilisateur();
                 $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	             {
                       $page->drawText("Opérateur/Opératrice                               :",50,118,'utf-8');
                       $page->drawText($agences->nom_utilisateur."  ".$agences->prenom_utilisateur,260,118, 'utf-8');  
                         
                       $page->drawText("Agence                                                     :",50,98,'utf-8');
                       $page->drawText($agences->libelle_agence,260,98, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,58, 'utf-8');
                     $page->drawText('Signature du client',360,58, 'utf-8');     
                }
                
                //permet de spécifier l'en-tête http
		        header('Content-Type: application/pdf; charset=utf-8');
 
		       //affichage de notre pdf
		       echo $pdf->render();
               $this->view->data = $pdf->render();
                
		       //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		      //permet de désactiver l'affichage de la vue de l'action list
		      $this->_helper->viewRenderer->setNoRender(true);
                
		      //permet de désactiver l'affichage du layout
		      $this->_helper->layout->disableLayout();
              
              }
    

	public function listAction()
	{
            
	   //récupération des utilisateurs
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity(); 
	       $facture = new Application_Model_DbTable_EuFacture();
           $select = $facture->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)        
                  ->join('eu_reglement','eu_reglement.code_facture = eu_facture.code_facture')
                  ->join('eu_utilisateur','eu_utilisateur.id_utilisateur = eu_facture.id_utilisateur') 
                  ->where('eu_reglement.id_reglt = ?',$_POST['id_reglt']); 
           $data = $facture->fetchAll($select);
                
           //création d document pdf
           $pdf = new Default_Pdf_Reglement(); 
           $pdf->pages = array_reverse($pdf->pages);
           // Création d'une nouvelle page attachée au document
           $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
           $pdf->pages[] = ($page = $pdf->newPage('A4'));
           $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                
           foreach($data as $donnees)
	       {  
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
            $page->drawRectangle(37,725,560,830);
			//$page->drawRoundedRectangle(37,725,565,835,30);
            //$page->drawRoundedRectangle(42,730,560,830,30);
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $page->setFillColor($noir);
            $page->setFont($font,18); 
            $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $page->setFillColor($rouge);
            $page->drawText("mcnp",280,793,'utf-8');
            //Charger une image
            $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
            $page->drawImage($image,55,775,105,825);
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $page->setFillColor($noir);
            $page->setFont($font,14);
            $page->drawText("Marché de Crédit en Nature Pérenne",185,779,'utf-8');
                                
            //déplacement du curseur vers la droite de 120 
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
            $page->setFont($font1,8);
            $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
            $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
            $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,750, 'utf-8');
            $page->setFont($font,14);
            $page->drawText("facturation ",185,730,'utf-8');
            $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
            $page->setFillColor($rouge);
            $page->drawText(" smcipn",300,730,'utf-8');
            
            $noir = new Zend_Pdf_Color_Rgb(0,0,0);
            $page->setFillColor($noir);
            $page->setFont($font1,12);
            $page->drawText("Numéro du reçu         :",50,700,'utf-8');
            $page->drawText($donnees->id_reglt,165,700,'utf-8');
                     
            $page->drawText("Numéro de la facture :",50,680,'utf-8');    
            $page->drawText($donnees->code_facture,165,680,'utf-8');
                     
            $page->drawText("Montant à payer         :",50,660,'utf-8');
            $page->drawText("$donnees->montant_reglt",165,660,'utf-8');
                     
            //$page->drawText("Montant crédit :",50,640,'utf-8');
            //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
            $page->drawText("Numéro fournisseur   :",50,640,'utf-8');
            $page->drawText($donnees->code_membre_fournisseur,165,640,'utf-8');
                     
            $page->drawText("Numéro client            :",50,620,'utf-8');
            $page->drawText($donnees->code_membre_client,165,620,'utf-8');
                  
            $dateop = new Zend_Date($donnees->date_reglt,Zend_Date::ISO_8601);         
            $page->drawText("Date opération           :",50,600,'utf-8');
            $page->drawText($dateop->toString('dd/mm/yyyy'),165,600, 'utf-8');
                     
            $page->drawText("Opérateur/Opératrice :",50,580,'utf-8');
            $page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,165,580, 'utf-8');
                     
            $users = new Application_Model_DbTable_EuUtilisateur();
            $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)        
                ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
            $data1 = $users->fetchAll($sel);
            foreach($data1 as $agences)
	        {
               $page->drawText("Agence                       :",50,560,'utf-8');
               $page->drawText($agences->libelle_agence,165,560, 'utf-8');
            }
               $page->drawText("Signature de l'opérateur/opératrice",50,520, 'utf-8');
               $page->drawText('Signature du client',360,520, 'utf-8');
                     //$page->drawLine(50,450,560,450);
                     
              $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,450, 'utf-8');
                     
              $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
              //$page->drawRectangle(37,282,560,390);
			  //$page->drawRoundedRectangle(37,725,565,835,30);
              //$page->drawRoundedRectangle(42,730,560,830,30);
              $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
              $noir = new Zend_Pdf_Color_Rgb(0,0,0);
              $page->setFillColor($noir);
              $page->setFont($font,18); 
              $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
              $page->setFillColor($rouge);
	          $page->drawText("mcnp",280,355,'utf-8');
                     
              //Charger une image
              $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
              $page->drawImage($image,55,330,105,380);
              $noir = new Zend_Pdf_Color_Rgb(0,0,0);
              $page->setFillColor($noir);
              $page->setFont($font,14);
              $page->drawText("Marché de Crédit en Nature Pérenne",185,339,'utf-8');
                                
              //déplacement du curseur vers la droite de 120 
              $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
              $page->setFont($font1,8);
              $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,328, 'utf-8');
              $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,318, 'utf-8');
              $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,308, 'utf-8');
              $page->setFont($font,14);
              $page->drawText("facturation ",185,288,'utf-8');
              $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
              $page->setFillColor($rouge);
              $page->drawText(" smcipn",300,288,'utf-8');
             
              $noir = new Zend_Pdf_Color_Rgb(0,0,0);
              $page->setFillColor($noir);
              $page->setFont($font1,12);
              $page->drawText("Numéro du reçu         :",50,258,'utf-8');
              $page->drawText($donnees->id_reglt,165,258,'utf-8');
                     
              $page->drawText("Numéro de la facture :",50,238,'utf-8');    
              $page->drawText($donnees->code_facture,165,238,'utf-8');
                     
              $page->drawText("Montant à payer         :",50,218,'utf-8');
              $page->drawText("$donnees->montant_reglt",165,218,'utf-8');
                     
              $page->drawText("Numéro fournisseur   :",50,198,'utf-8');
              $page->drawText($donnees->code_membre_fournisseur,165,198,'utf-8');
             
              $page->drawText("Numéro client            :",50,178,'utf-8');
              $page->drawText($donnees->code_membre_client,165,178,'utf-8');
             
              $dateop = new Zend_Date($donnees->date_reglt,Zend_Date::ISO_8601);       
              $page->drawText("Date opération           :",50,158,'utf-8');
              $page->drawText($dateop->toString('dd/mm/yyyy'),165,158, 'utf-8');
             
              $page->drawText("Opérateur/Opératrice :",50,138,'utf-8');
              $page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,165,138, 'utf-8');
             
              $users = new Application_Model_DbTable_EuUtilisateur();
              $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
              $sel->setIntegrityCheck(false)        
                  ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                  ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
              $data1 = $users->fetchAll($sel);
              foreach($data1 as $agences)
	          {
                $page->drawText("Agence                       :",50,118,'utf-8');
                $page->drawText($agences->libelle_agence,165,118, 'utf-8');
              }
                $page->drawText("Signature de l'opérateur/opératrice",50,78, 'utf-8');
                $page->drawText('Signature du client',360,78, 'utf-8');     
              }
                //permet de spécifier l'en-tête http
		        header('Content-Type: application/pdf; charset=utf-8');
		       //affichage de notre pdf
	            echo $pdf->render();
                $this->view->data = $pdf->render();
		       //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
	          //permet de désactiver l'affichage de la vue de l'action list
		        $this->_helper->viewRenderer->setNoRender(true);
		       //permet de désactiver l'affichage du layout
		       $this->_helper->layout->disableLayout();
     }
	
		
	public function apaAction()
	{
        //récupération des données
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		$operation = new Application_Model_DbTable_EuOperation();
        $select = $operation->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_compte_credit', 'eu_compte_credit.id_operation = eu_operation.id_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
               ->join('eu_membre', 'eu_membre.code_membre = eu_operation.code_membre',array('eu_operation.*','eu_membre.*'))
               ->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_operation.id_utilisateur',array('eu_operation.*','eu_utilisateur.nom_utilisateur',
			   'eu_utilisateur.prenom_utilisateur'))  
               ->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur)   
               ->where('eu_operation.id_operation = ?',   $_POST["id_operation"]); 
         $data = $operation->fetchAll($select); 
                 
         //création d document pdf
		 $pdf = new Default_Pdf_Reglement(); 
         $pdf->pages = array_reverse($pdf->pages);
         // Création d'une nouvelle page attachée au document
         $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
         $pdf->pages[] = ($page = $pdf->newPage('A4'));
         $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
         $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                
         foreach($data as $donnees) {
		 
           $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
           //$page->drawRectangle(37,725,560,830); 
		   $page->drawRoundedRectangle(37,725,565,835,30);
           $page->drawRoundedRectangle(42,730,560,830,30);
           //$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
           $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $page->setFillColor($noir);
           $page->setFont($font,18); 
           $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
           $page->setFillColor($rouge);
		   $page->drawText("mcnp",280,793,'utf-8');
           //Charger une image
           $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
           $page->drawImage($image,55,775,105,825);
           $noir = new Zend_Pdf_Color_Rgb(0,0,0);
           $page->setFillColor($noir);
           $page->setFont($font,14);
           $page->drawText("Marché de Crédit en Nature Pérenne",185,779,'utf-8');
                                
           //déplacement du curseur vers la droite de 120 
           $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
           $page->setFont($font1,8);
           $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
           $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
           $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,750, 'utf-8');
           $page->setFont($font,14);
           $page->drawText("achat du pouvoir d'achat (apa) ",185,733,'utf-8');
           
		        
            
		   $page->setFont($font1,12);
           $page->drawText("N° de reçu                 :",50,700,'utf-8');
           $page->drawText($_POST['id_operation'],160,700,'utf-8');
			
			       
           $page->setFont($font1,12);
           $page->drawText("Code membre            :",50,680,'utf-8');
           $page->drawText($donnees->code_membre,160,680,'utf-8');
           
		             
           if(substr($donnees->code_membre,19,1) == 'p') {
              $page->drawText("Nom && Prénom      :",50,660,'utf-8');    
              $page->drawText($donnees->nom_membre."     ".$donnees->PREnom_membre,160,660,'utf-8');
           }
           /*else {
              $page->drawText("Raison sociale           :",50,660,'utf-8');    
              $page->drawText($donnees->raison_sociale,160,660,'utf-8');
           }*/
              $page->drawText("Montant placé           :",50,640,'utf-8');
              $page->drawText("$donnees->montant_op",160,640,'utf-8');
                     
                     
                     
              $page->drawText("Type opération          :",50,620,'utf-8');
              $page->drawText($donnees->lib_op,160,620,'utf-8');
              
                     
              $page->drawText("Date opération           :",50,600,'utf-8');
              $page->drawText($donnees->dateop,160,600, 'utf-8');
                     
              $page->drawText("Opérateur/Opératrice :",50,580,'utf-8');
              $page->drawText($donnees->nom_utilisateur."  ".$donnees->PREnom_utilisateur,160,580, 'utf-8');
                     
              $users = new Application_Model_DbTable_EuUtilisateur();
              $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
              $sel->setIntegrityCheck(false)        
                  ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                  ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
              $data1 = $users->fetchAll($sel);
              foreach($data1 as $agences)
	          {
                 $page->drawText("Agence                       :",50,560,'utf-8');
                 $page->drawText($agences->libelle_agence,160,560, 'utf-8');
              }
                 $page->drawText("Signature de l'opérateur/opératrice",50,520, 'utf-8');
                 $page->drawText('Signature du client',360,520, 'utf-8');
                //$page->drawLine(50,450,560,450);
                     
                $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,450, 'utf-8');
                     
                $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                //$page->drawRectangle(37,282,560,390);
				//$page->drawRoundedRectangle(37,725,565,835,30);
                //$page->drawRoundedRectangle(42,730,560,830,30);
				$page->drawRoundedRectangle(37,282,565,390,30);
                $page->drawRoundedRectangle(42,287,560,385,30);
                $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                $page->setFillColor($noir);
                $page->setFont($font,18); 
                $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                $page->setFillColor($rouge);
		        $page->drawText("mcnp",280,355,'utf-8');
                     
                //Charger une image
                $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                $page->drawImage($image,55,330,105,380);
                $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                $page->setFillColor($noir);
                $page->setFont($font,14);
                $page->drawText("Marché de Crédit en Nature Pérenne",185,339,'utf-8');
                                
                //déplacement du curseur vers la droite de 120 
                $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                $page->setFont($font1,8);
                $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,328, 'utf-8');
                $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,318, 'utf-8');
                $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,308, 'utf-8');
                $page->setFont($font,14);
                $page->drawText("achat du pouvoir d'achat (apa) ",185,290,'utf-8');
                
                 
				 
				$page->setFont($font1,12);
                $page->drawText("N° de reçu                 :",50,258,'utf-8');
                $page->drawText($_POST['id_operation'],160,258,'utf-8'); 
				 
				
				     
                $page->setFont($font1,12);
                $page->drawText("Code membre            :",50,238,'utf-8');
                $page->drawText($donnees->code_membre,160,238,'utf-8');
                
				
				     
                if(substr($donnees->code_membre,19,1)=='p') {
                     $page->drawText("Nom && Prénom      :",50,218,'utf-8');    
                     $page->drawText($donnees->nom_membre."     ".$donnees->PREnom_membre,160,218,'utf-8');
                }
                /*else {
                     $page->drawText("Raison sociale           :",50,218,'utf-8');    
                     $page->drawText($donnees->raison_sociale,160,218,'utf-8');
                }*/
                     $page->drawText("Montant placé           :",50,198,'utf-8');
                     $page->drawText("$donnees->montant_op",160,198,'utf-8');
                     
                     //$page->drawText("Montant crédit :",50,640,'utf-8');
                     //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                     $page->drawText("Type opération          :",50,178,'utf-8');
                     $page->drawText($donnees->lib_op,160,178,'utf-8');
                     
                     $page->drawText("Date opération           :",50,158,'utf-8');
                     $page->drawText($donnees->dateop,160,158, 'utf-8');
                     
                     $page->drawText("Opérateur/Opératrice :",50,138,'utf-8');
                     $page->drawText($donnees->nom_utilisateur."  ".$donnees->PREnom_utilisateur,160,138, 'utf-8');
                     
                     $users = new Application_Model_DbTable_EuUtilisateur();
                     $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	                 {
                       $page->drawText("Agence                       :",50,118,'utf-8');
                       $page->drawText($agences->libelle_agence,160,118, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,78, 'utf-8');
                     $page->drawText('Signature du client',360,78, 'utf-8');     
                }
                
                //permet de spécifier l'en-tête http
		        header('Content-Type: application/pdf; charset=utf-8');
 
		       //affichage de notre pdf
		       echo $pdf->render();
               $this->view->data = $pdf->render();
                
		       //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		      //permet de désactiver l'affichage de la vue de l'action list
		      $this->_helper->viewRenderer->setNoRender(true);
                
		      //permet de désactiver l'affichage du layout
		      $this->_helper->layout->disableLayout();
              
              }
		
		
		      public function mfAction() {
			  
                    //récupération des données
                    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
                    $user = $auth->getIdentity();
                    $reglement = new Application_Model_DbTable_EuReglementMf();
                    $select = $reglement->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                    $select->setIntegrityCheck(false)        
                           //->join('eu_membre_fondateur11000', 'eu_membre_fondateur11000.num_bon = eu_reglement_mf.code_membre')
                           ->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_reglement_mf.id_utilisateur')  
                           ->where('eu_reglement_mf.id_utilisateur = ?',$user->id_utilisateur)   
                           ->where('eu_reglement_mf.id_reglt_mf = ?',$_POST['id_reglt']); 
                    $data = $reglement->fetchAll($select);
            
            
                    //création d document pdf
		            $pdf = new Default_Pdf_Reglement(); 
                    $pdf->pages = array_reverse($pdf->pages);
                    // Création d'une nouvelle page attachée au document
                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
                    $pdf->pages[] = ($page = $pdf->newPage('A4'));
                    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
                    $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                
                    foreach($data as $donnees)
	                {  
                      $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                      $page->drawRectangle(37,725,560,830);
					  //$page->drawRoundedRectangle(37,725,565,835,30);
                      //$page->drawRoundedRectangle(42,730,560,830,30);
                      $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                      $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                      $page->setFillColor($noir);
                      $page->setFont($font,18); 
                      $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                      $page->setFillColor($rouge);
		              $page->drawText("mcnp",280,793,'utf-8');
                      //Charger une image
                      $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                      $page->drawImage($image,55,775,105,825);
                      $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                      $page->setFillColor($noir);
                      $page->setFont($font,14);
                      $page->drawText("Marché de Crédit en Nature Pérenne",185,779,'utf-8');
                                
                      //déplacement du curseur vers la droite de 120 
                      $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                      $page->setFont($font1,8);
                      $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
                      $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
                      $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,750, 'utf-8');
                      $page->setFont($font,14);
                      $page->drawText("recu de reglement deS membres fondateurs 11000",125,730,'utf-8');
                    
                    
                      $page->setFont($font1,12);
                    
                      $page->drawText("Numéro du reçu         :",50,700,'utf-8');
                      $page->drawText($_POST['id_reglt'],160,700,'utf-8');
                    
                      $page->drawText("Numéro de bon          :",50,680,'utf-8');
                      $page->drawText($_POST['code_mf11000'],160,680,'utf-8');
                     
					  $membres = new Application_Model_DbTable_EuMembreFondateur11000();
                      $sels = $membres->select();  
                      $sels->where('num_bon = ?',$_POST['code_mf11000']); 
                      $datas = $membres->fetchAll($sels);
                      foreach($datas as $enr)
	                  {
                         $page->drawText("Nom && Prénom      :",50,660,'utf-8');    
                         $page->drawText($enr->nom."     ".$enr->prenom,160,660,'utf-8'); 
                      }
					 
                     // if($donnees->type_membre=='p') {
                      
                   //}
                   // else {
                   //   $page->drawText("Raison sociale          :",50,660,'utf-8');    
                   //   $page->drawText($donnees->raison_sociale,160,660,'utf-8');
                  // }
                     
                      $page->drawText("Montant reçu             :",50,640,'utf-8');
                      $page->drawText("$donnees->mont_reglt_mf",160,640,'utf-8');
                     
                     //$page->drawText("Montant crédit :",50,640,'utf-8');
                     //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                     $dateop = new Zend_Date($donnees->date_reglt_mf,Zend_Date::ISO_8601);
                     
                     $page->drawText("Date opération           :",50,620,'utf-8');
                     $page->drawText($dateop->toString('dd/mm/yyyy'),160,620, 'utf-8');
                     
                     $page->drawText("Opérateur/Opératrice :",50,600,'utf-8');
                     $page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,160,600, 'utf-8');
                     
                     $users = new Application_Model_DbTable_EuUtilisateur();
                     $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	                 {
                       $page->drawText("Agence                       :",50,580,'utf-8');
                       $page->drawText($agences->libelle_agence,160,580, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,540, 'utf-8');
                     $page->drawText('Signature du client',360,540, 'utf-8');
                     //$page->drawLine(50,450,560,450);
                     
                     $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,450, 'utf-8');
                     
                     $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                     $page->drawRectangle(37,282,560,390);
					 //$page->drawRoundedRectangle(37,725,565,835,30);
                     //$page->drawRoundedRectangle(42,730,560,830,30);
                     $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                     $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                     $page->setFillColor($noir);
                     $page->setFont($font,18); 
                     $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                     $page->setFillColor($rouge);
		             $page->drawText("mcnp",280,355,'utf-8');
                     
                     //Charger une image
                     $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                     $page->drawImage($image,55,330,105,380);
                     $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                     $page->setFillColor($noir);
                     $page->setFont($font,14);
                     $page->drawText("Marché de Crédit en Nature Pérenne",185,339,'utf-8');
                                
                     //déplacement du curseur vers la droite de 120 
                     $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                     $page->setFont($font1,8);
                     $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,328, 'utf-8');
                     $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,318, 'utf-8');
                     $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,308, 'utf-8');
                     $page->setFont($font,14);
                     $page->drawText("recu de reglement deS membres fondateurs 11000",125,288,'utf-8');
                
                     
                     $page->setFont($font1,12);
                     
                     $page->drawText("Numéro du reçu         :",50,258,'utf-8');
                     $page->drawText($_POST['id_reglt'],160,258,'utf-8');
                     
                     $page->drawText("Numéro de bon          :",50,238,'utf-8');
                     $page->drawText($_POST['code_mf11000'],160,238,'utf-8');
                     
					 $membres = new Application_Model_DbTable_EuMembreFondateur11000();
                      $sels = $membres->select();  
                      $sels->where('num_bon = ?',$_POST['code_mf11000']); 
                      $datas = $membres->fetchAll($sels);
                      foreach($datas as $enr)
	                  {
                         $page->drawText("Nom && Prénom      :",50,218,'utf-8');    
                         $page->drawText($enr->nom."     ".$enr->prenom,160,218,'utf-8'); 
                      }
					 
					 
                     //if($donnees->type_membre=='p') {
                     
                     //}
                     // else {
                     //  $page->drawText("Raison sociale          :",50,218,'utf-8');    
                    //  $page->drawText($donnees->raison_sociale,160,218,'utf-8');
                    // }
                     
                     $page->drawText("Montant reçu             :",50,198,'utf-8');
                     $page->drawText("$donnees->mont_reglt_mf",160,198,'utf-8');
                     
                     //$page->drawText("Montant crédit :",50,640,'utf-8');
                     //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                     $dateop = new Zend_Date($donnees->date_reglt_mf,Zend_Date::ISO_8601);
                     
                     $page->drawText("Date opération           :",50,178,'utf-8');
                     $page->drawText($dateop->toString('dd/mm/yyyy'),160,178, 'utf-8');
                     
                     $page->drawText("Opérateur/Opératrice :",50,158,'utf-8');
                     $page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,160,158, 'utf-8');
                     
                     $users = new Application_Model_DbTable_EuUtilisateur();
                     $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	                 {
                            $page->drawText("Agence                       :",50,138,'utf-8');
                            $page->drawText($agences->libelle_agence,160,138, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,98, 'utf-8');
                     $page->drawText('Signature du client',360,98, 'utf-8');     
                  }
            
                  //permet de spécifier l'en-tête http
		    header('Content-Type: application/pdf; charset=utf-8');
 
		  //affichage de notre pdf
		    echo $pdf->render();
                    $this->view->data = $pdf->render();
                
		  //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		  //permet de désactiver l'affichage de la vue de l'action list
		    $this->_helper->viewRenderer->setNoRender(true);
                
		  //permet de désactiver l'affichage du layout
		    $this->_helper->layout->disableLayout();
        }
		
	    public function crediterAction() {
            $request = $this->getRequest();
            $id_mf107 = $request->id_mf107;
            //création d document pdf
            $pdf = new Default_Pdf_Reglement(); 
            $pdf->pages = array_reverse($pdf->pages);
            // Création d'une nouvelle page attachée au document
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
            $pdf->pages[] = ($page = $pdf->newPage('A4'));
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
            
            //récupération des données
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            
            $dmf107 = new Application_Model_DbTable_EuDetailMf107();
            $select = $dmf107->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)        
                   ->join('eu_membre', 'eu_membre.code_membre = EU_DETAIL_MF107.code_membre',array('eu_membre.*',"to_char((EU_DETAIL_MF107.DATE_MF107),'dd/mm/yyyy') DATEMF107",'EU_DETAIL_MF107.*'))     
                   ->where('EU_DETAIL_MF107.ID_MF107 =?',$id_mf107); 
            $data = $dmf107->fetchAll($select);
            
            foreach($data as $donnees)
	        {  
               $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
               //$page->drawRectangle(37,725,560,830);
			   $page->drawRoundedRectangle(37,725,565,835,30);
               $page->drawRoundedRectangle(42,730,560,830,30);
               $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
               $noir = new Zend_Pdf_Color_Rgb(0,0,0);
               $page->setFillColor($noir);
               $page->setFont($font,40); 
               $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
               $page->setFillColor($rouge);
	           $page->drawText("m c n p",240,793,'utf-8');
               //Charger une image
               $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
               $page->drawImage($image,55,775,105,825);
               $noir = new Zend_Pdf_Color_Rgb(0,0,0);
               $page->setFillColor($noir);
               $page->setFont($font,14);
               $page->drawText("Marché de Crédit en Nature Pérenne",190,779,'utf-8');
                                
               //déplacement du curseur vers la droite de 120 
               $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
               $page->setFont($font1,8);
               $page->drawText("Arrêté N°10/1533/oapi/dg portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
               $page->drawText("Arrêté N°10/2131/oapi/dg portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
               
               $page->setFont($font,14);
               $page->drawText("recu de placement sur les comptes MF107 ",125,740,'utf-8');
                    
               $page->setFont($font1,12);
                    
               $mf107 = new Application_Model_DbTable_EuMembreFondateur107();
               $selection = $mf107->select();
               $selection->where('EU_MEMBRE_FONDATEUR107.numident = ?',$donnees->numident); 
               $query = $mf107->fetchAll($selection);
                    
               foreach($query as $resp)
	           {
                    $page->drawText("Compte Marchand propriétaire :",50,700,'utf-8');
                    $page->drawText($resp->code_membre,210,700,'utf-8');  
               }
                    
                    $page->drawText("Pourcentage propriétaire           :",50,680,'utf-8');
                    $page->drawText($donnees->pourcentage.' '.'%',210,680,'utf-8');
                    
                    $page->drawText("Compte Marchand apporteur    :",50,660,'utf-8');
                    $page->drawText($donnees->code_membre,210,660,'utf-8');
                    
                    if(substr($donnees->code_membre,19,1)=='p') {
                     $page->drawText("Nom && Prénom apporteur     :",50,640,'utf-8');    
                     $page->drawText($donnees->nom_membre."     ".$donnees->PREnom_membre,210,640,'utf-8');
                    }
                     
                     $page->drawText("Montant placé                           :",50,620,'utf-8');
                     $page->drawText("$donnees->mont_apport",210,620,'utf-8');
                     
                     //$page->drawText("Montant crédit :",50,640,'utf-8');
                     //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                   
                     
                     $page->drawText("Date du placement                    :",50,600,'utf-8');
                     $page->drawText($donnees->DATEMF107,210,600, 'utf-8');
                     
                     
                     $users = new Application_Model_DbTable_EuUtilisateur();
                     $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	             {
                       $page->drawText("Opérateur/Opératrice                :",50,580,'utf-8');
                       $page->drawText($agences->nom_utilisateur."  ".$agences->PREnom_utilisateur,210,580,'utf-8');  
                       $page->drawText("Agence                                      :",50,560,'utf-8');
                       $page->drawText($agences->libelle_agence,210,560, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,500, 'utf-8');
                     $page->drawText('Signature du client',360,500, 'utf-8');
                     //$page->drawLine(50,450,560,450);
                     
                     
                     $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,430, 'utf-8');
                     
                     
                     $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                     //$page->drawRectangle(37,282,560,390);
					 $page->drawRoundedRectangle(37,282,560,390,30);
                     $page->drawRoundedRectangle(42,287,555,385,30);
                     $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                     $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                     $page->setFillColor($noir);
                     $page->setFont($font,40); 
                     $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                     $page->setFillColor($rouge);
		             $page->drawText("m c n p",240,350,'utf-8');
                     
                     
                     //Charger une image
                     $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                     $page->drawImage($image,55,330,105,380);
                     $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                     $page->setFillColor($noir);
                     $page->setFont($font,14);
                     $page->drawText("Marché de Crédit en Nature Pérenne",190,334,'utf-8');
                     
                     
                     //déplacement du curseur vers la droite de 120 
                     $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                     $page->setFont($font1,8);
                     $page->drawText("Arrêté N°10/1533/oapi/dg portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,323, 'utf-8');
                     $page->drawText("Arrêté N°10/2131/oapi/dg portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,313, 'utf-8');
                     $page->setFont($font,14);
                     $page->drawText("recu de placement sur les comptes MF107 ",125,293,'utf-8');
                
                     
                     $page->setFont($font1,12);
                     
                     $mf107 = new Application_Model_DbTable_EuMembreFondateur107();
                     $selection = $mf107->select();
                     $selection->where('EU_MEMBRE_FONDATEUR107.numident = ?',$donnees->numident); 
                     $query = $mf107->fetchAll($selection);
                     
                     foreach($query as $resp)
	                 {
                       $page->drawText("Compte Marchand propriétaire :",50,258,'utf-8');
                       $page->drawText($resp->code_membre,210,258,'utf-8');  
                     }
                     
                     $page->drawText("Pourcentage propriétaire           :",50,238,'utf-8');
                     $page->drawText($donnees->pourcentage.' '.'%',210,238,'utf-8');
                     
                     $page->drawText("Compte Marchand apporteur    :",50,218,'utf-8');
                     $page->drawText($donnees->code_membre,210,218,'utf-8');
                     
                     
                        $page->drawText("Nom && Prénom apporteur     :",50,198,'utf-8');    
                        $page->drawText($donnees->nom_membre."     ".$donnees->PREnom_membre,210,198,'utf-8');
                     
               
                     
                        $page->drawText("Montant placé                           :",50,178,'utf-8');
                        $page->drawText("$donnees->mont_apport",210,178,'utf-8');
                     
                        //$page->drawText("Montant crédit :",50,640,'utf-8');
                        //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                       
                     
                        $page->drawText("Date du placement                    :",50,158,'utf-8');
                        $page->drawText($donnees->DATEMF107,210,158, 'utf-8');
                     
                        $users = new Application_Model_DbTable_EuUtilisateur();
                        $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                        $sel->setIntegrityCheck(false)        
                            ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                            ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                        $data1 = $users->fetchAll($sel);
                        foreach($data1 as $agences)
	                    {      
                            $page->drawText("Opérateur/Opératrice                :",50,138,'utf-8');
                            $page->drawText($agences->nom_utilisateur."  ".$agences->PREnom_utilisateur,210,138, 'utf-8');
                            $page->drawText("Agence                                      :",50,118,'utf-8');
                            $page->drawText($agences->libelle_agence,210,118, 'utf-8');
                        }
                        $page->drawText("Signature de l'opérateur/opératrice",50,78, 'utf-8');
                        $page->drawText('Signature du client',360,78, 'utf-8');     
                  }
            
                 //permet de spécifier l'en-tête http
                 header('Content-Type: application/pdf; charset=utf-8');
 
	             //affichage de notre pdf
                 echo $pdf->render();
                 $this->view->data = $pdf->render();
                
                 //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
                 //permet de désactiver l'affichage de la vue de l'action list
	             $this->_helper->viewRenderer->setNoRender(true);
                
                 //permet de désactiver l'affichage du layout
                 $this->_helper->layout->disableLayout();
            
    }
		
		
		
		public function crediter1Action() {
            
            $request = $this->getRequest();
            $id_mf11000 = $request->id_mf11000;
            //création d document pdf
            $pdf = new Default_Pdf_Reglement(); 
            $pdf->pages = array_reverse($pdf->pages);
            // Création d'une nouvelle page attachée au document
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
            $pdf->pages[] = ($page = $pdf->newPage('A4'));
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
            $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
            
            //récupération des données
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            
            $dmf11000 = new Application_Model_DbTable_EuDetailMf11000();
            $select = $dmf11000->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)        
                   ->join('eu_membre', 'eu_membre.code_membre = eu_detail_mf11000.code_membre')     
                   ->where('eu_detail_mf11000.id_mf11000 =?',$id_mf11000); 
            $data = $dmf11000->fetchAll($select);
            
            foreach($data as $donnees)
	        {  
               $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
               $page->drawRectangle(37,725,560,830);
			   //$page->drawRoundedRectangle(37,725,565,835,30);
               //$page->drawRoundedRectangle(42,730,560,830,30);
               $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
               $noir = new Zend_Pdf_Color_Rgb(0,0,0);
               $page->setFillColor($noir);
               $page->setFont($font,18); 
               $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
               $page->setFillColor($rouge);
	           $page->drawText("mcnp",280,793,'utf-8');
               //Charger une image
               $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
               $page->drawImage($image,55,775,105,825);
               $noir = new Zend_Pdf_Color_Rgb(0,0,0);
               $page->setFillColor($noir);
               $page->setFont($font,14);
               $page->drawText("Marché de Crédit en Nature Pérenne",185,779,'utf-8');
                                
               //déplacement du curseur vers la droite de 120 
                    $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                    $page->setFont($font1,8);
                    $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
                    $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
                    $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,750, 'utf-8');
                    $page->setFont($font,14);
                    $page->drawText("recu de placement sur les comptes MF11000",125,730,'utf-8');
                    
                    $page->setFont($font1,12);
                    
                    $mf11000 = new Application_Model_DbTable_EuMembreFondateur11000();
                    $selection = $mf11000->select();
                    $selection->where('eu_membre_fondateur11000.num_bon = ?',$donnees->num_bon); 
                    $query = $mf11000->fetchAll($selection);
                    
                    foreach($query as $resp)
	                {
                      $page->drawText("Compte Marchand propriétaire :",50,700,'utf-8');
                      $page->drawText($resp->code_membre,210,700,'utf-8');  
                    }
					
                      $page->drawText("Pourcentage propriétaire           :",50,680,'utf-8');
                      $page->drawText($donnees->pourcentage.' '.'%',210,680,'utf-8');
					  
					  
					  $page->drawText("Compte Marchand apporteur    :",50,660,'utf-8');
                      $page->drawText($donnees->code_membre,210,660,'utf-8');
                    
                    if($donnees->type_membre=='p') {
                      $page->drawText("Nom && Prénom apporteur     :",50,640,'utf-8');    
                      $page->drawText($donnees->nom_membre."     ".$donnees->prenom_membre,210,640,'utf-8');
                    }
                    else {
                      $page->drawText("Raison sociale apporteur     :",50,640,'utf-8');    
                      $page->drawText($donnees->raison_sociale,210,640,'utf-8');
                   }
                     
                      $page->drawText("Montant placé                           :",50,620,'utf-8');
                      $page->drawText("$donnees->mont_apport",210,620,'utf-8');
                     
                      //$page->drawText("Montant crédit :",50,640,'utf-8');
                      //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                      $dateop = new Zend_Date($donnees->date_mf11000,Zend_Date::ISO_8601);
                     
                      $page->drawText("Date du placement                    :",50,600,'utf-8');
                      $page->drawText($dateop->toString('dd/mm/yyyy'),210,600, 'utf-8');
                     
                     
                      $users = new Application_Model_DbTable_EuUtilisateur();
                      $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                      $sel->setIntegrityCheck(false)        
                          ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                          ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                      $data1 = $users->fetchAll($sel);
                      foreach($data1 as $agences)
	                  {
                       $page->drawText("Opérateur/Opératrice                :",50,580,'utf-8');
                       $page->drawText($agences->nom_utilisateur."  ".$agences->prenom_utilisateur,210,580,'utf-8');  
                       $page->drawText("Agence                                      :",50,560,'utf-8');
                       $page->drawText($agences->libelle_agence,210,560, 'utf-8');
                      }
                       $page->drawText("Signature de l'opérateur/opératrice",50,520, 'utf-8');
                       $page->drawText('Signature du client',360,520, 'utf-8');
                       //$page->drawLine(50,450,560,450);
                     
                     
                       $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,430, 'utf-8');
                     
                     
                       $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                       $page->drawRectangle(37,282,560,390);
					   //$page->drawRoundedRectangle(37,725,565,835,30);
                       //$page->drawRoundedRectangle(42,730,560,830,30);
                       $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                       $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                       $page->setFillColor($noir);
                       $page->setFont($font,18); 
                       $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                       $page->setFillColor($rouge);
		               $page->drawText("mcnp",280,355,'utf-8');
                     
                     
                       //Charger une image
                       $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                       $page->drawImage($image,55,330,105,380);
                       $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                       $page->setFillColor($noir);
                       $page->setFont($font,14);
                       $page->drawText("Marché de Crédit en Nature Pérenne",185,339,'utf-8');
                     
                     
                       //déplacement du curseur vers la droite de 120 
                       $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                       $page->setFont($font1,8);
                       $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,328, 'utf-8');
                       $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,318, 'utf-8');
                       $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,308, 'utf-8');
                       $page->setFont($font,14);
                       $page->drawText("recu de placement sur les comptes MF11000 ",125,288,'utf-8');
                
                     
                       $page->setFont($font1,12);
                     
                       $mf11000 = new Application_Model_DbTable_EuMembreFondateur11000();
                       $selection = $mf11000->select();
                       $selection->where('eu_membre_fondateur11000.num_bon = ?',$donnees->num_bon); 
                       $query = $mf107->fetchAll($selection);
					 
                       foreach($query as $resp)
	                   {
                         $page->drawText("Compte Marchand propriétaire :",50,258,'utf-8');
                         $page->drawText($resp->code_membre,210,258,'utf-8');  
                       }
                        
					   $page->drawText("Pourcentage propriétaire           :",50,238,'utf-8');
                       $page->drawText($donnees->pourcentage.' '.'%',210,238,'utf-8');	
						
                       $page->drawText("Compte Marchand apporteur    :",50,218,'utf-8');
                       $page->drawText($donnees->code_membre,210,218,'utf-8');
                     
                       if($donnees->type_membre=='p') {
                          $page->drawText("Nom && Prénom apporteur     :",50,198,'utf-8');    
                          $page->drawText($donnees->nom_membre."     ".$donnees->prenom_membre,210,198,'utf-8');
                       }
                       else {
                          $page->drawText("Raison sociale apporteur     :",50,198,'utf-8');    
                          $page->drawText($donnees->raison_sociale,210,198,'utf-8');
                       }
                     
                       $page->drawText("Montant placé                           :",50,178,'utf-8');
                       $page->drawText("$donnees->mont_apport",210,178,'utf-8');
                     
                       //$page->drawText("Montant crédit :",50,640,'utf-8');
                       //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                       $dateop = new Zend_Date($donnees->date_mf11000,Zend_Date::ISO_8601);
                     
                       $page->drawText("Date du placement                    :",50,158,'utf-8');
                       $page->drawText($dateop->toString('dd/mm/yyyy'),210,158, 'utf-8');
                     
                       $users = new Application_Model_DbTable_EuUtilisateur();
                       $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                       $sel->setIntegrityCheck(false)        
                           ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                           ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                       $data1 = $users->fetchAll($sel);
                       foreach($data1 as $agences)
	                   {      
                           $page->drawText("Opérateur/Opératrice                :",50,138,'utf-8');
                           $page->drawText($agences->nom_utilisateur."  ".$agences->prenom_utilisateur,210,138, 'utf-8');
                           $page->drawText("Agence                                      :",50,118,'utf-8');
                           $page->drawText($agences->libelle_agence,210,118, 'utf-8');
                       }
                           $page->drawText("Signature de l'opérateur/opératrice",50,78, 'utf-8');
                           $page->drawText('Signature du client',360,78, 'utf-8');     
                  }
            
            //permet de spécifier l'en-tête http
            header('Content-Type: application/pdf; charset=utf-8');
 
	        //affichage de notre pdf
            echo $pdf->render();
            $this->view->data = $pdf->render();
                
            //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
            //permet de désactiver l'affichage de la vue de l'action list
	        $this->_helper->viewRenderer->setNoRender(true);
                
            //permet de désactiver l'affichage du layout
            $this->_helper->layout->disableLayout();
            
}
		
	
		public function echangeAction()
	    {
		          //récupération des données
                  $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
                  $user = $auth->getIdentity();
		          $echange = new Application_Model_DbTable_EuEchange();
                  $select = $echange->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                  $select->setIntegrityCheck(false)        
                         ->join('eu_membre', 'eu_membre.code_membre = eu_echange.code_membre')
                         ->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_echange.id_utilisateur')  
                         ->where('eu_echange.id_utilisateur = ?',$user->id_utilisateur)   
                         ->where('eu_echange.id_echange = ?',$_POST['id_echange']); 
                  $data = $echange->fetchAll($select); 
                 
                  //création d document pdf
		          $pdf = new Default_Pdf_Reglement(); 
                  $pdf->pages = array_reverse($pdf->pages);
                  // Création d'une nouvelle page attachée au document
                  $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
                  $pdf->pages[] = ($page = $pdf->newPage('A4'));
                  $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times_bold);
                  $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
		
		          foreach($data as $donnees)
	              {  
                    $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                    $page->drawRectangle(37,725,560,830);
					//$page->drawRoundedRectangle(37,725,565,835,30);
                    //$page->drawRoundedRectangle(42,730,560,830,30);
                    $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $page->setFillColor($noir);
                    $page->setFont($font,18); 
                    $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                    $page->setFillColor($rouge);
		            $page->drawText("mcnp",280,793,'utf-8');
                    //Charger une image
                    $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                    $page->drawImage($image,55,775,105,825);
                    $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                    $page->setFillColor($noir);
                    $page->setFont($font,14);
                    $page->drawText("Marché de Crédit en Nature Pérenne",185,779,'utf-8');
                                
                    //déplacement du curseur vers la droite de 120 
                    $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                    $page->setFont($font1,8);
                    $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,768, 'utf-8');
                    $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,758, 'utf-8');
                    $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,750, 'utf-8');
                    $page->setFont($font,14);
                    $page->drawText("echange des numeriques ",185,730,'utf-8');
                
				
				    $page->setFont($font1,12);
                    $page->drawText("N° de reçu                 :",50,700,'utf-8');
                    $page->drawText($_POST['id_echange'],160,700,'utf-8');
					
                   
                    $page->setFont($font1,12);
                    $page->drawText("Code membre            :",50,680,'utf-8');
                    $page->drawText($_POST['code_membre'],160,680,'utf-8');
                    
					
					 
                    if($donnees->type_membre=='p') {
                     $page->drawText("Nom && Prénom      :",50,660,'utf-8');    
                     $page->drawText($donnees->nom_membre."     ".$donnees->prenom_membre,160,660,'utf-8');
                    }
                    else {
                     $page->drawText("Raison sociale           :",50,660,'utf-8');    
                     $page->drawText($donnees->raison_sociale,160,660,'utf-8');
                    }
                     
                     $page->drawText("Montant échangé       :",50,640,'utf-8');
                     $page->drawText("$donnees->montant_echange",160,640,'utf-8');
                     
					 
                     //$page->drawText("Montant crédit :",50,640,'utf-8');
                     //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
					 
                     $page->drawText("Type echange            :",50,620,'utf-8');
                     $page->drawText($donnees->type_echange,160,620,'utf-8');
                     $dateop = new Zend_Date($donnees->date_echange,Zend_Date::ISO_8601);
                     
                     $page->drawText("Date opération           :",50,600,'utf-8');
                     $page->drawText($dateop->toString('dd/mm/yyyy'),160,600, 'utf-8');
                     
                     $page->drawText("Opérateur/Opératrice :",50,580,'utf-8');
                     $page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,160,580, 'utf-8');
                     
                     $users = new Application_Model_DbTable_EuUtilisateur();
                     $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	                 {
                       $page->drawText("Agence                       :",50,560,'utf-8');
                       $page->drawText($agences->libelle_agence,160,560, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,520, 'utf-8');
                     $page->drawText('Signature du client',360,520, 'utf-8');
                     //$page->drawLine(50,450,560,450);
                     
                     $page->drawText('------------------------------------------------------------------------------------------------------------------------------',40,450, 'utf-8');
                     
                     $page->setFillColor(new Zend_Pdf_Color_GrayScale(1.0));
                     $page->drawRectangle(37,282,560,390);
					 //$page->drawRoundedRectangle(37,282,560,390,30);
                     //$page->drawRoundedRectangle(42,287,555,385,30);
                     $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.0));
                     $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                     $page->setFillColor($noir);
                     $page->setFont($font,18); 
                     $rouge = new Zend_Pdf_Color_Rgb(1,0,0);
                     $page->setFillColor($rouge);
		             $page->drawText("mcnp",280,355,'utf-8');
                     
					 
                     //Charger une image
                     $image = Zend_Pdf_Image::imageWithPath(application_path.'/../public/images/logo.jpg');
                     $page->drawImage($image,55,330,105,380);
                     $noir = new Zend_Pdf_Color_Rgb(0,0,0);
                     $page->setFillColor($noir);
                     $page->setFont($font,14);
                     $page->drawText("Marché de Crédit en Nature Pérenne",185,339,'utf-8');
                      
					            
                     //déplacement du curseur vers la droite de 120 
                     $font1 = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::font_times);
                     $page->setFont($font1,8);
                     $page->drawText("arrete N°10/1533/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63271 du 09 décembre 2009 sous N° 3200902614",100,328, 'utf-8');
                     $page->drawText("arrete N°10/2131/oapi/dg/dga/dpi/ssd portant enrégistrement de la marque N°:63869 du 15 février 2010 sous N° 32001000435",100,318, 'utf-8');
                     $page->drawText("227,Rue des Amandiers Tokoin-Nukafu b.p.:30038 lome-togo Tél:+(228)22260662/Site web:www.eu-mcnp.com/Adresse électronique:mcnp@yahoo.fr",50,308, 'utf-8');
                     $page->setFont($font,14);
                     $page->drawText("echange des numeriques ",185,288,'utf-8');
                
				
                     $page->setFont($font1,12);
                     $page->drawText("N° de reçu                 :",50,258,'utf-8');
                     $page->drawText($_POST['id_echange'],160,258,'utf-8');
					 
					 
                     $page->setFont($font1,12);
                     $page->drawText("Code membre            :",50,238,'utf-8');
                     $page->drawText($_POST['code_membre'],160,238,'utf-8');
                     
                     if($donnees->type_membre=='p') {
                     $page->drawText("Nom && Prénom      :",50,218,'utf-8');    
                     $page->drawText($donnees->nom_membre."     ".$donnees->prenom_membre,160,218,'utf-8');
                     }
                    else {
                     $page->drawText("Raison sociale           :",50,218,'utf-8');    
                     $page->drawText($donnees->raison_sociale,160,218,'utf-8');
                   }
                     
                     $page->drawText("Montant echangé       :",50,198,'utf-8');
                     $page->drawText("$donnees->montant_echange",160,198,'utf-8');
                     
                     //$page->drawText("Montant crédit :",50,640,'utf-8');
                     //$page->drawText("$donnees->montant_credit",150,640,'utf-8');
                     
                     $page->drawText("Type échange            :",50,178,'utf-8');
                     $page->drawText($donnees->type_echange,160,178,'utf-8');
                     $dateop = new Zend_Date($donnees->date_echange,Zend_Date::ISO_8601);
                     
                     $page->drawText("Date règlement          :",50,158,'utf-8');
                     $page->drawText($dateop->toString('dd/mm/yyyy'),160,158, 'utf-8');
                     
                     $page->drawText("Opérateur/Opératrice :",50,138,'utf-8');
                     $page->drawText($donnees->nom_utilisateur."  ".$donnees->prenom_utilisateur,160,138, 'utf-8');
                     
                     $users = new Application_Model_DbTable_EuUtilisateur();
                     $sel = $users->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                     $sel->setIntegrityCheck(false)        
                         ->join('eu_agence', 'eu_agence.code_agence = eu_utilisateur.code_agence')  
                         ->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur); 
                     $data1 = $users->fetchAll($sel);
                     foreach($data1 as $agences)
	                 {
                        $page->drawText("Agence                       :",50,118,'utf-8');
                        $page->drawText($agences->libelle_agence,160,118, 'utf-8');
                     }
                     $page->drawText("Signature de l'opérateur/opératrice",50,78, 'utf-8');
                     $page->drawText('Signature du client',360,78, 'utf-8');     
                }
		
		     //permet de spécifier l'en-tête http
		     header('Content-Type: application/pdf; charset=utf-8');
 
		     //affichage de notre pdf
		     echo $pdf->render();
             $this->view->data = $pdf->render();
                
		     //comme l'action affiche un pdf, nous allons désactiver l'affichage de la vue et du layout
		     //permet de désactiver l'affichage de la vue de l'action list
		  
		     $this->_helper->viewRenderer->setNoRender(true);
                
		     //permet de désactiver l'affichage du layout
		     $this->_helper->layout->disableLayout();
	  }		      
}