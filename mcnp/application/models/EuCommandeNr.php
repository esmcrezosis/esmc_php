<?php
 
class Application_Model_EuCommandeNr {

    //put your code here
    protected $id_commande_nr;
    protected $code_membre;
    protected $produit;
    protected $designation;
    protected $prix_unitaire;
    protected $quantite;
    protected $total_bps;
    protected $total_nr;
    protected $date_commande_nr;
    protected $date_livraison_estimer;
    protected $actif;
    protected $prk;
    
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

    public function getId_commande_nr() {
        return $this->id_commande_nr;
    }

    public function setId_commande_nr($id_commande_nr) {
        $this->id_commande_nr = $id_commande_nr;
        return $this;
    }

    public function getPrix_unitaire() {
        return $this->prix_unitaire;
    }

    public function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }

    public function getProduit() {
        return $this->produit;
    }

    public function setProduit($produit) {
        $this->produit = $produit;
        return $this;
    }

    public function getCode_membre() {
        return ($this->code_membre);
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = ($code_membre);
        return $this;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }

    public function getTotal_bps() {
        return $this->total_bps;
    }

    public function setTotal_bps($total_bps) {
        $this->total_bps = $total_bps;
        return $this;
    }


    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
        return $this;
    }


    public function getTotal_nr() {
        return $this->total_nr;
    }

    public function setTotal_nr($total_nr) {
        $this->total_nr = $total_nr;
        return $this;
    }

    public function getDate_commande_nr() {
        return $this->date_commande_nr;
    }

    public function setDate_commande_nr($date_commande_nr) {
        $this->date_commande_nr = $date_commande_nr;
        return $this;
    }

    public function getActif() {
        return $this->actif;
    }

    public function setActif($actif) {
        $this->actif = $actif;
        return $this;
    }

    public function getDate_livraison_estimer() {
        return $this->date_livraison_estimer;
    }

    public function setDate_livraison_estimer($date_livraison_estimer) {
        $this->date_livraison_estimer = $date_livraison_estimer;
        return $this;
    }

    public function getPrk() {
        return $this->prk;
    }

    public function setPrk($prk) {
        $this->prk = $prk;
        return $this;
    }


}

?>
