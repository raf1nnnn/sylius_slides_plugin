<?php
declare(strict_types=1);

namespace Black\SyliusBannerPlugin\UI\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


final class BannerType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new AddCodeFormSubscriber())
            ->add('name', TextType::class, [
                'label' => 'black_sylius_banner.form.banner.name.label',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.ui.enabled',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'black_sylius_banner.form.banner.channels.label',
            ])
            ->add('devices', ChoiceType::class, [
                'label' => 'Devices',
                'multiple'=>true,
                'choices' => [
                    'Mobile' => 'Mobile',
                    'Desktop' => 'Desktop',
                    'Tablette' => 'Tablette',
                ],
            ])
            ->add('slides', CollectionType::class, [
                'entry_type' => SlideType::class,
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'black_sylius_banner.form.banner.slides.label',
                'block_name' => 'entry',
            ])
        ;
    }
}
