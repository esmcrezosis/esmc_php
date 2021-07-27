<?php

class EuUserController extends Zend_Controller_Action {

    public function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = trim($user->code_groupe);
		
		    $table3 = new Application_Model_DbTable_EuUserGroup();
			$select3 = $table3->select();
			$select3->where("code_groupe = ? ", $group);
			$Rows3 = $table3->fetchAll($select3);
				
            if (count($Rows3) == 0 ) {
				
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->view->user = $user;
        $group = trim($user->code_groupe);
		$menu = "";
		
		/*
		$table3 = new Application_Model_DbTable_EuUserGroup();
		$select3 = $table3->select();
		$select3->where("code_groupe = ? ", $group);
		$Rows3 = $table3->fetchAll($select3);
		*/		
		//if (count($Rows3) > 0 ) {
			//$pos1 = stripos($_SERVER['REQUEST_URI'], "mpp2");
			//$pos2 = stripos($_SERVER['REQUEST_URI'], "mpm2");
			//$pos3 = stripos($_SERVER['REQUEST_URI'], "tdbfs2");
			//$pos4 = stripos($_SERVER['REQUEST_URI'], "tdbfl2");
			//$pos5 = stripos($_SERVER['REQUEST_URI'], "tdbfcps2");
		    $menu = "";
			if ($group == "cm") {
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpp2/etat/A">Tdb des Anciens MPP enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpp2/etat/N">Tdb des Nouveaux MPP enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfs2">Tdb des FS utilisés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfl2">Tdb des FL utilisés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfcps2">Tdb des FCPS commandés</a></li>';
		} else if ($group == "detentrice" || $group == "surveillance") {
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpp2/etat/A">Tdb des Anciens MPP enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpp2/etat/N">Tdb des Nouveaux MPP enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpm2/etat/A">Tdb des Anciens MPM enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpm2/etat/N">Tdb des Nouveaux MPM enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfs2">Tdb des FS utilisés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfl2">Tdb des FL utilisés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfcps2">Tdb des FCPS commandés</a></li>';
		} else {
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpm2/etat/A">Tdb des Anciens MPM enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/mpm2/etat/N">Tdb des Nouveaux MPM enrôlés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfs2">Tdb des FS utilisés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfl2">Tdb des FL utilisés</a></li>';
            $menu .= '<li><a style="font-size:11px" href=" /eu-user/tdbfcps2">Tdb des FCPS commandés</a></li>';
		}
			
		$pos1 = stripos($_SERVER['REQUEST_URI'], "transfert2");
		$pos2 = stripos($_SERVER['REQUEST_URI'], "echange2");
		$pos3 = stripos($_SERVER['REQUEST_URI'], "debitcredit2");
			
			if ($pos1 !== false) {
			   $id_cm_utilisateur = 1;
			} else if ($pos2 !== false) {
			   $id_cm_utilisateur = 2;
			} else if ($pos3 !== false) {
			   $id_cm_utilisateur = 3;
			} else {
			   $id_cm_utilisateur = 0;
		    }
            $this->view->id_cm_utilisateur = $id_cm_utilisateur;
			if($id_cm_utilisateur > 0) {
            $menu = "";
			
		    $table1 = new Application_Model_DbTable_EuUtilisateur();
            $select1 = $table1->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select1->setIntegrityCheck(false);
		    $select1->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
            $select1->where('eu_utilisateur.id_utilisateur_parent = ?', $user->id_utilisateur);
            //$select1->where('eu_user_group.id_cm_utilisateur <= ?', 3);
			$select1->where('eu_user_group.id_cm_utilisateur = ?', $id_cm_utilisateur);
            $select1->order('eu_user_group.id_cm_utilisateur asc', 'eu_utilisateur.id_utilisateur asc');
            $Rows1 = $table1->fetchAll($select1);

		    if(count($Rows1) > 0) {	
		        $cm = "";$y = 0;
		        foreach ($Rows1 as $row1) {
		
			    if($cm != $row1->id_cm_utilisateur) {
				if($cm != "") {
				    //$menu .= '</ul></li>';
				}
				$cm = $row1->id_cm_utilisateur;
					$cm_user = new Application_Model_DbTable_EuCmUtilisateur();
					$select_cm = $cm_user->select();
					$select_cm->where('id_cm_utilisateur = ?', $row1->id_cm_utilisateur);
					$rows_cm = $cm_user->fetchRow($select_cm);
		            //$menu .= '<li><a href="#" class="menuLink" style="font-size:11px">'.($rows_cm->libelle_cm_utilisateur).'</a>
				    //		<ul style="z-index:1000000;background-color:#d7ebf9;">';
		        $menu .= '<a style="font-size:13px">'.($rows_cm->libelle_cm_utilisateur).'</a>
';
			    }
		
				$table2 = new Application_Model_DbTable_EuUtilisateur();
				$select2 = $table2->select();
				//$select2 = $table2->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				//$select2->setIntegrityCheck(false);
				//$select2->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
				//$select2->where('eu_utilisateur.id_utilisateur_parent = ?', $row1->id_utilisateur);
				$select2->where('id_utilisateur_parent = ?', $row1->id_utilisateur);
				$select2->order('id_utilisateur asc');
				$Rows2 = $table2->fetchAll($select2);
				
				$tab2 = new Application_Model_DbTable_EuUserGroup();
				$sel2 = $tab2->select();
				$sel2->where('code_groupe_parent = ?', $row1->code_groupe);
				$group2 = $tab2->fetchAll($sel2);
					
				   $grp1 = new Application_Model_DbTable_EuUserGroup();
					$select_grp1 = $grp1->select();
					$select_grp1->where('code_groupe = ?', $row1->code_groupe);
					$rows_grp1 = $grp1->fetchRow($select_grp1);

					   if(count($Rows2) > 0 || count($group2) > 0) {
				   $menu .= '
            <li><a style="font-size:11px" href="#" class="menuLink">'.($rows_grp1->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
		
				   foreach ($Rows2 as $row2) {
        $table3 = new Application_Model_DbTable_EuUtilisateur();
		$select3 = $table3->select();
        //$select3 = $table3->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        //$select3->setIntegrityCheck(false);
        //$select3->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select3->where('id_utilisateur_parent = ?',$row2->id_utilisateur);
        $select3->order('id_utilisateur asc');
        $Rows3 = $table3->fetchAll($select3);
				
				$tab3 = new Application_Model_DbTable_EuUserGroup();
				$sel3 = $tab3->select();
				$sel3->where('code_groupe_parent = ?', $row2->code_groupe);
				$group3 = $tab3->fetchAll($sel3);
					
				   $grp2 = new Application_Model_DbTable_EuUserGroup();
					$select_grp2 = $grp2->select();
					$select_grp2->where('code_groupe = ?', $row2->code_groupe);
					$rows_grp2 = $grp2->fetchRow($select_grp2);

			   if(count($Rows3) > 0 || count($group3) > 0) {
				   $menu .= '
            <li><a style="font-size:11px;" href="#" class="menuLink">'.($rows_grp2->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';

				   foreach ($Rows3 as $row3) {
        $table4 = new Application_Model_DbTable_EuUtilisateur();
		$select4 = $table4->select();
        //$select4 = $table4->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        //$select4->setIntegrityCheck(false);
        //$select4->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select4->where('id_utilisateur_parent = ?',$row3->id_utilisateur);
        $select4->order('id_utilisateur asc');
        $Rows4 = $table4->fetchAll($select4);
				
				$tab4 = new Application_Model_DbTable_EuUserGroup();
				$sel4 = $tab4->select();
				$sel4->where('code_groupe_parent = ?', $row3->code_groupe);
				$group4 = $tab4->fetchAll($sel4);
					
				   $grp3 = new Application_Model_DbTable_EuUserGroup();
					$select_grp3 = $grp3->select();
					$select_grp3->where('code_groupe = ?', $row3->code_groupe);
					$rows_grp3 = $grp3->fetchRow($select_grp3);

			   if(count($Rows4) > 0 || count($group4) > 0) {
				   $menu .= '
            <li><a style="font-size:11px" href="#" class="menuLink">'.($rows_grp3->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				   foreach ($Rows4 as $row4) {
				   
		}
					
		$menu .= " </ul></li>";
						}else{
						if($rows_grp3->id_cm_utilisateur == 1){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/transfert2/ssgrp/'.$row3->code_groupe.' ">'.($rows_grp3->libelle_groupe).'</a></li>';
						}else if($rows_grp3->id_cm_utilisateur == 2){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/echange2/ssgrp/'.$row3->code_groupe.' ">'.($rows_grp3->libelle_groupe).'</a></li>';
						}else if($rows_grp3->id_cm_utilisateur == 3){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/debitcredit2/ssgrp/'.$row3->code_groupe.' ">'.($rows_grp3->libelle_groupe).'</a></li>';
						}
						}
		}
		
		$menu .= " </ul></li>";
						}else{
						if($rows_grp2->id_cm_utilisateur == 1){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/transfert2/ssgrp/'.$row2->code_groupe.' ">'.($rows_grp2->libelle_groupe).'</a></li>';
						}else if($rows_grp2->id_cm_utilisateur == 2){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/echange2/ssgrp/'.$row2->code_groupe.' ">'.($rows_grp2->libelle_groupe).'</a></li>';
						}else if($rows_grp2->id_cm_utilisateur == 3){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/debitcredit2/ssgrp/'.$row2->code_groupe.' ">'.($rows_grp2->libelle_groupe).'</a></li>';
						}
						}
		}
		
		$menu .= " </ul></li>";
						}else{
						if($rows_grp1->id_cm_utilisateur == 1){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/transfert2/ssgrp/'.$row1->code_groupe.' ">'.($rows_grp1->libelle_groupe).'</a></li>';
						}else if($rows_grp1->id_cm_utilisateur == 2){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/echange2/ssgrp/'.$row1->code_groupe.' ">'.($rows_grp1->libelle_groupe).'</a></li>';
						}else if($rows_grp1->id_cm_utilisateur == 3){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/debitcredit2/ssgrp/'.$row1->code_groupe.' ">'.($rows_grp1->libelle_groupe).'</a></li>';
						}
					}
		}
		//$menu .= " </ul></li>";
		}

		
        //}
}



			
			$pos1 = stripos($_SERVER['REQUEST_URI'], "transfert3");
			$pos2 = stripos($_SERVER['REQUEST_URI'], "echange3");
			$pos3 = stripos($_SERVER['REQUEST_URI'], "debitcredit3");
			
			if ($pos1 !== false) {
				$id_cm_utilisateur = 1;
			}else if ($pos2 !== false) {
				$id_cm_utilisateur = 2;
			}else if ($pos3 !== false) {
				$id_cm_utilisateur = 3;
			}else{
				$id_cm_utilisateur = 0;
				}
				
//$this->view->id_cm_utilisateur = $id_cm_utilisateur;
			if($id_cm_utilisateur > 0){
				
					$user10 = new Application_Model_DbTable_EuUtilisateur();
					$select10 = $user10->select();
					$select10->where('eu_utilisateur.code_groupe_create = ?', "surveillance");
					$select10->where('eu_utilisateur.code_groupe = ?', "surveillance");
					$rows10 = $user10->fetchRow($select10);
				
				
            $menu = "";
			
		    $table1 = new Application_Model_DbTable_EuUtilisateur();
            $select1 = $table1->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select1->setIntegrityCheck(false);
		    $select1->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
            $select1->where('eu_utilisateur.id_utilisateur_parent = ?', $rows10->id_utilisateur);
            $select1->where('eu_user_group.id_cm_utilisateur <= ?', 3);
			$select1->where('eu_user_group.id_cm_utilisateur = ?', $id_cm_utilisateur);
            $select1->order('eu_user_group.id_cm_utilisateur asc', 'eu_utilisateur.id_utilisateur asc');
            $Rows1 = $table1->fetchAll($select1);

		    if(count($Rows1) > 0) {	
		      $cm = "";$y = 0;
		      foreach ($Rows1 as $row1) {
		
			  if($cm != $row1->id_cm_utilisateur) {
				if($cm != "") {
					//$menu .= '</ul></li>';
				}
				$cm = $row1->id_cm_utilisateur;
					$cm_user = new Application_Model_DbTable_EuCmUtilisateur();
					$select_cm = $cm_user->select();
					$select_cm->where('id_cm_utilisateur = ?', $row1->id_cm_utilisateur);
					$rows_cm = $cm_user->fetchRow($select_cm);
		        //$menu .= '<li><a href="#" class="menuLink" style="font-size:11px">'.($rows_cm->libelle_cm_utilisateur).'</a>
				//		<ul style="z-index:1000000;background-color:#d7ebf9;">';
		        $menu .= '<a style="font-size:13px">'.($rows_cm->libelle_cm_utilisateur).'</a>
';
			    }
		
				$table2 = new Application_Model_DbTable_EuUtilisateur();
				$select2 = $table2->select();
				//$select2 = $table2->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				//$select2->setIntegrityCheck(false);
				//$select2->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
				//$select2->where('eu_utilisateur.id_utilisateur_parent = ?', $row1->id_utilisateur);
				$select2->where('id_utilisateur_parent = ?', $row1->id_utilisateur);
				$select2->order('id_utilisateur asc');
				$Rows2 = $table2->fetchAll($select2);
				
				$tab2 = new Application_Model_DbTable_EuUserGroup();
				$sel2 = $tab2->select();
				$sel2->where('code_groupe_parent = ?', $row1->code_groupe);
				$group2 = $tab2->fetchAll($sel2);
					
				   $grp1 = new Application_Model_DbTable_EuUserGroup();
					$select_grp1 = $grp1->select();
					$select_grp1->where('code_groupe = ?', $row1->code_groupe);
					$rows_grp1 = $grp1->fetchRow($select_grp1);

					   if(count($Rows2) > 0 || count($group2) > 0) {
				   $menu .= '
            <li><a style="font-size:11px" href="#" class="menuLink">'.($rows_grp1->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
		
				   foreach ($Rows2 as $row2) {
        $table3 = new Application_Model_DbTable_EuUtilisateur();
		$select3 = $table3->select();
        //$select3 = $table3->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        //$select3->setIntegrityCheck(false);
        //$select3->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select3->where('id_utilisateur_parent = ?',$row2->id_utilisateur);
        $select3->order('id_utilisateur asc');
        $Rows3 = $table3->fetchAll($select3);
				
				$tab3 = new Application_Model_DbTable_EuUserGroup();
				$sel3 = $tab3->select();
				$sel3->where('code_groupe_parent = ?', $row2->code_groupe);
				$group3 = $tab3->fetchAll($sel3);
					
				   $grp2 = new Application_Model_DbTable_EuUserGroup();
					$select_grp2 = $grp2->select();
					$select_grp2->where('code_groupe = ?', $row2->code_groupe);
					$rows_grp2 = $grp2->fetchRow($select_grp2);

			   if(count($Rows3) > 0 || count($group3) > 0) {
				   $menu .= '
            <li><a style="font-size:11px;" href="#" class="menuLink">'.($rows_grp2->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';

				   foreach ($Rows3 as $row3) {
        $table4 = new Application_Model_DbTable_EuUtilisateur();
		$select4 = $table4->select();
        //$select4 = $table4->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        //$select4->setIntegrityCheck(false);
        //$select4->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select4->where('id_utilisateur_parent = ?',$row3->id_utilisateur);
        $select4->order('id_utilisateur asc');
        $Rows4 = $table4->fetchAll($select4);
				
				$tab4 = new Application_Model_DbTable_EuUserGroup();
				$sel4 = $tab4->select();
				$sel4->where('code_groupe_parent = ?', $row3->code_groupe);
				$group4 = $tab4->fetchAll($sel4);
					
				   $grp3 = new Application_Model_DbTable_EuUserGroup();
					$select_grp3 = $grp3->select();
					$select_grp3->where('code_groupe = ?', $row3->code_groupe);
					$rows_grp3 = $grp3->fetchRow($select_grp3);

			   if(count($Rows4) > 0 || count($group4) > 0) {
				   $menu .= '
            <li><a style="font-size:11px" href="#" class="menuLink">'.($rows_grp3->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				   foreach ($Rows4 as $row4) {
				   
		}
					
		$menu .= " </ul></li>";
						}else{
						if($rows_grp3->id_cm_utilisateur == 1){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/transfert3/ssgrp/'.$row3->code_groupe.' ">'.($rows_grp3->libelle_groupe).'</a></li>';
						}else if($rows_grp3->id_cm_utilisateur == 2){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/echange3/ssgrp/'.$row3->code_groupe.' ">'.($rows_grp3->libelle_groupe).'</a></li>';
						}else if($rows_grp3->id_cm_utilisateur == 3){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/debitcredit3/ssgrp/'.$row3->code_groupe.' ">'.($rows_grp3->libelle_groupe).'</a></li>';
						}
						}
		}
		
		$menu .= " </ul></li>";
						}else{
						if($rows_grp2->id_cm_utilisateur == 1){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/transfert3/ssgrp/'.$row2->code_groupe.' ">'.($rows_grp2->libelle_groupe).'</a></li>';
						}else if($rows_grp2->id_cm_utilisateur == 2){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/echange3/ssgrp/'.$row2->code_groupe.' ">'.($rows_grp2->libelle_groupe).'</a></li>';
						}else if($rows_grp2->id_cm_utilisateur == 3){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/debitcredit3/ssgrp/'.$row2->code_groupe.' ">'.($rows_grp2->libelle_groupe).'</a></li>';
						}
						}
		}
		
		$menu .= " </ul></li>";
						}else{
						if($rows_grp1->id_cm_utilisateur == 1){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/transfert3/ssgrp/'.$row1->code_groupe.' ">'.($rows_grp1->libelle_groupe).'</a></li>';
						}else if($rows_grp1->id_cm_utilisateur == 2){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/echange3/ssgrp/'.$row1->code_groupe.' ">'.($rows_grp1->libelle_groupe).'</a></li>';
						}else if($rows_grp1->id_cm_utilisateur == 3){
					$menu .= '<li><a style="font-size:11px" href=" /eu-user/debitcredit3/ssgrp/'.$row1->code_groupe.' ">'.($rows_grp1->libelle_groupe).'</a></li>';
						}
					}
		}
		//$menu .= " </ul></li>";
		}




