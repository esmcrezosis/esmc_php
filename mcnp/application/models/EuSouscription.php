<?php
 
class Application_Model_EuSouscription {

    //put your code here
    protected $souscription_id;
    protected $souscription_nom;
    protected $souscription_prenom;
    protected $souscription_mobile;
    protected $souscription_membreasso;
    protected $souscription_email;
    protected $souscription_raison;
    protected $souscription_numero;
    protected $souscription_date_numero;
    protected $souscription_type;
    protected $souscription_banque;
    protected $souscription_date;
    protected $souscription_personne;
    protected $souscription_montant;
    protected $souscription_nombre;
    protected $souscription_programme;
    protected $souscription_vignette;
    protected $souscription_type_candidat;
    protected $souscription_filiere;
    protected $code_type_acteur;
    protected $code_statut;
    protected $id_metier;
    protected $id_competence;
    protected $code_activite;
    protected $souscription_quartier;
    protected $souscription_ville;
    protected $souscription_login;
    protected $souscription_passe;
    protected $souscription_souscription;
    protected $souscription_autonome;
    protected $souscription_ordre;
    protected $souscription_ancien_membre;
    protected $publier;
    protected $id_canton;
    protected $erreur;
    protected $erreurdescription;
    protected $quittance_invalide;
    protected $id_postulat;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getSouscription_id() {
        return $this->souscription_id;
    }

    public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getSouscription_nom() {
        return htmlentities($this->souscription_nom);
    }

    public function setSouscription_nom($souscription_nom) {
        $this->souscription_nom = html_entity_decode($souscription_nom);
        return $this;
    }

    public function getSouscription_prenom() {
        return htmlentities($this->souscription_prenom);
    }

    public function setSouscription_prenom($souscription_prenom) {
        $this->souscription_prenom = html_entity_decode($souscription_prenom);
        return $this;
    }

    public function getSouscription_mobile() {
        return $this->souscription_mobile;
    }

    public function setSouscription_mobile($souscription_mobile) {
        $this->souscription_mobile = $souscription_mobile;
        return $this;
    }

    public function getSouscription_membreasso() {
        return $this->souscription_membreasso;
    }

    public function setSouscription_membreasso($souscription_membreasso) {
        $this->souscription_membreasso = $souscription_membreasso;
        return $this;
    }

    public function getSouscription_email() {
        return htmlentities($this->souscription_email);
    }

    public function setSouscription_email($souscription_email) {
        $this->souscription_email = html_entity_decode($souscription_email);
        return $this;
    }

    public function getSouscription_raison() {
        return htmlentities($this->souscription_raison);
    }

    public function setSouscription_raison($souscription_raison) {
        $this->souscription_raison = html_entity_decode($souscription_raison);
        return $this;
    }

    public function getSouscription_numero() {
        return $this->souscription_numero;
    }

    public function setSouscription_numero($souscription_numero) {
        $this->souscription_numero = $souscription_numero;
        return $this;
    }

    public function getSouscription_date_numero() {
        return $this->souscription_date_numero;
    }

    public function setSouscription_date_numero($souscription_date_numero) {
        $this->souscription_date_numero = $souscription_date_numero;
        return $this;
    }

    public function getSouscription_type() {
        return $this->souscription_type;
    }

    public function setSouscription_type($souscription_type) {
        $this->souscription_type = $souscription_type;
        return $this;
    }

    public function getSouscription_date() {
        return $this->souscription_date;
    }

    public function setSouscription_date($souscription_date) {
        $this->souscription_date = $souscription_date;
        return $this;
    }

    public function getSouscription_personne() {
        return $this->souscription_personne;
    }

    public function setSouscription_personne($souscription_personne) {
        $this->souscription_personne = $souscription_personne;
        return $this;
    }

    public function getSouscription_montant() {
        return $this->souscription_montant;
    }

    public function setSouscription_montant($souscription_montant) {
        $this->souscription_montant = $souscription_montant;
        return $this;
    }

    public function getSouscription_nombre() {
        return $this->souscription_nombre;
    }

    public function setSouscription_nombre($souscription_nombre) {
        $this->souscription_nombre = $souscription_nombre;
        return $this;
    }

    public function getSouscription_programme() {
        return $this->souscription_programme;
    }

    public function setSouscription_programme($souscription_programme) {
        $this->souscription_programme = $souscription_programme;
        return $this;
    }

