<?php

namespace Brosland\Chain;

use Brosland\Chain\Notifications\NotificationObject,
	Brosland\Chain\Notifications\NotificationRequest,
	Kdyby\Curl\CurlSender,
	Kdyby\Curl\Request,
	Nette\Utils\Json;

class Account extends \Nette\Object
{
	/**
	 * @var string
	 */
	private $baseUrl;
	/**
	 * @var CurlSender
	 */
	private $sender;


	/**
	 * @param string $id
	 * @param string $secret
	 * @param string $blockChain
	 */
	public function __construct($id, $secret, $blockChain)
	{
		if (!Chain::validateBlockChain($blockChain))
		{
			throw new \Nette\InvalidArgumentException("Unknown block chain {$blockChain}.");
		}

		$this->baseUrl = Chain::URL . '/' . $blockChain;

		$this->sender = new CurlSender();
		$this->sender->headers['Content-Type'] = 'application/json';
		$this->sender->options['HTTPAUTH'] = CURLAUTH_BASIC;
		$this->sender->options['USERPWD'] = $id . ':' . $secret;
		$this->sender->options['CAINFO'] = __DIR__ . '/certificates/cacert.pem';
	}
	//****************************** DATA API ********************************//

	/**
	 * Returns basic balance details for one or more Bitcoin addresses.
	 * 
	 * @link https://chain.com/docs#bitcoin-address
	 * @param string|array $address
	 */
	public function getAddress($address)
	{
		if (is_array($address))
		{
			$address = implode(',', $address);
		}

		$request = new Request($this->baseUrl . '/addresses/' . $address);

		return new Address($this->sendRequest($request));
	}

	/**
	 * Returns details about a Bitcoin transaction, including inputs and outputs.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction
	 * @param string $hash
	 * @return Transaction
	 */
	public function getTransaction($hash)
	{
		$request = new Request($this->baseUrl . '/transactions/' . $hash);

		return new Transaction($this->sendRequest($request));
	}

	/**
	 * Returns a set of transactions for one or more Bitcoin addresses. Pagination is not supported yet.
	 * 
	 * @link https://chain.com/docs#bitcoin-address-transactions
	 * @param string|array $address
	 * @param int $limit The number of transactions to return, starting with most recent (default=50, max=500).
	 * @return Transaction[]
	 */
	public function getTransactionsByAddress($address, $limit = NULL)
	{
		if (is_array($address))
		{
			$address = implode(',', $address);
		}

		$request = new Request($this->baseUrl . '/addresses/' . $address . '/transactions');
		$response = $this->sendRequest($request, ['limit' => $limit]);
		$transactions = [];

		foreach ($response as $transaction)
		{
			$transactions[] = new Transaction($transaction);
		}

		return $transactions;
	}

	/**
	 * Returns network propagation level and double spend information for a given Bitcoin transaction hash.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction-confidence
	 * @param string $hash
	 * @return TransactionConfidence
	 */
	public function getTransactionConfidence($hash)
	{
		$request = new Request($this->baseUrl . '/transactions/' . $hash . '/confidence');

		return new TransactionConfidence($this->sendRequest($request));
	}

	/**
	 * Returns the raw transaction hex data for a given Bitcoin transaction hash.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction-hex
	 * @param string $hash
	 * @return string
	 */
	public function getTransactionHex($hash)
	{
		$request = new Request($this->baseUrl . '/transactions/' . $hash . '/hex');

		return $this->sendRequest($request)['hex'];
	}

	/**
	 * Returns details about a Bitcoin block, including all transaction hashes.
	 * 
	 * @link https://chain.com/docs#bitcoin-block
	 * @param string|int $hashOrHeight
	 * @return Block
	 */
	public function getBlock($hashOrHeight = 'latest')
	{
		$request = new Request($this->baseUrl . '/blocks/' . $hashOrHeight);

		return new Block($this->sendRequest($request));
	}

