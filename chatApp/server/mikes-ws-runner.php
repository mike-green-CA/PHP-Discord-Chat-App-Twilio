<?php

// be sure to read the comments in runner.php first

require 'vendor/autoload.php';
require 'Chtr.php';

// a simple IO server allows dumb connections to happen, recall telnet example
// in the runner.php example, whatever we typed in was just relayed it to Chtr, which just simply messaged everyone
use Ratchet\Server\IoServer;

// an HTTP server will allow the dumb connections to understand HTTP, recall telnet example
// typing in just anything to an HTTP server will likely just close the connection
// typing in HTTP requests, such as a GET request, the HTTP server knew how to understand and process it
use Ratchet\Http\HttpServer;

// a WebSocket server rides on top of HTTP. essentially clients "type in" an Upgrade: header
// this tells both client and server to stop talking HTTP and start talking WS
// more importantly, client and server knows to not close the connection
use Ratchet\WebSocket\WsServer;

// stack them all together!
$chtr = new Chtr();
$myWsServer = new WsServer($chtr);
$httpServer = new HttpServer($myWsServer);

// now throw all that into our factory and out comes a server which
// - listens on port 9000
// - opens a socket for any connection  (IoServer)
// - understands http                   (HttpServer)
// - understands ws on top of http      (WsServer)
IoServer::factory($httpServer, 9000)->run();
