<?php 
//$this->view->siteurl = $_SERVER['SERVER_NAME'];
$sessionurl = new Zend_Session_Namespace('url');

$urlparametre = substr($_SERVER['REQUEST_URI'], 1);

  if(stripos($urlparametre, '/') !== false){
  list($b, $a) = explode ('/', $urlparametre, 2);
  $controlleur = $b;

if(substr($a, -1) == "_"){
if($_POST){
  $a = substr($a, 0, -1);
  $d = base64_decode($a);
$c = explode ('/', $d);
  $action = $c[0];
  $i = 1;
  $parametre = array();
  while ($i < count($c)) {
    $parametre[$c[$i]] = $c[$i + 1];
    $i = $i + 2;
  }
$this->_forward($action, $controlleur, 'default', $_POST);
  }else{
  $a = substr($a, 0, -1);
  $d = base64_decode($a);
$c = explode ('/', $d);
  $action = $c[0];
  $i = 1;
  $parametre = array();
  while ($i < count($c)) {
    $parametre[$c[$i]] = $c[$i + 1];
    $i = $i + 2;
  }
$this->_forward($action, $controlleur, 'default', $parametre);
    }
}else{
if($_POST){
  }else{

    /*if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
      $server_name = "prod.gacsource.net";
    }else{
      $server_name = "prod.esmcgacsource.com";
    }*/
    if($_SERVER['SERVER_ADDR'] == Util_Utils::getParamEsmc(9)) {
      $server_name = Util_Utils::getParamEsmcLib(9);
    }else{
      $server_name = Util_Utils::getParamEsmcLib(10);
    }
    $this->_redirect('http://'.$server_name.'/'.$controlleur.'/'.base64_encode($a)."_");
  }
}

} 

/*
//$this->view->siteurl = $_SERVER['SERVER_NAME'];
$sessionurl = new Zend_Session_Namespace('url');

$urlparametre = substr($_SERVER['REQUEST_URI'], 1);

  if(stripos($urlparametre, '/') !== false){
  list($b, $a) = explode ('/', $urlparametre, 2);
  $controlleur = $b;

if(substr($a, -1) == "_"){
if($_POST){
	$a = substr($a, 0, -1);
	$d = base64_decode($a);
$c = explode ('/', $d);
  $action = $c[0];
  $i = 1;
  $parametre = array();
  while ($i < count($c)) {
	  $parametre[$c[$i]] = $c[$i + 1];
    $i = $i + 2;
  }
$this->_forward($action, $controlleur, 'default', $_POST);
	}else{
	$a = substr($a, 0, -1);
	$d = base64_decode($a);
$c = explode ('/', $d);
  $action = $c[0];
  $i = 1;
  $parametre = array();
  while ($i < count($c)) {
	  $parametre[$c[$i]] = $c[$i + 1];
    $i = $i + 2;
  }
$this->_forward($action, $controlleur, 'default', $parametre);
		}
}else{
if($_POST){
	}else{
    $this->_redirect('http://'.$_SERVER['SERVER_NAME'].'/'.$controlleur.'/'.base64_encode($a)."_");
	}
}

}		
	*/	
		
		
?>