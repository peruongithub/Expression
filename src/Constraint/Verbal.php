<?php
/*
 * This file is part of the Trident package.
 *
 * (c) Perederko Ruslan <perederko.ruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trident\Components\Expression\Constraint;

use VerbalExpressions\PHPVerbalExpressions\VerbalExpressions;
use Webmozart\Expression\Expression;
use Webmozart\Expression\Logic\Literal;
use Webmozart\Expression\Util\StringUtil;

/**
 * Class Verbal
 * @see https://github.com/VerbalExpressions/PHPVerbalExpressions
 * @package Trident\Components\Expression\Constraint
 */
class Verbal extends Literal
{
    /**
     * @var $verbal VerbalExpressions
     */
    protected $verbal;

    /**
     * Creates the expression.
     *
     * @param $verbalExp VerbalExpressions
     */
    public function __construct(VerbalExpressions $verbalExp)
    {
        $this->verbal = $verbalExp;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($value)
    {
        return (bool)$this->verbal->test($value);
    }

    /**
     * {@inheritdoc}
     */
    public function equivalentTo(Expression $other)
    {
        // Since this class is final, we can check with instanceof
        return $other instanceof $this && $this->verbal === $other->verbal;
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'matches('.StringUtil::formatValue($this->getRegex()).')';
    }

    /**
     * Returns the regular expression.
     *
     * @return mixed The regular expression.
     */
    public function getRegex()
    {
        return $this->verbal->getRegex();
    }
}