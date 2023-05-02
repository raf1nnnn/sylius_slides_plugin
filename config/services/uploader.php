<?php

declare(strict_types=1);

use Black\SyliusBannerPlugin\EventListener\SlideTranslationUplode;
use Dotit\SyliusAppearancePlugin\Uploader\SocialMediaUploader;
use Gaufrette\Filesystem;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->set('black_sylius_banner.filesystem.slide_translation_logo', Filesystem::class)
        ->args([
            'slide_translation_logo'
        ])
        ->factory([
            service('knp_gaufrette.filesystem_map'),
            'get'
        ]);

    $services
        ->set('black_sylius_banner.uploader.slide_translation_logo', SlideTranslationUplode::class)
        ->args([
            service('black_sylius_banner.filesystem.slide_translation_logo')
        ]);
};
