<?php

class Application_Model_EuSmcipn {

    protected $code_smcipn;
    protected $lib_demande;
    protected $code_membre;
    protected $desc_demande;
    protected $req_demande;
    protected $date_demande;
    protected $heure_demande;
    protected $date_deb;
    protected $date_fin;
    protected $date_alloc;
    protected $dvm_demande;
    protected $montant_salaire;
    protected $montant_investis;
    protected $etat_demande_inv;
    protected $etat_demande_sal;
    protected $id_utilisateur;
    protected $source_demande;
    protected $valid_gac;
    protected $valid_fil;
    protected $valid_creneau;
    protected $alloc_gac_inv;
    protected $alloc_gac_sal;
    protected $alloc_fil_inv;
    protected $alloc_fil_sal;
    protected $alloc_creneau_inv;
    protected $alloc_creneau_sal;
    protected $type_objet;
    protected $code_gac;
    protected $domicilier;
    protected $rembourser;
    protected $type_smcipn;
    protected $salaire_alloue;
    protected $investis_alloue;
    protected $allouer_i;
    protected $allouer_s;
    protected $type_alloc;
    protected $sal_transmis;
    protected $etat_sal;

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

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getLib_demande() {
        return $this->lib_demande;
    }

    public function setLib_demande($lib_demande) {
        $this->lib_demande = $lib_demande;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getDesc_demande() {
        return $this->desc_demande;
    }

    public function setDesc_demande($desc_demande) {
        $this->desc_demande = $desc_demande;
        return $this;
    }

    public function getReq_demande() {
        return $this->req_demande;
    }

    public function setReq_demande($req_demande) {
        $this->req_demande = $req_demande;
        return $this;
    }

    public function getDate_demande() {
        return $this->date_demande;
    }

    public function setDate_demande($date_demande) {
        $this->date_demande = $date_demande;
        return $this;
    }

    public function getHeure_demande() {
        return $this->heure_demande;
    }

    public function setHeure_demande($heure_demande) {
        $this->heure_demande = $heure_demande;
        return $this;
    }

    public function getDate_deb() {
        return $this->date_deb;
    }

    public function setDate_deb($date_deb) {
        $this->date_deb = $date_deb;
        return $this;
    }

    public function getDate_fin() {
        return $this->date_fin;
    }

    public function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }

    public function getDate_alloc() {
        return $this->date_alloc;
    }

    public function setDate_alloc($date_alloc) {
        $this->date_alloc = $date_alloc;
        return $this;
    }

    public function getDvm_demande() {
        return $this->dvm_demande;
    }

    public function setDvm_demande($dvm_demande) {
        $this->dvm_demande = $dvm_demande;
        return $this;
    }

    public function getMontant_salaire() {
        return $this->montant_salaire;
    }

    public function setMontant_salaire($montant_salaire) {
        $this->montant_salaire = $montant_salaire;
        return $this;
    }

    public function getMontant_investis() {
        return $this->montant_investis;
    }

    public function setMontant_investis($montant_investis) {
        $this->montant_investis = $montant_investis;
        return $this;
    }

    public function getEtat_demande_inv() {
        return $this->etat_demande_inv;
    }

    public function setEtat_demande_inv($etat_demande_inv) {
        $this->etat_demande_inv = $etat_demande_inv;
        return $this;
    }

    public function getEtat_demande_sal() {
        return $this->etat_demande_sal;
    }

