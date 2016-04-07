<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
	'driver'   => 'pdo_sqlsrv',
	'dbname'   => 'DATABASE_NAME',
	'host'     => '127.0.0.1',
	'user'     => 'DATABASE_USER',
	'password' => 'DATABASE_PASS',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
