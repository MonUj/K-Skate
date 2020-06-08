# K-Skate

Installation pour avoir accès au site :

1)Clonez le dépot chez vous.
2)Modifiez le .env avec vos informations ou avec une bdd sqlite : ligne DATABASE_URL : sqlite:///%kernek.project_dir%/var/data.db
                                         ou avec vos paramètres de votre base de données.
3)Executez la base de données : php bin/console doctrine:schema:update --force
4)Executez les données : php bin/console doctrine:fixtures:load --no-interaction
5)Lancez le serveur interne : php bin/console server:run

Vous pouvez à présent testez mon site !

6)Pour afficher les images des produits : /templates/home.html.twig -> remplacez ligne 86 : src="{{ asset('images/products/' ~ product.filename)}}" par src="{{ product.filename }}"

nb: Si vous voulez ajouter votre avatar ou un produit, des images se trouvent dans le dossier : public/assets/images/avatars ou products.
