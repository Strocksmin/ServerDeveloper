<?php

require_once 'vendor/autoload.php';


class FixtureCreator
{
    function getUsers($quantity = 1)
    {
        $faker = Faker\Factory::create();
        if ($quantity <= 0) {
            return;
        }

        $data = array();
        for ($i = 0; $i < $quantity; $i++) {
            $gender = rand(0, 1) == 0 ? 'male' : 'female';
            $browsers = array("Chrome", "Firefox", "Opera", "Internet Explorer", "Safari", "Microsoft Edge");
            array_push($data, array(
                "firstName" => $faker->firstName($gender),
                "lastName" => $faker->lastName($gender),
                "gender" => $gender,
                "age" => strval(rand(10, 80)),
                "username" => $faker->userName,
                "country" => $faker->country,
                "job" => $faker->jobTitle,
                "browser" => $browsers[rand(0, count($browsers) - 1)]
            ));
        }

        return $data;
    }
}
