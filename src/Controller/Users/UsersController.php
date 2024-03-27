<?php

/**
 * PostsController.php
 *
 * This file contains the definition of the UserController class, which handles
 * actions related to posts in the application.
 *
 * @category Controllers
 * @package  App\Controller\Users
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller\Users;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * UsersController
 *
 * @category Controllers
 *
 * @package App\Controller\Users
 *
 * @author Maher Ben Rhouma <maherbenrhouma@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */
class UsersController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em      The entity manager.
     * @param Request                $request The request object.
     *
     * @return void
     */
    public function __construct(
        private EntityManagerInterface $em,
        private Request $request
    ) {
    }

    /**
     * Updateprofile Method to display the update form
     *
     * @param User $user The user entity.
     *
     * @return Response
     */
    public function updateProfile(User $user): Response
    {
        // Render the update profile form
        return $this->render(
            'users/update-profile.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * EditPorile Method to update users profile
     *
     * @param User $user The user entity.
     *
     * @return Response
     */
    public function editProfile(User $user): Response
    {
        // Validate incoming request fields
        $incomingFields = $this->request->request->all();

        // Update user profile
        $user->setName($incomingFields['name']);
        $user->setEmail($incomingFields['email']);
        $user->setBio($incomingFields['bio']);
        $this->em->flush();

        // Redirect to user profile page
        return $this->redirectToRoute(
            'user_single_profile',
            ['user' => $user->getId()]
        );
    }

    /**
     * Profile Method to display user profile
     *
     * @param User $user The user entity.
     *
     * @return Response
     */
    public function profile(User $user): Response
    {
        // Retrieve user's posts
        $posts = $user->getPosts()->slice(0, 5);

        // Render user profile page
        return $this->render(
            'users/profile.html.twig',
            [
                'user' => $user,
                'posts' => $posts,
                'username' => $user->getName(),
            ]
        );
    }
}