        //}
}


        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {

        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        // action body
    }

    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_utilisateur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuUtilisateur();
        $select = $tabela->select();
        $cats = $tabela->fetchAll($select);
        $count = count($cats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($cats as $row) {

            $responce['rows'][$i]['id'] = $row->id_utilisateur;
            $responce['rows'][$i]['cell'] = array(
                $row->login,
                $row->pwd,
                $row->code_groupe,
                $row->description,
                $row->ulock,
                $row->connecte,
                $row->ch_pwd_flog,
                $row->code_membre,
                $row->code_secteur,
                $row->code_zone,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function distribAction() {
        
    }

    public function listdistribAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_utilisateur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuUtilisateur();
        $select1 = $tabela->select();
        $select1->where('code_acteur = ?', $user->code_acteur)
                ->where('code_groupe = ?', 'dist');
        $select2 = $tabela->select();
        $select2->where('code_acteur = ?', $user->code_acteur)
                ->where('code_groupe = ?', 'boutique');
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2));

        $cats = $tabela->fetchAll($select);
        $count = count($cats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->id_utilisateur;
            $responce['rows'][$i]['cell'] = array(
                strtoupper($row->nom_utilisateur),
                ucfirst($row->prenom_utilisateur),
                $row->login,
                $row->pwd,
                $row->description,
                $row->ulock,
                $row->connecte,
                $row->ch_pwd_flog,
                $row->code_membre,
                $row->code_secteur,
                $row->code_zone,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {
        
    }

    public function newAction() {
        // action body 
        $request = $this->getRequest();
        $form = new Application_Form_EuUser();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $pwd = $this->_request->getPost("pwd");
                $pwd1 = $this->_request->getPost("pwd1");
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    //Mise à jour de la table eu_utilisateur
                    $user = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $find_user = $mapper->findLogin($this->_request->getPost("login"));
                    if ($find_user != false) {
                        $message = 'Ce login existe déjà.';
                        $this->view->message = $message;
                        $this->view->form = $form;
                        return;
                    } else if ($pwd != $pwd1) {
                        $message = 'Erreur de confirmation.';
                        $this->view->message = $message;
                        $this->view->form = $form;
                        return;
                    } else {
                        $user->setPrenom_utilisateur($this->_request->getPost("prenom_utilisateur"))
                                ->setNom_utilisateur($this->_request->getPost("nom_utilisateur"))
                                ->setLogin($this->_request->getPost("login"))
                                ->setPwd(md5($pwd))
                                ->setDescription($this->_request->getPost("description"))
                                ->setUlock($this->_request->getPost("ulock"))
                                ->setCh_pwd_flog(0)
                                ->setCode_groupe($this->_request->getPost("code_groupe"))
                                ->setConnecte(0)
                                ->setCode_agence($this->_request->getPost("code_agence"))
                                ->setCode_secteur($this->_request->getPost("code_secteur"))
                                ->setCode_zone($this->_request->getPost("code_zone"));
                        $group = $this->_request->getPost("code_groupe");
                        if ($group == 'fl' || $group == "admin" || $group == "agregat" || $group == "fs" || $group == "pck" || $group == "prk" || $group == "quota" || $group == "sqmaxui" || $group == 'smc_entree_r' || $group == 'smc_entree_nr' || $group == 'smc_sortie_nr' || $group == 'smc_sortie_r' || $group == 'fn_entree_r' || $group == 'fn_entree_nr' || $group == 'fn_sortie_nr' || $group == 'fn_sortie_r' || $group == 'periode' || $group == 'contrat') {
                            $user->setCode_membre(Null);
                        } elseif ($group == "cm") {
                            if ($this->_request->getPost("code_membre") == '') {
                                $user->setCode_membre(null);
                            } else {
                                $user->setCode_membre($this->_request->getPost("code_membre"));
                            }
                        } else {
                            $user->setCode_membre($this->_request->getPost("code_membre"));
                        }
                        if ($group == "filiere" || $group == "dist") {
                            $user->setCode_gac_filiere($this->_request->getPost("code_gac_filiere"));
                        } else {
                            $user->setCode_gac_filiere(Null);
                        }
                        $user->setCode_acteur(Null);
                        $mapper->save($user);
                    }
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Vous avez oublié de saisir le numero membre ou le numéro de la gac filière';
                    // $message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function editAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuUserM();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $pwd = $this->_request->getPost("pwd");
                $pwd1 = $this->_request->getPost("pwd1");
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    //Mise à jour de la table user
                    $user = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $rep = $mapper->find($this->_request->getPost("id_utilisateur"), $user);
                    if ($rep) {
                        $user->setPrenom_utilisateur($this->_request->getPost("prenom_utilisateur"))
                                ->setNom_utilisateur($this->_request->getPost("nom_utilisateur"))
                                ->setDescription($this->_request->getPost("description"))
                                ->setUlock($this->_request->getPost("ulock"))
                                ->setCh_pwd_flog(0)
                                ->setCode_groupe($this->_request->getPost("code_groupe"))
                                ->setConnecte(0)
                                ->setCode_agence($this->_request->getPost("code_agence"))
                                ->setCode_secteur($this->_request->getPost("code_secteur"))
                                ->setCode_zone($this->_request->getPost("code_zone"));
                        $group = $this->_request->getPost("code_groupe");
                        if ($group == "admin" || $group == "agregat" || $group == "cm" || $group == "fs" || $group == "pck" || $group == "prk" || $group == "quota" || $group == "sqmaxui" || $group == 'smc_entree_r' || $group == 'smc_entree_nr' || $group == 'smc_sortie_nr' || $group == 'smc_sortie_r' || $group == 'fn_entree_r' || $group == 'fn_entree_nr' || $group == 'fn_sortie_nr' || $group == 'fn_sortie_r' || $group == 'periode' || $group == 'contrat') {
                            $user->setCode_membre(Null);
                        } else {
                            $user->setCode_membre($this->_request->getPost("code_membre"));
                        }
                        if ($group == "filiere" || $group == "dist") {
                            $user->setCode_gac_filiere($this->_request->getPost("code_gac_filiere"));
                        } else {
                            $user->setCode_gac_filiere(Null);
                        }
                        $user->setCode_acteur(Null);
                        $mapper->update($user);
                    }
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Vous avez oublié de saisir le numero membre ou le numero de la gac filière';
                    //$message = 'Erreur d\'éxécution : ' . $message . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
            // invalid fields - need old employee to set the name back
            $id_user = $this->getRequest()->user;
            $mapper = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
        } else {
            $id_user = $this->getRequest()->user;
            $mapper = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $mapper->find($id_user, $user);
            if ($user->getId_utilisateur() == $id_user) {
                $data = array(
                    'id_utilisateur' => $user->getId_utilisateur(),
                    //'login' => $user->getLogin(),
                    //'pwd' => $user->getPwd(),
                    'description' => $user->getDescription(),
                    'ulock' => $user->getUlock(),
                    'ch_pwd_flog' => $user->getCh_pwd_flog(),
                    'code_groupe' => $user->getCode_groupe(),
                    'code_membre' => $user->getCode_membre(),
                    'code_secteur' => $user->getCode_secteur(),
                    'code_agence' => $user->getCode_agence(),
                    'code_zone' => $user->getCode_zone(),
                    'code_gac_filiere' => $user->getCode_gac_filiere(),
                    'code_acteur' => $user->getCode_acteur(),
                    'nom_utilisateur' => $user->getNom_utilisateur(),
                    'prenom_utilisateur' => $user->getPrenom_utilisateur()
                );

                $form->populate($data);
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->user = $user;
        $this->view->form = $form;
    }

    public function deleteAction() {
        // action body
        $form = new Application_Form_EuUser();

        if ($this->getRequest()->isPost()) {
            $mapper = new Application_Model_EuUtilisateurMapper();
            $mapper->delete($this->getRequest()->login);
            return $this->_helper->redirector('index');
        } else {
            // initial rendering of the form, get the employee id
            // from the parameters
            $login = $this->getRequest()->login;
            $mapper = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $mapper->find($login, $user);
            if ($user->getLogin() == $login) {
                $data = array(
                    'id_utilisateur' => $user->getId_utilisateur(),
                    'login' => $user->getLogin(),
                    'pwd' => $user->getPwd(),
                    'description' => $user->getDescription(),
                    'ulock' => $user->getUlock(),
                    'ch_pwd_flog' => $user->getCh_pwd_flog(),
                    'code_groupe' => $user->getCode_groupe(),
                    'code_membre' => $user->getCode_membre(),
                    'code_secteur' => $user->getCode_secteur(),
                    'code_agence' => $user->getCode_agence(),
                    'code_zone' => $user->getCode_zone(),
                    'code_gac_filiere' => $user->getCode_gac_filiere(),
                    'code_acteur' => $user->getCode_acteur(),
                    'nom_utilisateur' => $user->getNom_utilisateur(),
                    'prenom_utilisateur' => $user->getPrenom_utilisateur()
                );
                $form->populate($data);
            } else {
                // redirect to new action if the employee id is invalid
                return $this->_helper->redirector('new');
            }
        }


        // make form read-only

        foreach ($form->getElements() as $formElement) {
            if ($formElement->getAttrib('id') != 'submit-label') {
                $formElement->setAttrib('readonly', 'true');
            }
        }

        // Add the link to the cancel button

        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user',
                    'action' => 'index'), 'default', true) . "','_self')");

        $this->view->form = $form;
    }

    public function gacuserAction() {
        // action body
        $request = $this->getRequest();
        $type = $request->type;
        $zone = $request->zone;
        $membre = $request->membre;
        $num = $request->num;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $code_type = $request->code_type;
        $code_div = $request->code_div;
        $this->view->numero = $num;
        $this->view->num_membre = $membre;
        $this->view->type = $type;
        $this->view->zone = $zone;
        $this->view->nom_user = $nom;
        $this->view->prenom_user = $prenom;
        $this->view->code_type = $code_type;
        $this->view->code_div = $code_div;
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $groupe = $users->code_groupe;
        if ($this->getRequest()->isPost()) {
            $muser = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $type1 = $this->_request->getPost("type");
            $zone1 = $this->_request->getPost("zone");
            $code_type1 = $this->_request->getPost("code_type");
            $code_div1 = $this->_request->getPost("code_div");
            $num_membre = $this->_request->getPost("num_membre");
            $numero = $this->_request->getPost("numero");
            $login = $this->_request->getPost("login");
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            //Contrôle du login user
            $find_user = $muser->findLogin($login);
            if ($find_user == false) {
                //Création du compte user
                $user->setNom_utilisateur($this->_request->getPost("nom_user"))
                        ->setPrenom_utilisateur($this->_request->getPost("prenom_user"))
                        ->setLogin($login)
                        ->setPwd(md5($this->_request->getPost("pwd")))
                        ->setUlock(0)
                        ->setCh_pwd_flog(0);
                if ($type1 == 'pbf' && $groupe == 'agregat') {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac_pbf');
                        $user->setDescription('Groupe des gac pbf de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp_pbf');
                        $user->setDescription('Groupe des gac pbf Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe') {
                        $user->setCode_groupe('gacex_pbf');
                        $user->setDescription('Groupe des gac pbf Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu_pbf');
                        $user->setDescription('Groupe des gac pbf Surveillantes du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse_pbf');
                        $user->setDescription('Groupe des gac pbf de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr_pbf');
                        $user->setDescription('Groupe des gac pbf de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs_pbf');
                        $user->setDescription('Groupe des gac pbf du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca_pbf');
                        $user->setDescription('Groupe des gac pbf de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'gac' && $groupe == 'agregat') {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac');
                        $user->setDescription('Groupe des gac de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp');
                        $user->setDescription('Groupe des gac Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe') {
                        $user->setCode_groupe('gacex');
                        $user->setDescription('Groupe des gac Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu');
                        $user->setDescription('Groupe des gac Surveillantes du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse');
                        $user->setDescription('Groupe des gac de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr');
                        $user->setDescription('Groupe des gac de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs');
                        $user->setDescription('Groupe des gac du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca');
                        $user->setDescription('Groupe des gac de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'pbf' && ($groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf')) {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac_pbf');
                        $user->setDescription('Groupe des gac pbf de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp_pbf');
                        $user->setDescription('Groupe des gac pbf Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe') {
                        $user->setCode_groupe('gacex_pbf');
                        $user->setDescription('Groupe des gac pbf Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu_pbf');
                        $user->setDescription('Groupe des gac pbf Surveillantes du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse_pbf');
                        $user->setDescription('Groupe des gac pbf de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr_pbf');
                        $user->setDescription('Groupe des gac pbf de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs_pbf');
                        $user->setDescription('Groupe des gac pbf du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca_pbf');
                        $user->setDescription('Groupe des gac pbf de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'gac' && ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca')) {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac');
                        $user->setDescription('Groupe des gac de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp');
                        $user->setDescription('Groupe des gac Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe ') {
                        $user->setCode_groupe('gacex');
                        $user->setDescription('Groupe des gac Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu');
                        $user->setDescription('Groupe des gac Surveillantes du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse');
                        $user->setDescription('Groupe des gac de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr');
                        $user->setDescription('Groupe des gac de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs');
                        $user->setDescription('Groupe des gac du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca');
                        $user->setDescription('Groupe des gac de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                $user->setConnecte(0)
                        ->setCode_secteur($this->_request->getPost("numsect"))
                        ->setCode_zone($zone1)
                        ->setCode_membre($num_membre)
                        ->setCode_agence($this->_request->getPost("numag"))
                        ->setCode_acteur($numero);
                if ($this->_request->getPost("numsect") == '') {
                    $user->setCode_secteur(null);
                }
                if ($this->_request->getPost("numag") == '') {
                    $user->setCode_agence(null);
                }
                $id_user = $muser->findConuter() + 1;
                $user->setId_utilisateur($id_user);
                $muser->save($user);
                $db->commit();
                if ($groupe == 'dg' || $groupe == 'agregat' || $groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf') {
                    return $this->_helper->redirector('index', 'eu-gac', null, array('controller' => 'eu-gac', 'action' => 'index', null));
                }
            } else {
                $db->rollback();
                $this->view->message = 'Ce login est déjà utiliser.';
                $this->view->numero = $numero;
                $this->view->num_membre = $num_membre;
                $this->view->nom_user = $_POST["nom_user"];
                $this->view->prenom_user = $_POST["prenom_user"];
                $this->view->login = $_POST["login"];
                $this->view->pwd = $_POST["pwd"];
                $this->view->numsect = $_POST["numsect"];
                $this->view->numag = $_POST["numag"];
                $this->view->type = $type1;
                $this->view->code_div = $code_div1;
                $this->view->zone = $zone1;
                return;
            }
        }
    }

    public function newuserAction() {
        // action body
        $request = $this->getRequest();
        $type = $request->type;
        $zone = $request->zone;
        $membre = $request->membre;
        $num = $request->num;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $code_type = $request->code_type;
        $code_div = $request->code_div;
        $code_filiere = $request->code_filiere;
        $this->view->numero = $num;
        $this->view->num_membre = $membre;
        $this->view->type = $type;
        $this->view->zone = $zone;
        $this->view->nom_user = $nom;
        $this->view->prenom_user = $prenom;
        $this->view->code_type = $code_type;
        $this->view->code_div = $code_div;
        $this->view->code_filiere = $code_filiere;
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $groupe = $users->code_groupe;
        if ($this->getRequest()->isPost()) {
            $muser = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $type1 = $this->_request->getPost("type");
            $zone1 = $this->_request->getPost("zone");
            //$code_type1 = $this->_request->getPost("code_type");
            $num_membre = $this->_request->getPost("num_membre");
            $numero = $this->_request->getPost("numero");
            $login = $this->_request->getPost("login");
            $code_filiere = $this->_request->getPost("code_filiere");
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            //Contrôle du login user
            $find_user = $muser->findLogin($login);
            if ($find_user == false) {
                //Création du compte user
                $user->setNom_utilisateur($this->_request->getPost("nom_user"))
                        ->setPrenom_utilisateur($this->_request->getPost("prenom_user"))
                        ->setLogin($login)
                        ->setPwd(md5($this->_request->getPost("pwd")))
                        ->setUlock(0)
                        ->setCh_pwd_flog(0);
                if ($type1 == 'pbf' and ($groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf')) {
                    $user->setCode_groupe('filiere_pbf');
                    $user->setDescription('Groupe des gac Filières pbf');
                    $user->setCode_gac_filiere($numero);
                }
                if ($type1 == 'gac' and ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca')) {
                    $user->setCode_groupe('filiere');
                    $user->setDescription('Groupe des gac Filières');
                    $user->setCode_gac_filiere($numero);
                }
                if ($type1 == 'pbf' and $groupe == 'filiere_pbf' and $code_filiere == '') {
                    $user->setCode_groupe('creneau_pbf');
                    $user->setDescription('Groupe des Créneaux pbf');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'pbf' and $groupe == 'filiere_pbf' and $code_filiere !== '') {
                    $user->setCode_groupe('acteur_pbf');
                    $user->setDescription('Groupe des acteurs pbf');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'gac' and $groupe == 'filiere' and $code_filiere == '') {
                    $user->setCode_groupe('creneau');
                    $user->setDescription('Groupe des créneaux');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'gac' and $groupe == 'filiere' and $code_filiere !== '') {
                    $user->setCode_groupe('acteur');
                    $user->setDescription('Groupe des acteurs');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'pbf' and $groupe == 'creneau_pbf') {
                    $user->setCode_groupe('acteur_pbf');
                    $user->setDescription('Groupe des acteurs pbf');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'gac' and $groupe == 'creneau') {
                    $user->setCode_groupe('acteur');
                    $user->setDescription('Groupe des acteurs simples');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                $user->setConnecte(0)
                        ->setCode_secteur($_POST["numsect"])
                        ->setCode_zone($zone1)
                        ->setCode_agence($_POST["numag"])
                        ->setCode_acteur($numero);
                if ($num_membre == '') {
                    $user->setCode_membre(null);
                } else {
                    $user->setCode_membre($num_membre);
                }
                if ($this->_request->getPost("numsect") == '') {
                    $user->setCode_secteur(null);
                }
                if ($this->_request->getPost("numag") == '') {
                    $user->setCode_agence(null);
                }
                $id_user = $muser->findConuter() + 1;
                $user->setId_utilisateur($id_user);
                $muser->save($user);
                $db->commit();
                if ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca' || $groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf') {
                    return $this->_helper->redirector('index', 'eu-gac-filiere', null, array('controller' => 'eu-gac-filiere', 'action' => 'index', null));
                } elseif ($groupe == 'filiere' || $groupe == 'filiere_pbf' and $code_filiere == '') {
                    return $this->_helper->redirector('index', 'eu-creneau', null, array('controller' => 'eu-creneau', 'action' => 'index', null));
                } elseif ($groupe == 'filiere' || $groupe == 'filiere_pbf' and $code_filiere !== '') {
                    return $this->_helper->redirector('index', 'eu-acteur-creneau', null, array('controller' => 'eu-acteur-creneau', 'action' => 'index', null));
                } elseif ($groupe == 'creneau' || $groupe == 'creneau_pbf') {
                    return $this->_helper->redirector('index', 'eu-acteur-creneau', null, array('controller' => 'eu-acteur-creneau', 'action' => 'index', null));
                }
            } else {
                $db->rollback();
                $this->view->message = 'Ce login est déjà utiliser.';
                $this->view->numero = $numero;
                $this->view->num_membre = $num_membre;
                $this->view->nom_user = $_POST["nom_user"];
                $this->view->prenom_user = $_POST["prenom_user"];
                $this->view->login = $_POST["login"];
                $this->view->pwd = $_POST["pwd"];
                $this->view->numsect = $_POST["numsect"];
                $this->view->numag = $_POST["numag"];
                $this->view->type = $type1;
                $this->view->zone = $zone1;
                $this->view->code_filiere = $code_filiere;
                $this->view->code_div = $code_div;
                return;
            }
        }
    }

    public function adduserAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $groupe = $users->code_groupe;
        $code = $request->gac_act;
        $code_fil = $request->gac_fil;
        $code_type = '';
        if ($groupe == 'agregat') {
            $mapper = new Application_Model_EuGacMapper();
            $gac = new Application_Model_EuGac();
            $mapper->find($code, $gac);
            $num = $gac->getCode_gac();
            $zone = $gac->getZone();
            $code_type = $gac->getCode_type_gac();
        } elseif ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca' || $groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf') {
            $mapper = new Application_Model_EuGacFiliereMapper();
            $gac = new Application_Model_EuGacFiliere();
            $mapper->find($code, $gac);
            $num = $gac->getCode_gac_filiere();
            $zone = $users->code_zone;
        } elseif (($groupe == 'filiere' || $groupe == 'filiere_pbf') and $code_fil == '') {
            $mapper = new Application_Model_EuCreneauMapper();
            $gac = new Application_Model_EuCreneau();
            $mapper->find($code, $gac);
            $num = $gac->getCode_creneau();
            $zone = $users->code_zone;
        } elseif (($groupe == 'filiere' || $groupe == 'filiere_pbf') and $code_fil !== '') {
            $mapper = new Application_Model_EuActeurCreneauMapper();
            $gac = new Application_Model_EuActeurCreneau();
            $mapper->find($code, $gac);
            $num = $gac->getCode_acteur();
            $zone = $users->code_zone;
        } elseif ($groupe == 'creneau' || $groupe == 'creneau_pbf') {
            $mapper = new Application_Model_EuActeurCreneauMapper();
            $gac = new Application_Model_EuActeurCreneau();
            $mapper->find($code, $gac);
            $num = $gac->getCode_acteur();
            $zone = $users->code_zone;
        }
        $membre = $gac->getCode_membre();
        $type = $gac->getGroupe();
        $membrem = new Application_Model_EuMembreMapper();
        $memb = new Application_Model_EuMembre();
        $membrem->find($gac->getCode_membre_gestionnaire(), $memb);
        if ($memb) {
            $nom = $memb->getNom_membre();
            $prenom = $memb->getPrenom_membre();
        }
        $this->view->numero = $num;
        $this->view->num_membre = $membre;
        $this->view->type = $type;
        $this->view->zone = $zone;
        $this->view->nom_user = $nom;
        $this->view->prenom_user = $prenom;
        $this->view->code_type = $code_type;
        $this->view->code_filiere = $code_fil;
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            $muser = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $type1 = $this->_request->getPost("type");
            $zone1 = $this->_request->getPost("zone");
            $num_membre = $this->_request->getPost("num_membre");
            $numero = $this->_request->getPost("numero");
            $login = $this->_request->getPost("login");
            $code_type1 = $this->_request->getPost("code_type");
            $code_fil = $this->_request->getPost("code_filiere");
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            //Contrôle du login user
            $find_user = $muser->findLogin($login);
            if ($find_user == false) {
                //Création du compte user
                $user->setNom_utilisateur($this->_request->getPost("nom_user"))
                        ->setPrenom_utilisateur($this->_request->getPost("prenom_user"))
                        ->setLogin($login)
                        ->setPwd(md5($this->_request->getPost("pwd")))
                        ->setUlock(0)
                        ->setCh_pwd_flog(0);
                if ($type1 == 'pbf' and $groupe == 'agregat') {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac_pbf');
                        $user->setDescription('Groupe des gac pbf de la source zone');
                    } else if ($code_type1 == 'gac_pays') {
                        $user->setCode_groupe('gacp_pbf');
                        $user->setDescription('Groupe des gac pbf du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse_pbf');
                        $user->setDescription('Groupe des gac pbf de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr_pbf');
                        $user->setDescription('Groupe des gac pbf de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs_pbf');
                        $user->setDescription('Groupe des gac pbf du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca_pbf');
                        $user->setDescription('Groupe des gac pbf de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'gac' and $groupe == 'agregat') {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac');
                        $user->setDescription('Groupe des gac simples de la source zone');
                    } else if ($code_type1 == 'gac_pays') {
                        $user->setCode_groupe('gacp');
                        $user->setDescription('Groupe des gac simples du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse');
                        $user->setDescription('Groupe des gac simples de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr');
                        $user->setDescription('Groupe des gac simples de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs');
                        $user->setDescription('Groupe des gac simples du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca');
                        $user->setDescription('Groupe des gac simples de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'pbf' and ($groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf')) {
                    $user->setCode_groupe('filiere_pbf');
                    $user->setDescription('Groupe des gac Filières pbf');
                    $user->setCode_gac_filiere($numero);
                }
                if ($type1 == 'gac' and ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca')) {
                    $user->setCode_groupe('filiere');
                    $user->setDescription('Groupe des gac Filières simples');
                    $user->setCode_gac_filiere($numero);
                }
                if ($type1 == 'pbf' and $groupe == 'filiere_pbf' and $code_fil == '') {
                    $user->setCode_groupe('creneau_pbf');
                    $user->setDescription('Groupe des Créneaux pbf');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'pbf' and $groupe == 'filiere_pbf' and $code_fil !== '') {
                    $user->setCode_groupe('acteur_pbf');
                    $user->setDescription('Groupe des acteurs pbf');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'gac' and $groupe == 'filiere' and $code_fil == '') {
                    $user->setCode_groupe('creneau');
                    $user->setDescription('Groupe des créneaux simples');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'gac' and $groupe == 'filiere' and $code_fil !== '') {
                    $user->setCode_groupe('acteur');
                    $user->setDescription('Groupe des acteurs simples');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'pbf' and $groupe == 'creneau_pbf') {
                    $user->setCode_groupe('acteur_pbf');
                    $user->setDescription('Groupe des acteurs pbf');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                if ($type1 == 'gac' and $groupe == 'creneau') {
                    $user->setCode_groupe('acteur');
                    $user->setDescription('Groupe des acteurs simples');
                    $user->setCode_gac_filiere($users->code_gac_filiere);
                }
                $user->setConnecte(0)
                     ->setCode_secteur($_POST["numsect"])
                     ->setCode_zone($zone1)
                        //->setCode_membre($num_membre)
                        ->setCode_agence($_POST["numag"])
                        ->setCode_acteur($numero);
                if ($num_membre == '') {
                    $user->setCode_membre(null);
                } else {
                    $user->setCode_membre($num_membre);
                }
                if ($this->_request->getPost("numsect") == '') {
                    $user->setCode_secteur(null);
                }
                if ($this->_request->getPost("numag") == '') {
                    $user->setCode_agence(null);
                }
                $muser->save($user);
                $db->commit();
                if ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca' || $groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf') {
                    return $this->_helper->redirector('index', 'eu-gac-filiere', null, array('controller' => 'eu-gac-filiere', 'action' => 'index', null));
                } elseif ($groupe == 'filiere' || $groupe == 'filiere_pbf' and $code_fil == '') {
                    return $this->_helper->redirector('index', 'eu-creneau', null, array('controller' => 'eu-creneau', 'action' => 'index', null));
                } elseif ($groupe == 'filiere' || $groupe == 'filiere_pbf' and $code_fil !== '') {
                    return $this->_helper->redirector('index', 'eu-acteur-creneau', null, array('controller' => 'eu-acteur-creneau', 'action' => 'index', null));
                } elseif ($groupe == 'creneau' || $groupe == 'creneau_pbf') {
                    return $this->_helper->redirector('index', 'eu-acteur-creneau', null, array('controller' => 'eu-acteur-creneau', 'action' => 'index', null));
                }
            } else {
                $db->rollback();
                $this->view->message = 'Ce login est déjà utiliser.';
                $this->view->numero = $numero;
                $this->view->num_membre = $num_membre;
                $this->view->nom_user = $_POST["nom_user"];
                $this->view->prenom_user = $_POST["prenom_user"];
                $this->view->login = $_POST["login"];
                $this->view->pwd = $_POST["pwd"];
                $this->view->numsect = $_POST["numsect"];
                $this->view->numag = $_POST["numag"];
                $this->view->type = $type1;
                $this->view->zone = $zone1;
                $this->view->code_filiere = $code_fil;
                return;
            }
        }
    }

    public function addgacuserAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $groupe = $users->code_groupe;
        $code = $request->gac;
        $code_type = '';
        if ($groupe == 'agregat' || $groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca' || $groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf') {
            $mapper = new Application_Model_EuGacMapper();
            $gac = new Application_Model_EuGac();
            $mapper->find($code, $gac);
            $num = $gac->getCode_gac();
            $zone = $gac->getZone();
            $code_type = $gac->getCode_type_gac();
        }
        $membre = $gac->getCode_membre();
        $type = $gac->getGroupe();
        $membrem = new Application_Model_EuMembreMapper();
        $memb = new Application_Model_EuMembre();
        $membrem->find($gac->getCode_membre_gestionnaire(), $memb);
        if ($memb) {
            $nom = $memb->getNom_membre();
            $prenom = $memb->getPrenom_membre();
        }
        //Récup du code_div de la division
        $id_div = '';
        $id_div = $gac->getId_division();
        if ($id_div != '') {
            $madiv = new Application_Model_DbTable_EuDivisionGac();
            $select = $madiv->select();
            $select->where('id_division =?', $gac->getId_division());
            $div = $madiv->fetchAll($select);
            $row = $div->current();
        }
        $this->view->numero = $num;
        $this->view->num_membre = $membre;
        $this->view->type = $type;
        $this->view->zone = $zone;
        $this->view->nom_user = $nom;
        $this->view->prenom_user = $prenom;
        $this->view->code_type = $code_type;
        $this->view->code_div = $row->code_division;
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            $muser = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $type1 = $this->_request->getPost("type");
            $zone1 = $this->_request->getPost("zone");
            $num_membre = $this->_request->getPost("num_membre");
            $numero = $this->_request->getPost("numero");
            $login = $this->_request->getPost("login");
            $code_type1 = $this->_request->getPost("code_type");
            $code_div1 = $this->_request->getPost("code_div");
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            //Contrôle du login user
            $find_user = $muser->findLogin($login);
            if ($find_user == false) {
                //Création du compte user
                $user->setNom_utilisateur($this->_request->getPost("nom_user"))
                        ->setPrenom_utilisateur($this->_request->getPost("prenom_user"))
                        ->setLogin($login)
                        ->setPwd(md5($this->_request->getPost("pwd")))
                        ->setUlock(0)
                        ->setCh_pwd_flog(0);
                if ($type1 == 'pbf' and $groupe == 'agregat') {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac_pbf');
                        $user->setDescription('Groupe des gac pbf de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp_pbf');
                        $user->setDescription('Groupe des gac pbf Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe') {
                        $user->setCode_groupe('gacex_pbf');
                        $user->setDescription('Groupe des gac pbf Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu_pbf');
                        $user->setDescription('Groupe des gac pbf Surveillante du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse_pbf');
                        $user->setDescription('Groupe des gac pbf de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr_pbf');
                        $user->setDescription('Groupe des gac pbf de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs_pbf');
                        $user->setDescription('Groupe des gac pbf du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca_pbf');
                        $user->setDescription('Groupe des gac pbf de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'gac' and $groupe == 'agregat') {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac');
                        $user->setDescription('Groupe des gac de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp');
                        $user->setDescription('Groupe des gac Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe') {
                        $user->setCode_groupe('gacex');
                        $user->setDescription('Groupe des gac Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu');
                        $user->setDescription('Groupe des gac Surveillantes du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse');
                        $user->setDescription('Groupe des gac de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr');
                        $user->setDescription('Groupe des gac simples de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs');
                        $user->setDescription('Groupe des gac simples du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca');
                        $user->setDescription('Groupe des gac simples de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'pbf' and ($groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf' || $groupe == 'gaca_pbf')) {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac_pbf');
                        $user->setDescription('Groupe des gac pbf de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl') {
                        $user->setCode_groupe('gacp_pbf');
                        $user->setDescription('Groupe des gac pbf Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe') {
                        $user->setCode_groupe('gacex_pbf');
                        $user->setDescription('Groupe des gac pbf Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur') {
                        $user->setCode_groupe('gacsu_pbf');
                        $user->setDescription('Groupe des gac pbf Surveillante du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse_pbf');
                        $user->setDescription('Groupe des gac pbf de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr_pbf');
                        $user->setDescription('Groupe des gac pbf de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs_pbf');
                        $user->setDescription('Groupe des gac pbf du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca_pbf');
                        $user->setDescription('Groupe des gac pbf de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                if ($type1 == 'gac' and ($groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca')) {
                    if ($code_type1 == 'gac_zone') {
                        $user->setCode_groupe('gac');
                        $user->setDescription('Groupe des gac de la source zone');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'dl ') {
                        $user->setCode_groupe('gacp');
                        $user->setDescription('Groupe des gac Détentrices de licence du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'exe ') {
                        $user->setCode_groupe('gacex');
                        $user->setDescription('Groupe des gac Exécutantes du pays');
                    } else if ($code_type1 == 'gac_pays' && $code_div1 == 'sur ') {
                        $user->setCode_groupe('gacsu');
                        $user->setDescription('Groupe des gac Surveillantes du pays');
                    } else if ($code_type1 == 'gac_section') {
                        $user->setCode_groupe('gacse');
                        $user->setDescription('Groupe des gac de la section');
                    } else if ($code_type1 == 'gac_region') {
                        $user->setCode_groupe('gacr');
                        $user->setDescription('Groupe des gac de la région');
                    } else if ($code_type1 == 'gac_secteur') {
                        $user->setCode_groupe('gacs');
                        $user->setDescription('Groupe des gac du secteur');
                    } else if ($code_type1 == 'gac_agence') {
                        $user->setCode_groupe('gaca');
                        $user->setDescription('Groupe des gac de l\'agence');
                    }
                    $user->setCode_gac_filiere(null);
                }
                $user->setConnecte(0)
                        ->setCode_secteur($_POST["numsect"])
                        ->setCode_zone($zone1)
                        ->setCode_membre($num_membre)
                        ->setCode_agence($_POST["numag"])
                        ->setCode_acteur($numero);
                if ($this->_request->getPost("numsect") == '') {
                    $user->setCode_secteur(null);
                }
                if ($this->_request->getPost("numag") == '') {
                    $user->setCode_agence(null);
                }
                $id_user = $muser->findConuter() + 1;
                $user->setId_utilisateur($id_user);
                $muser->save($user);
                $db->commit();
                if ($groupe == 'agregat' || $groupe == 'gac' || $groupe == 'gacp' || $groupe == 'gacex' || $groupe == 'gacsu' || $groupe == 'gacse' || $groupe == 'gacr' || $groupe == 'gacs' || $groupe == 'gaca' || $groupe == 'gac_pbf' || $groupe == 'gacp_pbf' || $groupe == 'gacex_pbf' || $groupe == 'gacsu_pbf' || $groupe == 'gacse_pbf' || $groupe == 'gacr_pbf' || $groupe == 'gacs_pbf') {
                    return $this->_helper->redirector('index', 'eu-gac', null, array('controller' => 'eu-gac', 'action' => 'index', null));
                }
            } else {
                $db->rollback();
                $this->view->message = 'Ce login est déjà utiliser.';
                $this->view->numero = $numero;
                $this->view->num_membre = $num_membre;
                $this->view->nom_user = $_POST["nom_user"];
                $this->view->prenom_user = $_POST["prenom_user"];
                $this->view->login = $_POST["login"];
                $this->view->pwd = $_POST["pwd"];
                $this->view->numsect = $_POST["numsect"];
                $this->view->numag = $_POST["numag"];
                $this->view->type = $type1;
                $this->view->zone = $zone1;
                $this->view->code_div = $code_div1;
                return;
            }
        }
    }

    public function newdistribAction() {
        // action body 
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $request = $this->getRequest();
        $form = new Application_Form_EuDistributeur();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $pwd = $this->_request->getPost("pwd");
                $pwd1 = $this->_request->getPost("pwd1");
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    //Mise à jour de la table eu_utilisateur
                    $user = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $find_user = $mapper->findLogin($this->_request->getPost("login"));
                    if ($find_user != false) {
                        $message = 'Ce login existe déjà.';
                        $this->view->message = $message;
                        $this->view->form = $form;
                        return;
                    } else if ($pwd != $pwd1) {
                        $message = 'Erreur de confirmation.';
                        $this->view->message = $message;
                        $this->view->form = $form;
                        return;
                    } else {
                        $user->setPrenom_utilisateur($this->_request->getPost("prenom_utilisateur"))
                                ->setNom_utilisateur($this->_request->getPost("nom_utilisateur"))
                                ->setLogin($this->_request->getPost("login"))
                                ->setPwd(md5($pwd))
                                ->setDescription($this->_request->getPost("description"))
                                ->setUlock($this->_request->getPost("ulock"))
                                ->setCh_pwd_flog(0)
                                ->setCode_groupe($this->_request->getPost("type_groupe"))
                                ->setConnecte(0)
                                ->setCode_agence($users->code_agence)
                                ->setCode_secteur($users->code_secteur)
                                ->setCode_zone($users->code_zone);

                        $user->setCode_membre($users->code_membre);
                        $user->setCode_gac_filiere($users->code_gac_filiere);
                        $user->setCode_acteur($users->code_acteur);
                        $mapper->save($user);
                    }
                    $db->commit();
                    return $this->_helper->redirector('distrib');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user',
                    'action' => 'distrib'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function editdistribAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuDistributeur();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    //Mise à jour de la table user
                    $user = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();

                    $rep = $mapper->find($this->_request->getPost("id_utilisateur"), $user);
                    if ($rep) {
                        $user->setPrenom_utilisateur($this->_request->getPost("prenom_utilisateur"))
                                ->setNom_utilisateur($this->_request->getPost("nom_utilisateur"))
                                ->setLogin($this->_request->getPost("login"))
                                ->setPwd($user->getPwd())
                                ->setDescription($this->_request->getPost("description"))
                                ->setUlock($this->_request->getPost("ulock"))
                                ->setCh_pwd_flog(0)
                                ->setCode_groupe($this->_request->getPost("type_groupe"))
                                ->setConnecte(0)
                                ->setCode_agence($user->getCode_agence())
                                ->setCode_secteur($user->getCode_secteur())
                                ->setCode_zone($user->getCode_zone());

                        $user->setCode_membre($user->getCode_membre());
                        $user->setCode_gac_filiere($user->getCode_gac_filiere());
                        $user->setCode_acteur($user->getCode_acteur());
                        $mapper->update($user);
                    }
                    $db->commit();
                    return $this->_helper->redirector('distrib');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Erreur d\'éxécution : ' . $message . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
            // invalid fields - need old employee to set the name back
            $id_user = $this->getRequest()->user;
            $mapper = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
        } else {
            $id_user = $this->getRequest()->user;
            $mapper = new Application_Model_EuUtilisateurMapper();
            $user = new Application_Model_EuUtilisateur();
            $mapper->find($id_user, $user);
            if ($user->getId_utilisateur() == $id_user) {
                $data = array(
                    'id_utilisateur' => $user->getId_utilisateur(),
                    'login' => $user->getLogin(),
                    'pwd' => $user->getPwd(),
                    'PWD1' => $user->getPwd(),
                    'description' => $user->getDescription(),
                    'ulock' => $user->getUlock(),
                    'ch_pwd_flog' => $user->getCh_pwd_flog(),
                    'code_membre' => $user->getCode_membre(),
                    'code_secteur' => $user->getCode_secteur(),
                    'code_agence' => $user->getCode_agence(),
                    'code_zone' => $user->getCode_zone(),
                    'code_gac_filiere' => $user->getCode_gac_filiere(),
                    'code_acteur' => $user->getCode_acteur(),
                    'nom_utilisateur' => $user->getNom_utilisateur(),
                    'prenom_utilisateur' => $user->getPrenom_utilisateur(),
                    'code_groupe' => $user->getCode_groupe()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user',
                    'action' => 'distrib'
                        ), 'default', true) .
                "','_self')");

        $this->view->user = $user;
        $this->view->form = $form;
    }

	
    public function numsecteurAction() {
        $gac = array();
        $tab = new Application_Model_DbTable_EuSecteur();
        $sel = $tab->select();
        $sel->order('date_creation', 'asc');
        $ngac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($ngac as $value) {
            $gac[$i][1] = $value->code_secteur;
            $gac[$i][2] = ucfirst($value->nom_secteur);
            $i++;
        }
        $this->view->data = $gac;
    }

	
    public function numagenceAction() {
        $numsect = $_GET['numsect'];
        $gac = array();
        $tab = new Application_Model_DbTable_EuAgence();
        $sel = $tab->select();
        $sel->where('code_secteur = ?', $numsect);
        $ngac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($ngac as $value) {
            $gac[$i][1] = $value->code_agence;
            $gac[$i][2] = ucfirst($value->libelle_agence);
            $i++;
        }
        $this->view->data = $gac;
    }


	public function debitcreditAction() {
	
	
	}
	
	
	public function datadebitcreditAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'neng');
        $sord = $this->_request->getParam("sord", 'asc');
		$code = $this->_request->getParam("code");

		$id_utilisateur = $user->id_utilisateur;
        $code_groupe = trim($user->code_groupe);
        $code_membre = $user->code_membre;

        $ssgrp = (string)$this->_request->getParam('ssgrp');

        $table = new Application_Model_DbTable_EuUtilisateur();
                $select = $table->select();
                $select->where('id_utilisateur = ?', $id_utilisateur);
                $select->where('code_groupe = ?', $ssgrp);
                $Rows = $table->fetchAll($select);
		// && count($Rows) > 0
		if($ssgrp != "") {
		  //$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		  $sousgroupe = explode("_", $ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$s = $sousgroupe[0];}else{$s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$nn = $sousgroupe[1];}else{$nn = "";}
		if($nn != "smc" && $nn != "fn") {
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$par = $sousgroupe[2];}else{$par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd = $sousgroupe[3];}else{$prd = "";}
		if($prd != "capa" && $prd != "nn") {
		  if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd2 = $sousgroupe[3];}else{$prd2 = "";}
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk = $sousgroupe[4];}else{$prk = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk2 = $sousgroupe[5];}else{$prk2 = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk3 = $sousgroupe[6];}else{$prk3 = "";}
		} else {
		if($par == "reapropm") {
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prd2 = $sousgroupe[4];}else{$prd2 = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk = $sousgroupe[5];}else{$prk = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk2 = $sousgroupe[6]."reappro";}else{$prk2 = "";}
		  if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$prk3 = $sousgroupe[7];}else{$prk3 = "";}
		} else {
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prd2 = $sousgroupe[4];}else{$prd2 = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk = $sousgroupe[5];}else{$prk = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk2 = $sousgroupe[6];}else{$prk2 = "";}
		  if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$prk3 = $sousgroupe[7];}else{$prk3 = "";}
		}
		}
		
		}else {
		//if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$par = $sousgroupe[2];}else{$par = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$prd = $sousgroupe[2];}else{$prd = "";}
		if($prd != "creation"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$prd2 = $sousgroupe[2];}else{$prd2 = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prk = $sousgroupe[3];}else{$prk = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk2 = $sousgroupe[4];}else{$prk2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk3 = $sousgroupe[5];}else{$prk3 = "";}
		}else{
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd2 = $sousgroupe[3];}else{$prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk = $sousgroupe[4];}else{$prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk2 = $sousgroupe[5];}else{$prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk3 = $sousgroupe[6];}else{$prk3 = "";}
		}
			
		}



		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

