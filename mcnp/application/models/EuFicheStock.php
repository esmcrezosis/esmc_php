<?php

class Application_Model_EuFicheStock {

    //put your code here
    protected $id_fiche_stock;
    protected $nom_article;
    protected $validation_ggsm;
    protected $validation_agent_comptable;
    protected $validation_rsf;
    protected $valid;
    protected $etat;
/*
    `id_fiche_stock` INT(11) NOT NULL AUTO_INCREMENT,
    `nom_article` VARCHAR(50) NULL DEFAULT NULL,
    `validation_ggsm` BIGINT(20) NOT NULL DEFAULT '0',
    `validation_agent_comptable` BIGINT(20) NOT NULL DEFAULT '0',
    `validation_rsf` BIGINT(20) NOT NULL DEFAULT '0',
*/
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

    public function getId_fiche_stock() {
        return $this->id_fiche_stock;
    }

    public function setId_fiche_stock($id_fiche_stock) {
        $this->id_fiche_stock = $id_fiche_stock;
        return $this;
    }
    
    public function getNom_article() {
        return $this->nom_article;
    }

    public function setNom_article($nom_article) {
        $this->nom_article = $nom_article;
        return $this;
    }

    public function getValidation_ggsm() {
        return $this->validation_ggsm;
    }

    public function setValidation_ggsm($validation_ggsm) {
        $this->validation_ggsm = $validation_ggsm;
        return $this;
    }
    
    public function getValidation_agent_comptable() {
        return $this->validation_agent_comptable;
    }

    public function setValidation_agent_comptable($validation_agent_comptable) {
        $this->validation_agent_comptable = $validation_agent_comptable;
        return $this;
    }

        public function getValidation_rsf() {
        return $this->validation_rsf;
    }

    public function setValidation_rsf($validation_rsf) {
        $this->validation_rsf = $validation_rsf;
        return $this;
    }

        
    public function getValid() {
        return $this->valid;
    }

    public function setValid($valid) {
        $this->valid = $valid;
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