    public function getSouscription_vignette() {
        return $this->souscription_vignette;
    }

    public function setSouscription_vignette($souscription_vignette) {
        $this->souscription_vignette = $souscription_vignette;
        return $this;
    }

    public function getSouscription_banque() {
        return $this->souscription_banque;
    }

    public function setSouscription_banque($souscription_banque) {
        $this->souscription_banque = $souscription_banque;
        return $this;
    }

    public function getSouscription_type_candidat() {
        return $this->souscription_type_candidat;
    }

    public function setSouscription_type_candidat($souscription_type_candidat) {
        $this->souscription_type_candidat = $souscription_type_candidat;
        return $this;
    }

    public function getSouscription_filiere() {
        return $this->souscription_filiere;
    }

    public function setSouscription_filiere($souscription_filiere) {
        $this->souscription_filiere = $souscription_filiere;
        return $this;
    }

    function getCode_type_acteur() {
        return $this->code_type_acteur;
    }

    function setCode_type_acteur($code_type_acteur) {
        $this->code_type_acteur = $code_type_acteur;
        return $this;
    }

    function getCode_statut() {
        return $this->code_statut;
    }

    function setCode_statut($code_statut) {
        $this->code_statut = $code_statut;
        return $this;
    }

    function getCode_activite() {
        return $this->code_activite;
    }

    function setCode_activite($code_activite) {
        $this->code_activite = $code_activite;
        return $this;
    }

    function getId_competence() {
        return $this->id_competence;
    }

    function setId_competence($id_competence) {
        $this->id_competence = $id_competence;
        return $this;
    }

    function getId_metier() {
        return $this->id_metier;
    }

    function setId_metier($id_metier) {
        $this->id_metier = $id_metier;
        return $this;
    }
	
    public function getSouscription_ville() {
        return $this->souscription_ville;
    }

    public function setSouscription_ville($souscription_ville) {
        $this->souscription_ville = $souscription_ville;
        return $this;
    }

    public function getSouscription_quartier() {
        return $this->souscription_quartier;
    }

    public function setSouscription_quartier($souscription_quartier) {
        $this->souscription_quartier = $souscription_quartier;
        return $this;
    }

    public function getSouscription_login() {
        return $this->souscription_login;
    }

    public function setSouscription_login($souscription_login) {
        $this->souscription_login = $souscription_login;
        return $this;
    }

    public function getSouscription_passe() {
        return $this->souscription_passe;
    }

    public function setSouscription_passe($souscription_passe) {
        $this->souscription_passe = $souscription_passe;
        return $this;
    }

    public function getSouscription_souscription() {
        return $this->souscription_souscription;
    }

    public function setSouscription_souscription($souscription_souscription) {
        $this->souscription_souscription = $souscription_souscription;
        return $this;
    }

    public function getSouscription_autonome() {
        return $this->souscription_autonome;
    }

    public function setSouscription_autonome($souscription_autonome) {
        $this->souscription_autonome = $souscription_autonome;
        return $this;
    }

    public function getSouscription_ordre() {
        return $this->souscription_ordre;
    }

    public function setSouscription_ordre($souscription_ordre) {
        $this->souscription_ordre = $souscription_ordre;
        return $this;
    }

    public function getSouscription_ancien_membre() {
        return $this->souscription_ancien_membre;
    }

    public function setSouscription_ancien_membre($souscription_ancien_membre) {
        $this->souscription_ancien_membre = $souscription_ancien_membre;
        return $this;
    }
	
	public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	

    public function getErreur() {
        return $this->erreur;
    }

    public function setErreur($erreur) {
        $this->erreur = $erreur;
        return $this;
    }
	

    public function getErreurdescription() {
        return $this->erreurdescription;
    }

    public function setErreurdescription($erreurdescription) {
        $this->erreurdescription = $erreurdescription;
        return $this;
    }
	
	public function getQuittance_invalide() {
        return $this->quittance_invalide;
    }

    public function setQuittance_invalide($quittance_invalide) {
        $this->quittance_invalide = $quittance_invalide;
        return $this;
    }


    public function getId_postulat() {
        return $this->id_postulat;
    }

    public function setId_postulat($id_postulat) {
        $this->id_postulat = $id_postulat;
        return $this;
    }
	
	
	
	
	


}

?>
