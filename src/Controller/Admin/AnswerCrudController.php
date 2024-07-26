<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Answer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail()->onlyOnIndex(),
            TextareaField::new('content'),
            AssociationField::new('question')
            ->setCrudController(QuestionCrudController::class)
            ->setFormTypeOption('choice_label','title'),
        ];
    }

    public function createEntity(string $entityFqcn): Answer
    {
        $answer = new Answer();
        $answer->setAuthor($this->getUser());

        return $answer;
    }

}
