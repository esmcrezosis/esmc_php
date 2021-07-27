<?php

class Application_Model_EuPlacementMapper
{
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
            $this->setDbTable('Application_Model_DbTable_EuPlacement');
        }
        return $this->_dbTable;
    }
    
    public function find($num_placement, Application_Model_EuPlacement $placement) {
        $result = $this->getDbTable()->find($num_placement);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $placement->setNum_placement($row->num_placement)
                ->setMembre($row->membre)
                ->setProduit($row->produit)
                ->setAgence($row->agence)
                ->setCaisse($row->caisse)
                ->getHeure_placement($row->heure_placement)
                ->setMontant_placement($row->montant_placement)
                ->getDate_placement($row->date_placement);
    }
    
    public function fetchAllByUser($user) {
        $select = $this->getDbTable()->select();
        $select->where('caisse=?', $user)
                ->order('date_placement', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPlacement();
            $entry->setNum_placement($row->num_placement);
                $entry->setMembre($row->membre);
                $entry->setProduit($row->produit);
                $entry->setAgence($row->agence);
                $entry->setCaisse($row->caisse);
                $entry->setMontant_placement($row->montant_placement);
                $entry->setHeure_placement($row->heure_placement);
                $entry->setDate_placement($row->date_placement);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuPlacement $placement) {
        $data = array(
            'num_placement' => $placement->getNum_placement(),
            'membre' => $placement->getMembre(),
            'produit' => $placement->getProduit(),
            'montant_placement' => $placement->getMontant_placement(),
            'date_placement' => $placement->getDate_placement(),
            'heure_placement' => $placement->getHeure_placement(),
            'agence' => $placement->getAgence(),
            'caisse' => $placement->getCaisse()
        );

        $this->getDbTable()->insert($data);
    }
    
     public function update(Application_Model_EuPlacement $placement) {
        $data = array(
            'num_placement' => $placement->getNum_placement(),
            'membre' => $placement->getMembre(),
            'produit' => $placement->getProduit(),
            'montant_placement' => $placement->getMontant_placement(),
            'date_placement' => $placement->getDate_placement(),
            'heure_placement' => $placement->getHeure_placement(),
            'agence' => $placement->getAgence(),
            'caisse' => $placement->getCaisse()
        );
        
        $this->getDbTable()->update($data, array('num_placement = ?' => $placement->getNum_placement()));
    }
    
     public function delete($num_placement) {
        $this->getDbTable()->delete(array('num_placement = ?' => $num_placement));
    }


}

