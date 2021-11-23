<?php

namespace App\Entity;

use App\Repository\RelationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelationsRepository::class)
 */
class Relations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Books::class, inversedBy="relations")
     */
    private $book_id;

    /**
     * @ORM\ManyToMany(targetEntity=Authors::class, inversedBy="relations")
     */
    private $author_id;

    public function __construct()
    {
        $this->book_id = new ArrayCollection();
        $this->author_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Books[]
     */
    public function getBookId(): Collection
    {
        return $this->book_id;
    }

    public function addBookId(Books $bookId): self
    {
        if (!$this->book_id->contains($bookId)) {
            $this->book_id[] = $bookId;
        }

        return $this;
    }

    public function removeBookId(Books $bookId): self
    {
        $this->book_id->removeElement($bookId);

        return $this;
    }

    /**
     * @return Collection|Authors[]
     */
    public function getAuthorId(): Collection
    {
        return $this->author_id;
    }

    public function addAuthorId(Authors $authorId): self
    {
        if (!$this->author_id->contains($authorId)) {
            $this->author_id[] = $authorId;
        }

        return $this;
    }

    public function removeAuthorId(Authors $authorId): self
    {
        $this->author_id->removeElement($authorId);

        return $this;
    }
}
