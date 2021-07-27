<?php

class Application_Model_EuLierFiliereCreneau{

    protected $id;
    protected $num_gac_filiere;
    protected $code_creneau;
    protected $date_adhesion;
    protected $heure_adhesion;
    protected $cree_par;

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
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function getCode_creneau() {
        return $this->code_creneau;
    }

    function setCode_creneau($code_creneau) {
        $this->code_creneau = $code_creneau;
        return $this;
    }

    function getNum_gac_filiere() {
        return $this->num_gac_filiere;
    }

    function setNum_gac_filiere($num_gac_filiere) {
        $this->num_gac_filiere = $num_gac_filiere;
        return $this;;
    }

    function getDate_adhesion() {
        return $this->date_adhesion;
    }

    function setDate_adhesion($date_adhesion) {
        $this->date_adhesion = $date_adhesion;
        return $this;
    }

    function getHeure_adhesion() {
        return $this->heure_adhesion;
    }

    function setHeure_adhesion($heure_adhesion) {
        $this->heure_adhesion = $heure_adhesion;
        return $this;
    }

    public function getCree_par() {
        return $this->cree_par;
    }

    public function setCree_par($cree_par) {
        $this->cree_par = $cree_par;
        return $this;
    }

}
