<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCartes
 *
 * @author user
 */
class Application_Model_EuAncienCartes {
    //put your code here
     //put your code here
    protected $id_demande;
    protected $id_utilisateur;
    protected $date_demande;
    protected $code_membre;
    protected $code_Compte;
    protected $mont_carte;
    protected $code_cat;
    protected $imprimer;
    protected $livrer;
    protected $date_livraison;
    protected $CardPrintedDate;
    protected $CardPrintedIDDate;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Cartes property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Cartes property');
        }
        return $this->$method();
    }

    public function getId_demande() {
        return $this->id_demande;
    }

    public function setId_demande($id_demande) {
        $this->id_demande = $id_demande;
        return $this;
    }

    public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    
     public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDate_demande() {
        return $this->date_demande;
    }

    public function setDate_demande($date_demande) {
        $this->date_demande = $date_demande;
        return $this;
    }

    public function getMont_carte() {
        return $this->mont_carte;
    }

    public function setMont_carte($mont_carte) {
        $this->mont_carte = $mont_carte;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    function getCode_cat() {
        return $this->code_cat;
    }

    function setCode_cat($code_cat) {
        $this->code_cat = $code_cat;
        return $this;
    }
    
    public function getImprimer() {
        return $this->imprimer;
    }

    public function setImprimer($imprimer) {
        $this->imprimer = $imprimer;
        return $this;
    }
    
    public function getLivrer() {
        return $this->livrer;
    }

    public function setLivrer($livrer) {
        $this->livrer = $livrer;
        return $this;
    }
    
    public function getDate_livraison() {
        return $this->date_livraison;
    }

    public function setDate_livraison($date_livraison) {
        $this->date_livraison = $date_livraison;
        return $this;
    }
    
    public function getCardPrintedDate() {
        return $this->CardPrintedDate;
    }

    public function setCardPrintedDate($CardPrintedDate) {
        $this->CardPrintedDate = $CardPrintedDate;
        return $this;
    }
    
    public function getCardPrintedIDDate() {
        return $this->CardPrintedIDDate;
    }

    public function setCardPrintedIDDate($CardPrintedIDDate) {
        $this->CardPrintedIDDate = $CardPrintedIDDate;
        return $this;
    }
    
    function getCode_Compte() {
        return $this->code_Compte;
    }

    function setCode_Compte($code_compte) {
        $this->code_Compte = $code_compte;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_demande = (isset($data['id_demande'])) ? $data['id_demande'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->date_demande = (isset($data['date_demande'])) ? $data['date_demande'] : NULL;
        $this->code_cat = (isset($data['code_cat'])) ? $data['code_cat'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->code_Compte = (isset($data['code_compte'])) ? $data['code_compte'] : NULL;
        $this->mont_carte = (isset($data['mont_carte'])) ? $data['mont_carte'] : NULL;
        $this->imprimer = (isset($data['imprimer'])) ? $data['imprimer'] : 0;
        $this->livrer = (isset($data['livrer'])) ? $data['livrer'] : 0;
        $this->date_livraison = (isset($data['date_livraison'])) ? $data['date_livraison'] : NULL;
        $this->CardPrintedDate = (isset($data['cardprinteddate'])) ? $data['cardprinteddate'] : '';
        $this->CardPrintedIDDate = (isset($data['cardprintediddate'])) ? $data['cardprintediddate'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_demande' => $this->id_demande,
            'id_utilisateur' => $this->id_utilisateur,
            'date_demande' => $this->date_demande,
            'code_cat' => $this->code_cat,
            'code_membre' => $this->code_membre,
            'mont_carte' => $this->mont_carte,
            'imprimer' => $this->imprimer,
            'livrer' => $this->livrer,
            'date_livraison'=> $this->date_livraison,
            'cardprintediddate' => $this->CardPrintedIDDate,
            'cardprinteddate' => $this->CardPrintedDate,
            'code_compte' => $this->code_Compte
        );
        return $data;
    }

	
    public function findConuter() {
        $t_cartes = new Application_Model_DbTable_EuAncienCartes();
        $select = $t_cartes->select();
        $select->from($t_cartes, array('MAX(id_demande) as count'));
        $result = $t_cartes->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

	

////////////////////////////////////////////////////////////////











}

?>
