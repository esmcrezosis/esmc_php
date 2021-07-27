<?php

class Application_Model_EuBonEntreeStock {

    //put your code here
    protected $id_bon_entree_stock;
    protected $reference_bon_entree_stock;
    protected $libelle_bon_entree_stock;
    protected $date_bon_entree_stock;
    protected $rejet;
    protected $valider_up;
    protected $valider_down;
    protected $valid;
    protected $etat;

/*
CREATE TABLE `eu_bon_entree_stock` (
    `id_bon_entree_stock` INT(11) NOT NULL AUTO_INCREMENT,
    `reference_bon_entree_stock` VARCHAR(50) NULL DEFAULT NULL,
    `date_bon_entree_stock` DATETIME NOT NULL,
    `rejet` INT(11) NOT NULL,
    `valid_up` INT(11) NOT NULL,
    `valid_down` INT(11) NOT NULL,
    PRIMARY KEY (`id_bon_entree_stock`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
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

    public function getId_bon_entree_stock() {
        return $this->id_bon_entree_stock;
    }

    public function setId_bon_entree_stock($id_bon_entree_stock) {
        $this->id_bon_entree_stock = $id_bon_entree_stock;
        return $this;
    }
    
    public function getReference_bon_entree_stock() {
        return $this->reference_bon_entree_stock;
    }

    public function setReference_bon_entree_stock($reference_bon_entree_stock) {
        $this->reference_bon_entree_stock = $reference_bon_entree_stock;
        return $this;
    }
    
    public function getLibelle_bon_entree_stock() {
        return $this->libelle_bon_entree_stock;
    }

    public function setLibelle_bon_entree_stock($libelle_bon_entree_stock) {
        $this->libelle_bon_entree_stock = $libelle_bon_entree_stock;
        return $this;
    }

    public function getDate_bon_entree_stock() {
        return $this->date_bon_entree_stock;
    }

    public function setDate_bon_entree_stock($date_bon_entree_stock) {
        $this->date_bon_entree_stock = $date_bon_entree_stock;
        return $this;
    }
      
    public function getRejet() {
        return $this->rejet;
    }

    public function setRejet($rejet) {
        $this->rejet = $rejet;
        return $this;
    }
    
    public function getValider_up() {
        return $this->valider_up;
    }

    public function setValider_up($valider_up) {
        $this->valider_up = $valider_up;
        return $this;
    }
    
    public function getValider_down() {
        return $this->valider_down;
    }

    public function setValider_down($valider_down) {
        $this->valider_down = $valider_down;
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
