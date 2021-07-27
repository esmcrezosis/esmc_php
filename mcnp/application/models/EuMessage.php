<?php
 
class Application_Model_EuMessage {

    //put your code here
    protected $id_message;
    protected $titre_message;
    protected $description_message;
    protected $date_message;
    protected $code_membre_expediteur;
    protected $id_message_envoi;
    protected $alerte;
    protected $etat;
    protected $admin;

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

    public function getId_message() {
        return $this->id_message;
    }

    public function setId_message($id_message) {
        $this->id_message = $id_message;
        return $this;
    }

    public function getDate_message() {
        return $this->date_message;
    }

    public function setDate_message($date_message) {
        $this->date_message = $date_message;
        return $this;
    }

    public function getDescription_message() {
        return $this->description_message;
    }

    public function setDescription_message($description_message) {
        $this->description_message = $description_message;
        return $this;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }

    public function getTitre_message() {
        return ($this->titre_message);
    }

    public function setTitre_message($titre_message) {
        $this->titre_message = ($titre_message);
        return $this;
    }

    public function getCode_membre_expediteur() {
        return $this->code_membre_expediteur;
    }

    public function setCode_membre_expediteur($code_membre_expediteur) {
        $this->code_membre_expediteur = $code_membre_expediteur;
        return $this;
    }

    public function getId_message_envoi() {
        return $this->id_message_envoi;
    }

    public function setId_message_envoi($id_message_envoi) {
        $this->id_message_envoi = $id_message_envoi;
        return $this;
    }

    public function getAlerte() {
        return $this->alerte;
    }

    public function setAlerte($alerte) {
        $this->alerte = $alerte;
        return $this;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
        return $this;
    }


}

?>
