 <?php

class Application_Model_EuConfirmationMapper {

    //put your code here
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
            $this->setDbTable('Application_Model_DbTable_EuConfirmation');
        }
        return $this->_dbTable;
    }

	

    public function find($id_requete) {
        $result = $this->getDbTable()->find($id_requete);
        if(0 == count($result)) {
           return false;
        }
        $qrauthrequete = new Application_Model_EuConfirmation();
        $row = $result->current();

              /*  ->setId_requete($row->id_requete)
                ->setCode_membre_client($row->code_membre_client)
		        ->setCode_operateur($row->code_operateur)
                ->setCode_secret_client($row->code_secret_client)
                ->setDaterequete($row->daterequete)
                ->setId_requete($row->id_requete);*/

    $qrauthrequete->setId_confirmation($row->id_confirmation)
                ->setCode_membre($row->code_membre)
                ->setCode_operateur($row->code_operateur)
                ->setNom_operateur($row->nom_operateur)
                ->setData_text($row->data_text)
                ->setData_json($row->data_json)
                ->setActivite($row->activite)
                ->setStatus($row->status)
                ->setDate_creation($row->date_creation)
                ->setDate_confirmation($row->date_confirmation)
                ->setTexte_confirmation($row->texte_confirmation)
                ->setPage($row->page)
                ->setCode_sms($row->code_sms)
                ->setNom_appareil($row->nom_appareil)
                ->setImei_appareil($row->imei_appareil)
                ->setNumero_appareil($row->numero_appareil)
                ->setMac_appareil($row->mac_appareil)
                ->setIp_appareil($row->ip_appareil)
                ->setType_confirmation($row->type_confirmation);



        return $qrauthrequete;
	}
	


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuConfirmation();
            $entry->setId_confirmation($row->id_confirmation)
            ->setCode_membre($row->code_membre)
            ->setCode_operateur($row->code_operateur)
            ->setNom_operateur($row->nom_operateur)
            ->setData_text($row->data_text)
            ->setData_json($row->data_json)
            ->setActivite($row->activite)
            ->setStatus($row->status)
            ->setDate_creation($row->date_creation)
            ->setDate_confirmation($row->date_confirmation)
            ->setTexte_confirmation($row->texte_confirmation)
            ->setPage($row->page)
            ->setCode_sms($row->code_sms)
            ->setNom_appareil($row->nom_appareil)
            ->setImei_appareil($row->imei_appareil)
            ->setNumero_appareil($row->numero_appareil)
            ->setMac_appareil($row->mac_appareil)
            ->setIp_appareil($row->ip_appareil)
            ->setType_confirmation($row->type_confirmation);

            $entries[] = $entry;
        }
        return $entries;
    }
	
	

	
	public  function fetchAllByCouple($code_operateur, $code_membre)  {
		$select = $this->getDbTable()->select();
	    $select->where("code_operateur = ? ", $code_operateur)->where("code_membre = ? ", $code_membre);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuConfirmation();
           $entry->setId_confirmation($row->id_confirmation)
           ->setCode_membre($row->code_membre)
           ->setCode_operateur($row->code_operateur)
           ->setNom_operateur($row->nom_operateur)
           ->setData_text($row->data_text)
           ->setData_json($row->data_json)
           ->setActivite($row->activite)
           ->setStatus($row->status)
           ->setDate_creation($row->date_creation)
           ->setDate_confirmation($row->date_confirmation)
           ->setTexte_confirmation($row->texte_confirmation)
           ->setPage($row->page)
           ->setCode_sms($row->code_sms)
           ->setNom_appareil($row->nom_appareil)
           ->setImei_appareil($row->imei_appareil)
           ->setNumero_appareil($row->numero_appareil)
           ->setMac_appareil($row->mac_appareil)
           ->setIp_appareil($row->ip_appareil)
           ->setType_confirmation($row->type_confirmation);

           $entries[] = $entry;
		  
	    }
		return $entries;
	}
	
	



  /*  public function save(Application_Model_EuConfirmation $qrconfirmationrequete) {
        $data = array(
          //  'id_confirmation' => $qrconfirmationrequete->getId_confirmation(),
            'code_operateur' => $qrconfirmationrequete->getCode_operateur(),
            'code_membre' => $qrconfirmationrequete->getCode_membre(),
            'nom_operateur' => $qrconfirmationrequete->getNom_operateur(),
            'data_text' => $qrconfirmationrequete->getData_text(),
            'data_json' => $qrconfirmationrequete->getData_json(),
            'status' => $qrconfirmationrequete->getStatus(),
            'activite' => $qrconfirmationrequete->getActivite(),
            'date_creation' => $qrconfirmationrequete->getDate_creation(),
            'date_confirmation' => $qrconfirmationrequete->getDate_confirmation(),
            'texte_confirmation' => $qrconfirmationrequete->getTexte_confirmation(),
            'page' => $qrconfirmationrequete->getPage(),

        );

        $this->getDbTable()->insert($data);
    }*/



 /*
    public function save(Application_Model_Qrauth $qrauthrequete) {
        $data = array(
		    'id_requete' => $qrauthrequete->getId_requete(),
			'code_membre_client' => $qrauthrequete->getCode_membre_client(),
            'code_operateur' => $qrauthrequete->getCode_operateur(),
            'code_secret_client' => $qrauthrequete->getCode_secret_client(),
            'daterequete' => $qrauthrequete->getDaterequete()
         //   'id_requete' => $qrauthrequete->getPrix_unitaire()

        );

        $this->getDbTable()->insert($data);
    }
*/


    public function save(Application_Model_EuConfirmation $confirmation) {

        $data = array(
			//"id_confirmation" => $confirmation->getId_confirmation(),
			"code_membre" => $confirmation->getCode_membre(),
			"code_operateur" => $confirmation->getCode_operateur(),
			"nom_operateur" => $confirmation->getNom_operateur(),
			"data_text" => $confirmation->getData_text(),
			"data_json" => $confirmation->getData_json(),
			"activite" => $confirmation->getActivite(),
			"status" => $confirmation->getStatus(),
			"date_creation" => $confirmation->getDate_creation(),
			"date_confirmation" => $confirmation->getDate_confirmation(),
			"texte_confirmation" => $confirmation->getTexte_confirmation(),
			"page" => $confirmation->getPage(),
			"code_sms" => $confirmation->getCode_sms(),
			"nom_appareil" => $confirmation->getNom_appareil(),
			"imei_appareil" => $confirmation->getImei_appareil(),
			"numero_appareil" => $confirmation->getNumero_appareil(),
			"mac_appareil" => $confirmation->getMac_appareil(),
			"ip_appareil" => $confirmation->getIp_appareil(),
			"type_confirmation" => $confirmation->getType_confirmation()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuConfirmation $confirmation) {
/*        $data = array(
            'id_confirmation' => $qrconfirmationrequete->getId_confirmation(),
      //      'code_operateur' => $qrconfirmationrequete->getCode_operateur(),
         //   'code_membre' => $qrconfirmationrequete->getCode_membre(),
         //   'nom_operateur' => $qrconfirmationrequete->getNom_operateur(),
        //    'data_text' => $qrconfirmationrequete->getData_text(),
       //     'data_json' => $qrconfirmationrequete->getData_json(),
            'status' => $qrconfirmationrequete->getStatus(),
          //  'activite' => $qrconfirmationrequete->getActivite(),
           // 'date_creation' => $qrconfirmationrequete->getDate_creation(),
            'date_confirmation' => $qrconfirmationrequete->getDate_confirmation(),
          //  'texte_confirmation' => $qrconfirmationrequete->getTexte_confirmation(),
          //  'page' => $qrconfirmationrequete->getPage(),
        );
*/
    $data = array(
       // "id_confirmation" => $confirmation->getId_confirmation(),
      //  "code_membre" => $confirmation->getCode_membre(),
       // "code_operateur" => $confirmation->getCode_operateur(),
       // "nom_operateur" => $confirmation->getNom_operateur(),
        //"data_text" => $confirmation->getData_text(),
        //"data_json" => $confirmation->getData_json(),
     //   "activite" => $confirmation->getActivite(),
        "status" => $confirmation->getStatus(),
      //  "date_creation" => $confirmation->getDate_creation(),
        "date_confirmation" => $confirmation->getDate_confirmation(),
       // "texte_confirmation" => $confirmation->getTexte_confirmation(),
       // "page" => $confirmation->getPage(),
       // "code_sms" => $confirmation->getCode_sms(),
        "nom_appareil" => $confirmation->getNom_appareil(),
        "imei_appareil" => $confirmation->getImei_appareil(),
        "numero_appareil" => $confirmation->getNumero_appareil(),
        "mac_appareil" => $confirmation->getMac_appareil(),
        "ip_appareil" => $confirmation->getIp_appareil(),
      //  "type_confirmation" => $confirmation->getType_confirmation()
    );
        $this->getDbTable()->update($data, array('id_confirmation = ?' => $confirmation->getId_confirmation()));
    }

	

    public function delete($id_confirmation) {
        $this->getDbTable()->delete(array('id_confirmation = ?' => $id_confirmation));
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_confirmation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    ///////////////////////////////////////////////////////////////

}

?>
