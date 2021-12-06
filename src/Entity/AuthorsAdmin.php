<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


final class AuthorsAdmin
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity=BooksAdmin::class, mappedBy="author_admin", cascade={"persist"})
     */
    private $books_admin;

    public function __construct()
    {
        $this->books_admin = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|BooksAdmin[]
     */
    public function getBooksAdmin(): Collection
    {
        return $this->books_admin;
    }

    public function addBooksAdmin(BooksAdmin $book): self
    {
        if (!$this->books_admin->contains($book)) {
            $this->books_admin[] = $book;
            $book->addAuthorAdmin($this);
        }

        return $this;
    }

    public function removeBook(BooksAdmin $book): self
    {
        if ($this->books_admin->removeElement($book)) {
            $book->removeAuthorAdmin($this);
        }

        return $this;
    }
}