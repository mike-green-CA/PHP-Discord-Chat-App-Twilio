<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Class Chtr
 *
 * A basic class that represents things that happen in a socket connection.
 *
 * This can be used to model a basic dumb terminal socket or a web socket.
 *
 * Make note of the MessageComponentInterface it implements
 */
class Chtr implements MessageComponentInterface
{
    // keep track of all connections
    private $users = [];

    /**
     * When a client connects, this method is called.
     *
     * Simply keep track of it in our array of clients and print some debug information.
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        echo 'New user has joined the chat! ' . $conn->resourceId . PHP_EOL;
        $this->users[$conn->resourceId] = $conn;
    }

    /**
     * Called when a client disconnects.
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        echo 'User has left the chat! ' . $conn->resourceId . PHP_EOL;
        // remove the user from our array so we don't keep sending them messages.
        $this->users[$conn->resourceId] = null;
    }

    /**
     * When a client sends a message, this method is called and provides who the send is, and what the message is.
     *
     * @param ConnectionInterface $from The sender connection.
     * @param string $msg The message.
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        // for debugging
        echo $msg   .  PHP_EOL;  
                           

        // loop through all users we have kept track of
        foreach($this->users as $key => $user)
        {
            // for each user send them the message
            // this includes the original sender! perhaps add an if check?
            $user->send($msg);
        }
    }

    /**
     * Some times errors happen. Just log it.
     *
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        error_log($e->getMessage());
        $conn->close();
    }
}
