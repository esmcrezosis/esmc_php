<?php
 
class Application_Model_EuPostulat {

    //put your code here
    protected $id_postulat;
    protected $code_membre;
    protected $id_type_candidat;
    protected $date_postulat;
    protected $nom_postulat;
    protected $prenom_postulat;
    protected $raison_postulat;
    protected $code_zone;
    protected $id_pays;
    protected $id_region;
    protected $id_prefecture;
    protected $id_canton;
    protected $traiter;
    protected $email_postulat;
    protected $mobile_postulat;
    protected $code_postulat;
    protected $utilisateur;
    
	
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
	
    
    public function getId_postulat() {
        return $this->id_postulat;
    }

    public function setId_postulat($id_postulat) {
        $this->id_postulat = $id_postulat;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
    public function getId_type_candidat() {
        return $this->id_type_candidat;
    }

    public function setId_type_candidat($id_type_candidat) {
        $this->id_type_candidat = $id_type_candidat;
        return $this;
    }
	
    public function getDate_postulat() {
        return $this->date_postulat;
    }

    public function setDate_postulat($date_postulat) {
        $this->date_postulat = $date_postulat;
        return $this;
    }
	
    public function getNom_postulat() {
      return $this->nom_postulat;
    }

    public function setNom_postulat($nom_postulat) {
      $this->nom_postulat = $nom_postulat;
      return $this;
    }
	
	
    public function getPrenom_postulat() {
        return $this->prenom_postulat;
    }

    public function setPrenom_postulat($prenom_postulat) {
        $this->prenom_postulat = $prenom_postulat;
        return $this;
    }
	
    public function getRaison_postulat() {
        return $this->raison_postulat;
    }

    public function setRaison_postulat($raison_postulat) {
        $this->raison_postulat = $raison_postulat;
        return $this;
    }
	

    public function getCode_zone() {
        return $this->code_zone;
    }

    public function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        return $this;
    }

   
    public function getId_pays() {
        return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	public function getId_region() {
        return $this->id_region;
    }

    public function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }
	
    public function getId_prefecture() {
        return $this->id_prefecture;
    }

    public function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }
	
    public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
    public function getTraiter() {
        return $this->traiter;
    }

    public function setTraiter($traiter) {
        $this->traiter = $traiter;
        return $this;
    }
	
	
    public function getEmail_postulat() {
        return $this->email_postulat;
    }

    public function setEmail_postulat($email_postulat) {
        $this->email_postulat = $email_postulat;
        return $this;
    }
	
	public function getMobile_postulat() {
        return $this->mobile_postulat;
    }

    public function setMobile_postulat($mobile_postulat) {
        $this->mobile_postulat = $mobile_postulat;
        return $this;
    }
	
	
    public function getCode_postulat() {
      return $this->code_postulat;
    }

    public function setCode_postulat($code_postulat)  {
        $this->code_postulat = $code_postulat;
        return $this;
    }

    public function getUtilisateur() {
      return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur)  {
        $this->utilisateur = $utilisateur;
        return $this;
    }

	

}

?>
