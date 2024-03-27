<?php
/**
 *  AdminsController.php
 *
 * This file contains the definition of the AdminsController class, which handles
 * actions related to admins in the application.
 *
 * @category Controllers
 * @package  App\Controller\Admins
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller\Admins;

use App\Entity\User;
use App\Entity\Posts;
use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Form\RegistrationFormType;
use App\Repository\PostsRepository;
use App\Repository\AdminsRepository;
use App\Repository\CategoriesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * AdminsController
 *
 * @category Controllers
 * 
 * @package App\Controller\Admins
 * 
 * @author Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * 
 * @license No license (Personal project)
 * 
 * @link https://symfony.com/doc/current/controller.html
 */
class AdminsController extends AbstractController
{

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em                   The entity manager.
     * @param CategoriesRepository   $categoriesRepository The categories repository.
     * @param PostsRepository        $postsRepository      The posts repository.
     * @param Request                $request              The request Object.
     * @param AdminsRepository       $adminRepository      The admins repository.
     * @param UserRepository         $userRepository       The user repository.
     * 
     * @return void
     */
    public function __construct(
        private EntityManagerInterface $em,
        private CategoriesRepository $categoriesRepository,
        private PostsRepository $postsRepository,
        private Request $request,
        private AdminsRepository $adminRepository,
        private UserRepository $userRepository
    ) {
    }
    /**
     * Index Method to display all the posts
     * 
     * @return Response
     */
    public function index(): Response
    {
        // Retrieve count of posts, categories, and admins
        $postCount = $this->postsRepository->count([]);
        $countCategory = $this->categoriesRepository->count([]);
        $countAdmin = $this->adminRepository->count([]);

        return $this->render(
            'admins/dashboard.html.twig',
            [
                'postCount' => $postCount,
                'countCategory' => $countCategory,
                'countAdmin' => $countAdmin,
            ]
        );
    }

    /**
     * Showadmins Method to display all the admins
     * 
     * @return Response
     */
    public function showAdmins(): Response
    {
        // Retrieve all admins
        $admins = $this->userRepository->findAdmins();

        return $this->render(
            'admins/admins.html.twig',
            [
                'admins' => $admins,
            ]
        );
    }

    /**
     * CreateAdmins Method to create new admins
     * 
     * @param UserPasswordHasherInterface $userPasswordHasher The user password hasher.
     * 
     * @return Response
     */
    public function createAdmins(UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $admin = new User();
        $form = $this->createForm(RegistrationFormType::class, $admin);

        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {

            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('plainPassword')->getData()
                )
            );

            $admin->setRoles(['ROLE_ADMIN']);

            $this->em->persist($admin);
            $this->em->flush();

            return $this->redirectToRoute('admin_admins_list');
        }

        return $this->render(
            'admins/create-admins.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * ShowCategories Method to display all the categories
     * 
     * @return Response
     */
    public function showCategories(): Response
    {
        $categories = $this->categoriesRepository->findAll();

        return $this->render(
            'admins/categories.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * DeleteCategory Method to delete categories
     * 
     * @param Categories $category The categories entity.
     * 
     * @return Response
     */
    public function deleteCategory(Categories $category): Response
    {
        // Remove the post from the database
        $this->em->remove($category);
        $this->em->flush();

        // Redirect to the index page
        return $this->redirectToRoute('admin_admins_categories');
    }

    /**
     * CreateCategoty Method to create new categories
     * 
     * @return Response
     */
    public function createCategory(): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);

        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('admin_admins_categories');
        }
    }
    /**
     * UpdateCategory Method to update categories
     * 
     * @param Categories $category The categories entity.
     * 
     * @return Response
     */
    public function updateCategory(Categories $category): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);


        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_admins_categories');
        }

        return $this->render(
            'admins/update-category.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category->getId(),
                'categoryName' => $category->getName(),
            ]
        );
    }

    /**
     * ShowPosts Method to display all the posts
     * 
     * @return Response
     */
    public function showPosts(): Response
    {
        // Retrieve all admins
        $posts = $this->postsRepository->findAll();

        return $this->render(
            'admins/posts.html.twig',
            [
                'posts' => $posts,
            ]
        );
    }

    /**
     * Showadmins Method to display all the admins
     * 
     * @param Posts $post The posts entity.
     * 
     * @return Response
     */
    public function deletePost(Posts $post): Response
    {
        // Remove the post from the database
        $this->em->remove($post);
        $this->em->flush();

        // Redirect to the index page
        return $this->redirectToRoute('admin_admins_show_posts');
    }

}