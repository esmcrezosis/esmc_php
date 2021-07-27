<?php

/**
 * Description of EuSection
 *
 * @author user
 */
class Application_Model_EuSection {

    //put your code here
    protected $id_section;
    protected $nom_section;
    protected $date_creation;
    protected $id_utilisateur;
    protected $id_pays;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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

    public function getId_section() {
        return $this->id_section;
    }

    public function setId_section($id_section) {
        $this->id_section = $id_section;
        return $this;
    }

    public function getNom_section() {
        return $this->nom_section;
    }

    public function setNom_section($nom_section) {
        $this->nom_section = $nom_section;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getId_pays() {
        return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_section = (isset($data['id_section'])) ? $data['id_section'] : NULL;
        $this->nom_section = (isset($data['nom_section'])) ? $data['nom_section'] : NULL;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->id_pays = (isset($data['id_pays'])) ? $data['id_pays'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_section' => $this->id_section,
            'nom_section' => $this->nom_section,
            'date_creation' => $this->date_creation,
            'id_utilisateur' => $this->id_utilisateur,
            'id_pays' => $this->id_pays
        );
        return $data;
    }

}

?>
