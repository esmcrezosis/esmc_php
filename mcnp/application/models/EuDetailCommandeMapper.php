<?php
class Application_Model_EuDetailCommandeMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (NULL === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuDetailCommande');
        }
        return $this->_dbTable;
    }
    public function find($id_detail_commande, Application_Model_EuDetailCommande $commande) {
        $result = $this->getDbTable()->find($id_detail_commande);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $commande->setId_detail_commande($row->id_detail_commande)
                    ->setCode_commande($row->code_commande)
                    ->setQte($row->qte)
                    ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                    ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuDetailCommande $commande){
        $data = array(
            'id_detail_commande' => $commande->getId_detail_commande(),
            'code_commande' => $commande->getCode_commande(),
            'qte' => $commande->getQte(),
            'prix_unitaire' => $commande->getPrix_unitaire(),
            'reference' => $commande->getReference(),
            'designation' => $commande->getDesignation(),
            'livrer' => $commande->getLivrer(),
            'remise' => $commande->getRemise(),
            'prepayer' => $commande->getPrepayer(),
            'commander' => $commande->getCommander(),
            'code_barre' => $commande->getCode_barre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailCommande $commande) {
        $data = array(
            'id_detail_commande' => $commande->getId_detail_commande(),
            'code_commande' => $commande->getCode_commande(),
            'qte' => $commande->getQte(),
            'prix_unitaire' => $commande->getPrix_unitaire(),
            'reference' => $commande->getReference(),
            'designation' => $commande->getDesignation(),
            'livrer' => $commande->getLivrer(),
            'remise' => $commande->getRemise(),
            'prepayer' => $commande->getPrepayer(),
            'commander' => $commande->getCommander(),
            'code_barre' => $commande->getCode_barre()
        );
        $this->getDbTable()->update($data, array('id_detail_commande = ?' => $commande->getId_detail_commande()));
    }
    
    public function delete($id_detail_commande,$code_commande) {
        $this->getDbTable()->delete(array('id_detail_commande = ?' => $id_detail_commande));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_commande) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function fetchAllByCommander($code_membre_vendeur = "", $designation = "", $date_debut = "", $date_fin = "", $commander = 0) {
        $select = $this->getDbTable()->select();
        if($code_membre_vendeur != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE code_membre_vendeur LIKE '".$code_membre_vendeur."')");
        }
        if($designation != ""){
        $select->where("reference LIKE '%".$designation."%'");
        }
        if($date_debut != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande BETWEEN '".$date_debut."' AND '".$date_fin."')");
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE executer = 1)");
        if($commander == 0){
        $select->where("commander = ".$commander."");
        }else{
        $select->where("commander >= ".$commander."");        
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllByCommanderEnligne($code_membre_vendeur = "", $designation = "", $date_debut = "", $date_fin = "", $commander = "", $enligne = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_vendeur != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE code_membre_vendeur LIKE '".$code_membre_vendeur."')");
        }
        if($designation != ""){
        $select->where("reference LIKE '%".$designation."%'");
        }
        if($date_debut != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande BETWEEN '".$date_debut."' AND '".$date_fin."')");
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE executer = 1)");
        if($commander == 0){
        $select->where("commander = ".$commander."");
        }else{
        $select->where("commander >= ".$commander."");        
        }
        if($enligne != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE enligne = ".$enligne.")");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllByCommander0($code_membre_vendeur = "", $designation = "", $date_debut = "", $date_fin = "", $commander = 0) {
        $select = $this->getDbTable()->select();
        if($code_membre_vendeur != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE code_membre_vendeur LIKE '".$code_membre_vendeur."')");
        }
        if($designation != ""){
        $select->where("reference LIKE '%".$designation."%'");
        }
        if($date_debut != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande BETWEEN '".$date_debut."' AND '".$date_fin."')");
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE executer = 1)");
        if($commander == 0){
        $select->where("commander = ".$commander."");
        }else{
        $select->where("commander >= ".$commander."");        
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE enligne = 0)");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function fetchAllByCommander1($code_membre_vendeur = "", $designation = "", $date_debut = "", $date_fin = "", $commander = 0) {
        $select = $this->getDbTable()->select();
        if($code_membre_vendeur != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE code_membre_vendeur LIKE '".$code_membre_vendeur."')");
        }
        if($designation != ""){
        $select->where("reference LIKE '%".$designation."%'");
        }
        if($date_debut != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande BETWEEN '".$date_debut."' AND '".$date_fin."')");
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE executer = 1)");
        if($commander == 0){
        $select->where("commander = ".$commander."");
        }else{
        $select->where("commander >= ".$commander."");        
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE enligne = 1)");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
	

	public function fetchAllByCommandeTegc($code_membre_vendeur,$code_tegc,$date_debut,$date_fin,$commander)  {
		$date_fin = new Zend_Date($date_fin);
		$date_fin->addDay(1);
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->join('eu_commande', 'eu_commande.code_commande = eu_detail_commande.code_commande');
		//$select->join('eu_article_stockes', 'eu_article_stockes.reference = eu_detail_commande.reference');
		
		if($code_membre_vendeur != "")  {
			$select->where('eu_commande.code_membre_vendeur like ?',$code_membre_vendeur);
		}
		
		$select->where('eu_commande.type_bon like ?',"BAN");
		
		
		if($code_tegc != "") {
		   //$select->where('eu_article_stockes.categorie like ?',$code_tegc);
		   //$select->where('eu_article_stockes.categorie like ?',"%TEGCP30010010010010000003M00128%");
		   
		  /*
		  if($code_tegc  != "TEGCP60010010010010000003M00136") {
		     $select->where('eu_article_stockes.categorie like ?',$code_tegc);
		  } else {
			 $select->where('eu_article_stockes.categorie like ?','TEGCP30010010010010000003M00128');					
		  }
		  */
		}
		
		$select->where('(eu_commande.date_commande >= ?',$date_debut)
		       ->where('eu_commande.date_commande <= ?)',$date_fin->toString('yyyy-MM-dd'));
		$select->where('eu_commande.executer = ?',1);
		$select->where("eu_detail_commande.livrer = ?",0);
		//$select->where("eu_detail_commande.reference <> ?","FSMS");
		
		
		
		$resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                  ->setReference($row->reference)
                  ->setDesignation($row->designation)
                  ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                  ->setPrepayer($row->prepayer)
                  ->setCode_barre($row->code_barre)
                  ->setCommander($row->commander);
            $entries[] = $entry;
        }
        return $entries;
	}
	


    public function fetchAllByCommandeTegcOLD($code_membre_vendeur = "", $code_tegc = "", $date_debut = "", $date_fin = "", $commander = "") {
        $select = $this->getDbTable()->select();
        if($code_membre_vendeur != "") {
           $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE code_membre_vendeur LIKE '".$code_membre_vendeur."')");
        }
        if($code_tegc != "") {
           $select->where("reference IN (SELECT reference FROM eu_article_stockes WHERE categorie LIKE '".$code_tegc."')");
        }
		
		/*
        if($date_debut != "") {
          $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande BETWEEN '".$date_debut."' AND '".$date_fin."')");
        }
		*/
		
		$select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande >= '".$date_debut."')");
		$select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande <= '".$date_fin."')");
		
		//$select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande <= '".$date_fin->toString('yyyy-MM-dd')."')");
		
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE executer = 1)");
        
		/* if($commander == "") {	
        } else if($commander == 0) {
           $select->where("commander = ".$commander."");
        } else if($commander > 0) {
           $select->where("commander >= ".$commander."");        
        }
		*/
		
		$select->where("livrer = ?",0);
		
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
		
    }
	
	


    public function fetchAllByCommanderSelect($code_membre_vendeur = "", $designation = "", $date_debut = "", $date_fin = "", $commander = 0) {
        $select = $this->getDbTable()->select();
        if($code_membre_vendeur != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE code_membre_vendeur LIKE '".$code_membre_vendeur."')");
        }
        if($designation != ""){
        $select->where("reference LIKE '%".$designation."%'");
        }
        if($date_debut != ""){
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE date_commande BETWEEN '".$date_debut."' AND '".$date_fin."')");
        }
        $select->where("code_commande IN (SELECT code_commande FROM eu_commande WHERE executer = 1)");
        if($commander == 0){
        $select->where("commander = ".$commander."");
        }else{
        $select->where("commander >= ".$commander."");        
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        /*$entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }*/
        return $select;
    }




    public function fetchAllByDetailCommande($code_commande = 0) {
        $select = $this->getDbTable()->select();
        if($code_commande != "") {
        $select->where("code_commande = ?", $code_commande);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ->setCommander($row->commander)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }







    public function fetchAllByCommande($code_commande) {
        $select = $this->getDbTable()->select();
        $select->where("code_commande = ? ", $code_commande);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCommande();
            $entry->setId_detail_commande($row->id_detail_commande)
                  ->setCode_commande($row->code_commande)  
                  ->setQte($row->qte)
                  ->setPrix_unitaire($row->prix_unitaire)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setLivrer($row->livrer)
                  ->setRemise($row->remise)
                    ->setPrepayer($row->prepayer)
                    ->setCode_barre($row->code_barre)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }






}
