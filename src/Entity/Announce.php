<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AnnounceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"announce:read","picture:read"}}
 *          },
 *     "post"
 *      },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"announce:read","picture:read"}}
 *          }
 *     })
 * @ORM\Entity(repositoryClass=AnnounceRepository::class)
 */
class Announce
{
    /**
     * @Groups({"announce:read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"announce:read"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"announce:read"})
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups({"announce:read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $postedAt;

    /**
     * @Groups({"picture:read"})
     * @ORM\OneToMany(targetEntity=Pictures::class, mappedBy="annonce", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $pictures;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeInterface $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    /**
     * @return Collection|Pictures[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Pictures $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setAnnonce($this);
        }

        return $this;
    }

    public function removePicture(Pictures $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getAnnonce() === $this) {
                $picture->setAnnonce(null);
            }
        }

        return $this;
    }
}
