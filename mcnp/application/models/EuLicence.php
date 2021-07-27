<?php

class Application_Model_EuLicence {

    //put your code here
    protected $id_licence;
    protected $num_licence;
    protected $libelle_licence;
    protected $desc_licence;
    protected $date_licence;
    protected $code_membre_morale;
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

    public function getId_licence() {
        return $this->id_licence;
    }

    public function setId_licence($id_licence) {
        $this->id_licence = $id_licence;
        return $this;
    }

    public function getNum_licence() {
        return $this->num_licence;
    }

    public function setNum_licence($num_licence) {
        $this->num_licence = $num_licence;
        return $this;
    }

    public function getDesc_licence() {
        return $this->desc_licence;
    }

    public function setDesc_licence($desc_licence) {
        $this->desc_licence = $desc_licence;
        return $this;
    }

    public function getDate_licence() {
        return $this->date_licence;
    }

    public function setDate_licence($date_licence) {
        $this->date_licence = $date_licence;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    public function getLibelle_licence() {
        return $this->libelle_licence;
    }

    public function setLibelle_licence($libelle_licence) {
        $this->libelle_licence = $libelle_licence;
        return $this;
    }

	
}

?>
