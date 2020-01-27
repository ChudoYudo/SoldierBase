<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SoldierRepository")
 */
class Soldier
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
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $third_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MilitaryUnit", inversedBy="soldiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $military_unit;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getThirdName(): ?string
    {
        return $this->third_name;
    }

    public function setThirdName(?string $third_name): self
    {
        $this->third_name = $third_name;

        return $this;
    }

    public function getMilitaryUnit(): ?MilitaryUnit
    {
        return $this->military_unit;
    }

    public function setMilitaryUnit(?MilitaryUnit $military_unit): self
    {
        $this->military_unit = $military_unit;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthday_date;
    }

    public function setBirthdayDate(?\DateTimeInterface $birthday_date): self
    {
        $this->birthday_date = $birthday_date;

        return $this;
    }
    public function getBirthdayDateFormat($format){
        if ($this->getBirthdayDate()!==null)
        {
            return $this->getBirthdayDate()->format($format);
        } else {
            return null;
        }
    }
    
}
