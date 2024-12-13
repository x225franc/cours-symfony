<?php

namespace App\Security;

use App\Entity\User;
use App\Enum\UserAccountStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomProvider implements UserProviderInterface
{
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->loadUserByUsername($identifier);
    }
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Nom d\'utilisateur ou mot de passe incorrect.');
        }

        if ($user->getAccountStatus() === UserAccountStatusEnum::INACTIVE) {
            throw new CustomUserMessageAuthenticationException('Votre compte est inactif. Veuillez vérifier votre email pour activer votre compte.');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new CustomUserMessageAuthenticationException('Nom d\'utilisateur ou mot de passe incorrect.');
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}