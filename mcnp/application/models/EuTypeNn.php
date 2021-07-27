<?php

/**
 * Description of EuSection
 *
 * @author user
 */
class Application_Model_EuTypeNn {

    //put your code here
    protected $code_type_nn;
    protected $lib_type_nn;
    protected $desc_type_nn;

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

    public function getCode_type_nn() {
        return $this->code_type_nn;
    }

    public function setCode_type_nn($code_type_nn) {
        $this->code_type_nn = $code_type_nn;
        return $this;
    }

    public function getLib_type_nn() {
        return $this->lib_type_nn;
    }

    public function setLib_type_nn($lib_type_nn) {
        $this->lib_type_nn = $lib_type_nn;
        return $this;
    }

    public function getDesc_type_nn() {
        return $this->desc_type_nn;
    }

    public function setDesc_type_nn($desc_type_nn) {
        $this->desc_type_nn = $desc_type_nn;
        return $this;
    }

    public function exchangeArray($data) {
        $this->code_type_nn = (isset($data['code_type_nn'])) ? $data['code_type_nn'] : NULL;
        $this->lib_type_nn = (isset($data['lib_type_nn'])) ? $data['lib_type_nn'] : NULL;
        $this->desc_type_nn = (isset($data['desc_type_nn'])) ? $data['desc_type_nn'] : NULL;
    }

    public function toArray() {
        $data = array(
            'code_type_nn' => $this->code_type_nn,
            'lib_type_nn' => $this->lib_type_nn,
            'desc_type_nn' => $this->desc_type_nn
        );
        return $data;
    }

}

?>
