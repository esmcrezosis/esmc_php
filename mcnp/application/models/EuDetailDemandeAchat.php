<?php
 
class Application_Model_EuDetailDemandeAchat {

     //put your code here
	 protected $id_detail_demande_achat;
	 protected $id_demande_achat;
	 protected $reference_article;
	 protected $designation_article;
	 protected $quantite;
	 protected $prix_unitaire;
	 protected $validation;
     
    
	
	
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
	
	
	public function getId_detail_demande_achat() {
        return $this->id_detail_demande_achat;
    }
	

    public function setId_detail_demande_achat($id_detail_demande_achat) {
        $this->id_detail_demande_achat = $id_detail_demande_achat;
        return $this;
    }
	
	
	
	public function getId_demande_achat() {
        return $this->id_demande_achat;
    }
	

    public function setId_demande_achat($id_demande_achat) {
        $this->id_demande_achat = $id_demande_achat;
        return $this;
    }

    
    public function getReference_article() {
        return $this->reference_article;
    }
	

    public function setReference_article($reference_article) {
        $this->reference_article = $reference_article;
        return $this;
    }
	

    public function getDesignation_article() {
        return $this->designation_article;
    }

    public function setDesignation_article($designation_article) {
        $this->designation_article = $designation_article;
        return $this;
    }
	
	
    public function getQuantite() {
        return $this->quantite;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }
	

    public function getPrix_unitaire() {
        return $this->prix_unitaire;
    }

    public function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }
	
    public function getValidation() {
        return $this->validation;
    }

    public function setValidation($validation) {
        $this->validation = $validation;
        return $this;
    }
    

}

?>
