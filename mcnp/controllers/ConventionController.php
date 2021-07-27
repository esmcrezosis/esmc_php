<?php

class ConventionController extends Zend_Controller_Action{

public function listingAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    $dbcv = new Application_Model_DbTable_EuConvention();
    $cv = new Application_Model_EuConvention();
    $mpcv = new Application_Model_EuConventionMapper();
    
}

public function brutespaceAction() 
{
  Zend_Session::destroy(true);
  $this->_redirect('/');
}

public function indexAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmc');
  
		$sessionmembre = new Zend_Session_Namespace('membre');	
  
    if($sessionmembre->code_membre == ""){
            $this->_redirect('/');
    }
    $dbcv = new Application_Model_DbTable_EuConvention();
    $cv = new Application_Model_EuConvention();
    $mpcv = new Application_Model_EuConventionMapper();
    $request = $this->getRequest();
    $validationerrors = array();
    $convention_array = array();
    $created = Zend_Date::now();
    $date_convention =  $created->toString('yyyy-MM-dd HH:mm:ss');
       
    $this->view->dateconvention = $date_convention;
    $code_membre = $sessionmembre->code_membre;

    if($request->isPost()){
      if(!array_key_exists('convention_select', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404: de ce ticket n'existe pas";
      }
      if($_POST['convention_select'] == "personne_physique"){
         if(!array_key_exists('civilite_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du demandeur de ce ticket n'existe pas";
         }

         if(empty($_POST['civilite_name'])){
            $validationerrors['empty_civilite_name'] = "Vos Nom et Prenoms ne doivent pas être vide";
         }

         if(!array_key_exists('civilite_domicile', $_POST)){
            $validationerrors['error_civilite_domicile'] = "Erreur 404:Le Type demeure n'existe pas";
         }
         if(empty($_POST['civilite_domicile']) || $_POST['civilite_domicile'] == ""){
            $validationerrors['empty_civilite_domicile'] = "Le lieu ne doivent pas être vide";
         }

        if(!array_key_exists('civilite_quartier', $_POST)){
            $validationerrors['error_civilite_quartier'] = "Erreur 404:le quartier n'existe pas";
         }
         if(empty($_POST['civilite_quartier'])){
            $validationerrors['empty_civilite_quartier'] = "Le quartier n'est pas rempli";
         }

        if(!array_key_exists('civilite_bp', $_POST)){
            $validationerrors['error_civilite_bp'] = "Erreur 404:La boîte postale n'est pas précisé";
        }

        if(!array_key_exists('civilite_phone', $_POST)){
            $validationerrors['error_civilite_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['civilite_phone'])){
            $validationerrors['empty_civilite_phone'] = "Le numero de telephone n'est pas rempli";
        }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["civilite_name"],
		       "code_membre"=>$sessionmembre->code_membre,		   
           "demeure"=>$_POST["civilite_domicile"],
           "libelle_demeure"=>$_POST["civilite_domicile"],
           "quartier"=>$_POST["civilite_quartier"],
           "boite_postale"=>$_POST["civilite_bp"],
           "telephone"=>$_POST["civilite_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
       /**,
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]**/

       if($_POST['convention_select'] == "Etablissement"){
         if(!array_key_exists('etablissement_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_name'])){
            $validationerrors['empty_etablissement_name'] = "Le nom de l'établissement pas être vide";
         }

         if(!array_key_exists('etablissement_residence', $_POST)){
            $validationerrors['error_etablissement_residence'] = "Erreur 404:Le Lieu de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_residence'])){
            $validationerrors['empty_etablissement_residence'] = "Le Lieu de l'établissement ne doit pas être vide";
         }

        if(!array_key_exists('etablissement_quartier', $_POST)){
            $validationerrors['error_etablissement_quartier'] = "Erreur 404:le quartier de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_quartier'])){
            $validationerrors['empty_etablissement_quartier'] = "Le quartier de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant l'établissemnt est invalide";
        }

        if(empty($_POST['etablissement_representant_bp'])){
            $validationerrors['empty_etablissement_representant_bp'] = "La boîte postale du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_phone', $_POST)){
            $validationerrors['error_etablissement_representant_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['etablissement_representant_phone'])){
            $validationerrors['empty_etablissement_representant_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['etablissement_representant_phone'] !== ""){
          if(filter_var($_POST['etablissement_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_etablissement_representant_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

        if(!array_key_exists('etablissement_rue', $_POST)){
            $validationerrors['error_etablissement_rue'] = "Erreur 404:La Rue de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_rue'])){
            $validationerrors['empty_etablissement_rue'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_name', $_POST)){
            $validationerrors['error_etablissement_representant_name'] = "Erreur 404:Le Nom du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_name'])){
            $validationerrors['empty_etablissement_representant_name'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_operateur', $_POST)){
            $validationerrors['error_etablissement_representant_operateur'] = "Erreur 404:Le Numero d'opérateur du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_operateur'])){
            $validationerrors['empty_etablissement_representant_operateur'] = "Le Numero d'opérateur du représentant de l'établissement n'est pas rempli";
         }

        $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_name"],
		   "code_membre"=>$sessionmembre->code_membre,		   
           "libelle_situation"=>$_POST["etablissement_residence"],
           "quartier"=>$_POST["etablissement_quartier"],
           "boite_postale"=>$_POST["etablissement_representant_bp"],
           "telephone"=>$_POST["etablissement_representant_phone"],
           "rue"=>$_POST["etablissement_rue"],
           "civilite_representant"=>$_POST["etablissement_representant"],
           "nom_representant"=>$_POST["etablissement_representant_name"],
           "carte_operateur"=>$_POST["etablissement_representant_operateur"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
           
         );
       }

       if($_POST['convention_select'] == "Maison_Villa_Immeuble"){
         if(!array_key_exists('residence_name', $_POST)){
            $validationerrors['error_residence_name'] = "Erreur 404:Le Nom de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_name'])){
            $validationerrors['empty_residence_name'] = "Le nom de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_situation', $_POST)){
            $validationerrors['error_residence_situation'] = "Erreur 404:Le lieu de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_situation'])){
            $validationerrors['empty_residence_situation'] = "Le lieu de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_representant_demeure', $_POST)){
            $validationerrors['error_residence_representant_demeure'] = "Erreur 404:Le Lieu de residence du représentant de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_representant_demeure'])){
            $validationerrors['empty_residence_representant_demeure'] = "Le Lieu de residence du représentant de la maison/Villa/Immeuble ne doit pas être vide";
         }

        if(!array_key_exists('residence_quartier', $_POST)){
            $validationerrors['error_residence_quartier'] = "Erreur 404:le quartier de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_quartier'])){
            $validationerrors['empty_residence_quartier'] = "Le quartier de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant la résidence est invalide";
        }

        if(empty($_POST['residence_representant_bp'])){
            $validationerrors['empty_residence_representant_bp'] = "La boîte postale du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_phone', $_POST)){
            $validationerrors['error_residence_representant_phone'] = "Erreur 404:Le champs numero de la maison/Villa/Immeuble n'est pas précisé";
        }
        if(empty($_POST['residence_representant_phone'])){
            $validationerrors['empty_residence_representant_phone'] = "Le numero de telephone du represésentant de la maison/Villa/Immeuble n'est pas rempli";
        }
        if($_POST['residence_representant_phone'] !== ""){
          if(filter_var($_POST['residence_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_residence_representant_phone'] = "Le Numero de telephone du represésentant de la maison/Villa/Immeuble doit être numérique";
           }
        }

        if(!array_key_exists('residence_rue', $_POST)){
            $validationerrors['error_residence_rue'] = "Erreur 404:La Rue de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_rue'])){
            $validationerrors['empty_residence_rue'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant', $_POST)){
            $validationerrors['error_residence_representant'] = "Erreur 404:Le Nom du représentant de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_representant'])){
            $validationerrors['empty_residence_representant'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }


         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
		       "code_membre"=>$sessionmembre->code_membre,		   
           "type_maison"=>$_POST["residence_name"],
           "demeure"=>$_POST["residence_representant_demeure"],
           "libelle_situation"=>$_POST["residence_situation"],
           "quartier"=>$_POST["residence_quartier"],
           "boite_postale"=>$_POST["residence_representant_bp"],
           "telephone"=>$_POST["residence_representant_phone"],
           "rue"=>$_POST["residence_rue"],
           "nom_representant"=>$_POST["residence_representant"],           
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }


       if($_POST['convention_select'] == "Collectivite"){
        if(!array_key_exists('collectivite_name', $_POST)){
            $validationerrors['error_collectivite_name'] = "Erreur 404:Le Nom de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_name'])){
            $validationerrors['empty_collectivite_name'] = "Le nom de la collectivité ne doit pas être vide";
         }

         if(!array_key_exists('collectivite_domicile', $_POST)){
            $validationerrors['error_collectivite_domicile'] = "Erreur 404:Le Lieu de residence du représentant de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_domicile'])){
            $validationerrors['empty_collectivite_domicile'] = "Le Lieu de residence du représentant de la collectivité ne doit pas être vide";
         }

        if(!array_key_exists('collectivite_quartier', $_POST)){
            $validationerrors['error_collectivite_quartier'] = "Erreur 404:le quartier de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_quartier'])){
            $validationerrors['empty_collectivite_quartier'] = "Le quartier de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_bp', $_POST)){
            $validationerrors['error_collectivite_bp'] = "Erreur 404:La boîte postale du représentant de la collectivité est invalide";
        }

        if(empty($_POST['collectivite_bp'])){
            $validationerrors['empty_collectivite_bp'] = "La boîte postale du représentant de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_tel', $_POST)){
            $validationerrors['error_collectivite_tel'] = "Erreur 404:Le champs numero de telephone du representant de la collectivité n'est pas précisé";
        }
        if(empty($_POST['residence_collectivite_tel'])){
            $validationerrors['empty_collectivite_tel'] = "Le numero de telephone du represésentant de la collectivité n'est pas rempli";
        }
        if($_POST['collectivite_tel'] !== ""){
          if(filter_var($_POST['collectivite_tel'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_collectivite_tel'] = "Le Numero de telephone du represésentant de la collectivité doit être numérique";
           }
        }

        if(!array_key_exists('collectivite_representant', $_POST)){
            $validationerrors['error_collectivite_representant'] = "Erreur 404:Le Nom du représentant de la collectivité est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['collectivite_representant'])){
            $validationerrors['empty_collectivite_representant'] = "Le Nom du représentant de la collectivité n'est pas rempli";
         }
          $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["collectivite_name"],
		       "code_membre"=>$sessionmembre->code_membre,		   
           "demeure"=>$_POST["collectivite_domicile"],
           "quartier"=>$_POST["collectivite_quartier"],
           "boite_postale"=>$_POST["collectivite_bp"],
           "telephone"=>$_POST["collectivite_tel"],
           "nom_representant"=>$_POST["collectivite_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Association"){
        if(!array_key_exists('association_name', $_POST)){
            $validationerrors['error_association_name'] = "Erreur 404:Le Nom de l'Association est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['association_name'])){
            $validationerrors['empty_association_name'] = "Le Nom de l'Association n'est pas rempli";
         }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["association_name"],
           "code_membre"=>$sessionmembre->code_membre,  
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

        if($_POST['convention_select'] == "Groupement"){
          if(!array_key_exists('groupement_name', $_POST)){
            $validationerrors['error_groupement_name'] = "Erreur 404:Le Nom du groupement est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['groupement_name'])){
            $validationerrors['empty_groupement_name'] = "Le Nom du groupement n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["groupement_name"],
           "code_membre"=>$sessionmembre->code_membre,
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Cooperative"){
          if(!array_key_exists('cooperative_name', $_POST)){
            $validationerrors['error_cooperative_name'] = "Erreur 404:Le Nom de la coopérative est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['cooperative_name'])){
            $validationerrors['empty_cooperative_name'] = "Le Nom de la coopérative n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["cooperative_name"],
           "code_membre"=>$sessionmembre->code_membre,		
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Union"){
          if(!array_key_exists('union_name', $_POST)){
            $validationerrors['error_union_name'] = "Erreur 404:Le Nom de l'Union est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['union_name'])){
            $validationerrors['empty_union_name'] = "Le Nom de l'Union n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["union_name"],
           "code_membre"=>$sessionmembre->code_membre,		 
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
         
       }

       
      if($_POST['convention_select'] == "ONG"){
          if(!array_key_exists('ong_name', $_POST)){
            $validationerrors['error_ong_name'] = "Erreur 404:Le Nom de l'ONG est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['ong_name'])){
            $validationerrors['empty_ong_name'] = "Le Nom de l'ONG n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_name"],
           "code_membre"=>$sessionmembre->code_membre,
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
       
       
      if($_POST['convention_select'] == "Confederation"){
          if(!array_key_exists('confederation_name', $_POST)){
            $validationerrors['error_confederation_name'] = "Erreur 404:Le Nom de la confédération est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confederation_name'])){
            $validationerrors['empty_confederation_name'] = "Le Nom de la confédération n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confederation_name"],
           "code_membre"=>$sessionmembre->code_membre,	
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Federation"){
        if(!array_key_exists('federation_name', $_POST)){
          $validationerrors['error_federation_name'] = "Erreur 404:Le Nom de la Fédération est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['federation_name'])){
          $validationerrors['empty_federation_name'] = "Le Nom de la fédération n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["federation_name"],
         "code_membre"=>$sessionmembre->code_membre,		 
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "signature_new_convention"=>'1'
       );
     }
      
      if($_POST['convention_select'] == "Reseau"){
          if(!array_key_exists('reseau_name', $_POST)){
            $validationerrors['error_reseau_name'] = "Erreur 404:Le Nom du réseau est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['reseau_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom du réseau n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["reseau_name"],
           "code_membre"=>$sessionmembre->code_membre,	
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Faitiere"){
          if(!array_key_exists('faitiere_name', $_POST)){
            $validationerrors['error_faitiere_name'] = "Erreur 404:Le Nom du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_name'])){
            $validationerrors['empty_faitiere_name'] = "Le Nom du faitière n'est pas rempli";
          }

          if(!array_key_exists('numero_recipice', $_POST)){
            $validationerrors['error_numero_recipice'] = "Erreur 404:Le Numéro de recipice du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['numero_recipice'])){
            $validationerrors['empty_numero_recipice'] = "Le Numéro de recipice du faitière n'est pas rempli";
          }

          if(!array_key_exists('faitiere_representant', $_POST)){
            $validationerrors['error_faitiere_representant'] = "Erreur 404:Le Représentant du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_representant'])){
            $validationerrors['empty_faitiere_representant'] = "Le Représentant du faitière n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["faitiere_name"],
		       "code_membre"=>$sessionmembre->code_membre,		   
           "numero_recipice"=>$_POST["faitiere_numero"],
           "nom_representant"=>$_POST["faitiere_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Confession_religieuse"){
          if(!array_key_exists('confession_religieuse_name', $_POST)){
            $validationerrors['error_confession_religieuse_name'] = "Erreur 404:Le Nom de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Nom de la confession réligieuse n'est pas rempli";
          }
          if(!array_key_exists('confession_religieuse_quartier_name', $_POST)){
            $validationerrors['error_confession_religieuse_quartier_name'] = "Erreur 404:Le Nom du quartier de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_quartier_name'])){
            $validationerrors['empty_confession_religieuse_quartier_name'] = "Le Nom du quartier de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_representant', $_POST)){
            $validationerrors['error_confession_religieuse_representant'] = "Erreur 404:Le Représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_demeure', $_POST)){
            $validationerrors['error_confession_religieuse_demeure'] = "Erreur 404:Le domicile du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_demeure'])){
            $validationerrors['empty_confession_religieuse_demeure'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_bp', $_POST)){
            $validationerrors['error_confession_religieuse_bp'] = "Erreur 404:La boîte postale du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_bp'])){
            $validationerrors['empty_confession_religieuse_bp'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_phone', $_POST)){
            $validationerrors['error_confession_religieuse_phone'] = "Erreur 404:Le numéro de telephone du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_phone'])){
            $validationerrors['empty_confession_religieuse_phone'] = "Le numéro de telephone du représentant de la confession réligieuse n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confession_religieuse_name"],
		   "code_membre"=>$sessionmembre->code_membre,		   
           "quartier"=>$_POST["confession_religieuse_quartier_name"],
           "demeure"=>$_POST["confession_religieuse_demeure"],
           "nom_representant"=>$_POST["confession_religieuse_representant"],
           "boite_postale"=>$_POST["confession_religieuse_bp"],
           "telephone"=>$_POST["confession_religieuse_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "EPA"){
          if(!array_key_exists('etablissement_administratif_name', $_POST)){
            $validationerrors['error_etablissement_administratif_name'] = "Erreur 404:Le Nom de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_name'])){
            $validationerrors['empty_etablissement_administratif_name'] = "Le Nom de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_bp', $_POST)){
            $validationerrors['error_etablissement_administratif_bp'] = "Erreur 404:La boîte postale l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_bp'])){
            $validationerrors['empty_etablissement_administratif_bp'] = "Le boîte postle de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_telephone', $_POST)){
            $validationerrors['error_etablissement_administratif_telephone'] = "Erreur 404:Le numéro de telephone de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_telephone'])){
            $validationerrors['empty_etablissement_administratif_telephone'] = "Le numéro de telephone de l'établissement public administratif n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_administratif_name"],
		   "code_membre"=>$sessionmembre->code_membre,		   
           "boite_postale"=>$_POST["etablissement_administratif_bp"],
           "telephone"=>$_POST["etablissement_administratif_telephone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "EPIC"){
          if(!array_key_exists('etablissement_industriel_commercial_name', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_name'] = "Erreur 404:Le Nom de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_name'])){
            $validationerrors['empty_etablissement_industriel_commercial_name'] = "Le Nom de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_bp', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_bp'] = "Erreur 404:La boîte postale  de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_bp'])){
            $validationerrors['empty_etablissement_industriel_commercial_bp'] = "Le boîte postale du représentant de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_phone', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_phone'] = "Erreur 404:Le numéro de telephone de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_phone'])){
            $validationerrors['empty_etablissement_industriel_commercial_phone'] = "Le numéro de telephone de l'établissement industriel commercial n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_industriel_commercial_name"],
		       "code_membre"=>$sessionmembre->code_membre,		   
           "boite_postale"=>$_POST["etablissement_industriel_commercial_bp"],
           "telephone"=>$_POST["etablissement_industriel_commercial_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "OI"){
          if(!array_key_exists('organisation_internationale_name', $_POST)){
            $validationerrors['error_organisation_internationale_name'] = "Erreur 404:Le Nom de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_name'])){
            $validationerrors['empty_organisation_internationale_name'] = "Le Nom de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_bp', $_POST)){
            $validationerrors['error_organisation_internationale_bp'] = "Erreur 404:La boîte postale  de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_bp'])){
            $validationerrors['empty_organisation_internationale_bp'] = "Le boîte postale de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_phone', $_POST)){
            $validationerrors['error_organisation_internationale_phone'] = "Erreur 404:Le numéro de téléphone de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_phone'])){
            $validationerrors['empty_organisation_internationale_phone'] = "Le numéro de téléphone de l'organisation internationale n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["organisation_internationale_name"],
		       "code_membre"=>$sessionmembre->code_membre,		   
           "boite_postale"=>$_POST["organisation_internationale_bp"],
           "telephone"=>$_POST["organisation_internationale_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "societe"){
          if(!array_key_exists('societe_name', $_POST)){
            $validationerrors['error_societe_name'] = "Erreur 404:Le Nom de l'organisation internationale commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_name'])){
            $validationerrors['empty_societe_name'] = "Le Nom de l'organisation internationale commercial n'est pas rempli";
          }

          if(!array_key_exists('societe_imatriculation_numero', $_POST)){
            $validationerrors['error_societe_imatriculation_numero'] = "Erreur 404:Le numéro d'imatriculation de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_imatriculation_numero'])){
            $validationerrors['empty_societe_imatriculation_numero'] = "Le numéro d'imatriculation de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_siege', $_POST)){
            $validationerrors['error_societe_siege'] = "Erreur 404:Le siege de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_siege'])){
            $validationerrors['empty_societe_siege'] = "Le siege de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_representant_name', $_POST)){
            $validationerrors['error_societe_representant_name'] = "Erreur 404:Le nom du représentant de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_representant_name'])){
            $validationerrors['empty_societe_representant_name'] = "Le nom du représentant de la société n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["societe_name"],
		       "code_membre"=>$sessionmembre->code_membre,
           "numero_recipice"=>$_POST["societe_imatriculation_numero"],
           "siege"=>$_POST["societe_siege"],
           "nom_representant"=>$_POST["societe_representant_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
         
       }
       

          if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
                
           }
           $dbselect = $dbcv->select();
		       $dbselect->from('eu_convention');
		       $dbselect->where("code_membre like '".$sessionmembre->code_membre."'");
			     $dbselect_all = $dbcv->fetchAll($dbselect);
           $count = count($dbselect_all);           
           
         if(!empty($convention_array) && empty($validationerrors)){
            if($count == 0) {
              if($dbcv->insert($convention_array)){
                if (in_array(substr($code_membre,-1), array('M'))) {
                   $this->_redirect('/formsguichet/signaturedelafranchiseparlapersonnemorale');		              
                }
    
                if(in_array(substr($code_membre,-1), array('P'))){
                   $this->_redirect('/formsguichet/validationdelaconventionelipersonnephysiquespacepersonnel');	
                                  
                }
              }
            }

            if($count !== 0) {           
              $cv = array(
                'signature_new_convention'=>'1');
              if($dbcv->update($cv,array('code_membre = ?'=>$code_membre))){
                if (in_array(substr($code_membre,-1), array('M'))) {
                  $this->_redirect('/formsguichet/signaturedelafranchiseparlapersonnemorale');		              
                }
               if(in_array(substr($code_membre,-1), array('P'))){
                  $this->_redirect('/formsguichet/validationdelaconventionelipersonnephysiquespacepersonnel');	                                
               }
              }

            }


      }
    }
  }
  


public function signatureconventionAction () {
  $this->_helper->layout()->setLayout('layoutpublicesmc');
  $dbcv = new Application_Model_DbTable_EuConvention();
  $cv = new Application_Model_EuConvention();
  $mpcv = new Application_Model_EuConventionMapper();
  $request = $this->getRequest();
  $validationerrors = array();
  $convention_array = array();
  $created = Zend_Date::now();
  $date_convention =  $created->toString('yyyy-MM-dd HH:mm:ss');
  $this->view->dateconvention = $date_convention;
  
  if($request->isPost()){
    if(!array_key_exists('convention_select', $_POST)){
      $validationerrors['error_demandeur'] = "Erreur 404: Vous devez cocher la case correspondante à votre statut sur la convention";
    }
    if($_POST['convention_select'] == "Personne_physique"){
       if(!array_key_exists('civilite_name', $_POST)){
          $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du demandeur de ce ticket n'existe pas";
       }
       if(empty($_POST['civilite_name'])){
          $validationerrors['empty_civilite_name'] = "Vos Nom et Prenoms ne doivent pas être vide";
       }

       if(!array_key_exists('civilite_type_demeure', $_POST)){
          $validationerrors['error_civilite_type_demeure'] = "Erreur 404:Le Type demeur n'existe pas";
       }
       if(empty($_POST['civilite_type_demeure']) || $_POST['civilite_type_demeure'] == ""){
          $validationerrors['empty_civilite_type_demeure'] = "Le lieu ne doivent pas être vide";
       }

      if(!array_key_exists('civilite_quartier', $_POST)){
          $validationerrors['error_civilite_quartier'] = "Erreur 404:le quartier n'existe pas";
       }
       if(empty($_POST['civilite_quartier'])){
          $validationerrors['empty_civilite_quartier'] = "Le quartier n'est pas rempli";
       }

      if(!array_key_exists('civilite_bp', $_POST)){
          $validationerrors['error_civilite_bp'] = "Erreur 404:La boîte postale n'est pas précisé";
      }

      if(!array_key_exists('civilite_phone', $_POST)){
          $validationerrors['error_civilite_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
      }
      if(empty($_POST['civilite_phone'])){
          $validationerrors['empty_civilite_phone'] = "Le numero de telephone n'est pas rempli";
      }
      if($_POST['civilite_phone'] !== ""){
        if(filter_var($_POST['civilite_phone'], FILTER_VALIDATE_REGEXP,
           array("options"=>array("regexp"=>"#[^0-9]#")))){
           $validationerrors['verif_civilite_phone'] = "Le Numero de telephone doit être numérique";
         }
      }

       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["civilite_name"],
         "demeure"=>$_POST["civilite_type_demeure"],
         "libelle_demeure"=>$_POST["civilite_domicile"],
         "quartier"=>$_POST["civilite_quartier"],
         "boite_postale"=>$_POST["civilite_bp"],
         "telephone"=>$_POST["civilite_phone"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }
     /**,
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"]**/

     if($_POST['convention_select'] == "Etablissement"){
       if(!array_key_exists('etablissement_name', $_POST)){
          $validationerrors['error_demandeur'] = "Erreur 404:Le Nom de l'établissement n'existe pas";
       }
       if(empty($_POST['etablissement_name'])){
          $validationerrors['empty_etablissement_name'] = "Le nom de l'établissement pas être vide";
       }

       if(!array_key_exists('etablissement_residence', $_POST)){
          $validationerrors['error_etablissement_residence'] = "Erreur 404:Le Lieu de l'établissement n'existe pas";
       }
       if(empty($_POST['etablissement_residence'])){
          $validationerrors['empty_etablissement_residence'] = "Le Lieu de l'établissement ne doit pas être vide";
       }

      if(!array_key_exists('etablissement_quartier', $_POST)){
          $validationerrors['error_etablissement_quartier'] = "Erreur 404:le quartier de l'établissement n'existe pas";
       }
       if(empty($_POST['etablissement_quartier'])){
          $validationerrors['empty_etablissement_quartier'] = "Le quartier de l'établissement n'est pas rempli";
       }

      if(!array_key_exists('etablissement_representant_bp', $_POST)){
          $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant l'établissemnt est invalide";
      }

      if(empty($_POST['etablissement_representant_bp'])){
          $validationerrors['empty_etablissement_representant_bp'] = "La boîte postale du représentant de l'établissement n'est pas rempli";
       }

      if(!array_key_exists('etablissement_representant_phone', $_POST)){
          $validationerrors['error_etablissement_representant_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
      }
      if(empty($_POST['etablissement_representant_phone'])){
          $validationerrors['empty_etablissement_representant_phone'] = "Le numero de telephone n'est pas rempli";
      }
      if($_POST['etablissement_representant_phone'] !== ""){
        if(filter_var($_POST['etablissement_representant_phone'], FILTER_VALIDATE_REGEXP,
           array("options"=>array("regexp"=>"#[^0-9]#")))){
           $validationerrors['verif_etablissement_representant_phone'] = "Le Numero de telephone doit être numérique";
         }
      }

      if(!array_key_exists('etablissement_rue', $_POST)){
          $validationerrors['error_etablissement_rue'] = "Erreur 404:La Rue de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['etablissement_rue'])){
          $validationerrors['empty_etablissement_rue'] = "Le Nom du représentant de l'établissement n'est pas rempli";
       }

      if(!array_key_exists('etablissement_representant_name', $_POST)){
          $validationerrors['error_etablissement_representant_name'] = "Erreur 404:Le Nom du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['etablissement_representant_name'])){
          $validationerrors['empty_etablissement_representant_name'] = "Le Nom du représentant de l'établissement n'est pas rempli";
       }

      if(!array_key_exists('etablissement_representant_operateur', $_POST)){
          $validationerrors['error_etablissement_representant_operateur'] = "Erreur 404:Le Numero d'opérateur du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['etablissement_representant_operateur'])){
          $validationerrors['empty_etablissement_representant_operateur'] = "Le Numero d'opérateur du représentant de l'établissement n'est pas rempli";
       }

      $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["etablissement_name"],
         "libelle_situation"=>$_POST["etablissement_residence"],
         "quartier"=>$_POST["etablissement_quartier"],
         "boite_postale"=>$_POST["etablissement_representant_bp"],
         "telephone"=>$_POST["etablissement_representant_phone"],
         "rue"=>$_POST["etablissement_rue"],
         "civilite_representant"=>$_POST["etablissement_representant"],
         "nom_representant"=>$_POST["etablissement_representant_name"],
         "carte_operateur"=>$_POST["etablissement_representant_operateur"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

     if($_POST['convention_select'] == "Maison_Villa_Immeuble"){
       if(!array_key_exists('residence_name', $_POST)){
          $validationerrors['error_residence_name'] = "Erreur 404:Le Nom de la maison/Villa/Immeuble n'existe pas";
       }
       if(empty($_POST['residence_name'])){
          $validationerrors['empty_residence_name'] = "Le nom de la maison/Villa/Immeuble ne doit pas être vide";
       }

       if(!array_key_exists('residence_situation', $_POST)){
          $validationerrors['error_residence_situation'] = "Erreur 404:Le lieu de la maison/Villa/Immeuble n'existe pas";
       }
       if(empty($_POST['residence_situation'])){
          $validationerrors['empty_residence_situation'] = "Le lieu de la maison/Villa/Immeuble ne doit pas être vide";
       }

       if(!array_key_exists('residence_representant_demeure', $_POST)){
          $validationerrors['error_residence_representant_demeure'] = "Erreur 404:Le Lieu de residence du représentant de la maison/Villa/Immeuble n'existe pas";
       }
       if(empty($_POST['residence_representant_demeure'])){
          $validationerrors['empty_residence_representant_demeure'] = "Le Lieu de residence du représentant de la maison/Villa/Immeuble ne doit pas être vide";
       }

      if(!array_key_exists('residence_quartier', $_POST)){
          $validationerrors['error_residence_quartier'] = "Erreur 404:le quartier de la maison/Villa/Immeuble n'existe pas";
       }
       if(empty($_POST['residence_quartier'])){
          $validationerrors['empty_residence_quartier'] = "Le quartier de la maison/Villa/Immeuble n'est pas rempli";
       }

      if(!array_key_exists('residence_representant_bp', $_POST)){
          $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant la résidence est invalide";
      }

      if(empty($_POST['residence_representant_bp'])){
          $validationerrors['empty_residence_representant_bp'] = "La boîte postale du représentant de la maison/Villa/Immeuble n'est pas rempli";
       }

      if(!array_key_exists('residence_representant_phone', $_POST)){
          $validationerrors['error_residence_representant_phone'] = "Erreur 404:Le champs numero de la maison/Villa/Immeuble n'est pas précisé";
      }
      if(empty($_POST['residence_representant_phone'])){
          $validationerrors['empty_residence_representant_phone'] = "Le numero de telephone du represésentant de la maison/Villa/Immeuble n'est pas rempli";
      }
      if($_POST['residence_representant_phone'] !== ""){
        if(filter_var($_POST['residence_representant_phone'], FILTER_VALIDATE_REGEXP,
           array("options"=>array("regexp"=>"#[^0-9]#")))){
           $validationerrors['verif_residence_representant_phone'] = "Le Numero de telephone du represésentant de la maison/Villa/Immeuble doit être numérique";
         }
      }

      if(!array_key_exists('residence_rue', $_POST)){
          $validationerrors['error_residence_rue'] = "Erreur 404:La Rue de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['residence_rue'])){
          $validationerrors['empty_residence_rue'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
       }

      if(!array_key_exists('residence_representant', $_POST)){
          $validationerrors['error_residence_representant'] = "Erreur 404:Le Nom du représentant de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['residence_representant'])){
          $validationerrors['empty_residence_representant'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
       }


       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "type_maison"=>$_POST["residence_name"],
         "demeure"=>$_POST["residence_representant_demeure"],
         "libelle_situation"=>$_POST["residence_situation"],
         "quartier"=>$_POST["residence_quartier"],
         "boite_postale"=>$_POST["residence_representant_bp"],
         "telephone"=>$_POST["residence_representant_phone"],
         "rue"=>$_POST["residence_rue"],
         "nom_representant"=>$_POST["residence_representant"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }


     if($_POST['convention_select'] == "Collectivité"){
      if(!array_key_exists('collectivite_name', $_POST)){
          $validationerrors['error_collectivite_name'] = "Erreur 404:Le Nom de la collectivité n'existe pas";
       }
       if(empty($_POST['collectivite_name'])){
          $validationerrors['empty_collectivite_name'] = "Le nom de la collectivité ne doit pas être vide";
       }

       if(!array_key_exists('collectivite_domicile', $_POST)){
          $validationerrors['error_collectivite_domicile'] = "Erreur 404:Le Lieu de residence du représentant de la collectivité n'existe pas";
       }
       if(empty($_POST['collectivite_domicile'])){
          $validationerrors['empty_collectivite_domicile'] = "Le Lieu de residence du représentant de la collectivité ne doit pas être vide";
       }

      if(!array_key_exists('collectivite_quartier', $_POST)){
          $validationerrors['error_collectivite_quartier'] = "Erreur 404:le quartier de la collectivité n'existe pas";
       }
       if(empty($_POST['collectivite_quartier'])){
          $validationerrors['empty_collectivite_quartier'] = "Le quartier de la collectivité n'est pas rempli";
       }

      if(!array_key_exists('collectivite_bp', $_POST)){
          $validationerrors['error_collectivite_bp'] = "Erreur 404:La boîte postale du représentant de la collectivité est invalide";
      }

      if(empty($_POST['collectivite_bp'])){
          $validationerrors['empty_collectivite_bp'] = "La boîte postale du représentant de la collectivité n'est pas rempli";
       }

      if(!array_key_exists('collectivite_tel', $_POST)){
          $validationerrors['error_collectivite_tel'] = "Erreur 404:Le champs numero de telephone du representant de la collectivité n'est pas précisé";
      }
      if(empty($_POST['residence_collectivite_tel'])){
          $validationerrors['empty_collectivite_tel'] = "Le numero de telephone du represésentant de la collectivité n'est pas rempli";
      }
      if($_POST['collectivite_tel'] !== ""){
        if(filter_var($_POST['collectivite_tel'], FILTER_VALIDATE_REGEXP,
           array("options"=>array("regexp"=>"#[^0-9]#")))){
           $validationerrors['verif_collectivite_tel'] = "Le Numero de telephone du represésentant de la collectivité doit être numérique";
         }
      }

      if(!array_key_exists('collectivite_representant', $_POST)){
          $validationerrors['error_collectivite_representant'] = "Erreur 404:Le Nom du représentant de la collectivité est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['collectivite_representant'])){
          $validationerrors['empty_collectivite_representant'] = "Le Nom du représentant de la collectivité n'est pas rempli";
       }
        $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["collectivite_name"],
         "demeure"=>$_POST["collectivite_domicile"],
         "quartier"=>$_POST["collectivite_quartier"],
         "boite_postale"=>$_POST["collectivite_bp"],
         "telephone"=>$_POST["collectivite_tel"],
         "nom_representant"=>$_POST["collectivite_representant"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

     if($_POST['convention_select'] == "Association"){
      if(!array_key_exists('association_name', $_POST)){
          $validationerrors['error_association_name'] = "Erreur 404:Le Nom de l'Association est invalide:Impossible de faire une quelconque sauvegarde";
      }

      if(empty($_POST['association_name'])){
          $validationerrors['empty_association_name'] = "Le Nom de l'Association n'est pas rempli";
       }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["ong_association_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

      if($_POST['convention_select'] == "Groupement"){
        if(!array_key_exists('groupement_name', $_POST)){
          $validationerrors['error_groupement_name'] = "Erreur 404:Le Nom du groupement est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['groupement_name'])){
          $validationerrors['empty_groupement_name'] = "Le Nom du groupement n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["groupement_name"],     
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

     if($_POST['convention_select'] == "Coopérative"){
        if(!array_key_exists('cooperative_name', $_POST)){
          $validationerrors['error_cooperative_name'] = "Erreur 404:Le Nom de la coopérative est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['cooperative_name'])){
          $validationerrors['empty_cooperative_name'] = "Le Nom de la coopérative n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["cooperative_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

    if($_POST['convention_select'] == "Union"){
        if(!array_key_exists('union_name', $_POST)){
          $validationerrors['error_union_name'] = "Erreur 404:Le Nom de l'Union est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['union_name'])){
          $validationerrors['empty_union_name'] = "Le Nom de l'Union n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["union_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
       
     }

     
    if($_POST['convention_select'] == "ONG"){
        if(!array_key_exists('ong_name', $_POST)){
          $validationerrors['error_ong_name'] = "Erreur 404:Le Nom de l'ONG est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['ong_name'])){
          $validationerrors['empty_ong_name'] = "Le Nom de l'ONG n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["ong_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }
     
     
    if($_POST['convention_select'] == "Confédération"){
        if(!array_key_exists('confédération_name', $_POST)){
          $validationerrors['error_confédération_name'] = "Erreur 404:Le Nom de la confédération est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confédération_name'])){
          $validationerrors['empty_confédération_name'] = "Le Nom de la confédération n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["confédération_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }
    
    if($_POST['convention_select'] == "Réseau"){
        if(!array_key_exists('reseau_name', $_POST)){
          $validationerrors['error_reseau_name'] = "Erreur 404:Le Nom du réseau est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['reseau_name'])){
          $validationerrors['empty_confédération_name'] = "Le Nom du réseau n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["reseau_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

    if($_POST['convention_select'] == "Faitière"){
        if(!array_key_exists('faitiere_name', $_POST)){
          $validationerrors['error_faitiere_name'] = "Erreur 404:Le Nom du faitière est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['faitiere_name'])){
          $validationerrors['empty_faitiere_name'] = "Le Nom du faitière n'est pas rempli";
        }

        if(!array_key_exists('numero_recipice', $_POST)){
          $validationerrors['error_numero_recipice'] = "Erreur 404:Le Numéro de recipice du faitière est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['numero_recipice'])){
          $validationerrors['empty_numero_recipice'] = "Le Numéro de recipice du faitière n'est pas rempli";
        }

        if(!array_key_exists('faitiere_representant', $_POST)){
          $validationerrors['error_faitiere_representant'] = "Erreur 404:Le Représentant du faitière est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['faitiere_representant'])){
          $validationerrors['empty_faitiere_representant'] = "Le Représentant du faitière n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["faitiere_name"],
         "numero_recipice"=>$_POST["faitiere_numero"],
         "nom_representant"=>$_POST["faitiere_representant"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

    if($_POST['convention_select'] == "Confession_réligieuse"){
        if(!array_key_exists('confession_religieuse_name', $_POST)){
          $validationerrors['error_confession_religieuse_name'] = "Erreur 404:Le Nom de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confession_religieuse_representant'])){
          $validationerrors['empty_confession_religieuse_representant'] = "Le Nom de la confession réligieuse n'est pas rempli";
        }
        if(!array_key_exists('confession_religieuse_quartier_name', $_POST)){
          $validationerrors['error_confession_religieuse_quartier_name'] = "Erreur 404:Le Nom du quartier de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confession_religieuse_quartier_name'])){
          $validationerrors['empty_confession_religieuse_quartier_name'] = "Le Nom du quartier de la confession réligieuse n'est pas rempli";
        }

        if(!array_key_exists('confession_religieuse_representant', $_POST)){
          $validationerrors['error_confession_religieuse_representant'] = "Erreur 404:Le Représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confession_religieuse_representant'])){
          $validationerrors['empty_confession_religieuse_representant'] = "Le Représentant de la confession réligieuse n'est pas rempli";
        }

        if(!array_key_exists('confession_religieuse_demeure', $_POST)){
          $validationerrors['error_confession_religieuse_demeure'] = "Erreur 404:Le domicile du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confession_religieuse_demeure'])){
          $validationerrors['empty_confession_religieuse_demeure'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
        }

        if(!array_key_exists('confession_religieuse_bp', $_POST)){
          $validationerrors['error_confession_religieuse_bp'] = "Erreur 404:La boîte postale du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confession_religieuse_bp'])){
          $validationerrors['empty_confession_religieuse_bp'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
        }

        if(!array_key_exists('confession_religieuse_phone', $_POST)){
          $validationerrors['error_confession_religieuse_phone'] = "Erreur 404:Le numéro de telephone du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['confession_religieuse_phone'])){
          $validationerrors['empty_confession_religieuse_phone'] = "Le numéro de telephone du représentant de la confession réligieuse n'est pas rempli";
        }

       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["confession_religieuse_name"],
         "quartier"=>$_POST["confession_religieuse_quartier_name"],
         "demeure"=>$_POST["confession_religieuse_demeure"],
         "nom_representant"=>$_POST["confession_religieuse_representant"],
         "boite_postale"=>$_POST["confession_religieuse_bp"],
         "telephone"=>$_POST["confession_religieuse_phone"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

    if($_POST['convention_select'] == "EPA"){
        if(!array_key_exists('etablissement_administratif_name', $_POST)){
          $validationerrors['error_etablissement_administratif_name'] = "Erreur 404:Le Nom de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['etablissement_administratif_name'])){
          $validationerrors['empty_etablissement_administratif_name'] = "Le Nom de l'établissement public administratif n'est pas rempli";
        }

        if(!array_key_exists('etablissement_administratif_bp', $_POST)){
          $validationerrors['error_etablissement_administratif_bp'] = "Erreur 404:La boîte postale l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['etablissement_administratif_bp'])){
          $validationerrors['empty_etablissement_administratif_bp'] = "Le boîte postle de l'établissement public administratif n'est pas rempli";
        }

        if(!array_key_exists('etablissement_administratif_telephone', $_POST)){
          $validationerrors['error_etablissement_administratif_telephone'] = "Erreur 404:Le numéro de telephone de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['etablissement_administratif_telephone'])){
          $validationerrors['empty_etablissement_administratif_telephone'] = "Le numéro de telephone de l'établissement public administratif n'est pas rempli";
        }

       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["etablissement_administratif_name"],
         "boite_postale"=>$_POST["etablissement_administratif_bp"],
         "telephone"=>$_POST["etablissement_administratif_telephone"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

     if($_POST['convention_select'] == "EPIC"){
        if(!array_key_exists('etablissement_industriel_commercial_name', $_POST)){
          $validationerrors['error_etablissement_industriel_commercial_name'] = "Erreur 404:Le Nom de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['etablissement_industriel_commercial_name'])){
          $validationerrors['empty_etablissement_industriel_commercial_name'] = "Le Nom de l'établissement industriel commercial n'est pas rempli";
        }

        if(!array_key_exists('etablissement_industriel_commercial_bp', $_POST)){
          $validationerrors['error_etablissement_industriel_commercial_bp'] = "Erreur 404:La boîte postale  de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['etablissement_industriel_commercial_bp'])){
          $validationerrors['empty_etablissement_industriel_commercial_bp'] = "Le boîte postale du représentant de l'établissement industriel commercial n'est pas rempli";
        }

        if(!array_key_exists('etablissement_industriel_commercial_phone', $_POST)){
          $validationerrors['error_etablissement_industriel_commercial_phone'] = "Erreur 404:Le numéro de telephone de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['etablissement_industriel_commercial_phone'])){
          $validationerrors['empty_etablissement_industriel_commercial_phone'] = "Le numéro de telephone de l'établissement industriel commercial n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["etablissement_industriel_commercial_name"],
         "boite_postale"=>$_POST["etablissement_industriel_commercial_bp"],
         "telephone"=>$_POST["etablissement_industriel_commercial_phone"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

    if($_POST['convention_select'] == "Organisation_Internationale"){
        if(!array_key_exists('organisation_internationale_name', $_POST)){
          $validationerrors['error_organisation_internationale_name'] = "Erreur 404:Le Nom de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['organisation_internationale_name'])){
          $validationerrors['empty_organisation_internationale_name'] = "Le Nom de l'organisation internationale n'est pas rempli";
        }

        if(!array_key_exists('organisation_internationale_bp', $_POST)){
          $validationerrors['error_organisation_internationale_bp'] = "Erreur 404:La boîte postale  de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['organisation_internationale_bp'])){
          $validationerrors['empty_organisation_internationale_bp'] = "Le boîte postale de l'organisation internationale n'est pas rempli";
        }

        if(!array_key_exists('organisation_internationale_phone', $_POST)){
          $validationerrors['error_organisation_internationale_phone'] = "Erreur 404:Le numéro de téléphone de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['organisation_internationale_phone'])){
          $validationerrors['empty_organisation_internationale_phone'] = "Le numéro de téléphone de l'organisation internationale n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["organisation_internationale_name"],
         "boite_postale"=>$_POST["organisation_internationale_bp"],
         "telephone"=>$_POST["organisation_internationale_phone"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }

    if($_POST['convention_select'] == "Société"){
        if(!array_key_exists('societe_name', $_POST)){
          $validationerrors['error_societe_name'] = "Erreur 404:Le Nom de l'organisation internationale commercial est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['societe_name'])){
          $validationerrors['empty_societe_name'] = "Le Nom de l'organisation internationale commercial n'est pas rempli";
        }

        if(!array_key_exists('societe_imatriculation_numero', $_POST)){
          $validationerrors['error_societe_imatriculation_numero'] = "Erreur 404:Le numéro d'imatriculation de la société est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['societe_imatriculation_numero'])){
          $validationerrors['empty_societe_imatriculation_numero'] = "Le numéro d'imatriculation de la société n'est pas rempli";
        }

        if(!array_key_exists('societe_siege', $_POST)){
          $validationerrors['error_societe_siege'] = "Erreur 404:Le siege de la société est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['societe_siege'])){
          $validationerrors['empty_societe_siege'] = "Le siege de la société n'est pas rempli";
        }

        if(!array_key_exists('societe_representant_name', $_POST)){
          $validationerrors['error_societe_representant_name'] = "Erreur 404:Le nom du représentant de la société est invalide:Impossible de faire une quelconque sauvegarde";
        }
        if(empty($_POST['societe_representant_name'])){
          $validationerrors['empty_societe_representant_name'] = "Le nom du représentant de la société n'est pas rempli";
        }
       $convention_array = array(
         "civilite"=>$_POST["convention_select"],
         "nom"=>$_POST["societe_name"],
         "numero_recipice"=>$_POST["societe_imatriculation_numero"],
         "siege"=>$_POST["societe_siege"],
         "nom_representant"=>$_POST["societe_representant_name"],
         "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
         "biens"=>$_POST["biens"],
         "producteur"=>$_POST["producteur"],
         "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
         "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
         "fournisseur_externe"=>$_POST["fournisseur_externe"],
         "services"=>$_POST["services"],
         "transformateur"=>$_POST["transformateur"],           
         "vendeur"=>$_POST["vendeur"],
         "produits"=>$_POST["produit"],
         "oe"=>$_POST["oe"],
         "ose"=>$_POST["ose"],
         "prestataire_production_commune"=>$_POST["prestataire_pc"]
       );
     }
     


        if(!empty($validationerrors)){
              $_SESSION['validationerrors'] = $validationerrors;
         }
         
         $nometprenoms = $_POST["civilite_name"];
         $dbselect = $dbcv->select();
         $dbselect->from('eu_convention');
         $dbselect->where('nom like ?',$nometprenoms);
         $dbselectsearch_all = $dbcv->fetchAll($dbselect);
         $dbcountselectsearch_all = count($dbselectsearch_all);
         
         
       if(!empty($convention_array) && empty($validationerrors)){
        if($dbcv->insert($convention_array)){
          $this->_redirect('/formsguichet/engagementdelivraisonirrevocablebps');		  
        }
    }
  }

}

public function conventionreactivationAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmc');
		$sessionmembre = new Zend_Session_Namespace('membre');
    $dbcv = new Application_Model_DbTable_EuConvention();
    $cv = new Application_Model_EuConvention();
    $mpcv = new Application_Model_EuConventionMapper();
    $request = $this->getRequest();
    $validationerrors = array();
    $created = Zend_Date::now();
    $ancien_membre = $_SESSION['ancien_membre'];
    $convention_array = array();
    $date_convention =  $created->toString('yyyy-MM-dd HH:mm:ss');
       
    $this->view->dateconvention = $date_convention;

    if($request->isPost()){
      if(!array_key_exists('convention_select', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404: de ce ticket n'existe pas";
      }
      
      if($_POST['convention_select'] == "personne_physique"){
         if(!array_key_exists('civilite_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du signataire n'existe pas";
         }

         if(empty($_POST['civilite_name'])){
            $validationerrors['empty_civilite_name'] = "Vos Noms et Prenoms ne doivent pas être vide";
         }

         if(!array_key_exists('civilite_domicile', $_POST)){
            $validationerrors['error_civilite_domicile'] = "Erreur 404:Le Type demeur n'existe pas";
         }
         if(empty($_POST['civilite_domicile']) || $_POST['civilite_domicile'] == ""){
            $validationerrors['empty_civilite_domicile'] = "Le lieu ne doivent pas être vide";
         }

        if(!array_key_exists('civilite_quartier', $_POST)){
            $validationerrors['error_civilite_quartier'] = "Erreur 404:le quartier n'existe pas";
         }
         if(empty($_POST['civilite_quartier'])){
            $validationerrors['empty_civilite_quartier'] = "Le quartier n'est pas rempli";
         }

        if(!array_key_exists('civilite_bp', $_POST)){
            $validationerrors['error_civilite_bp'] = "Erreur 404:La boîte postale n'est pas précisé";
        }

        if(!array_key_exists('civilite_phone', $_POST)){
            $validationerrors['error_civilite_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['civilite_phone'])){
            $validationerrors['empty_civilite_phone'] = "Le numero de telephone n'est pas rempli";
        }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["civilite_name"],
		       "code_membre"=>$ancien_membre,		   
           "demeure"=>$_POST["civilite_domicile"],
           "libelle_demeure"=>$_POST["civilite_domicile"],
           "quartier"=>$_POST["civilite_quartier"],
           "boite_postale"=>$_POST["civilite_bp"],
           "telephone"=>$_POST["civilite_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
       /**,
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]**/

       if($_POST['convention_select'] == "Etablissement"){
         if(!array_key_exists('etablissement_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_name'])){
            $validationerrors['empty_etablissement_name'] = "Le nom de l'établissement pas être vide";
         }

         if(!array_key_exists('etablissement_residence', $_POST)){
            $validationerrors['error_etablissement_residence'] = "Erreur 404:Le Lieu de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_residence'])){
            $validationerrors['empty_etablissement_residence'] = "Le Lieu de l'établissement ne doit pas être vide";
         }

        if(!array_key_exists('etablissement_quartier', $_POST)){
            $validationerrors['error_etablissement_quartier'] = "Erreur 404:le quartier de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_quartier'])){
            $validationerrors['empty_etablissement_quartier'] = "Le quartier de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant l'établissemnt est invalide";
        }

        if(empty($_POST['etablissement_representant_bp'])){
            $validationerrors['empty_etablissement_representant_bp'] = "La boîte postale du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_phone', $_POST)){
            $validationerrors['error_etablissement_representant_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['etablissement_representant_phone'])){
            $validationerrors['empty_etablissement_representant_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['etablissement_representant_phone'] !== ""){
          if(filter_var($_POST['etablissement_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_etablissement_representant_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

        if(!array_key_exists('etablissement_rue', $_POST)){
            $validationerrors['error_etablissement_rue'] = "Erreur 404:La Rue de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_rue'])){
            $validationerrors['empty_etablissement_rue'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_name', $_POST)){
            $validationerrors['error_etablissement_representant_name'] = "Erreur 404:Le Nom du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_name'])){
            $validationerrors['empty_etablissement_representant_name'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_operateur', $_POST)){
            $validationerrors['error_etablissement_representant_operateur'] = "Erreur 404:Le Numero d'opérateur du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_operateur'])){
            $validationerrors['empty_etablissement_representant_operateur'] = "Le Numero d'opérateur du représentant de l'établissement n'est pas rempli";
         }

        $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_name"],
		       "code_membre"=>$ancien_membre,		   
           "libelle_situation"=>$_POST["etablissement_residence"],
           "quartier"=>$_POST["etablissement_quartier"],
           "boite_postale"=>$_POST["etablissement_representant_bp"],
           "telephone"=>$_POST["etablissement_representant_phone"],
           "rue"=>$_POST["etablissement_rue"],
           "civilite_representant"=>$_POST["etablissement_representant"],
           "nom_representant"=>$_POST["etablissement_representant_name"],
           "carte_operateur"=>$_POST["etablissement_representant_operateur"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
           
         );
       }

       if($_POST['convention_select'] == "Maison_Villa_Immeuble"){
         if(!array_key_exists('residence_name', $_POST)){
            $validationerrors['error_residence_name'] = "Erreur 404:Le Nom de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_name'])){
            $validationerrors['empty_residence_name'] = "Le nom de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_situation', $_POST)){
            $validationerrors['error_residence_situation'] = "Erreur 404:Le lieu de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_situation'])){
            $validationerrors['empty_residence_situation'] = "Le lieu de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_representant_demeure', $_POST)){
            $validationerrors['error_residence_representant_demeure'] = "Erreur 404:Le Lieu de residence du représentant de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_representant_demeure'])){
            $validationerrors['empty_residence_representant_demeure'] = "Le Lieu de residence du représentant de la maison/Villa/Immeuble ne doit pas être vide";
         }

        if(!array_key_exists('residence_quartier', $_POST)){
            $validationerrors['error_residence_quartier'] = "Erreur 404:le quartier de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_quartier'])){
            $validationerrors['empty_residence_quartier'] = "Le quartier de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant la résidence est invalide";
        }

        if(empty($_POST['residence_representant_bp'])){
            $validationerrors['empty_residence_representant_bp'] = "La boîte postale du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_phone', $_POST)){
            $validationerrors['error_residence_representant_phone'] = "Erreur 404:Le champs numero de la maison/Villa/Immeuble n'est pas précisé";
        }
        if(empty($_POST['residence_representant_phone'])){
            $validationerrors['empty_residence_representant_phone'] = "Le numero de telephone du represésentant de la maison/Villa/Immeuble n'est pas rempli";
        }
        if($_POST['residence_representant_phone'] !== ""){
          if(filter_var($_POST['residence_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_residence_representant_phone'] = "Le Numero de telephone du represésentant de la maison/Villa/Immeuble doit être numérique";
           }
        }

        if(!array_key_exists('residence_rue', $_POST)){
            $validationerrors['error_residence_rue'] = "Erreur 404:La Rue de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_rue'])){
            $validationerrors['empty_residence_rue'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant', $_POST)){
            $validationerrors['error_residence_representant'] = "Erreur 404:Le Nom du représentant de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_representant'])){
            $validationerrors['empty_residence_representant'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }


         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
		       "code_membre"=>$ancien_membre,		   
           "type_maison"=>$_POST["residence_name"],
           "demeure"=>$_POST["residence_representant_demeure"],
           "libelle_situation"=>$_POST["residence_situation"],
           "quartier"=>$_POST["residence_quartier"],
           "boite_postale"=>$_POST["residence_representant_bp"],
           "telephone"=>$_POST["residence_representant_phone"],
           "rue"=>$_POST["residence_rue"],
           "nom_representant"=>$_POST["residence_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }


       if($_POST['convention_select'] == "Collectivité"){
        if(!array_key_exists('collectivite_name', $_POST)){
            $validationerrors['error_collectivite_name'] = "Erreur 404:Le Nom de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_name'])){
            $validationerrors['empty_collectivite_name'] = "Le nom de la collectivité ne doit pas être vide";
         }

         if(!array_key_exists('collectivite_domicile', $_POST)){
            $validationerrors['error_collectivite_domicile'] = "Erreur 404:Le Lieu de residence du représentant de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_domicile'])){
            $validationerrors['empty_collectivite_domicile'] = "Le Lieu de residence du représentant de la collectivité ne doit pas être vide";
         }

        if(!array_key_exists('collectivite_quartier', $_POST)){
            $validationerrors['error_collectivite_quartier'] = "Erreur 404:le quartier de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_quartier'])){
            $validationerrors['empty_collectivite_quartier'] = "Le quartier de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_bp', $_POST)){
            $validationerrors['error_collectivite_bp'] = "Erreur 404:La boîte postale du représentant de la collectivité est invalide";
        }

        if(empty($_POST['collectivite_bp'])){
            $validationerrors['empty_collectivite_bp'] = "La boîte postale du représentant de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_tel', $_POST)){
            $validationerrors['error_collectivite_tel'] = "Erreur 404:Le champs numero de telephone du representant de la collectivité n'est pas précisé";
        }
        if(empty($_POST['residence_collectivite_tel'])){
            $validationerrors['empty_collectivite_tel'] = "Le numero de telephone du represésentant de la collectivité n'est pas rempli";
        }
        if($_POST['collectivite_tel'] !== ""){
          if(filter_var($_POST['collectivite_tel'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_collectivite_tel'] = "Le Numero de telephone du represésentant de la collectivité doit être numérique";
           }
        }

        if(!array_key_exists('collectivite_representant', $_POST)){
            $validationerrors['error_collectivite_representant'] = "Erreur 404:Le Nom du représentant de la collectivité est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['collectivite_representant'])){
            $validationerrors['empty_collectivite_representant'] = "Le Nom du représentant de la collectivité n'est pas rempli";
         }
          $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["collectivite_name"],
		       "code_membre"=>$ancien_membre,		   
           "demeure"=>$_POST["collectivite_domicile"],
           "quartier"=>$_POST["collectivite_quartier"],
           "boite_postale"=>$_POST["collectivite_bp"],
           "telephone"=>$_POST["collectivite_tel"],
           "nom_representant"=>$_POST["collectivite_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Association"){
        if(!array_key_exists('association_name', $_POST)){
            $validationerrors['error_association_name'] = "Erreur 404:Le Nom de l'Association est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['association_name'])){
            $validationerrors['empty_association_name'] = "Le Nom de l'Association n'est pas rempli";
         }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_association_name"],
		       "code_membre"=>$ancien_membre,  
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

        if($_POST['convention_select'] == "Groupement"){
          if(!array_key_exists('groupement_name', $_POST)){
            $validationerrors['error_groupement_name'] = "Erreur 404:Le Nom du groupement est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['groupement_name'])){
            $validationerrors['empty_groupement_name'] = "Le Nom du groupement n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["groupement_name"],
		       "code_membre"=>$ancien_membre,	   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Coopérative"){
          if(!array_key_exists('cooperative_name', $_POST)){
            $validationerrors['error_cooperative_name'] = "Erreur 404:Le Nom de la coopérative est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['cooperative_name'])){
            $validationerrors['empty_cooperative_name'] = "Le Nom de la coopérative n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["cooperative_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Union"){
          if(!array_key_exists('union_name', $_POST)){
            $validationerrors['error_union_name'] = "Erreur 404:Le Nom de l'Union est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['union_name'])){
            $validationerrors['empty_union_name'] = "Le Nom de l'Union n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["union_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
         
       }

       
      if($_POST['convention_select'] == "ONG"){
          if(!array_key_exists('ong_name', $_POST)){
            $validationerrors['error_ong_name'] = "Erreur 404:Le Nom de l'ONG est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['ong_name'])){
            $validationerrors['empty_ong_name'] = "Le Nom de l'ONG n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
       
       
      if($_POST['convention_select'] == "Confédération"){
          if(!array_key_exists('confédération_name', $_POST)){
            $validationerrors['error_confédération_name'] = "Erreur 404:Le Nom de la confédération est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confédération_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom de la confédération n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confédération_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
      
      if($_POST['convention_select'] == "Réseau"){
          if(!array_key_exists('reseau_name', $_POST)){
            $validationerrors['error_reseau_name'] = "Erreur 404:Le Nom du réseau est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['reseau_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom du réseau n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["reseau_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Faitière"){
          if(!array_key_exists('faitiere_name', $_POST)){
            $validationerrors['error_faitiere_name'] = "Erreur 404:Le Nom du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_name'])){
            $validationerrors['empty_faitiere_name'] = "Le Nom du faitière n'est pas rempli";
          }

          if(!array_key_exists('numero_recipice', $_POST)){
            $validationerrors['error_numero_recipice'] = "Erreur 404:Le Numéro de recipice du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['numero_recipice'])){
            $validationerrors['empty_numero_recipice'] = "Le Numéro de recipice du faitière n'est pas rempli";
          }

          if(!array_key_exists('faitiere_representant', $_POST)){
            $validationerrors['error_faitiere_representant'] = "Erreur 404:Le Représentant du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_representant'])){
            $validationerrors['empty_faitiere_representant'] = "Le Représentant du faitière n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["faitiere_name"],
		       "code_membre"=>$ancien_membre,		   
           "numero_recipice"=>$_POST["faitiere_numero"],
           "nom_representant"=>$_POST["faitiere_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Confession_réligieuse"){
          if(!array_key_exists('confession_religieuse_name', $_POST)){
            $validationerrors['error_confession_religieuse_name'] = "Erreur 404:Le Nom de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Nom de la confession réligieuse n'est pas rempli";
          }
          if(!array_key_exists('confession_religieuse_quartier_name', $_POST)){
            $validationerrors['error_confession_religieuse_quartier_name'] = "Erreur 404:Le Nom du quartier de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_quartier_name'])){
            $validationerrors['empty_confession_religieuse_quartier_name'] = "Le Nom du quartier de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_representant', $_POST)){
            $validationerrors['error_confession_religieuse_representant'] = "Erreur 404:Le Représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_demeure', $_POST)){
            $validationerrors['error_confession_religieuse_demeure'] = "Erreur 404:Le domicile du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_demeure'])){
            $validationerrors['empty_confession_religieuse_demeure'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_bp', $_POST)){
            $validationerrors['error_confession_religieuse_bp'] = "Erreur 404:La boîte postale du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_bp'])){
            $validationerrors['empty_confession_religieuse_bp'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_phone', $_POST)){
            $validationerrors['error_confession_religieuse_phone'] = "Erreur 404:Le numéro de telephone du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_phone'])){
            $validationerrors['empty_confession_religieuse_phone'] = "Le numéro de telephone du représentant de la confession réligieuse n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confession_religieuse_name"],
		       "code_membre"=>$ancien_membre,		   
           "quartier"=>$_POST["confession_religieuse_quartier_name"],
           "demeure"=>$_POST["confession_religieuse_demeure"],
           "nom_representant"=>$_POST["confession_religieuse_representant"],
           "boite_postale"=>$_POST["confession_religieuse_bp"],
           "telephone"=>$_POST["confession_religieuse_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "EPA"){
          if(!array_key_exists('etablissement_administratif_name', $_POST)){
            $validationerrors['error_etablissement_administratif_name'] = "Erreur 404:Le Nom de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_name'])){
            $validationerrors['empty_etablissement_administratif_name'] = "Le Nom de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_bp', $_POST)){
            $validationerrors['error_etablissement_administratif_bp'] = "Erreur 404:La boîte postale l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_bp'])){
            $validationerrors['empty_etablissement_administratif_bp'] = "Le boîte postle de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_telephone', $_POST)){
            $validationerrors['error_etablissement_administratif_telephone'] = "Erreur 404:Le numéro de telephone de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_telephone'])){
            $validationerrors['empty_etablissement_administratif_telephone'] = "Le numéro de telephone de l'établissement public administratif n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_administratif_name"],
		       "code_membre"=>$ancien_membre,		   
           "boite_postale"=>$_POST["etablissement_administratif_bp"],
           "telephone"=>$_POST["etablissement_administratif_telephone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "EPIC"){
          if(!array_key_exists('etablissement_industriel_commercial_name', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_name'] = "Erreur 404:Le Nom de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_name'])){
            $validationerrors['empty_etablissement_industriel_commercial_name'] = "Le Nom de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_bp', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_bp'] = "Erreur 404:La boîte postale  de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_bp'])){
            $validationerrors['empty_etablissement_industriel_commercial_bp'] = "Le boîte postale du représentant de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_phone', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_phone'] = "Erreur 404:Le numéro de telephone de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_phone'])){
            $validationerrors['empty_etablissement_industriel_commercial_phone'] = "Le numéro de telephone de l'établissement industriel commercial n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_industriel_commercial_name"],
		       "code_membre"=>$ancien_membre,		   
           "boite_postale"=>$_POST["etablissement_industriel_commercial_bp"],
           "telephone"=>$_POST["etablissement_industriel_commercial_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Organisation_Internationale"){
          if(!array_key_exists('organisation_internationale_name', $_POST)){
            $validationerrors['error_organisation_internationale_name'] = "Erreur 404:Le Nom de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_name'])){
            $validationerrors['empty_organisation_internationale_name'] = "Le Nom de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_bp', $_POST)){
            $validationerrors['error_organisation_internationale_bp'] = "Erreur 404:La boîte postale  de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_bp'])){
            $validationerrors['empty_organisation_internationale_bp'] = "Le boîte postale de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_phone', $_POST)){
            $validationerrors['error_organisation_internationale_phone'] = "Erreur 404:Le numéro de téléphone de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_phone'])){
            $validationerrors['empty_organisation_internationale_phone'] = "Le numéro de téléphone de l'organisation internationale n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["organisation_internationale_name"],
		       "code_membre"=>$ancien_membre,		   
           "boite_postale"=>$_POST["organisation_internationale_bp"],
           "telephone"=>$_POST["organisation_internationale_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Société"){
          if(!array_key_exists('societe_name', $_POST)){
            $validationerrors['error_societe_name'] = "Erreur 404:Le Nom de l'organisation internationale commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_name'])){
            $validationerrors['empty_societe_name'] = "Le Nom de l'organisation internationale commercial n'est pas rempli";
          }

          if(!array_key_exists('societe_imatriculation_numero', $_POST)){
            $validationerrors['error_societe_imatriculation_numero'] = "Erreur 404:Le numéro d'imatriculation de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_imatriculation_numero'])){
            $validationerrors['empty_societe_imatriculation_numero'] = "Le numéro d'imatriculation de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_siege', $_POST)){
            $validationerrors['error_societe_siege'] = "Erreur 404:Le siege de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_siege'])){
            $validationerrors['empty_societe_siege'] = "Le siege de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_representant_name', $_POST)){
            $validationerrors['error_societe_representant_name'] = "Erreur 404:Le nom du représentant de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_representant_name'])){
            $validationerrors['empty_societe_representant_name'] = "Le nom du représentant de la société n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["societe_name"],
		       "code_membre"=>$ancien_membre,
           "numero_recipice"=>$_POST["societe_imatriculation_numero"],
           "siege"=>$_POST["societe_siege"],
           "nom_representant"=>$_POST["societe_representant_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
           $ancienmembre = $_SESSION['membre']['ancien_membre'];
             var_dump($_SESSION);
             var_dump($_POST);
          if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
                
           }        
           
         if(!empty($convention_array) && empty($validationerrors)){
              if($dbcv->insert($convention_array)){
                $this->_redirect('/souscriptionbon/enrolementmcnppp/id/'.$ancien_membre);
              }

      }
    }
    
  }

/*
                

   */
  

  public function conventionreactivationpmAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmc');
		$sessionmembre = new Zend_Session_Namespace('membre');
    $dbcv = new Application_Model_DbTable_EuConvention();
    $cv = new Application_Model_EuConvention();
    $mpcv = new Application_Model_EuConventionMapper();
    $request = $this->getRequest();
    $validationerrors = array();
    $created = Zend_Date::now();
    $ancien_membre = $_SESSION['ancien_membre'];
    $convention_array = array();
    $date_convention =  $created->toString('yyyy-MM-dd HH:mm:ss');
       
    $this->view->dateconvention = $date_convention;

    if($request->isPost()){
      if(!array_key_exists('convention_select', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404: Vous essayez d'effectuer une action qui n'est pas autorisé";
      }
      if($_POST['convention_select'] == "personne_physique"){
         if(!array_key_exists('civilite_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du demandeur de ce ticket n'existe pas";
         }

         if(empty($_POST['civilite_name'])){
            $validationerrors['empty_civilite_name'] = "Vos Nom et Prenoms ne doivent pas être vide";
         }

         if(!array_key_exists('civilite_domicile', $_POST)){
            $validationerrors['error_civilite_domicile'] = "Erreur 404:Le Type demeur n'existe pas";
         }
         if(empty($_POST['civilite_domicile']) || $_POST['civilite_domicile'] == ""){
            $validationerrors['empty_civilite_domicile'] = "Le lieu ne doivent pas être vide";
         }

        if(!array_key_exists('civilite_quartier', $_POST)){
            $validationerrors['error_civilite_quartier'] = "Erreur 404:le quartier n'existe pas";
         }
         if(empty($_POST['civilite_quartier'])){
            $validationerrors['empty_civilite_quartier'] = "Le quartier n'est pas rempli";
         }

        if(!array_key_exists('civilite_bp', $_POST)){
            $validationerrors['error_civilite_bp'] = "Erreur 404:La boîte postale n'est pas précisé";
        }

        if(!array_key_exists('civilite_phone', $_POST)){
            $validationerrors['error_civilite_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['civilite_phone'])){
            $validationerrors['empty_civilite_phone'] = "Le numero de telephone n'est pas rempli";
        }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["civilite_name"],
		       "code_membre"=>$ancien_membre,		   
           "demeure"=>$_POST["civilite_domicile"],
           "libelle_demeure"=>$_POST["civilite_domicile"],
           "quartier"=>$_POST["civilite_quartier"],
           "boite_postale"=>$_POST["civilite_bp"],
           "telephone"=>$_POST["civilite_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
       /**,
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]**/

       if($_POST['convention_select'] == "Etablissement"){
         if(!array_key_exists('etablissement_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_name'])){
            $validationerrors['empty_etablissement_name'] = "Le nom de l'établissement pas être vide";
         }

         if(!array_key_exists('etablissement_residence', $_POST)){
            $validationerrors['error_etablissement_residence'] = "Erreur 404:Le Lieu de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_residence'])){
            $validationerrors['empty_etablissement_residence'] = "Le Lieu de l'établissement ne doit pas être vide";
         }

        if(!array_key_exists('etablissement_quartier', $_POST)){
            $validationerrors['error_etablissement_quartier'] = "Erreur 404:le quartier de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_quartier'])){
            $validationerrors['empty_etablissement_quartier'] = "Le quartier de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant l'établissemnt est invalide";
        }

        if(empty($_POST['etablissement_representant_bp'])){
            $validationerrors['empty_etablissement_representant_bp'] = "La boîte postale du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_phone', $_POST)){
            $validationerrors['error_etablissement_representant_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['etablissement_representant_phone'])){
            $validationerrors['empty_etablissement_representant_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['etablissement_representant_phone'] !== ""){
          if(filter_var($_POST['etablissement_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_etablissement_representant_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

        if(!array_key_exists('etablissement_rue', $_POST)){
            $validationerrors['error_etablissement_rue'] = "Erreur 404:La Rue de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_rue'])){
            $validationerrors['empty_etablissement_rue'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_name', $_POST)){
            $validationerrors['error_etablissement_representant_name'] = "Erreur 404:Le Nom du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_name'])){
            $validationerrors['empty_etablissement_representant_name'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_operateur', $_POST)){
            $validationerrors['error_etablissement_representant_operateur'] = "Erreur 404:Le Numero d'opérateur du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_operateur'])){
            $validationerrors['empty_etablissement_representant_operateur'] = "Le Numero d'opérateur du représentant de l'établissement n'est pas rempli";
         }

        $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_name"],
		       "code_membre"=>$ancien_membre,		   
           "libelle_situation"=>$_POST["etablissement_residence"],
           "quartier"=>$_POST["etablissement_quartier"],
           "boite_postale"=>$_POST["etablissement_representant_bp"],
           "telephone"=>$_POST["etablissement_representant_phone"],
           "rue"=>$_POST["etablissement_rue"],
           "civilite_representant"=>$_POST["etablissement_representant"],
           "nom_representant"=>$_POST["etablissement_representant_name"],
           "carte_operateur"=>$_POST["etablissement_representant_operateur"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
           
         );
       }

       if($_POST['convention_select'] == "Maison_Villa_Immeuble"){
         if(!array_key_exists('residence_name', $_POST)){
            $validationerrors['error_residence_name'] = "Erreur 404:Le Nom de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_name'])){
            $validationerrors['empty_residence_name'] = "Le nom de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_situation', $_POST)){
            $validationerrors['error_residence_situation'] = "Erreur 404:Le lieu de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_situation'])){
            $validationerrors['empty_residence_situation'] = "Le lieu de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_representant_demeure', $_POST)){
            $validationerrors['error_residence_representant_demeure'] = "Erreur 404:Le Lieu de residence du représentant de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_representant_demeure'])){
            $validationerrors['empty_residence_representant_demeure'] = "Le Lieu de residence du représentant de la maison/Villa/Immeuble ne doit pas être vide";
         }

        if(!array_key_exists('residence_quartier', $_POST)){
            $validationerrors['error_residence_quartier'] = "Erreur 404:le quartier de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_quartier'])){
            $validationerrors['empty_residence_quartier'] = "Le quartier de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant la résidence est invalide";
        }

        if(empty($_POST['residence_representant_bp'])){
            $validationerrors['empty_residence_representant_bp'] = "La boîte postale du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_phone', $_POST)){
            $validationerrors['error_residence_representant_phone'] = "Erreur 404:Le champs numero de la maison/Villa/Immeuble n'est pas précisé";
        }
        if(empty($_POST['residence_representant_phone'])){
            $validationerrors['empty_residence_representant_phone'] = "Le numero de telephone du represésentant de la maison/Villa/Immeuble n'est pas rempli";
        }
        if($_POST['residence_representant_phone'] !== ""){
          if(filter_var($_POST['residence_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_residence_representant_phone'] = "Le Numero de telephone du represésentant de la maison/Villa/Immeuble doit être numérique";
           }
        }

        if(!array_key_exists('residence_rue', $_POST)){
            $validationerrors['error_residence_rue'] = "Erreur 404:La Rue de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_rue'])){
            $validationerrors['empty_residence_rue'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant', $_POST)){
            $validationerrors['error_residence_representant'] = "Erreur 404:Le Nom du représentant de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_representant'])){
            $validationerrors['empty_residence_representant'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }


         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
		       "code_membre"=>$ancien_membre,		   
           "type_maison"=>$_POST["residence_name"],
           "demeure"=>$_POST["residence_representant_demeure"],
           "libelle_situation"=>$_POST["residence_situation"],
           "quartier"=>$_POST["residence_quartier"],
           "boite_postale"=>$_POST["residence_representant_bp"],
           "telephone"=>$_POST["residence_representant_phone"],
           "rue"=>$_POST["residence_rue"],
           "nom_representant"=>$_POST["residence_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }


       if($_POST['convention_select'] == "Collectivité"){
        if(!array_key_exists('collectivite_name', $_POST)){
            $validationerrors['error_collectivite_name'] = "Erreur 404:Le Nom de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_name'])){
            $validationerrors['empty_collectivite_name'] = "Le nom de la collectivité ne doit pas être vide";
         }

         if(!array_key_exists('collectivite_domicile', $_POST)){
            $validationerrors['error_collectivite_domicile'] = "Erreur 404:Le Lieu de residence du représentant de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_domicile'])){
            $validationerrors['empty_collectivite_domicile'] = "Le Lieu de residence du représentant de la collectivité ne doit pas être vide";
         }

        if(!array_key_exists('collectivite_quartier', $_POST)){
            $validationerrors['error_collectivite_quartier'] = "Erreur 404:le quartier de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_quartier'])){
            $validationerrors['empty_collectivite_quartier'] = "Le quartier de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_bp', $_POST)){
            $validationerrors['error_collectivite_bp'] = "Erreur 404:La boîte postale du représentant de la collectivité est invalide";
        }

        if(empty($_POST['collectivite_bp'])){
            $validationerrors['empty_collectivite_bp'] = "La boîte postale du représentant de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_tel', $_POST)){
            $validationerrors['error_collectivite_tel'] = "Erreur 404:Le champs numero de telephone du representant de la collectivité n'est pas précisé";
        }
        if(empty($_POST['residence_collectivite_tel'])){
            $validationerrors['empty_collectivite_tel'] = "Le numero de telephone du represésentant de la collectivité n'est pas rempli";
        }
        if($_POST['collectivite_tel'] !== ""){
          if(filter_var($_POST['collectivite_tel'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_collectivite_tel'] = "Le Numero de telephone du represésentant de la collectivité doit être numérique";
           }
        }

        if(!array_key_exists('collectivite_representant', $_POST)){
            $validationerrors['error_collectivite_representant'] = "Erreur 404:Le Nom du représentant de la collectivité est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['collectivite_representant'])){
            $validationerrors['empty_collectivite_representant'] = "Le Nom du représentant de la collectivité n'est pas rempli";
         }
          $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["collectivite_name"],
		       "code_membre"=>$ancien_membre,		   
           "demeure"=>$_POST["collectivite_domicile"],
           "quartier"=>$_POST["collectivite_quartier"],
           "boite_postale"=>$_POST["collectivite_bp"],
           "telephone"=>$_POST["collectivite_tel"],
           "nom_representant"=>$_POST["collectivite_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Association"){
        if(!array_key_exists('association_name', $_POST)){
            $validationerrors['error_association_name'] = "Erreur 404:Le Nom de l'Association est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['association_name'])){
            $validationerrors['empty_association_name'] = "Le Nom de l'Association n'est pas rempli";
         }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_association_name"],
		       "code_membre"=>$ancien_membre,  
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

        if($_POST['convention_select'] == "Groupement"){
          if(!array_key_exists('groupement_name', $_POST)){
            $validationerrors['error_groupement_name'] = "Erreur 404:Le Nom du groupement est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['groupement_name'])){
            $validationerrors['empty_groupement_name'] = "Le Nom du groupement n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["groupement_name"],
		       "code_membre"=>$ancien_membre,	   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "Coopérative"){
          if(!array_key_exists('cooperative_name', $_POST)){
            $validationerrors['error_cooperative_name'] = "Erreur 404:Le Nom de la coopérative est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['cooperative_name'])){
            $validationerrors['empty_cooperative_name'] = "Le Nom de la coopérative n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["cooperative_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Union"){
          if(!array_key_exists('union_name', $_POST)){
            $validationerrors['error_union_name'] = "Erreur 404:Le Nom de l'Union est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['union_name'])){
            $validationerrors['empty_union_name'] = "Le Nom de l'Union n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["union_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
         
       }

       
      if($_POST['convention_select'] == "ONG"){
          if(!array_key_exists('ong_name', $_POST)){
            $validationerrors['error_ong_name'] = "Erreur 404:Le Nom de l'ONG est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['ong_name'])){
            $validationerrors['empty_ong_name'] = "Le Nom de l'ONG n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
       
       
      if($_POST['convention_select'] == "Confédération"){
          if(!array_key_exists('confédération_name', $_POST)){
            $validationerrors['error_confédération_name'] = "Erreur 404:Le Nom de la confédération est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confédération_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom de la confédération n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confédération_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
      
      if($_POST['convention_select'] == "Réseau"){
          if(!array_key_exists('reseau_name', $_POST)){
            $validationerrors['error_reseau_name'] = "Erreur 404:Le Nom du réseau est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['reseau_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom du réseau n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["reseau_name"],
		       "code_membre"=>$ancien_membre,		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Faitière"){
          if(!array_key_exists('faitiere_name', $_POST)){
            $validationerrors['error_faitiere_name'] = "Erreur 404:Le Nom du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_name'])){
            $validationerrors['empty_faitiere_name'] = "Le Nom du faitière n'est pas rempli";
          }

          if(!array_key_exists('numero_recipice', $_POST)){
            $validationerrors['error_numero_recipice'] = "Erreur 404:Le Numéro de recipice du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['numero_recipice'])){
            $validationerrors['empty_numero_recipice'] = "Le Numéro de recipice du faitière n'est pas rempli";
          }

          if(!array_key_exists('faitiere_representant', $_POST)){
            $validationerrors['error_faitiere_representant'] = "Erreur 404:Le Représentant du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_representant'])){
            $validationerrors['empty_faitiere_representant'] = "Le Représentant du faitière n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["faitiere_name"],
		       "code_membre"=>$ancien_membre,		   
           "numero_recipice"=>$_POST["faitiere_numero"],
           "nom_representant"=>$_POST["faitiere_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Confession_réligieuse"){
          if(!array_key_exists('confession_religieuse_name', $_POST)){
            $validationerrors['error_confession_religieuse_name'] = "Erreur 404:Le Nom de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Nom de la confession réligieuse n'est pas rempli";
          }
          if(!array_key_exists('confession_religieuse_quartier_name', $_POST)){
            $validationerrors['error_confession_religieuse_quartier_name'] = "Erreur 404:Le Nom du quartier de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_quartier_name'])){
            $validationerrors['empty_confession_religieuse_quartier_name'] = "Le Nom du quartier de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_representant', $_POST)){
            $validationerrors['error_confession_religieuse_representant'] = "Erreur 404:Le Représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_demeure', $_POST)){
            $validationerrors['error_confession_religieuse_demeure'] = "Erreur 404:Le domicile du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_demeure'])){
            $validationerrors['empty_confession_religieuse_demeure'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_bp', $_POST)){
            $validationerrors['error_confession_religieuse_bp'] = "Erreur 404:La boîte postale du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_bp'])){
            $validationerrors['empty_confession_religieuse_bp'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_phone', $_POST)){
            $validationerrors['error_confession_religieuse_phone'] = "Erreur 404:Le numéro de telephone du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_phone'])){
            $validationerrors['empty_confession_religieuse_phone'] = "Le numéro de telephone du représentant de la confession réligieuse n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confession_religieuse_name"],
		       "code_membre"=>$ancien_membre,		   
           "quartier"=>$_POST["confession_religieuse_quartier_name"],
           "demeure"=>$_POST["confession_religieuse_demeure"],
           "nom_representant"=>$_POST["confession_religieuse_representant"],
           "boite_postale"=>$_POST["confession_religieuse_bp"],
           "telephone"=>$_POST["confession_religieuse_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "EPA"){
          if(!array_key_exists('etablissement_administratif_name', $_POST)){
            $validationerrors['error_etablissement_administratif_name'] = "Erreur 404:Le Nom de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_name'])){
            $validationerrors['empty_etablissement_administratif_name'] = "Le Nom de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_bp', $_POST)){
            $validationerrors['error_etablissement_administratif_bp'] = "Erreur 404:La boîte postale l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_bp'])){
            $validationerrors['empty_etablissement_administratif_bp'] = "Le boîte postle de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_telephone', $_POST)){
            $validationerrors['error_etablissement_administratif_telephone'] = "Erreur 404:Le numéro de telephone de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_telephone'])){
            $validationerrors['empty_etablissement_administratif_telephone'] = "Le numéro de telephone de l'établissement public administratif n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_administratif_name"],
		       "code_membre"=>$ancien_membre,		   
           "boite_postale"=>$_POST["etablissement_administratif_bp"],
           "telephone"=>$_POST["etablissement_administratif_telephone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

       if($_POST['convention_select'] == "EPIC"){
          if(!array_key_exists('etablissement_industriel_commercial_name', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_name'] = "Erreur 404:Le Nom de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_name'])){
            $validationerrors['empty_etablissement_industriel_commercial_name'] = "Le Nom de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_bp', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_bp'] = "Erreur 404:La boîte postale  de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_bp'])){
            $validationerrors['empty_etablissement_industriel_commercial_bp'] = "Le boîte postale du représentant de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_phone', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_phone'] = "Erreur 404:Le numéro de telephone de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_phone'])){
            $validationerrors['empty_etablissement_industriel_commercial_phone'] = "Le numéro de telephone de l'établissement industriel commercial n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_industriel_commercial_name"],
		       "code_membre"=>$ancien_membre,		   
           "boite_postale"=>$_POST["etablissement_industriel_commercial_bp"],
           "telephone"=>$_POST["etablissement_industriel_commercial_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Organisation_Internationale"){
          if(!array_key_exists('organisation_internationale_name', $_POST)){
            $validationerrors['error_organisation_internationale_name'] = "Erreur 404:Le Nom de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_name'])){
            $validationerrors['empty_organisation_internationale_name'] = "Le Nom de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_bp', $_POST)){
            $validationerrors['error_organisation_internationale_bp'] = "Erreur 404:La boîte postale  de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_bp'])){
            $validationerrors['empty_organisation_internationale_bp'] = "Le boîte postale de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_phone', $_POST)){
            $validationerrors['error_organisation_internationale_phone'] = "Erreur 404:Le numéro de téléphone de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_phone'])){
            $validationerrors['empty_organisation_internationale_phone'] = "Le numéro de téléphone de l'organisation internationale n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["organisation_internationale_name"],
		       "code_membre"=>$ancien_membre,		   
           "boite_postale"=>$_POST["organisation_internationale_bp"],
           "telephone"=>$_POST["organisation_internationale_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }

      if($_POST['convention_select'] == "Société"){
          if(!array_key_exists('societe_name', $_POST)){
            $validationerrors['error_societe_name'] = "Erreur 404:Le Nom de l'organisation internationale commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_name'])){
            $validationerrors['empty_societe_name'] = "Le Nom de l'organisation internationale commercial n'est pas rempli";
          }

          if(!array_key_exists('societe_imatriculation_numero', $_POST)){
            $validationerrors['error_societe_imatriculation_numero'] = "Erreur 404:Le numéro d'imatriculation de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_imatriculation_numero'])){
            $validationerrors['empty_societe_imatriculation_numero'] = "Le numéro d'imatriculation de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_siege', $_POST)){
            $validationerrors['error_societe_siege'] = "Erreur 404:Le siege de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_siege'])){
            $validationerrors['empty_societe_siege'] = "Le siege de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_representant_name', $_POST)){
            $validationerrors['error_societe_representant_name'] = "Erreur 404:Le nom du représentant de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_representant_name'])){
            $validationerrors['empty_societe_representant_name'] = "Le nom du représentant de la société n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["societe_name"],
		       "code_membre"=>$ancien_membre,
           "numero_recipice"=>$_POST["societe_imatriculation_numero"],
           "siege"=>$_POST["societe_siege"],
           "nom_representant"=>$_POST["societe_representant_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "signature_new_convention"=>'1'
         );
       }
           $ancienmembre = $_SESSION['membre']['ancien_membre'];

          if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
                
           }        
           
         if(!empty($convention_array) && empty($validationerrors)){
              if($dbcv->insert($convention_array)){
                $this->_redirect('/souscriptionbon/enrolementmcnppm/id/'.$ancien_membre);
              }
         }
    }
    
  }


    public function banconventionAction(){
          $this->_helper->layout()->setLayout('layoutpublicesmc');
    $dbcv = new Application_Model_DbTable_EuConvention();
    $cv = new Application_Model_EuConvention();
    $mpcv = new Application_Model_EuConventionMapper();
    $request = $this->getRequest();
    $validationerrors = array();
    $validationemailerrors = array();
    $validationperteerrors = array();
    $validationpertesuccess = array();
    $convention_array = array();
    $created = Zend_Date::now();

    if($request->isPost()){
      if(!array_key_exists('convention_select', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404: de ce ticket n'existe pas";
      }
      if($_POST['convention_select'] == "Personne physique"){
         if(!array_key_exists('civilite_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du demandeur de ce ticket n'existe pas";
         }
         if(empty($_POST['civilite_name'])){
            $validationerrors['empty_civilite_name'] = "Vos Nom et Prenoms ne doivent pas être vide";
         }

         if(!array_key_exists('civilite_type_demeure', $_POST)){
            $validationerrors['error_civilite_type_demeure'] = "Erreur 404:Le Type demeur n'existe pas";
         }
         if(empty($_POST['civilite_type_demeure']) || $_POST['civilite_type_demeure'] == ""){
            $validationerrors['empty_civilite_type_demeure'] = "Le lieu ne doivent pas être vide";
         }

        if(!array_key_exists('civilite_quartier', $_POST)){
            $validationerrors['error_civilite_quartier'] = "Erreur 404:le quartier n'existe pas";
         }
         if(empty($_POST['civilite_quartier'])){
            $validationerrors['empty_civilite_quartier'] = "Le quartier n'est pas rempli";
         }

        if(!array_key_exists('civilite_bp', $_POST)){
            $validationerrors['error_civilite_bp'] = "Erreur 404:La boîte postale n'est pas précisé";
        }

        if(!array_key_exists('civilite_phone', $_POST)){
            $validationerrors['error_civilite_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['civilite_phone'])){
            $validationerrors['empty_civilite_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['civilite_phone'] !== ""){
          if(filter_var($_POST['civilite_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_civilite_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["civilite_name"],
           "demeure"=>$_POST["civilite_type_demeure"],
           "libelle_demeure"=>$_POST["civilite_domicile"],
           "quartier"=>$_POST["civilite_quartier"],
           "boite_postale"=>$_POST["civilite_bp"],
           "telephone"=>$_POST["civilite_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['convention_select'] == "Etablissement"){
         if(!array_key_exists('etablissement_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_name'])){
            $validationerrors['empty_etablissement_name'] = "Le nom de l'établissement pas être vide";
         }

         if(!array_key_exists('etablissement_residence', $_POST)){
            $validationerrors['error_etablissement_residence'] = "Erreur 404:Le Lieu de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_residence'])){
            $validationerrors['empty_etablissement_residence'] = "Le Lieu de l'établissement ne doit pas être vide";
         }

        if(!array_key_exists('etablissement_quartier', $_POST)){
            $validationerrors['error_etablissement_quartier'] = "Erreur 404:le quartier de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_quartier'])){
            $validationerrors['empty_etablissement_quartier'] = "Le quartier de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant l'établissemnt est invalide";
        }

        if(empty($_POST['etablissement_representant_bp'])){
            $validationerrors['empty_etablissement_representant_bp'] = "La boîte postale du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_phone', $_POST)){
            $validationerrors['error_etablissement_representant_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['etablissement_representant_phone'])){
            $validationerrors['empty_etablissement_representant_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['etablissement_representant_phone'] !== ""){
          if(filter_var($_POST['etablissement_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_etablissement_representant_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

        if(!array_key_exists('etablissement_rue', $_POST)){
            $validationerrors['error_etablissement_rue'] = "Erreur 404:La Rue de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_rue'])){
            $validationerrors['empty_etablissement_rue'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_name', $_POST)){
            $validationerrors['error_etablissement_representant_name'] = "Erreur 404:Le Nom du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_name'])){
            $validationerrors['empty_etablissement_representant_name'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_operateur', $_POST)){
            $validationerrors['error_etablissement_representant_operateur'] = "Erreur 404:Le Numero d'opérateur du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_operateur'])){
            $validationerrors['empty_etablissement_representant_operateur'] = "Le Numero d'opérateur du représentant de l'établissement n'est pas rempli";
         }

        $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_name"],
           "libelle_situation"=>$_POST["etablissement_residence"],
           "quartier"=>$_POST["etablissement_quartier"],
           "boite_postale"=>$_POST["etablissement_representant_bp"],
           "telephone"=>$_POST["etablissement_representant_phone"],
           "rue"=>$_POST["etablissement_rue"],
           "civilite_representant"=>$_POST["etablissement_representant"],
           "nom_representant"=>$_POST["etablissement_representant_name"],
           "carte_operateur"=>$_POST["etablissement_representant_operateur"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['convention_select'] == "Maison/Villa/Immeuble"){
         if(!array_key_exists('residence_name', $_POST)){
            $validationerrors['error_residence_name'] = "Erreur 404:Le Nom de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_name'])){
            $validationerrors['empty_residence_name'] = "Le nom de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_situation', $_POST)){
            $validationerrors['error_residence_situation'] = "Erreur 404:Le lieu de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_situation'])){
            $validationerrors['empty_residence_situation'] = "Le lieu de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_representant_demeure', $_POST)){
            $validationerrors['error_residence_representant_demeure'] = "Erreur 404:Le Lieu de residence du représentant de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_representant_demeure'])){
            $validationerrors['empty_residence_representant_demeure'] = "Le Lieu de residence du représentant de la maison/Villa/Immeuble ne doit pas être vide";
         }

        if(!array_key_exists('residence_quartier', $_POST)){
            $validationerrors['error_residence_quartier'] = "Erreur 404:le quartier de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_quartier'])){
            $validationerrors['empty_residence_quartier'] = "Le quartier de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant la résidence est invalide";
        }

        if(empty($_POST['residence_representant_bp'])){
            $validationerrors['empty_residence_representant_bp'] = "La boîte postale du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_phone', $_POST)){
            $validationerrors['error_residence_representant_phone'] = "Erreur 404:Le champs numero de la maison/Villa/Immeuble n'est pas précisé";
        }
        if(empty($_POST['residence_representant_phone'])){
            $validationerrors['empty_residence_representant_phone'] = "Le numero de telephone du represésentant de la maison/Villa/Immeuble n'est pas rempli";
        }
        if($_POST['residence_representant_phone'] !== ""){
          if(filter_var($_POST['residence_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_residence_representant_phone'] = "Le Numero de telephone du represésentant de la maison/Villa/Immeuble doit être numérique";
           }
        }

        if(!array_key_exists('residence_rue', $_POST)){
            $validationerrors['error_residence_rue'] = "Erreur 404:La Rue de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_rue'])){
            $validationerrors['empty_residence_rue'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant', $_POST)){
            $validationerrors['error_residence_representant'] = "Erreur 404:Le Nom du représentant de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_representant'])){
            $validationerrors['empty_residence_representant'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }


         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "type_maison"=>$_POST["residence_name"],
           "demeure"=>$_POST["residence_representant_demeure"],
           "libelle_situation"=>$_POST["residence_situation"],
           "quartier"=>$_POST["residence_quartier"],
           "boite_postale"=>$_POST["residence_representant_bp"],
           "telephone"=>$_POST["residence_representant_phone"],
           "rue"=>$_POST["residence_rue"],
           "nom_representant"=>$_POST["residence_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }


       if($_POST['convention_select'] == "Collectivité"){
        if(!array_key_exists('collectivite_name', $_POST)){
            $validationerrors['error_collectivite_name'] = "Erreur 404:Le Nom de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_name'])){
            $validationerrors['empty_collectivite_name'] = "Le nom de la collectivité ne doit pas être vide";
         }

         if(!array_key_exists('collectivite_domicile', $_POST)){
            $validationerrors['error_collectivite_domicile'] = "Erreur 404:Le Lieu de residence du représentant de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_domicile'])){
            $validationerrors['empty_collectivite_domicile'] = "Le Lieu de residence du représentant de la collectivité ne doit pas être vide";
         }

        if(!array_key_exists('collectivite_quartier', $_POST)){
            $validationerrors['error_collectivite_quartier'] = "Erreur 404:le quartier de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_quartier'])){
            $validationerrors['empty_collectivite_quartier'] = "Le quartier de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_bp', $_POST)){
            $validationerrors['error_collectivite_bp'] = "Erreur 404:La boîte postale du représentant de la collectivité est invalide";
        }

        if(empty($_POST['collectivite_bp'])){
            $validationerrors['empty_collectivite_bp'] = "La boîte postale du représentant de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_tel', $_POST)){
            $validationerrors['error_collectivite_tel'] = "Erreur 404:Le champs numero de telephone du representant de la collectivité n'est pas précisé";
        }
        if(empty($_POST['residence_collectivite_tel'])){
            $validationerrors['empty_collectivite_tel'] = "Le numero de telephone du represésentant de la collectivité n'est pas rempli";
        }
        if($_POST['collectivite_tel'] !== ""){
          if(filter_var($_POST['collectivite_tel'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_collectivite_tel'] = "Le Numero de telephone du represésentant de la collectivité doit être numérique";
           }
        }

        if(!array_key_exists('collectivite_representant', $_POST)){
            $validationerrors['error_collectivite_representant'] = "Erreur 404:Le Nom du représentant de la collectivité est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['collectivite_representant'])){
            $validationerrors['empty_collectivite_representant'] = "Le Nom du représentant de la collectivité n'est pas rempli";
         }
          $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["collectivite_name"],
           "demeure"=>$_POST["collectivite_domicile"],
           "quartier"=>$_POST["collectivite_quartier"],
           "boite_postale"=>$_POST["collectivite_bp"],
           "telephone"=>$_POST["collectivite_tel"],
           "nom_representant"=>$_POST["collectivite_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['convention_select'] == "Association"){
        if(!array_key_exists('association_name', $_POST)){
            $validationerrors['error_association_name'] = "Erreur 404:Le Nom de l'Association est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['association_name'])){
            $validationerrors['empty_association_name'] = "Le Nom de l'Association n'est pas rempli";
         }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_association_name"],		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

        if($_POST['convention_select'] == "Groupement"){
          if(!array_key_exists('groupement_name', $_POST)){
            $validationerrors['error_groupement_name'] = "Erreur 404:Le Nom du groupement est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['groupement_name'])){
            $validationerrors['empty_groupement_name'] = "Le Nom du groupement n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["groupement_name"],		   
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['convention_select'] == "Coopérative"){
          if(!array_key_exists('cooperative_name', $_POST)){
            $validationerrors['error_cooperative_name'] = "Erreur 404:Le Nom de la coopérative est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['cooperative_name'])){
            $validationerrors['empty_cooperative_name'] = "Le Nom de la coopérative n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["cooperative_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['convention_select'] == "Union"){
          if(!array_key_exists('union_name', $_POST)){
            $validationerrors['error_union_name'] = "Erreur 404:Le Nom de l'Union est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['union_name'])){
            $validationerrors['empty_union_name'] = "Le Nom de l'Union n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["union_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
         
       }

       
      if($_POST['convention_select'] == "ONG"){
          if(!array_key_exists('ong_name', $_POST)){
            $validationerrors['error_ong_name'] = "Erreur 404:Le Nom de l'ONG est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['ong_name'])){
            $validationerrors['empty_ong_name'] = "Le Nom de l'ONG n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["ong_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
       
       
      if($_POST['convention_select'] == "Confédération"){
          if(!array_key_exists('confédération_name', $_POST)){
            $validationerrors['error_confédération_name'] = "Erreur 404:Le Nom de la confédération est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confédération_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom de la confédération n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confédération_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
      
      if($_POST['convention_select'] == "Réseau"){
          if(!array_key_exists('reseau_name', $_POST)){
            $validationerrors['error_reseau_name'] = "Erreur 404:Le Nom du réseau est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['reseau_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom du réseau n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["reseau_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['convention_select'] == "Faitière"){
          if(!array_key_exists('faitiere_name', $_POST)){
            $validationerrors['error_faitiere_name'] = "Erreur 404:Le Nom du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_name'])){
            $validationerrors['empty_faitiere_name'] = "Le Nom du faitière n'est pas rempli";
          }

          if(!array_key_exists('numero_recipice', $_POST)){
            $validationerrors['error_numero_recipice'] = "Erreur 404:Le Numéro de recipice du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['numero_recipice'])){
            $validationerrors['empty_numero_recipice'] = "Le Numéro de recipice du faitière n'est pas rempli";
          }

          if(!array_key_exists('faitiere_representant', $_POST)){
            $validationerrors['error_faitiere_representant'] = "Erreur 404:Le Représentant du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_representant'])){
            $validationerrors['empty_faitiere_representant'] = "Le Représentant du faitière n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["faitiere_name"],
           "numero_recipice"=>$_POST["faitiere_numero"],
           "nom_representant"=>$_POST["faitiere_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['convention_select'] == "Confession réligieuse"){
          if(!array_key_exists('confession_religieuse_name', $_POST)){
            $validationerrors['error_confession_religieuse_name'] = "Erreur 404:Le Nom de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Nom de la confession réligieuse n'est pas rempli";
          }
          if(!array_key_exists('confession_religieuse_quartier_name', $_POST)){
            $validationerrors['error_confession_religieuse_quartier_name'] = "Erreur 404:Le Nom du quartier de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_quartier_name'])){
            $validationerrors['empty_confession_religieuse_quartier_name'] = "Le Nom du quartier de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_representant', $_POST)){
            $validationerrors['error_confession_religieuse_representant'] = "Erreur 404:Le Représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_demeure', $_POST)){
            $validationerrors['error_confession_religieuse_demeure'] = "Erreur 404:Le domicile du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_demeure'])){
            $validationerrors['empty_confession_religieuse_demeure'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_bp', $_POST)){
            $validationerrors['error_confession_religieuse_bp'] = "Erreur 404:La boîte postale du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_bp'])){
            $validationerrors['empty_confession_religieuse_bp'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_phone', $_POST)){
            $validationerrors['error_confession_religieuse_phone'] = "Erreur 404:Le numéro de telephone du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_phone'])){
            $validationerrors['empty_confession_religieuse_phone'] = "Le numéro de telephone du représentant de la confession réligieuse n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["confession_religieuse_name"],
           "quartier"=>$_POST["confession_religieuse_quartier_name"],
           "demeure"=>$_POST["confession_religieuse_demeure"],
           "nom_representant"=>$_POST["confession_religieuse_representant"],
           "boite_postale"=>$_POST["confession_religieuse_bp"],
           "telephone"=>$_POST["confession_religieuse_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['convention_select'] == "Etablissement Public Administratif"){
          if(!array_key_exists('etablissement_administratif_name', $_POST)){
            $validationerrors['error_etablissement_administratif_name'] = "Erreur 404:Le Nom de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_name'])){
            $validationerrors['empty_etablissement_administratif_name'] = "Le Nom de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_bp', $_POST)){
            $validationerrors['error_etablissement_administratif_bp'] = "Erreur 404:La boîte postale l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_bp'])){
            $validationerrors['empty_etablissement_administratif_bp'] = "Le boîte postle de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_telephone', $_POST)){
            $validationerrors['error_etablissement_administratif_telephone'] = "Erreur 404:Le numéro de telephone de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_telephone'])){
            $validationerrors['empty_etablissement_administratif_telephone'] = "Le numéro de telephone de l'établissement public administratif n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_administratif_name"],
           "boite_postale"=>$_POST["etablissement_administratif_bp"],
           "telephone"=>$_POST["etablissement_administratif_telephone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['convention_select'] == "Etablissement Public Industriel Commercial"){
          if(!array_key_exists('etablissement_industriel_commercial_name', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_name'] = "Erreur 404:Le Nom de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_name'])){
            $validationerrors['empty_etablissement_industriel_commercial_name'] = "Le Nom de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_bp', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_bp'] = "Erreur 404:La boîte postale  de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_bp'])){
            $validationerrors['empty_etablissement_industriel_commercial_bp'] = "Le boîte postale du représentant de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_phone', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_phone'] = "Erreur 404:Le numéro de telephone de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_phone'])){
            $validationerrors['empty_etablissement_industriel_commercial_phone'] = "Le numéro de telephone de l'établissement industriel commercial n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["etablissement_industriel_commercial_name"],
           "boite_postale"=>$_POST["etablissement_industriel_commercial_bp"],
           "telephone"=>$_POST["etablissement_industriel_commercial_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['convention_select'] == "Organisation_Internationale"){
          if(!array_key_exists('organisation_internationale_name', $_POST)){
            $validationerrors['error_organisation_internationale_name'] = "Erreur 404:Le Nom de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_name'])){
            $validationerrors['empty_organisation_internationale_name'] = "Le Nom de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_bp', $_POST)){
            $validationerrors['error_organisation_internationale_bp'] = "Erreur 404:La boîte postale  de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_bp'])){
            $validationerrors['empty_organisation_internationale_bp'] = "Le boîte postale de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_phone', $_POST)){
            $validationerrors['error_organisation_internationale_phone'] = "Erreur 404:Le numéro de téléphone de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_phone'])){
            $validationerrors['empty_organisation_internationale_phone'] = "Le numéro de téléphone de l'organisation internationale n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["organisation_internationale_name"],
           "boite_postale"=>$_POST["organisation_internationale_bp"],
           "telephone"=>$_POST["organisation_internationale_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['convention_select'] == "Société"){
          if(!array_key_exists('societe_name', $_POST)){
            $validationerrors['error_societe_name'] = "Erreur 404:Le Nom de l'organisation internationale commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_name'])){
            $validationerrors['empty_societe_name'] = "Le Nom de l'organisation internationale commercial n'est pas rempli";
          }

          if(!array_key_exists('societe_imatriculation_numero', $_POST)){
            $validationerrors['error_societe_imatriculation_numero'] = "Erreur 404:Le numéro d'imatriculation de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_imatriculation_numero'])){
            $validationerrors['empty_societe_imatriculation_numero'] = "Le numéro d'imatriculation de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_siege', $_POST)){
            $validationerrors['error_societe_siege'] = "Erreur 404:Le siege de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_siege'])){
            $validationerrors['empty_societe_siege'] = "Le siege de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_representant_name', $_POST)){
            $validationerrors['error_societe_representant_name'] = "Erreur 404:Le nom du représentant de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_representant_name'])){
            $validationerrors['empty_societe_representant_name'] = "Le nom du représentant de la société n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["convention_select"],
           "nom"=>$_POST["societe_name"],
           "numero_recipice"=>$_POST["societe_imatriculation_numero"],
           "siege"=>$_POST["societe_siege"],
           "nom_representant"=>$_POST["societe_representant_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
       

          if(!empty($validationerrors)){
             $_SESSION['validationerrors'] = $validationerrors;
           }
         if(!empty($convention_array) && empty($validationerrors)){
              $_SESSION['information_convention'] = $convention_array;
              $this->_redirect("/addsouscriptionban/paramban/1");
         }
      }
    }
    public function lectureAction(){
       $this->_helper->layout()->setLayout('layoutpublicesmc');
       $validation = (int)$this->_request->getParam('param');
       $created = Zend_Date::now();       
       $date_convention =  $created->toString('yyyy-MM-dd HH:mm:ss');
       
       $this->view->dateconvention = $date_convention;
    }

    public function conventiongenererpdfAction () {
      $codemembre = (int)$this->_request->getParam('id');

      $this->_redirect(Util_Utils::genererPdfConvention($codemembre));
     
    }


    public function indexnewAction () {

    }
    public function testconventionAction(){
      
    }

    public function contratdepartenariatAction () {
      
    }

    public function readconventionpersonnephysiqueespacepersonnelAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      $request = $this->getRequest();
      
      $id = (int)$this->_request->getParam('codemembre');

      $code_membre = '0010010010010000215M';

      $dbverifselect = "SELECT *
                        FROM eu_convention
                        WHERE eu_convention.code_membre = '$code_membre'";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dbconvention = $stmt->fetchAll();    
      $this->view->conventionmembre = $dbconvention;
      var_dump($dbconvention);

    }

    public function listedetouslessignatairesdelaconventionppAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      

      $dbtselect = "SELECT 
                       DISTINCT(eu_convention.code_membre),
                       eu_convention.nom,
                       eu_convention.date_convention
                    FROM eu_convention, eu_membre WHERE eu_convention.code_membre = eu_membre.code_membre AND eu_convention.code_membre != '' AND eu_convention.signature_new_convention=1"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresulttouslessignatairesdelaconventionpp = $stmt->fetchAll();
      $this->view->resulttouslessignatairesdelaconventionpp = $dbresulttouslessignatairesdelaconventionpp;
      $this->view->tabletri = 1;
      
      
    }

    public function listedetouslessignatairesdelaconventionpmAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      

      $dbtselect = "SELECT
                       civilite,
                       eu_convention.code_membre,
                       eu_membre_morale.raison_sociale, 
                       eu_convention.date_convention 
                    FROM eu_convention, eu_membre_morale
                    WHERE eu_convention.code_membre = eu_membre_morale.code_membre_morale
                    AND eu_convention.signature_new_convention=1"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresulttouslessignatairesdelaconventionpm = $stmt->fetchAll();
      $this->view->resulttouslessignatairesdelaconventionpm = $dbresulttouslessignatairesdelaconventionpm;

      $this->view->tabletri = 1;      
    }

    public function listedetouslessignatairesdelafranchiseAction () {
      $db = Zend_Db_Table::getDefaultAdapter();

      $dbtselect = "SELECT
                     eu_franchise.code_membre_franchise,
                     eu_membre_morale.raison_sociale,
                     eu_representation.code_membre,                           
                     eu_franchise.representant,
                     eu_franchise.type_franchise,
                     eu_franchise.create_date
                    FROM 
                    eu_franchise,
                    eu_membre_morale,
                    eu_representation
                    WHERE eu_franchise.code_membre_franchise = eu_membre_morale.code_membre_morale
                    AND eu_franchise.code_membre_franchise = eu_representation.code_membre_morale"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultdetouslessignatairesdelafranchise = $stmt->fetchAll();

      $this->view->resultdetouslessignatairesdelafranchise = $dbresultdetouslessignatairesdelafranchise;

      $this->view->tabletri = 1;      
    }

    public function listedetouslessignatairesdelelipmAction () {
      $db = Zend_Db_Table::getDefaultAdapter();

      $dbtselect = "SELECT 
                        eu_convention_eli_opi.code_membre as ceocm, 
                        eu_membre_morale.raison_sociale,
                        eu_representation.code_membre as rcm,
                        eu_convention_eli_opi.date_signature 
                    FROM 
                      eu_convention_eli_opi,
                      eu_membre_morale,
                      eu_representation
                    WHERE eu_convention_eli_opi.code_membre = eu_membre_morale.code_membre_morale
                    AND eu_convention_eli_opi.code_membre = eu_representation.code_membre_morale"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultdetouslessignatairesdelelipm = $stmt->fetchAll();

      $this->view->resultdetouslessignatairesdelelipm = $dbresultdetouslessignatairesdelelipm;

      $this->view->tabletri = 1;      
      
    }

    public function listedetouslessignatairesdelelippAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      
      $dbtselect = "SELECT 
                      eu_convention_eli_opi.code_membre,
                      eu_membre.nom_membre,
                      eu_membre.prenom_membre,
                      eu_convention_eli_opi.date_signature 
                    FROM eu_convention_eli_opi, eu_membre
                    WHERE eu_convention_eli_opi.code_membre = eu_membre.code_membre"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultdetouslessignatairesdelelipp = $stmt->fetchAll();
 
      $this->view->resultdetouslessignatairesdelelipp = $dbresultdetouslessignatairesdelelipp;

      $this->view->tabletri = 1;      
    }

    public function listedetouslessignataireducontratdepartenariatAction () {
      $db = Zend_Db_Table::getDefaultAdapter();

      $dbtselect = "SELECT * FROM eu_representation WHERE code_membre_morale ='$code_membre' AND titre='Representant'"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultrepresentant = $stmt->fetchAll();
    }

    public function statistiquedetouselessignatairedeconventionelietfranchiseAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      
      /*****Par jours combien de personnes ont signé la convention,eli, franchise
       Par mois combien de personnes ont signé la convention, eli et franchise
       Par ans combien de personnes ont signé la convention, eli, franchise,
       Par jours,par ans et par années le nombre total de signataire
      
      */

      $dbtselect = "SELECT count(eu_convention.id_convention) FROM eu_convention"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresulttouslessignatairesdelaconventionpp = $stmt->fetchAll();

      $dbtselect = "SELECT count(eu_franchise.id_franchise) FROM eu_franchise"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultdetouslessignatairesdelafranchise = $stmt->fetchAll();

      $dbtselect = "SELECT count(eu_convention_eli_opi.id_convention_eli) FROM eu_convention_eli_opi"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultdetouslessignatairesdelelipp = $stmt->fetchAll();

      var_dump($dbresulttouslessignatairesdelaconventionpp);
      var_dump($dbresultdetouslessignatairesdelafranchise);
      var_dump($dbresultdetouslessignatairesdelelipp);
    }
}