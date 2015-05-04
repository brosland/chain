<?php

namespace Brosland\Chain\DI;

class ChainExtension extends \Nette\DI\CompilerExtension
{
	


	/**
	 * @var array
	 */
	private static $DEFAULTS = [
		'account' => [],
		'notificationRoute' => 'chain-notification'
	];
	/**
	 * @var array
	 */
	private static $ACCOUNT_DEFAULTS = [
		'id' => NULL,
		'secret' => NULL,
		'blockChain' => self::BLOCK_CHAIN_BITCOIN
	];


	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();
		$config = $this->getConfig(self::$DEFAULTS);

		$accounts = $this->loadAccounts($config['account']);

		$builder->addDefinition($this->prefix('chain'))
			->setClass(\Brosland\Chain\Chain::class)
			->addSetup('injectServiceLocator')
			->addSetup('injectServiceMap', array ($accounts));

		$router = $builder->addDefinition($this->prefix('router'))
			->setClass(\Brosland\Chain\Routers\NotificationRouter::class)
			->setArguments(array ($config['notificationRoute']))
			->setAutowired(FALSE);

		if ($builder->hasDefinition('router'))
		{
			$builder->getDefinition('router')
				->addSetup('offsetSet', array (NULL, $router));
		}
	}

	/**
	 * @param array $definitions
	 * @return array
	 */
	private function loadAccounts($definitions)
	{
		if (isset($definitions['id']))
		{
			$definitions = array ('default' => $definitions);
		}

		$builder = $this->getContainerBuilder();
		$accounts = array ();

		foreach ($definitions as $name => $account)
		{
			$account = $this->mergeConfig($account, self::$ACCOUNT_DEFAULTS);
			$serviceName = $this->prefix('account.' . $name);

			$service = $builder->addDefinition($serviceName)
				->setClass(\Brosland\Chain\Account::class)
				->setArguments(array (
				$account['id'],
				$account['secret']
			));

			if (!empty($accounts))
			{
				$service->setAutowired(FALSE);
			}

			$accounts[$name] = $serviceName;
		}

		return $accounts;
	}

	/**
	 * @param array $config
	 * @param array $defaults
	 * @return array
	 */
	private function mergeConfig($config, $defaults)
	{
		return \Nette\DI\Config\Helpers::merge(
				$config, $this->compiler->getContainerBuilder()->expand($defaults));
	}
}