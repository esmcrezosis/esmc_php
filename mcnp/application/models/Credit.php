<?php
 
class Application_Model_Credit {

    //put your code here
    protected $codecredi;
    protected $montantcredi;
    protected $membre;
    protected $libelle;
    protected $montplace;
    protected $datefin;
    protected $datedeb;
    protected $val;
    protected $periode;
    protected $source;
    protected $dateoctroi;
    protected $agence;
    protected $inn;

	
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

	
    public function getCodecredi() {
        return $this->codecredi;
    }

    public function setCodecredi($codecredi) {
        $this->codecredi = $codecredi;
        return $this;
    }

    public function getMontantcredi() {
        return $this->montantcredi;
    }

    public function setMontantcredi($montantcredi) {
        $this->montantcredi = $montantcredi;
        return $this;
    }
	
    public function getMembre() {
        return $this->membre;
    }

    public function setMembre($membre) {
        $this->membre = $membre;
        return $this;
    }


    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
        return $this;
    }
	
    public function getMontplace() {
        return $this->montplace;
    }

    public function setMontplace($montplace) {
        $this->montplace = $montplace;
        return $this;
    }

    public function getDatefin() {
        return $this->datefin;
    }

    public function setDatefin($datefin) {
        $this->datefin = $datefin;
        return $this;
    }

    public function getDatedeb() {
        return $this->datedeb;
    }

    public function setDatedeb($datedeb) {
        $this->datedeb = $datedeb;
        return $this;
    }
	
    public function getVal() {
        return $this->val;
    }

    public function setVal($val) {
        $this->val = $val;
        return $this;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
        return $this;
    }

    public function getDateoctroi() {
        return $this->dateoctroi;
    }

    public function setDateoctroi($dateoctroi) {
        $this->dateoctroi = $dateoctroi;
        return $this;
    }

    public function getAgence() {
        return $this->agence;
    }

    public function setAgence($agence) {
        $this->agence = $agence;
        return $this;
    }

    public function getInn() {
        return $this->inn;
    }

    public function setInn($inn) {
        $this->inn = $inn;
        return $this;
    }

}

?>
