<?php
/*
 * This file is part of the Trident package.
 *
 * (c) Perederko Ruslan <perederko.ruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trident\Components\Expression\Tests;


use Trident\Components\Expression\Selector\Func;
use Webmozart\Expression\Constraint\GreaterThan;
use Webmozart\Expression\Constraint\LessThan;
use Webmozart\Expression\Constraint\Same;
use Webmozart\Expression\Logic\AndX;

class FunctionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionOnFailure()
    {
        new Func('S_file_exists_S', new Same(true));
    }

    public function testEvaluate()
    {
        $expr1 = new Func('file_exists', new Same(true));
        $expr2 = new Func('file_exists', new Same(false));

        $this->assertTrue($expr1->evaluate(__FILE__));
        $this->assertFalse($expr2->evaluate(__FILE__));
    }

    public function testToString()
    {
        $expr1 = new Func('file_exists', new Same(true));
        $expr2 = new Func('strlen', new GreaterThan(10));
        $expr3 = new Func(
            'strlen', new AndX(
            array(
                new GreaterThan(10),
                new LessThan(20),
            )
        )
        );

        $this->assertSame('file_exists.(===true)', $expr1->toString());
        $this->assertSame('strlen.(>10)', $expr2->toString());
        $this->assertSame('strlen{>10 && <20}', $expr3->toString());
    }
}