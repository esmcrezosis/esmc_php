<?php

class Application_Model_EuPublicite {

    //put your code here
    protected $id_publicite;
    protected $type_publicite;
    protected $lien_publicite;
    protected $libelle_publicite;
    protected $desc_publicite;
    protected $date_publicite;
    protected $interface_publicite;
    protected $id_utilisateur;
    protected $duree_publicite;
    protected $categorie_publicite;
    protected $box_publicite;
    protected $ancien_publicite;
    protected $status;

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

    public function getId_publicite() {
        return $this->id_publicite;
    }

    public function setId_publicite($id_publicite) {
        $this->id_publicite = $id_publicite;
        return $this;
    }

    public function getLien_publicite() {
        return $this->lien_publicite;
    }

    public function setLien_publicite($lien_publicite) {
        $this->lien_publicite = $lien_publicite;
        return $this;
    }

    public function getDesc_publicite() {
        return $this->Desc_publicite;
    }

    public function setDesc_publicite($DESC_publicite) {
        $this->Desc_publicite = $DESC_publicite;
        return $this;
    }

    public function getDate_publicite() {
        return $this->date_publicite;
    }

    public function setDate_publicite($date_publicite) {
        $this->date_publicite = $date_publicite;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getInterface_publicite() {
        return $this->interface_publicite;
    }

    public function setInterface_publicite($interface_publicite) {
        $this->interface_publicite = $interface_publicite;
        return $this;
    }

    public function getType_publicite() {
        return $this->type_publicite;
    }

    public function setType_publicite($type_publicite) {
        $this->type_publicite = $type_publicite;
        return $this;
    }

    public function getLibelle_publicite() {
        return ($this->libelle_publicite);
    }

    public function setLibelle_publicite($libelle_publicite) {
        $this->libelle_publicite = ($libelle_publicite);
        return $this;
    }

    public function getDuree_publicite() {
        return $this->duree_publicite;
    }

    public function setDuree_publicite($duree_publicite) {
        $this->duree_publicite = $duree_publicite;
        return $this;
    }
    
    public function getCategorie_publicite() {
        return $this->categorie_publicite;
    }

    public function setCategorie_publicite($categorie_publicite) {
        $this->categorie_publicite = $categorie_publicite;
        return $this;
    }

    public function getBox_publicite() {
        return $this->box_publicite;
    }

    public function setBox_publicite($box_publicite) {
        $this->box_publicite = $box_publicite;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getAncien_publicite() {
        return $this->ancien_publicite;
    }

    public function setAncien_publicite($ancien_publicite) {
        $this->ancien_publicite = $ancien_publicite;
        return $this;
    }


}

?>
