<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuEchange
 *
 * @author user
 */
class Application_Model_EuEchange {

    //put your code here
    protected $id_echange;
    protected $code_membre;
	protected $code_membre_morale;
    protected $code_compte_ech;
    protected $code_compte_obt;
    protected $type_echange;
    protected $montant;
    protected $montant_echange;
    protected $agio;
    protected $date_echange;
    protected $id_utilisateur;
    protected $cat_echange;
    protected $regler;
    protected $date_reglement;
    protected $id_credit;
    protected $code_produit;
    protected $compenser;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
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

    public function getId_echange() {
        return $this->id_echange;
    }

    public function setId_echange($id_echange) {
        $this->id_echange = $id_echange;
        return $this;
    }

    public function getCompenser() {
        return $this->compenser;
    }

    public function setCompenser($compenser) {
        $this->compenser = $compenser;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
	

    public function getCode_compte_ech() {
        return $this->code_compte_ech;
    }

    public function setCode_compte_ech($code_compte_ech) {
        $this->code_compte_ech = $code_compte_ech;
        return $this;
    }

    public function getCode_compte_obt() {
        return $this->code_compte_obt;
    }

    public function setCode_compte_obt($code_compte_obt) {
        $this->code_compte_obt = $code_compte_obt;
        return $this;
    }

    public function getCode_produit() {
        return $this->code_produit;
    }

    public function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

    public function getType_echange() {
        return $this->type_echange;
    }

    public function setType_echange($type_echange) {
        $this->type_echange = $type_echange;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    public function getMontant_echange() {
        return $this->montant_echange;
    }

    public function setMontant_echange($montant_echange) {
        $this->montant_echange = $montant_echange;
        return $this;
    }

    public function getAgio() {
        return $this->agio;
    }

    public function setAgio($agio) {
        $this->agio = $agio;
        return $this;
    }

    public function getDate_echange() {
        return $this->date_echange;
    }

    public function setDate_echange($date_echange) {
        $this->date_echange = $date_echange;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getCat_echange() {
        return $this->cat_echange;
    }

    public function setCat_echange($cat_echange) {
        $this->cat_echange = $cat_echange;
        return $this;
    }

    public function getRegler() {
        return $this->regler;
    }

    public function setRegler($regler) {
        $this->regler = $regler;
        return $this;
    }

    public function getDate_reglement() {
        return $this->date_reglement;
    }

    public function setDate_reglement($date_reglement) {
        $this->date_reglement = $date_reglement;
        return $this;
    }

}

?>
