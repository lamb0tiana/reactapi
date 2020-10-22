<?php

namespace App\DataFixtures;

use App\Entity\Announce;
use App\Entity\Pictures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class AnnounceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($a = 0 ; $a < 500 ; $a++){
            $title = $faker->title;
            $descr = $faker->text;
            $announce = (new Announce())->setTitle($title)->setDescription($descr);
            for($p = 0 ; $p < 5; $p++)
            {
                $i = rand(0,1084);
                $path = "https://picsum.photos/500/500?image=$i";
                $picture = (new Pictures())->setPath($path);
                $announce->addPicture($picture);
            }
            $manager->persist($announce);
        }
        $manager->flush();
    }
}
