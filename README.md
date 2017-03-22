dashboard
=========

Instruccions d'instal·lació de l'entorn de desenvolupament

  Clonar el projecte:

    git clone https://github.com/chefchef/dashboard.git

  Clonar el projecte extern de vagrant, dintre de la carpeta creada anteriorment (per exemple dashboard/vagrant)

    git clone https://github.com/kleiram/vagrant-symfony.git vagrant

  Més informació a : https://github.com/kleiram/vagrant-symfony

  Dintre de la carpeta vagrant fer un 

    vagrant up

  Al projecte li falten les dependències cal fer :

    php composer.phar install
    npm install
    bower install
    app/scripts/build.sh

  Si falten algun element com php es poden instal·lar amb gestor de paquets com apt-get o brew.

  Per últim falta configurar la base de dades. Cal fer el següent :

  Entrar a la màquina vagrant amb 

    vagrant ssh
    mysql -u root -p
(Cap password)

    CREATE DATABASE projecte;
    USE projecte;
Volcar les dades del fitxer de /var/www/info/sql

La URL de l'entorn de desenvolupament es : http://192.168.33.10/

