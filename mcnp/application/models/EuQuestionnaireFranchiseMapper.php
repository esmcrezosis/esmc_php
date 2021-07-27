<?php

class Application_Model_EuQuestionnaireFranchiseMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQuestionnaireFranchise');
        }
        return $this->_dbTable;
    }

    public function find($id_questionnaire_franchise, Application_Model_EuQuestionnaireFranchise $questionnaire_franchise) {
        $result = $this->getDbTable()->find($id_questionnaire_franchise);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $questionnaire_franchise->setId_questionnaire_franchise($row->id_questionnaire_franchise)
                ->setDesignation($row->designation)
                ->setCode_membre($row->code_membre)
                ->setType_membre($row->type_membre)
                ->setType_acteur($row->type_acteur)
                ->setAvec_intermediaire($row->avec_intermediaire)
                ->setSans_intermediaire($row->sans_intermediaire)
                ->setAvec_abonne($row->avec_abonne)
                ->setSans_abonne($row->sans_abonne)
                ->setFiliere_biens($row->filiere_biens)
                ->setFiliere_produits($row->filiere_produits)
                ->setFiliere_services($row->filiere_services)
                ->setAvec_stock($row->avec_stock)
                ->setSans_stock($row->sans_stock)
                ->setVente_enligne($row->vente_enligne)
                ->setAccord_partenariat($row->accord_partenariat)
                ->setCm_soi($row->cm_soi)
                ->setCm_tiers($row->cm_tiers)
                ->setCm_tiers_opi($row->cm_tiers_opi)
                ->setCm_tiers_bps($row->cm_tiers_bps)
                ->setKit_su_tic($row->kit_su_tic)
                ->setKit_su_finance($row->kit_su_finance)
                ->setKit_su_protection($row->kit_su_protection)
                ->setKit_su_bcr($row->kit_su_bcr)
                ->setKit_t_tic($row->kit_t_tic)
                ->setKit_t_finance($row->kit_t_finance)
                ->setKit_t_protection($row->kit_t_protection)
                ->setKit_t_bcr($row->kit_t_bcr)
                ->setTe_interim($row->te_interim)
                ->setTe_utilisateur_ppc_op($row->te_utilisateur_ppc_op)
                ->setTe_utilisateur_ppc_ot($row->te_utilisateur_ppc_ot)
                ->setTe_utilisateur_pp($row->te_utilisateur_pp)
                ->setFranchise($row->franchise)
                ->setCaution($row->caution)
                ->setEli_bai_anticipe($row->eli_bai_anticipe)
                ->setEli_opi_anticipe($row->eli_opi_anticipe)
                ->setEli_ban_anticipe($row->eli_ban_anticipe)
                ->setAchat_vente_reciproque($row->achat_vente_reciproque)
                ->setBudget_nature($row->budget_nature)
                ->setId_utilisateur($row->id_utilisateur)
                ->setDate_creation($row->date_creation)
                ->setEtat($row->etat)
                ;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionnaireFranchise();
            $entry->setId_questionnaire_franchise($row->id_questionnaire_franchise)
                ->setDesignation($row->designation)
                ->setCode_membre($row->code_membre)
                ->setType_membre($row->type_membre)
                ->setType_acteur($row->type_acteur)
                ->setAvec_intermediaire($row->avec_intermediaire)
                ->setSans_intermediaire($row->sans_intermediaire)
                ->setAvec_abonne($row->avec_abonne)
                ->setSans_abonne($row->sans_abonne)
                ->setFiliere_biens($row->filiere_biens)
                ->setFiliere_produits($row->filiere_produits)
                ->setFiliere_services($row->filiere_services)
                ->setAvec_stock($row->avec_stock)
                ->setSans_stock($row->sans_stock)
                ->setVente_enligne($row->vente_enligne)
                ->setAccord_partenariat($row->accord_partenariat)
                ->setCm_soi($row->cm_soi)
                ->setCm_tiers($row->cm_tiers)
                ->setCm_tiers_opi($row->cm_tiers_opi)
                ->setCm_tiers_bps($row->cm_tiers_bps)
                ->setKit_su_tic($row->kit_su_tic)
                ->setKit_su_finance($row->kit_su_finance)
                ->setKit_su_protection($row->kit_su_protection)
                ->setKit_su_bcr($row->kit_su_bcr)
                ->setKit_t_tic($row->kit_t_tic)
                ->setKit_t_finance($row->kit_t_finance)
                ->setKit_t_protection($row->kit_t_protection)
                ->setKit_t_bcr($row->kit_t_bcr)
                ->setTe_interim($row->te_interim)
                ->setTe_utilisateur_ppc_op($row->te_utilisateur_ppc_op)
                ->setTe_utilisateur_ppc_ot($row->te_utilisateur_ppc_ot)
                ->setTe_utilisateur_pp($row->te_utilisateur_pp)
                ->setFranchise($row->franchise)
                ->setCaution($row->caution)
                ->setEli_bai_anticipe($row->eli_bai_anticipe)
                ->setEli_opi_anticipe($row->eli_opi_anticipe)
                ->setEli_ban_anticipe($row->eli_ban_anticipe)
                ->setAchat_vente_reciproque($row->achat_vente_reciproque)
                ->setBudget_nature($row->budget_nature)
                ->setId_utilisateur($row->id_utilisateur)
                ->setDate_creation($row->date_creation)
                ->setEtat($row->etat)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_questionnaire_franchise) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuQuestionnaireFranchise $questionnaire_franchise) {
        $data = array(
            'id_questionnaire_franchise' => $questionnaire_franchise->getId_questionnaire_franchise(),
            'designation' => $questionnaire_franchise->getDesignation(),
            'code_membre' => $questionnaire_franchise->getCode_membre(),
            'type_membre' => $questionnaire_franchise->getType_membre(),
            'type_acteur' => $questionnaire_franchise->getType_acteur(),
            'avec_intermediaire' => $questionnaire_franchise->getAvec_intermediaire(),
            'sans_intermediaire' => $questionnaire_franchise->getSans_intermediaire(),
            'avec_abonne' => $questionnaire_franchise->getAvec_abonne(),
            'sans_abonne' => $questionnaire_franchise->getSans_abonne(),
            'filiere_biens' => $questionnaire_franchise->getFiliere_biens(),
            'filiere_produits' => $questionnaire_franchise->getFiliere_produits(),
            'filiere_services' => $questionnaire_franchise->getFiliere_services(),
            'avec_stock' => $questionnaire_franchise->getAvec_stock(),
            'sans_stock' => $questionnaire_franchise->getSans_stock(),
            'vente_enligne' => $questionnaire_franchise->getVente_enligne(),
            'accord_partenariat' => $questionnaire_franchise->getAccord_partenariat(),
            'cm_soi' => $questionnaire_franchise->getCm_soi(),
            'cm_tiers' => $questionnaire_franchise->getCm_tiers(),
            'cm_tiers_opi' => $questionnaire_franchise->getCm_tiers_opi(),
            'cm_tiers_bps' => $questionnaire_franchise->getCm_tiers_bps(),
            'kit_su_tic' => $questionnaire_franchise->getKit_su_tic(),
            'kit_su_finance' => $questionnaire_franchise->getKit_su_finance(),
            'kit_su_protection' => $questionnaire_franchise->getKit_su_protection(),
            'kit_su_bcr' => $questionnaire_franchise->getKit_su_bcr(),
            'kit_t_tic' => $questionnaire_franchise->getKit_t_tic(),
            'kit_t_finance' => $questionnaire_franchise->getKit_t_finance(),
            'kit_t_protection' => $questionnaire_franchise->getKit_t_protection(),
            'kit_t_bcr' => $questionnaire_franchise->getKit_t_bcr(),
            'te_interim' => $questionnaire_franchise->getTe_interim(),
            'te_utilisateur_ppc_op' => $questionnaire_franchise->getTe_utilisateur_ppc_op(),
            'te_utilisateur_ppc_ot' => $questionnaire_franchise->getTe_utilisateur_ppc_ot(),
            'te_utilisateur_pp' => $questionnaire_franchise->getTe_utilisateur_pp(),
            'franchise' => $questionnaire_franchise->getFranchise(),
            'caution' => $questionnaire_franchise->getCaution(),
            'eli_bai_anticipe' => $questionnaire_franchise->getEli_bai_anticipe(),
            'eli_opi_anticipe' => $questionnaire_franchise->getEli_opi_anticipe(),
            'eli_ban_anticipe' => $questionnaire_franchise->getEli_ban_anticipe(),
            'achat_vente_reciproque' => $questionnaire_franchise->getAchat_vente_reciproque(),
            'budget_nature' => $questionnaire_franchise->getBudget_nature(),
            'id_utilisateur' => $questionnaire_franchise->getId_utilisateur(),
            'date_creation' => $questionnaire_franchise->getDate_creation(),
            'etat' => $questionnaire_franchise->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuQuestionnaireFranchise $questionnaire_franchise) {
        $data = array(
            'id_questionnaire_franchise' => $questionnaire_franchise->getId_questionnaire_franchise(),
            'designation' => $questionnaire_franchise->getDesignation(),
            'code_membre' => $questionnaire_franchise->getCode_membre(),
            'type_membre' => $questionnaire_franchise->getType_membre(),
            'type_acteur' => $questionnaire_franchise->getType_acteur(),
            'avec_intermediaire' => $questionnaire_franchise->getAvec_intermediaire(),
            'sans_intermediaire' => $questionnaire_franchise->getSans_intermediaire(),
            'avec_abonne' => $questionnaire_franchise->getAvec_abonne(),
            'sans_abonne' => $questionnaire_franchise->getSans_abonne(),
            'filiere_biens' => $questionnaire_franchise->getFiliere_biens(),
            'filiere_produits' => $questionnaire_franchise->getFiliere_produits(),
            'filiere_services' => $questionnaire_franchise->getFiliere_services(),
            'avec_stock' => $questionnaire_franchise->getAvec_stock(),
            'sans_stock' => $questionnaire_franchise->getSans_stock(),
            'vente_enligne' => $questionnaire_franchise->getVente_enligne(),
            'accord_partenariat' => $questionnaire_franchise->getAccord_partenariat(),
            'cm_soi' => $questionnaire_franchise->getCm_soi(),
            'cm_tiers' => $questionnaire_franchise->getCm_tiers(),
            'cm_tiers_opi' => $questionnaire_franchise->getCm_tiers_opi(),
            'cm_tiers_bps' => $questionnaire_franchise->getCm_tiers_bps(),
            'kit_su_tic' => $questionnaire_franchise->getKit_su_tic(),
            'kit_su_finance' => $questionnaire_franchise->getKit_su_finance(),
            'kit_su_protection' => $questionnaire_franchise->getKit_su_protection(),
            'kit_su_bcr' => $questionnaire_franchise->getKit_su_bcr(),
            'kit_t_tic' => $questionnaire_franchise->getKit_t_tic(),
            'kit_t_finance' => $questionnaire_franchise->getKit_t_finance(),
            'kit_t_protection' => $questionnaire_franchise->getKit_t_protection(),
            'kit_t_bcr' => $questionnaire_franchise->getKit_t_bcr(),
            'te_interim' => $questionnaire_franchise->getTe_interim(),
            'te_utilisateur_ppc_op' => $questionnaire_franchise->getTe_utilisateur_ppc_op(),
            'te_utilisateur_ppc_ot' => $questionnaire_franchise->getTe_utilisateur_ppc_ot(),
            'te_utilisateur_pp' => $questionnaire_franchise->getTe_utilisateur_pp(),
            'franchise' => $questionnaire_franchise->getFranchise(),
            'caution' => $questionnaire_franchise->getCaution(),
            'eli_bai_anticipe' => $questionnaire_franchise->getEli_bai_anticipe(),
            'eli_opi_anticipe' => $questionnaire_franchise->getEli_opi_anticipe(),
            'eli_ban_anticipe' => $questionnaire_franchise->getEli_ban_anticipe(),
            'achat_vente_reciproque' => $questionnaire_franchise->getAchat_vente_reciproque(),
            'budget_nature' => $questionnaire_franchise->getBudget_nature(),
            'id_utilisateur' => $questionnaire_franchise->getId_utilisateur(),
            'date_creation' => $questionnaire_franchise->getDate_creation(),
            'etat' => $questionnaire_franchise->getEtat()
        );
        $this->getDbTable()->update($data, array('id_questionnaire_franchise = ?' => $questionnaire_franchise->getId_questionnaire_franchise()));
    }

    public function delete($id_questionnaire_franchise) {
        $this->getDbTable()->delete(array('id_questionnaire_franchise = ?' => $id_questionnaire_franchise));
    }




    public function fetchAllByUtilisateur($id_utilisateur) {
        $select = $this->getDbTable()->select();
        $select->where("id_utilisateur = ? ", $id_utilisateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionnaireFranchise();
            $entry->setId_questionnaire_franchise($row->id_questionnaire_franchise)
                ->setDesignation($row->designation)
                ->setCode_membre($row->code_membre)
                ->setType_membre($row->type_membre)
                ->setType_acteur($row->type_acteur)
                ->setAvec_intermediaire($row->avec_intermediaire)
                ->setSans_intermediaire($row->sans_intermediaire)
                ->setAvec_abonne($row->avec_abonne)
                ->setSans_abonne($row->sans_abonne)
                ->setFiliere_biens($row->filiere_biens)
                ->setFiliere_produits($row->filiere_produits)
                ->setFiliere_services($row->filiere_services)
                ->setAvec_stock($row->avec_stock)
                ->setSans_stock($row->sans_stock)
                ->setVente_enligne($row->vente_enligne)
                ->setAccord_partenariat($row->accord_partenariat)
                ->setCm_soi($row->cm_soi)
                ->setCm_tiers($row->cm_tiers)
                ->setCm_tiers_opi($row->cm_tiers_opi)
                ->setCm_tiers_bps($row->cm_tiers_bps)
                ->setKit_su_tic($row->kit_su_tic)
                ->setKit_su_finance($row->kit_su_finance)
                ->setKit_su_protection($row->kit_su_protection)
                ->setKit_su_bcr($row->kit_su_bcr)
                ->setKit_t_tic($row->kit_t_tic)
                ->setKit_t_finance($row->kit_t_finance)
                ->setKit_t_protection($row->kit_t_protection)
                ->setKit_t_bcr($row->kit_t_bcr)
                ->setTe_interim($row->te_interim)
                ->setTe_utilisateur_ppc_op($row->te_utilisateur_ppc_op)
                ->setTe_utilisateur_ppc_ot($row->te_utilisateur_ppc_ot)
                ->setTe_utilisateur_pp($row->te_utilisateur_pp)
                ->setFranchise($row->franchise)
                ->setCaution($row->caution)
                ->setEli_bai_anticipe($row->eli_bai_anticipe)
                ->setEli_opi_anticipe($row->eli_opi_anticipe)
                ->setEli_ban_anticipe($row->eli_ban_anticipe)
                ->setAchat_vente_reciproque($row->achat_vente_reciproque)
                ->setBudget_nature($row->budget_nature)
                ->setId_utilisateur($row->id_utilisateur)
                ->setDate_creation($row->date_creation)
                ->setEtat($row->etat)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    

}


?>
