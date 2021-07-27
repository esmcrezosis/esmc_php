<?php

class Application_Model_EuProposition {

    //put your code here
    protected $id_proposition;
    protected $id_appel_offre;
    protected $id_utilisateur;
    protected $date_creation;
    protected $disponible;
    protected $code_membre_morale;
    protected $montant_proposition;
    protected $choix_proposition;
    protected $montant_salaire;
    protected $autre_budget;
    protected $preselection;

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

    public function getId_proposition() {
        return $this->id_proposition;
    }

    public function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }

    public function getId_appel_offre() {
        return $this->id_appel_offre;
    }

    public function setId_appel_offre($id_appel_offre) {
        $this->id_appel_offre = $id_appel_offre;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    public function getDisponible() {
        return $this->disponible;
    }

    public function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }

    public function getMontant_proposition() {
        return $this->montant_proposition;
    }

    public function setMontant_proposition($montant_proposition) {
        $this->montant_proposition = $montant_proposition;
        return $this;
    }


    public function getChoix_proposition() {
        return $this->choix_proposition;
    }

    public function setChoix_proposition($choix_proposition) {
        $this->choix_proposition = $choix_proposition;
        return $this;
    }

    public function getMontant_salaire() {
        return $this->montant_salaire;
    }

    public function setMontant_salaire($montant_salaire) {
        $this->montant_salaire = $montant_salaire;
        return $this;
    }
	
    public function getAutre_budget() {
        return $this->autre_budget;
    }

    public function setAutre_budget($autre_budget) {
        $this->autre_budget = $autre_budget;
        return $this;
    }
	
    public function getPreselection() {
        return $this->preselection;
    }

    public function setPreselection($preselection) {
        $this->preselection = $preselection;
        return $this;
    }

	
}

?>
