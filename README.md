1) Git clone
2) composer install
3) php bin/console doctrine:database:create
4) chmod 777 -R var
5) php bin/console doctrine:fixtures:load
6) Open web:
    http://localhost:83/symfony_34_petkobase/web/app_dev.php/login

7) Si da error: 
    You are not allowed to access this file. Check app_dev.php for more information.172.20.0.1
    
    7)a) Editar web/app_dev.php e incluir la ip que imprime el mensaje: "172.20.0.1"
    

Login: admin@app.com
pass: test123    