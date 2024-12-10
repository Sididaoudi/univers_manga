<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types as DoctrineTypes; 
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;


#[ORM\Entity(repositoryClass: MangaRepository::class)]
#[UniqueEntity('title')]
#[Vich\Uploadable]

class Manga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("manga:read")]
    private ?int $id = null;

    #[ORM\Column(type: DoctrineTypes::TEXT)]
    #[Groups("manga:read")] 
    private ?string $title = null;

    #[ORM\Column(type: DoctrineTypes::TEXT)]
    #[Groups("manga:read")] 
    private ?string $synopsis = null;


    #[ORM\Column(type: DoctrineTypes::DATE_MUTABLE)]
    #[Groups("manga:read")]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Groups("manga:read")]
    private ?string $originalName = null;

    #[ORM\Column]
    #[Groups("manga:read")]
    private ?int $numberPages = null;

    #[ORM\Column(length: 255)]
    #[Groups("manga:read")]
    private ?string $thumbnail = null;

    #[Vich\UploadableField(mapping: 'manga', fileNameProperty: 'thumbnail')]
    #[Assert\Image()]
    private ?File $thumbnailFile = null;

    /**
     * @var Collection<int, Mangaka>
     */
    #[ORM\ManyToMany(targetEntity: Mangaka::class, inversedBy: 'mangas')]
    #[Groups("manga:read")]
    private Collection $mangakas;

    #[ORM\ManyToOne(inversedBy: 'mangas')]
    #[Groups("manga:read")]
    private ?Types $typeManga = null;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'mangas')]
    #[Groups("manga:read")]
   // Limite la profondeur de sérialisation pour éviter les boucles infinies
    private Collection $genre;

    public function __construct()
    {
        $this->mangakas = new ArrayCollection();
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }
    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getNumberPages(): ?int
    {
        return $this->numberPages;
    }

    public function setNumberPages(int $numberPages): static
    {
        $this->numberPages = $numberPages;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile(?File $thumbnailFile = null): self
    {
        $this->thumbnailFile = $thumbnailFile;
        return $this;
    }



    /**
     * @return Collection<int, Mangaka>
     */
    public function getMangakas(): Collection
    {
        return $this->mangakas;
    }

    public function addMangaka(Mangaka $mangaka): static
    {
        if (!$this->mangakas->contains($mangaka)) {
            $mangaka->addManga($this);
        }

        return $this;
    }

    public function removeMangaka(Mangaka $mangaka): static
    {
        if ($this->mangakas->removeElement($mangaka)) {
            // Assurez-vous que Mangaka a une méthode pour retirer Manga
            $mangaka->removeManga($this); // Retirez l'inverse
        }

        return $this;
    }

    public function getTypeManga(): ?Types
    {
        return $this->typeManga;
    }

    public function setTypeManga(?Types $typeManga): static
    {
        $this->typeManga = $typeManga;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    

   
}
