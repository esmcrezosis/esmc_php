<?php

class Application_Model_EuAncienFs {

    protected $code_fs;
    protected $code_membre;
    protected $code_membre_morale;
    protected $mont_fs;
    protected $date_fs;
    protected $heure_fs;
    protected $id_utilisateur;
    protected $creditcode;

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

    function getCode_fs() {
        return $this->code_fs;
    }

    function setCode_fs($code_fs) {
        $this->code_fs = $code_fs;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale =  $code_membre_morale;
        return $this;
    }
    
    function getMont_fs() {
        return $this->mont_fs;
    }

    function setMont_fs($mont_fs) {
        $this->mont_fs =  $mont_fs;
        return $this;
    }

    function getDate_fs() {
        return $this->date_fs;
    }

    function setDate_fs($date_fs) {
        $this->date_fs =  $date_fs;
        return $this;
    }

    function getHeure_fs() {
        return $this->heure_fs;
    }

    function setHeure_fs($heure_fs) {
        $this->heure_fs =  $heure_fs;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getCreditcode(){
        return $this->creditcode;
    }
    
    public function setCreditcode($creditcode){
        $this->creditcode = $creditcode;
        return $this;
    }

    public function exchangeArray($data) {
        $this->code_fs = (isset($data['code_fs'])) ? $data['code_fs'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
		$this->code_membre_morale = (isset($data['code_membre_morale'])) ? $data['code_membre_morale'] : NULL;
        $this->creditcode = (isset($data['creditcode'])) ? $data['creditcode'] : NULL;
        $this->mont_fs = (isset($data['mont_fs'])) ? $data['mont_fs'] : NULL;
        $this->date_fs = (isset($data['date_fs'])) ? $data['date_fs'] : NULL;
        $this->heure_fs = (isset($data['heure_fs'])) ? $data['heure_fs'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
    }

    public function toArray() {
       $data = array(
        'code_fs' => $this->code_fs,
        'creditcode' => $this->creditcode,
        'code_membre' => $this->code_membre,
		'code_membre_morale' => $this->code_membre_morale,
        'mont_fs' => $this->mont_fs,
        'date_fs' => $this->date_fs,
        'heure_fs' => $this->heure_fs,
        'id_utilisateur' => $this->id_utilisateur
      );
        return $data;
    }

}

