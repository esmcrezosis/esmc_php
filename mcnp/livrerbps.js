/* On crée l'instance de l'objet XMLHTTPRequest */

var mon_objet = new Object;

/* Si c'est Mozilla/Firefox/Nescape/opera/safari */

if(window.XMLHttpRequest) 

   mon_objet = new XMLHttpRequest();  

/* Si c'est Internet Explorer */

else if(window.ActiveXObject) 

  mon_objet = new ActiveXObject("Microsoft.XMLHTTP");

/* Si aucun navigateur compatible avec XMLHttpRequest, on le signale */

else
  { 
     alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 	 
  }


/* Fonction à exécuter quand on clique sur le lien AM */
function ouvre_livrer(act,nivo) {
/* on spécifie la méthode,l'URL et le type de transmission */
mon_objet.open("POST","/livrerbps.php",true); 
 
/* On spécifie la fonction à exécuter */
mon_objet.onreadystatechange = function() {
  /* si on a reçu la réponse */
  if(mon_objet.readyState == 4) {  
		    /* on reçoit les données et on les affiche*/
			contenu = mon_objet.responseText;
			document.getElementById(nivo).innerHTML = contenu;
  }
}

mon_objet.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
var_transmettre = "act="+act;
mon_objet.send(var_transmettre);  

}