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


use Trident\Components\Expression\Expr;
use Trident\Components\Expression\Selector\Func;
use Webmozart\Expression\Constraint\Same;

class ExprTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $expr1 = new Func('file_exists', new Same(true));
        $expr2 = Expr::func('file_exists', new Same(true));

        $this->assertSame('Trident\\Components\\Expression\\Selector\\Func', Expr::getFullCassName('Func'));

        $this->assertEquals($expr1, $expr2);
    }
}