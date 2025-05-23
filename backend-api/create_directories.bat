@echo off
REM Create directory structure for the PHP admin dashboard

REM Main folders
mkdir backend-api
mkdir backend-api\classes
mkdir backend-api\config
mkdir backend-api\public
mkdir backend-api\public\assets
mkdir backend-api\public\pages

REM Create empty files if they don't exist
IF NOT EXIST backend-api\classes\db_conn.php type nul > backend-api\classes\db_conn.php
IF NOT EXIST backend-api\classes\crud.php type nul > backend-api\classes\crud.php
IF NOT EXIST backend-api\config\db_conn.php type nul > backend-api\config\db_conn.php
IF NOT EXIST backend-api\public\index.php type nul > backend-api\public\index.php
IF NOT EXIST backend-api\public\login.php type nul > backend-api\public\login.php
IF NOT EXIST backend-api\public\logout.php type nul > backend-api\public\logout.php
IF NOT EXIST backend-api\public\assets\style.css type nul > backend-api\public\assets\style.css
IF NOT EXIST backend-api\public\layout.php type nul > backend-api\public\layout.php
IF NOT EXIST backend-api\public\footer.php type nul > backend-api\public\footer.php

REM Example pages for tables
IF NOT EXIST backend-api\public\pages\users.php type nul > backend-api\public\pages\users.php
IF NOT EXIST backend-api\public\pages\franchises.php type nul > backend-api\public\pages\franchises.php
IF NOT EXIST backend-api\public\pages\restaurants.php type nul > backend-api\public\pages\restaurants.php
IF NOT EXIST backend-api\public\pages\employees.php type nul > backend-api\public\pages\employees.php
IF NOT EXIST backend-api\public\pages\menu_categories.php type nul > backend-api\public\pages\menu_categories.php
IF NOT EXIST backend-api\public\pages\menu_items.php type nul > backend-api\public\pages\menu_items.php
IF NOT EXIST backend-api\public\pages\condiments.php type nul > backend-api\public\pages\condiments.php
IF NOT EXIST backend-api\public\pages\upgrades.php type nul > backend-api\public\pages\upgrades.php
IF NOT EXIST backend-api\public\pages\orders.php type nul > backend-api\public\pages\orders.php

echo Directory structure created.
pause