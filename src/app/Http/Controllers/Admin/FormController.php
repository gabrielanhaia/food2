<?php

namespace App\Http\Controllers\Admin;

use App\Entities\FormEntity;
use App\Entities\QuestionEntity;
use App\Enums\HttpStatusCodeEnum;
use App\Enums\QuestionTypeEnum;
use App\Http\Requests\CreateFormRequest;
use App\Http\Resources\Form;
use App\Repositories\Contracts\AbstractFormRepository;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function createForm(CreateFormRequest $request)
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
            ->setUserId($request->post('user_id'))
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
}
