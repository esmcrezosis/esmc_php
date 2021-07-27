<?php
class EuHtml2PdfContratController extends Zend_Controller_Action {

        public function listAction() {
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
			      
			if (substr($_POST['membre'],19,1) == 'P')  {
		        $membre = new Application_Model_DbTable_EuMembre();
                $select = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                      ->join('eu_contrat','eu_contrat.code_membre = eu_membre.code_membre', array('eu_membre.*','eu_contrat.*'))
                      ->join('eu_pays','eu_pays.id_pays = eu_membre.id_pays')  
                      ->where('eu_contrat.id_contrat = ?',$_POST['id_contrat']);
                $data = $membre->fetchAll($select);		 
            } else {
			    $membre = new Application_Model_DbTable_EuMembreMorale();
                $select = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                       ->join('eu_contrat','eu_contrat.code_membre = eu_membre_morale.code_membre_morale',array('eu_membre_morale.*','eu_contrat.*'))
                       ->join('eu_pays','eu_pays.id_pays = eu_membre_morale.id_pays')  
                       ->where('eu_contrat.id_contrat = ?',$_POST['id_contrat']);
                $data = $membre->fetchAll($select);		
			}
 
 
			// création du document pdf
		    $pdf = new Default_Pdf_Contrat();
			
			// création d'une nouvelle page au format A4 
			    $entete = new Default_Pdf_Page_Entete(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $entete;
			
			    $currentPage = new Default_Pdf_Page_Contrat(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPage; 
		    
			    $currentPagesuite = new Default_Pdf_Page_Contratsuite(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuite; 
			
			    $currentPagesuitenext = new Default_Pdf_Page_Contratsuitenext(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuitenext;
			  
			    $currentPagesuitenext1 = new Default_Pdf_Page_Contratsuitenext1(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuitenext1;
			 
			    $currentPagesuitenext2 = new Default_Pdf_Page_Contratsuitenext2(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuitenext2;
			 
			    $currentPagesuitenext3 = new Default_Pdf_Page_Contratsuitenext3(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuitenext3;
			
			    $currentPagesuitenext4 = new Default_Pdf_Page_Contratsuitenext4(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuitenext4;
			
			    $currentPagesuitenext5 = new Default_Pdf_Page_Contratsuitenext5(Zend_Pdf_Page::SIZE_A4);
                $pdf->pages[] = $currentPagesuitenext5;
			
                $entete->addContrat();
			    $currentPage->addContrat();
			    $currentPagesuite->addContrat();
			    $currentPagesuitenext->addContrat();
			    $currentPagesuitenext1->addContrat();
			    $currentPagesuitenext2->addContrat();
				$currentPagesuitenext3->addContrat();
				$currentPagesuitenext4->addContrat($contrat);
			
			    foreach($data as $contrat)  {
                   $currentPagesuitenext5->addContrat($contrat);  
			    }
			
			    //permet de spécifier l'en-tête HTTP
		        header('Content-Type: application/pdf; charset=UTF-8');
		        //affichage de notre PDF
		        echo $pdf->render();
                $this->view->data = $pdf->render(); 
		        //comme l'action affiche un PDF, nous allons désactiver l'affichage de la vue et du layout
		        //permet de désactiver l'affichage de la vue de l'action list 
		        $this->_helper->viewRenderer->setNoRender(true);
		        //permet de désactiver l'affichage du layout
		        $this->_helper->layout->disableLayout();
            }
}
