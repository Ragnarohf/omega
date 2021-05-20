<?php

namespace App\Entity;

use App\Repository\FriendRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendRepository::class)
 */
class Friend
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username_2;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_pending;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername1(): ?string
    {
        return $this->username_1;
    }

    public function setUsername1(?string $username_1): self
    {
        $this->username_1 = $username_1;

        return $this;
    }

    public function getUsername2(): ?string
    {
        return $this->username_2;
    }

    public function setUsername2(?string $username_2): self
    {
        $this->username_2 = $username_2;

        return $this;
    }

    public function getIsPending(): ?bool
    {
        return $this->is_pending;
    }

    public function setIsPending(?bool $is_pending): self
    {
        $this->is_pending = $is_pending;

        return $this;
    }
}
