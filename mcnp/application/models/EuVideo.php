<?php
 
class Application_Model_EuVideo {

    //put your code here
    protected $video_id;
    protected $video_libelle;
    protected $video_categorie;
    protected $video_description;
    protected $video_type;
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

    public function getVideo_id() {
        return $this->video_id;
    }

    public function setVideo_id($video_id) {
        $this->video_id = $video_id;
        return $this;
    }

    public function getVideo_description() {
        return $this->video_description;
    }

    public function setVideo_description($video_description) {
        $this->video_description = $video_description;
        return $this;
    }

    public function getVideo_categorie() {
        return $this->video_categorie;
    }

    public function setVideo_categorie($video_categorie) {
        $this->video_categorie = $video_categorie;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getVideo_libelle() {
        return ($this->video_libelle);
    }

    public function setVideo_libelle($video_libelle) {
        $this->video_libelle = ($video_libelle);
        return $this;
    }

    public function getVideo_type() {
        return $this->video_type;
    }

    public function setVideo_type($video_type) {
        $this->video_type = $video_type;
        return $this;
    }


}

?>
