<?php
 
class Application_Model_EuMailenvoye {

    //put your code here
    protected $mailenvoye_id;
    protected $mailenvoye_emetteur;
    protected $mailenvoye_recepteur;
    protected $mailenvoye_objet;
    protected $mailenvoye_contenu;
	protected $mailenvoye_date;
    
	
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
	
    
    public function getMailenvoye_id() {
        return $this->mailenvoye_id;
    }

    public function setMailenvoye_id($mailenvoye_id) {
        $this->mailenvoye_id = $mailenvoye_id;
        return $this;
    }

    public function getMailenvoye_emetteur() {
        return $this->mailenvoye_emetteur;
    }

    public function setMailenvoye_emetteur($mailenvoye_emetteur) {
        $this->mailenvoye_emetteur = $mailenvoye_emetteur;
        return $this;
    }
	
    public function getMailenvoye_recepteur() {
        return $this->mailenvoye_recepteur;
    }

    public function setMailenvoye_recepteur($mailenvoye_recepteur) {
        $this->mailenvoye_recepteur = $mailenvoye_recepteur;
        return $this;
    }
	
	protected $mailenvoye_date;
	
    public function getMailenvoye_objet() {
        return $this->mailenvoye_objet;
    }

    public function setMailenvoye_objet($mailenvoye_objet) {
        $this->mailenvoye_objet = $mailenvoye_objet;
        return $this;
    }
	
    public function getMailenvoye_contenu() {
        return $this->mailenvoye_contenu;
    }

    public function setMailenvoye_contenu($mailenvoye_contenu) {
        $this->mailenvoye_contenu = $mailenvoye_contenu;
        return $this;
    }
	
	public function getMailenvoye_date() {
        return $this->mailenvoye_date;
    }

    public function setMailenvoye_date($mailenvoye_date) {
        $this->mailenvoye_date = $mailenvoye_date;
        return $this;
    }

    

}

?>
