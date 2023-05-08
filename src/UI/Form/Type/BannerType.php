<?php
declare(strict_types=1);

namespace Black\SyliusBannerPlugin\UI\Form\Type;

use Black\SyliusBannerPlugin\Entity\BannerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;


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
                'multiple' => true,
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form): array {
                /** @var BannerInterface|null $productHighlight */
                $banner = $form->getData();
                if($banner->getCode() == null){
                    $form->get('code')->addError(new FormError('Code ne doit pas etre vide'));

                }
                if($banner->getName() == null){
                    $form->get('name')->addError(new FormError('Name ne doit pas etre vide'));

                }
                if($banner->getDevices() == null){
                    $form->get('devices')->addError(new FormError('Types de devices ne doit pas etre vide'));

                }
                $possibleSuffixes = array("-Desktop", "-Mobile", "-Tablette");
                $endsWithPossibleSuffix = false;
                if ($banner->getCode()) {
                    foreach ($possibleSuffixes as $suffix) {
                        if (substr($banner->getCode(), -strlen($suffix)) === $suffix) {
                            $endsWithPossibleSuffix = true;
                            break;
                        }
                    }
                    if ($endsWithPossibleSuffix == false) {
                        $form->get('code')->addError(new FormError('Corriger le code doit se terminer avec "-(Desktop,Mobile,Tablette)"'));
                    }
                }
                foreach ($banner->getSlides() as $slide) {
                    foreach ($slide->getTranslations() as $translation) {
                        if ( $translation->getLogoFile() == null && $translation->getLogoName() == null ) {
                            $form->get('slides')->addError(new FormError('Image dans translation est vide"'));

                        }
                    }
                }
                return array_merge($this->validationGroups, ['black_banner']);
            }
        ]);

    }
}
