<?php
 
class Application_Model_EuAttributionUserGroupFormulaire {

    //put your code here
    protected $attribution_user_group_formulaire_id;
    protected $code_groupe_depart;
    protected $formulaire_id;
    protected $code_groupe_arrivee;
    protected $code_groupe_autre;
    protected $etat;

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

    public function getAttribution_user_group_formulaire_id() {
        return $this->attribution_user_group_formulaire_id;
    }

    public function setAttribution_user_group_formulaire_id($attribution_user_group_formulaire_id) {
        $this->attribution_user_group_formulaire_id = $attribution_user_group_formulaire_id;
        return $this;
    }


    public function getCode_groupe_depart() {
        return ($this->code_groupe_depart);
    }

    public function setCode_groupe_depart($code_groupe_depart) {
        $this->code_groupe_depart = ($code_groupe_depart);
        return $this;
    }

    public function getFormulaire_id() {
        return ($this->formulaire_id);
    }

    public function setFormulaire_id($formulaire_id) {
        $this->formulaire_id = ($formulaire_id);
        return $this;
    }


    public function getCode_groupe_arrivee() {
        return $this->code_groupe_arrivee;
    }

    public function setCode_groupe_arrivee($code_groupe_arrivee) {
        $this->code_groupe_arrivee = $code_groupe_arrivee;
        return $this;
    }

    public function getCode_groupe_autre() {
        return $this->code_groupe_autre;
    }

    public function setCode_groupe_autre($code_groupe_autre) {
        $this->code_groupe_autre = $code_groupe_autre;
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
