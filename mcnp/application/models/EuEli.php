<?php
 
class Application_Model_EuEli {

     //put your code here
	 protected $id_eli;
     protected $code_membre;
     protected $numero_eli;
     protected $libelle_eli;
     protected $date_eli;
     protected $bai;
     protected $montant_bai;
     protected $ban;
     protected $montant_ban;
     protected $opi;
     protected $montant_opi;
     protected $montant_eli;
	 protected $montant_vente;
     protected $valider;
     protected $payer;
	 protected $utilisateur;
	 protected $id_canton;
	 protected $rejeter;
	 protected $code_tegc;
     protected $id_tdr;
     protected $propose;
	 protected $type_eli;
	
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
	
	
	public function getId_eli() {
        return $this->id_eli;
    }

    public function setId_eli($id_eli) {
        $this->id_eli = $id_eli;
        return $this;
    }
	
	public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	public function getNumero_eli() {
        return $this->numero_eli;
    }

    public function setNumero_eli($numero_eli) {
        $this->numero_eli = $numero_eli;
        return $this;
    }
	
	public function getLibelle_eli() {
        return $this->libelle_eli;
    }

    public function setLibelle_eli($libelle_eli) {
        $this->libelle_eli = $libelle_eli;
        return $this;
    }
	
	public function getDate_eli() {
        return $this->date_eli;
    }

    public function setDate_eli($date_eli) {
        $this->date_eli = $date_eli;
        return $this;
    }
	
	public function getBai() {
        return $this->bai;
    }

    public function setBai($bai) {
        $this->bai = $bai;
        return $this;
    }
	
    public function getMontant_bai() {
        return $this->montant_bai;
    }

    public function setMontant_bai($montant_bai) {
        $this->montant_bai = $montant_bai;
        return $this;
    } 
	
	public function getBan() {
        return $this->ban;
    }

    public function setBan($ban) {
        $this->ban = $ban;
        return $this;
    }
	
    public function getMontant_ban() {
        return $this->montant_ban;
    }

    public function setMontant_ban($montant_ban) {
        $this->montant_ban = $montant_ban;
        return $this;
    }
	
    public function getOpi() {
        return $this->opi;
    }

    public function setOpi($opi) {
        $this->opi = $opi;
        return $this;
    }
	
    public function getMontant_opi() {
        return $this->montant_opi;
    }

    public function setMontant_opi($montant_opi) {
        $this->montant_opi = $montant_opi;
        return $this;
    }
	
	public function getMontant_eli() {
        return $this->montant_eli;
    }

    public function setMontant_eli($montant_eli) {
        $this->montant_eli = $montant_eli;
        return $this;
    }
	
	public function getMontant_vente() {
        return $this->montant_vente;
    }

    public function setMontant_vente($montant_vente) {
        $this->montant_vente = $montant_vente;
        return $this;
    }
	
	
	public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
        return $this;
    }
   
    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }
	
	public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
        return $this;
    }
	
	
	public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	public function getRejeter() {
        return $this->rejeter;
    }

    public function setRejeter($rejeter) {
        $this->rejeter = $rejeter;
        return $this;
    }
	
	public function getCode_tegc() {
        return $this->code_tegc;
    }

    public function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }
    
    public function getId_tdr() {
        return $this->id_tdr;
    }

    public function setId_tdr($id_tdr) {
        $this->id_tdr = $id_tdr;
        return $this;
    }
    
    public function getPropose() {
        return $this->propose;
    }

    public function setPropose($propose) {
        $this->propose = $propose;
        return $this;
    }
	
	public function getType_eli() {
        return $this->type_eli;
    }

    public function setType_eli($type_eli) {
        $this->type_eli = $type_eli;
        return $this;
    }
	
	

}

?>
