<?php

namespace App\Form;

use App\Entity\Column;
use App\Entity\User;
use App\Repository\BoardRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    private $boardRepository;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('estimate')
            ->add('status', EntityType::class, [
                'class' => Column::class,
                'choices' => $options['board']->getColumns()
            ])
            ->add('assignee', EntityType::class, [
                'class' => User::class,
                'choices' => $options['board']->getMembers()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'board' => []
        ]);
    }
}
