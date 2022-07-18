<?php 
require 'libs/rb.php';
R::setup( 'mysql:host=localhost;dbname=c291470u_double', 'c291470u_double', 'FhHhbqi8' ); 

if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}

session_start();