if($nn == "nn"){
		if($prd == "nn" && $prd2 == "repartition"){
				$tabela = new Application_Model_DbTable_EuDetailAppelNn();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn');
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("eu_detail_appel_nn.code_membre like '%".$code_membre."%' ");
				}
				$select->order('eu_repartition_nn.id_rep_nn desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->montant_apport;
            $totsortie+=$row->mont_rep;
            $totsolde+=$row->mont_marge;

				$tabelb = new Application_Model_DbTable_EuDetailAppelNn();
				$selectb = $tabelb->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$selectb->setIntegrityCheck(false);
                $selectb->from('eu_detail_appel_nn', array('sum(mont_rep) as somme'));
                $selectb->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn', array());
				$selectb->where('eu_repartition_nn.date_rep <= ?', $row->date_rep);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				   $selectb->where("eu_detail_appel_nn.code_membre like '%".$code_membre."%' ");
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme;
				
            $responce['rows'][$i]['id'] = $row->id_rep_nn;
            $responce['rows'][$i]['cell'] = array(
              $row->date_rep,
              "nn Repartition",
              $row->creditcode,
              $row->montant_apport,
              $row->mont_rep,
              $row->mont_marge,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;
		}

		} else {
				$tabela = new Application_Model_DbTable_EuSmsmoney();
				$select = $tabela->select();
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', 'datetime', "to_char((datetime),'dd/mm/yyyy HH24:mi:ss') as datetime2"));
				if($ssgrp != ""){
           		$select->where("motif like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("destaccount_consumed like '%".$code_membre."%' ");
				}
				$select->order('neng desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
		    if($row->destaccount_consumed != null) {
			    $sortie = $row->creditamount;
				$solde  = 0;
            $totsortie+=$row->creditamount;
			} else {
			    $sortie = 0;
				$solde  = $row->creditamount;
                $totsolde+=$row->creditamount;
			}
            $totmontant+=$row->creditamount;

				$tabelb = new Application_Model_DbTable_EuSmsmoney();
				$selectb = $tabelb->select();
                $selectb->from('eu_smsmoney', array('sum(creditamount) as SOMME_creditamount'));
				$selectb->where('datetime <= ?', $row->datetime);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where("destaccount_consumed like '%".$code_membre."%' ");
				}
           		if($ssgrp != ""){
				$selectb->where("motif like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme_creditamount;
				
            $responce['rows'][$i]['id'] = $row->neng;
            $responce['rows'][$i]['cell'] = array(
              $row->datetime,
              $row->motif,
              $row->creditcode,
              $row->creditamount,
              $sortie,
              $solde,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;
		}

		}
}else if($nn == "cnp"){
				$tabela = new Application_Model_DbTable_EuCnp();
				$select = $tabela->select();
                $select->from(array('eu_cnp'), array('id_cnp', 'type_cnp', 'origine_cnp', 'mont_credit', 'mont_debit', 'solde_cnp', 'date_cnp', "to_char((date_cnp),'dd/mm/yyyy HH24:mi:ss') as date_cnp2"));
if($ssgrp != ""){
	if($prk == "prk"){
           		$select->where("upper(type_cnp) like '%".strtoupper($prd2)."%' ");//
           		$select->where("id_credit in (select id_credit from eu_compte_credit where upper(code_produit) like '%".strtoupper($prd2)."%' and prk = ".$prk2.")");//
	}else{
           		$select->where("upper(type_cnp) like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
	}
				}
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("source_credit like '%".$code_membre."%' ");
				}
				$select->order('id_cnp desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->mont_debit;
            $totsortie+=$row->mont_credit;
            $totsolde+=$row->solde_cnp;


				$tabelb = new Application_Model_DbTable_EuCnp();
				$selectb = $tabelb->select();
                $selectb->from('eu_cnp', array('sum(mont_debit) as SOMME_mont_debit'));
				$selectb->where('date_cnp <= ?', $row->date_cnp);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where("source_credit like '%".$code_membre."%' ");
				}
           		if($ssgrp != ""){
				$selectb->where("upper(type_cnp) like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme_mont_debit;
				/*foreach ($achatb as $rowb) {
					$total_date += $rowb->mont_credit;
				}*/
							  
            $responce['rows'][$i]['id'] = $row->id_cnp;
            $responce['rows'][$i]['cell'] = array(
              $row->DATE_CNP2,
              $row->type_cnp,
              $row->origine_cnp,
              $row->mont_debit,
              $row->mont_credit,
              $row->solde_cnp,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;

		}
}else if($nn == "smc"){
				$tabela = new Application_Model_DbTable_EuSmc();
				$select = $tabela->select();
                $select->from(array('eu_smc'), array('id_smc', 'type_smc', 'origine_smc', 'montant', 'sortie', 'solde', 'date_smc', "to_char((date_smc),'dd/mm/yyyy HH24:mi:ss') as date_smc2"));
				if($ssgrp != ""){
           		$select->where("upper(type_smc) like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("source_credit like '%".$code_membre."%' ");
				}
				$select->order('id_smc desc');
				$achat = $tabela->fetchAll($select);
								
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->montant;
            $totsortie+=$row->sortie;
            $totsolde+=$row->solde;


				$tabelb = new Application_Model_DbTable_EuSmc();
				$selectb = $tabelb->select();
                $selectb->from('eu_smc', array('sum(montant) as SOMME_montant'));
				$selectb->where('date_smc <= ?', $row->date_smc);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where("source_credit like '%".$code_membre."%' ");
				}
           		if($ssgrp != ""){
				$selectb->where("upper(type_smc) like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme_montant;
				/*foreach ($achatb as $rowb) {
					$total_date += $rowb->montant;
				}*/
							  
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
              $row->DATE_SMC2,
              $row->type_smc,
              $row->origine_smc,
              $row->montant,
              $row->sortie,
              $row->solde,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;

		}
}else if($nn == "fn"){
				$tabela = new Application_Model_DbTable_EuFn();
				$select = $tabela->select();
                //$select->from(array('eu_fn'), array('id_fn', 'type_fn', 'montant', 'sortie', 'solde', 'date_fn', "to_char((date_fn),'dd/mm/yyyy HH24:mi:ss') as date_fn2"));
				if($ssgrp != ""){
           		$select->where("upper(type_fn) like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("code_capa in (select code_capa from eu_capa where code_membre like '%".$code_membre."%')");
				}
				$select->order('id_fn desc');
				$achat = $tabela->fetchAll($select);
								
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->montant;
            $totsortie+=$row->sortie;
            $totsolde+=$row->solde;

				$tabelb = new Application_Model_DbTable_EuFn();
				$selectb = $tabelb->select();
                $selectb->from('eu_smc', array('sum(montant) as SOMME_montant'));
				$selectb->where('date_fn <= ?', $row->date_fn);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where("code_capa in (select code_capa from eu_capa where code_membre like '%".$code_membre."%')");
				}
           		if($ssgrp != ""){
           		$selectb->where("upper(type_fn) like '%".strtoupper($prd2.$prk.$prk2)."%' ");//
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme_montant;
				/*foreach ($achatb as $rowb) {
					$total_date += $rowb->montant;
				}*/
							  
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
              $row->date_fn,
              $row->type_fn,
              $row->code_capa,
              $row->montant,
              $row->sortie,
              $row->solde,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;

		}
}
		
        }
	

		
		
		
	public function transfertAction() {
	
	
	}
	
	
	public function datatransfertAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_transfert_nn');
        $sord = $this->_request->getParam("sord", 'desc');
		//$code = $this->_request->getParam("code");

		$id_utilisateur = $user->id_utilisateur;
        $code_groupe = trim($user->code_groupe);
        $code_membre = $user->code_membre;

        $ssgrp = (string)$this->_request->getParam('ssgrp');

        /*$table = new Application_Model_DbTable_EuUtilisateur();
                $select = $table->select();
                $select->where('id_utilisateur = ?', $id_utilisateur);
                $select->where('code_groupe = ?', $ssgrp);
                $Rows = $table->fetchAll($select);*/
		// && count($Rows) > 0
		if($ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre_kit_tec
		$sousgroupe = explode("_", $ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$s = $sousgroupe[0];}else{$s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$nn = $sousgroupe[1];}else{$nn = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$par = $sousgroupe[2];}else{$par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd = $sousgroupe[3];}else{$prd = "";}
		if($prd != "capa" && $prd != "nn"){
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd2 = $sousgroupe[3];}else{$prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk = $sousgroupe[4];}else{$prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk2 = $sousgroupe[5];}else{$prk2 = "";}
		}else{
		if($par == "reapropm"){
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prd2 = $sousgroupe[4];}else{$prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk = $sousgroupe[5];}else{$prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk2 = $sousgroupe[6]."reappro";}else{$prk2 = "";}
		}else{
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prd2 = $sousgroupe[4];}else{$prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk = $sousgroupe[5];}else{$prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk2 = $sousgroupe[6];}else{$prk2 = "";}
		}
		}

		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

		if($prd == "nn" && $prd2 == "repartition"){
				$tabela = new Application_Model_DbTable_EuDetailAppelNn();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn');
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("eu_detail_appel_nn.code_membre like '%".$code_membre."%' ");
				}
				$select->order('eu_repartition_nn.id_rep_nn desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->montant_apport;
            $totsortie+=$row->mont_rep;
            $totsolde+=$row->mont_marge;

				$tabelb = new Application_Model_DbTable_EuDetailAppelNn();
				$selectb = $tabelb->select(Zend_Db_Table::SELECT_WITH_FROM_PART);//
				$selectb->setIntegrityCheck(false);
                $selectb->from('eu_detail_appel_nn', array('sum(mont_rep) as somme'));
                $selectb->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn', array());
				$selectb->where('eu_repartition_nn.date_rep <= ?', $row->date_rep);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where("eu_detail_appel_nn.code_membre like '%".$code_membre."%' ");
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme;
				
            $responce['rows'][$i]['id'] = $row->id_rep_nn;
            $responce['rows'][$i]['cell'] = array(
              $row->date_rep,
              "nn Repartition",
              $row->creditcode,
              $row->montant_apport,
              $row->mont_rep,
              $row->mont_marge,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;
		}

		}else{
			
				$tabela = new Application_Model_DbTable_EuTransfertNn();
				$select = $tabela->select();
                $select->from(array('eu_transfert_nn'), array('id_transfert_nn', 'code_type_nn', 'type_transfert', 'mont_transfert', 'mont_vendu', 'solde_transfert', 'date_transfert', "to_char((date_transfert),'dd/mm/yyyy HH24:mi:ss') as date_transfert2"));
				if($ssgrp != ""){
           		$select->where("code_type_nn like '%".strtoupper($prd2.$prk.$prk2)."%' ");
				}
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where('code_compte_transfert like ?', '%'.$code_membre);
				}
				$select->order('id_transfert_nn desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->mont_transfert;
            $totsortie+=$row->mont_vendu;
            $totsolde+=$row->solde_transfert;
			
				$tabelb = new Application_Model_DbTable_EuTransfertNn();
				$selectb = $tabelb->select();
                $selectb->from('eu_transfert_nn', array('sum(mont_transfert) as somme_transfert'));
				$selectb->where('date_transfert <= ?', $row->date_transfert);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where('code_compte_transfert like ?', '%'.$code_membre);
				}
           		if($ssgrp != ""){
				$selectb->where("code_type_nn like '%".strtoupper($prd2.$prk.$prk2)."%' ");
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme_transfert;
				
            $responce['rows'][$i]['id'] = $row->id_transfert_nn;
            $responce['rows'][$i]['cell'] = array(
              $row->date_transfert,
              $row->code_type_nn,
              $row->type_transfert,
              $row->mont_transfert,
              $row->mont_vendu,
              $row->solde_transfert,
              $total_date
            );
            $i++;

        $responce['userdata']['type'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;
		

	}
	}
        }
		
		
		
		

		
		
		
	public function echangeAction() {
	
	
	}
	
	
	public function dataechangeAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'date_echange');
        $sord = $this->_request->getParam("sord", 'asc');
		$code = $this->_request->getParam("code");

		$id_utilisateur = $user->id_utilisateur;
        $code_groupe = trim($user->code_groupe);
        $code_membre = $user->code_membre;

        $ssgrp = (string)$this->_request->getParam('ssgrp');

        $table = new Application_Model_DbTable_EuUtilisateur();
                $select = $table->select();
                $select->where('id_utilisateur = ?', $id_utilisateur);
                $select->where('code_groupe = ?', $ssgrp);
                $Rows = $table->fetchAll($select);
		// && count($Rows) > 0
		if($ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		$sousgroupe = explode("_", $ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$s = $sousgroupe[0];}else{$s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$nn = $sousgroupe[1];}else{$nn = "";}
		if($nn != "smc" && $nn != "fn"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$par = $sousgroupe[2];}else{$par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd = $sousgroupe[3];}else{$prd = "";}
		if($prd != "capa" && $prd != "nn"){
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd2 = $sousgroupe[3];}else{$prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk = $sousgroupe[4];}else{$prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk2 = $sousgroupe[5];}else{$prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk3 = $sousgroupe[6];}else{$prk3 = "";}
		}else{
		if($par == "reapropm"){
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prd2 = $sousgroupe[4];}else{$prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk = $sousgroupe[5];}else{$prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk2 = $sousgroupe[6]."reappro";}else{$prk2 = "";}
		if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$prk3 = $sousgroupe[7];}else{$prk3 = "";}
		}else{
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prd2 = $sousgroupe[4];}else{$prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk = $sousgroupe[5];}else{$prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk2 = $sousgroupe[6];}else{$prk2 = "";}
		if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$prk3 = $sousgroupe[7];}else{$prk3 = "";}
		}
		}
		
		}else{
		//if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$par = $sousgroupe[2];}else{$par = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$prd = $sousgroupe[2];}else{$prd = "";}
		if($prd != "creation"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$prd2 = $sousgroupe[2];}else{$prd2 = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prk = $sousgroupe[3];}else{$prk = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk2 = $sousgroupe[4];}else{$prk2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk3 = $sousgroupe[5];}else{$prk3 = "";}
		}else{
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$prd2 = $sousgroupe[3];}else{$prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$prk = $sousgroupe[4];}else{$prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$prk2 = $sousgroupe[5];}else{$prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$prk3 = $sousgroupe[6];}else{$prk3 = "";}
		}
			
		}


		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuEchange();
				$select = $tabela->select();
                $select->from(array('eu_echange'), array('id_echange', 'cat_echange', 'code_produit', 'montant_echange', 'montant', 'agio', 'date_echange', "to_char((date_echange),'dd/mm/yyyy HH24:mi:ss') as date_echange2"));
				if($ssgrp != ""){
           		$select->where("upper(code_produit) like '%".strtoupper($prd2)."%' ");
				}
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where('code_compte_ech like ?', '%'.$code_membre);
				}
				$select->order('id_echange desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->montant_echange;
            $totsortie+=$row->montant;
            $totsolde+=$row->agio;
							
				$tabelb = new Application_Model_DbTable_EuEchange();
				$selectb = $tabelb->select();
                $selectb->from('eu_echange', array('sum(montant_echange) as somme_echange'));
				$selectb->where('date_echange <= ?', $row->date_echange);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where('code_compte_ech like ?', '%'.$code_membre);
				}
           		if($ssgrp != ""){
           		$selectb->where("upper(code_produit) like '%".strtoupper($prd2)."%' ");
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme_echange;
				/*foreach ($achatb as $rowb) {
					$total_date += $rowb->montant_echange;
				}*/
				
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
              $row->DATE_ECHANGE2,
              $row->cat_echange,
              $row->montant_echange,
              $row->montant,
              $row->code_produit,
              $row->agio,
              $total_date
            );
            $i++;

        $responce['userdata']['code'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;
		
	    }
    }
		
		
		
		
		
		
		
		
	public function cnncAction() {
	
	
	}
	
	
	public function datacnncAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'datefin');
        $sord = $this->_request->getParam("sord", 'desc');
		$code = $this->_request->getParam("code");

		$id_utilisateur = $user->id_utilisateur;
        $code_groupe = trim($user->code_groupe);
        $code_membre = $user->code_membre;

        $ssgrp = (string)$this->_request->getParam('ssgrp');

        $table = new Application_Model_DbTable_EuUtilisateur();
                $select = $table->select();
                $select->where('id_utilisateur = ?', $id_utilisateur);
                $select->where('code_groupe = ?', $ssgrp);
                $Rows = $table->fetchAll($select);
		// && count($Rows) > 0
		if($ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		$sousgroupe = explode("_", $ssgrp);
		
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuCnnc();
				$select = $tabela->select();
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$select->where("code_membre like '%".$code_membre."%' ");
				}
				$select->order('id_cnnc desc');
				$achat = $tabela->fetchAll($select);
				
        $count = count($achat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmontant = 0;
        $totsortie = 0;
        $totsolde = 0;

        foreach ($achats as $row) {
            $totmontant+=$row->mont_credit;
            $totsortie+=$row->mont_utilise;
            $totsolde+=$row->solde;

				$tabelb = new Application_Model_DbTable_EuCnnc();
				$selectb = $tabelb->select();
				$selectb->setIntegrityCheck(false);
                $selectb->from('eu_cnnc', array('sum(mont_utilise) as somme'));
				$selectb->where('datefin <= ?', $row->datefin);
				if($code_groupe != 'detentrice' && $code_groupe != 'surveillance'){
				$selectb->where("code_membre like '%".$code_membre."%' ");
				}
				$achatb = $tabelb->fetchRow($selectb);
				$total_date = $achatb->somme;
				
            $responce['rows'][$i]['id'] = $row->id_cnnc;
            $responce['rows'][$i]['cell'] = array(
              $row->datefin,
              $row->libelle,
              $row->mont_credit,
              $row->mont_utilise,
              $row->solde,
              $total_date
            );
            $i++;

        $responce['userdata']['libelle'] = 'Total:';
        $responce['userdata']['montant_entrer'] = $totmontant;
        $responce['userdata']['montant_sortie'] = $totsortie;
        $responce['userdata']['solde'] = $totsolde;
        $responce['userdata']['total'] = $total_date;
        $this->view->data = $responce;
		}
	}
    
	}
		
		
	public function transfert2Action() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
        $acteur = new Application_Model_EuActeur();
        $acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
		$code_source_create = $acteurRow->code_source_create;
		$code_monde_create = $acteurRow->code_monde_create;
		$code_zone_create = $acteurRow->code_zone_create;
		$id_pays = $acteurRow->id_pays;
		$id_region = $acteurRow->id_region;
		$code_secteur_create = $acteurRow->code_secteur_create;
		$code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != "") {
		   //$sousgroupe = array();fg_nn_achatpm_capa_inr_pre_kit_tec
		   $sousgroupe = explode("_", $this->view->ssgrp);
		
		   if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$this->view->s = $sousgroupe[0];} else {$this->view->s = "";}
		   
		   if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$this->view->nn = $sousgroupe[1];}else{$this->view->nn = "";}
		   
		   if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		
		   if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd = $sousgroupe[3];}else{$this->view->prd = "";}
		   
		   if($this->view->prd != "capa" && $this->view->prd != "nn") {
		    if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		    if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		    if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		    } else {
		      if($this->view->par == "reapropm") {
		      if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		      if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		      if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6]."reappro";}else{$this->view->prk2 = "";}
		    } else {
		      if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		      if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		      if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6];}else{$this->view->prk2 = "";}
		    }
		}

		}
		
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
		if($this->view->prd == "nn" && $this->view->prd2 == "repartition"){
				$tabela = new Application_Model_DbTable_EuDetailAppelNn();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn');
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence') {
				$select->where("eu_detail_appel_nn.code_membre like '%".$this->view->code_membre."%' ");
				} else {
		    $select->join('eu_acteur', 'eu_acteur.code_membre = eu_detail_appel_nn.code_membre');
					
		if($code_source_create != ""){
		   $select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_repartition_nn.date_rep) = '".$_GET['annee']."'");
				$select->where("MONTH(eu_repartition_nn.date_rep) = '".$_GET['mois']."'");
				$select->order(array('eu_detail_appel_nn.code_membre asc', 'eu_repartition_nn.id_rep_nn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				
				$this->view->code = "répartitions";

		}else if($this->view->s == "gsnp") {
			
				$tabela = new Application_Model_DbTable_EuNn();
				//$select = $tabela->select();
				$select = $tabela->select();
				//$select->setIntegrityCheck(false);
                //
				//if($this->view->ssgrp != "") {
				    if($this->view->code_groupe == 'detentrice' ||  $this->view->code_groupe == 'surveillance') {
					  $select->from($tabela, array('id_utilisateur','id_nn', 'code_type_nn', 'emetteur_nn', 'type_emission', 'montant_emis', 'montant_remb', 'solde_nn', "date_emission"));
				      $select->where("eu_nn.code_type_nn like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");
					  $select->where('eu_nn.id_utilisateur is null');
					}    
				//}
				//if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence') {
           		//$select->from($tabela, array('id_nn', 'code_type_nn', 'emetteur_nn', 'type_emission', 'montant_emis', 'montant_remb', 'solde_nn', "date_emission"));
				//$select->where('eu_nn.id_utilisateur like ?', '%'.$this->view->id_utilisateur);
				//} else if(isset($_GET['id_utilisateur']) && $_GET['id_utilisateur'] != "") {
           		//$select->from($tabela, array('id_nn', 'code_type_nn', 'emetteur_nn', 'type_emission', 'montant_emis', 'montant_remb', 'solde_nn', "date_emission"));
				//  $select->where('eu_nn.id_utilisateur like ?', '%'.$_GET['id_utilisateur']);
				//} else {
		        //$select->join('eu_acteur', 'eu_acteur.id_utilisateur = eu_nn.id_utilisateur');
					
		        //if($code_source_create != ""){
		        //$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		        //if($code_monde_create != ""){
		        //$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		        //if($code_zone_create != ""){
		        //$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		        //if($id_pays > 0){
		        //$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		        //if($id_region > 0){
		        //$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		        //if($code_secteur_create != ""){
		        //$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		        //if($code_agence_create != "") {
		        //$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

		//}
		    $annee = $_GET['annee'];
			$select->where('YEAR(eu_nn.date_emission) = ?',$annee);
		    $mois = $_GET['mois'];
			$select->where('MONTH(eu_nn.date_emission) = ?',$mois);
			//$select->order(array('eu_nn.id_utilisateur asc', 'eu_nn.id_nn desc'));
			$this->view->achat = $tabela->fetchAll($select);
			$this->view->select = $select;	
			$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);

		} else {
			
				$tabela = new Application_Model_DbTable_EuTransfertNn();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                //
				if($this->view->ssgrp != ""){
				  $select->where("eu_transfert_nn.code_type_nn like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence') {
           		//$select->from($tabela, array('id_transfert_nn', 'code_type_nn', 'code_compte_transfert', 'code_compte_dist', 'type_transfert', 'mont_transfert', 'mont_vendu', 'solde_transfert', "date_transfert"));
				$select->where('eu_transfert_nn.code_compte_dist like ?', '%'.$this->view->code_membre);
				} else if(isset($_GET['membre']) && $_GET['membre'] != "") {
           		//$select->from($tabela, array('id_transfert_nn', 'code_type_nn', 'code_compte_transfert', 'code_compte_dist', 'type_transfert', 'mont_transfert', 'mont_vendu', 'solde_transfert', "date_transfert"));
				  $select->where('eu_transfert_nn.code_compte_transfert like ?', '%'.$_GET['membre']);
				} else {
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_transfert_nn.code_compte_dist, -20)');
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != "") {
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

		}
		    $annee = $_GET['annee'];
			$select->where('YEAR(eu_transfert_nn.date_transfert) = ?',$annee);
		    $mois = $_GET['mois'];
			$select->where('MONTH(eu_transfert_nn.date_transfert) = ?',$mois);
			//$select->order(array('substr(eu_transfert_nn.code_compte_dist, -20) asc', 'eu_transfert_nn.id_transfert_nn desc'));
			$this->view->achat = $tabela->fetchAll($select);
			$this->view->select = $select;	
			$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
	    }
    }
		








	public function echange2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		$sousgroupe = explode("_", $this->view->ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$this->view->s = $sousgroupe[0];}else{$this->view->s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$this->view->nn = $sousgroupe[1];}else{$this->view->nn = "";}
		if($this->view->nn != "smc" && $this->view->nn != "fn"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd = $sousgroupe[3];}else{$this->view->prd = "";}
		if($this->view->prd != "capa" && $this->view->prd != "nn"){
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		} else {
		if($this->view->par == "reapropm"){
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6]."reappro";}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		} else {
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		}
		}
		
		}else{
		//if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd = $sousgroupe[2];}else{$this->view->prd = "";}
		if($this->view->prd != "creation"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd2 = $sousgroupe[2];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prk = $sousgroupe[3];}else{$this->view->prk = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk2 = $sousgroupe[4];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk3 = $sousgroupe[5];}else{$this->view->prk3 = "";}
		}else{
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		}
			
		}


		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuEchange();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("upper(code_produit) like '%".strtoupper($this->view->prd2)."%' ");
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
                //$select->from(array('eu_echange'), array('id_echange', 'cat_echange', 'code_produit', 'montant_echange', 'code_compte_ech', 'montant', 'agio', "date_echange"));
				$select->where('code_compte_ech like ?', '%'.$this->view->code_membre);
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_echange.code_compte_ech, -20)', array("eu_echange.date_echange"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(date_echange) = '".$_GET['annee']."'");
				$select->where("MONTH(date_echange) = '".$_GET['mois']."'");
				$select->order(array('substr(code_compte_ech, -20) asc', 'id_echange desc'));
				$this->view->achat = $tabela->fetchAll($select);
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2.$this->view->prk3);



}
		






	public function cnnc2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
        $this->view->code_groupe_create = trim($user->code_groupe_create);
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		$sousgroupe = explode("_", $this->view->ssgrp);
		
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuCnnc();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select->where("code_membre like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_cnnc.code_membre');
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				if($sousgroupe[0] == "rpgr"){
				$select->where("libelle like 'RPGr' ");
				}else if($sousgroupe[0] == "ir"){
				$select->where("libelle like 'Ir' ");
				}
				$select->where("YEAR(datefin) = '".$_GET['annee']."' ");
				$select->where("MONTH(datefin) = '".$_GET['mois']."' ");
				$select->order(array('code_membre asc', 'id_cnnc desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
	}


        }
		





	public function debitcredit2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
        $this->view->code_groupe_create = trim($user->code_groupe_create);
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != "") {
		  //$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		  $sousgroupe = explode("_", $this->view->ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$this->view->s = $sousgroupe[0];}else{$this->view->s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$this->view->nn = $sousgroupe[1];}else{$this->view->nn = "";}
		if($this->view->nn != "smc" && $this->view->nn != "fn") {
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd = $sousgroupe[3];}else{$this->view->prd = "";}
		if($this->view->prd != "capa" && $this->view->prd != "nn") {
		  if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		} else {
		if($this->view->par == "reapropm") {
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6]."reappro";}else{$this->view->prk2 = "";}
		  if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		} else {
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6];}else{$this->view->prk2 = "";}
		  if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		}
		}
		
		}else {
		//if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd = $sousgroupe[2];}else{$this->view->prd = "";}
		if($this->view->prd != "creation"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd2 = $sousgroupe[2];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prk = $sousgroupe[3];}else{$this->view->prk = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk2 = $sousgroupe[4];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk3 = $sousgroupe[5];}else{$this->view->prk3 = "";}
		}else{
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		}
			
		}


		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

