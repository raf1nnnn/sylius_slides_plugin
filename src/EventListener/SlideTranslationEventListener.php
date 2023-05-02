<?php

namespace Black\SyliusBannerPlugin\EventListener;

use Black\SyliusBannerPlugin\Entity\Banner;
use Black\SyliusBannerPlugin\Entity\SlideTranslation;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;
class SlideTranslationEventListener
{
    private SlideTranslationUplode $uploader;

    public function __construct(SlideTranslationUplode $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadLogo(GenericEvent $event): void
    {
        $banner = $event->getSubject();
        Assert::isInstanceOf($banner, Banner::class);

        $this->uploader->upload($banner);
    }
}
