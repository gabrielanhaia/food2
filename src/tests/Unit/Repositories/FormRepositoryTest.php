<?php

use App\Exceptions\Api\NotFoundException;
use App\Models\Form;
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
        $this->expectExceptionMessage("Form not found.");

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
}
