<?php


namespace App\Repositories;


use App\Entities\FormEntity;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\UnauthorizedException;
use App\Exceptions\Api\UnprocessableEntityException;
use App\Models\Form;
use App\Models\Question;
use App\Models\User;
use App\Repositories\Contracts\AbstractFormRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $user = $this->userModel->find($formEntity->getUserId());

        if (empty($user)) {
            throw new UnprocessableEntityException(__('api.error_create_form_user_not_found'));
        }

        $startPublishDate = $formEntity->getStartPublish();
        $endPublishDate = $formEntity->getEndPublish();

        if (!empty($startPublishDate)) {
            if ($startPublishDate->lessThan(Carbon::today())) {
                throw new UnprocessableEntityException(__('api.error_create_form_start_date_lower_today'));
            }
        }

        if (!empty($endPublishDate)) {
            if ($endPublishDate->lessThan(Carbon::today())) {
                throw new UnprocessableEntityException(__('api.error_create_form_end_date_lower_today'));
            }

            if (!empty($startPublishDate)
                && $endPublishDate->lessThan($startPublishDate)) {
                throw new UnprocessableEntityException(__('api.error_create_form_end_date_lower_start_date'));
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

        Log::info('form_created', [
            'form_id' => $formCreated->id,
            'form_data' => $formEntity
        ]);

        return $formCreated;
    }

    /**
     * Create a form.
     *
     * @param int $formId Identifier from the form that will be updated.
     * @param FormEntity $formEntity
     * @return mixed
     * @throws UnprocessableEntityException
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function updateForm(int $formId, FormEntity $formEntity): Form
    {
        $form = $this->formModel->find($formId);

        if (empty($form)) {
            throw new NotFoundException(__('api.form_not_found'));
        }

        foreach ($form->questions as $question) {
           if ($question->usersAnswers->count() > 0) {
               throw new UnauthorizedException("It's not possible update a form with answers.");
           }
        }

        $user = User::find($formEntity->getUserId());

        if (empty($user)) {
            throw new UnprocessableEntityException(__('api.error_update_form_user_not_found'));
        }

        $startPublishDate = $formEntity->getStartPublish();
        $endPublishDate = $formEntity->getEndPublish();

        if (!empty($startPublishDate)) {
            if ($startPublishDate->lessThan(Carbon::today())) {
                throw new UnprocessableEntityException(__('api.error_update_form_start_date_lower_today'));
            }
        }

        if (!empty($endPublishDate)) {
            if ($endPublishDate->lessThan(Carbon::today())) {
                throw new UnprocessableEntityException(__('api.error_update_form_end_date_lower_today'));
            }

            if (!empty($startPublishDate)
                && $endPublishDate->lessThan($startPublishDate)) {
                throw new UnprocessableEntityException(__('api.error_update_form_end_date_lower_start_date'));
            }
        }

        DB::beginTransaction();
        $form->update([
            'user_id' => $formEntity->getUserId(),
            'name' => $formEntity->getName(),
            'description' => $formEntity->getDescription(),
            'introduction' => $formEntity->getIntroduction(),
            'start_publish' => $formEntity->getStartPublish(),
            'end_publish' => $formEntity->getEndPublish(),
        ]);

        $form->questions()->delete();

        $questionList = [];
        foreach ($formEntity->getQuestions() as $question) {
            $questionList[] = new Question([
                'description' => $question->getDescription(),
                'mandatory' => (int)$question->isMandatory(),
                'type' => $question->getType()->value(),
            ]);
        }

        $form->questions()->saveMany($questionList);
        DB::commit();

        $form->refresh();

        Log::info('form_updated', [
            'form_id' => $form->id,
            'form_data' => $formEntity
        ]);

        return $form;
    }

    /**
     * Delete a form.
     *
     * @param int $idForm Form Identifier
     * @return mixed
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function deleteForm(int $idForm)
    {
        $form = $this->formModel->find($idForm);

        if (empty($form)) {
            throw new NotFoundException(__('api.form_not_found'));
        }

        foreach ($form->questions as $question) {
            if (sizeof($question->usersAnswers) > 0) {
                throw new UnauthorizedException(__('api.error_delete_form_answered'));
            }
        }

        Log::info('form_deleted', [
            'form_id' => $idForm
        ]);

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
            throw new NotFoundException(__('api.form_not_found'));
        }

        return $form;
    }
}
