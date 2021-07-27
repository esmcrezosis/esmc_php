<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailVentesms
 *
 * @author mawuli
 */
class Application_Model_EuDetailVentesms {

    //put your code here
    protected $id_detail_vtsms;
    protected $id_detail_smsmoney;
    protected $date_vente;
    protected $code_membre_dist;
    protected $code_membre;
    protected $mont_vente;
    protected $type_transfert;
    protected $creditcode;
    protected $id_utilisateur;
    protected $code_produit;
	protected $origine_compte;

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

    public function getId_detail_vtsms() {
        return $this->id_detail_vtsms;
    }

    public function setId_detail_vtsms($id_detail_vtsms) {
        $this->id_detail_vtsms = $id_detail_vtsms;
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

    public function getMont_vente() {
        return $this->mont_vente;
    }

    public function setMont_vente($mont_vente) {
        $this->mont_vente = $mont_vente;
        return $this;
    }

    public function getDate_vente() {
        return $this->date_vente;
    }

    public function setDate_vente($date_vente) {
        $this->date_vente = $date_vente;
        return $this;
    }

    public function getType_tansfert() {
        return $this->type_transfert;
    }

    public function setType_tansfert($type_transfert) {
        $this->type_transfert = $type_transfert;
        return $this;
    }

    public function getCreditcode() {
        return $this->creditcode;
    }

    public function setCreditcode($creditcode) {
        $this->creditcode = $creditcode;
        return $this;
    }
    
    public function getCode_produit(){
        return $this->code_produit;
    }
    
    public function setCode_produit($code_produit){
        $this->code_produit = $code_produit;
        return $this;
    }
	
	public function getOrigine_compte(){
        return $this->origine_compte;
    }
    
    public function setOrigine_compte($origine_compte){
        $this->origine_compte = $origine_compte;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_detail_smsmoney = (isset($data['id_detail_smsmoney'])) ? $data['id_detail_smsmoney'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->creditcode = (isset($data['creditcode'])) ? $data['creditcode'] : NULL;
        $this->type_transfert = (isset($data['type_transfert'])) ? $data['type_transfert'] : NULL;
        $this->mont_vente = (isset($data['mont_vente'])) ? $data['mont_vente'] : NULL;
        $this->date_vente = (isset($data['date_vente'])) ? $data['date_vente'] : NULL;
        $this->code_membre_dist = (isset($data['code_membre_dist'])) ? $data['code_membre_dist'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->id_detail_vtsms = (isset($data['id_detail_vtsms'])) ? $data['id_detail_vtsms'] : NULL;
        $this->code_produit = (isset($data['code_produit'])) ? $data['code_produit'] : NULL;
		$this->origine_compte = (isset($data['origine_compte'])) ? $data['origine_compte'] : NULL;
    }

	
	
	public function findConuter() {
		$table = new Application_Model_DbTable_EuDetailVentesms();
        $select = $table->select();
        $select->from($table, array('MAX(id_detail_vtsms) as count'));
        $result = $table->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function toArray() {
        $data = array(
         'id_detail_smsmoney' => $this->id_detail_smsmoney,
         'creditcode' => $this->creditcode,
         'code_membre' => $this->code_membre,
         'type_transfert' => $this->type_transfert,
         'mont_vente' => $this->mont_vente,
         'date_vente' => $this->date_vente,
         'code_membre_dist' => $this->code_membre_dist,
         'id_utilisateur' => $this->id_utilisateur,
         'id_detail_vtsms' => $this->id_detail_vtsms,
         'code_produit' => $this->code_produit,
	     'origine_compte' => $this->origine_compte
        );
        return $data;
    }

}

?>
