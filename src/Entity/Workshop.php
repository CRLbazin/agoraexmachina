<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkshopRepository")
 * @Vich\Uploadable
 */
class Workshop
{

	public function __construct()
         	{
         		$d1						 = new \DateTime();
         		$this->dateBegin		 = $d1;
         		$d2						 = new \DateTime();
         		$this->dateEnd			 = $d2->modify('+1 month');
         		$this->quorumRequired	 = 0;
         		$this->rightsDelegation	 = true;
         		$this->proposals		 = new ArrayCollection();
         		$this->delegations		 = new ArrayCollection();
         	}

	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $name;
	/**
	 * @ORM\Column(type="text")
	 */
	private $description;
	/**
	 * @ORM\Column(type="date")
	 */
	private $dateBegin;
	/**
	 * @ORM\Column(type="date")
	 */
	private $dateEnd;
	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $rightsSeeWorkshop;
	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $rightsVoteProposals;
	/**
	 * @ORM\Column(type="string", length=1024)
	 */
	private $rightsWriteProposals;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $quorumRequired;
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $rightsDelegation;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="workshops")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $category;
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $image;
	/**
	 * @Vich\UploadableField(mapping="workshops_images", fileNameProperty="image")
	 * @var File
	 */
	private $imageFile;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var \DateTime
	 */
	private $updatedAt;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Proposal", mappedBy="workshop", orphanRemoval=true)
	 */
	private $proposals;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="workshop")
	 */
	private $delegations;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

	public function getId(): ?int
         	{
         		return $this->id;
         	}

	public function getName(): ?string
         	{
         		return $this->name;
         	}

	public function setName(string $name): self
         	{
         		$this->name = $name;
         
         		return $this;
         	}

	public function getDescription(): ?string
         	{
         		return $this->description;
         	}

	public function setDescription(string $description): self
         	{
         		$this->description = $description;
         
         		return $this;
         	}

	public function getDateBegin(): ?\DateTimeInterface
         	{
         		return $this->dateBegin;
         	}

	public function setDateBegin(\DateTimeInterface $dateBegin): self
         	{
         		$this->dateBegin = $dateBegin;
         
         		return $this;
         	}

	public function getDateEnd(): ?\DateTimeInterface
         	{
         		return $this->dateEnd;
         	}

	public function setDateEnd(\DateTimeInterface $dateEnd): self
         	{
         		$this->dateEnd = $dateEnd;
         
         		return $this;
         	}

	public function getRightsSeeWorkshop(): ?string
         	{
         		return $this->rightsSeeWorkshop;
         	}

	public function setRightsSeeWorkshop(string $rightsSeeWorkshop): self
         	{
         		$this->rightsSeeWorkshop = $rightsSeeWorkshop;
         
         		return $this;
         	}

	public function getRightsVoteProposals(): ?string
         	{
         		return $this->rightsVoteProposals;
         	}

	public function setRightsVoteProposals(string $rightsVoteProposals): self
         	{
         		$this->rightsVoteProposals = $rightsVoteProposals;
         
         		return $this;
         	}

	public function getRightsWriteProposals(): ?string
         	{
         		return $this->rightsWriteProposals;
         	}

	public function setRightsWriteProposals(string $rightsWriteProposals): self
         	{
         		$this->rightsWriteProposals = $rightsWriteProposals;
         
         		return $this;
         	}

	public function getQuorumRequired(): ?int
         	{
         		return $this->quorumRequired;
         	}

	public function setQuorumRequired(?int $quorumRequired): self
         	{
         		$this->quorumRequired = $quorumRequired;
         
         		return $this;
         	}

	public function getRightsDelegation(): ?bool
         	{
         		return $this->rightsDelegation;
         	}

	public function setRightsDelegation(bool $rightsDelegation): self
         	{
         		$this->rightsDelegation = $rightsDelegation;
         
         		return $this;
         	}

	public function getCategory(): ?Category
         	{
         		return $this->category;
         	}

	public function setCategory(?category $category): self
         	{
         		$this->category = $category;
         
         		return $this;
         	}

	public function setImageFile(File $image = null)
         	{
         		$this->imageFile = $image;
         
         		// VERY IMPORTANT:
         		// It is required that at least one field changes if you are using Doctrine,
         		// otherwise the event listeners won't be called and the file is lost
         		if($image)
         		{
         			// if 'updatedAt' is not defined in your entity, use another property
         			$this->updatedAt = new \DateTime('now');
         		}
         	}

	public function getImageFile()
         	{
         		return $this->imageFile;
         	}

	public function setImage($image)
         	{
         		$this->image = $image;
         	}

	public function getImage()
         	{
         		return $this->image;
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
         		if( ! $this->Proposals->contains($proposal))
         		{
         			$this->Proposals[] = $proposal;
         			$proposal->setWorkshop($this);
         		}
         
         		return $this;
         	}

	public function removeProposal(Proposal $proposal): self
         	{
         		if($this->Proposals->contains($proposal))
         		{
         			$this->Proposals->removeElement($proposal);
         			// set the owning side to null (unless already changed)
         			if($proposal->getWorkshop() === $this)
         			{
         				$proposal->setWorkshop(null);
         			}
         		}
         
         		return $this;
         	}


	/**
	 * @return Collection|Delegation[]
	 */
	public function getDelegations(): Collection
         	{
         		return $this->delegations;
         	}

	public function addDelegation(Delegation $delegation): self
         	{
         		if( ! $this->delegations->contains($delegation))
         		{
         			$this->delegations[] = $delegation;
         			$delegation->setWorkshop($this);
         		}
         
         		return $this;
         	}

	public function removeDelegation(Delegation $delegation): self
         	{
         		if($this->delegations->contains($delegation))
         		{
         			$this->delegations->removeElement($delegation);
         			// set the owning side to null (unless already changed)
         			if($delegation->getWorkshop() === $this)
         			{
         				$delegation->setWorkshop(null);
         			}
         		}
         
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

}