<?php

namespace App\DataFixtures;

use App\Entity\Crypto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CryptoFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $ch = curl_init();
        try {
            curl_setopt($ch, CURLOPT_URL, "https://api.coingecko.com/api/v3/coins/markets?vs_currency=eur&order=market_cap_desc&per_page=100&page=1&sparkline=false%22");
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo curl_error($ch);
                die();
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == intval(200)) {
                //echo $response;
            } else {
                echo "Ressource introuvable : " . $http_code;
            }
        } catch (\Throwable $th) {
            throw $th;
        } finally {
            curl_close($ch);
        }

        $ch2 = curl_init();
        try {
            curl_setopt($ch2, CURLOPT_URL, "https://api.coingecko.com/api/v3/coins/categories/list");
            curl_setopt($ch2, CURLOPT_HEADER, false);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch2, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch2, CURLOPT_MAXREDIRS, 1);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

            $response2 = curl_exec($ch2);

            if (curl_errno($ch2)) {
                echo curl_error($ch2);
                die();
            }

            $http_code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
            if ($http_code2 == intval(200)) {
                //echo $response;
            } else {
                echo "Ressource introuvable : " . $http_code2;
            }
        } catch (\Throwable $th2) {
            throw $th2;
        } finally {
            curl_close($ch2);
        }

        $json = json_decode($response, 1);
        $json2 = json_decode($response2, 1);

        foreach ($json as $j){

            $crypto = new Crypto();
            $crypto->setNom($j["name"]);
            $crypto->setSymbole($j["symbol"]);
           $crypto->SetImage($j["image"]);
            $crypto->setPrix($j["current_price"]);
            $crypto->setDescription("");
            $crypto->setMarketcup($j["market_cap"]);
            $crypto->setNbFollowers(0);

            $manager->persist($crypto);
        }

        foreach ($json2 as $j2){
            $crypto->setCategorie($j2["name"]);
            $manager->persist($crypto);
        }

        $manager->flush();

    }

}