<?php


namespace App\Entities;

use App\Enums\QuestionTypeEnum;

/**
 * Class QuestionEntity
 * @package App\Entities
 */
class QuestionEntity
{
    /** @var integer $id */
    protected $id;

    /** @var integer $formId */
    protected $formId;

    /** @var string $description */
    protected $description;

    /** @var boolean $mandatory  */
    protected $mandatory;

    /** @var QuestionTypeEnum $type */
    protected $type;

    /** @var Carbon|null $endPublish */
    protected $createdAt;

    /** @var Carbon|null $endPublish */
    protected $updatedAt;

    /** @var Carbon|null $endPublish */
    protected $deletedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return QuestionEntity
     */
    public function setId(int $id): QuestionEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getFormId(): int
    {
        return $this->formId;
    }

    /**
     * @param int $formId
     * @return QuestionEntity
     */
    public function setFormId(int $formId): QuestionEntity
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return QuestionEntity
     */
    public function setDescription(string $description): QuestionEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMandatory(): bool
    {
        return $this->mandatory;
    }

    /**
     * @param bool $mandatory
     * @return QuestionEntity
     */
    public function setMandatory($mandatory): QuestionEntity
    {
        $mandatory = filter_var($mandatory, FILTER_VALIDATE_BOOLEAN);

        $this->mandatory = $mandatory;
        return $this;
    }

    /**
     * @return QuestionTypeEnum
     */
    public function getType(): QuestionTypeEnum
    {
        return $this->type;
    }

    /**
     * @param QuestionTypeEnum $type
     * @return QuestionEntity
     */
    public function setType(QuestionTypeEnum $type): QuestionEntity
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon|null $createdAt
     * @return QuestionEntity
     */
    public function setCreatedAt(?Carbon $createdAt): QuestionEntity
    {
        if (empty($createdAt)) {
            return $this;
        }

        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param Carbon|null $updatedAt
     * @return QuestionEntity
     */
    public function setUpdatedAt(?Carbon $updatedAt): QuestionEntity
    {
        if (empty($updatedAt)) {
            return $this;
        }

        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getDeletedAt(): ?Carbon
    {
        return $this->deletedAt;
    }

    /**
     * @param Carbon|null $deletedAt
     * @return QuestionEntity
     */
    public function setDeletedAt(?Carbon $deletedAt): QuestionEntity
    {
        if (empty($deletedAt)) {
            return $this;
        }

        $this->deletedAt = $deletedAt;
        return $this;
    }
}
