<?php

use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\UnauthorizedException;
use App\Models\Form;
use App\Models\UserAnswer;
use App\Repositories\FormRepository;
use Illuminate\Support\Collection;
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

        $formRepository->deleteForm($formId);
    }
}
