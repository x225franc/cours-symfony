<?php

namespace App\DataFixtures;
ini_set('memory_limit', '1024M');
use Faker\Factory;
use App\Entity\User;
use App\Entity\media;
use App\Entity\Serie;
use App\Entity\Season;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Subscription;
use App\Enum\CommentStatusEnum;
use App\Entity\SubscriptionHistory;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        
        // Load fixtures from YAML
        $objects = $loader->loadFile(__DIR__ . '/fixtures.yaml')->getObjects();
        
        // Persist objects
        foreach ($objects as $object) {
            $manager->persist($object);
        }
        
        $manager->flush();
    }
}
