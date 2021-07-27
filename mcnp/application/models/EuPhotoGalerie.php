<?php
 
class Application_Model_EuPhotoGalerie {

    //put your code here
    protected $id_photo_galerie;
    protected $id_galerie;
	protected $libelle;
    protected $photo;
    protected $statut;
	protected $date_photo;
   
   
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

	
	
    
    public function getId_photo_galerie() {
        return $this->id_photo_galerie;
    }

    public function setId_photo_galerie($id_photo_galerie) {
        $this->id_photo_galerie = $id_photo_galerie;
        return $this;
    }

	
	
    public function getId_galerie() {
        return $this->id_galerie;
    }

    public function setId_galerie($id_galerie) {
        $this->id_galerie = $id_galerie;
        return $this;
    }
	
    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
        return $this;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }
	
    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }
	
	
	public function getDate_photo() {
        return $this->date_photo;
    }

    public function setDate_photo($date_photo) {
        $this->date_photo = $date_photo;
        return $this;
    }

}

?>
