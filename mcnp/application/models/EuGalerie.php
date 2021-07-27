<?php
 
class Application_Model_EuGalerie {

    //put your code here
    protected $id_galerie;
    protected $titre;
    protected $resume;
    protected $statut;
	protected $date_galerie;
    
	
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

    
    public function getId_galerie() {
        return $this->id_galerie;
    }

    public function setId_galerie($id_galerie) {
        $this->id_galerie = $id_galerie;
        return $this;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }
	
    public function getResume() {
        return $this->resume;
    }

    public function setResume($resume) {
        $this->resume = $resume;
        return $this;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }
	
	public function getDate_galerie() {
        return $this->date_galerie;
    }

    public function setDate_galerie($date_galerie) {
        $this->date_galerie = $date_galerie;
        return $this;
    }
	
	
	

    

}

?>
