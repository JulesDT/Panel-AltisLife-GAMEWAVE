Panel-AltisLife-GAMEWAVE
========================

Panel de gestion des utilisateurs, des dons et de la quasi totalité des fonctions d'un serveur Altis Life (Arma3)

Réutilisation autorisée par tous, sous condition de citer la source (BloodMotion) ainsi que le lien du Github :-)

Installation :
========================
C'est asssez simple (n'hésitez pas à me contacter par mail / GitHub). Il vous suffit dé télécharger la dernière version du Git, de l'uploader dans votre FTP (local sur la machine hébergeant le serveur Arma, si vous n'avez pas défini de connnexion distante SQL dans la configuration MySQL).

Par la suite, vous devez récupérer la base de donnée "users.sql" (à la racine du Git) et l'importer dans votre base de donnée "arma3life". Avec PHPmyAdmin ou Navicat (par exemple), vous n'avez qu'à créer une nouvelle table "users" dans la base de donnée "arma3life" et importer le fichier fourni ici même :)

Pour configurer les accès BDD (serveur, utilisateur, password) : vous devez éditer le fichier "bdd.php" en remplacant les champs par vos identifiants de connexion base de donnée respectifs.

Vous devriez avoir à peu près ça dans votre table "users" à la fin ! :
![ScreenShot](http://my-url.fr/screen/060914143458.png)

Première connexion :
========================
Si tout fonctionne bien, vous devriez pouvoir vous connecter au panel, les identifiants par défaut son :
  - URL: celle de votre serveur (ex : http://admin.altislife.fr/à)
  - ID : admin
  - MDP: admin

Pensez à les changer en base de donnée ;) (encryption SHA1)

C'est fini ! Pour le reste, allez bidouiller dans les fichiers, n'ayez pas peur, c'est du procédural (pas d'objet ni de classe), pas forcément le plus "propre" mais testé et approuvé par de gros serveurs (Fantasma, AltisLifefr.com, Renaissance, GAMEWAVE (Altislife.fr) etc ...)

Côté technique :
========================
  - Regex (JS / PHP)
  - Requetes préparés
  - Vérification des GET
  - htaccess
  - Session
  - Niveau d'administration (viisiteur, modérateur, admin)

Captures d'écran
========================

connexion
![ScreenShot](http://my-url.fr/screen/300614183612.png)

accueil
![ScreenShot](http://my-url.fr/screen/300614183705.png)

recherche par pseudo / ID
![ScreenShot](http://my-url.fr/screen/300614184152.png)

profil
![ScreenShot](http://my-url.fr/screen/300614183903.png)

RconPHP (infos serveur)
![ScreenShot](http://my-url.fr/screen/250714174830.png)

Utilisateurs du panel
![ScreenShot](http://my-url.fr/screen/090714233308.png)
