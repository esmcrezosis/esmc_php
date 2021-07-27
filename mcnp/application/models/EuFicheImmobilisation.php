<?php
class Application_Model_EuFicheImmobilisation {
	
	protected $id_fiche_immobilisation;
    protected $designation_immobilisation;
    protected $nature_immobilisation;
    protected $famille_immobilisation;
    protected $code_identification;
    protected $lieu_affectation;
    protected $date_entree;
    protected $valeur_acquisition;
    protected $source_financement;
    protected $date_sortie;
    protected $etat_utilisation;
    protected $observations ;
	protected $id_pvacquisition;
    protected $id_pvrestitution;
    protected $restituer;
	protected $traiter;
	protected $date_codification;
	protected $date_creation;

  
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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
	
	
	function getId_fiche_immobilisation() {
      return $this->id_fiche_immobilisation;
    }
    
    function setId_fiche_immobilisation($id_fiche_immobilisation) {
      $this->id_fiche_immobilisation = $id_fiche_immobilisation;
      return $this;
    }
	

    function getDesignation_immobilisation(){
      return $this->designation_immobilisation;
    }
    
    function setDesignation_immobilisation($designation_immobilisation){
        $this->designation_immobilisation = $designation_immobilisation;
        return $this;
    }
    
    function getNature_immobilisation(){
        return $this->nature_immobilisation;
    }
    
    function setNature_immobilisation($nature_immobilisation){
        $this->nature_immobilisation = $nature_immobilisation;
        return $this;
    }
        
    function getFamille_immobilisation(){
        return $this->famille_immobilisation;
    }
    
    function setFamille_immobilisation($famille_immobilisation){
        $this->famille_immobilisation = $famille_immobilisation;
        return $this;
    }
    
    function getCode_identification(){
        return $this->code_identification;
    }
    
    function setCode_identification($code_identification){
        $this->code_identification = $code_identification;
        return $this;
    }

    function getLieu_affectation(){
        return $this->lieu_affectation;
    }
    
    function setLieu_affectation($lieu_affectation){
        $this->lieu_affectation = $lieu_affectation;
        return $this;
    }

    function getDate_entree(){
        return $this->date_entree;
    } 

    function setDate_entree($date_entree){
        $this->date_entree = $date_entree;
        return $this;
    }

    function getValeur_acquisition(){
        return $this->valeur_acquisition;
    }
    
    function setValeur_acquisition($valeur_acquisition){
        $this->valeur_acquisition = $valeur_acquisition;
        return $this;
    }
    
    function getSource_financement(){
        return $this->source_financement;
    }
    
    function setSource_financement($source_financement){
        $this->source_financement = $source_financement;
        return $this;
    }

    function getDate_sortie(){
        return $this->date_sortie;
    }
    
    function setDate_sortie($date_sortie){
        $this->date_sortie = $date_sortie;
        return $this;
    }

    

    function  getEtat_utilisation(){
        return $this->etat_utilisation ;
    }

    function setEtat_utilisation($etat_utilisation){
        $this->etat_utilisation = $etat_utilisation ;
        return $this ;
    }

    function getObservations(){
        return $this->observations ;
    }

    function setObservations($observations){
        $this->observations = $observations ;
        return $this ;
    }
	
	function  getId_pvacquisition(){
        return $this->id_pvacquisition;
    }

    function setId_pvacquisition($id_pvacquisition){
        $this->id_pvacquisition = $id_pvacquisition ;
        return $this ;
    }
	
	function  getId_pvrestitution(){
        return $this->id_pvrestitution;
    }

    function setId_pvrestitution($id_pvrestitution){
        $this->id_pvrestitution = $id_pvrestitution;
        return $this ;
    }
	
	function  getRestituer() {
        return $this->restituer;
    }

    function setRestituer($restituer) {
        $this->restituer = $restituer;
        return $this ;
    }
	
	function  getDate_codification(){
        return $this->date_codification;
    }

    function setDate_codification($date_codification){
        $this->date_codification = $date_codification;
        return $this ;
    }
	
	function  getTraiter() {
        return $this->traiter;
    }

    function setTraiter($traiter) {
        $this->traiter = $traiter;
        return $this ;
    }
	
	
	function  getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this ;
    }
	
	
	
	
	
}


