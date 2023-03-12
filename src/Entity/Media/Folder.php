<?php

namespace App\Entity\Media;

use App\Repository\Media\FolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Sluggable\Handler\InversedRelativeSlugHandler;
use Gedmo\Sluggable\Handler\RelativeSlugHandler;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childFolders')]
    private ?self $parent = null;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    #[Gedmo\Slug(fields:['name'], updatable: true, unique: true)]
    #[Gedmo\SlugHandler(class: RelativeSlugHandler::class, options: [
        'relationField' => 'parent',
        'relationSlugField' => 'slug',
        'separator' => '/',
    ])]
    #[Gedmo\SlugHandler(class: InversedRelativeSlugHandler::class, options: [
        'relationClass' => Folder::class,
        'mappedBy' => 'parent',
        'inverseSlugField' => 'slug',
    ])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $childFolders;

    #[ORM\OneToMany(mappedBy: 'folder', targetEntity: File::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $files;

    #[ORM\Column(length: 7, nullable: true)]
    #[Assert\CssColor([Assert\CssColor::HEX_LONG, Assert\CssColor::HEX_SHORT])]
    private ?string $color = null;

    public function __construct()
    {
        $this->childFolders = new ArrayCollection();
        $this->files        = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

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

    /**
     * @return Collection<int, self>
     */
    public function getChildFolders(): Collection
    {
        return $this->childFolders;
    }

    public function addChildFolder(self $child): self
    {
        if (!$this->childFolders->contains($child)) {
            $this->childFolders->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChildFolder(self $child): self
    {
        if ($this->childFolders->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setFolder($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getFolder() === $this) {
                $file->setFolder(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
