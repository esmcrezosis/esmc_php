<?php

/**
 * Description of EuMouvementBancaire
 *
 * @author user
 */
 
class Application_Model_EuMouvementBancaire {

    //put your code here
    protected $id_mouvement_bancaire;
    protected $type_mouvement;
    protected $montant_mouvement;
    protected $date_mouvement;
    protected $date_emission;
	protected $code_banque;
	protected $type_compte;
	
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
	
	
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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
	
    public function getId_mouvement_bancaire() {
      return $this->id_mouvement_bancaire;
    }

    public function setId_mouvement_bancaire($id_mouvement_bancaire) {
      $this->id_mouvement_bancaire = $id_mouvement_bancaire;
      return $this;
    }

    public function getType_mouvement() {
      return $this->type_mouvement;
    }

    public function setType_mouvement($type_mouvement) {
      $this->type_mouvement = $type_mouvement;
      return $this;
    }

    public function getMontant_mouvement() {
        return $this->montant_mouvement;
    }

    public function setMontant_mouvement($montant_mouvement) {
        $this->montant_mouvement = $montant_mouvement;
        return $this;
    }

    public function getDate_mouvement() {
        return $this->date_mouvement;
    }

    public function setDate_mouvement($date_mouvement) {
        $this->date_mouvement = $date_mouvement;
        return $this;
    }

    public function getDate_emission() {
        return $this->date_emission;
    }

    public function setDate_emission($date_emission) {
        $this->date_emission = $date_emission;
        return $this;
    }
	
	public function getCode_banque() {
        return $this->code_banque;
    }

    public function setCode_banque($code_banque) {
        $this->code_banque = $code_banque;
        return $this;
    }
	
	public function getType_compte() {
        return $this->type_compte;
    }

    public function setType_compte($type_compte) {
        $this->type_compte = $type_compte;
        return $this;
    }

}

?>
