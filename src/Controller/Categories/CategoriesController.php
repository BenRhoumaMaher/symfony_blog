<?php

/**
 * CategoriesController.php
 *
 * This file contains the definition of the CategoriesController class, which handles
 * actions related to categories in the application.
 *
 * @category Controllers
 * @package  App\Controller\Categories
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller\Categories;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CategoriesController
 *
 * @category Controllers
 *
 * @package App\Controller\Categories
 *
 * @author Maher Ben Rhouma <maherbenrhouma@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */
class CategoriesController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param CategoriesRepository $categoriesRepository The categories repository.
     * @param PostsRepository      $postsRepository      The posts repository.
     * @param Request              $request              The request object.
     *
     * @return void
     */
    public function __construct(
        private CategoriesRepository $categoriesRepository,
        private PostsRepository $postsRepository,
        private Request $request
    ) {
    }


    /**
     * Action to retrieve the category page.
     *
     * @param Categories $categories The categories entity.
     *
     * @return Response
     */
    public function category(Categories $categories): Response
    {
        // Retrieve category name
        $categoryName = $this->request->attributes->get('category');

        // Retrieve category entity by name
        $category = $this->categoriesRepository->findOneBy(
            ['name' => $categoryName]
        );

        // Retrieve posts
        $posts = [];
        if ($category) {
            $posts = $category->getPosts();
        }

        $postCount = count($categories->getPosts());

        // Retrieve all categories with post counts
        $categoriess = $this->categoriesRepository->findAll();

        // Retrieve popular posts
        $popPosts = $this->postsRepository->findBy([], ['id' => 'DESC'], 5);

        // Render the category page
        return $this->render(
            'categories/category.html.twig',
            [
                'posts' => $posts,
                'categoryName' => $categoryName,
                'categories' => $categoriess,
                'popPosts' => $popPosts,
                'postCount' => $postCount
            ]
        );
    }
}
