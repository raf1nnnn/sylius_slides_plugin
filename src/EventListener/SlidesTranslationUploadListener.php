<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the Sylius LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Black\SyliusBannerPlugin\EventListener;

use Black\SyliusBannerPlugin\Entity\SlideInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Black\SyliusBannerPlugin\Entity\BannerInterface;
use Black\SyliusBannerPlugin\Uploader\SlideTranslationUploaderInterface;
use Webmozart\Assert\Assert;

final class SlidesTranslationUploadListener
{
    private SlideTranslationUploaderInterface $uploader;

    public function __construct(SlideTranslationUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadSlidesTranslation(GenericEvent $event): void
    {
        $subject = $event->getSubject();
        Assert::isInstanceOf($subject, BannerInterface::class);

        $this->uploadSubjectSlides($subject);
    }

    private function uploadSubjectSlides(BannerInterface $subject): void
    {
        $slides = $subject->getSlides();
        // dump($slides);
        // die;
        foreach ($slides as $slide) {
            if ($slide->getTranslation("en_US")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("en_US"));
            }
            if ($slide->getTranslation("de_DE")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("de_DE"));
            }
            if ($slide->getTranslation("fr_FR")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("fr_FR"));
            }
            if ($slide->getTranslation("pl_PL")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("pl_PL"));
            }
            if ($slide->getTranslation("es_ES")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("es_ES"));
            }
            if ($slide->getTranslation("es_Mx")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("es_Mx"));
            }
            if ($slide->getTranslation("pt_PT")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("pt_PT"));
            }
            if ($slide->getTranslation("zh_CN")->hasFile()) {
                $this->uploader->upload($slide->getTranslation("zh_CN"));
            }


            // if (null === $slide->getPath()) {
            //     $slides->removeElement($slide);
            // }
        }
    }
}
