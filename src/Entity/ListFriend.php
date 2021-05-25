<?php

namespace App\Entity;

use App\Repository\ListFriendRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListFriendRepository::class)
 */
class ListFriend
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="listFriend", cascade={"persist", "remove"})
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="is_friend")
     */
    private $Friend;

    public function __construct()
    {
        $this->Friend = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFriend(): Collection
    {
        return $this->Friend;
    }

    public function addFriend(User $friend): self
    {
        if (!$this->Friend->contains($friend)) {
            $this->Friend[] = $friend;
            $friend->setIsFriend($this);
        }

        return $this;
    }

    public function removeFriend(User $friend): self
    {
        if ($this->Friend->removeElement($friend)) {
            // set the owning side to null (unless already changed)
            if ($friend->getIsFriend() === $this) {
                $friend->setIsFriend(null);
            }
        }

        return $this;
    }
}
