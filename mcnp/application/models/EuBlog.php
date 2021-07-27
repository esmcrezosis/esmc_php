<?php
 
class Application_Model_EuBlog {

    //put your code here
    protected $blog_id;
    protected $blog_titre;
    protected $blog_resume;
    protected $blog_description;
    protected $id_type_blog;
    protected $blog_vignette;
    protected $blog_date;
    protected $publier;
    protected $spotlight;
    protected $id_utilisateur;


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

    public function getBlog_id() {
        return $this->blog_id;
    }

    public function setBlog_id($blog_id) {
        $this->blog_id = $blog_id;
        return $this;
    }

    public function getBlog_description() {
        return $this->blog_description;
    }

    public function setBlog_description($blog_description) {
        $this->blog_description = $blog_description;
        return $this;
    }

    public function getBlog_resume() {
        return $this->blog_resume;
    }

    public function setBlog_resume($blog_resume) {
        $this->blog_resume = $blog_resume;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getSpotlight() {
        return $this->spotlight;
    }

    public function setSpotlight($spotlight) {
        $this->spotlight = $spotlight;
        return $this;
    }

    public function getBlog_titre() {
        return ($this->blog_titre);
    }

    public function setBlog_titre($blog_titre) {
        $this->blog_titre = ($blog_titre);
        return $this;
    }

    public function getId_type_blog() {
        return $this->id_type_blog;
    }

    public function setId_type_blog($id_type_blog) {
        $this->id_type_blog = $id_type_blog;
        return $this;
    }

    public function getBlog_vignette() {
        return $this->blog_vignette;
    }

    public function setBlog_vignette($blog_vignette) {
        $this->blog_vignette = $blog_vignette;
        return $this;
    }

    public function getBlog_date() {
        return $this->blog_date;
    }

    public function setBlog_date($blog_date) {
        $this->blog_date = $blog_date;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }


}

?>
