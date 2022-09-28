<?php

ini_set('max_execution_time', 0);   // this tells php to keep running forever; this allows for an infinite loop
ini_set('implicit_flush', 1);       // this tells php to let us control flushing of the buffers

echo 'hello';

// flush the output buffers before the script stops executing
// remember in long polling, we want to try to keep the script running forever
// so whenever there is something to send to the client, don't buffer it til the end - send it right away in real time
ob_flush();
flush();

sleep(15);

// push another message to the client
echo ' from the other side';

// we should probably flush here because if we're in an infinite loop, we won't get that message until the script dies
// but since this example isn't infinite loop, the echo gets flushed because the script is done right after the echo.
