<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    const PATH_BACK = 0;
    const PATH_FRONT = 1;
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
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $remotable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="services")
     */
    private $category;

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

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRemotable(): ?bool
    {
        return $this->remotable;
    }

    public function setRemotable(bool $remotable): self
    {
        $this->remotable = $remotable;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFormattedDuration()
    {
        return date('g\hi', mktime(0, $this->duration));
    }

    public function getImages()
    {
        $images = glob($this->getImagesPath(self::PATH_BACK) . '/*.jpeg');

        foreach($images as &$image) {
            $image = basename($image);
        }

        shuffle($images);

        return $images;
    }

    public function getImagesPath($type)
    {
        if ($type == self::PATH_BACK) {
            return __DIR__ . '/../../public/assets/images/services/' . $this->getCategory()->getSlug() . '/' . $this->getSlug();
        }

        return '/assets/images/services/' . $this->getCategory()->getSlug() . '/' . $this->getSlug();
    }

    public function getParams()
    {
        return [
            'slugCategory' => $this->getCategory()->getSlug(),
            'slugService' => $this->getSlug(),
        ];
    }
}
