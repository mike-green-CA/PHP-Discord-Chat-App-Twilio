@extends('layout')
@section('content')
<div class="content">
<head>
    <script>
        // quick javascript to act as a client to our web socket server
        // to state the obvious, this has nothing to do with PHP; this is javascript
        var conn = new WebSocket('ws://localhost:9000');
        var meObj = {};
        // some basic call back functions when certain events happen on the web socket server

        // when we successfully connect, log a simple message
        conn.onopen = function (e) {
            fetch('http://localhost:8080/me')
            .then(response => response.json())
            .then(data => {
                meObj = data;
                console.log(meObj);
                console.log(meObj.me.name + " has entered the chat!");
            })
        };

        // when we receive a message, log that message
        conn.onmessage = function (e) {
            console.log(meObj.me.name + "> " + e.data);
        };

        conn.onclose = function (e) {
            console.log("Disconnected!");
        };

        // when the send button is pressed, sendMessage is called
        sendMessage = function (e) {
            // grab the current value in the input field
            var value = document.getElementById("text").value;
            console.log(value); // log that value

            // var payload =   json([
            //                     payload : [
            //                         'action'    : "message",
            //                         'message'   : value,
            //                         'token'     : base64_encode(meObj),
            //                     ]      
            //                 ]);
            
            // conn.send(payload);   // send that value to our web socket connect

            conn.send(value);   // send that value to our web socket connect
        }

    </script>
</head>

<body>
<input id="text" type="text"/>
<button onclick="sendMessage();">send!</button>
</body>
</div>
@stop
