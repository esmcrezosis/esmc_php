<?php

class Application_Model_EuDomaineActivite {

    //put your code here
    protected $id_domaine;
    protected $lib_domaine;
    protected $desc_domaine;
    protected $date_creation;
    protected $id_utilisateur;

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

    public function getId_domaine() {
        return $this->id_domaine;
    }

    public function setId_domaine($id_domaine) {
        $this->id_domaine = $id_domaine;
        return $this;
    }

    public function getLib_domaine() {
        return $this->lib_domaine;
    }

    public function setLib_domaine($lib_domaine) {
        $this->lib_domaine = $lib_domaine;
        return $this;
    }

    public function getDesc_domaine() {
        return $this->desc_domaine;
    }

    public function setDesc_domaine($desc_domaine) {
        $this->desc_domaine = $desc_domaine;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

}

?>
