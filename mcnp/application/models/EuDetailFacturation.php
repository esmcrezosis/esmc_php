<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailFacturation
 *
 * @author mawuli
 */
class Application_Model_EuDetailFacturation {

    //put your code here
    protected $id_detail_facturation;
    protected $date_facturation;
    protected $code_compte;
    protected $id_operation;
    protected $code_membre;
    protected $mont_facturation;
    protected $creditcode;
    protected $id_cnp;

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

    public function getId_detail_facturation() {
        return $this->id_detail_facturation;
    }

    public function setId_detail_facturation($id_detail_facturation) {
        $this->id_detail_facturation = $id_detail_facturation;
        return;
    }

    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    public function getId_cnp() {
        return $this->id_cnp;
    }

    public function setId_cnp($id_cnp) {
        $this->id_cnp = $id_cnp;
        return $this;
    }

    public function getDate_facturation() {
        return $this->date_facturation;
    }

    public function setDate_facturation($date_facturation) {
        $this->date_facturation = $date_facturation;
        return $this;
    }

    public function getCreditcode() {
        return $this->creditcode;
    }

    public function setCreditcode($creditcode) {
        $this->creditcode = $creditcode;
        return $this;
    }

    public function getMont_facturation() {
        return $this->mont_facturation;
    }

    public function setMont_facturation($mont_facturation) {
        $this->mont_facturation = $mont_facturation;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_detail_facturation = (isset($data['id_detail_facturation'])) ? $data['id_detail_facturation'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->creditcode = (isset($data['creditcode'])) ? $data['creditcode'] : NULL;
        $this->mont_facturation = (isset($data['mont_facturation'])) ? $data['mont_facturation'] : NULL;
        $this->code_compte = (isset($data['code_compte'])) ? $data['code_compte'] : NULL;
        $this->id_operation = (isset($data['id_operation'])) ? $data['id_operation'] : NULL;
        $this->date_facturation = (isset($data['date_facturation'])) ? $data['date_facturation'] : NULL;
        $this->id_cnp = (isset($data['id_cnp'])) ? $data['id_cnp'] : 0;
    }

    public function toArray() {
        $data = array(
        'id_detail_facturation' => $this->id_detail_facturation,
        'creditcode' => $this->creditcode,
        'code_membre' => $this->code_membre,
        'mont_facturation' => $this->mont_facturation,
        'code_compte' => $this->code_compte,
        'id_operation' => $this->id_operation,
        'date_facturation' => $this->date_facturation,
        'id_cnp' => $this->id_cnp
        );
        return $data;
    }



    public function findConuter() {
		$tabela = new Application_Model_DbTable_EuDetailFacturation();
        $select = $tabela->select();
        $select->from('eu_detail_facturation', array('MAX(id_detail_facturation) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count']; 
    }


}

?>
