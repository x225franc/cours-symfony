<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Enum\UserAccountStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(Security $security): Response
    {
        $response = $security->logout();

        return $this->redirectToRoute('home');
    }

    #[Route(path: '/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, UrlGeneratorInterface $urlGenerator, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
                return $this->redirectToRoute('register');
            }

            $user->setAccountStatus(UserAccountStatusEnum::INACTIVE);
            $user->setRoles(['ROLE_USER']);

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $activationToken = bin2hex(random_bytes(32));
            $user->setActivationToken($activationToken);
            $user->setActivationTokenExpiresAt(new \DateTime('+1 hour'));

            $entityManager->persist($user);
            $entityManager->flush();

            $activationUrl = $urlGenerator->generate('confirm', ['token' => $activationToken], UrlGeneratorInterface::ABSOLUTE_URL);
            $email = (new Email())
                ->from('no-reply@streemi.com')
                ->to($user->getEmail())
                ->subject('Activer votre compte')
                ->html('<p>S\'il vous plaît cliquez sur le lien suivant pour activer votre compte: <a href="' . $activationUrl . '">Activer le compte</a></p>');

            $mailer->send($email);

            return $this->redirectToRoute('created');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/created', name: 'created')]
    public function created(): Response
    {
        return $this->render('auth/created.html.twig');
    }

    #[Route(path: '/confirm/{token}', name: 'confirm')]
    public function confirm(string $token, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['activationToken' => $token]);

        if (!$user || $user->getActivationTokenExpiresAt() < new \DateTime()) {
            $this->addFlash('error', 'Le lien d\'activation est invalide ou expiré.');
            return $this->redirectToRoute('register');
        }

        $user->setAccountStatus(UserAccountStatusEnum::ACTIVE);
        $user->setActivationToken(null);
        $user->setActivationTokenExpiresAt(null);

        $entityManager->flush();

        return $this->render('auth/confirm.html.twig');
    }

    #[Route(path: '/forgot', name: 'forgot')]
    public function forgot(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, UrlGeneratorInterface $urlGenerator): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            // Find the user by email
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                // Generate reset token
                $resetToken = bin2hex(random_bytes(32));
                $user->setResetToken($resetToken);
                $user->setResetTokenExpiresAt(new \DateTime('+1 hour'));

                $entityManager->flush();

                // Send reset email
                $resetUrl = $urlGenerator->generate('reset', ['token' => $resetToken], UrlGeneratorInterface::ABSOLUTE_URL);
                $emailMessage = (new Email())
                    ->from('no-reply@streemi.com')
                    ->to($user->getEmail())
                    ->subject('Reinitialiser votre mot de passe')
                    ->html('<p>S\'il vous plaît cliquez sur le lien suivant pour réinitialiser votre mot de passe: <a href="' . $resetUrl . '">Reinitialiser mot de passe</a></p>');

                $mailer->send($emailMessage);

                $this->addFlash('success', 'Un email a été envoyé à votre adresse email avec les instructions pour réinitialiser votre mot de passe.');
                return $this->redirectToRoute('login');
            } else {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cette adresse email.');
            }
        }

        return $this->render('auth/forgot.html.twig');
    }

    #[Route(path: '/reset/{token}', name: 'reset')]
    public function reset(string $token, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user || $user->getResetTokenExpiresAt() < new \DateTime()) {
            $this->addFlash('error', 'Le lien de réinitialisation est invalide ou expiré.');
            return $this->redirectToRoute('forgot');
        }

        if ($request->isMethod('POST')) {
            $newPassword = $request->request->get('password');
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

            $user->setPassword($hashedPassword);
            $user->setResetToken(null);
            $user->setResetTokenExpiresAt(null);

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');

            return $this->redirectToRoute('login');
        }

        return $this->render('auth/reset.html.twig', [
            'token' => $token,
        ]);
    }
}
