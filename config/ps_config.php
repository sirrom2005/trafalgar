<?php
$db = new PDO("pgsql:dbname=ttms;host=192.168.0.8", 'postgres', 'tRafalger1');

function generatePassword(){
    return 'pass1234';
}