if($this->view->nn == "nn"){
		if($this->view->prd == "nn" && $this->view->prd2 == "repartition"){
				$tabela = new Application_Model_DbTable_EuDetailAppelNn();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn');
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select->where("eu_detail_appel_nn.code_membre like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_detail_appel_nn.code_membre');
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_repartition_nn.date_rep) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_repartition_nn.date_rep) = '".$_GET['mois']."' ");
				$select->order(array('eu_detail_appel_nn.code_membre asc', 'eu_repartition_nn.id_rep_nn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = "répartitions";

				

		} else {
			
				if(($this->view->code_groupe == 'detentrice' || $this->view->code_groupe == 'surveillance') && !isset($_GET['membre'])){
			
			
			
			
				$tabela = new Application_Model_DbTable_EuDetailSmsmoney();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("type_sms like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
                //$select->from(array('eu_detail_smsmoney'), array('id_detail_smsmoney', 'type_sms', 'creditcode', 'mont_sms', "date_allocation"));
				$select->where("code_membre_dist like '%".$this->view->code_membre."%' ");
				}else if(isset($_GET['membre2']) && $_GET['membre2'] != ""){
                //$select->from(array('eu_detail_smsmoney'), array('id_detail_smsmoney', 'type_sms', 'creditcode', 'mont_sms', "date_allocation"));
				$select->where("code_membre_dist like '%".substr($_GET['membre2'], -20)."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_detail_smsmoney.code_membre_dist, -20)', array());
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("origine_sms like 'TR' ");
				$select->where("YEAR(date_allocation) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_allocation) = '".$_GET['mois']."' ");
				$select->order(array('code_membre_dist asc', 'id_detail_smsmoney desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);

			
				/*}else if(($this->view->code_groupe == 'detentrice' || $this->view->code_groupe == 'surveillance') && isset($_GET['membre']) && $_GET['membre'] != ""){
			
			
				$tabela = new Application_Model_DbTable_EuDetailSmsmoney();
				$select = $tabela->select();
                //$select->from(array('eu_detail_smsmoney'), array('id_detail_smsmoney', 'type_sms', 'creditcode', 'mont_sms', 'date_allocation'));
				if($this->view->ssgrp != ""){
           		$select->where("type_sms like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				//if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'surveillance'){
				$select->where("code_membre_dist like '%".$_GET['membre']."%' ");
				//}
				$select->where("origine_sms like 'tr' ");
				$select->where("YEAR(date_allocation) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_allocation) = '".$_GET['mois']."' ");
				$select->order(array('code_membre asc', 'id_detail_smsmoney desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);*/
				}else{
					
				$tabela = new Application_Model_DbTable_EuSmsmoney();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("motif like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', "datetime"));
				$select->where("fromaccount like '%".$this->view->code_membre."%' ");
				}else if(isset($_GET['membre']) && $_GET['membre'] != ""){
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', "datetime"));
				$select->where("fromaccount like '%".$_GET['membre']."%' ");
				}else if($this->view->code_groupe_create == "personne_physique"){
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', "datetime"));
				$select->where("destaccount_consumed like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_smsmoney.fromaccount, -20)', array("eu_smsmoney.datetime"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(datetimeconsumed) = '".$_GET['annee']."' ");
				$select->where("MONTH(datetimeconsumed) = '".$_GET['mois']."' ");
				$select->order(array('substr(destaccount_consumed, -20) asc', 'neng desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
					}
					
					
		}
}else if($this->view->nn == "cnp"){
				$tabela = new Application_Model_DbTable_EuCnp();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
if($this->view->ssgrp != ""){
	if($this->view->prk == "prk"){
           		$select->where("upper(type_cnp) like '%".strtoupper($this->view->prd2)."%' ");//
           		$select->where("id_credit in (select id_credit from eu_compte_credit where upper(code_produit) like '%".strtoupper($this->view->prd2)."%' and prk = ".$this->view->prk2.")");//
	}else{
           		$select->where("upper(type_cnp) like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
	}
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
                //$select->from(array('eu_cnp'), array('id_cnp', 'type_cnp', 'origine_cnp', 'mont_credit', 'mont_debit', 'solde_cnp',  'source_credit', "date_cnp");
				$select->where("source_credit like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_cnp.source_credit, 0, 20)', array("eu_cnp.date_cnp"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(date_cnp) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_cnp) = '".$_GET['mois']."' ");
				$select->order(array('substr(source_credit, 0, 20) asc', 'id_cnp desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
				
}else if($this->view->nn == "smc"){
				$tabela = new Application_Model_DbTable_EuSmc();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("upper(type_smc) like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
                //$select->from(array('eu_smc'), array('id_smc', 'type_smc', 'origine_smc', 'montant', 'sortie', 'solde',  'source_credit', "date_smc"));
				$select->where("source_credit like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_smc.source_credit, 0, 20)', array("eu_smc.date_smc"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(date_smc) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_smc) = '".$_GET['mois']."' ");
				$select->order(array('substr(source_credit, 0, 20) asc', 'id_smc desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
								
}else if($this->view->nn == "fn"){
				$tabela = new Application_Model_DbTable_EuFn();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_capa', 'eu_capa.code_capa = eu_fn.code_capa');
				if($this->view->ssgrp != ""){
           		$select->where("upper(eu_fn.type_fn) like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
                //$select->from(array('eu_fn'), array('id_fn', 'type_fn', 'montant', 'sortie', 'solde',  "date_fn"));
				//$select->where("eu_capa.code_capa in (select code_capa from eu_capa where code_membre like '%".$this->view->code_membre."%')");
				$select->where("eu_capa.code_membre like '%".$this->view->code_membre."%'");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_capa.code_membre', array("eu_capa.date_fn"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_fn.date_fn) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_fn.date_fn) = '".$_GET['mois']."' ");
				$select->order(array('eu_capa.code_membre asc', 'eu_fn.id_fn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
}
										

        }




		 

	public function mpp2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        $this->view->etat = (string) $this->_request->getParam('etat');

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
        $acteur = new Application_Model_EuActeur();
        $acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
		$code_source_create = $acteurRow->code_source_create;
		$code_monde_create = $acteurRow->code_monde_create;
		$code_zone_create = $acteurRow->code_zone_create;
		$id_pays = $acteurRow->id_pays;
		$id_region = $acteurRow->id_region;
		$code_secteur_create = $acteurRow->code_secteur_create;
		$code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuMembre();
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select = $tabela->select();
                $select->from(array('eu_membre'), array('count(code_membre) as nombre', "date_identification"));
				//$select->where("id_utilisateur = ".$this->view->id_utilisateur." ");
				$select->where("etat_membre = '".$this->view->etat."' ");
				$select->where("YEAR(date_identification) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_identification) = '".$_GET['mois']."' ");
				$select->group("date_identification");
				$select->order(array('date_identification desc'));
				}else{
				$select = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select->setIntegrityCheck(false);
                $select->from($tabela, array());
		$select->columns(array(
           'nombre' => 'count(eu_membre.code_membre)',
           'date_identification'  => 'eu_membre.date_identification'
           ));
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_membre.id_utilisateur', array());//, array('count(eu_membre.code_membre) as nombre', "date_identification")
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		   $select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				$select->where("eu_membre.etat_membre = '".$this->view->etat."' ");
				$select->where("YEAR(eu_membre.date_identification) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_membre.date_identification) = '".$_GET['mois']."' ");
				$select->group("eu_membre.date_identification");
				$select->order(array('eu_membre.date_identification desc'));
				}
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				


        }
		



	public function mpm2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        $this->view->etat = (string) $this->_request->getParam('etat');

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuMembreMorale();
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select = $tabela->select();
                $select->from(array('eu_membre_morale'), array('count(code_membre_morale) as nombre', "date_identification"));
				$select->where("id_utilisateur = ".$this->view->id_utilisateur." ");
				$select->where("etat_membre = '".$this->view->etat."' ");
				$select->where("YEAR(date_identification) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_identification) = '".$_GET['mois']."' ");
				$select->group("date_identification");
				$select->order(array('date_identification desc'));
				}else{
				$select = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select->setIntegrityCheck(false);
                $select->from($tabela, array());
		$select->columns(array(
           'nombre' => 'count(eu_membre_morale.code_membre_morale)',
           'date_identification'  => 'eu_membre_morale.date_identification'
           ));
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_membre_morale.id_utilisateur', array());
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("eu_membre_morale.etat_membre = '".$this->view->etat."' ");
				$select->where("YEAR(eu_membre_morale.date_identification) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_membre_morale.date_identification) = '".$_GET['mois']."' ");
				$select->group("eu_membre_morale.date_identification");
				$select->order(array('eu_membre_morale.date_identification desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				


        }





	public function tdbfs2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuFs();
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select1 = $tabela->select();
				$select1->setIntegrityCheck(false);
                $select1->from(array('eu_fs'), array('count(eu_fs.code_fs) as nombre', "eu_fs.date_fs"));
				$select1->join('eu_membre', 'eu_membre.code_membre = eu_fs.code_membre', array());
				$select1->where("eu_membre.etat_membre = 'N' ");
				$select1->where("eu_fs.id_utilisateur = ".$this->view->id_utilisateur." ");
				$select1->where("YEAR(eu_fs.date_fs) = '".$_GET['annee']."' ");
				$select1->where("MONTH(eu_fs.date_fs) = '".$_GET['mois']."' ");
				$select1->group("eu_fs.date_fs");

				$select2 = $tabela->select();
				$select2->setIntegrityCheck(false);
                $select2->from(array('eu_fs'), array('count(eu_fs.code_fs) as nombre', "eu_fs.date_fs"));
				$select2->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_fs.code_membre_morale', array());
				$select2->where("eu_membre_morale.etat_membre = 'N' ");
				$select2->where("eu_fs.id_utilisateur = ".$this->view->id_utilisateur." ");
				$select2->where("YEAR(eu_fs.date_fs) = '".$_GET['annee']."' ");
				$select2->where("MONTH(eu_fs.date_fs) = '".$_GET['mois']."' ");
				$select2->group("eu_fs.date_fs");

				$select = $tabela->select();
				$select->union(array($select1, $select2));
				$select->order(array('date_fs desc'));
				}else{
				$select1 = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select1->setIntegrityCheck(false);
                $select1->from($tabela, array());
				$select1->columns(array(
				   'nombre' => 'count(eu_fs.code_fs)',
				   'date_fs'  => 'eu_fs.date_fs'
				   ));
				$select1->join('eu_membre', 'eu_membre.code_membre = eu_fs.code_membre', array());
				$select1->where("eu_membre.etat_membre = 'N' ");
				$select1->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_fs.id_utilisateur', array());
				$select1->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
							
				if($code_source_create != ""){
				$select1->where("eu_acteur.code_source_create = ? ", $code_source_create);}
				
				if($code_monde_create != ""){
				$select1->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
				
				if($code_zone_create != ""){
				$select1->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
				
				if($id_pays > 0){
				$select1->where("eu_acteur.id_pays = ? ", $id_pays);}
				
				if($id_region > 0){
				$select1->where("eu_acteur.id_region = ? ", $id_region);}
				
				if($code_secteur_create != ""){
				$select1->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
				
				if($code_agence_create != ""){
				$select1->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}
		
				$select1->where("YEAR(eu_fs.date_fs) = '".$_GET['annee']."' ");
				$select1->where("MONTH(eu_fs.date_fs) = '".$_GET['mois']."' ");
				$select1->group("eu_fs.date_fs");
				
							
				   
				$select2 = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select2->setIntegrityCheck(false);
                $select2->from($tabela, array());
				$select2->columns(array(
				   'nombre' => 'count(eu_fs.code_fs)',
				   'date_fs'  => 'eu_fs.date_fs'
				   ));
				$select2->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_fs.code_membre_morale', array());
				$select2->where("eu_membre_morale.etat_membre = 'N' ");
				$select2->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_fs.id_utilisateur', array());
				$select2->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
							
							
				if($code_source_create != ""){
				$select2->where("eu_acteur.code_source_create = ? ", $code_source_create);}
				
				if($code_monde_create != ""){
				$select2->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
				
				if($code_zone_create != ""){
				$select2->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
				
				if($id_pays > 0){
				$select2->where("eu_acteur.id_pays = ? ", $id_pays);}
				
				if($id_region > 0){
				$select2->where("eu_acteur.id_region = ? ", $id_region);}
				
				if($code_secteur_create != ""){
				$select2->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
				
				if($code_agence_create != ""){
				$select2->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}
		
				$select2->where("YEAR(eu_fs.date_fs) = '".$_GET['annee']."' ");
				$select2->where("MONTH(eu_fs.date_fs) = '".$_GET['mois']."' ");
				$select2->group("eu_fs.date_fs");
				
				   
				   
				$select = $tabela->select();
				$select->union(array($select1, $select2));
				   
							
				$select->order(array('date_fs desc'));
				
				
						}
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				


        }




	public function tdbfl2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuFl();
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select1 = $tabela->select();
				$select1->setIntegrityCheck(false);
                $select1->from(array('eu_fl'), array('count(eu_fl.code_fl) as nombre', "eu_fl.date_fl"));
				$select1->join('eu_membre', 'eu_membre.code_membre = eu_fl.code_membre', array());
				$select1->where("eu_membre.etat_membre = 'N' ");
				$select1->where("eu_fl.id_utilisateur = ".$this->view->id_utilisateur." ");
				$select1->where("YEAR(eu_fl.date_fl) = '".$_GET['annee']."' ");
				$select1->where("MONTH(eu_fl.date_fl) = '".$_GET['mois']."' ");
				$select1->group("eu_fl.date_fl");
				
				
				$select2 = $tabela->select();
				$select2->setIntegrityCheck(false);
                $select2->from(array('eu_fl'), array('count(eu_fl.code_fl) as nombre', "eu_fl.date_fl"));
				$select2->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_fl.code_membre_morale', array());
				$select2->where("eu_membre_morale.etat_membre = 'N' ");
				$select2->where("eu_fl.id_utilisateur = ".$this->view->id_utilisateur." ");
				$select2->where("YEAR(eu_fl.date_fl) = '".$_GET['annee']."' ");
				$select2->where("MONTH(eu_fl.date_fl) = '".$_GET['mois']."' ");
				$select2->group("eu_fl.date_fl");
				
				
				$select = $tabela->select();
				$select->union(array($select1, $select2));
				$select->order(array('date_fl desc'));
				}else{
				$select1 = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select1->setIntegrityCheck(false);
                $select1->from($tabela, array());
				$select1->columns(array(
				   'nombre' => 'count(eu_fl.code_fl)',
				   'date_fl'  => 'eu_fl.date_fl'
				   ));
				$select1->join('eu_membre', 'eu_membre.code_membre = eu_fl.code_membre', array());
				$select1->where("eu_membre.etat_membre = 'N' ");
				$select1->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_fl.id_utilisateur', array());
				$select1->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
							
				if($code_source_create != ""){
				$select1->where("eu_acteur.code_source_create = ? ", $code_source_create);}
				
				if($code_monde_create != ""){
				$select1->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
				
				if($code_zone_create != ""){
				$select1->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
				
				if($id_pays > 0){
				$select1->where("eu_acteur.id_pays = ? ", $id_pays);}
				
				if($id_region > 0){
				$select1->where("eu_acteur.id_region = ? ", $id_region);}
				
				if($code_secteur_create != ""){
				$select1->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
				
				if($code_agence_create != ""){
				$select1->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				$select1->where("YEAR(eu_fl.date_fl) = '".$_GET['annee']."' ");
				$select1->where("MONTH(eu_fl.date_fl) = '".$_GET['mois']."' ");
				$select1->group("eu_fl.date_fl");
				
				
				$select2 = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select2->setIntegrityCheck(false);
                $select2->from($tabela, array());
				$select2->columns(array(
				   'nombre' => 'count(eu_fl.code_fl)',
				   'date_fl'  => 'eu_fl.date_fl'
				   ));
				$select2->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_fl.code_membre_morale', array());
				$select2->where("eu_membre_morale.etat_membre = 'N' ");
				$select2->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_fl.id_utilisateur', array());
				$select2->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
							
				if($code_source_create != ""){
				$select2->where("eu_acteur.code_source_create = ? ", $code_source_create);}
				
				if($code_monde_create != ""){
				$select2->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
				
				if($code_zone_create != ""){
				$select2->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
				
				if($id_pays > 0){
				$select2->where("eu_acteur.id_pays = ? ", $id_pays);}
				
				if($id_region > 0){
				$select2->where("eu_acteur.id_region = ? ", $id_region);}
				
				if($code_secteur_create != ""){
				$select2->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
				
				if($code_agence_create != ""){
				$select2->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				$select2->where("YEAR(eu_fl.date_fl) = '".$_GET['annee']."' ");
				$select2->where("MONTH(eu_fl.date_fl) = '".$_GET['mois']."' ");
				$select2->group("eu_fl.date_fl");
				
				
				   
				$select = $tabela->select();
				$select->union(array($select1, $select2));
				
				$select->order(array('date_fl desc'));
				}
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				


        }




	public function tdbfcps2Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuCartes();
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence'){
				$select = $tabela->select();
                $select->from(array('eu_cartes'), array('count(id_demande) as nombre', 'code_cat', 'date_demande'));
				$select->where("id_utilisateur = ".$this->view->id_utilisateur." ");
				$select->where("YEAR(date_demande) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_demande) = '".$_GET['mois']."' ");
				$select->group("date_demande");
				$select->order(array('date_demande desc'));
				}else{
				$select = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
				$select->setIntegrityCheck(false);
                $select->from($tabela, array());
		$select->columns(array(
			'code_cat',
			'date_demande',
           'nombre' => 'count(eu_cartes.id_demande)',
           'date_demande'  => 'eu_cartes.date_demande'
           ));
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_cartes.id_utilisateur', array());
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur', array());
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_cartes.date_demande) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_cartes.date_demande) = '".$_GET['mois']."' ");
				$select->group(array("eu_cartes.date_demande", "eu_cartes.code_cat"));
				$select->order(array('eu_cartes.date_demande desc', 'eu_cartes.code_cat asc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				


        }



		
		







	public function transfert3Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre_kit_tec
		$sousgroupe = explode("_", $this->view->ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$this->view->s = $sousgroupe[0];}else{$this->view->s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$this->view->nn = $sousgroupe[1];}else{$this->view->nn = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd = $sousgroupe[3];}else{$this->view->prd = "";}
		if($this->view->prd != "capa" && $this->view->prd != "nn"){
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		}else{
		if($this->view->par == "reapropm"){
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6]."reappro";}else{$this->view->prk2 = "";}
		}else{
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6];}else{$this->view->prk2 = "";}
		}
		}

		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

		if($this->view->prd == "nn" && $this->view->prd2 == "repartition"){
				$tabela = new Application_Model_DbTable_EuDetailAppelNn();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn');
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
				$select->where("eu_detail_appel_nn.code_membre like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_detail_appel_nn.code_membre');
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_repartition_nn.date_rep) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_repartition_nn.date_rep) = '".$_GET['mois']."' ");
				$select->order(array('eu_detail_appel_nn.code_membre asc', 'eu_repartition_nn.id_rep_nn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				
				$this->view->code = "répartitions";

		}else{
			
				$tabela = new Application_Model_DbTable_EuTransfertNn();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                //
				if($this->view->ssgrp != ""){
				$select->where("eu_transfert_nn.code_type_nn like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
           		//$select->from($tabela, array('id_transfert_nn', 'code_type_nn', 'code_compte_transfert', 'code_compte_dist', 'type_transfert', 'mont_transfert', 'mont_vendu', 'solde_transfert', "date_transfert"));
				$select->where('eu_transfert_nn.code_compte_dist like ?', '%'.$this->view->code_membre);
				}else if(isset($_GET['membre']) && $_GET['membre'] != ""){
           		//$select->from($tabela, array('id_transfert_nn', 'code_type_nn', 'code_compte_transfert', 'code_compte_dist', 'type_transfert', 'mont_transfert', 'mont_vendu', 'solde_transfert', "date_transfert"));
				$select->where('eu_transfert_nn.code_compte_transfert like ?', '%'.$_GET['membre']);
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_transfert_nn.code_compte_dist, -20)', array("eu_transfert_nn.date_transfert"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_transfert_nn.date_transfert) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_transfert_nn.date_transfert) = '".$_GET['mois']."' ");
				$select->order(array('substr(eu_transfert_nn.code_compte_dist, -20) asc', 'eu_transfert_nn.id_transfert_nn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
	}
        }
		








	public function echange3Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != ""){
		//$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		$sousgroupe = explode("_", $this->view->ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$this->view->s = $sousgroupe[0];}else{$this->view->s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$this->view->nn = $sousgroupe[1];}else{$this->view->nn = "";}
		if($this->view->nn != "smc" && $this->view->nn != "fn"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd = $sousgroupe[3];}else{$this->view->prd = "";}
		if($this->view->prd != "capa" && $this->view->prd != "nn"){
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		}else{
		if($this->view->par == "reapropm"){
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6]."reappro";}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		}else{
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		}
		}
		
		}else{
		//if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd = $sousgroupe[2];}else{$this->view->prd = "";}
		if($this->view->prd != "creation"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd2 = $sousgroupe[2];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prk = $sousgroupe[3];}else{$this->view->prk = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk2 = $sousgroupe[4];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk3 = $sousgroupe[5];}else{$this->view->prk3 = "";}
		}else{
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		}
			
		}


		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$tabela = new Application_Model_DbTable_EuEchange();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("upper(code_produit) like '%".strtoupper($this->view->prd2)."%' ");
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
                //$select->from(array('eu_echange'), array('id_echange', 'cat_echange', 'code_produit', 'montant_echange', 'code_compte_ech', 'montant', 'agio', "date_echange"));
				$select->where('code_compte_ech like ?', '%'.$this->view->code_membre);
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_echange.code_compte_ech, -20)', array("eu_echange.date_echange"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(date_echange) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_echange) = '".$_GET['mois']."' ");
				$select->order(array('substr(code_compte_ech, -20) asc', 'id_echange desc'));
				$this->view->achat = $tabela->fetchAll($select);
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2.$this->view->prk3);



}
		


	public function debitcredit3Action() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

		$this->view->id_utilisateur = $user->id_utilisateur;
        $this->view->code_groupe = trim($user->code_groupe);
        $this->view->code_membre = $user->code_membre;
        $this->view->code_groupe_create = trim($user->code_groupe_create);
		
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($user->code_acteur);
				 $code_source_create = $acteurRow->code_source_create;
				 $code_monde_create = $acteurRow->code_monde_create;
				 $code_zone_create = $acteurRow->code_zone_create;
				 $id_pays = $acteurRow->id_pays;
				 $id_region = $acteurRow->id_region;
				 $code_secteur_create = $acteurRow->code_secteur_create;
				 $code_agence_create = $acteurRow->code_agence_create;

        $date = new Zend_Date();
		if(!isset($_GET['annee'])){$_GET['annee'] = $date->toString('yyyy');}
		if(!isset($_GET['mois'])){$_GET['mois'] = $date->toString('MM');}

        $this->view->ssgrp = (string)$this->_request->getParam('ssgrp');

		if($this->view->ssgrp != "") {
		  //$sousgroupe = array();fg_nn_achatpm_capa_inr_pre
		  $sousgroupe = explode("_", $this->view->ssgrp);
		
		if(isset($sousgroupe[0]) && $sousgroupe[0] != ""){$this->view->s = $sousgroupe[0];}else{$this->view->s = "";}
		if(isset($sousgroupe[1]) && $sousgroupe[1] != ""){$this->view->nn = $sousgroupe[1];}else{$this->view->nn = "";}
		if($this->view->nn != "smc" && $this->view->nn != "fn") {
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd = $sousgroupe[3];}else{$this->view->prd = "";}
		if($this->view->prd != "capa" && $this->view->prd != "nn") {
		  if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		} else {
		if($this->view->par == "reapropm") {
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6]."reappro";}else{$this->view->prk2 = "";}
		  if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		} else {
		  if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prd2 = $sousgroupe[4];}else{$this->view->prd2 = "";}
		  if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk = $sousgroupe[5];}else{$this->view->prk = "";}
		  if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk2 = $sousgroupe[6];}else{$this->view->prk2 = "";}
		  if(isset($sousgroupe[7]) && $sousgroupe[7] != ""){$this->view->prk3 = $sousgroupe[7];}else{$this->view->prk3 = "";}
		}
		}
		
		}else {
		//if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->par = $sousgroupe[2];}else{$this->view->par = "";}
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd = $sousgroupe[2];}else{$this->view->prd = "";}
		if($this->view->prd != "creation"){
		if(isset($sousgroupe[2]) && $sousgroupe[2] != ""){$this->view->prd2 = $sousgroupe[2];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prk = $sousgroupe[3];}else{$this->view->prk = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk2 = $sousgroupe[4];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk3 = $sousgroupe[5];}else{$this->view->prk3 = "";}
		}else{
		if(isset($sousgroupe[3]) && $sousgroupe[3] != ""){$this->view->prd2 = $sousgroupe[3];}else{$this->view->prd2 = "";}
		if(isset($sousgroupe[4]) && $sousgroupe[4] != ""){$this->view->prk = $sousgroupe[4];}else{$this->view->prk = "";}
		if(isset($sousgroupe[5]) && $sousgroupe[5] != ""){$this->view->prk2 = $sousgroupe[5];}else{$this->view->prk2 = "";}
		if(isset($sousgroupe[6]) && $sousgroupe[6] != ""){$this->view->prk3 = $sousgroupe[6];}else{$this->view->prk3 = "";}
		}
			
		}


		}
		
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);

if($this->view->nn == "nn"){
		if($this->view->prd == "nn" && $this->view->prd2 == "repartition"){
				$tabela = new Application_Model_DbTable_EuDetailAppelNn();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn');
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
				$select->where("eu_detail_appel_nn.code_membre like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_detail_appel_nn.code_membre');
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_repartition_nn.date_rep) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_repartition_nn.date_rep) = '".$_GET['mois']."' ");
				$select->order(array('eu_detail_appel_nn.code_membre asc', 'eu_repartition_nn.id_rep_nn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = "répartitions";

				

		} else {
			
				if(($this->view->code_groupe == 'detentrice' || $this->view->code_groupe == 'detentrice_pays' || $this->view->code_groupe == 'detentrice_region' || $this->view->code_groupe == 'detentrice_secteur' || $this->view->code_groupe == 'detentrice_agence' || $this->view->code_groupe == 'surveillance' || $this->view->code_groupe == 'surveillance_pays' || $this->view->code_groupe == 'surveillance_region' || $this->view->code_groupe == 'surveillance_secteur' || $this->view->code_groupe == 'surveillance_agence' || $this->view->code_groupe == 'detentrice_filiere' || $this->view->code_groupe == 'agrement_filiere' || $this->view->code_groupe == 'executante_acnev' || $this->view->code_groupe == 'agrement_acnev') && !isset($_GET['membre'])){
			
			
			
			
				$tabela = new Application_Model_DbTable_EuDetailSmsmoney();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("type_sms like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
                //$select->from(array('eu_detail_smsmoney'), array('id_detail_smsmoney', 'type_sms', 'creditcode', 'mont_sms', "date_allocation"));
				$select->where("code_membre_dist like '%".$this->view->code_membre."%' ");
				}else if(isset($_GET['membre2']) && $_GET['membre2'] != ""){
                //$select->from(array('eu_detail_smsmoney'), array('id_detail_smsmoney', 'type_sms', 'creditcode', 'mont_sms', "date_allocation"));
				$select->where("code_membre_dist like '%".substr($_GET['membre2'], -20)."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_detail_smsmoney.code_membre_dist, -20)', array("eu_detail_smsmoney.date_allocation"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("origine_sms like 'tr' ");
				$select->where("YEAR(date_allocation) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_allocation) = '".$_GET['mois']."' ");
				$select->order(array('code_membre_dist asc', 'id_detail_smsmoney desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);

			
				/*}else if(($this->view->code_groupe == 'detentrice' || $this->view->code_groupe == 'surveillance') && isset($_GET['membre']) && $_GET['membre'] != ""){
			
			
				$tabela = new Application_Model_DbTable_EuDetailSmsmoney();
				$select = $tabela->select();
                //$select->from(array('eu_detail_smsmoney'), array('id_detail_smsmoney', 'type_sms', 'creditcode', 'mont_sms', 'date_allocation'));
				if($this->view->ssgrp != ""){
           		$select->where("type_sms like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				//if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'surveillance'){
				$select->where("code_membre_dist like '%".$_GET['membre']."%' ");
				//}
				$select->where("origine_sms like 'tr' ");
				$select->where("YEAR(date_allocation) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_allocation) = '".$_GET['mois']."' ");
				$select->order(array('code_membre asc', 'id_detail_smsmoney desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);*/
				}else{
					
				$tabela = new Application_Model_DbTable_EuSmsmoney();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("motif like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', "datetime"));
				$select->where("fromaccount like '%".$this->view->code_membre."%' ");
				}else if(isset($_GET['membre']) && $_GET['membre'] != ""){
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', "datetime"));
				$select->where("fromaccount like '%".$_GET['membre']."%' ");
				}else if($this->view->code_groupe_create == "personne_physique"){
                //$select->from(array('eu_smsmoney'), array('neng', 'motif', 'creditcode', 'creditamount', "datetime"));
				$select->where("destaccount_consumed like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_smsmoney.fromaccount, -20)', array("eu_smsmoney.datetime"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(datetimeconsumed) = '".$_GET['annee']."' ");
				$select->where("MONTH(datetimeconsumed) = '".$_GET['mois']."' ");
				$select->order(array('substr(destaccount_consumed, -20) asc', 'neng desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
					}
					
					
		}
}else if($this->view->nn == "cnp"){
				$tabela = new Application_Model_DbTable_EuCnp();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
if($this->view->ssgrp != ""){
	if($this->view->prk == "prk"){
           		$select->where("upper(type_cnp) like '%".strtoupper($this->view->prd2)."%' ");//
           		$select->where("id_credit in (select id_credit from eu_compte_credit where upper(code_produit) like '%".strtoupper($this->view->prd2)."%' and prk = ".$this->view->prk2.")");//
	}else{
           		$select->where("upper(type_cnp) like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
	}
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
                //$select->from(array('eu_cnp'), array('id_cnp', 'type_cnp', 'origine_cnp', 'mont_credit', 'mont_debit', 'solde_cnp',  'source_credit', "date_cnp"));
				$select->where("source_credit like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_cnp.source_credit, 0, 20)', array("eu_cnp.date_cnp"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(date_cnp) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_cnp) = '".$_GET['mois']."' ");
				$select->order(array('substr(source_credit, 0, 20) asc', 'id_cnp desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
				
}else if($this->view->nn == "smc"){
				$tabela = new Application_Model_DbTable_EuSmc();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
				if($this->view->ssgrp != ""){
           		$select->where("upper(type_smc) like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
                //$select->from(array('eu_smc'), array('id_smc', 'type_smc', 'origine_smc', 'montant', 'sortie', 'solde',  'source_credit', "date_smc"));
				$select->where("source_credit like '%".$this->view->code_membre."%' ");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = substr(eu_smc.source_credit, 0, 20)', array("eu_smc.date_smc"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(date_smc) = '".$_GET['annee']."' ");
				$select->where("MONTH(date_smc) = '".$_GET['mois']."' ");
				$select->order(array('substr(source_credit, 0, 20) asc', 'id_smc desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
								
}else if($this->view->nn == "fn"){
				$tabela = new Application_Model_DbTable_EuFn();
				//$select = $tabela->select();
				$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->setIntegrityCheck(false);
                $select->join('eu_capa', 'eu_capa.code_capa = eu_fn.code_capa');
				if($this->view->ssgrp != ""){
           		$select->where("upper(eu_fn.type_fn) like '%".strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2)."%' ");//
				}
				if($this->view->code_groupe != 'detentrice' && $this->view->code_groupe != 'detentrice_pays' && $this->view->code_groupe != 'detentrice_region' && $this->view->code_groupe != 'detentrice_secteur' && $this->view->code_groupe != 'detentrice_agence' && $this->view->code_groupe != 'surveillance' && $this->view->code_groupe != 'surveillance_pays' && $this->view->code_groupe != 'surveillance_region' && $this->view->code_groupe != 'surveillance_secteur' && $this->view->code_groupe != 'surveillance_agence' && $this->view->code_groupe != 'detentrice_filiere' && $this->view->code_groupe != 'agrement_filiere' && $this->view->code_groupe != 'executante_acnev' && $this->view->code_groupe != 'agrement_acnev'){
                //$select->from(array('eu_fn'), array('id_fn', 'type_fn', 'montant', 'sortie', 'solde',  "date_fn"));
				//$select->where("eu_capa.code_capa in (select code_capa from eu_capa where code_membre like '%".$this->view->code_membre."%')");
				$select->where("eu_capa.code_membre like '%".$this->view->code_membre."%'");
				}else{
		$select->join('eu_acteur', 'eu_acteur.code_membre = eu_capa.code_membre', array("eu_fn.date_fn"));
					
		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}

				}
				$select->where("YEAR(eu_fn.date_fn) = '".$_GET['annee']."' ");
				$select->where("MONTH(eu_fn.date_fn) = '".$_GET['mois']."' ");
				$select->order(array('eu_capa.code_membre asc', 'eu_fn.id_fn desc'));
				$this->view->achat = $tabela->fetchAll($select);
				$this->view->select = $select;
				
				$this->view->code = strtoupper($this->view->prd2.$this->view->prk.$this->view->prk2);
}
										

        }







       }
	
	







