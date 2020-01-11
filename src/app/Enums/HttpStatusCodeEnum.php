<?php

namespace App\Enums;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class HttpStatusCodeEnum
 * @package App\Enums
 *
 * @method static $this OK()
 * @method static $this ACCEPTED()
 * @method static $this NO_CONTENT()
 * @method static $this NOT_FOUND()
 * @method static $this CREATED()
 * @method static $this UNAUTHORIZED()
 * @method static $this CONFLICT()
 * @method static $this UNPROCESSABLE_ENTITY()
 * @method static $this INTERNAL_SERVER_ERROR()
 * @method static $this METHOD_NOT_ALLOWED()
 * @method static $this GONE()
 * @method static $this NOT_IMPLEMENTED()
 * @method static $this LOCKED()
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class HttpStatusCodeEnum extends AbstractEnumeration
{
    /** @var int OK Sucesso no acesso ao recurso. */
    const OK = 200;

    /** @var int CREATED Recurso criado com sucesso. */
    const CREATED = 201;

    /** @var int ACCEPTED Aceito. */
    const ACCEPTED = 202;

    /** @var int NO_CONTENT Sem conteúdo. */
    const NO_CONTENT = 204;

    /** @var int BAD_REQUEST O request foi enviado em um formato inválido ou não pode ser processado pela API. */
    const BAD_REQUEST = 400;

    /** @var int UNAUTHORIZED Não autorizado. */
    const UNAUTHORIZED = 401;

    /** @var int FORBIDDEN Acesso proibido. */
    const FORBIDDEN = 403;

    /** @var int NOT_FOUND Recurso não encontrado. */
    const NOT_FOUND = 404;

    /** @var int METHOD_NOT_ALLOWED Método não permitido. */
    const METHOD_NOT_ALLOWED = 405;

    /** @var int CONFLICT Conflito na requisição. */
    const CONFLICT = 409;

    /** @var int GONE Recurso não está mais disponível. */
    const GONE = 410;

    /** @var int UNPROCESSABLE_ENTITY Entidade inválida para preocessamento */
    const UNPROCESSABLE_ENTITY = 422;

    /** @var int LOCKED Acesso ao recurso bloqueado. */
    const LOCKED = 423;

    /** @var int INTERNAL_SERVER_ERROR Erro interno de servidor. */
    const INTERNAL_SERVER_ERROR = 500;

    /** @var int NOT_IMPLEMENTED Erro, não implementado. */
    const NOT_IMPLEMENTED = 501;

    /** @var array $httpMessages Mensagens de erro http. */
    private $httpMessages = [
        self::NOT_FOUND => 'Not found.',
        self::ACCEPTED => 'Accepted.',
        self::NO_CONTENT => 'No content.',
        self::CREATED => 'Created.',
        self::BAD_REQUEST => 'Bad request.',
        self::UNAUTHORIZED => 'Unauthorized.',
        self::OK => 'Ok.',
        self::UNPROCESSABLE_ENTITY => 'Unprocessable entity.',
        self::CONFLICT => 'Conflict.',
        self::INTERNAL_SERVER_ERROR => 'Internal server error.',
        self::METHOD_NOT_ALLOWED => 'Method not allowed.',
        self::LOCKED => 'Locked.',
        self::GONE => 'Gone.',
        self::NOT_IMPLEMENTED => 'Not implemented.'
    ];

    /**
     * Retorna a mensagem de erro padrão de acordo com o código Http.
     * @return mixed
     */
    public function getMessage() : string
    {
        return $this->httpMessages[$this->value()];
    }
}
