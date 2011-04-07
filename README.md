README
======

What is Prospect?
-----------------

Prospect is a PHP 5.3 HTTP library for making .

Requirements
------------

PHP 5.3.x

Usage
-----

Performing a simple get request
<?php

  include 'src/Versionable/Prospect/Request/Request.php';
  include 'src/Versionable/Prospect/Url/Url.php';
  include 'src/Versionable/Prospect/Adapter/Curl.php';
  include 'src/Versionable/Prospect/Client/Client.php';
  include 'src/Versionable/Prospect/Response/Response.php';

  use \Versionable\Prospect\Request\Request;
  use \Versionable\Prospect\Url\Url;
  use \Versionable\Prospect\Adapter\Curl;
  use \Versionable\Prospect\Client\Client;
  use \Versionable\Prospect\Response\Response;
  
  $request = new Request(new Url('http://versionable.co.uk/'));
  $client = new Client(new Curl());
  
  $response = $client>send($request, new Response());

?>