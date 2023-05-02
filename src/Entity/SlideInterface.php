<?php
declare(strict_types=1);

namespace Black\SyliusBannerPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\File\File;

interface SlideInterface extends ResourceInterface
{
   
    public function setBanner(?BannerInterface $banner): void;

    public function getBanner(): ?BannerInterface;
}
