<?php
 
class Application_Model_EuBlogCommentaire {

    //put your code here
    protected $blog_commentaire_id;
    protected $blog_id;
    protected $code_membre;
    protected $blog_commentaire_message;
    protected $blog_commentaire_emoticone;
    protected $blog_commentaire_date;
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

    public function getBlog_commentaire_id() {
        return $this->blog_commentaire_id;
    }

    public function setBlog_commentaire_id($blog_commentaire_id) {
        $this->blog_commentaire_id = $blog_commentaire_id;
        return $this;
    }

    public function getBlog_commentaire_message() {
        return $this->blog_commentaire_message;
    }

    public function setBlog_commentaire_message($blog_commentaire_message) {
        $this->blog_commentaire_message = $blog_commentaire_message;
        return $this;
    }

    public function getBlog_id() {
        return $this->blog_id;
    }

    public function setBlog_id($blog_id) {
        $this->blog_id = $blog_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getCode_membre() {
        return ($this->code_membre);
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = ($code_membre);
        return $this;
    }

    public function getBlog_commentaire_emoticone() {
        return $this->blog_commentaire_emoticone;
    }

    public function setBlog_commentaire_emoticone($blog_commentaire_emoticone) {
        $this->blog_commentaire_emoticone = $blog_commentaire_emoticone;
        return $this;
    }

    public function getBlog_commentaire_date() {
        return $this->blog_commentaire_date;
    }

    public function setBlog_commentaire_date($blog_commentaire_date) {
        $this->blog_commentaire_date = $blog_commentaire_date;
        return $this;
    }


}

?>
