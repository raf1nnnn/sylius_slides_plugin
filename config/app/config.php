<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('black_banner.uploader.filesystem', 'black_sylius_banner');

    $containerConfigurator->extension('doctrine', [
        'orm' => [
            'auto_generate_proxy_classes' => '%kernel.debug%',
            'entity_managers' => [
                'default' => [
                    'auto_mapping' => true,
                    'mappings' => [
                        'BlackSyliusBannerPlugin' => [
                            'type' => 'xml',
                            'dir' => '/config/doctrine'
                        ]
                    ]
                ]
            ]
        ]
    ]);

    $containerConfigurator->extension('knp_gaufrette', [
        'adapters' => [
            'slide_translation_logo' => [
                'local' => [
                    'directory' => '%sylius_core.public_dir%/media/slide-logo',
                    'create' => true,
                ],
            ],
        ],
        'filesystems' => [
            'slide_translation_logo' => [
                'adapter' => 'slide_translation_logo',
            ],
        ],
        'stream_wrapper' => null
    ]);

    $containerConfigurator->extension('liip_imagine', [
        'loaders' => [
            'slide_translation_logo' => [
                'filesystem' => [
                    'data_root' => '%kernel.project_dir%/public/media/slider-logo',
                ],
            ],
        ],
        'filter_sets' => [
            'black_banner_logo' => [
                'data_loader' => 'slide_translation_logo',
                'filters' => [
                    'thumbnail' => [
                        'size' => [300, 300],
                        'mode' => 'outbound',
                    ],
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_grid', [
        'templates' => [
            'filter' => [
                'banner_channel' => '@BlackSyliusBannerPlugin/Admin/Grid/Filter/channel.html.twig']
        ],
        'grids' => [
            'black_sylius_banner' => [
                'driver' => [
                    'name' => 'doctrine/orm',
                    'options' => [
                        'class' => 'expr:parameter("black_sylius_banner.model.banner.class")'
                    ]
                ],
                'fields' => [
                    'code' => [
                        'type' => 'string',
                        'label' => 'sylius.ui.code'
                    ],
                    'name' => [
                        'type' => 'string',
                        'label' => 'sylius.ui.name'
                    ]

                ],
                'filters' => [
                    'code' => [
                        'label' => 'sylius.ui.code',
                        'type' => 'string'
                    ],
                    'name' => [
                        'label' => 'sylius.ui.name',
                        'type' => 'string'
                    ],
                    'channel' => [
                        'type' => 'banner_channel',
                        'label' => 'sylius.ui.channel'
                    ]
                ],
                'actions' => [
                    'main' => [
                        'create' => [
                            'type' => 'create'
                        ]
                    ],
                    'item' => [
                        'update' => [
                            'type' => 'update'
                        ],
                        'delete' => [
                            'type' => 'delete'
                        ]
                    ]
                ]
            ]
        ]
    ]);
};
