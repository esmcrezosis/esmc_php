<?php
 
class Application_Model_EuAttributionUtilisateurFormulaire {

    //put your code here
    protected $attribution_utilisateur_formulaire_id;
    protected $procedure_id;
    protected $formulaire_id;
    protected $centrale_id;
    protected $id_utilisateur;
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

    public function getAttribution_utilisateur_formulaire_id() {
        return $this->attribution_utilisateur_formulaire_id;
    }

    public function setAttribution_utilisateur_formulaire_id($attribution_utilisateur_formulaire_id) {
        $this->attribution_utilisateur_formulaire_id = $attribution_utilisateur_formulaire_id;
        return $this;
    }


    public function getProcedure_id() {
        return ($this->procedure_id);
    }

    public function setProcedure_id($procedure_id) {
        $this->procedure_id = ($procedure_id);
        return $this;
    }

    public function getFormulaire_id() {
        return ($this->formulaire_id);
    }

    public function setFormulaire_id($formulaire_id) {
        $this->formulaire_id = ($formulaire_id);
        return $this;
    }


    public function getCentrale_id() {
        return $this->centrale_id;
    }

    public function setCentrale_id($centrale_id) {
        $this->centrale_id = $centrale_id;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
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
