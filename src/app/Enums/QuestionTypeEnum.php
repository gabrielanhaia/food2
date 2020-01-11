<?php

namespace App\Enums;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 *
 * @package App\Enums
 *
 * @method static $this NUMBER()
 * @method static $this TEXT()
 * @method static $this DATE()
 * @method static $this RADIO()
 * @method static $this DROPDOWN()
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class QuestionTypeEnum extends AbstractEnumeration
{
    /** @var string NUMBER Type number. */
    const NUMBER = 'number';

    /** @var string TEXT Type text. */
    const TEXT = 'text';

    /** @var string DATE Type date. */
    const DATE = 'date';

    /** @var string RADIO Type radio. */
    const RADIO = 'radio';

    /** @var string DROPDOWN Type dropdown. */
    const DROPDOWN = 'dropdown';

    /**
     * @return string
     */
    public static function formValidationString(): string
    {
        return ('in:' . self::NUMBER
            . ',' . self::TEXT
            . ',' . self::RADIO
            . ',' . self::DATE
            . ',' . self::DROPDOWN);
    }
}
