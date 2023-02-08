<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use App\Services\SpamFinder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Runtime\Symfony\Component\Console\Output\OutputInterfaceRuntime;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Un article doit avoir un titre.')]
    private ?string $title = null;

    #[ORM\Column(length: 1000)]
    // Voir validate()
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 128)]
    private ?string $author = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $nbViews = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'articles')]
    private Collection $categories;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    #[Gedmo\Slug(fields: ['title', 'author', 'createdAt'])]
    private ?string $slug = null;

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        if(strcmp($this->title, $this->content) == 0)
        {
            $context->buildViolation('Le contenu doit etre différent du titre!')
                ->atPath('content')
                ->addViolation();
        }

        $handler = $context->getRoot()->getConfig()->getRequestHandler();
        $handlerRef = new \ReflectionObject($handler);
        $serverParamsRefProp = $handlerRef->getProperty('serverParams');
        $serverParamsRefProp->setAccessible(true);
        $serverParamsVal = $serverParamsRefProp->getValue($handler);
        $serverParamsRef = new \ReflectionObject($serverParamsVal);
        $stackRefProp = $serverParamsRef->getProperty('requestStack');
        $stackRefProp->setAccessible(true);
        $stack = $stackRefProp->getValue($serverParamsVal);

        $verbosityLevelMap = [
            LogLevel::NOTICE => ConsoleOutput::VERBOSITY_NORMAL,
            LogLevel::INFO   => ConsoleOutput::VERBOSITY_NORMAL,
        ];
        $finder = new SpamFinder(new ConsoleLogger(new ConsoleOutput(), $verbosityLevelMap), $stack);
        if($finder->isSpam($this->content))
        {
            $context->buildViolation('Le contenu a été détecter comme du spam !')
                ->atPath('content')
                ->addViolation();
        }
    }

    #[ORM\PrePersist]
    public function nullAuthorVerif() : void
    {
        if(is_null($this->getAuthor()))
        {
            $this->setAuthor("anonimous");
        }
    }

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getNbViews(): ?int
    {
        return $this->nbViews;
    }

    public function setNbViews(int $nbViews): self
    {
        $this->nbViews = $nbViews;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

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
}
