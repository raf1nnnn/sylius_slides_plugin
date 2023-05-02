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

namespace Black\SyliusBannerPlugin\Uploader;

use Black\SyliusBannerPlugin\Entity\SlideTranslationInterface;

interface SlideTranslationUploaderInterface
{
    public function upload(SlideTranslationInterface $slide): void;

    public function remove(string $path): bool;
}