    public function setEtat_demande_sal($etat_demande_sal) {
        $this->etat_demande_sal = $etat_demande_sal;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getSource_demande() {
        return $this->source_demande;
    }

    public function setSource_demande($source_demande) {
        $this->source_demande = $source_demande;
        return $this;
    }

    public function getValid_gac() {
        return $this->valid_gac;
    }

    public function setValid_gac($valid_gac) {
        $this->valid_gac = $valid_gac;
        return $this;
    }

    public function getValid_fil() {
        return $this->valid_fil;
    }

    public function setValid_fil($valid_fil) {
        $this->valid_fil = $valid_fil;
        return $this;
    }

    public function getValid_creneau() {
        return $this->valid_creneau;
    }

    public function setValid_creneau($valid_creneau) {
        $this->valid_creneau = $valid_creneau;
        return $this;
    }

    public function getAlloc_gac_inv() {
        return $this->alloc_gac_inv;
    }

    public function setAlloc_gac_inv($alloc_gac_inv) {
        $this->alloc_gac_inv = $alloc_gac_inv;
        return $this;
    }

    public function getAlloc_gac_sal() {
        return $this->alloc_gac_sal;
    }

    public function setAlloc_gac_sal($alloc_gac_sal) {
        $this->alloc_gac_sal = $alloc_gac_sal;
        return $this;
    }

    public function getAlloc_fil_inv() {
        return $this->alloc_fil_inv;
    }

    public function setAlloc_fil_inv($alloc_fil_inv) {
        $this->alloc_fil_inv = $alloc_fil_inv;
        return $this;
    }

    public function getAlloc_fil_sal() {
        return $this->alloc_fil_sal;
    }

    public function setAlloc_fil_sal($alloc_fil_sal) {
        $this->alloc_fil_sal = $alloc_fil_sal;
        return $this;
    }

    public function getAlloc_creneau_inv() {
        return $this->alloc_creneau_inv;
    }

    public function setAlloc_creneau_inv($alloc_creneau_inv) {
        $this->alloc_creneau_inv = $alloc_creneau_inv;
        return $this;
    }

    public function getAlloc_creneau_sal() {
        return $this->alloc_creneau_sal;
    }

    public function setAlloc_creneau_sal($alloc_creneau_sal) {
        $this->alloc_creneau_sal = $alloc_creneau_sal;
        return $this;
    }

    public function getType_objet() {
        return $this->type_objet;
    }

    public function setType_objet($type_objet) {
        $this->type_objet = $type_objet;
        return $this;
    }

    public function getCode_gac() {
        return $this->code_gac;
    }

    public function setCode_gac($code_gac) {
        $this->code_gac = $code_gac;
        return $this;
    }

    public function getDomicilier() {
        return $this->domicilier;
    }

    public function setDomicilier($domicilier) {
        $this->domicilier = $domicilier;
        return $this;
    }

    public function getRembourser() {
        return $this->rembourser;
    }

    public function setRembourser($rembourser) {
        $this->rembourser = $rembourser;
        return $this;
    }

    public function getType_smcipn() {
        return $this->type_smcipn;
    }

    public function setType_smcipn($type_smcipn) {
        $this->type_smcipn = $type_smcipn;
        return $this;
    }

    public function getSalaire_alloue() {
        return $this->salaire_alloue;
    }

    public function setSalaire_alloue($salaire_alloue) {
        $this->salaire_alloue = $salaire_alloue;
        return $this;
    }

    public function getInvestis_alloue() {
        return $this->investis_alloue;
    }

    public function setInvestis_alloue($investis_alloue) {
        $this->investis_alloue = $investis_alloue;
        return $this;
    }

    public function getAllouer_i() {
        return $this->allouer_i;
    }

    public function setAllouer_i($allouer_i) {
        $this->allouer_i = $allouer_i;
        return $this;
    }

    public function getAllouer_s() {
        return $this->allouer_s;
    }

    public function setAllouer_s($allouer_s) {
        $this->allouer_s = $allouer_s;
        return $this;
    }

    public function getType_alloc() {
        return $this->type_alloc;
    }

    public function setType_alloc($type_alloc) {
        $this->type_alloc = $type_alloc;
        return $this;
    }

    public function getSal_transmis() {
        return $this->sal_transmis;
    }

    public function setSal_transmis($sal_transmis) {
        $this->sal_transmis = $sal_transmis;
        return $this;
    }

    public function getEtat_sal() {
        return $this->etat_sal;
    }

    public function setEtat_sal($etat_sal) {
        $this->etat_sal = $etat_sal;
        return $this;
    }

}

?>
