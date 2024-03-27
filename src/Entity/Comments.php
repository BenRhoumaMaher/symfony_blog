<?php

/**
 * Comments.php
 *
 * This file contains the class of the Comments management page.
 *
 * @category Entities
 * @package  App\Entity
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]

/**
 * Comments
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
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $_id = null;

    #[ORM\Column(length: 255)]
    private ?string $_comment = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $_user = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Posts $_post = null;

    /**
     * Gets the ID of the comment.
     *
     * @return int|null The ID of the comment, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->_id;
    }

    /**
     * Gets the content of the comment.
     *
     * @return string|null The content of the comment, or null if not set.
     */
    public function getComment(): ?string
    {
        return $this->_comment;
    }

    /**
     * Sets the content of the comment.
     *
     * @param string $comment The content to set.
     *
     * @return static The updated entity instance.
     */
    public function setComment(string $comment): static
    {
        $this->_comment = $comment;

        return $this;
    }

    /**
     * Gets the user who posted the comment.
     *
     * @return User|null The user who posted the comment, or null if not set.
     */
    public function getUser(): ?User
    {
        return $this->_user;
    }

    /**
     * Sets the user who posted the comment.
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
     * Gets the post to which the comment belongs.
     *
     * @return Posts|null The post to which the comment belongs, or null if not set.
     */
    public function getPost(): ?Posts
    {
        return $this->_post;
    }

    /**
     * Sets the post to which the comment belongs.
     *
     * @param Posts|null $post The post to set.
     *
     * @return static The updated entity instance.
     */
    public function setPost(?Posts $post): static
    {
        $this->_post = $post;

        return $this;
    }
}
