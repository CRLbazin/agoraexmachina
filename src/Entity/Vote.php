<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
	public function __construct()
	{
		$this->creationDate = new \DateTime('now');
	}
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proposal", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proposal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
	private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": "0"})
     */
    private $votedFor;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": "0"})
     */
    private $votedAgainst;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": "0"})
     */
    private $votedBlank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProposal(): ?Proposal
    {
        return $this->proposal;
    }

    public function setProposal(?Proposal $proposal): self
    {
        $this->proposal = $proposal;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getVotedFor(): ?bool
    {
        return $this->votedFor;
    }

    public function setVotedFor(?bool $votedFor): self
    {
        $this->votedFor = $votedFor;

        return $this;
    }

    public function getVotedAgainst(): ?bool
    {
        return $this->votedAgainst;
    }

    public function setVotedAgainst(?bool $votedAgainst): self
    {
        $this->votedAgainst = $votedAgainst;

        return $this;
    }

    public function getVotedBlank(): ?bool
    {
        return $this->votedBlank;
    }

    public function setVotedBlank(?bool $votedBlank): self
    {
        $this->votedBlank = $votedBlank;

        return $this;
    }
}
