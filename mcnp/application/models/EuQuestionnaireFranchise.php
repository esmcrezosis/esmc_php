<?php

class Application_Model_EuQuestionnaireFranchise {

    //put your asso here
    protected $id_questionnaire_franchise;
    protected $designation;
    protected $code_membre;
    protected $type_membre;
    protected $type_acteur;
    protected $avec_intermediaire;
    protected $sans_intermediaire;
    protected $avec_abonne;
    protected $sans_abonne;
    protected $filiere_biens;
    protected $filiere_produits;
    protected $filiere_services;
    protected $avec_stock;
    protected $sans_stock;
    protected $vente_enligne;
    protected $accord_partenariat;
    protected $cm_soi;
    protected $cm_tiers;
    protected $cm_tiers_opi;
    protected $cm_tiers_bps;
    protected $kit_su_tic;
    protected $kit_su_finance;
    protected $kit_su_protection;
    protected $kit_su_bcr;
    protected $kit_t_tic;
    protected $kit_t_finance;
    protected $kit_t_protection;
    protected $kit_t_bcr;
    protected $te_interim;
    protected $te_utilisateur_ppc_op;
    protected $te_utilisateur_ppc_ot;
    protected $te_utilisateur_pp;
    protected $franchise;
    protected $caution;
    protected $eli_bai_anticipe;
    protected $eli_opi_anticipe;
    protected $eli_ban_anticipe;
    protected $achat_vente_reciproque;
    protected $budget_nature;
    protected $id_utilisateur;
    protected $date_creation;
    protected $etat;




    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId_questionnaire_franchise() {
        return $this->id_questionnaire_franchise;
    }

