<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailGcpPbf
 *
 * @author user
 */
class Application_Model_EuDetailGcpPbf {

    //put your code here
    protected $id_gcp_pbf;
    protected $type_capa;
    protected $code_gcp_pbf;
    protected $mont_gcp_pbf;
    protected $mont_preleve;
    protected $solde_gcp_pbf;
    protected $id_credit;
    protected $source_credit;
    protected $agio;
	protected $compensable;
	protected $id_echange;
	protected $id_escompte;

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

    public function getId_gcp_pbf() {
        return $this->id_gcp_pbf;
    }

    public function setId_gcp_pbf($id_gcp_pbf) {
        $this->id_gcp_pbf = $id_gcp_pbf;
        return $this;
    }

    public function getType_capa() {
        return $this->type_capa;
    }

    public function setType_capa($type_capa) {
        $this->type_capa = $type_capa;
        return $this;
    }

    public function getCode_gcp_pbf() {
        return $this->code_gcp_pbf;
    }

    public function setCode_gcp_pbf($code_gcp_pbf) {
        $this->code_gcp_pbf = $code_gcp_pbf;
        return $this;
    }

    public function getMont_gcp_pbf() {
        return $this->mont_gcp_pbf;
    }

    public function setMont_gcp_pbf($mont_gcp_pbf) {
        $this->mont_gcp_pbf = $mont_gcp_pbf;
        return $this;
    }

    public function getMont_preleve() {
        return $this->mont_preleve;
    }

    public function setMont_preleve($mont_preleve) {
        $this->mont_preleve = $mont_preleve;
        return $this;
    }

    public function getSolde_gcp_pbf() {
        return $this->solde_gcp_pbf;
    }

    public function setSolde_gcp_pbf($solde_gcp_pbf) {
        $this->solde_gcp_pbf = $solde_gcp_pbf;
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
    
    public function getAgio(){
        return $this->agio;
    }
    
    public function setAgio($agio){
        $this->agio = $agio;
        return $this;
    }
	
	public function getCompensable(){
        return $this->compensable;
    }
    
    public function setCompensable($compensable){
        $this->compensable = $compensable;
        return $this;
    }
	
	public function getId_echange() {
        return $this->id_echange;
    }

    public function setId_echange($id_echange) {
        $this->id_echange = $id_echange;
        return $this;
    }
	
	public function getId_escompte() {
        return $this->id_escompte;
    }

    public function setId_escompte($id_escompte) {
        $this->id_escompte = $id_escompte;
        return $this;
    }
	
	
	

    public function exchangeArray($data) {
        $this->id_credit = (isset($data['id_credit'])) ? $data['id_credit'] : NULL;
        $this->source_credit = (isset($data['source_credit'])) ? $data['source_credit'] : NULL;
        $this->code_gcp_pbf = (isset($data['code_gcp_pbf'])) ? $data['code_gcp_pbf'] : NULL;
        $this->id_gcp_pbf = (isset($data['id_gcp_pbf'])) ? $data['id_gcp_pbf'] : NULL;
        $this->mont_gcp_pbf = (isset($data['mont_gcp_pbf'])) ? $data['mont_gcp_pbf'] : NULL;
        $this->mont_preleve = (isset($data['mont_preleve'])) ? $data['mont_preleve'] : NULL;
        $this->solde_gcp_pbf = (isset($data['solde_gcp_pbf'])) ? $data['solde_gcp_pbf'] : NULL;
        $this->type_capa = (isset($data['type_capa'])) ? $data['type_capa'] : NULL;
        $this->agio = (isset($data['agio'])) ? $data['agio'] : NULL;
		$this->agio = (isset($data['compensable'])) ? $data['compensable'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_credit' => $this->id_credit,
            'source_credit' => $this->source_credit,
            'code_gcp_pbf' => $this->code_gcp_pbf,
            'id_gcp_pbf' => $this->id_gcp_pbf,
            'mont_gcp_pbf' => $this->mont_gcp_pbf,
            'mont_preleve' => $this->mont_preleve,
            'solde_gcp_pbf' => $this->solde_gcp_pbf,
            'type_capa' => $this->type_capa,
            'agio' => $this->agio,
			'compensable' => $this->compensable
        );
        return $data;
    }



////////////////////////////////////////////////////////////////
    public function fetchAll2($code_membre, $type_capa) {
		$table = new Application_Model_DbTable_EuDetailGcpPbf;
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where("code_gcp_pbf LIKE '%".$code_membre."'");}
		if(isset($type_capa) && $type_capa!=""){
        $select->where('type_capa LIKE ?', $type_capa);}
        $select->order(array('id_gcp_pbf DESC'));
		$select->limit(250);
        $resultSet = $table->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailGcpPbf();
            $entry->setId_gcp_pbf($row->id_gcp_pbf)
                    ->setCode_gcp_pbf($row->code_gcp_pbf)
                    ->setId_credit($row->id_credit)
                    ->setMont_gcp_pbf($row->mont_gcp_pbf)
                    ->setSolde_gcp_pbf($row->solde_gcp_pbf)
                    ->setMont_preleve($row->mont_preleve)
                    ->setType_capa($row->type_capa)
                    ->setSource_credit($row->source_credit)
                    ->setAgio($row->agio);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByTypeCapaSolde($code_membre, $type_capa, Application_Model_EuDetailGcpPbf $DetailGcpPbf) {
        $table = new Application_Model_DbTable_EuDetailGcpPbf();
        $select = $table->select();
		$select->from(array('eu_detail_gcp_pbf'), array('code_gcp_pbf', 'type_capa', 'solde' => 'SUM(solde_GCP_PBF)'));
        $select->group(array('code_gcp_pbf', 'type_capa'));
		if(isset($code_membre) && $code_membre!=""){        
		$select->having("code_gcp_pbf LIKE '%".$code_membre."'");}
		if(isset($type_capa) && $type_capa!=""){		
		$select->having('type_capa LIKE ?', $type_capa);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $DetailGcpPbf->setType_capa($row->type_capa)
                ->setSolde_gcp_pbf($row->solde)
                    ->setCode_gcp_pbf($row->code_gcp_pbf);
        return true;
    }


}

?>
