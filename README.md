# syliusbannerplugin
This plugin is used to add the banner to a sylius project 

## Installation

1. Install [Sylius](https://docs.sylius.com/en/latest/book/installation/installation.html)
2.  Import the configuration

```yaml
# config/packages/sylius_banner.yaml
imports:
    - { resource: "@BlackSyliusBannerPlugin/config/app/config.php" }
```

3. Import routing

```yaml
# config/routes/sylius_banner.yaml
black_sylius_banner_shop:
    resource: "@BlackSyliusBannerPlugin/config/routes/shop.yaml"

black_sylius_banner_admin:
    resource: "@BlackSyliusBannerPlugin/config/routes/admin.yaml"
    prefix: '/%sylius_admin.path_name%'

black_sylius_banner_api:
    resource: "@BlackSyliusBannerPlugin/config/routes/api.yaml"
    
```

4. Register the bundle:

```php
<?php

// config/bundles.php

return [
    // ...
    Black\SyliusBannerPlugin\BlackSyliusBannerPlugin::class => ['all' => true],
];
```

5. Add the bundle and dependencies in your `composer.json`

`composer require black/sylius-banner-plugin:^1.0.0@dev`

6.Add the bundle FOSCKeditor


`composer require friendsofsymfony/ckeditor-bundle`
 
7. Add this files to your project  

```xml
<!-- config/api_platform/Banner.xml -->
<?xml version="1.0" ?>

<resources xmlns="https://api-platform.com/schema/metadata"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="https://api-platform.com/schema/metadata https://api-platform.com/schema/metadata/metadata-2.0.xsd"
>
    <resource class="Black\SyliusBannerPlugin\Entity\Banner" shortName="Banner">
        <attribute name="validation_groups">banner</attribute>

        <collectionOperations>
            <collectionOperation name="admin_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/admin/banners</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">admin:banner:read</attribute>
                </attribute>
            </collectionOperation>

            <collectionOperation name="admin_post">
                <attribute name="method">POST</attribute>
                <attribute name="path">/admin/banners</attribute>
                <attribute name="denormalization_context">
                    <attribute name="groups">admin:banner:create</attribute>
                </attribute>
            </collectionOperation>



            <collectionOperation name="shop_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/shop/banners</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">shop:banner:read</attribute>
                </attribute>
            </collectionOperation>
        </collectionOperations>

        <itemOperations>
            <itemOperation name="admin_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/admin/banner/{code}</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">admin:banner:read</attribute>
                </attribute>
            </itemOperation>

            <itemOperation name="admin_put">
                <attribute name="method">PUT</attribute>
                <attribute name="path">/admin/banner/{code}</attribute>
                <attribute name="denormalization_context">
                    <attribute name="groups">admin:banner:update</attribute>
                </attribute>
            </itemOperation>

            <itemOperation name="admin_delete">
                <attribute name="method">DELETE</attribute>
                <attribute name="path">/admin/banner/{code}</attribute>
            </itemOperation>

            <itemOperation name="shop_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/shop/banner/{code}</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">shop:banner:read</attribute>
                </attribute>
            </itemOperation>
        </itemOperations>

        <property name="id" identifier="false" writable="false"/>
        <property name="code" identifier="true" readable="true" writable="true"/>
        <property name="enabled" readable="true" writable="true"/>

        <property name="slides">
            <attribute name="openapi_context">
                <attribute name="type">object</attribute>
                    <attribute name="example">
                        <attribute name="id">string</attribute>
                        <attribute name="path">string</attribute>
                        <attribute name="translations" >
                            <attribute name="example">
                                <attribute name="en_US">
                                    <attribute name="locale">string</attribute>
                                </attribute>
                            </attribute>               
                        </attribute>                     
                    </attribute>                        
            </attribute>
        </property>
    </resource>
</resources>```

```xml
<!-- config /api_paltform/Slide.xml -->
<?xml version="1.0" ?>

<resources xmlns="https://api-platform.com/schema/metadata"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="https://api-platform.com/schema/metadata https://api-platform.com/schema/metadata/metadata-2.0.xsd"
>
    <resource class="Black\SyliusBannerPlugin\Entity\Slide" shortName="slide">
        <attribute name="validation_groups">banner</attribute>

        <collectionOperations>

            <collectionOperation name="admin_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/admin/slides</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">admin:banner:read</attribute>
                </attribute>
            </collectionOperation>

            <!-- <collectionOperation name="admin_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/admin/sliders/{id}/name</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">admin:slider:read</attribute>
                </attribute>
            </collectionOperation> -->

  

            <collectionOperation name="admin_post">
                <attribute name="method">POST</attribute>
                <attribute name="path">/admin/slides</attribute>
                <attribute name="denormalization_context">
                    <attribute name="groups">admin:banner:create</attribute>
                </attribute>
            </collectionOperation>



            <collectionOperation name="shop_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/shop/slides</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">shop:banner:read</attribute>
                </attribute>
            </collectionOperation>
        </collectionOperations>

        <itemOperations>
            <itemOperation name="admin_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/admin/slide/{id}</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">admin:banner:read</attribute>
                </attribute>
            </itemOperation>

            <itemOperation name="admin_put">
                <attribute name="method">PUT</attribute>
                <attribute name="path">/admin/slide/{id}</attribute>
                <attribute name="denormalization_context">
                    <attribute name="groups">admin:banner:update</attribute>
                </attribute>
            </itemOperation>

            <itemOperation name="admin_delete">
                <attribute name="method">DELETE</attribute>
                <attribute name="path">/admin/slide/{id}</attribute>
            </itemOperation>

            <itemOperation name="shop_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/shop/slide/{id}</attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">shop:banner:read</attribute>
                </attribute>
            </itemOperation>
        </itemOperations>

        <property name="id" identifier="false" writable="false"/>
        <property name="code" identifier="true" required="true"/>
        <property name="enabled" readable="true" writable="true"/>
        <property name="translations" required="true">
            <attribute name="openapi_context">
                <attribute name="type">object</attribute>
                <attribute name="example">
                    <attribute name="en_US">
                        <attribute name="locale">string</attribute>
                    </attribute>
                </attribute>
            </attribute>
        </property>
        <property name="channels" required="false"/>
        <property name="createdAt" writable="false"/>
        <property name="updatedAt" writable="false"/>
    </resource>
</resources>```


```xml
<!-- config/api_paltform/SlideTranslation.xml -->
<?xml version="1.0" ?>

<resources xmlns="https://api-platform.com/schema/metadata"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="https://api-platform.com/schema/metadata https://api-platform.com/schema/metadata/metadata-2.0.xsd"
>
    <resource class="Black\SyliusBannerPlugin\Entity\SlideTranslation" shortName="SlideTranslation">
        <attribute name="validation_groups">Banner</attribute>

        <collectionOperations />

        <itemOperations>
            <itemOperation name="admin_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/admin/slide-translations/{id}</attribute>
            </itemOperation>
            <itemOperation name="shop_get">
                <attribute name="method">GET</attribute>
                <attribute name="path">/shop/slide-translations/{id}</attribute>
            </itemOperation>
        </itemOperations>

        <property name="id" identifier="true" writable="false"/>
        <property name="locale" required="true"/>
    </resource>
</resources>```

8.add this files to your project 

```xml
<!-- config/serialization/Banner.xml -->
<?xml version="1.0" ?>
<?xml version="1.0" ?>

<serializer xmlns="http://symfony.com/schema/dic/serializer-mapping"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://symfony.com/schema/dic/serializer-mapping https://symfony.com/schema/dic/serializer-mapping/serializer-mapping-1.0.xsd"
>
    <class name="Black\SyliusBannerPlugin\Entity\Banner">
        <attribute name="name">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="id">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="code">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="enabled">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="slides">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>


    </class>
</serializer>
```

```xml
<!-- config/serialization/Slide.xml -->
<?xml version="1.0" ?>

<serializer xmlns="http://symfony.com/schema/dic/serializer-mapping"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://symfony.com/schema/dic/serializer-mapping https://symfony.com/schema/dic/serializer-mapping/serializer-mapping-1.0.xsd"
>
    <class name="Black\SyliusBannerPlugin\Entity\Slide">
        <attribute name="id">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>

        <attribute name="translations">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
    </class>
</serializer>
```


```xml
<!-- config/serialization/SlideTranslation.xml -->
<?xml version="1.0" ?>

<serializer xmlns="http://symfony.com/schema/dic/serializer-mapping"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://symfony.com/schema/dic/serializer-mapping https://symfony.com/schema/dic/serializer-mapping/serializer-mapping-1.0.xsd"
>
    <class name="Black\SyliusBannerPlugin\Entity\SlideTranslation">
        <attribute name="id">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="content">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="link">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
        <attribute name="path">
            <group>admin:banner:read</group>
            <group>shop:banner:read</group>
        </attribute>
    </class>
</serializer>
```
9. Execute migration

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```
