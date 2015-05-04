<?php

namespace Brosland\Chain;

use Nette\DI\Container;

class Chain extends \Nette\Object
{
	const BLOCK_CHAIN_BITCOIN = 'bitcoin',
		BLOCK_CHAIN_TESTNET3 = 'testnet3';


	/**
	 * @var Container
	 */
	private $serviceLocator;
	/**
	 * @var array
	 */
	private $serviceMap = [];


	/**
	 * @param string $name
	 */
	public function getAccount($name)
	{
		if (!isset($this->serviceMap['accounts'][$name]))
		{
			throw new \Nette\InvalidArgumentException("Unknown account {$name}.");
		}
	}

	/**
	 * @internal
	 */
	public function injectServiceMap(array $accounts)
	{
		$this->serviceMap = array ('accounts' => $accounts);
	}

	/**
	 * @internal
	 * @param Container $serviceLocator
	 */
	public function injectServiceLocator(Container $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}

	/**
	 * @param string $blockChain
	 * @return bool
	 */
	public static function validateBlockChain($blockChain)
	{
		return $blockChain == self::BLOCK_CHAIN_BITCOIN ||
			$blockChain == self::BLOCK_CHAIN_TESTNET3;
	}
}