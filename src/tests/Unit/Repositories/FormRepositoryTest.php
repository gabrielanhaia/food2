<?php

use App\Entities\{FormEntity, QuestionEntity};
use App\Enums\QuestionTypeEnum;
use App\Exceptions\{Api\NotFoundException, Api\UnauthorizedException, Api\UnprocessableEntityException};
use App\Models\{Form, Question, User, UserAnswer};
use App\Repositories\V1\FormRepository;
use Carbon\Carbon;
use Illuminate\Support\{Collection, Facades\DB, Facades\Log};
use Tests\TestCase;

/**
 * Class FormRepositoryTest
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class FormRepositoryTest extends TestCase
{
    /**
     * Test error trying to get a form passing id invalid.
     */
    public function testGetFormErrorUserNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(__('api.form_not_found'));

        $formId = 123232443142;

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('find')
            ->with($formId)
            ->once()
            ->andReturnNull();

        $formRepository = new FormRepository;
        $formRepository->setFormModel($formModelMock);

        $formRepository->getForm($formId);
    }

    /**
     * Test success getting an form by id.
     */
    public function testGetFormSuccess()
    {
        $formId = 234224142124;

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('find')
            ->with($formId)
            ->once()
            ->andReturnSelf();

        $formRepository = new FormRepository;
        $formRepository->setFormModel($formModelMock);

        $result = $formRepository->getForm($formId);

        $this->assertEquals($formModelMock, $result);
    }

    /**
     * Test success listing forms.
     */
    public function testListFormsSuccess()
    {
        $expectedResult = new Collection(['AAAA', 'BBBB']);

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('all')
            ->withNoArgs()
            ->once()
            ->andReturn($expectedResult);

        $formRepository = new FormRepository;
        $formRepository->setFormModel($formModelMock);

        $result = $formRepository->listForms();

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test error trying delete a form using a invalid form id.
     */
    public function testDeleteFormErrorFormNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(__('api.form_not_found'));

        $formId = 123232443142;

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('find')
            ->with($formId)
            ->once()
            ->andReturnNull();

        $formModelMock->shouldReceive('delete')
            ->never();

        $formRepository = new FormRepository;
        $formRepository->setFormModel($formModelMock);

        $formRepository->deleteForm($formId);
    }

    /**
     * Test error trying to delete a form already answered (questions).
     *
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function testDeleteFormErrorFormQuestionsAlreadyAnswered()
    {
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage(__('api.error_delete_form_answered'));

        $formId = 123232443142;

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('find')
            ->with($formId)
            ->once()
            ->andReturnSelf();

        $formModelMock->shouldReceive('delete')
            ->never();

        $userAnswerModelMock = Mockery::mock(UserAnswer::class);
        $userAnswerModelMock->shouldReceive('getAttribute')
            ->with('usersAnswers')
            ->andReturn(['ANSWER 1']);

        $formModelMock->shouldReceive('getAttribute')
            ->with('questions')
            ->andReturn([$userAnswerModelMock]);

        $formRepository = new FormRepository;
        $formRepository->setFormModel($formModelMock);

        $formRepository->deleteForm($formId);
    }

    /**
     * Test Success deleting a form.
     */
    public function testDeleteFormSuccess()
    {
        $formId = 123232443142;

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('find')
            ->with($formId)
            ->once()
            ->andReturnSelf();

        $formModelMock->shouldReceive('getAttribute')
            ->with('questions')
            ->once()
            ->andReturn([]);

        $formModelMock->shouldReceive('questions')
            ->withNoArgs()
            ->once()
            ->andReturnSelf();

        $formModelMock->shouldReceive('delete')
            ->withNoArgs()
            ->twice()
            ->andReturnTrue();

        $formRepository = new FormRepository;
        $formRepository->setFormModel($formModelMock);

        Log::shouldReceive('info');

        $formRepository->deleteForm($formId);
    }

    /**
     * Test error trying create a new form with a author (user) id not found.
     */
    public function testCreateFormErrorAuthorIdNotFound()
    {
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage(__('api.error_create_form_user_not_found'));

        $userId = 343423423432;

        $formEntity = new FormEntity;
        $formEntity->setUserId($userId);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('find')
            ->with($userId)
            ->once()
            ->andReturnNull();

        $formRepository = new FormRepository;
        $formRepository->setUserModel($userModelMock);

        $formRepository->createForm($formEntity);
    }

    /**
     * Test error creating form with start date lower than today.
     *
     * @throws UnprocessableEntityException
     */
    public function testCreateFormErrorStartDateLowerThanToday()
    {
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage(__('api.error_create_form_start_date_lower_today'));

        $userId = 343423423432;
        $today = Carbon::create(2020, 10, 11);
        $startDate = Carbon::create(2020, 10, 10);
        $endDate = Carbon::create(2020, 10, 15);

        $formEntity = new FormEntity;
        $formEntity->setUserId($userId)
            ->setStartPublish($startDate)
            ->setEndPublish($endDate);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('find')
            ->with($userId)
            ->once()
            ->andReturnSelf();

        Carbon::setTestNow($today);

        $formRepository = new FormRepository;
        $formRepository->setUserModel($userModelMock);

        $formRepository->createForm($formEntity);
    }

    /**
     * Test error creating form with end date lower than today.
     *
     * @throws UnprocessableEntityException
     */
    public function testCreateFormErrorEndDateLowerThanToday()
    {
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage(__('api.error_create_form_end_date_lower_today'));

        $userId = 343423423432;
        $today = Carbon::create(2020, 10, 20);
        $startDate = Carbon::create(2020, 10, 21);
        $endDate = Carbon::create(2020, 9, 9);

        $formEntity = new FormEntity;
        $formEntity->setUserId($userId)
            ->setStartPublish($startDate)
            ->setEndPublish($endDate);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('find')
            ->with($userId)
            ->once()
            ->andReturnSelf();

        Carbon::setTestNow($today);

        $formRepository = new FormRepository;
        $formRepository->setUserModel($userModelMock);

        $formRepository->createForm($formEntity);
    }

    /**
     * Test error creating form with end date lower than start date.
     *
     * @throws UnprocessableEntityException
     */
    public function testCreateFormErrorEndDateLowerThanStartDate()
    {
        $this->expectException(UnprocessableEntityException::class);
        $this->expectExceptionMessage(__('api.error_create_form_end_date_lower_start_date'));

        $userId = 343423423432;
        $today = Carbon::create(2020, 10, 20);
        $startDate = Carbon::create(2020, 10, 22);
        $endDate = Carbon::create(2020, 10, 21);

        $formEntity = new FormEntity;
        $formEntity->setUserId($userId)
            ->setStartPublish($startDate)
            ->setEndPublish($endDate);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('find')
            ->with($userId)
            ->once()
            ->andReturnSelf();

        Carbon::setTestNow($today);

        $formRepository = new FormRepository;
        $formRepository->setUserModel($userModelMock);

        $formRepository->createForm($formEntity);
    }

    /**
     * Test success creating a form.
     *
     * @throws UnprocessableEntityException
     */
    public function testCreateFormSuccess()
    {
        $userId = 343423423432;
        $today = Carbon::create(2020, 10, 20);
        $startDate = Carbon::create(2020, 10, 22);
        $endDate = Carbon::create(2020, 10, 23);
        $name = 'NAME';
        $description = 'DESCRIPTION';
        $introduction = 'INTRODUCTION';

        $questionMandatory = true;
        $questionType = QuestionTypeEnum::DROPDOWN();
        $questionDescription = 'QUESTION DESCRIPTION';

        $question = new QuestionEntity;
        $question->setMandatory($questionMandatory)
            ->setType($questionType)
            ->setDescription($questionDescription);

        $formEntity = new FormEntity;
        $formEntity->setUserId($userId)
            ->setStartPublish($startDate)
            ->setEndPublish($endDate)
            ->setName($name)
            ->setDescription($description)
            ->setIntroduction($introduction)
            ->setQuestions([$question]);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('find')
            ->with($userId)
            ->once()
            ->andReturnSelf();

        Carbon::setTestNow($today);

        DB::shouldReceive('beginTransaction')
            ->once();

        $formModelMock = Mockery::mock(Form::class);
        $formModelMock->shouldReceive('create')
            ->once()
            ->with([
                'user_id' => $userId,
                'name' => $name,
                'description' => $description,
                'introduction' => $introduction,
                'start_publish' => $startDate,
                'end_publish' => $endDate
            ])
            ->andReturnSelf();

        $questionsMock = Mockery::mock(stdClass::class);
        $questionsMock->shouldReceive('save')
            ->withAnyArgs();

        $formModelMock->shouldReceive('questions')
            ->once()
            ->withNoArgs()
            ->andReturn($questionsMock);

        $formModelMock->shouldReceive('getAttribute')
            ->with('id')
            ->once();

        DB::shouldReceive('commit')
            ->once();

        $formRepository = new FormRepository;
        $formRepository->setUserModel($userModelMock)
            ->setFormModel($formModelMock);

        Log::shouldReceive('info')
            ->once();

        $result = $formRepository->createForm($formEntity);

        $this->assertEquals($formModelMock, $result);
    }
}
