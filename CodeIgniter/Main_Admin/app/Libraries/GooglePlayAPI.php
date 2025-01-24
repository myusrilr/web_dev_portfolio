<?php

namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

use Google_Client;
use Google\Service\AndroidPublisher;
use Google\Service\AndroidPublisher\AppEdit;

class GooglePlayAPI {
    
    protected $client;
    protected $service;

    public function __construct() {
        $this->client = new Google_Client();
        $this->client->setApplicationName('LeapApps');
        $this->client->setScopes([AndroidPublisher::ANDROIDPUBLISHER]);
        $this->client->setAuthConfig(APPPATH . 'Config/client_secret.json');
        $this->client->setAccessType('offline');

        $this->service = new AndroidPublisher($this->client);
    }

    public function getAppDetails($packageName) {
        try {
            $appEdit = $this->service->edits->insert($packageName, new AppEdit());
            return $appEdit;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
