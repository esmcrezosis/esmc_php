<?php
 
class Application_Model_EuDetailEli {

     //put your code here
	 protected $id_detail_eli;
     protected $id_eli;
     protected $libelle_produit;
     protected $montant_produit;
     protected $quantite;
     protected $prix_unitaire;
	 protected $qte_vente;
     protected $prix_vente;
     protected $statut;
	 protected $type_bps;
     
	 
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
	
	public function getId_detail_eli() {
        return $this->id_detail_eli;
    }

    public function setId_detail_eli($id_detail_eli) {
        $this->id_detail_eli = $id_detail_eli;
        return $this;
    }
	
	
	public function getId_eli() {
        return $this->id_eli;
    }

    public function setId_eli($id_eli) {
        $this->id_eli = $id_eli;
        return $this;
    }
	
	public function getLibelle_produit() {
        return $this->libelle_produit;
    }

    public function setLibelle_produit($libelle_produit) {
        $this->libelle_produit = $libelle_produit;
        return $this;
    }
	
	
	public function getMontant_produit() {
        return $this->montant_produit;
    }

    public function setMontant_produit($montant_produit) {
        $this->montant_produit = $montant_produit;
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
	
	
	public function getQte_vente() {
        return $this->qte_vente;
    }

    public function setQte_vente($qte_vente) {
        $this->qte_vente = $qte_vente;
        return $this;
    }
	
	
	public function getPrix_vente() {
        return $this->prix_vente;
    }

    public function setPrix_vente($prix_vente) {
        $this->prix_vente = $prix_vente;
        return $this;
    }
	
	
	public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }
	
	
	public function getType_bps() {
        return $this->type_bps;
    }

    public function setType_bps($type_bps) {
        $this->type_bps = $type_bps;
        return $this;
    }
	
	
	
	

}

?>
