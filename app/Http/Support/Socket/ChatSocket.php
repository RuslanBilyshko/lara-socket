<?php namespace App\Http\Support\Socket;


use App\Http\Support\Socket\Base\BaseSocket;
use Ratchet\ConnectionInterface;


class ChatSocket extends BaseSocket
{
	protected $clients;

	public function __construct()
	{
		$this->clients = new \SplObjectStorage();
	}


	function onOpen(ConnectionInterface $conn)
	{
		// Storage the new connection to send message to later
		$this->clients->attach($conn);
	}

	function onMessage(ConnectionInterface $from, $msg)
	{
		$numRecv = count($this->clients) - 1;
		echo sprintf('Connection %d sending message "%s" to %d other connection%s'."\n",
			$from->resourceId,$msg,$numRecv,$numRecv == 1 ? '' : 's');


		foreach ($this->clients as $client) {
			if($from !== $client) {
				$client->send($msg);
			}
		}
	}

	function onClose(ConnectionInterface $conn)
	{
		$this->clients->detach($conn);
		echo "Connection {$conn->resourceId} has disconnected\n";
	}


	function onError(ConnectionInterface $conn, \Exception $e)
	{
		echo "An error has occurred {$e->getMessage()}\n";
		$conn->close();
	}



}