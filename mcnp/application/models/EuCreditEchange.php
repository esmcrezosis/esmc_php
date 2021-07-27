<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCnpEntree
 *
 * @author user
 */
class Application_Model_EuCreditEchange {

    //put your code here
    protected $id_credit_echange;
    protected $id_echange;
    protected $id_credit;
    protected $source_credit;
    protected $mont_echange;
    protected $agio;

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

    public function getId_credit_echange() {
        return $this->id_credit_echange;
    }

    public function setId_credit_echange($id_credit_echange) {
        $this->id_credit_echange = $id_credit_echange;
        return $this;
    }
    
    public function getId_echange() {
        return $this->id_echange;
    }

    public function setId_echange($id_echange) {
        $this->id_echange = $id_echange;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getSource_credit() {
        return $this->source_credit;
    }

    public function setSource_credit($source_credit) {
        $this->source_credit = $source_credit;
        return $this;
    }

    public function getMont_echange() {
        return $this->mont_echange;
    }

    public function setMont_echange($mont_echange) {
        $this->mont_echange = $mont_echange;
        return $this;
    }
    
    public function getAgio(){
        return $this->agio;
    }
    
    public function setAgio($agio){
        $this->agio = $agio;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_credit_echange = (isset($data['id_credit_echange'])) ? $data['id_credit_echange'] : NULL;
        $this->id_credit = (isset($data['id_credit'])) ? $data['id_credit'] : NULL;
        $this->source_credit = (isset($data['source_credit'])) ? $data['source_credit'] : NULL;
        $this->id_echange = (isset($data['id_echange'])) ? $data['id_echange'] : NULL;
        $this->mont_echange = (isset($data['mont_echange'])) ? $data['mont_echange'] : NULL;
        $this->agio = (isset($data['agio'])) ? $data['agio'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_credit_echange' => $this->id_credit_echange,
            'id_credit' => $this->id_credit,
            'source_credit' => $this->source_credit,
            'id_echange' => $this->id_echange,
            'mont_echange' => $this->mont_echange,
            'agio' => $this->agio
        );
        return $data;
    }

}

?>
