<?php

 
class Application_Model_EuAnnulationCommande  {

    //put your code here
	protected $id_annulation_commande;
    protected $code_commande;
    protected $id_detail;
    protected $montant;

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
	
	
	public function getId_annulation_commande() {
        return $this->id_annulation_commande;
    }

    public function setId_annulation_commande($id_annulation_commande) {
        $this->id_annulation_commande = $id_annulation_commande;
        return $this;
    }
    
    public function getCode_commande() {
        return $this->code_commande;
    }

    public function setCode_commande($code_commande) {
        $this->code_commande = $code_commande;
        return $this;
    }

    public function getId_detail() {
        return $this->id_detail;
    }

    public function setId_detail($id_detail) {
        $this->id_detail = $id_detail;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }
	

}

?>
