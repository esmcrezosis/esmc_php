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












}
