<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MilitaryUnitRepository")
 */
class MilitaryUnit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Soldier", mappedBy="military_unit")
     */
    private $soldiers;

    public function __construct()
    {
        $this->soldiers = new ArrayCollection();
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

    /**
     * @return Collection|Soldier[]
     */
    public function getSoldiers(): Collection
    {
        return $this->soldiers;
    }

    public function addSoldier(Soldier $soldier): self
    {
        if (!$this->soldiers->contains($soldier)) {
            $this->soldiers[] = $soldier;
            $soldier->setMilitaryUnit($this);
        }

        return $this;
    }

    public function removeSoldier(Soldier $soldier): self
    {
        if ($this->soldiers->contains($soldier)) {
            $this->soldiers->removeElement($soldier);
            // set the owning side to null (unless already changed)
            if ($soldier->getMilitaryUnit() === $this) {
                $soldier->setMilitaryUnit(null);
            }
        }

        return $this;
    }
}
