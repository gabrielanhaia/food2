<?php


namespace App\Repositories;


use App\Entities\FormEntity;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\UnprocessableEntityException;
use App\Models\Form;
use App\Models\Question;
use App\Models\User;
use App\Repositories\Contracts\AbstractFormRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class FormRepository
 * @package App\Repositories
 */
class FormRepository extends AbstractFormRepository
{
    /**
     * Create a form.
     *
     * @param FormEntity $formEntity
     * @return mixed
     * @throws UnprocessableEntityException
     */
    public function createForm(FormEntity $formEntity)
    {
        $user = User::find($formEntity->getUserId());

        if (empty($user)) {
            throw new UnprocessableEntityException('User not found.');
        }

        $startPublishDate = $formEntity->getStartPublish();
        $endPublishDate = $formEntity->getEndPublish();

        if (!empty($startPublishDate)) {
            if ($startPublishDate->lessThan(Carbon::today())) {
                throw new UnprocessableEntityException('The start publish date must be greather or equeals than today.');
            }
        }

        if (!empty($endPublishDate)) {
            if ($endPublishDate->lessThan(Carbon::today())) {
                throw new UnprocessableEntityException('The end publish date must be greather or equeals than today.');
            }

            if (!empty($startPublishDate)
                && $endPublishDate->lessThan($startPublishDate)) {
                throw new UnprocessableEntityException('The end publish date can\'t be before publish start date.');
            }
        }

        DB::beginTransaction();
        $formCreated = $this->formModel::create([
            'user_id' => $formEntity->getUserId(),
            'name' => $formEntity->getName(),
            'description' => $formEntity->getDescription(),
            'introduction' => $formEntity->getIntroduction(),
            'start_publish' => $formEntity->getStartPublish(),
            'end_publish' => $formEntity->getEndPublish(),
        ]);

        $questionList = [];
        foreach ($formEntity->getQuestions() as $question) {
            $questionList[] = new Question([
                'description' => $question->getDescription(),
                'mandatory' => (int)$question->isMandatory(),
                'type' => $question->getType()->value(),
            ]);
        }

        $formCreated->questions()->saveMany($questionList);
        DB::commit();

        return $formCreated;
    }

    /**
     * Create a form.
     *
     * @param FormEntity $formEntity
     * @return mixed
     */
    public function updateForm(FormEntity $formEntity): Form
    {
        // TODO: Implement updateForm() method.
    }

    /**
     * Delete a form.
     *
     * @param int $idForm Form Identifier
     * @return mixed
     * @throws NotFoundException
     */
    public function deleteForm(int $idForm)
    {
        $form = $this->formModel->find($idForm);

        if (empty($form)) {
            throw new NotFoundException('Form not found.');
        }

        $form->questions()->delete();
        $form->delete();
    }

    /**
     * List forms.
     *
     * @return Collection|null
     */
    public function listForms()
    {
        $forms = $this->formModel->all();

        return $forms;
    }

    /**
     * Get one form through its id.
     *
     * @param int $idForm Form identifier.
     * @return Form
     * @throws NotFoundException
     */
    public function getForm(int $idForm): Form
    {
        $form = $this->formModel->find($idForm);

        if (empty($form)) {
            throw new NotFoundException('Form not found.');
        }

        return $form;
    }
}
