<?php

class Application_Model_EuQuestionReponseCategorie {

    protected  $question_reponse_categorie_cod;
    protected  $question_reponse_categorie_lib;
    
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

    function getQuestion_reponse_categorie_cod() {
        return $this->question_reponse_categorie_cod;
    }

    function setQuestion_reponse_categorie_cod($question_reponse_categorie_cod) {
        $this->question_reponse_categorie_cod = $question_reponse_categorie_cod;
        return $this;
    }

    function getQuestion_reponse_categorie_lib() {
        return $this->question_reponse_categorie_lib;
    }

    function setQuestion_reponse_categorie_lib($question_reponse_categorie_lib) {
        $this->question_reponse_categorie_lib = $question_reponse_categorie_lib;
        return $this;
    }

}

?>
