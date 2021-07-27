<?php
class  Application_Model_EuProprietaire  {

       //put your code here
       protected $id_proprietaire;
       protected $code_membre_pro;
       protected $code_membre_ag;
       protected $date_declaration;
       protected $id_utilisateur;
       protected $nbre_maison;
       
       
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
      
      public function getId_proprietaire() {
        return $this->id_proprietaire;
      }

      public function setId_proprietaire($id_proprietaire) {
        $this->id_proprietaire = $id_proprietaire;
        return $this;
      }
      
      public function getCode_membre_pro() {
        return $this->code_membre_pro;
      }

      public function setCode_membre_pro($code_membre_pro) {
        $this->code_membre_pro = $code_membre_pro;
        return $this;
      }
      
      public function getCode_membre_ag() {
        return $this->code_membre_ag;
      }

      public function setCode_membre_ag($code_membre_ag) {
        $this->code_membre_ag = $code_membre_ag;
        return $this;
      }
      
      public function getDate_declaration() {
        return $this->date_declaration;
      }

      public function setDate_declaration($date_declaration) {
        $this->date_declaration = $date_declaration;
        return $this;
      }
      
      public function getId_utilisateur() {
        return $this->id_utilisateur;
      }

      public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
      }
      
      public function getNbre_maison() {
        return $this->nbre_maison;
      }

      public function setNbre_maison($nbre_maison) {
        $this->nbre_maison = $nbre_maison;
        return $this;
      }
      
}

?>
