<?php
declare(strict_types=1);

namespace Black\SyliusBannerPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Banner implements BannerInterface
{


    /** @psalm-suppress PropertyNotSetInConstructor */

    private ?int $id;

    /**
     * @ORM\Column(type="boolean",nullable=false)
     */
    private ?bool $enabled;
    /**
     * @Assert\NotBlank()
     */
    private ?string $code = null;

    /**
     * @Assert\NotBlank()
     */

    private ?string $name = null;

    private ?array $devices = null;

    /**
     * @var Collection<int, ChannelInterface>
     */
    private Collection $channels;

    /**
     * @var Collection<int, SlideInterface>
     */
    private Collection $slides;

    public function __construct()
    {
        $this->channels = new ArrayCollection();
        $this->slides = new ArrayCollection();
    }


    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @inheritDoc
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    /**
     * @inheritDoc
     */
    public function getSlides(): Collection
    {
        return $this->slides;
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    public function addSlide(SlideInterface $slide): void
    {
        $this->slides->add($slide);
        $slide->setBanner($this);
    }

    public function removeSlide(SlideInterface $slide): void
    {
        if ($this->hasSlide($slide)) {
            $this->slides->removeElement($slide);
            $slide->setBanner(null);
        }
    }

    public function hasSlide(SlideInterface $slide): bool
    {
        return $this->slides->contains($slide);
    }

    public function hasSlides(): bool
    {
        return false === $this->slides->isEmpty();
    }

    public function setDevices(?array $devices)
    {
        $this->devices = $devices;
    }

    public function getDevices(): ?array
    {
        return $this->devices;
    }
}
