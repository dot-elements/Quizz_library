<?php

namespace App\Form;

use App\Entity\QuizVersion;
use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizVersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('questions', EntityType::class, [
            'class' => Question::class,
            'choice_label' => fn (Question $q) => $q->getText(),
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,

            // Group by category for "By Category" view
            'group_by' => function (Question $q) {
                return $q->getCategory() ? $q->getCategory()->getName() : 'Uncategorized';
            },

            // Always fetch consistently ordered list
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('q')
                    ->leftJoin('q.category', 'c')
                    ->addSelect('c')
                    ->orderBy('q.text', 'ASC');
            },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizVersion::class,
        ]);
    }
}
