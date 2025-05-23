<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Safe\DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setLocale('de_DE')
            ->setIsConfirmed(true)
            ->setConfirmedAt(new DateTimeImmutable('11.03.2025'))
            ->setEmail('test@test.tld')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'test'));

        $manager->persist($user);
        $manager->flush();
    }
}
