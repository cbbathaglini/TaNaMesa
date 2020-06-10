<?php

require __DIR__ . '/../../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/../../utils/ta-na-mesa-mobile-b7e69bf0ea6e.json');
$firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://ta-na-mesa-mobile.firebaseio.com/')->createDatabase();
