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

use Trident\Components\Expression\Constraint\Verbal;
use VerbalExpressions\PHPVerbalExpressions\VerbalExpressions;

class VerbalTest extends \PHPUnit_Framework_TestCase
{
    public static function provideValidUrls()
    {
        return array(
            array('http://github.com'),
            array('http://www.github.com'),
            array('https://github.com'),
            array('https://www.github.com'),
            array('https://github.com/blog'),
            array('https://foobar.github.com'),
        );
    }

    /**
     * @dataProvider provideValidUrls
     * @group        functional
     */
    public function testEvaluate($url)
    {
        $regex = new VerbalExpressions();
        $this->buildUrlPattern($regex);

        $expr = new Verbal($regex);

        $this->assertTrue($expr->evaluate($url));
    }

    protected function buildUrlPattern(VerbalExpressions $regex)
    {
        return $regex->startOfLine()
            ->then("http")
            ->maybe("s")
            ->then("://")
            ->maybe("www.")
            ->anythingBut(" ")
            ->endOfLine();
    }

    public function testToString()
    {
        $regex = new VerbalExpressions();
        $this->buildUrlPattern($regex);

        $expr = new Verbal($regex);
        $this->assertSame('matches("'.$regex->getRegex().'")', $expr->toString());
    }
}