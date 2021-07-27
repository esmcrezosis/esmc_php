<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/ 

 
class EuTableauController extends Zend_Controller_Action {

        public function init() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
	        if ($user->code_groupe == 'tableau_bord') {
                $menu ='<li><a id="sub" href="/eu-tableau/subvention" style="font-size:11px;font-family:Arial Black"><font color=red>SMCIPN</font></a></li>
		            <li><a id="sub" href="/eu-tableau/subasolder" style="font-size:11px;font-family:arial Black"><font color=red>SMCIPN</font> A SOLDER</a></li>
                    <li><a id="sub" href="/eu-tableau/fgfnmoney" style="font-size:11px;font-family:Arial Black">FGFN REMONETISER</a></li>
                    <li><a id="nn" href="/eu-tableau/fgfnnn" style="font-size:11px;font-family:Arial Black">FGFN NN</a></li>
                    <li><a id="electro" href="/eu-tableau/fgfnelectro" style="font-size:11px;font-family:Arial Black">FGFN ELECTRONIQUE</a></li>
                    <li><a id="espece" href="/eu-tableau/fgfnespece" style="font-size:11px;font-family:Arial Black">FGFN ESPECE</a></li>
					<li><a id="sub" href="/eu-tableau/tpsattente" style="font-size:11px;font-family:Arial Black"><font color=black>TPS</font> EN ATTENTE</a></li>
			        <li><a id="global" href="/eu-tableau/fgfn" style="font-size:11px;font-family:Arial Black">FGFN</a></li>
					<li><a id="global" href="/eu-tableau/kacm" style="font-size:11px;font-family:Arial Black">KACM</a></li>
					';
            }
	        $this->view->placeholder("menu")->set($menu);
            $this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
	    }
	  
        function preDispatch() {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            if (!$auth->hasIdentity()) {
              $this->_redirect('login');
            } else {
                  $user = $auth->getIdentity();
                  $group = $user->code_groupe;
                  if ($group != 'tableau_bord') {
                      $this->view->user = $user;
                      return $this->_redirect('index2');
                  }
                  $this->view->user = $user;
            }
        }
	
	
	    public function tpsattenteAction() {
		         $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') {
	            
				$db = Zend_Db_Table::getDefaultAdapter();
                $requete = "select sum( eu_compte.solde) as solde_NB  from eu_compte where eu_compte.code_type_compte like 'NB'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $fgfn = $db->query($requete);
                $result = $fgfn->fetchAll();
                foreach ($result as $row) {
                  $solde_nb = $row->solde_nb;
                }
                if($solde_nb == null) {
                 $solde_nb = 0; 
                } else {
                 $solde_nb = $row->solde_nb;  
                }
				
				$db = Zend_Db_Table::getDefaultAdapter();
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $select = "select sum(solde) as solde_nn from eu_compte where code_type_compte like 'NN' and code_cat <> 'TR' ";
                $donnees = $db->fetchAll($select);
                foreach ($donnees as $row) {
                  $solde_nn = $row->solde_nn;
                }
				
				if($solde_nn == null) {
                   $solde_nn = 0; 
                } else {
                 $solde_nn = $row->solde_nn;  
                }
				
			
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $select1 = "select sum(solde) as solde_nb from eu_compte where code_type_compte like 'NB'";
                $donnees1 = $db->fetchAll($select1);
                foreach ($donnees1 as $row) {
                   $nb = $row->solde_nb;
                }
			
			
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $select2 = "select sum(solde) as solde_nr from eu_compte where code_type_compte like 'NR'";
                $donnees2 = $db->fetchAll($select2);
                foreach ($donnees2 as $row) {
                    $solde_nr = $row->solde_nr;
                }
				
				if($solde_nr == null) {
                   $solde_nr = 0; 
                } else {
                   $solde_nr = $row->solde_nr;  
                }
	            
				$this->view->solde_nb = floor($solde_nb);
				$this->view->solde_nn = floor($solde_nn);
				$this->view->solde_nr = floor($solde_nr);
			//}	
	   
	    }
	
	
	   public function kacmAction() {
	          
		   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
		   
		   $db = Zend_Db_Table::getDefaultAdapter();
           $requete = "select count( eu_membre.code_membre) as count_kacmpp  from eu_membre where etat_membre like 'N'";
           $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $kacm_pp = $db->query($requete);
           $result = $kacm_pp->fetchAll();
           foreach ($result as $row) {
             $count_kacmpp = $row->count_kacmpp;
           }
           if($count_kacmpp == null) {
             $count_kacmpp = 0; 
           } else {
             $count_kacmpp = $row->count_kacmpp;  
           }
		   
		   $solde_kacmpp = ($count_kacmpp*5000);
		   
		   $reqfs = "select sum(eu_smsmoney.creditamount) as solde_fs  from eu_smsmoney where motif like 'FS' and fromACCOUNT <> 'NN-TR' 
		    and destaccount_consumed like 'NB-TFS-%M'";
		   $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $fs_pm = $db->query($reqfs);
           $result = $fs_pm->fetchAll();
           foreach ($result as $row) {
             $solde_fs = $row->solde_fs;
           }
           if($solde_fs == null) {
             $solde_fs = 0; 
           } else {
             $solde_fs = $row->solde_fs;  
           }
		   
		   $reqfl = "select sum(eu_smsmoney.creditamount) as solde_fl  from eu_smsmoney where motif like 'FL' and fromACCOUNT <> 'NN-TR' 
		             and destaccount_consumed like 'FL-%M'";
		   $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $fl_pm = $db->query($reqfl);
           $result = $fl_pm->fetchAll();
           foreach ($result as $row) {
             $solde_fl = $row->solde_fl;
           }
           if($solde_fl == null) {
             $solde_fl = 0; 
           } else {
             $solde_fl = $row->solde_fl;  
           }
		   
		   $reqfkps = "select sum(eu_smsmoney.creditamount) as solde_fkps  from eu_smsmoney where motif like 'FKPS' and fromACCOUNT <> 'NN-TR' 
		               and destaccount_consumed like 'FKPS-%M'";
		   $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $fkps_pm = $db->query($reqfkps);
           $result = $fkps_pm->fetchAll();
           foreach ($result as $row) {
             $solde_fkps = $row->solde_fkps;
           }
		   
           if($solde_fkps == null) {
             $solde_fkps = 0; 
           } else {
             $solde_fkps = $row->solde_fkps;  
           }
		   
		   $this->view->solde_kacm = floor($solde_kacmpp + $solde_fs + $solde_fl + $solde_fkps); 
		   
		   $reqxfs = "select sum(eu_smsmoney.creditamount) as xfs  from eu_smsmoney where motif like 'fs' and fromACCOUNT <> 'NN-TR' 
		              and destaccount_consumed is null";
		   $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $xfs = $db->query($reqxfs);
           $result = $xfs->fetchAll();
           foreach ($result as $row) {
            $xfs = $row->xfs;
           }
		   
           if($xfs == null) {
             $xfs = 0; 
           } else {
             $xfs = $row->xfs;  
           }
		   
		   $reqxfl = "select sum(eu_smsmoney.creditamount) as xfl  from eu_smsmoney where motif like 'FL' and fromACCOUNT <> 'NN-TR' 
		              and destaccount_consumed is null";
		   $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $xfl = $db->query($reqxfl);
           $result = $xfl->fetchAll();
           foreach ($result as $row) {
            $xfl = $row->xfl;
           }
		   
           if($xfl == null) {
             $xfl = 0; 
           } else {
             $xfl = $row->xfl;  
           }
		   
		   $reqxfkps = "select sum(eu_smsmoney.creditamount) as xfkps  from eu_smsmoney where motif like 'fkps' and fromaccount <> 'NN-TR' 
		                and destaccount_consumed is null";
		   $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $xfkps = $db->query($reqxfkps);
           $result = $xfkps->fetchAll();
           foreach ($result as $row) {
            $xfkps = $row->xfkps;
           }
		   
           if($xfkps == null) {
             $xfkps = 0; 
           } else {
             $xfkps = $row->xfkps;  
           }
		   $this->view->x = floor($xfs + $xfl + $xfkps);	  
	   }
	
	
        public function fgfnAction() {
		       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') {
		
            $db = Zend_Db_Table::getDefaultAdapter();
            $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_re  from eu_detail_fgfn where type_fgfn like 'FGFNMRE'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $fgfn = $db->query($requete);
            $result = $fgfn->fetchAll();
            foreach ($result as $row) {
                $solde_re = $row->solde_re;
            }
            if($solde_re == null) {
                $solde_re = 0; 
            } else {
                $solde_re = $row->solde_re;  
            }		
	   
	        $db = Zend_Db_Table::getDefaultAdapter();
            $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_nn  from eu_detail_fgfn where type_fgfn like 'FGFNMNN'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $fgfn = $db->query($requete);
            $result = $fgfn->fetchAll();
            foreach ($result as $row) {
                $solde_nn = $row->solde_nn;
            }
            if($solde_nn == null) {
                $solde_nn = 0; 
            } else {
                $solde_nn = $row->solde_nn;  
            }
			
			$db = Zend_Db_Table::getDefaultAdapter();
            $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_electro  from eu_detail_fgfn where type_fgfn like 'FGFNMEL'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $fgfn = $db->query($requete);
            $result = $fgfn->fetchAll();
            foreach ($result as $row) {
                $solde_electro = $row->solde_electro;
            }
            if($solde_electro == null) {
                $solde_electro = 0; 
            } else {
                $solde_electro = $row->solde_electro;  
            }
			
			$db = Zend_Db_Table::getDefaultAdapter();
            $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_espece  from eu_detail_fgfn where type_fgfn like 'FGFNMES'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $fgfn = $db->query($requete);
            $result = $fgfn->fetchAll();
            foreach ($result as $row) {
                $solde_espece = $row->solde_espece;
            }
            if($solde_espece == null) {
                $solde_espece = 0; 
            } else {
                $solde_espece = $row->solde_espece;  
            }
	        
			$solde_fgfn = $solde_re + $solde_nn + $solde_electro + $solde_espece ;
	   
	        $req = "select sum( eu_gcp_pbf.solde_gcp) as solde_gcppbf  from eu_gcp_pbf";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $gcp = $db->query($req);
            $resultpbf = $gcp->fetchAll();
        
            foreach ($resultpbf as $row) {
               $solde_gcp = $row->solde_gcppbf;
            }
            if($solde_gcp == null) {
               $solde_gcp = 1; 
            } else {
               $solde_gcp = $row->solde_gcppbf;  
            }
			
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $select = "select sum(solde) as solde_nn from eu_compte where code_type_compte like 'NN' and code_cat <> 'TR' and code_cat <> 'CAPA' 
			and code_cat <> 'TMF107' and code_cat <> 'TMF11000' and code_cat <> 'TMFL'";
            $donnees = $db->fetchAll($select);
            foreach ($donnees as $row) {
               $nn = $row->solde_nn;
            }
			
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $select1 = "select sum(solde) as solde_nb from eu_compte where code_type_compte like 'NB'";
            $donnees1 = $db->fetchAll($select1);
            foreach ($donnees1 as $row) {
               $nb = $row->solde_nb;
            }
			
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $select2 = "select sum(solde) as solde_nr from eu_compte where code_type_compte like 'NR'";
            $donnees2 = $db->fetchAll($select2);
            foreach ($donnees2 as $row) {
               $nr = $row->solde_nr;
            }
			
			
			$db = Zend_Db_Table::getDefaultAdapter();
            $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgfn  from eu_detail_fgfn where type_fgfn like 'FGFNMES'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $fgfn = $db->query($requete);
            $result = $fgfn->fetchAll();
            foreach ($result as $row) {
              $solde_fgfn = $row->solde_fgfn;
            }
            if($solde_fgfn == null) {
               $solde_fgfn = 0; 
            } else {
               $solde_fgfn = $row->solde_fgfn;  
            }
    
    
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $select1 = "select * from  eu_heterogene where code_hetero like 'omega'";
            $donnees1 = $db->fetchAll($select1);
            foreach ($donnees1 as $row) {
               $omega = $row->solde;
            }
      
            $selection = "select * from  eu_heterogene where code_hetero like 'omegaprim'";
            $don = $db->fetchAll($selection);
            foreach ($don as $row) {
               $omegaprim = $row->solde;
            }
			
			$i = $nn + $nb + $nr;
			$this->view->passif = $i;
			if(abs($solde_fgfn - $omega) > 0) {
	           $this->view->deficit = floor($i/abs($solde_fgfn - $omega));
            } else { 
               $this->view->deficit = 0 ;  
            }
           
            if(abs($solde_fgfn + $omegaprim) > 0) {
	          $this->view->excedent = $i/abs($solde_fgfn + $omegaprim);
            } else {
              $this->view->excedent = 0;  
            }
	        $this->view->solde_fgfn = floor($solde_re + $solde_nn + $solde_electro + $solde_espece) ;
			$this->view->x = floor($solde_fgfn / $solde_gcp);
			//}
		}
	
       
        public function indexAction() {
        
		
        }
	
       
        public function subventionAction() {
		       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	            $code_acteur = $user->code_acteur;   
	            $tabela = new Application_Model_DbTable_EuActeur();
                $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	            $alloc = $tabela->fetchAll($select);
	            $row = $alloc->current();
			    $code_activite = $row->code_activite;
			    $code_agence = $row->code_agence;
			   
			    //if($code_activite == 'source') {
			   
                $db = Zend_Db_Table::getDefaultAdapter();
                $requete = "select sum( eu_gcp.mont_gcp) as solde  from eu_gcp,eu_membre_morale where eu_gcp.code_membre = eu_membre_morale.code_membre_morale ";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $cr = $db->query($requete);
                $result = $cr->fetchAll();
                foreach ($result as $row) {
                    $solde_gcnrb = $row->solde;
                }
                if($solde_gcnrb == null) {
                    $solde_gcnrb = 0; 
                } else {
                    $solde_gcnrb = $row->solde;  
                }  
   
                $reqfn = "select sum(eu_smcipnpwi.investis_alloue) as solde_fn  from eu_smcipnpwi,eu_appel_offre where
		        eu_smcipnpwi.numero_appel = eu_appel_offre.numero_offre and
		        eu_appel_offre.type_appel_offre <> 'ass'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $fn = $db->query($reqfn);
                $resultfn = $fn->fetchAll();
                foreach ($resultfn as $row) {
                  $solde_fn = $row->solde_fn;
                }
                if($solde_fn == null) {
                  $solde_fn = 0; 
                } else {
                  $solde_fn = $row->solde_fn;  
                }
   
                $reqsmc = "select sum(eu_smcipnpwi.salaire_alloue) as solde_smc  from eu_smcipnpwi,eu_appel_offre where
		        eu_smcipnpwi.numero_appel = eu_appel_offre.numero_offre and
		        eu_appel_offre.type_appel_offre <> 'ass'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $smc = $db->query($reqsmc);
                $resultsmc = $smc->fetchAll();
                foreach ($resultsmc as $row) {
                   $solde_smc = $row->solde_smc;
                }
                if($solde_smc == null) {
                   $solde_smc = 0; 
                } else {
                   $solde_smc = $row->solde_smc;  
                }
				
				$reqhete ="select montant_utilise as montant from eu_heterogene where code_hetero like 'alpha'";
				$db->setFetchMode(Zend_Db::FETCH_OBJ);
                $hete = $db->query($reqhete);
                $resulthete = $hete->fetchAll();
                foreach ($resulthete as $row) {
                   $montant = $row->montant;
                }
				
				$reqheteprim ="select montant_utilise as montantprim from eu_heterogene where code_hetero like 'alphaprim'";
				$db->setFetchMode(Zend_Db::FETCH_OBJ);
                $heteprim = $db->query($reqheteprim);
                $resultheteprim = $heteprim->fetchAll();
                foreach ($resultheteprim as $row) {
                   $montantprim = $row->montantprim;
                }
				
                $solde_gcnrr = floor($solde_fn + $solde_smc);
                $this->view->solde_gcnrr  = floor($solde_gcnrr); 
                $this->view->solde_gcnrb  = floor($solde_gcnrb);
                if($solde_gcnrb - $solde_gcnrr > 0) {
                   $this->view->deficit = floor(abs($solde_gcnrb - $solde_gcnrr)) ;
                   $db = Zend_Db_Table::getDefaultAdapter();
                   $alpha = floor(abs($solde_gcnrb - $solde_gcnrr)) ;
                   $select = "update eu_heterogene set montant = $alpha , solde = $alpha - $montant  where code_hetero like 'alpha'";
                   $db->query($select);
                   $select = "update eu_heterogene set montant = 0 , solde = 0  where code_hetero like 'alphaprim'";
                   $db->query($select);
                   $this->view->excedent = 0;
      
                } elseif($solde_gcnrb - $solde_gcnrr < 0) { 
                   $this->view->excedent = floor(abs($solde_gcnrr - $solde_gcnrb)) ;
                   $db = Zend_Db_Table::getDefaultAdapter();
                   $alpha = floor(abs($solde_gcnrr - $solde_gcnrb)) ;
                   $select = "update eu_heterogene set montant = $alpha , solde = $alpha - $montantprim  where code_hetero like 'alphaprim'";
                   $db->query($select);
                   $select = "update eu_heterogene set montant = 0 , solde = 0  where code_hetero like 'alpha'";
                   $db->query($select);
                   $this->view->deficit = 0;
         
                } elseif($solde_gcnrb - $solde_gcnrr == 0) { 
                   $this->view->equilibre = $solde_gcnrr - $solde_gcnrb ;
                   $db = Zend_Db_Table::getDefaultAdapter();
                   $alpha = $solde_gcnrr - $solde_gcnrb ;
                   $select = "update eu_heterogene set montant = $alpha , solde = $alpha - $montantprim  where code_hetero like 'alphaprim'";
                   $db->query($select);
                   $select = "update eu_heterogene set montant = 0 , solde = 0  where code_hetero like 'alpha'";
                   $db->query($select);
                   $this->view->deficit = 0;
                   $this->view->excedent = 0;
                }
				
				//}
								 
                
}


    public function fgfnmoneyAction() {
	
	   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') {
       
      $db = Zend_Db_Table::getDefaultAdapter();
      $requete = "select sum( eu_gcsc.solde) as solde_FGFN  from eu_gcsc,eu_membre_morale,eu_acteur 
	  where eu_membre_morale.code_membre_morale = eu_gcsc.code_membre and eu_membre_morale.code_membre_morale = eu_acteur.code_membre
	  and eu_acteur.type_acteur like 'kr' and eu_acteur.code_activite like 'acnev'";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $fgfn = $db->query($requete);
      $result = $fgfn->fetchAll();
      foreach ($result as $row) {
        $solde_fgfn = $row->solde_fgfn;
      }
      if($solde_fgfn == null) {
          $solde_fgfn = 0; 
      } else {
          $solde_fgfn = $row->solde_fgfn;  
      } 
      $this->view->solde_fgfn  = $solde_fgfn;
      
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $select1 = "select * from eu_heterogene where code_hetero like 'alpha'";
      $donnees1 = $db->fetchAll($select1);
      foreach ($donnees1 as $row1) {
        $alpha = $row1->solde;
      }
      
      $select2 = "select * from eu_heterogene where code_hetero like 'alphaprim'";
      $donnees2 = $db->fetchAll($select2);
      foreach ($donnees2 as $row2) {
        $alphaprim = $row2->solde;
      }
      
      $select3 = "select * from eu_heterogene where code_hetero like 'fi'";
      $donnees3 = $db->fetchAll($select3);
      foreach ($donnees3 as $row3) {
         $fi = $row3->solde;
      }
      
      $select4 = "select * from eu_heterogene where code_hetero like 'fiprim'";
      $donnees4 = $db->fetchAll($select4);
      foreach ($donnees4 as $row4) {
        $fiprim = $row4->solde;
      }
      if(($solde_fgfn - $fi - $alpha) < 0)  {
	        $db = Zend_Db_Table::getDefaultAdapter();
            $beta = floor(abs($solde_fgfn - $fi - $alpha));
            $select = "update eu_heterogene set montant = $beta ,solde = $beta - montant_utilise  where code_hetero like 'beta'";
            $db->query($select);
		    $this->view->deficit = abs($solde_fgfn - $fi - $alpha);
		  
		        //$db = Zend_Db_Table::getDefaultAdapter();
                //$select = "update eu_parametres set montant = 0  where code_param like 'betaprim'";
                //$db->query($select);
		        //$this->view->excedent = 0 ;
	  
	    } if(($solde_fgfn + $fiprim + $alphaprim) > 0) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $betaprim = floor($solde_fgfn + $fiprim + $alphaprim);
                $select = "update eu_heterogene set montant = $betaprim,solde = $betaprim - montant_UTILISE  where code_hetero like 'betaprim'";
                $db->query($select);
		        $this->view->excedent = floor(abs($solde_fgfn + $fiprim + $alphaprim));
				
				//$db = Zend_Db_Table::getDefaultAdapter();
                //$select = "update eu_parametres set montant = 0  where code_param like 'beta'";
                //$db->query($select);
		        //$this->view->deficit = 0;

	    }
       
      //}
      //$this->view->equilibre = $solde_fgfn + $fiprim + $alphaprim;
             
 }


 
 public function fgfnnnAction() {
 
 
     $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') { 
    $db = Zend_Db_Table::getDefaultAdapter();
    $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgfn  from eu_detail_fgfn where type_fgfn like 'NN'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $fgfn = $db->query($requete);
    $result = $fgfn->fetchAll();
    foreach ($result as $row) {
         $solde_fgfn = $row->solde_fgfn;
    }
    if($solde_fgfn == null) {
          $solde_fgfn = 0; 
    } else {
          $solde_fgfn = $row->solde_fgfn;  
    }
      
	$db = Zend_Db_Table::getDefaultAdapter();
    $reqfgcncs = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgnncncs  from eu_detail_fgfn where origine_fgfn like 'TCNCS'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $fgfn = $db->query($reqfgcncs);
    $result = $fgfn->fetchAll();
    foreach ($result as $row) {
         $solde_fgnncncs = $row->solde_fgnncncs;
    }
    if($solde_fgnncncs == null) {
          $solde_fgnncncs = 0; 
    } else {
          $solde_fgnncncs = $row->solde_fgnncncs;  
    }
	  
	$db = Zend_Db_Table::getDefaultAdapter();
    $reqfgi = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgnni  from eu_detail_fgfn where origine_fgfn like 'TPAGCI'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $fgfn = $db->query($reqfgi);
    $result = $fgfn->fetchAll();
    foreach ($result as $row) {
         $solde_fgnni = $row->solde_fgnni;
    }
    if($solde_fgnni == null) {
          $solde_fgnni = 0; 
    } else {
          $solde_fgnni = $row->solde_fgnni;  
    }
	  
	  
	  $db = Zend_Db_Table::getDefaultAdapter();
      $reqfggcp = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgnngcp  from eu_detail_fgfn where origine_fgfn like 'TPAGCP'";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $fgfn = $db->query($reqfggcp);
      $result = $fgfn->fetchAll();
      foreach ($result as $row) {
         $solde_fgnngcp = $row->solde_fgnngcp;
      }
      if($solde_fgnngcp == null) {
          $solde_fgnngcp = 0; 
      } else {
          $solde_fgnngcp = $row->solde_fgnngcp;  
      }
	  
      
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $select1 = "select * from  eu_heterogene where code_hetero like 'beta'";
      $donnees1 = $db->fetchAll($select1);
      foreach ($donnees1 as $row) {
        $beta = $row->solde;
      }
      
      $select2 = "select * from  eu_heterogene where code_hetero like 'betaprim'";
      $donnees2 = $db->fetchAll($select2);
      foreach ($donnees2 as $row) {
        $betaprim = $row->solde;
      }
      
	  
	    if(($solde_fgfn - $beta) < 0) {
           $this->view->deficit = floor(abs($solde_fgfn - $beta));
		   $db = Zend_Db_Table::getDefaultAdapter();
           $landa = floor(abs($solde_fgfn - $beta));
           $select = "update eu_heterogene set montant = $landa , solde = $landa - montant_UTILISE  where code_hetero like 'landa'";
           $db->query($select);
		   
		   //$db = Zend_Db_Table::getDefaultAdapter();
           //$select = "update eu_parametres set montant = 0  where code_param like 'landaprim'";
           //$db->query($select);
		   //$this->view->excedent = 0;
	  
	    }
		
		if(($solde_fgfn + $betaprim) > 0) {
		   $this->view->excedent = floor($solde_fgfn + $betaprim);
           $db = Zend_Db_Table::getDefaultAdapter();
           $landaprim = floor($solde_fgfn + $betaprim) ;
           $select = "update eu_heterogene set montant = $landaprim, solde = $landaprim - montant_UTILISE  where code_hetero like 'landaprim'";
           $db->query($select);
		   
		   //$db = Zend_Db_Table::getDefaultAdapter();
           //$select = "update eu_parametres set montant = 0  where code_param like 'landa'";
           //$db->query($select);
		   //$this->view->deficit = 0;
		
		}
      
        $this->view->solde_fgfn  = floor($solde_fgfn);
	    $this->view->solde_fgnni  = floor($solde_fgnni);
	    $this->view->solde_fgnngcp  = floor($solde_fgnngcp);
	    $this->view->solde_fgnncncs  = floor($solde_fgnncncs);
		
		//}
          
 }

 
 
 public function fgfnelectroAction() {
     
	     $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') {
	 
        $db = Zend_Db_Table::getDefaultAdapter();
        $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgfn  from eu_detail_fgfn  where  type_fgfn  like  'FGFNMEL'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $fgfn = $db->query($requete);
        $result = $fgfn->fetchAll();
        foreach ($result as $row) {
            $solde_fgfn = $row->solde_fgfn;
        }
        if($solde_fgfn == null) {
          $solde_fgfn = 0; 
        } else {
          $solde_fgfn = $row->solde_fgfn;  
        } 
        
        $req = "select sum( eu_gcp_pbf.solde_gcp) as solde_gcpPBF  from eu_gcp_pbf";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $gcp = $db->query($req);
        $resultpbf = $gcp->fetchAll();
        
        foreach ($resultpbf as $row) {
            $solde_gcp = $row->solde_gcppbf;
        }
        if($solde_gcp == null) {
          $solde_gcp = 0; 
        } else {
          $solde_gcp = $row->solde_gcppbf;  
        }
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select1 = "select * from  eu_heterogene where code_hetero like 'landa'";
        $donnees1 = $db->fetchAll($select1);
        foreach ($donnees1 as $row) {
           $landa = $row->solde;
        }
      
        $select2 = "select * from  eu_heterogene where code_hetero like 'landaprim'";
        $donnees2 = $db->fetchAll($select2);
        foreach ($donnees2 as $row) {
          $landaprim = $row->solde;
        }
        
		if(($solde_fgfn - $solde_gcp - $landa) < 0) {
            $omega = floor(abs($solde_fgfn - $solde_gcp - $landa));
            $this->view->deficit = $omega;
            $db = Zend_Db_Table::getDefaultAdapter();
            $select = "update eu_heterogene set montant = $omega,solde=$omega - montant_UTILISE  where code_hetero like 'omega'";
            $db->query($select);
            
            //$db = Zend_Db_Table::getDefaultAdapter();
            //$select = "update eu_parametres set montant = 0  where code_param like 'omegaprim'";
            //$db->query($select);
            //$this->view->excedent = 0;			

        }  
		if(($solde_fgfn - $solde_gcp + $landaprim) > 0) {
		    $omegaprim = floor(abs($solde_fgfn - $solde_gcp + $landaprim));
            $this->view->excedent = $omegaprim;
			$db = Zend_Db_Table::getDefaultAdapter();
            $select = "update eu_heterogene set montant = $omegaprim,solde=$omegaprim - montant_UTILISE  where code_hetero like 'omegaprim'";
            $db->query($select);

            //$db = Zend_Db_Table::getDefaultAdapter();
            //$select = "update eu_parametres set montant = 0  where code_param like 'omega'";
            //$db->query($select);
            //$this->view->deficit = 0;
        }		
         
        $this->view->solde_fgfn  = floor($solde_fgfn);
        $this->view->solde_gcp  = floor($solde_gcp);
		
		//}
    
 }
 
 
 
 
 public function fgfnespeceAction() {
 
     $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') {
 
    $db = Zend_Db_Table::getDefaultAdapter();
    $requete = "select sum( eu_detail_fgfn.mont_fgfn) as solde_fgfn  from eu_detail_fgfn where type_fgfn like 'fgfnmes'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $fgfn = $db->query($requete);
    $result = $fgfn->fetchAll();
    foreach ($result as $row) {
         $solde_fgfn = $row->solde_fgfn;
    }
    if($solde_fgfn == null) {
          $solde_fgfn = 0; 
    } else {
          $solde_fgfn = $row->solde_fgfn;  
    }
    
    
    $db = Zend_Db_Table::getDefaultAdapter();
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $select1 = "select * from  eu_heterogene where code_hetero like 'omega'";
    $donnees1 = $db->fetchAll($select1);
    foreach ($donnees1 as $row) {
      $omega = $row->solde;
    }
      
    $select2 = "select * from  eu_heterogene where code_hetero like 'omegaprim'";
    $donnees2 = $db->fetchAll($select2);
    foreach ($donnees2 as $row) {
      $omegaprim = $row->solde;
    }
        
    $def = floor(abs($solde_fgfn - $omega));  
    $this->view->deficit = $def; 
        
    $omegaprim = floor($solde_fgfn + $omegaprim);
    $this->view->excedent = $omegaprim;
    
    $this->view->solde_fgfn  = floor($solde_fgfn); 
	
	//}
    
 }
 

 
 

 public function subasolderAction()  {
 
         $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	  
	           $code_acteur = $user->code_acteur;   
	           $tabela = new Application_Model_DbTable_EuActeur();
               $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $select->setIntegrityCheck(false)
		              ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			          ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	           $alloc = $tabela->fetchAll($select);
	           $row = $alloc->current();
			   $code_activite = $row->code_activite;
			   $code_agence = $row->code_agence;
			   
			   //if($code_activite == 'source') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $req = "select sum( eu_cnnc.solde) as solde_CNNC  from eu_cnnc";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $cnnc = $db->query($req);
        $resultcnnc = $cnnc->fetchAll();
        foreach ($resultcnnc as $row) {
          $solde_cnnc = $row->solde_cnnc;
        }
        if($solde_cnnc == null) {
            $solde_cnnc = 0; 
        } else {
            $solde_cnnc = $row->solde_cnnc;  
        }
        
        $reqfn = "select sum(eu_smcipnpwi.investis_alloue) as solde_fn  from eu_smcipnpwi,eu_appel_offre where
		eu_smcipnpwi.numero_appel = eu_appel_offre.numero_offre and
		eu_appel_offre.type_appel_offre like 'ass'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $fn = $db->query($reqfn);
        $resultfn = $fn->fetchAll();
        foreach ($resultfn as $row) {
          $solde_fn = $row->solde_fn;
        }
        if($solde_fn == null) {
          $solde_fn = 0; 
        } else {
          $solde_fn = $row->solde_fn;  
        }    
    
        $reqsmc = "select sum(eu_smcipnpwi.salaire_alloue) as solde_smc  from eu_smcipnpwi,eu_appel_offre where
		eu_smcipnpwi.numero_appel = eu_appel_offre.numero_offre and
		eu_appel_offre.type_appel_offre like 'ass'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $smc = $db->query($reqsmc);
        $resultsmc = $smc->fetchAll();
        foreach ($resultsmc as $row) {
             $solde_smc = $row->solde_smc;
        }
        if($solde_smc == null) {
         $solde_smc = 0; 
        } else {
         $solde_smc = $row->solde_smc;  
        }
         
		 $reqhete ="select montant_utilise as montant from eu_heterogene where code_hetero like 'fi'";
				$db->setFetchMode(Zend_Db::FETCH_OBJ);
                $hete = $db->query($reqhete);
                $resulthete = $hete->fetchAll();
                foreach ($resulthete as $row) {
                   $montant = $row->montant;
                }
				
				$reqheteprim ="select montant_utilise as montantprim from eu_heterogene where code_hetero like 'fiprim'";
				$db->setFetchMode(Zend_Db::FETCH_OBJ);
                $heteprim = $db->query($reqheteprim);
                $resultheteprim = $heteprim->fetchAll();
                foreach ($resultheteprim as $row) {
                   $montantprim = $row->montantprim;
                }
		 
		 
        $solde_gcnrr =  $solde_fn + $solde_smc;
   
        if($solde_cnnc - $solde_gcnrr < 0) { 
           $this->view->deficit = floor(abs($solde_gcnrr - $solde_cnnc));
           $db = Zend_Db_Table::getDefaultAdapter();
           $fi = floor(abs($solde_cnnc - $solde_gcnrr)) ;
           $select = "update eu_heterogene set montant = $fi,solde = $fi-$montant  where code_hetero like 'fi'";
           $db->query($select);
           $select = "update eu_heterogene set montant = 0, solde = 0  where code_hetero like 'fiprim'";
           $db->query($select);
           $this->view->excedent = 0;
        } elseif($solde_cnnc - $solde_gcnrr > 0) { 
           $this->view->excedent = floor(abs($solde_cnnc - $solde_gcnrr)) ;
           $db = Zend_Db_Table::getDefaultAdapter();
           $fi = floor(abs($solde_gcnrr - $solde_cnnc));
           $select = "update eu_heterogene set montant = $fi,solde = $fi-$montantprim  where code_hetero like 'fiprim'";
           $db->query($select);
           $select = "update eu_heterogene set montant = 0 , solde = 0  where code_hetero like 'fi'";
           $db->query($select);
           $this->view->deficit = 0;
        } elseif($solde_cnnc - $solde_gcnrr == 0) {
           $this->view->equilibre = $solde_gcnrr - $solde_cnnc ;
           $db = Zend_Db_Table::getDefaultAdapter();
           $select = "update eu_heterogene set montant = 0,solde=0  where code_hetero like 'fi'";
           $db->query($select);
           $selectprim = "update eu_heterogene set montant = 0,solde=0 where code_hetero like 'fiprim'";
           $db->query($selectprim);
           $this->view->deficit = 0;
           $this->view->excedent = 0;
        }        
           $this->view->solde_cnnc  = floor($solde_cnnc);
           $this->view->solde_gcnrr  = floor($solde_gcnrr); 
		   
		}   
           
     //}
}