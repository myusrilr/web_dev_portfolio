<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Google\Client;
use Google\Service\AndroidPublisher;
use Google\Service\AndroidPublisher\AppEdit;
use Google\Service\Exception;
use App\Libraries\GooglePlayAPI;

class Downloadreport extends BaseController
{

    private $model;
    private $modul;
    protected $googlePlayAPI;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
        $this->googlePlayAPI = new GooglePlayAPI();
    }

    public function index(){
        $packageName = 'com.leap.leapverse'; // Ganti dengan package name aplikasi Anda
        $appDetails = $this->googlePlayAPI->getAppDetails($packageName);

        if (is_string($appDetails) && strpos($appDetails, 'Error') !== false) {
            echo $appDetails;
        } else {
            echo 'App details retrieved successfully:';
            print_r($appDetails);
        }
    }

    public function index2(){
        // $apiKey = 'AIzaSyB5IVPB82bcUmKMz2GmS4Pcx0SxG3tx55c';
        // $packageName = 'com.leap.leapverse';

        $keyFilePath  = './gapijson/credentials.json';
        

        $client = new Client();
        $client->setApplicationName('LeapApps');
        $client->setScopes(['https://www.googleapis.com/auth/androidpublisher']);
        $client->setAuthConfig($keyFilePath);
        $client->setAccessType('offline');
        

        // Inisialisasi Android Publisher Service
        $service = new AndroidPublisher($client);

        try {
            $packageName = 'com.leap.leapverse'; // Ganti dengan package name aplikasi Anda

            $appDetails = $service->edits->insert($packageName, new AppEdit());
            echo 'App details retrieved successfully';
            print_r($appDetails);

            // $response = $service->stats->get(
            //     $packageName, 'installs', ['startTime' => '2024-01-01T00:00:00Z']
            // );

            // // Mengambil jumlah unduhan dari response
            // $downloads = $response->getInstalls()->getInstalls();

            // echo "Jumlah unduhan: " . $downloads;
        } catch (Exception $e) {
            // Tangani error
            echo 'Ada kesalahan saat memanggil API: ' . $e->getMessage();
            // Debugging tambahan jika diperlukan
            // echo '<pre>'; print_r($e); echo '</pre>';
        }
        
    }
}