<?php


namespace App\Repositories\Contracts;

use App\Entities\FormEntity;
use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Interface FormRepositoryInterface
 * @package App\Repositories\Contracts
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
abstract class AbstractFormRepository
{
    /** @var Form $formModel Model of forms. */
    protected $formModel;

    /** @var User $userModel Model of users. */
    protected $userModel;

    /**
     * AbstractFormRepository constructor.
     */
    public function __construct()
    {
        $this->formModel = new Form;
        $this->userModel = new User;
    }

    /**
     * Create a form.
     *
     * @param FormEntity $formEntity
     * @return mixed
     */
    public abstract function createForm(FormEntity $formEntity);

    /**
     * Create a form.
     *
     * @param int $formId Identifier from the form that will be updated.
     * @param FormEntity $formEntity
     * @return mixed
     */
    public abstract function updateForm(int $formId, FormEntity $formEntity): Form;

    /**
     * Delete a form.
     *
     * @param int $idForm Form Identifier
     * @return mixed
     */
    public abstract function deleteForm(int $idForm);

    /**
     * List forms.
     *
     * @return Collection|null
     */
    public abstract function listForms();

    /**
     * Get one form through its id.
     *
     * @param int $idForm Form identifier.
     * @return Form
     */
    public abstract function getForm(int $idForm): Form;

    /**
     * @return Form
     */
    public function getFormModel(): Form
    {
        return $this->formModel;
    }

    /**
     * @param Form $formModel
     * @return AbstractFormRepository
     */
    public function setFormModel(Form $formModel): AbstractFormRepository
    {
        $this->formModel = $formModel;
        return $this;
    }

    /**
     * @return User
     */
    public function getUserModel(): User
    {
        return $this->userModel;
    }

    /**
     * @param User $userModel
     * @return AbstractFormRepository
     */
    public function setUserModel(User $userModel): AbstractFormRepository
    {
        $this->userModel = $userModel;
        return $this;
    }
}
