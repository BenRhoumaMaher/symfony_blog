<?php

/**
 * Admin.php
 *
 * This file contains the class of the Admin user management page.
 *
 * @category Entities
 * @package  App\Entity
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminsRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: AdminsRepository::class)]

/**
 * Admins
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
class Admins implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $_id = null;

    #[ORM\Column(length: 255)]
    private ?string $_name = null;

    #[ORM\Column(length: 255)]
    private ?string $_email = null;

    #[ORM\Column(length: 255)]
    private ?string $_password = null;



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
     * Gets the email of the entity.
     *
     * @return string|null The email of the entity, or null if not set.
     */
    public function getEmail(): ?string
    {
        return $this->_email;
    }

    /**
     * Sets the email of the entity.
     *
     * @param string $email The email to set.
     *
     * @return static The updated entity instance.
     */
    public function setEmail(string $email): static
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * Gets the password of the entity.
     *
     * @return string|null The password of the entity, or null if not set.
     */
    public function getPassword(): ?string
    {
        return $this->_password;
    }

    /**
     * Sets the password of the entity.
     *
     * @param string $password The password to set.
     *
     * @return static The updated entity instance.
     */
    public function setPassword(string $password): static
    {
        $this->_password = $password;

        return $this;
    }
}
