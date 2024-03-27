<?php

/**
 * RegistrationController.php
 *
 * This file contains the definition of the RegistrationController class, which handles
 * authentification of users in our application
 *
 * @category Controllers
 * @package  App\Controller\Registration
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * RegistrationController
 *
 * @category Controllers
 *
 * @package App\Controller\Registration
 *
 * @author Maher Ben Rhouma <maherbenrhouma@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]

    /**
     * Register Method to register the users
     *
     * @param SluggerInterface            $slugger            The slugger interface
     * @param Request                     $request            The request object
     * @param UserPasswordHasherInterface $userPasswordHasher The user    password hasher
     * @param EntityManagerInterface      $entityManager      The entity manager
     *
     * @return Response
     */
    public function register(SluggerInterface $slugger, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $user->setImage($newFilename);
            }
            $user->setRoles(['ROLE_USER']);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );



            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute(
                'single_profile',
                [
                    'user' => $user->getId(),
                ]
            );
        }

        return $this->render(
            'registration/register.html.twig',
            [
                'registrationForm' => $form,
            ]
        );
    }
}
