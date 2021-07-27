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
class Application_Model_EuTransfertNn {

    //put your code here
    protected $id_transfert_nn;
    protected $date_transfert;
    protected $mont_transfert;
    protected $mont_vendu;
    protected $solde_transfert;
    protected $type_reglement;
    protected $type_transfert;
    protected $code_compte_dist;
    protected $code_compte_transfert;
    protected $code_type_nn;
    protected $mont_regle;
    protected $restant_du;
    protected $code_document;
	protected $url_document;

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

	

   
   
    
	
	
    public function getId_transfert_nn() {
        return $this->id_transfert_nn;
    }

    public function setId_transfert_nn($id_transfert_nn) {
        $this->id_transfert_nn = $id_transfert_nn;
        return $this;
    }

    public function getDate_transfert() {
        return $this->date_transfert;
    }
    
     public function setDate_transfert($date_transfert) {
        $this->date_transfert = $date_transfert;
        return $this;
    }
    
    public function getMont_transfert(){
        return $this->mont_transfert;
    }
    
    public function setMont_transfert($mont_transfert) {
        $this->mont_transfert = $mont_transfert;
        return $this;
    }
	
    public function getMont_vendu() {
        return $this->mont_vendu;
    }

    public function setMont_vendu($mont_vendu) {
        $this->mont_vendu = $mont_vendu;
        return $this;
    }

    public function getSolde_transfert() {
        return $this->solde_transfert;
    }

    public function setSolde_transfert($solde_transfert) {
        $this->solde_transfert = $solde_transfert;
        return $this;
    }
    
    public function getType_reglement() {
        return $this->type_reglement;
    }

    public function setType_reglement($type_reglement) {
        $this->type_reglement = $type_reglement;
        return $this;
    }

    public function getType_transfert() {
        return $this->type_transfert;
    }

    public function setType_transfert($type_transfert) {
           $this->type_transfert = $type_transfert;
           return $this;
    }

    public function getCode_compte_dist() {
        return $this->code_compte_dist;
    }

    public function setCode_compte_dist($code_compte_dist) {
        $this->code_compte_dist = $code_compte_dist;
        return $this;
    }
    
	
    public function getCode_compte_transfert() {
        return $this->code_compte_transfert;
    }

    public function setCode_compte_transfert($code_compte_transfert) {
        $this->code_compte_transfert = $code_compte_transfert;
        return $this;
    }

    public function getCode_type_nn() {
        return $this->code_type_nn;
        ;
    }

    public function setCode_type_nn($code_type_nn) {
        $this->code_type_nn = $code_type_nn;
        return $this;
    }
    
    public function getMont_regle() {
        return $this->mont_regle;
        ;
    }

    public function setMont_regle($mont_regle) {
        $this->mont_regle = $mont_regle;
        return $this;
    }
	
    public function getRestant_du() {
        return $this->restant_du;
    }

    public function setRestant_du($restant_du) {
        $this->restant_du = $restant_du;
        return $this;
    }

    public function getCode_document() {
        return $this->code_document;
    }

    public function setCode_document($code_document) {
        $this->code_document = $code_document;
        return $this;
    }
	
	public function getUrl_document() {
        return $this->url_document;
    }

    public function setUrl_document($url_document) {
        $this->url_document = $url_document;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_transfert_nn = (isset($data['id_transfert_nn'])) ? $data['id_transfert_nn'] : NULL;
        $this->date_transfert = (isset($data['date_transfert'])) ? $data['date_transfert'] : NULL;
        $this->mont_transfert = (isset($data['mont_transfert'])) ? $data['mont_transfert'] : NULL;
        $this->mont_vendu = (isset($data['mont_vendu'])) ? $data['mont_vendu'] : NULL;
        $this->solde_transfert = (isset($data['solde_transfert'])) ? $data['solde_transfert'] : NULL;
        $this->type_reglement = (isset($data['type_reglement'])) ? $data['type_reglement'] : NULL;
        $this->type_transfert = (isset($data['type_transfert'])) ? $data['type_transfert'] : '';
        $this->code_compte_dist = (isset($data['code_compte_dist'])) ? $data['code_compte_dist'] : NULL;
        $this->code_membre_transfert = (isset($data['code_compte_transfert'])) ? $data['code_compte_transfert'] : NULL;
        $this->code_type_nn = (isset($data['code_type_nn'])) ? $data['code_type_nn'] : NULL;
        $this->mont_regle = (isset($data['mont_regle'])) ? $data['mont_regle'] : NULL;
		$this->restant_du = (isset($data['restant_du'])) ? $data['restant_du'] : NULL;
		$this->code_document = (isset($data['code_document'])) ? $data['code_document'] : NULL;
		$this->url_document = (isset($data['url_document'])) ? $data['url_document'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_transfert_nn' => $this->id_transfert_nn,
            'date_transfert' => $this->date_transfert,
            'mont_transfert' => $this->code_membre,
            'mont_vendu' => $this->mont_sms,
            'solde_transfert' => $this->type_sms,
            'type_reglement' => $this->mont_vendu,
            'type_transfert' => $this->solde_sms,
            'code_compte_dist' => $this->code_compte_dist,
            'code_compte_transfert' => $this->code_compte_transfert,
            'code_type_nn' => $this->code_type_nn,
            'mont_regle' => $this->mont_regle,
			'restant_du' => $this->restant_du,
			'code_document' => $this->code_document,
			'url_document' => $this->url_document
        );
        return $data;
    }

}

?>
