<?php

namespace App\Http\Controllers\Admin;

use App\Entities\FormEntity;
use App\Entities\QuestionEntity;
use App\Enums\HttpStatusCodeEnum;
use App\Enums\QuestionTypeEnum;
use App\Http\Requests\CreateFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\Form;
use App\Http\Resources\FormCollection;
use App\Repositories\Contracts\AbstractFormRepository;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class FormController
 * @package App\Http\Controllers\Admin
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class FormController extends Controller
{
    /**
     * @var AbstractFormRepository $formRepository
     */
    private $formRepository;

    /**
     * FormController constructor.
     * @param AbstractFormRepository $formRepository
     */
    public function __construct(AbstractFormRepository $formRepository)
    {
        $this->formRepository = $formRepository;
    }

    /**
     * Method resposible for create new forms.
     *
     * @param CreateFormRequest $request
     * @param Auth $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function createForm(CreateFormRequest $request, Auth $auth)
    {
        $startPublish = null;
        if (!empty($request->post('start_publish'))) {
            $startPublish = Carbon::createFromFormat('Y-m-d', $request->post('start_publish'));
        }

        $endPublish = null;
        if (!empty($request->post('end_publish'))) {
            $endPublish = Carbon::createFromFormat('Y-m-d', $request->post('end_publish'));
        }

        $formEntity = new FormEntity;
        $formEntity->setName($request->post('name'))
            ->setUserId($auth::user()->id)
            ->setDescription($request->post('description'))
            ->setIntroduction($request->post('introduction'))
            ->setStartPublish($startPublish)
            ->setEndPublish($endPublish);

        $formQuestions = [];
        foreach ($request->post('questions') as $question) {
            $formQuestions[] = (new QuestionEntity)
                ->setDescription($question['description'])
                ->setMandatory($question['mandatory'])
                ->setType(QuestionTypeEnum::memberByValue($question['type']));
        }
        $formEntity->setQuestions($formQuestions);

        $formCreated = $this->formRepository->createForm($formEntity);

        return (new Form($formCreated))
            ->response()
            ->setStatusCode(HttpStatusCodeEnum::CREATED);
    }

    /**
     * Method responsible for updating a form.
     *
     * @param int $formId Form identifier that will be updated.
     * @param UpdateFormRequest $request Object with the request data.
     * @param Auth $auth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateForm(int $formId, UpdateFormRequest $request, Auth $auth)
    {
        $startPublish = null;
        if (!empty($request->post('start_publish'))) {
            $startPublish = Carbon::createFromFormat('Y-m-d', $request->post('start_publish'));
        }

        $endPublish = null;
        if (!empty($request->post('end_publish'))) {
            $endPublish = Carbon::createFromFormat('Y-m-d', $request->post('end_publish'));
        }

        $formEntity = new FormEntity;
        $formEntity->setName($request->post('name'))
            ->setUserId($auth::user()->id)
            ->setDescription($request->post('description'))
            ->setIntroduction($request->post('introduction'))
            ->setStartPublish($startPublish)
            ->setEndPublish($endPublish);

        $formQuestions = [];
        foreach ($request->post('questions') as $question) {
            $formQuestions[] = (new QuestionEntity)
                ->setDescription($question['description'])
                ->setMandatory($question['mandatory'])
                ->setType(QuestionTypeEnum::memberByValue($question['type']));
        }
        $formEntity->setQuestions($formQuestions);

        $formUpdated = $this->formRepository->updateForm($formId, $formEntity);

        return (new Form($formUpdated))
            ->response()
            ->setStatusCode(HttpStatusCodeEnum::ACCEPTED);
    }

    /**
     * Method responsible for listing forms available.
     */
    public function listForms()
    {
        $forms = $this->formRepository->listForms();

        return new FormCollection($forms);
    }

    /**
     * Method responsible for delete a form.
     *
     * @param int $formId Identifier of the form to be deleted.
     */
    public function deleteForm(int $formId)
    {
        $this->formRepository->deleteForm($formId);

        response('', HttpStatusCodeEnum::NO_CONTENT);
    }

    /**
     * Method responsible for getting a form.
     *
     * @param int $formId Form identifier.
     * @return Form
     */
    public function getForm(int $formId)
    {
        $form = $this->formRepository->getForm($formId);

        return new Form($form);
    }
}
