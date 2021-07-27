<?php

class Application_Model_EuGcpPrelever {

    protected $id_prelevement;
    protected $code_membre;
    protected $code_tegc;
    protected $id_gcp;
    protected $id_operation;
    protected $mont_prelever;
    protected $mont_rapprocher;
    protected $solde_prelevement;
    protected $date_prelevement;
    protected $heure_prelevement;
    protected $id_tpagcp;
    protected $rapprocher;
    protected $id_credit;
    protected $source_credit;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    function getId_prelevement() {
        return $this->id_prelevement;
    }

    function setId_prelevement($id_prelevement) {
        $this->id_prelevement = $id_prelevement;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getCode_tegc() {
        return $this->code_tegc;
    }

    function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }

    public function getId_gcp() {
        return $this->id_gcp;
    }

    public function setId_gcp($id_gcp) {
        $this->id_gcp = $id_gcp;
        return $this;
    }

    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    public function getMont_prelever() {
        return $this->mont_prelever;
    }

    public function setMont_prelever($mont_prelever) {
        $this->mont_prelever = $mont_prelever;
        return $this;
    }

    public function getDate_prelevement() {
        return $this->date_prelevement;
    }

    public function setDate_prelevement($date_prelevement) {
        $this->date_prelevement = $date_prelevement;
        return $this;
    }

    public function getHeure_prelevement() {
        return $this->heure_prelevement;
    }

    public function setHeure_prelevement($heure_prelevement) {
        $this->heure_prelevement = $heure_prelevement;
        return $this;
    }

    public function getId_tpagcp() {
        return $this->id_tpagcp;
    }

    public function setId_tpagcp($id_tpagcp) {
        $this->id_tpagcp = $id_tpagcp;
        return $this;
    }

    public function getMont_rapprocher() {
        return $this->mont_rapprocher;
    }

    public function setMont_rapprocher($mont_rapprocher) {
        $this->mont_rapprocher = $mont_rapprocher;
        return $this;
    }

    public function getSolde_prelevement() {
        return $this->solde_prelevement;
    }

    public function setSolde_prelevement($solde_prelevement) {
        $this->solde_prelevement = $solde_prelevement;
        return $this;
    }

    public function getRapprocher() {
        return $this->rapprocher;
    }

    public function setRapprocher($rapprocher) {
        $this->rapprocher = $rapprocher;
        return $this;
    }

    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getSource_credit() {
        return $this->source_credit;
    }

    public function setSource_credit($source_credit) {
        $this->source_credit = $source_credit;
        return $this;
    }

}

?>
