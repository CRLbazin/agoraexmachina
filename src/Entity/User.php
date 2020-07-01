<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="username.alreadyexists")
 * @UniqueEntity(fields={"email"}, message="email.alreadyexists")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposal", mappedBy="user")
     */
    private $proposals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="user", orphanRemoval=true)
     */
    private $votes;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
	 * @Assert\Email(
	 *	message = "email.notvalid"
	 * )
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Forum", mappedBy="user", orphanRemoval=true)
     */
    private $forums;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="userFrom", orphanRemoval=true)
     */
    private $delegationsFrom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="userTo", orphanRemoval=true)
     */
    private $delegationsTo;

    /**
     * @ORM\OneToMany(targetEntity=Workshop::class, mappedBy="user")
     */
    private $workshops;

    public function __construct()
    {
        $this->proposals = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->forums = new ArrayCollection();
        $this->delegationsFrom = new ArrayCollection();
		$this->delegationsTo = new ArrayCollection();
  $this->workshops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Proposals[]
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): self
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals[] = $proposal;
            $proposal->setUser($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): self
    {
        if ($this->proposals->contains($proposal)) {
            $this->proposals->removeElement($proposal);
            // set the owning side to null (unless already changed)
            if ($proposal->getUser() === $this) {
                $proposal->setUser(null);
            }
        }

        return $this;
    }
	
    /**
     * @return Collection|Votes[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setUser($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getUser() === $this) {
                $vote->setUser(null);
            }
        }

        return $this;
	}

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Forums[]
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums[] = $forum;
            $forum->setUser($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forums->contains($forum)) {
            $this->forums->removeElement($forum);
            // set the owning side to null (unless already changed)
            if ($forum->getUser() === $this) {
                $forum->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DelegationFrom[]
     */
    public function getDelegationsFrom(): Collection
    {
        return $this->delegationsFrom;
    }

    /**
     * @return Collection|DelegationTo[]
     */
    public function getDelegationsTo(): Collection
    {
        return $this->delegationsTo;
    }

    public function addDelegationFrom(Delegation $delegationFrom): self
    {
        if (!$this->delegationsFrom->contains($delegationFrom)) {
            $this->delegationsFrom[] = $delegationFrom;
            $delegationFrom->setUserFrom($this);
        }

        return $this;
    }

    public function addDelegationTo(Delegation $delegationTo): self
    {
        if (!$this->delegationsTo->contains($delegationTo)) {
            $this->delegationsTo[] = $delegationTo;
            $delegationTo->setUserFrom($this);
        }

        return $this;
    }

    public function removeDelegationFrom(Delegation $delegationFrom): self
    {
        if ($this->delegationsFrom->contains($delegationFrom)) {
            $this->delegationsFrom->removeElement($delegationFrom);
            // set the owning side to null (unless already changed)
            if ($delegationFrom->getUserFrom() === $this) {
                $delegationFrom->setUserFrom(null);
            }
        }

        return $this;
	}

        

    public function removeDelegationTo(Delegation $delegationTo): self
    {
        if ($this->delegationsTo->contains($delegationTo)) {
            $this->delegationsTo->removeElement($delegationTo);
            // set the owning side to null (unless already changed)
            if ($delegationTo->getUserFrom() === $this) {
                $delegationTo->setUserFrom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Workshop[]
     */
    public function getWorkshops(): Collection
    {
        return $this->workshops;
    }

    public function addWorkshop(Workshop $workshop): self
    {
        if (!$this->workshops->contains($workshop)) {
            $this->workshops[] = $workshop;
            $workshop->setUser($this);
        }

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        if ($this->workshops->contains($workshop)) {
            $this->workshops->removeElement($workshop);
            // set the owning side to null (unless already changed)
            if ($workshop->getUser() === $this) {
                $workshop->setUser(null);
            }
        }

        return $this;
    }
}
