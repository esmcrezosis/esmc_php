<?php

/**
 * Description of EuDemandeConfigte
 *
 * @author user
*/
 
class Application_Model_EuDemandeConfigte {
    //put your code here
    protected $id_demande;
    protected $nom_produit;
    protected $code_membre_morale;
	protected $produit_special;
	protected $produit_ordinaire;
    protected $valider;
	protected $id_canton;
    protected $date_demande;
    
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
	
	
    public function getId_demande() {
        return $this->id_demande;
    }

    public function setId_demande($id_demande) {
      $this->id_demande = $id_demande;
      return $this;
    }

    public function getNom_produit() {
        return $this->nom_produit;
    }

    public function setNom_produit($nom_produit) {
        $this->nom_produit = $nom_produit;
        return $this;
    }

    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
      $this->code_membre_morale = $code_membre_morale;
      return $this;
    }
	
	public function getProduit_special() {
      return $this->produit_special;
    }

    public function setProduit_special($produit_special) {
        $this->produit_special = $produit_special;
        return $this;
    }
	
	public function getProduit_ordinaire() {
      return $this->produit_ordinaire;
    }

    public function setProduit_ordinaire($produit_ordinaire) {
        $this->produit_ordinaire = $produit_ordinaire;
        return $this;
    }

    public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
        return $this;
    }
	
	
	public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	public function getDate_demande() {
        return $this->date_demande;
    }

    public function setDate_demande($date_demande) {
      $this->date_demande = $date_demande;
      return $this;
    }

}

?>
