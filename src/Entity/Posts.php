<?php
/**
 * Posts.php
 *
 * This file contains the class of the Posts management page.
 *
 * @category Entities
 * @package  App\Entity
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */
namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostsRepository::class)]

/**
 * Posts
 *
 * @category Entities
 * 
 * @package App\Entity
 * 
 * @author Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * 
 * @license No license (Personal project)
 * 
 * @link https://symfony.com/doc/current/controller.html
 */
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $_id = null;

    #[ORM\Column(length: 255)]
    private ?string $_title = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $_image = null;

    #[ORM\Column(length: 255)]
    private ?string $_description = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $_user = null;

    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'post', cascade: ["remove"], orphanRemoval: true)]
    private Collection $_comments;

    #[ORM\Column(length: 255)]
    private ?string $_user_name = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Categories $_category = null;

    /** 
     * Construct of the class Posts
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Gets the ID of the post.
     *
     * @return int|null The ID of the post, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->_id;
    }

    /**
     * Gets the title of the post.
     *
     * @return string|null The title of the post, or null if not set.
     */
    public function getTitle(): ?string
    {
        return $this->_title;
    }

    /**
     * Sets the title of the post.
     *
     * @param string $title The title to set.
     *
     * @return static The updated entity instance.
     */
    public function setTitle(string $title): static
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * Gets the image associated with the post.
     *
     * @return string|null The image associated with the post, or null if not set.
     */
    public function getImage(): ?string
    {
        return $this->_image;
    }

    /**
     * Sets the image associated with the post.
     *
     * @param string|null $image The image to set.
     *
     * @return static The updated entity instance.
     */
    public function setImage(?string $image): static
    {
        $this->_image = $image;

        return $this;
    }

    /**
     * Gets the description of the post.
     *
     * @return string|null The description of the post, or null if not set.
     */
    public function getDescription(): ?string
    {
        return $this->_description;
    }

    /**
     * Sets the description of the post.
     *
     * @param string $description The description to set.
     *
     * @return static The updated entity instance.
     */
    public function setDescription(string $description): static
    {
        $this->_description = $description;

        return $this;
    }

    /**
     * Gets the user who created the post.
     *
     * @return User|null The user who created the post, or null if not set.
     */
    public function getUser(): ?User
    {
        return $this->_user;
    }

    /**
     * Sets the user who created the post.
     *
     * @param User|null $user The user to set.
     *
     * @return static The updated entity instance.
     */
    public function setUser(?User $user): static
    {
        $this->_user = $user;

        return $this;
    }

    /**
     * Gets the collection of comments associated with this post.
     *
     * @return Collection<int, Comments> The collection of comments.
     */
    public function getComments(): Collection
    {
        return $this->_comments;
    }

    /**
     * Adds a comment to the collection of comments associated with this post.
     *
     * @param Comments $comment The comment to add.
     *
     * @return static The updated entity instance.
     */
    public function addComment(Comments $comment): static
    {
        if (!$this->_comments->contains($comment)) {
            $this->_comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    /**
     * Removes a comment from the collection of comments associated with this post.
     *
     * @param Comments $comment The comment to remove.
     *
     * @return static The updated entity instance.
     */
    public function removeComment(Comments $comment): static
    {
        if ($this->_comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * Gets the username associated with the post.
     *
     * @return string|null The username associated with the post, or null if not set.
     */
    public function getUserName(): ?string
    {
        return $this->_user_name;
    }

    /**
     * Sets the username associated with the post.
     *
     * @param string $user_name The username to set.
     *
     * @return static The updated entity instance.
     */
    public function setUserName(string $user_name): static
    {
        $this->_user_name = $user_name;

        return $this;
    }

    /**
     * Gets the category to which the post belongs.
     *
     * @return Categories|null The category to which the post belongs, or null if not set.
     */
    public function getCategory(): ?Categories
    {
        return $this->_category;
    }

    /**
     * Sets the category to which the post belongs.
     *
     * @param Categories|null $category The category to set.
     *
     * @return static The updated entity instance.
     */
    public function setCategory(?Categories $category): static
    {
        $this->_category = $category;

        return $this;
    }

}
