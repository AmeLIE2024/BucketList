<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    /**
     * @var Collection<int, Souhait>
     */
    #[ORM\OneToMany(targetEntity: Souhait::class, mappedBy: 'category')]
    private Collection $souhaits;

    public function __construct(){
        $this->createdAt = new \DateTimeImmutable();
        $this->souhaits = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @return Collection<int, Souhait>
     */
    public function getSouhaits(): Collection
    {
        return $this->souhaits;
    }

    public function addSouhait(Souhait $souhait): static
    {
        if (!$this->souhaits->contains($souhait)) {
            $this->souhaits->add($souhait);
            $souhait->setCategory($this);
        }

        return $this;
    }

    public function removeSouhait(Souhait $souhait): static
    {
        if ($this->souhaits->removeElement($souhait)) {
            // set the owning side to null (unless already changed)
            if ($souhait->getCategory() === $this) {
                $souhait->setCategory(null);
            }
        }

        return $this;
    }
}
