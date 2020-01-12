<?php


namespace App\Entities;

/**
 * Class AnswerEntity
 * @package App\Entities
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class AnswerEntity
{
    /** @var integer $id Answer identifier on database. */
    protected $id;

    /** @var integer $questionId Question identifier related to the answer. */
    protected $questionId;

    /** @var string $validValue Value for the answer. */
    protected $validValue;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AnswerEntity
     */
    public function setId(int $id): AnswerEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    /**
     * @param int $questionId
     * @return AnswerEntity
     */
    public function setQuestionId(int $questionId): AnswerEntity
    {
        $this->questionId = $questionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidValue(): string
    {
        return $this->validValue;
    }

    /**
     * @param string $validValue
     * @return AnswerEntity
     */
    public function setValidValue(string $validValue): AnswerEntity
    {
        $this->validValue = $validValue;
        return $this;
    }
}
