<?php

// load all the required libraries for a socket server
// because composer doesn't know about our class, we have to manually require it
// a better solution is to have composer load it. If you're interested, look up PSR-4 autoloading
require 'vendor/autoload.php';
require 'Chtr.php';

// recall the long-poll example we still had to use an HTTP server to serve the script
// then call it directly and the long-poll mechanism will infinitely wait for input or send output
// this IoServer acts as an infinite loop that'll do that for us
// it'll also listen for a port, bind to an IP, and takes a MessageComponentInterface object
// whenever something happens on the server, it'll call the appropriate methods defined by MessageComponentInterface
use Ratchet\Server\IoServer;

// a quick factory pattern here pumps our a server for us to work with
// if you've forgotten, :: is the static access operator and gives us access to static methods
// static factory method means we don't have to instantiate an IoServer in order create a server
$server = IoServer::factory(new Chtr(), 8080);
$server->run(); // run our infinite loop
