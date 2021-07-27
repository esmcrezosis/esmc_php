<?php

class Application_Model_EuAppeloffres {

    //put your code here
    protected $id_appeloffres;
    protected $id_document;
    protected $num_appeloffres;
    protected $libelle_appeloffres;
    protected $desc_appeloffres;
    protected $date_appeloffres;
    protected $preselection;
    protected $id_utilisateur;
    protected $selection;
    protected $code_membre_morale;
    protected $propo;
    protected $okfinal;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
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

    public function getId_appeloffres() {
        return $this->id_appeloffres;
    }

    public function setId_appeloffres($id_appeloffres) {
        $this->id_appeloffres = $id_appeloffres;
        return $this;
    }

    public function getNum_appeloffres() {
        return $this->num_appeloffres;
    }

    public function setNum_appeloffres($num_appeloffres) {
        $this->num_appeloffres = $num_appeloffres;
        return $this;
    }

    public function getDesc_appeloffres() {
        return $this->desc_appeloffres;
    }

    public function setDesc_appeloffres($desc_appeloffres) {
        $this->desc_appeloffres = $desc_appeloffres;
        return $this;
    }

    public function getDate_appeloffres() {
        return $this->date_appeloffres;
    }

    public function setDate_appeloffres($date_appeloffres) {
        $this->date_appeloffres = $date_appeloffres;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getPreselection() {
        return $this->preselection;
    }

    public function setPreselection($preselection) {
        $this->preselection = $preselection;
        return $this;
    }

    public function getId_document() {
        return $this->id_document;
    }

    public function setId_document($id_document) {
        $this->id_document = $id_document;
        return $this;
    }

    public function getLibelle_appeloffres() {
        return $this->libelle_appeloffres;
    }

    public function setLibelle_appeloffres($libelle_appeloffres) {
        $this->libelle_appeloffres = $libelle_appeloffres;
        return $this;
    }

    public function getSelection() {
        return $this->selection;
    }

    public function setSelection($selection) {
        $this->selection = $selection;
        return $this;
    }
	
    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    public function getPropo() {
        return $this->propo;
    }

    public function setPropo($propo) {
        $this->propo = $propo;
        return $this;
    }

    public function getOkfinal() {
        return $this->okfinal;
    }

    public function setOkfinal($okfinal) {
        $this->okfinal = $okfinal;
        return $this;
    }
	
}

?>
