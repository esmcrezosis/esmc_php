<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuMprgController
 *
 * @author user
 */
class EuMprgController extends Zend_Controller_Action {
    //put your code here
     public function init() {
        $menu = '<li><a id="newmprg" href="/eu-mprg/new">MPRg</a></li>';
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->usergroup;
            if ($group != 'banque' &&  $group != 'mprg') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }
}

?>
