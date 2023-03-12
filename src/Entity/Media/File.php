<?php

namespace App\Entity\Media;

use App\Repository\Media\FileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[Vich\Uploadable]
class File
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?Folder $folder = null;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    #[Gedmo\Slug(fields:['fileName'], updatable: true, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $fileName = null;

    #[ORM\Column(length: 255)]
    private ?string $fileSize = null;

    #[ORM\Column(length: 255)]
    private ?string $fileMimeType = null;

    #[ORM\Column(length: 255)]
    private ?string $fileOriginalName = null;

    #[ORM\Column(nullable: true)]
    private ?array $fileDimensions = null;

    #[Vich\UploadableField(
        mapping: 'media_file',
        fileNameProperty: 'fileName',
        size: 'fileSize',
        mimeType: 'fileMimeType',
        originalName: 'fileOriginalName',
        dimensions: 'fileDimensions'
    )]
    private ?HttpFile $realFile;

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

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function setFolder(?Folder $folder): self
    {
        $this->folder = $folder;

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

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getRealFile(): ?HttpFile
    {
        return $this->realFile;
    }

    public function getFileSize(): ?string
    {
        return $this->fileSize;
    }

    public function setFileSize(?string $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileMimeType(): ?string
    {
        return $this->fileMimeType;
    }

    public function setFileMimeType(?string $fileMimeType): self
    {
        $this->fileMimeType = $fileMimeType;

        return $this;
    }

    public function getFileOriginalName(): ?string
    {
        return $this->fileOriginalName;
    }

    public function setFileOriginalName(?string $fileOriginalName): self
    {
        $this->fileOriginalName = $fileOriginalName;

        return $this;
    }

    public function getFileDimensions(): ?array
    {
        return $this->fileDimensions;
    }

    public function setFileDimensions(?array $fileDimensions): self
    {
        $this->fileDimensions = $fileDimensions;

        return $this;
    }

    public function setRealFile(?HttpFile $realFile = null): void
    {
        $this->realFile = $realFile;

        if (null !== $realFile) {
            $this->updatedAt = new \DateTime();
        }
    }
}
