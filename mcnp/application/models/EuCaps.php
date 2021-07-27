<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCaps
 *
 * @author user
 */
class Application_Model_EuCaps {

    //put your code here
    protected $code_caps;
    protected $code_type_bnp;
    protected $type_caps;
    protected $code_membre_app;
	protected $code_membre_morale_app;
    protected $code_membre_benef;
    protected $id_credit;
    protected $mont_caps;
    protected $mont_fs;
    protected $mont_panu_fs;
    protected $reconst_fs;
    protected $rembourser;
    protected $id_operation;
    protected $periode;
    protected $indexer;
    protected $fs_utiliser;
    protected $fl_utiliser;
    protected $cps_utiliser;
	protected $cps1_utiliser;
	protected $cps2_utiliser;
    protected $date_caps;
    protected $id_utilisateur;
    protected $panu;
	protected $type_op;

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

    public function getCode_caps() {
        return $this->code_caps;
    }

    public function setCode_caps($code_caps) {
        $this->code_caps = $code_caps;
        return $this;
    }

    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    public function getCode_type_bnp() {
        return $this->code_type_bnp;
    }

    public function getType_caps() {
        return $this->type_caps;
    }

    public function setType_caps($type_caps) {
        $this->type_caps = $type_caps;
        return $this;
    }

    public function setCode_type_bnp($code_type_bnp) {
        $this->code_type_bnp = $code_type_bnp;
        return $this;
    }

    public function getCode_membre_app() {
        return $this->code_membre_app;
    }

    public function setCode_membre_app($code_membre_app) {
        $this->code_membre_app = $code_membre_app;
        return $this;
    }
	
	public function getCode_membre_morale_app() {
        return $this->code_membre_morale_app;
    }

    public function setCode_membre_morale_app($code_membre_morale_app) {
        $this->code_membre_morale_app = $code_membre_morale_app;
        return $this;
    }

    public function getCode_membre_benef() {
        return $this->code_membre_benef;
    }

    public function setCode_membre_benef($code_membre_benef) {
        $this->code_membre_benef = $code_membre_benef;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getMont_caps() {
        return $this->mont_caps;
    }

    public function setMont_caps($mont_caps) {
        $this->mont_caps = $mont_caps;
        return $this;
    }

    public function getMont_panu_fs() {
        return $this->mont_panu_fs;
    }

    public function setMont_panu_fs($mont_panu_fs) {
        $this->mont_panu_fs = $mont_panu_fs;
        return $this;
    }
    
    public function getReconst_fs() {
        return $this->reconst_fs;
    }

    public function setReconst_fs($reconst_fs) {
        $this->reconst_fs = $reconst_fs;
        return $this;
    }
    
    public function getMont_fs() {
        return $this->mont_fs;
    }

    public function setMont_fs($mont_fs) {
        $this->mont_fs = $mont_fs;
        return $this;
    }

    public function getRembourser() {
        return $this->rembourser;
    }

    public function setRembourser($rembourser) {
        $this->rembourser = $rembourser;
        return $this;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }

    public function getIndexer() {
        return $this->indexer;
    }

    public function setIndexer($indexer) {
        $this->indexer = $indexer;
        return $this;
    }

    public function getFs_utiliser() {
        return $this->fs_utiliser;
    }

    public function setFs_utiliser($fs_utiliser) {
        $this->fs_utiliser = $fs_utiliser;
        return $this;
    }

    public function getFl_utiliser() {
        return $this->fl_utiliser;
    }

    public function setFl_utiliser($fl_utiliser) {
        $this->fl_utiliser = $fl_utiliser;
        return $this;
    }

    public function getCps_utiliser() {
        return $this->cps_utiliser;
    }

    public function setCps_utiliser($cps_utiliser) {
        $this->cps_utiliser = $cps_utiliser;
        return $this;
    }
	
	

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDate_caps() {
        return $this->date_caps;
    }

    public function setDate_caps($date_caps) {
        $this->date_caps = $date_caps;
        return $this;
    }
    
    public function getPanu(){
        return $this->panu;
    }
    
    public function setPanu($panu){
        $this->panu = $panu;
        return $this;
    }
	
	
	public function getType_op(){
        return $this->type_op;
    }
    
    public function setType_op($type_op){
        $this->type_op = $type_op;
        return $this;
    }
	
	
	

}

?>
