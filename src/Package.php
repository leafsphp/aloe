<?php

namespace Aloe;

/**
 * Package
 * ----
 * Meta info on aloe cli
 * 
 * @since 1.2.4
 */
class Package
{
	/**
	 * Check current version
	 */
	public static function info()
	{
		return json_decode(file_get_contents(
			dirname(__DIR__) . '/composer.json'
		));
	}

	/**
	 * Check current version
	 */
	public static function version()
	{
		$meta = static::info();

		return $meta->version;
	}

	/**
	 * Find latest stable version
	 */
	public static function ltsInfo()
	{
		$package = json_decode(
			file_get_contents('https://repo.packagist.org/p2/leafs/aloe.json')
		);

		return $package->packages->{'leafs/aloe'}[0];
	}

	/**
	 * Find latest stable version
	 */
	public static function ltsVersion()
	{
		$package = static::ltsInfo();

		return $package->version;
	}

	/**
	 * Check if there is an update available
	 */
	public static function findUpdates()
	{
		$currentVersion = static::version();
		$latestVersion = static::ltsVersion();

		if ($currentVersion !== $latestVersion) {
			echo "Aloe CLI update available ($latestVersion). Run `leaf install aloe` or `composer require leafs/aloe` to update.\n\n";
		}
	}
}
