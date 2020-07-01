<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @UniqueEntity(fields={"name"}, message="name.alreadyexists")
 * @Vich\Uploadable
 */
class Category
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=40)
	 * @Assert\NotBlank
	 */
	private $name;
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $image;
	/**
	 * @Vich\UploadableField(mapping="categories_images", fileNameProperty="image")
	 * @var File
	 */
	private $imageFile;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var \DateTime
	 */
	private $updatedAt;
	/**
	 * @ORM\Column(type="string", length=1024)
	 * @Assert\NotBlank
	 * @Assert\Length(
	 * 	min = 6,
	 * 	minMessage = "length.min.6",
	 * 	max = 1024,
	 * 	maxMessage = "length.max.1024"
	 * )
	 */
	private $description;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Workshop", mappedBy="category", orphanRemoval=true)
	 */
	private $workshops;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="category", orphanRemoval=true)
	 */
	private $delegations;

	public function __construct()
	{
		$this->workshops	 = new ArrayCollection();
		$this->delegations	 = new ArrayCollection();
	}

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
	 * @return Collection|Workshops[]
	 */
	public function getWorkshops(): Collection
	{
		return $this->workshops;
	}

	public function addWorkshop(Workshop $workshop): self
	{
		if( ! $this->workshops->contains($workshop))
		{
			$this->workshops[] = $workshop;
			$workshop->setCategory($this);
		}

		return $this;
	}

	public function removeWorkshop(Workshop $workshop): self
	{
		if($this->workshops->contains($workshop))
		{
			$this->workshops->removeElement($workshop);
			// set the owning side to null (unless already changed)
			if($workshop->getCategory() === $this)
			{
				$workshop->setCategory(null);
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
			$delegation->setCategory($this);
		}

		return $this;
	}

	public function removeDelegation(Delegation $delegation): self
	{
		if($this->delegations->contains($delegation))
		{
			$this->delegations->removeElement($delegation);
			// set the owning side to null (unless already changed)
			if($delegation->getCategory() === $this)
			{
				$delegation->setCategory(null);
			}
		}

		return $this;
	}

}