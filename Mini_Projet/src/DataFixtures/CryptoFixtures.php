<?php

namespace App\DataFixtures;

use App\Entity\Crypto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CryptoFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        ini_set('memory_limit', -1);
        $ch2 = curl_init();
        try {
            curl_setopt($ch2, CURLOPT_URL, "https://api.coingecko.com/api/v3/coins/categories/list");
            curl_setopt($ch2, CURLOPT_HEADER, false);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
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

        $json2 = json_decode($response2, 1);

        foreach ($json2 as $j2) {
            $cat = ($j2["category_id"]);
            $i = 1;


            if(!str_contains($cat, "layer")){
                if(!str_contains($cat, "us-election-2020")) {
                    $stop = false;
                    while (!$stop){

                    $ch = curl_init();
                    try {
                        //curl_setopt($ch, CURLOPT_URL, "https://api.coingecko.com/api/v3/coins/markets?vs_currency=eur&order=market_cap_desc&per_page=100&page=1&sparkline=false%22");
                        curl_setopt($ch, CURLOPT_URL,"https://api.coingecko.com/api/v3/coins/markets?vs_currency=eur&category=".$cat."&order=market_cap_desc&per_page=50&page=".$i."sparkline=false");
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            die();
                        }

                        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        echo curl_error($ch);
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

                    $json = json_decode($response, 1);

                    if($json !== null) {
                        foreach ($json as $j) {

                                $crypto = new Crypto();
                                $crypto->setSymbole($j["symbol"]);
                                $crypto->setNom($j["name"]);
                                $crypto->SetImage($j["image"]);
                                if ($j["current_price"] == null) {
                                    $crypto->setPrix(0);
                                } else {
                                    $crypto->setPrix($j["current_price"]);
                                }
                                $crypto->setDescription("");
                                $crypto->setCategorie($cat);
                                if ($j["market_cap"] == null) {
                                    $crypto->setMarketcup(0);
                                } else {
                                    $crypto->setMarketcup($j["market_cap"]);
                                }
                                $crypto->setNbFollowers(0);

                                $manager->persist($crypto);
                            }

                            if (sizeof($json) < 50) {
                                $stop = true;
                            }
                            sleep(1);
                            $i++;
                        }
                    }
                    }

                }
                }

        $manager->flush();


    }

}