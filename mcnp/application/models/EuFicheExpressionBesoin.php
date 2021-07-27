<?php
 
class Application_Model_EuFicheExpressionBesoin {

     //put your code here
     protected $id_fiche_expression_besoin;
     protected $designation_article;
     protected $description_bien;
     protected $quantite_article;
     protected $prix_unitaire;
     protected $visa_gerant;
     protected $avis_gerant;
     protected $valid_up;
     protected $valid_down;
     protected $date_demande;
     protected $appreciation;
     protected $valid;
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
	
     
	
	
	public function getId_fiche_expression_besoin() {
        return $this->id_fiche_expression_besoin;
    }

    public function setId_fiche_expression_besoin($id_fiche_expression_besoin) {
        $this->id_fiche_expression_besoin = $id_fiche_expression_besoin;
        return $this;
    }
    
    public function getDesignation_article() {
        return $this->designation_article;
    }

    public function setDesignation_article($designation_article) {
        $this->designation_article = $designation_article;
        return $this;
    }
    
    public function getDescription_bien() {
        return $this->description_bien;
    }

    public function setDescription_bien($description_bien) {
        $this->description_bien = $description_bien;
        return $this;
    }
    
    public function getQuantite_article() {
        return $this->quantite_article;
    }

    public function setQuantite_article($quantite_article) {
        $this->quantite_article = $quantite_article;
        return $this;
    }
    
    public function getPrix_unitaire() {
        return $this->prix_unitaire;
    }

    public function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }
        
    public function getVisa_gerant() {
        return $this->visa_gerant;
    }

    public function setVisa_gerant($visa_gerant) {
        $this->visa_gerant = $visa_gerant;
        return $this;
    }
        
    public function getAvis_gerant() {
        return $this->avis_gerant;
    }

    public function setAvis_gerant($avis_gerant) {
        $this->avis_gerant = $avis_gerant;
        return $this;
    }
        
    public function getValid_up() {
        return $this->valid_up;
    }

    public function setValid_up($valid_up) {
        $this->valid_up = $valid_up;
        return $this;
    }
        
    public function getValid_down() {
        return $this->valid_down;
    }

    public function setValid_down($valid_down) {
        $this->valid_down = $valid_down;
        return $this;
    }
    
    public function getDate_demande() {
        return $this->date_demande;
    }

    public function setDate_demande($date_demande) {
        $this->date_demande = $date_demande;
        return $this;
    }
        
    public function getAppreciation() {
        return $this->appreciation;
    }

    public function setAppreciation($appreciation) {
        $this->appreciation = $appreciation;
        return $this;
    }
    		
	public function getValid() {
        return $this->valid;
    }

    public function setValid($valid) {
        $this->valid = $valid;
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
