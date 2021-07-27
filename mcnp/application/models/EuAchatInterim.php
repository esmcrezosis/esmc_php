<?php
 
class Application_Model_EuAchatInterim  {

    //put your code here
    protected $id_achat;
    protected $code_achat;
    protected $montant_achat;
    protected $nom_acheteur;
    protected $prenom_acheteur;
    protected $raison_acheteur;
    protected $date_achat;
    protected $code_membre;
    protected $id_utilisateur;
    protected $bon_id;
    protected $status;
	protected $code_ban;
	
	
    public function __construct(array $options = NULL) {
        if(is_array($options)) {
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
	
	

    public function getId_achat() {
      return $this->id_achat;
    }

    public function setId_achat($id_achat) {
        $this->id_achat = $id_achat;
        return $this;
    }
	

    public function getCode_achat() {
        return $this->code_achat;
    }

    public function setCode_achat($code_achat) {
        $this->code_achat = $code_achat;
        return $this;
    }
	
    public function getMontant_achat() {
        return $this->montant_achat;
    }

    public function setMontant_achat($montant_achat) {
        $this->montant_achat = $montant_achat;
        return $this;
    }


    public function getNom_acheteur() {
        return $this->nom_acheteur;
    }

    public function setNom_acheteur($nom_acheteur) {
        $this->nom_acheteur = $nom_acheteur;
        return $this;
    }
	
    public function getPrenom_acheteur() {
        return $this->prenom_acheteur;
    }

    public function setPrenom_acheteur($prenom_acheteur) {
        $this->prenom_acheteur = $prenom_acheteur;
        return $this;
    }
	
	
	public function getRaison_acheteur() {
        return $this->raison_acheteur;
    }

    public function setRaison_acheteur($raison_acheteur) {
        $this->raison_acheteur = $raison_acheteur;
        return $this;
    }
	
	
	public function getDate_achat() {
        return $this->date_achat;
    }

    public function setDate_achat($date_achat) {
        $this->date_achat = $date_achat;
        return $this;
    }
	
	
	public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	
	public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	
	public function getBon_id() {
        return $this->bon_id;
    }

    public function setBon_id($bon_id) {
        $this->bon_id = $bon_id;
        return $this;
    }
	
	
	public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
	
	
	public function getCode_ban() {
        return $this->code_ban;
    }

    public function setCode_ban($code_ban) {
        $this->code_ban = $code_ban;
        return $this;
    }
	
	
	

}

?>
