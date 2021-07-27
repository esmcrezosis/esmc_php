<?php
 
class Application_Model_EuContratLivraisonIrrevocable {

    //put your code here
    protected $id_contrat;
    protected $code_membre;
    protected $numero_contrat;
    protected $periode_garde;
    protected $chargement_produit;
    protected $date_contrat;
    protected $statut;
	protected $valider;
    protected $bai;
    protected $montant_bai;
    protected $ban;
    protected $montant_ban;
    protected $opi;
    protected $montant_opi;
    protected $montant_contrat;
    
	
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

    public function getId_contrat() {
        return $this->id_contrat;
    }

    public function setId_contrat($id_contrat) {
        $this->id_contrat = $id_contrat;
        return $this;
    }

    public function getCode_membre() {
        return ($this->code_membre);
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = ($code_membre);
        return $this;
    }

    public function getNumero_contrat() {
        return $this->numero_contrat;
    }

    public function setNumero_contrat($numero_contrat) {
        $this->numero_contrat = $numero_contrat;
        return $this;
    }


    public function getChargement_produit() {
        return $this->chargement_produit;
    }

    public function setChargement_produit($chargement_produit) {
        $this->chargement_produit = $chargement_produit;
        return $this;
    }

    public function getDate_contrat() {
        return $this->date_contrat;
    }

    public function setDate_contrat($date_contrat) {
        $this->date_contrat = $date_contrat;
        return $this;
    }


    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }
	
	public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
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
	
	
	public function getMontant_contrat() {
        return $this->montant_contrat;
    }

    public function setMontant_contrat($montant_contrat) {
        $this->montant_contrat = $montant_contrat;
        return $this;
    }
	

}

?>
