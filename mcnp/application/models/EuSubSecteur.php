<?php

class Application_Model_EuSubSecteur {

    protected $id_sub_secteur;
    protected $nom_sub_secteur;
    protected $code_secteur;
	protected $code_agence;

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

    function getId_sub_secteur() {
        return $this->id_sub_secteur;
    }

    function setId_sub_secteur($id_sub_secteur) {
        $this->id_sub_secteur = $id_sub_secteur;
        return $this;
    }

    function getNom_sub_secteur() {
        return $this->nom_sub_secteur;
    }

    function setNom_sub_secteur($nom_sub_secteur) {
      $this->nom_sub_secteur = $nom_sub_secteur;
      return $this;
    }

    function getCode_secteur() {
        return $this->code_secteur;
    }

    function setCode_secteur($code_secteur) {
        $this->code_secteur = $code_secteur;
        return $this;
    }

    function getCode_agence() {
        return $this->code_agence;
    }

    function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	

}

