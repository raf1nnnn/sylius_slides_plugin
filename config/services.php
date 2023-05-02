<?php

declare(strict_types=1);

use Black\SyliusBannerPlugin\Generator\SlideTranslationPathGeneratorInterface;
use Black\SyliusBannerPlugin\Generator\UploadedSlideTranslationPathGenerator;
use Black\SyliusBannerPlugin\Uploader\SlideTranslationUploader;
use Black\SyliusBannerPlugin\Uploader\SlideTranslationUploaderInterface;
use Gaufrette\Filesystem;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator
        ->import(__DIR__ . '/services/*');

    $services = $containerConfigurator->services();

    $services
        ->set('black_sylius_banner.slide_uploader.gaufrette.filesystem', Filesystem::class)
        ->args([
            '%black_banner.uploader.filesystem%'
        ])
        ->factory([
            service('knp_gaufrette.filesystem_map'), 'get'
        ]);

    // $services
    //     ->set('black_sylius_banner.slide_uploader', SlideUploader::class)
    //     ->args([
    //         service('black_sylius_banner.slide_uploader.gaufrette.filesystem'),
    //         service(SlidePathGeneratorInterface::class)
    //     ]);

    // $services
    //     ->set(SlidePathGeneratorInterface::class, UploadedSlidePathGenerator::class);

    // $services
    //     ->alias(SlideUploaderInterface::class, 'black_sylius_banner.slide_uploader');

    
    $services
        ->set('black_sylius_banner.slidetranslation_uploader', SlideTranslationUploader::class)
        ->args([
            service('black_sylius_banner.slide_uploader.gaufrette.filesystem'),
            service(SlideTranslationPathGeneratorInterface::class)
        ]);

    $services
        ->set(SlideTranslationPathGeneratorInterface::class, UploadedSlideTranslationPathGenerator::class);

    $services
        ->alias(SlideTranslationUploaderInterface::class, 'black_sylius_banner.slidetranslation_uploader');

   };
