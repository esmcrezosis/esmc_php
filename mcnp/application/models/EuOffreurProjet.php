<?php
 
class Application_Model_EuOffreurProjet {

    //put your code here
    protected $offreur_projet_id;
    protected $offreur_projet_souscription;
    protected $offreur_projet_code_membre;
    protected $offreur_projet_raison_sociale;
    protected $offreur_projet_adresse;
    protected $offreur_projet_produit;
    protected $offreur_projet_type;
    protected $offreur_projet_date;
    protected $publier;
    protected $offreur_projet_operationnel;
    protected $offreur_projet_capacite_production;
    protected $offreur_projet_stock_disponible;
    protected $offreur_projet_membreasso;
    protected $offreur_projet_qte_max;
    protected $offreur_projet_qte_moyen;
    protected $offreur_projet_qte_min;
    protected $offreur_projet_nom_entrepot;
    protected $offreur_projet_adresse_entrepot;
    protected $offreur_projet_description_projet;
    protected $offreur_projet_canton;
    protected $offreur_projet_ville;
    protected $offreur_projet_fournisseur;

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

    public function getOffreur_projet_id() {
        return $this->offreur_projet_id;
    }

    public function setOffreur_projet_id($offreur_projet_id) {
        $this->offreur_projet_id = $offreur_projet_id;
        return $this;
    }

    public function getOffreur_projet_adresse() {
        return $this->offreur_projet_adresse;
    }

    public function setOffreur_projet_adresse($offreur_projet_adresse) {
        $this->offreur_projet_adresse = $offreur_projet_adresse;
        return $this;
    }

	public function getOffreur_projet_code_membre() {
        return $this->offreur_projet_code_membre;
    }

    public function setOffreur_projet_code_membre($offreur_projet_code_membre) {
        $this->offreur_projet_code_membre = $offreur_projet_code_membre;
        return $this;
    }
	
	
    public function getOffreur_projet_raison_sociale() {
        return $this->offreur_projet_raison_sociale;
    }

    public function setOffreur_projet_raison_sociale($offreur_projet_raison_sociale) {
        $this->offreur_projet_raison_sociale = $offreur_projet_raison_sociale;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getOffreur_projet_souscription() {
        return ($this->offreur_projet_souscription);
    }

    public function setOffreur_projet_souscription($offreur_projet_souscription) {
        $this->offreur_projet_souscription = ($offreur_projet_souscription);
        return $this;
    }

    public function getOffreur_projet_produit() {
        return $this->offreur_projet_produit;
    }

    public function setOffreur_projet_produit($offreur_projet_produit) {
        $this->offreur_projet_produit = $offreur_projet_produit;
        return $this;
    }

    public function getOffreur_projet_type() {
        return $this->offreur_projet_type;
    }

    public function setOffreur_projet_type($offreur_projet_type) {
        $this->offreur_projet_type = $offreur_projet_type;
        return $this;
    }

    public function getOffreur_projet_date() {
        return $this->offreur_projet_date;
    }

    public function setOffreur_projet_date($offreur_projet_date) {
        $this->offreur_projet_date = $offreur_projet_date;
        return $this;
    }

    public function getOffreur_projet_operationnel() {
        return ($this->offreur_projet_operationnel);
    }

    public function setOffreur_projet_operationnel($offreur_projet_operationnel) {
        $this->offreur_projet_operationnel = ($offreur_projet_operationnel);
        return $this;
    }

    public function getOffreur_projet_capacite_production() {
        return $this->offreur_projet_capacite_production;
    }

    public function setOffreur_projet_capacite_production($offreur_projet_capacite_production) {
        $this->offreur_projet_capacite_production = $offreur_projet_capacite_production;
        return $this;
    }

    public function getOffreur_projet_stock_disponible() {
        return $this->offreur_projet_stock_disponible;
    }

    public function setOffreur_projet_stock_disponible($offreur_projet_stock_disponible) {
        $this->offreur_projet_stock_disponible = $offreur_projet_stock_disponible;
        return $this;
    }

    public function getOffreur_projet_membreasso() {
        return ($this->offreur_projet_membreasso);
    }

    public function setOffreur_projet_membreasso($offreur_projet_membreasso) {
        $this->offreur_projet_membreasso = ($offreur_projet_membreasso);
        return $this;
    }

    public function getOffreur_projet_qte_max() {
        return ($this->offreur_projet_qte_max);
    }

    public function setOffreur_projet_qte_max($offreur_projet_qte_max) {
        $this->offreur_projet_qte_max = ($offreur_projet_qte_max);
        return $this;
    }

    public function getOffreur_projet_qte_moyen() {
        return ($this->offreur_projet_qte_moyen);
    }

    public function setOffreur_projet_qte_moyen($offreur_projet_qte_moyen) {
        $this->offreur_projet_qte_moyen = ($offreur_projet_qte_moyen);
        return $this;
    }

    public function getOffreur_projet_qte_min() {
        return ($this->offreur_projet_qte_min);
    }

    public function setOffreur_projet_qte_min($offreur_projet_qte_min) {
        $this->offreur_projet_qte_min = ($offreur_projet_qte_min);
        return $this;
    }

    public function getOffreur_projet_nom_entrepot() {
        return ($this->offreur_projet_nom_entrepot);
    }

    public function setOffreur_projet_nom_entrepot($offreur_projet_nom_entrepot) {
        $this->offreur_projet_nom_entrepot = ($offreur_projet_nom_entrepot);
        return $this;
    }

    public function getOffreur_projet_adresse_entrepot() {
        return ($this->offreur_projet_adresse_entrepot);
    }

    public function setOffreur_projet_adresse_entrepot($offreur_projet_adresse_entrepot) {
        $this->offreur_projet_adresse_entrepot = ($offreur_projet_adresse_entrepot);
        return $this;
    }

    public function getOffreur_projet_description_projet() {
        return ($this->offreur_projet_description_projet);
    }

    public function setOffreur_projet_description_projet($offreur_projet_description_projet) {
        $this->offreur_projet_description_projet = ($offreur_projet_description_projet);
        return $this;
    }

    public function getOffreurProjetCanton() {
	return $this->offreur_projet_canton;
    }

    public function setOffreurProjetCanton($offreur_projet_canton) {
	$this->offreur_projet_canton = $offreur_projet_canton;
	return $this;
    }

    public function getOffreurProjetVille() {
	return $this->offreur_projet_ville;
    }

    public function setOffreurProjetVille($offreur_projet_ville) {
	$this->offreur_projet_ville = $offreur_projet_ville;
	return $this;
    }


    public function getOffreurProjetFournisseur() {
	return $this->offreur_projet_fournisseur;
    }

    public function setOffreurProjetFournisseur($offreur_projet_fournisseur) {
	$this->offreur_projet_fournisseur = $offreur_projet_fournisseur;
	return $this;
    }

}

?>
