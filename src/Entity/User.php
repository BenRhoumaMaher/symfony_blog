<?php

/**
 * User.php
 *
 * This file contains the class of the User management page.
 *
 * @category Entities
 * @package  App\Entity
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

/**
 * User
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
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $_id = null;

    #[ORM\Column(length: 255)]
    private ?string $_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $_image = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $_bio = null;

    #[ORM\Column(length: 180)]
    private ?string $_email = null;

    #[ORM\OneToMany(targetEntity: \App\Entity\Posts::class, mappedBy: 'user')]

    private Collection $_posts;

    #[ORM\OneToMany(targetEntity: \App\Entity\Comments::class, mappedBy: 'user')]
    private Collection $_comments;

    /**
     * The roles of the user.
     *
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $_roles = [];

    /**
     * Construct of the class User
     */
    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    /**
     * The hashed password of the user.
     *
     * @var string|null The hashed password.
     */
    #[ORM\Column]
    private ?string $_password = null;


    /**
     * Gets the ID of the user.
     *
     * @return int|null The ID of the user, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->_id;
    }

    /**
     * Gets the email address of the user.
     *
     * @return string|null The email address of the user, or null if not set.
     */
    public function getEmail(): ?string
    {
        return $this->_email;
    }

    /**
     * Sets the email address of the user.
     *
     * @param string $email The email address to set.
     *
     * @return static The updated entity instance.
     */
    public function setEmail(string $email): static
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see    UserInterface
     * @return void
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->_email;
    }

    /**
     * Gets the roles granted to the user.
     *
     * @see UserInterface
     *
     * @return string[] The user roles.
     */
    public function getRoles(): array
    {
        $roles = $this->_roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Sets the roles granted to the user.
     *
     * @param string[] $roles The user roles to set.
     *
     * @return static The updated entity instance.
     */
    public function setRoles(array $roles): static
    {
        $this->_roles = $roles;

        return $this;
    }

    /**
     * Gets the password hash of the user.
     *
     * @see PasswordAuthenticatedUserInterface
     *
     * @return string The hashed password.
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * Sets the password hash of the user.
     *
     * @param string $password The hashed password to set.
     *
     * @return static The updated entity instance.
     */
    public function setPassword(string $password): static
    {
        $this->_password = $password;

        return $this;
    }

    /**
     * Erases the user credentials.
     *
     * This method is called after the user's information has been used to authenticate and it is no longer needed.
     *
     * @see UserInterface
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Gets the name of the user.
     *
     * @return string|null The name of the user, or null if not set.
     */
    public function getName(): ?string
    {
        return $this->_name;
    }

    /**
     * Sets the name of the user.
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
     * Gets the image associated with the user.
     *
     * @return string|null The image associated with the user, or null if not set.
     */
    public function getImage(): ?string
    {
        return $this->_image;
    }

    /**
     * Sets the image associated with the user.
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
     * Gets the biography of the user.
     *
     * @return string|null The biography of the user, or null if not set.
     */
    public function getBio(): ?string
    {
        return $this->_bio;
    }

    /**
     * Sets the biography of the user.
     *
     * @param string|null $bio The biography to set.
     *
     * @return static The updated entity instance.
     */
    public function setBio(?string $bio): static
    {
        $this->_bio = $bio;

        return $this;
    }

    /**
     * Gets the collection of posts authored by the user.
     *
     * @return Collection<int, Posts> The collection of posts.
     */
    public function getPosts(): Collection
    {
        return $this->_posts;
    }

    /**
     * Adds a post to the collection of posts authored by the user.
     *
     * @param Posts $post The post to add.
     *
     * @return static The updated entity instance.
     */
    public function addPost(Posts $post): static
    {
        if (!$this->_posts->contains($post)) {
            $this->_posts->add($post);
            $post->setUser($this);
        }

        return $this;
    }

    /**
     * Removes a post from the collection of posts authored by the user.
     *
     * @param Posts $post The post to remove.
     *
     * @return static The updated entity instance.
     */
    public function removePost(Posts $post): static
    {
        if ($this->_posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Gets the collection of comments posted by the user.
     *
     * @return Collection<int, Comments> The collection of comments.
     */
    public function getComments(): Collection
    {
        return $this->_comments;
    }

    /**
     * Adds a comment to the collection of comments posted by the user.
     *
     * @param Comments $comment The comment to add.
     *
     * @return static The updated entity instance.
     */
    public function addComment(Comments $comment): static
    {
        if (!$this->_comments->contains($comment)) {
            $this->_comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    /**
     * Removes a comment from the collection of comments posted by the user.
     *
     * @param Comments $comment The comment to remove.
     *
     * @return static The updated entity instance.
     */
    public function removeComment(Comments $comment): static
    {
        if ($this->_comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
}
