<?php
 
class Application_Model_EuMstiers {

    //put your code here
    protected $id_mstiers;
    protected $code_membre;
    protected $montant_souscris;
    protected $montant_utilise;
    protected $montant_restant;
    protected $type_souscription;
    protected $id_souscription;
    protected $date_mstiers;
    protected $bon_neutre_code;
    protected $statut_mstiers;
    protected $type_souscripteur;
    protected $type_mstiers;
	protected $bon_conso;
	protected $frais_solvabilite;
	protected $peripherique;
	protected $connectivite;
	protected $assurance;
	protected $deposit;
	protected $compte_bancaire;
	protected $distributeur_peripherique;
    protected $distributeur_connectivite;
    protected $distributeur_assurance;
	protected $type_kit;
	protected $montant_bc;
	protected $id_cycle_formation;
	protected $montant_peripherique;
	protected $montant_connectivite;
	protected $montant_assurance;
	protected $montant_comptebancaire;


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

    public function getId_mstiers() {
      return $this->id_mstiers;
    }

    public function setId_mstiers($id_mstiers) {
        $this->id_mstiers = $id_mstiers;
        return $this;
    }
	

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
    public function getMontant_souscris() {
        return $this->montant_souscris;
    }

    public function setMontant_souscris($montant_souscris) {
        $this->montant_souscris = $montant_souscris;
        return $this;
    }


    public function getMontant_utilise() {
        return $this->montant_utilise;
    }

    public function setMontant_utilise($montant_utilise) {
        $this->montant_utilise = $montant_utilise;
        return $this;
    }
	
    public function getMontant_restant() {
        return $this->montant_restant;
    }

    public function setMontant_restant($montant_restant) {
        $this->montant_restant = $montant_restant;
        return $this;
    }
	
	
	public function getType_souscription() {
        return $this->type_souscription;
    }

    public function setType_souscription($type_souscription) {
        $this->type_souscription = $type_souscription;
        return $this;
    }
	
	
	public function getId_souscription() {
        return $this->id_souscription;
    }

    public function setId_souscription($id_souscription) {
        $this->id_souscription = $id_souscription;
        return $this;
    }
	
	
	public function getDate_mstiers() {
        return $this->date_mstiers;
    }

    public function setDate_mstiers($date_mstiers) {
        $this->date_mstiers = $date_mstiers;
        return $this;
    }
	
	
	public function getBon_neutre_code() {
        return $this->bon_neutre_code;
    }

    public function setBon_neutre_code($bon_neutre_code) {
        $this->bon_neutre_code = $bon_neutre_code;
        return $this;
    }
	
	
    public function getStatut_mstiers() {
        return $this->statut_mstiers;
    }

    public function setStatut_mstiers($statut_mstiers) {
        $this->statut_mstiers = $statut_mstiers;
        return $this;
    }


    public function getType_souscripteur() {
        return $this->type_souscripteur;
    }

    public function setType_souscripteur($type_souscripteur) {
        $this->type_souscripteur = $type_souscripteur;
        return $this;
    }

    
    public function getType_mstiers() {
        return $this->type_mstiers;
    }

    public function setType_mstiers($type_mstiers) {
        $this->type_mstiers = $type_mstiers;
        return $this;
    }
	
	
	public function getBon_conso() {
        return $this->bon_conso;
    }

    public function setBon_conso($bon_conso) {
        $this->bon_conso = $bon_conso;
        return $this;
    }
	
	public function getFrais_solvabilite() {
        return $this->frais_solvabilite;
    }

    public function setFrais_solvabilite($frais_solvabilite) {
        $this->frais_solvabilite = $frais_solvabilite;
        return $this;
    }
	
	
	public function getPeripherique() {
        return $this->peripherique;
    }

    public function setPeripherique($peripherique) {
        $this->peripherique = $peripherique;
        return $this;
    }
	
	public function getConnectivite() {
        return $this->connectivite;
    }

    public function setConnectivite($connectivite) {
        $this->connectivite = $connectivite;
        return $this;
    }
	
	public function getAssurance() {
        return $this->assurance;
    }

    public function setAssurance($assurance) {
        $this->assurance = $assurance;
        return $this;
    }
	
	public function getDeposit() {
        return $this->deposit;
    }

    public function setDeposit($deposit) {
        $this->deposit = $deposit;
        return $this;
    }
	
	public function getCompte_bancaire() {
        return $this->compte_bancaire;
    }

    public function setCompte_bancaire($compte_bancaire) {
        $this->compte_bancaire = $compte_bancaire;
        return $this;
    }
	
	
	public function getDistributeur_peripherique() {
        return $this->distributeur_peripherique;
    }

    public function setDistributeur_peripherique($distributeur_peripherique) {
        $this->distributeur_peripherique = $distributeur_peripherique;
        return $this;
    }
	
	
	
	public function getDistributeur_connectivite() {
        return $this->distributeur_connectivite;
    }

    public function setDistributeur_connectivite($distributeur_connectivite) {
        $this->distributeur_connectivite = $distributeur_connectivite;
        return $this;
    }
	
	
	public function getDistributeur_assurance() {
        return $this->distributeur_assurance;
    }

    public function setDistributeur_assurance($distributeur_assurance) {
        $this->distributeur_assurance = $distributeur_assurance;
        return $this;
    }
	
	
	public function getType_kit() {
        return $this->type_kit;
    }

    public function setType_kit($type_kit) {
        $this->type_kit = $type_kit;
        return $this;
    }
	
	
	public function getMontant_bc() {
        return $this->montant_bc;
    }

    public function setMontant_bc($montant_bc) {
        $this->montant_bc = $montant_bc;
        return $this;
    }
	
	public function getId_cycle_formation() {
        return $this->id_cycle_formation;
    }

    public function setId_cycle_formation($id_cycle_formation) {
        $this->id_cycle_formation = $id_cycle_formation;
        return $this;
    }
	
	public function getMontant_peripherique() {
        return $this->montant_peripherique;
    }

    public function setMontant_peripherique($montant_peripherique) {
        $this->montant_peripherique = $montant_peripherique;
        return $this;
    }
	
	public function getMontant_connectivite() {
        return $this->montant_connectivite;
    }

    public function setMontant_connectivite($montant_connectivite) {
        $this->montant_connectivite = $montant_connectivite;
        return $this;
    }
	
	public function getMontant_assurance() {
        return $this->montant_assurance;
    }

    public function setMontant_assurance($montant_assurance) {
        $this->montant_assurance = $montant_assurance;
        return $this;
    }
	
	public function getMontant_comptebancaire() {
        return $this->montant_comptebancaire;
    }

    public function setMontant_comptebancaire($montant_comptebancaire) {
        $this->montant_comptebancaire = $montant_comptebancaire;
        return $this;
    }
	

}

?>
