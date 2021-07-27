<?php

class ComuniqueController extends Zend_Controller_Action{


    public function init() {
		/* Initialize action controller here */
        include("Url.php");
	  }
      
    public function lireAction(){
       $this->_helper->layout()->setLayout('layoutpublicesmc');
    
    }


}
