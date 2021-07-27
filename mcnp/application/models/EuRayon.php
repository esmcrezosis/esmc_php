<?php
class Application_Model_EuRayon {
    protected $code_rayon;
    protected $code_bout;
    protected $proprietaire_rayon;
    protected $design_rayon;
    protected $telephone;
    protected $adresse;
    protected $creer_par;

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
    
    function getCode_rayon() {
        return $this->code_rayon;
    }

    function setCode_rayon($code_rayon) {
        $this->code_rayon = $code_rayon;
        return $this;
    }

    function getCode_bout() {
        return $this->code_bout;
    }

    function setCode_bout($code_bout) {
        $this->code_bout = $code_bout;
        return $this;
    }

    function getProprietaire_rayon() {
        return $this->proprietaire_rayon;
    }

    function setProprietaire_rayon($proprietaire_rayon) {
        $this->proprietaire_rayon = $proprietaire_rayon;
        return $this;
    }

    function getDesign_rayon() {
        return $this->design_rayon;
    }

    function setDesign_rayon($design_rayon) {
        $this->design_rayon = $design_rayon;
        return $this;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }
    
    function getCreer_par() {
        return $this->creer_par;
    }

    function setCreer_par($creer_par) {
        $this->creer_par = $creer_par;
        return $this;
    }
}
?>

