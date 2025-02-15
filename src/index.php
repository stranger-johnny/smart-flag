<?php

require_once __DIR__ . '/vendor/autoload.php';

use Model\Flags;
use OpenFeature\implementation\flags\Attributes;
use OpenFeature\implementation\flags\EvaluationContext;
use OpenFeature\OpenFeatureAPI;
use Provider\SmartProvider;

$yamlString = file_get_contents("smart-flag.yaml");
$flags = Flags::fromYaml($yamlString);

$api = OpenFeatureAPI::getInstance();
    
// configure a provider
$api->setProvider(new SmartProvider($flags));

// create a client
$client = $api->getClient('smart-flag-client', '1.0');

// get a bool flag value
var_dump($client->getBooleanValue("hello-world", false, new EvaluationContext(
    "development",
    new Attributes(['lang' => 'ja']),
)));
var_dump($client->getBooleanValue("hello-world", false, new EvaluationContext(
    "development",
    new Attributes(['lang' => 'en']),
)));
