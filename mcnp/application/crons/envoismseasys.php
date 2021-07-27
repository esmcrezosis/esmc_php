#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';

try
{
   



           ini_set('memory_limit', '512M');    

$date_id = new Zend_Date(Zend_Date::ISO_8601);



    $tablee = new Application_Model_DbTable_EuSmsSent();
    $selecte = $tablee->select();
    $selecte->where('(etat = ?', '');
    $selecte->orwhere('etat IS NULL)');
    $selecte->where('typeexpediteur LIKE ?', 'EASYS');
    $selecte->where('datetime >= ?', '2017-07-28');
    //$selecte->where('(etat != ?', 0);
    //$selecte->orwhere('etat = ?)', '');
    $selecte->order(array("datetime ASC"));
    //$selecte->limit(5);
    $entriese = $tablee->fetchAll($selecte);

foreach ($entriese as $value) {

$recipient = $value->recipient;
$smsbody = $value->smsbody;
$compteursms = $value->neng;

$i = 0;
$status2 = "";

do {

$i++;

/////////////////////////////////////////////////////////////////////////
$homepage = file_get_contents("http://easys.gacsource.net/envoisms.php?login=esmc&password=mcnp&type=1&destination=".$recipient."&message=".urlencode(html_entity_decode($smsbody))."");
//$homepage = file_get_contents("http://prodsms.gacsource.net/easys/envoisms.php?login=esmc&password=mcnp&type=1&destination=".$recipient."&message=".urlencode(html_entity_decode($smsbody))."");

//$homepage = strip_tags($homepage, '<br>');
list($status, $numero, $msgid) = explode("|", $homepage);
$status2 = $status;

$sms_sent = new Application_Model_EuSmsSent();
$sms_sentM = new Application_Model_EuSmsSentMapper();
$sms_sentM->find($compteursms, $sms_sent);

$sms_sent->setEtat($status);
//$sms_sent->setRecipient($numero);
$sms_sent->setMsgId($msgid);
$sms_sentM->update($sms_sent);/**/

} while ($status2 == "" && $i < 3);


}














    
}
catch (Exception $e)
{
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
}
