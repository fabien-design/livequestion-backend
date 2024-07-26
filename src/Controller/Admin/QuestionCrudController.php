<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Question;
use App\Field\VichImageField;
use App\Form\ImageType;
use App\Repository\CategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Vich\UploaderBundle\Form\Type\VichImageType;

class QuestionCrudController extends AbstractCrudController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail()->onlyOnIndex(),
            TextField::new('title'),
            AssociationField::new('category')
                ->setCrudController(CategoryCrudController::class)
                ->setFormTypeOption('choice_label', 'name'),
            VichImageField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setLabel('Image')
                ->hideOnDetail()
                ->hideOnIndex(),
            ImageField::new('images.name')
                ->hideOnForm()
                ->setLabel('Image')
                ->setBasePath('/images/questions'),

            DateField::new("created_at")->onlyOnDetail()->onlyOnIndex(),
        ];
    }

    public function createEntity(string $entityFqcn): Question
    {
        $question = new Question();
        $question->setAuthor($this->getUser());

        return $question;
    }
    public function editEntity(string $entityFqcn, Question $question): Question
    {
        $question->setAuthor($this->getUser());
        $question->setTitle($question->getTitle());
        return $question;
    }
}
