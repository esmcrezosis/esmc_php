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
class Application_Model_EuGcpPbfCompense {

    //put your code here
    protected $id_gcp_compense;
    protected $id_compens;
    protected $code_compte;
    protected $type_capa_gcp;
    protected $type_capa_fgfn;
    protected $mont_compense;
    protected $code_fgfn;
    protected $id_detail_fgfn;
    protected $id_detail_gcppbf;
    protected $mont_gcp_entree;
    protected $mont_fgfn_sortie;
    protected $solde_compens;

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

    public function getId_gcp_compense() {
        return $this->id_gcp_compense;
    }

    public function setId_gcp_compense($id_gcp_compense) {
        $this->id_gcp_compense = $id_gcp_compense;
        return $this;
    }

    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    public function getCode_fgfn() {
        return $this->code_fgfn;
    }

    public function setCode_fgfn($code_fgfn) {
        $this->code_fgfn = $code_fgfn;
        return $this;
    }
    
    public function getId_detail_fgfn() {
        return $this->id_detail_fgfn;
    }

    public function setId_detail_fgfn($id_detail_fgfn) {
        $this->id_detail_fgfn = $id_detail_fgfn;
        return $this;
    }
    
    public function getId_detail_gcppbf() {
        return $this->id_detail_gcppbf;
    }

    public function setId_detail_gcppbf($id_detail_gcppbf) {
        $this->id_detail_gcppbf = $id_detail_gcppbf;
        return $this;
    }

    public function getId_compens() {
        return $this->id_compens;
    }

    public function setId_compens($id_compens) {
        $this->id_compens = $id_compens;
        return $this;
    }

    public function getType_capa_fgfn() {
        return $this->type_capa_fgfn;
    }

    public function setType_capa_fgfn($type_capa_fgfn) {
        $this->type_capa_fgfn = $type_capa_fgfn;
        return $this;
    }
    
    public function getType_capa_gcp() {
        return $this->type_capa_gcp;
    }

    public function setType_capa_gcp($type_capa_gcp) {
        $this->type_capa_gcp = $type_capa_gcp;
        return $this;
    }

    public function getMont_gcp_entree() {
        return $this->mont_gcp_entree;
    }

    public function setMont_gcp_entree($mont_gcp_entree) {
        $this->mont_gcp_entree = $mont_gcp_entree;
        return $this;
    }
    
    public function getMont_fgfn_sortie() {
        return $this->mont_fgfn_sortie;
    }

    public function setMont_fgfn_sortie($mont_fgfn_sortie) {
        $this->mont_fgfn_sortie = $mont_fgfn_sortie;
        return $this;
    }
    
    public function getSolde_compens() {
        return $this->solde_compens;
    }

    public function setSolde_compens($solde_compens) {
        $this->solde_compens = $solde_compens;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_gcp_compense = (isset($data['id_gcp_compense'])) ? $data['id_gcp_compense'] : NULL;
        $this->code_compte = (isset($data['code_compte'])) ? $data['code_compte'] : NULL;
        $this->id_compens = (isset($data['id_compens'])) ? $data['id_compens'] : NULL;
        $this->type_capa_fgfn = (isset($data['type_capa_fgfn'])) ? $data['type_capa_fgfn'] : NULL;
        $this->type_capa_gcp = (isset($data['type_capa_gcp'])) ? $data['type_capa_gcp'] : NULL;
        $this->mont_fgfn_sortie = (isset($data['mont_fgfn_sortie'])) ? $data['mont_fgfn_sortie'] : NULL;
        $this->mont_gcp_entree = (isset($data['mont_gcp_entree'])) ? $data['mont_gcp_entree'] : NULL;
        $this->solde_compens = (isset($data['solde_compens'])) ? $data['solde_compens'] : NULL;
        $this->code_fgfn = (isset($data['code_fgfn'])) ? $data['code_fgfn'] : NULL;
        $this->id_detail_fgfn = (isset($data['id_detail_fgfn'])) ? $data['id_detail_fgfn'] : NULL;
        $this->id_detail_gcppbf = (isset($data['id_detail_gcppbf'])) ? $data['id_detail_gcppbf'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_gcp_compense' => $this->id_gcp_compense,
            'id_compens' => $this->id_compens,
            'code_compte' => $this->code_compte,
            'id_detail_fgfn' => $this->id_detail_fgfn,
            'id_detail_gcppbf' => $this->id_detail_gcppbf,
            'mont_gcp_entree' => $this->mont_gcp_entree,
            'mont_fgfn_sortie' => $this->mont_fgfn_sortie,
            'solde_compens' => $this->solde_compens,
            'type_capa_gcp' => $this->type_capa_gcp,
            'type_capa_fgfn' => $this->type_capa_fgfn,
            'code_fgfn' => $this->code_fgfn
        );
        return $data;
    }

}

?>
