Panel Altis Life - GAMEWAVE
========================

Panel de gestion des utilisateurs, des dons et de la quasi totalité des fonctions d'un serveur Altis Life (Arma3)

Réutilisation autorisée par tous, sous condition de citer la source (BloodMotion) ainsi que le lien du Github :-)

<b>Demo (online guest access)</b> : http://admin.altislife.fr/login
<br>
<b>ID</b> : user
<br>
<b>MDP</b> : userpass
<br>

Installation :
========================

<b>Prérequis :</b>
<ul>
 <li>Activer le <b style="color:#D5001D;">mod rewrite</b> sur apache !</li>
 <li>Autoriser (par défaut normalement) l'<b style="color:#D5001D;">open short tag</b> pour PHP</li>
</ul>

<b style="color:D5001D;">La structure de la BDD est légèrement changée (deux colonnes en plus) afin de traiter les donateurs automatiquements :</b>

```sql
-- Exécuter ces deux requêtes dans la table "players"
ALTER TABLE `players` ADD `duredon` integer(1) default 0 NOT NULL;
ALTER TABLE `players` ADD `timestamp` integer(11) NULL;
```

C'est assez simple (n'hésitez pas à me contacter par mail / GitHub). Il vous suffit dé télécharger la dernière version du Git, de l'uploader dans votre FTP (local sur la machine hébergeant le serveur Arma, si vous n'avez pas défini de connexion distante SQL dans la configuration MySQL).

Par la suite, vous devez récupérer la base de donnée "users.sql" (à la racine du Git) et l'importer dans votre base de donnée "arma3life". Avec PHPmyAdmin ou Navicat (par exemple), vous n'avez qu'à créer une nouvelle table "users" dans la base de donnée "arma3life" et importer le fichier fourni ici même :)

Pour configurer les accès BDD (serveur, utilisateur, password) : vous devez éditer le fichier "bdd.php" en remplacant les champs par vos identifiants de connexion base de donnée respectifs :

```php
$ip = "localhost";
$bdd = "arma3life";
$user = "nom_utilisateur";
$passwd = "mot_de_passe";
try{
    $DB = new PDO('mysql:host='.$ip.';dbname='.$bdd, $user, $passwd);
}
```

Vous devriez avoir à peu près ça dans votre table "users" à la fin ! :
![ScreenShot](http://tuk.fr/s/060914143458.png)

Première connexion :
========================
Si tout fonctionne bien, vous devriez pouvoir vous connecter au panel, les identifiants par défaut son :
  - URL: celle de votre serveur (ex : http://admin.altislife.fr/)
  - ID : admin
  - MDP: admin

Pensez à les changer en base de donnée ;) (encryption SHA1)

C'est fini ! Pour le reste, allez bidouiller dans les fichiers, n'ayez pas peur, c'est du procédural (pas d'objet ni de classe), pas forcément le plus "propre" mais testé et approuvé par de gros serveurs (Fantasma, AltisLifefr.com, Renaissance, GAMEWAVE (Altislife.fr) etc ...)

Côté technique :
========================
  - Regex (JS / PHP)
  - Requêtes préparées
  - Vérification des GET
  - htaccess
  - Sessions
  - Boostrap v3
  - Niveau d'administration (visiteur [1], modérateur [2], admin[3])

Captures d'écran
========================

connexion
![ScreenShot](http://tuk.fr/s/300614183612.png)

accueil
![ScreenShot](http://tuk.fr/s/300614183705.png)

recherche par pseudo / ID
![ScreenShot](http://tuk.fr/s/300614184152.png)

profil
![ScreenShot](http://tuk.fr/s/300614183903.png)

RconPHP (infos serveur)
![ScreenShot](http://tuk.fr/s/250714174830.png)

Utilisateurs du panel
![ScreenShot](http://tuk.fr/s/090714233308.png)
