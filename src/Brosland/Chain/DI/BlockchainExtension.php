<?php

namespace Brosland\Blockchain\DI;

class BlockchainExtension extends \Nette\DI\CompilerExtension
{
	/**
	 * @var array
	 */
	private static $DEFAULTS = [
		'account' => [
			'id' => NULL,
			'secret' => NULL
		],
		'notificationRoute' => 'chain-notification'
	];


	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();
		$config = $this->getConfig(self::$DEFAULTS);

		$chain = $builder->addDefinition($this->prefix('chain'))
			->setClass(\Brosland\Chain\Chain::class);

		foreach ($this->loadWallets($config['account']) as $name => $account)
		{
			$chain->addSetup('addAccount', array ($name, $account));
		}

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
	 * @return \Nette\DI\ServiceDefinition[]
	 */
	private function loadWallets($definitions)
	{
		if (isset($definitions['id']))
		{
			$definitions = array ('default' => $definitions);
		}

		$builder = $this->getContainerBuilder();
		$services = array ();

		foreach ($definitions as $name => $account)
		{
			$serviceName = $this->prefix('account.' . $name);

			$service = $builder->addDefinition($serviceName)
				->setClass(\Brosland\Chain\Account::class)
				->setArguments(array (
					$account['id'],
					$account['secret']
				));

			if (!empty($services))
			{
				$service->setAutowired(FALSE);
			}

			$services[$name] = $service;
		}

		return $services;
	}
}