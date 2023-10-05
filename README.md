# Registration authentication and authorization php project with OOP

# Installation

# STEP 1 In the first you must have installed docker and docker compose on your operation system after insert this command in terminal into project folder
```make build```
### Note: this command create docker image and containers and run it
### Look all commands in Makefile

# STEP 2 Enter in phpmyadmin in address: http://localhost:777 create database with name reg and import data from: App/Resources/db.sql 
### Note: Look conection settings in App/Resources/config.php
```define('DSN', 'mysql:host=mysql;dbname=reg;');```
### Note: Port for connection database manager: 6033 Look at this settings in docker-compose.yml

# STEP 3  Main page address:
```http://localhost:83```

# STEP 4 You should register on site click Login and you will see registration form after registration you recieve confirmation link on mail
```
http://localhost:83/?ctrl=confirm&hash=f01bc9593cdcc5839cbae7d8628a65b0
```
### Note: You can find hash in phpmyadmin in column hash table users copy and insert manually

```http://localhost:83/?ctrl=confirm&hash=```
# STEP 5 Insert above link in browser and confirm


# HELP COMMANDS
```chmod ugo+rwx log.log```

```docker exec -it php-registration bash```
