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

use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Black\SyliusBannerPlugin\Entity\SlideTranslationInterface;
use Black\SyliusBannerPlugin\Generator\SlideTranslationPathGeneratorInterface;
use Webmozart\Assert\Assert;

class SlideTranslationUploader implements SlideTranslationUploaderInterface
{
    protected Filesystem $filesystem;

    protected SlidePathGeneratorInterface $slidePathGenerator;

    public function __construct(
        Filesystem $filesystem,
        SlideTranslationPathGeneratorInterface $slideTranslationPathGenerator
    ) {
        $this->filesystem = $filesystem;
        $this->slideTranslationPathGenerator = $slideTranslationPathGenerator;
    }

    public function upload(SlideTranslationInterface $slide): void
    {
        if (!$slide->hasFile()) {
            return;
        }

        $file = $slide->getFile();
        Assert::isInstanceOf($file, File::class);

 
        if (null !== $slide->getPath() && true === $this->has($slide->getPath())) {
            $path = $slide->getPath();
            /** @phpstan-ignore-next-line  */
            Assert::notNull($path);

            $this->remove($path);
        }

        do {
            /** @psalm-suppress PossiblyNullReference $path */
            $path = $this->slideTranslationPathGenerator->generate($slide);
        } while ($this->isAdBlockingProne($path) || $this->has($path));

        $slide->setPath($path);

        $file = file_get_contents($file->getPathname());
        Assert::notFalse($file);

        $this->filesystem->write($path, $file);

    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(?string $path): bool
    {
        if (null === $path) {
            return false;
        }

        return $this->filesystem->has($path);
    }

    private function isAdBlockingProne(string $path): bool
    {
        return strpos($path, 'ad') !== false;
    }
}
