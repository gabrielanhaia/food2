<?php


namespace App\Repositories;


use App\Entities\FormEntity;
use App\Exceptions\Api\UnprocessableEntityException;
use App\Models\Form;
use App\Models\User;
use App\Repositories\Contracts\AbstractFormRepository;
use Illuminate\Support\Collection;

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

        $formCreated = $this->formModel::create([
            'user_id' => $formEntity->getUserId(),
            'name' => $formEntity->getName(),
            'description' => $formEntity->getDescription(),
            'introduction' => $formEntity->getIntroduction(),
            'start_publish' => $formEntity->getStartPublish(),
            'end_publish' => $formEntity->getEndPublish(),
        ]);

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
     */
    public function deleteForm(int $idForm)
    {
        // TODO: Implement deleteForm() method.
    }

    /**
     * List forms.
     *
     * @return Collection|null
     */
    public function listForms()
    {
        // TODO: Implement listForms() method.
    }

    /**
     * Get one form through its id.
     *
     * @param int $idForm Form identifier.
     * @return Form
     */
    public function getForm(int $idForm): Form
    {
        // TODO: Implement getForm() method.
    }
}
