<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDeviseMapper
 *
 * @author user
 */
class Application_Model_EuCodebarreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCodebarre');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCodebarre $codebarre) {
        $data = array(
            'codebarre' => $codebarre->getCodebarre(),
            'type_codebar' => $codebarre->getType_codebar(),
            'date_generer' => $codebarre->getDate_generer(),
            'codemembre_four' => $codebarre->getCodemembre_four(),
            'raisonsociale_four' => $codebarre->getRaisonsociale_four(),
            'date_four' => $codebarre->getDate_four(),
            'idutilisateur' => $codebarre->getId_utilisateur(),
            'codemembre_dem' => $codebarre->getCodemembre_dem()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCodebarre $codebarre) {
        $data = array(
            'codebarre' => $codebarre->getCodebarre(),
            'type_codebar' => $codebarre->getType_codebar(),
            'date_generer' => $codebarre->getDate_generer(),
            'codemembre_four' => $codebarre->getCodemembre_four(),
            'raisonsociale_four' => $codebarre->getRaisonsociale_four(),
            'date_four' => $codebarre->getDate_four(),
            'idutilisateur' => $codebarre->getId_utilisateur(),
            'codemembre_dem' => $codebarre->getCodemembre_dem()
        );
        $this->getDbTable()->update($data, array('codebarre = ?' => $codebarre->getCodebarre()));
    }

    public function find($code_barre, Application_Model_EuCodebarre $codebarre) {
        $result = $this->getDbTable()->find($code_barre);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $codebarre->setCodebarre($row->codebarre)
                ->setType_codebar($row->type_codebar)
                ->setDate_generer($row->date_generer)
                ->setCodemembre_four($row->codemembre_four)
                ->setRaisonsociale_four($row->raisonsociale_four)
                ->setDate_four($row->date_four)
                ->setId_utilisateur($row->idutilisateur)
                ->setCodemembre_dem($row->codemembre_dem);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCodebarre();
            $entry->setCodebarre($row->codebarre)
                ->setType_codebar($row->type_codebar)
                ->setDate_generer($row->date_generer)
                ->setCodemembre_four($row->codemembre_four)
                ->setRaisonsociale_four($row->raisonsociale_four)
                ->setDate_four($row->date_four)
                ->setId_utilisateur($row->idutilisateur)
                ->setCodemembre_dem($row->codemembre_dem);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_barre) {
        $this->getDbTable()->delete(array('codebarre = ?' => $code_barre));
    }

}

?>