	/**
	 * Returns a collection of unspent outputs for a Bitcoin address. These outputs
	 * can be used as inputs for a new transaction. For multiple addresses (Max=200)
	 * 
	 * @link https://chain.com/docs#bitcoin-address-unspents
	 * @param string|array $address
	 * @return array
	 */
	public function getUnspentsByAddress($address)
	{
		if (is_array($address))
		{
			$address = implode(',', $address);
		}

		$request = new Request($this->baseUrl . '/addresses/' . $address . '/unspents');
		$response = $this->sendRequest($request);
		$outputs = [];

		foreach ($response as $output)
		{
			$outputs[] = new TransactionOutput($output);
		}

		return $outputs;
	}

	/**
	 * Returns any OP_RETURN values sent and received by a Bitcoin Address.
	 * 
	 * @link https://chain.com/docs#bitcoin-address-op-returns
	 * @param string $address
	 * @return OpReturn[]
	 */
	public function getOpReturnsByAddress($address)
	{
		$request = new Request($this->baseUrl . '/addresses/' . $address . '/op-returns');
		$response = $this->sendRequest($request);
		$opReturns = [];

		foreach ($response as $opReturn)
		{
			$opReturns[] = new OpReturn($opReturn);
		}

		return $opReturns;
	}

	/**
	 * Returns the OP_RETURN value and associated addresses for any transaction
	 * containing an OP_RETURN script.
	 * 
	 * @link https://chain.com/docs#bitcoin-transaction-op-return
	 * @param string $hash
	 * @return OpReturn
	 */
	public function getOpReturnByTransaction($hash)
	{
		$request = new Request($this->baseUrl . '/transactions/' . $hash . '/op-return');

		return new OpReturn($this->sendRequest($request));
	}

	/**
	 * Returns the OP_RETURN value and associated addresses for all transactions
	 * in the block which contain an OP_RETURN output script.
	 * 
	 * @link https://chain.com/docs#bitcoin-block-op-returns
	 * @param string|int $hashOrHeight
	 * @return OpReturn[]
	 */
	public function getOpReturnsByBlock($hashOrHeight)
	{
		$request = new Request($this->baseUrl . '/blocks/' . $hashOrHeight . '/op-returns');
		$response = $this->sendRequest($request);
		$opReturns = [];

		foreach ($response as $opReturn)
		{
			$opReturns[] = new OpReturn($opReturn);
		}

		return $opReturns;
	}
	//**************************** NOTIFICATIONS *****************************//

	/**
	 * Creates a new Notification of a specific type.
	 * 
	 * @param NotificationRequest $notificationRequest
	 * @return NotificationObject
	 */
	public function addNotificationObject(NotificationRequest $notificationRequest)
	{
		$request = new Request(Chain::URL . '/notifications');
		$request->setPost(Json::encode($notificationRequest->getParameters()));

		return NotificationObject::createFromArray($this->sendRequest($request));
	}

	/**
	 * Returns a list of all Notifications associated with a Chain API KEY.
	 * 
	 * @return NotificationObject[]
	 */
	public function getNotificationObjects()
	{
		$response = $this->sendRequest(new Request(Chain::URL . '/notifications'));

		$notificationObjects = [];

		foreach ($response as $notificationObject)
		{
			$notificationObjects[] = NotificationObject::createFromArray($notificationObject);
		}

		return $notificationObjects;
	}

	/**
	 * Deletes a specific Notification.
	 * 
	 * @param string $id
	 */
	public function removeNotificationObject($id)
	{
		$request = new Request(Chain::URL . '/notifications/' . $id);
		$request->setMethod('DELETE');

		return NotificationObject::createFromArray($this->sendRequest($request));
	}
	//************************************************************************//

	/**
	 * @param Request $request
	 * @param string|array $query
	 * @return mixed
	 * @throws ChainException
	 */
	private function sendRequest(Request $request, $query = NULL)
	{
		try
		{
			$response = NULL;

			if (!empty($query))
			{
				$request->setSender($this->sender);
				$response = $request->get($query);
			}
			else
			{
				$response = $this->sender->send($request);
			}

			return Json::decode($response->getResponse(), Json::FORCE_ARRAY);
		}
		catch (\Kdyby\Curl\CurlException $ex)
		{
			$response = Json::decode($ex->getResponse()->getResponse());

			throw new ChainException($response->message, $ex->getCode());
		}
	}
}