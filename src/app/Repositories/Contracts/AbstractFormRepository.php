<?php


namespace App\Repositories\Contracts;

use App\Entities\FormEntity;
use App\Models\Form;
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

    /**
     * AbstractFormRepository constructor.
     */
    public function __construct()
    {
        $this->formModel = new Form;
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
     * @param FormEntity $formEntity
     * @return mixed
     */
    public abstract function updateForm(FormEntity $formEntity): Form;

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
}
