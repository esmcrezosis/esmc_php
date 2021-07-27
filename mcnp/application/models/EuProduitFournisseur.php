<?php
 
class Application_Model_EuProduitFournisseur {

     //put your code here
	 protected $id_produit_fournisseur;
     protected $libelle_produit_fournisseur;
     protected $desc_produit_fournisseur;
     protected $code_membre_fournisseur;
     protected $code_tegc;
     protected $activer;
	 protected $date_creation;
	
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
	
	public function getId_produit_fournisseur() {
        return $this->id_produit_fournisseur;
    }

    public function setId_produit_fournisseur($id_produit_fournisseur) {
        $this->id_produit_fournisseur = $id_produit_fournisseur;
        return $this;
    }
	
	
	public function getLibelle_produit_fournisseur() {
        return $this->libelle_produit_fournisseur;
    }

    public function setLibelle_produit_fournisseur($libelle_produit_fournisseur) {
        $this->libelle_produit_fournisseur = $libelle_produit_fournisseur;
        return $this;
    }
	
	
	public function getDesc_produit_fournisseur() {
        return $this->desc_produit_fournisseur;
    }

    public function setDesc_produit_fournisseur($desc_produit_fournisseur) {
        $this->desc_produit_fournisseur = $desc_produit_fournisseur;
        return $this;
    }
	
	
	public function getCode_membre_fournisseur() {
        return $this->code_membre_fournisseur;
    }

    public function setCode_membre_fournisseur($code_membre_fournisseur) {
        $this->code_membre_fournisseur = $code_membre_fournisseur;
        return $this;
    }
	
	
	public function getCode_tegc() {
        return $this->code_tegc;
    }

    public function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }
	
	
	public function getActiver() {
      return $this->activer;
    }

    public function setActiver($activer) {
        $this->activer = $activer;
        return $this;
    }
	
	
	public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }
	
	
	

}

?>
