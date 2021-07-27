<?php

class Application_Model_EuFactureSmcipn {

    protected $code_facture;
    protected $code_membre_morale;
    protected $date_facture;
    protected $mont_facture;
    protected $etat_facture;
    protected $type_facture;
    protected $code_smcipn;
    protected $id_utilisateur;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
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

    function getCode_facture() {
        return $this->code_facture;
    }

    function setCode_facture($code_facture) {
        $this->code_facture = $code_facture;
        return $this;
    }

    function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    function getDate_facture() {
        return $this->date_facture;
    }

    function setDate_facture($date_facture) {
        $this->date_facture = $date_facture;
        return $this;
    }

    function getMont_facture() {
        return $this->mont_facture;
    }

    function setMont_facture($mont_facture) {
        $this->mont_facture = $mont_facture;
        return $this;
    }

    function getEtat_facture() {
        return $this->etat_facture;
    }

    function setEtat_facture($etat_facture) {
        $this->etat_facture = $etat_facture;
        return $this;
    }
    
    function getType_facture() {
        return $this->type_facture;
    }

    function setType_facture($type_facture) {
        $this->type_facture = $type_facture;
        return $this;
    }
    
    function getCode_smcipn() {
        return $this->code_smcipn;
    }

    function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

}
