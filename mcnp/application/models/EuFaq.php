<?php 

class Application_Model_EuFaq {

    //put your code here
    protected $faq_id;
    protected $faq_question;
    protected $faq_categorie;
    protected $faq_reponse;
    protected $faq_type;
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

    public function getFaq_id() {
        return $this->faq_id;
    }

    public function setFaq_id($faq_id) {
        $this->faq_id = $faq_id;
        return $this;
    }

    public function getFaq_reponse() {
        return $this->faq_reponse;
    }

    public function setFaq_reponse($faq_reponse) {
        $this->faq_reponse = $faq_reponse;
        return $this;
    }

    public function getFaq_categorie() {
        return $this->faq_categorie;
    }

    public function setFaq_categorie($faq_categorie) {
        $this->faq_categorie = $faq_categorie;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getFaq_question() {
        return $this->faq_question;
    }

    public function setFaq_question($faq_question) {
        $this->faq_question = $faq_question;
        return $this;
    }

    public function getFaq_type() {
        return $this->faq_type;
    }

    public function setFaq_type($faq_type) {
        $this->faq_type = $faq_type;
        return $this;
    }


}

?>
