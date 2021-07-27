<?php 

class Application_Model_EuQuestionReponse {

    //put your code here
    protected $question_reponse_id;
    protected $question_reponse_question;
    protected $question_reponse_categorie;
    protected $question_reponse_reponse;
    protected $question_reponse_nom;
    protected $question_reponse_utilisateur;
    protected $question_reponse_date;
    protected $publier;

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

    public function getQuestion_reponse_id() {
        return $this->question_reponse_id;
    }

    public function setQuestion_reponse_id($question_reponse_id) {
        $this->question_reponse_id = $question_reponse_id;
        return $this;
    }

    public function getQuestion_reponse_reponse() {
        return $this->question_reponse_reponse;
    }

    public function setQuestion_reponse_reponse($question_reponse_reponse) {
        $this->question_reponse_reponse = $question_reponse_reponse;
        return $this;
    }

    public function getQuestion_reponse_categorie() {
        return $this->question_reponse_categorie;
    }

    public function setQuestion_reponse_categorie($question_reponse_categorie) {
        $this->question_reponse_categorie = $question_reponse_categorie;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getQuestion_reponse_question() {
        return ($this->question_reponse_question);
    }

    public function setQuestion_reponse_question($question_reponse_question) {
        $this->question_reponse_question = ($question_reponse_question);
        return $this;
    }

    public function getQuestion_reponse_utilisateur() {
        return $this->question_reponse_utilisateur;
    }

    public function setQuestion_reponse_utilisateur($question_reponse_utilisateur) {
        $this->question_reponse_utilisateur = $question_reponse_utilisateur;
        return $this;
    }
	
    public function getQuestion_reponse_nom() {
        return ($this->question_reponse_nom);
    }

    public function setQuestion_reponse_nom($question_reponse_nom) {
        $this->question_reponse_nom = ($question_reponse_nom);
        return $this;
    }

    public function getQuestion_reponse_date() {
        return $this->question_reponse_date;
    }

    public function setQuestion_reponse_date($question_reponse_date) {
        $this->question_reponse_date = $question_reponse_date;
        return $this;
    }
	

}

?>
