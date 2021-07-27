<?php
 
class Application_Model_EuMstiersListebc {
    
    //put your code here
    protected $id_mstiers_listebc;
    protected $code_membre_apporteur;
    protected $code_membre_beneficiaire;
    protected $type_souscription;
    protected $code_bnp;
	protected $type_liste;
	protected $utilisateur;
    protected $date_listebc;
    protected $statut;
	protected $bon_conso;
	protected $frais_solvabilite;
	protected $peripherique;
	protected $connectivite;
	protected $assurance;
	protected $deposit;
	protected $compte_bancaire;
	protected $type_kit;
	protected $bon_neutre_id;
	protected $nom_membre;
	protected $prenom_membre;
    
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

    public function getId_mstiers_listebc() {
      return $this->id_mstiers_listebc;
    }

    public function setId_mstiers_listebc($id_mstiers_listebc) {
        $this->id_mstiers_listebc = $id_mstiers_listebc;
        return $this;
    }
	

    public function getCode_membre_apporteur() {
        return $this->code_membre_apporteur;
    }

    public function setCode_membre_apporteur($code_membre_apporteur) {
        $this->code_membre_apporteur = $code_membre_apporteur;
        return $this;
    }
	
	
    public function getCode_membre_beneficiaire() {
        return $this->code_membre_beneficiaire;
    }

    public function setCode_membre_beneficiaire($code_membre_beneficiaire) {
        $this->code_membre_beneficiaire = $code_membre_beneficiaire;
        return $this;
    }


    public function getType_souscription() {
        return $this->type_souscription;
    }

    public function setType_souscription($type_souscription) {
        $this->type_souscription = $type_souscription;
        return $this;
    }
	
    public function getMontant_restant() {
        return $this->montant_restant;
    }

    public function setMontant_restant($montant_restant) {
        $this->montant_restant = $montant_restant;
        return $this;
    }
	
	
	public function getCode_bnp() {
        return $this->code_bnp;
    }

    public function setCode_bnp($code_bnp) {
        $this->code_bnp = $code_bnp;
        return $this;
    }
	
	
    public function getDate_listebc() {
        return $this->date_listebc;
    }

    public function setDate_listebc($date_listebc) {
        $this->date_listebc = $date_listebc;
        return $this;
    }
	
	
	public function getType_liste() {
        return $this->type_liste;
    }

    public function setType_liste($type_liste) {
        $this->type_liste = $type_liste;
        return $this;
    }
	
	public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
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
	
	public function getType_kit() {
        return $this->type_kit;
    }

    public function setType_kit($type_kit) {
        $this->type_kit = $type_kit;
        return $this;
    }
	
	
	public function getBon_neutre_id() {
        return $this->bon_neutre_id;
    }

    public function setBon_neutre_id($bon_neutre_id) {
        $this->bon_neutre_id = $bon_neutre_id;
        return $this;
    }
	
	public function getNom_membre() {
        return $this->nom_membre;
    }

    public function setNom_membre($nom_membre) {
        $this->nom_membre = $nom_membre;
        return $this;
    }
	
	public function getPrenom_membre() {
        return $this->prenom_membre;
    }

    public function setPrenom_membre($prenom_membre) {
        $this->prenom_membre = $prenom_membre;
        return $this;
    }
	
    

}

?>
