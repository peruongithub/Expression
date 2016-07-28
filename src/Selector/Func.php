<?php
/*
 * This file is part of the Trident package.
 *
 * (c) Perederko Ruslan <perederko.ruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trident\Components\Expression\Selector;

use Webmozart\Expression\Expression;
use Webmozart\Expression\Logic\AndX;
use Webmozart\Expression\Logic\OrX;
use Webmozart\Expression\Selector\Selector;

class Func extends Selector
{
    /**
     * @var string
     */
    private $funcName;

    /**
     * Creates the expression.
     *
     * @param string $funcName The function name.
     * @param \Webmozart\Expression\Expression $expr The expression to evaluate for the key.
     */
    public function __construct($funcName, Expression $expr)
    {
        $this->funcName = (string)$funcName;
        if (!function_exists($this->funcName)) {
            throw new \InvalidArgumentException(sprintf('Function "%s" not exist.', $this->funcName));
        }

        parent::__construct($expr);
    }

    /**
     * Returns the function name.
     *
     * @return string|int The array key.
     */
    public function getFuncName()
    {
        return $this->funcName;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($value)
    {
        if (!function_exists($this->funcName)) {
            return false;
        }
        $args = func_get_args();

        $result = call_user_func_array($this->funcName, $args);

        return $this->expr->evaluate($result);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        $exprString = $this->expr->toString();

        if ($this->expr instanceof AndX || $this->expr instanceof OrX) {
            return $this->funcName.'{'.$exprString.'}';
        }

        // Append "functions" with "."
        if (isset($exprString[0]) && ctype_alpha($exprString[0])) {
            return $this->funcName.'.'.$exprString;
        }

        return $this->funcName.'.('.$exprString.')';
    }
}