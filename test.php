<?php
require_once 'Autoloader.php';

$service = new BankBusinessService();

echo "Initial Checking balance is " . $service->getCheckingBalance() . "<br>";
echo "Initial Saving balance is " . $service->getSavingBalance() . "<br>";

$service->transaction();

echo "New Checking balance is " . $service->getCheckingBalance() . "<br>";
echo "New Saving balance is " . $service->getSavingBalance() . "<br>";

?>