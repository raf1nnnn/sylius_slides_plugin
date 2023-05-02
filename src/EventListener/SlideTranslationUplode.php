<?php

namespace Black\SyliusBannerPlugin\EventListener;


use Black\SyliusBannerPlugin\Entity\Banner;
use Black\SyliusBannerPlugin\Entity\SlideTranslationInterface;
use Gaufrette\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;

class SlideTranslationUplode
{
    private FilesystemInterface $filesystem;

    public function __construct(
        FilesystemInterface $filesystem
    )
    {
        $this->filesystem = $filesystem;
    }

    public function upload(Banner $banner): void
    {
        foreach ($banner->getSlides() as $slide) {
            foreach ($slide->getTranslations() as $socialMedia) {
                if ($socialMedia->getLogoFile() === null) {
                    continue;
                } else {
                    /** @var File $file */
                    $file = $socialMedia->getLogoFile();

                    if (null !== $socialMedia->getLogoName() && $this->has($socialMedia->getLogoName())) {
                        $this->remove($socialMedia->getLogoName());
                    }

                    do {
                        $path = $this->name($file);
                    } while ($this->isAdBlockingProne($path) || $this->filesystem->has($path));

                    $socialMedia->setLogoName($path);

                    if ($socialMedia->getLogoName() === null) {
                        continue;
                    }

                    if (file_get_contents($file->getPathname()) === false) {
                        continue;
                    }

                    $this->filesystem->write(
                        $socialMedia->getLogoName(),
                        file_get_contents($file->getPathname()),
                        true
                    );
                }
            }
        }


    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(string $path): bool
    {
        if($path == null){
            return false;
        }
        return $this->filesystem->has($path);
    }

    private function name(File $file): string
    {
        $name = \str_replace('.', '', \uniqid('', true));
        $extension = $file->guessExtension();

        if (\is_string($extension) && '' !== $extension) {
            $name = \sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }

    private function isAdBlockingProne(string $path): bool
    {
        return strpos($path, 'ad') !== false;
    }
}
