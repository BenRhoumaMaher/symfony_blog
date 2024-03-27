<?php

/**
 * PostsController.php
 *
 * This file contains the definition of the PostsController class, which handles
 * actions related to posts in the application.
 *
 * @category Controllers
 * @package  App\Controller\Posts
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller\Posts;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Entity\Category;
use App\Entity\Comments;
use App\Repository\PostsRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PostsController
 *
 * @category Controllers
 *
 * @package App\Controller\Posts
 *
 * @author Maher Ben Rhouma <maherbenrhouma@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */
class PostsController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em                   The entity manager.
     * @param CategoriesRepository   $categoriesRepository The categories repository.
     * @param PostsRepository        $postsRepository      The posts repository.
     * @param Request                $request              The request object.
     *
     * @return void
     */
    public function __construct(
        private EntityManagerInterface $em,
        private CategoriesRepository $categoriesRepository,
        private PostsRepository $postsRepository,
        private Request $request
    ) {
    }
    /**
     * Index Method to display all the posts
     *
     * @return Response
     */
    public function index(): Response
    {
        // first section
        $posts = $this->postsRepository->findAll();
        $postOne = $this->postsRepository->findOneBy([], ['id' => 'desc']);
        $postTwo = $this->postsRepository->findBy([], ['title' => 'desc'], 2);

        // business section
        $postBus = $this->postsRepository->findBy(
            ['category' => 1],
            ['id' => 'desc'],
            2
        );
        $postBusTwo = $this->postsRepository->findBy(
            ['category' => 'business'],
            ['title' => 'desc'],
            3
        );

        // random posts
        $randomPosts = $this->postsRepository->findBy(
            [],
            ['category' => 'desc'],
            4
        );

        // Culture section
        $postCul = $this->postsRepository->findBy(
            ['category' => 'culture'],
            ['description' => 'desc'],
            2
        );
        $postCulTwo = $this->postsRepository->findBy(
            ['category' => 'culture'],
            ['title' => 'desc'],
            3
        );

        // Politics section
        $postPol = $this->postsRepository->findBy(
            ['category' => 'politics'],
            ['title' => 'desc'],
            9
        );

        // Travel section
        $postTraOne = $this->postsRepository->findOneBy(
            ['category' => 'travel'],
            [
                'title' =>
                    'desc'
            ]
        );
        $postTraFirst = $this->postsRepository->findOneBy(
            ['category' => 'travel'],
            ['id' => 'desc']
        );
        $postTraTwo = $this->postsRepository->findBy(
            ['category' => 'travel'],
            ['description' => 'desc'],
            2
        );
        return $this->render(
            'posts/index.html.twig',
            [
                'posts' => $posts,
                'post_one' => $postOne,
                'post_two' => $postTwo,
                'post_cul' => $postCul,
                'post_pol' => $postPol,
                'post_tra_first' => $postTraFirst,
                'post_tra_one' => $postTraOne,
                'post_tra_two' => $postTraTwo,
                'post_bus' => $postBus,
                'post_bus_two' => $postBusTwo,
                'post_cul_two' => $postCulTwo,
                'random_posts' => $randomPosts,
            ]
        );
    }


    /**
     * Displaying single post
     *
     * @param mixed $post The posts entity.
     *
     * @return Response
     */
    public function single(Posts $post): Response
    {
        // Retrieve popular posts from database
        $popPosts = $this->postsRepository->findBy([], ['id' => 'DESC'], 3);

        // Retrieve categories from database
        $categories = $this->categoriesRepository->findAll();


        // Retrieve comments for the post
        $comments = $post->getComments();
        $commentCount = count($comments);

        // Retrieve more posts from the same category
        $morePosts = $this->postsRepository->findBy(
            ['category' => $post->getCategory()],
            ['id' => 'DESC'],
            4
        );

        // Render the single post view
        return $this->render(
            'posts/single.html.twig',
            [
                'post' => $post,
                'popPosts' => $popPosts,
                'categories' => $categories,
                'comments' => $comments,
                'commentCount' => $commentCount,
                'morePosts' => $morePosts,
            ]
        );
    }

    /**
     * Storing a comment in database
     *
     * @return Response
     */
    public function storeComment(): Response
    {
        // Create a new comment entity
        $comment = new Comments();
        $comment->setComment($this->request->request->get('comment'));
        $comment->setUser($this->getUser());
        $comment->setPost(
            $this->postsRepository->find($this->request->get('post_id'))
        );

        // Persist the comment to the database
        $this->em->persist($comment);
        $this->em->flush();

        // Redirect back to the single post view
        return $this->redirectToRoute(
            'post_posts_single',
            ['post' => $this->request->request->get('post_id')]
        );
    }


    /**
     * Create new post
     *
     * @return Response
     */
    public function createPost(): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);

        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $fileName = uniqid() . '.' . $file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            // Create a new post entity
            $user = $this->getUser();
            $username = $user->getName();
            $post->setUserName($username);
            $post->setImage($fileName);
            $post->setUser($user);

            $this->em->persist($post);
            $this->em->flush();

            return $this->redirectToRoute(
                'post_posts_single',
                [
                    'post' => $post->getId(),
                ]
            );
        }

        return $this->render(
            'posts/create-post.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }


    /**
     * Deleting a post
     *
     * @param mixed $post The posts entity.
     *
     * @return Response
     */
    public function deletePost(Posts $post): Response
    {
        // Remove the post from the database
        $this->em->remove($post);
        $this->em->flush();

        // Redirect to the index page
        return $this->redirectToRoute('post_posts_index');
    }

    /**
     * Editing a post
     *
     * @param mixed $post The posts entity.
     *
     * @return Response
     */
    public function editPost(Posts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);


        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload...
            $file = $form->get('image')->getData();
            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move($this->getParameter('image_directory'), $fileName);
                $post->setImage($fileName);
            }
            // Persist the updated post to the database
            $this->em->flush();

            return $this->redirectToRoute(
                'post_posts_single',
                [
                    'post' => $post->getId(),
                ]
            );
        }

        return $this->render(
            'posts/edit-post.html.twig',
            [
                'form' => $form->createView(),
                'post' => $post->getId(),
                'userid' => $post->getUser()->getId()
            ]
        );
    }


    /**
     * Contact Page
     *
     * @return Response
     */
    public function contact(): Response
    {
        // Render the contact page
        return $this->render('pages/contact.html.twig');
    }


    /**
     * About Page
     *
     * @return Response
     */
    public function about(): Response
    {
        // Render the about page
        return $this->render('pages/about.html.twig');
    }


    /**
     * Search
     *
     * @return Response
     */
    public function search(): Response
    {
        // Search for posts based on title
        $search = $this->request->request->get('search');
        $results = $this->postsRepository->findByTitle($search);

        // Render the search results page
        return $this->render(
            'posts/search.html.twig',
            [
                'results' => $results,
            ]
        );
    }
}