    public function setId_questionnaire_franchise($id_questionnaire_franchise) {
        $this->id_questionnaire_franchise = $id_questionnaire_franchise;
        return $this;
    }


    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
        return $this;
    }


    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }


    public function getType_membre() {
        return $this->type_membre;
    }

    public function setType_membre($type_membre) {
        $this->type_membre = $type_membre;
        return $this;
    }


    public function getType_acteur() {
        return $this->type_acteur;
    }

    public function setType_acteur($type_acteur) {
        $this->type_acteur = $type_acteur;
        return $this;
    }


    public function getAvec_intermediaire() {
        return $this->avec_intermediaire;
    }

    public function setAvec_intermediaire($avec_intermediaire) {
        $this->avec_intermediaire = $avec_intermediaire;
        return $this;
    }


    public function getSans_intermediaire() {
        return $this->sans_intermediaire;
    }

    public function setSans_intermediaire($sans_intermediaire) {
        $this->sans_intermediaire = $sans_intermediaire;
        return $this;
    }


    public function getAvec_abonne() {
        return $this->avec_abonne;
    }

    public function setAvec_abonne($avec_abonne) {
        $this->avec_abonne = $avec_abonne;
        return $this;
    }


    public function getSans_abonne() {
        return $this->sans_abonne;
    }

    public function setSans_abonne($sans_abonne) {
        $this->sans_abonne = $sans_abonne;
        return $this;
    }


    public function getFiliere_biens() {
        return $this->filiere_biens;
    }

    public function setFiliere_biens($filiere_biens) {
        $this->filiere_biens = $filiere_biens;
        return $this;
    }


    public function getFiliere_produits() {
        return $this->filiere_produits;
    }

    public function setFiliere_produits($filiere_produits) {
        $this->filiere_produits = $filiere_produits;
        return $this;
    }


    public function getFiliere_services() {
        return $this->filiere_services;
    }

    public function setFiliere_services($filiere_services) {
        $this->filiere_services = $filiere_services;
        return $this;
    }


    public function getAvec_stock() {
        return $this->avec_stock;
    }

    public function setAvec_stock($avec_stock) {
        $this->avec_stock = $avec_stock;
        return $this;
    }


    public function getSans_stock() {
        return $this->sans_stock;
    }

    public function setSans_stock($sans_stock) {
        $this->sans_stock = $sans_stock;
        return $this;
    }


    public function getVente_enligne() {
        return $this->vente_enligne;
    }

    public function setVente_enligne($vente_enligne) {
        $this->vente_enligne = $vente_enligne;
        return $this;
    }


    public function getAccord_partenariat() {
        return $this->accord_partenariat;
    }

    public function setAccord_partenariat($accord_partenariat) {
        $this->accord_partenariat = $accord_partenariat;
        return $this;
    }


    public function getCm_soi() {
        return $this->cm_soi;
    }

    public function setCm_soi($cm_soi) {
        $this->cm_soi = $cm_soi;
        return $this;
    }


    public function getCm_tiers() {
        return $this->cm_tiers;
    }

    public function setCm_tiers($cm_tiers) {
        $this->cm_tiers = $cm_tiers;
        return $this;
    }


    public function getCm_tiers_opi() {
        return $this->cm_tiers_opi;
    }

    public function setCm_tiers_opi($cm_tiers_opi) {
        $this->cm_tiers_opi = $cm_tiers_opi;
        return $this;
    }


    public function getCm_tiers_bps() {
        return $this->cm_tiers_bps;
    }

    public function setCm_tiers_bps($cm_tiers_bps) {
        $this->cm_tiers_bps = $cm_tiers_bps;
        return $this;
    }


    public function getKit_su_tic() {
        return $this->kit_su_tic;
    }

    public function setKit_su_tic($kit_su_tic) {
        $this->kit_su_tic = $kit_su_tic;
        return $this;
    }


    public function getKit_su_finance() {
        return $this->kit_su_finance;
    }

    public function setKit_su_finance($kit_su_finance) {
        $this->kit_su_finance = $kit_su_finance;
        return $this;
    }


    public function getKit_su_protection() {
        return $this->kit_su_protection;
    }

    public function setKit_su_protection($kit_su_protection) {
        $this->kit_su_protection = $kit_su_protection;
        return $this;
    }


    public function getKit_su_bcr() {
        return $this->kit_su_bcr;
    }

    public function setKit_su_bcr($kit_su_bcr) {
        $this->kit_su_bcr = $kit_su_bcr;
        return $this;
    }


    public function getKit_t_tic() {
        return $this->kit_t_tic;
    }

    public function setKit_t_tic($kit_t_tic) {
        $this->kit_t_tic = $kit_t_tic;
        return $this;
    }


    public function getKit_t_finance() {
        return $this->kit_t_finance;
    }

    public function setKit_t_finance($kit_t_finance) {
        $this->kit_t_finance = $kit_t_finance;
        return $this;
    }


    public function getKit_t_protection() {
        return $this->kit_t_protection;
    }

    public function setKit_t_protection($kit_t_protection) {
        $this->kit_t_protection = $kit_t_protection;
        return $this;
    }


    public function getKit_t_bcr() {
        return $this->kit_t_bcr;
    }

    public function setKit_t_bcr($kit_t_bcr) {
        $this->kit_t_bcr = $kit_t_bcr;
        return $this;
    }


    public function getTe_interim() {
        return $this->te_interim;
    }

    public function setTe_interim ($te_interim) {
        $this->te_interim = $te_interim;
        return $this;
    }


    public function getTe_utilisateur_ppc_op() {
        return $this->te_utilisateur_ppc_op;
    }

    public function setTe_utilisateur_ppc_op($te_utilisateur_ppc_op) {
        $this->te_utilisateur_ppc_op = $te_utilisateur_ppc_op;
        return $this;
    }


    public function getTe_utilisateur_ppc_ot() {
        return $this->te_utilisateur_ppc_ot;
    }

    public function setTe_utilisateur_ppc_ot($te_utilisateur_ppc_ot) {
        $this->te_utilisateur_ppc_ot = $te_utilisateur_ppc_ot;
        return $this;
    }


    public function getTe_utilisateur_pp() {
        return $this->te_utilisateur_pp;
    }

    public function setTe_utilisateur_pp($te_utilisateur_pp) {
        $this->te_utilisateur_pp = $te_utilisateur_pp;
        return $this;
    }


    public function getFranchise() {
        return $this->franchise;
    }

    public function setFranchise($franchise) {
        $this->franchise = $franchise;
        return $this;
    }


    public function getCaution() {
        return $this->caution;
    }

    public function setCaution($caution) {
        $this->caution = $caution;
        return $this;
    }


    public function getEli_bai_anticipe() {
        return $this->eli_bai_anticipe;
    }

    public function setEli_bai_anticipe($eli_bai_anticipe) {
        $this->eli_bai_anticipe = $eli_bai_anticipe;
        return $this;
    }


    public function getEli_opi_anticipe() {
        return $this->eli_opi_anticipe;
    }

    public function setEli_opi_anticipe($eli_opi_anticipe) {
        $this->eli_opi_anticipe = $eli_opi_anticipe;
        return $this;
    }


    public function getEli_ban_anticipe() {
        return $this->eli_ban_anticipe;
    }

    public function setEli_ban_anticipe($eli_ban_anticipe) {
        $this->eli_ban_anticipe = $eli_ban_anticipe;
        return $this;
    }


    public function getAchat_vente_reciproque() {
        return $this->achat_vente_reciproque;
    }

    public function setAchat_vente_reciproque($achat_vente_reciproque) {
        $this->achat_vente_reciproque = $achat_vente_reciproque;
        return $this;
    }


    public function getBudget_nature() {
        return $this->budget_nature;
    }

    public function setBudget_nature($budget_nature) {
        $this->budget_nature = $budget_nature;
        return $this;
    }


    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }


    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }


    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }


}

?>
