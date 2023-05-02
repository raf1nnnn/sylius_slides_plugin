<?php

declare(strict_types=1);

use Black\SyliusBannerPlugin\EventListener\SlideTranslationEventListener;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->set('black_sylius_banner.event_listener.slide_translation_logo_upload', SlideTranslationEventListener::class)
        ->args([
            service('black_sylius_banner.uploader.slide_translation_logo')
        ])
        ->tag('kernel.event_listener', [
            'event' => 'black_sylius_banner.banner.pre_create',
            'method' => 'uploadLogo'
        ])
        ->tag('kernel.event_listener', [
            'event' => 'black_sylius_banner.banner.pre_update',
            'method' => 'uploadLogo'
        ]);
};
