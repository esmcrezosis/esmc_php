<?php

class Application_Model_EuDepotVente {

    protected $id_depot;
    protected $date_depot;
    protected $code_produit;
    protected $mont_depot;
    protected $mont_vendu;
    protected $solde_depot;
    protected $id_utilisateur;
	protected $code_membre;
	protected $type_depot;
	protected $souscription_id;

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

    public function getId_depot() {
        return $this->id_depot;
    }

    public function setId_depot($id_depot) {
        $this->id_depot = $id_depot;
        return $this;
    }

    public function getDate_depot() {
        return $this->date_depot;
    }

    public function setDate_depot($date_depot) {
        $this->date_depot = $date_depot;
        return $this;
    }

	
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    
    public function getMont_depot() {
        return $this->mont_depot;
    }

    public function setMont_depot($mont_depot) {
        $this->mont_depot = $mont_depot;
        return $this;
    }

    public function getMont_vendu() {
        return $this->mont_vendu;
    }

    public function setMont_vendu($mont_vendu) {
        $this->mont_vendu = $mont_vendu;
        return $this;
    }


    public function getSolde_depot() {
        return $this->solde_depot;
    }

    public function setSolde_depot($solde_depot) {
        $this->solde_depot = $solde_depot;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getCode_produit() {
        return $this->code_produit;
    }

    public function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }
	
	
	public function getType_depot() {
        return $this->type_depot;
    }

    public function setType_depot($type_depot) {
        $this->type_depot = $type_depot;
        return $this;
    }
	
	
	public function getSouscription_id() {
        return $this->souscription_id;
    }

    public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
    }
	
	
	
	/*
    public function exchangeArray($data) {
        $this->id_depot = (isset($data['id_depot'])) ? $data['id_depot'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->code_membre_dist = (isset($data['code_membre_dist'])) ? $data['code_membre_dist'] : NULL;
        $this->date_depot = (isset($data['date_depot'])) ? $data['date_depot'] : NULL;
        $this->mont_depot = (isset($data['mont_depot'])) ? $data['mont_depot'] : 0;
        $this->mont_vendu = (isset($data['mont_vendu'])) ? $data['mont_vendu'] : 0;
        $this->mont_paye = (isset($data['mont_paye'])) ? $data['mont_paye'] : 0;
        $this->solde_depot = (isset($data['solde_depot'])) ? $data['solde_depot'] : NULL;
        $this->code_produit = (isset($data['code_produit'])) ? $data['code_produit'] : '';
    }

    public function toArray() {
        $data = array(
            'id_depot' => $this->id_depot,
            'id_utilisateur' => $this->id_utilisateur,
            'code_membre' => $this->code_membre,
            'code_membre_dist' => $this->code_membre_dist,
            'date_depot' => $this->date_depot,
            'mont_depot' => $this->mont_depot,
            'mont_vendu' => $this->mont_vendu,
            'mont_paye' => $this->mont_paye,
            'solde_depot' => $this->solde_depot,
            'code_produit' => $this->code_produit
        );
        return $data;
    }*/

}

