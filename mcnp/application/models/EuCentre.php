<?php

class Application_Model_EuCentre {

    //put your code here
    protected $centre_id;
    protected $centre_libelle;
    protected $centre_ville;
    protected $centre_description;
    protected $centre_quartier;
    protected $id_pays;
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

    public function getCentre_id() {
        return $this->centre_id;
    }

    public function setCentre_id($centre_id) {
        $this->centre_id = $centre_id;
        return $this;
    }

    public function getCentre_description() {
        return $this->centre_description;
    }

    public function setCentre_description($centre_description) {
        $this->centre_description = $centre_description;
        return $this;
    }

    public function getCentre_ville() {
        return ($this->centre_ville);
    }

    public function setCentre_ville($centre_ville) {
        $this->centre_ville = ($centre_ville);
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getCentre_libelle() {
        return ($this->centre_libelle);
    }

    public function setCentre_libelle($centre_libelle) {
        $this->centre_libelle = ($centre_libelle);
        return $this;
    }

    public function getCentre_quartier() {
        return ($this->centre_quartier);
    }

    public function setCentre_quartier($centre_quartier) {
        $this->centre_quartier = ($centre_quartier);
        return $this;
    }
	
	function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	


}

?>
