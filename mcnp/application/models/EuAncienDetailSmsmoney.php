<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailSmsmoney
 *
 * @author user
 */
class Application_Model_EuAncienDetailSmsmoney {

    //put your code here
    protected $id_detail_smsmoney;
    protected $code_membre;
    protected $code_membre_dist;
    protected $mont_sms;
    protected $date_allocation;
    protected $id_utilisateur;
    protected $mont_vendu;
    protected $mont_regle;
    protected $solde_sms;
    protected $creditcode;
    protected $origine_sms;
    protected $num_bon;
    protected $type_sms;

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

    public function getId_detail_smsmoney() {
        return $this->id_detail_smsmoney;
    }

    public function setId_detail_smsmoney($id_detail_smsmoney) {
        $this->id_detail_smsmoney = $id_detail_smsmoney;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }
    
     public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getNum_bon(){
        return $this->num_bon;
    }
    
    public function setNum_bon($num_bon){
        $this->num_bon = $num_bon;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_membre_dist() {
        return $this->code_membre_dist;
    }

    public function setCode_membre_dist($code_membre_dist) {
        $this->code_membre_dist = $code_membre_dist;
        return $this;
    }

    public function getMont_sms() {
        return $this->mont_sms;
    }

    public function setMont_sms($mont_sms) {
        $this->mont_sms = $mont_sms;
        return $this;
    }

    public function getDate_allocation() {
        return $this->date_allocation;
    }

    public function setDate_allocation($date_allocation) {
        $this->date_allocation = $date_allocation;
        return $this;
    }

    public function getMont_vendu() {
        return $this->mont_vendu;
    }

    public function setMont_vendu($mont_vendu) {
        $this->mont_vendu = $mont_vendu;
        return $this;
    }
    
    public function getMont_regle() {
        return $this->mont_vendu;
    }

    public function setMont_regle($mont_regle) {
        $this->mont_regle = $mont_regle;
        return $this;
    }

    public function getSolde_sms() {
        return $this->solde_sms;
        ;
    }

    public function setSolde_sms($solde_sms) {
        $this->solde_sms = $solde_sms;
        return $this;
    }
    
    public function getType_sms() {
        return $this->type_sms;
        ;
    }

    public function setType_sms($type_sms) {
        $this->type_sms = $type_sms;
        return $this;
    }

    public function getCreditcode() {
        return $this->creditcode;
    }

    public function setCreditcode($creditcode) {
        $this->creditcode = $creditcode;
        return $this;
    }

    public function getOrigine_sms() {
        return $this->origine_sms;
    }

    public function setOrigine_sms($origine_sms) {
        $this->origine_sms = $origine_sms;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_detail_smsmoney = (isset($data['id_detail_smsmoney'])) ? $data['id_detail_smsmoney'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->creditcode = (isset($data['creditcode'])) ? $data['creditcode'] : NULL;
        $this->mont_sms = (isset($data['mont_sms'])) ? $data['mont_sms'] : NULL;
        $this->mont_vendu = (isset($data['mont_vendu'])) ? $data['mont_vendu'] : NULL;
        $this->solde_sms = (isset($data['solde_sms'])) ? $data['solde_sms'] : NULL;
        $this->type_sms = (isset($data['type_sms'])) ? $data['type_sms'] : '';
        $this->date_allocation = (isset($data['date_allocation'])) ? $data['date_allocation'] : NULL;
        $this->code_membre_dist = (isset($data['code_membre_dist'])) ? $data['code_membre_dist'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->origine_sms = (isset($data['origine_sms'])) ? $data['origine_sms'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_detail_smsmoney' => $this->id_detail_smsmoney,
            'creditcode' => $this->creditcode,
            'code_membre' => $this->code_membre,
            'mont_sms' => $this->mont_sms,
            'type_sms' => $this->type_sms,
            'mont_vendu' => $this->mont_vendu,
            'solde_sms' => $this->solde_sms,
            'date_allocation' => $this->date_allocation,
            'code_membre_dist' => $this->code_membre_dist,
            'id_utilisateur' => $this->id_utilisateur,
            'origine_sms' => $this->origine_sms
        );
        return $data;
    }

}

?>
