<?php


namespace App\Entities;

use Carbon\Carbon;

/**
 * Class FormEntity
 * @package App\Entities
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class FormEntity
{
    /** @var integer $id Form identifier. */
    protected $id;

    /** @var integer $userId */
    protected $userId;

    /** @var string $name */
    protected $name;

    /** @var string $description */
    protected $description;

    /** @var string $introduction */
    protected $introduction;

    /** @var Carbon $startPublish */
    protected $startPublish;

    /** @var Carbon $endPublish */
    protected $endPublish;

    /** @var Carbon $endPublish */
    protected $createdAt;

    /** @var Carbon $endPublish */
    protected $updatedAt;

    /** @var Carbon $endPublish */
    protected $deletedAt;

    /** @var QuestionEntity[] $questions */
    protected $questions;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FormEntity
     */
    public function setId(int $id): FormEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return FormEntity
     */
    public function setUserId(int $userId): FormEntity
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FormEntity
     */
    public function setName(string $name): FormEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return FormEntity
     */
    public function setDescription(string $description = null): FormEntity
    {
        if ($description === null) {
            return $this;
        }

        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * @param string $introduction
     * @return FormEntity
     */
    public function setIntroduction(string $introduction = null): FormEntity
    {
        if ($introduction === null) {
            return $this;
        }

        $this->introduction = $introduction;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getStartPublish(): ?Carbon
    {
        return $this->startPublish;
    }

    /**
     * @param Carbon $startPublish
     * @return FormEntity
     */
    public function setStartPublish(Carbon $startPublish = null): FormEntity
    {
        if ($startPublish === null) {
            return $this;
        }

        $this->startPublish = $startPublish;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getEndPublish(): ?Carbon
    {
        return $this->endPublish;
    }

    /**
     * @param Carbon $endPublish
     * @return FormEntity
     */
    public function setEndPublish(Carbon $endPublish = null): FormEntity
    {
        if ($endPublish === null) {
            return $this;
        }

        $this->endPublish = $endPublish;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon $createdAt
     * @return FormEntity
     */
    public function setCreatedAt(Carbon $createdAt = null): FormEntity
    {
        if ($createdAt === null) {
            return $this;
        }

        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param Carbon $updatedAt
     * @return FormEntity
     */
    public function setUpdatedAt(Carbon $updatedAt= null): FormEntity
    {
        if ($updatedAt === null) {
            return $this;
        }

        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getDeletedAt(): ?Carbon
    {
        return $this->deletedAt;
    }

    /**
     * @param Carbon $deletedAt
     * @return FormEntity
     */
    public function setDeletedAt(Carbon $deletedAt = null): FormEntity
    {
        if ($deletedAt === null) {
            return $this;
        }

        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @return QuestionEntity[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param QuestionEntity[] $questions
     * @return FormEntity
     */
    public function setQuestions(array $questions): FormEntity
    {
        $this->questions = $questions;
        return $this;
    }
}
