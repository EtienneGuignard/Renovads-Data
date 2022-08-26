<?php

namespace App\Form;

use App\Entity\Forwarder;
use App\Entity\Leads;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForwarderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $entity = $builder->getData();

        // // Reindex collection using id
        // $indexedCollection = new ArrayCollection();
        // foreach ($entity->getBody() as $collectionItem) {
        //     $indexedCollection->set($collectionItem->getId(), $collectionItem);
        // }
    
;
        $builder
            ->add('name')
            ->add('url')
            ->add('body',  CollectionType::class, [

                'entry_type' => LeadsType::class,
                'allow_add' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forwarder::class,
        ]);
            
       
    }
}