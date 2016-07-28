<?php
/*
 * This file is part of the Trident package.
 *
 * (c) Perederko Ruslan <perederko.ruslan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trident\Components\Expression;

use Webmozart\Expression\Expr as BaseExpr;

class Expr extends BaseExpr
{
    static $namespaces = [];

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array $args
     *
     * @method Expr::factory()
     *
     * @return Expression
     */
    public static function __callStatic($method, $args)
    {
        $className = ucfirst($method);
        $fullClassName = static::getFullCassName($className);

        $reflection = new \ReflectionClass($fullClassName);

        switch (count($args)) {
            case 0:
                return call_user_func([$reflection, 'newInstance']);
            case 1:
                return call_user_func([$reflection, 'newInstance'], $args[0]);
            case 2:
                return call_user_func([$reflection, 'newInstance'], $args[0], $args[1]);
            case 3:
                return call_user_func([$reflection, 'newInstance'], $args[0], $args[1], $args[2]);
            case 4:
                return call_user_func([$reflection, 'newInstance'], $args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array([$reflection, 'newInstance'], $args);
        }
    }

    public static function getFullCassName($className)
    {
        if (empty(static::$namespaces)) {
            static::$namespaces = static::scan();
        }

        foreach (static::$namespaces as $namespace) {
            $fullClassName = $namespace.$className;
            if (class_exists($fullClassName, true)) {
                return $fullClassName;
            }
        }

        return false;
    }

    final public static function scan()
    {
        echo $root = __DIR__.DIRECTORY_SEPARATOR;
        $items = \array_diff(\scandir($root), array('.', '..'));
        $namespaces = [];

        foreach ($items as $item) {
            if (\is_dir($root.$item.DIRECTORY_SEPARATOR)) {
                $namespaces[] = __NAMESPACE__.'\\'.$item.'\\';
            }
        }

        $parent = \get_parent_class(__CLASS__);
        if (\method_exists($parent, 'scan')) {
            $namespaces .= $parent::scan();
        }

        return $namespaces;
    }
}