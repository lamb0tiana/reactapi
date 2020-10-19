<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ottaviano\Faker\Gravatar;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new Gravatar($faker));
        $avatarCat = ['identicon', 'mp','monsterid', 'wavatar', 'retro', 'robohash'];
        for($i=0; $i < 20; $i++)
        {
            $user = (new User())
                        ->setPassword(User::DEFAULT_PASSWORD)
                        ->setEmail(sprintf('user%s@test.com',$i+1))
                        ->setUsername($faker->userName)
                        ->setPicture($faker->gravatarUrl($avatarCat[array_rand($avatarCat)]));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
