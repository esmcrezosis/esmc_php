<?php
 
class Application_Model_EuCaracteristique {

    //put your code here
    protected $caracteristique_id;
    protected $caracteristique_type;
    protected $caracteristique_table_id;
    protected $caracteristique_libelle;
    protected $caracteristique_description;
    protected $caracteristique_date;
    protected $caracteristique_fichier;
    protected $caracteristique_table;
    protected $publier;

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

    public function getCaracteristique_id() {
        return $this->caracteristique_id;
    }

    public function setCaracteristique_id($caracteristique_id) {
        $this->caracteristique_id = $caracteristique_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }
	
    public function getCaracteristique_type() {
        return $this->caracteristique_type;
    }

    public function setCaracteristique_type($caracteristique_type) {
        $this->caracteristique_type = $caracteristique_type;
        return $this;
    }


    public function getCaracteristique_table_id() {
        return $this->caracteristique_table_id;
    }

    public function setCaracteristique_table_id($caracteristique_table_id) {
        $this->caracteristique_table_id = $caracteristique_table_id;
        return $this;
    }
	
    public function getCaracteristique_libelle() {
        return $this->caracteristique_libelle;
    }

    public function setCaracteristique_libelle($caracteristique_libelle) {
        $this->caracteristique_libelle = $caracteristique_libelle;
        return $this;
    }

    public function getCaracteristique_description() {
        return $this->caracteristique_description;
    }

    public function setCaracteristique_description($caracteristique_description) {
        $this->caracteristique_description = $caracteristique_description;
        return $this;
    }

    public function getCaracteristique_date() {
        return $this->caracteristique_date;
    }

    public function setCaracteristique_date($caracteristique_date) {
        $this->caracteristique_date = $caracteristique_date;
        return $this;
    }

    public function getCaracteristique_fichier() {
        return $this->caracteristique_fichier;
    }

    public function setCaracteristique_fichier($caracteristique_fichier) {
        $this->caracteristique_fichier = $caracteristique_fichier;
        return $this;
    }

    public function getCaracteristique_table() {
        return $this->caracteristique_table;
    }

    public function setCaracteristique_table($caracteristique_table) {
        $this->caracteristique_table = $caracteristique_table;
        return $this;
    }


}

?>
