<?php

class Application_Model_EuLettreImmobilisation {
	
    protected $id_lettre;
    protected $id_fiche_immobilisation;
    protected $motif1;
    protected $valider;
    protected $rejeter;
    protected $code_membre_fournisseur;
    protected $date_creation;
	protected $motif2;
	protected $date_restitution;

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
	

    public function getId_lettre() {
        return $this->id_lettre;
    }

    public function setId_lettre($id_lettre) {
        $this->id_lettre = $id_lettre;
        return $this;
    }
	
	public function getId_fiche_immobilisation() {
        return $this->id_fiche_immobilisation;
    }

    public function setId_fiche_immobilisation($id_fiche_immobilisation) {
        $this->id_fiche_immobilisation = $id_fiche_immobilisation;
        return $this;
    }
	
	public function getMotif1() {
        return $this->motif1;
    }

    public function setMotif1($motif1) {
        $this->motif1 = $motif1;
        return $this;
    }
	
	public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
        return $this;
    }
	
	public function getRejeter() {
        return $this->rejeter;
    }

    public function setRejeter($rejeter) {
        $this->rejeter = $rejeter;
        return $this;
    }
	
	public function getCode_membre_fournisseur() {
        return $this->code_membre_fournisseur;
    }

    public function setCode_membre_fournisseur($code_membre_fournisseur) {
        $this->code_membre_fournisseur = $code_membre_fournisseur;
        return $this;
    }
	
	public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }
	
	public function getDate_restitution() {
        return $this->date_restitution;
    }

    public function setDate_restitution($date_restitution) {
        $this->date_restitution = $date_restitution;
        return $this;
    }
	
	public function getMotif2() {
        return $this->motif2;
    }

    public function setMotif2($motif2) {
        $this->motif2 = $motif2;
        return $this;
    }
	
	

}

