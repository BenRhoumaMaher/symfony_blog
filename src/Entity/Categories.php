<?php
/**
 * Categories.php
 *
 * This file contains the class of the Categories management page.
 *
 * @category Entities
 * @package  App\Entity
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
/**
 * Categories
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
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $_id = null;

    #[ORM\Column(length: 255)]
    private ?string $_name = null;

    #[ORM\OneToMany(targetEntity: Posts::class, mappedBy: 'category', cascade: ["remove"])]
    private Collection $_posts;

    /** 
     * Construct of the class Categories
     */
    public function __construct()
    {
        $this->_posts = new ArrayCollection();
    }

    /**
     * Gets the ID of the entity.
     *
     * @return int|null The ID of the entity, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->_id;
    }

    /**
     * Gets the name of the entity.
     *
     * @return string|null The name of the entity, or null if not set.
     */
    public function getName(): ?string
    {
        return $this->_name;
    }

    /**
     * Sets the name of the entity.
     *
     * @param string $name The name to set.
     *
     * @return static The updated entity instance.
     */
    public function setName(string $name): static
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Gets the collection of posts associated with this category.
     *
     * @return Collection<int, Posts> The collection of posts.
     */
    public function getPosts(): Collection
    {
        return $this->_posts;
    }

    /**
     * Adds a post to the collection of posts associated with this category.
     *
     * @param Posts $post The post to add.
     *
     * @return static The updated entity instance.
     */
    public function addPost(Posts $post): static
    {
        if (!$this->_posts->contains($post)) {
            $this->_posts->add($post);
            $post->setCategory($this);
        }

        return $this;
    }

    /**
     * Removes a post from the collection of posts associated with this category.
     *
     * @param Posts $post The post to remove.
     *
     * @return static The updated entity instance.
     */
    public function removePost(Posts $post): static
    {
        if ($this->_posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

        return $this;
    }

}
