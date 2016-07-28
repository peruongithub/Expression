<?php

$loader = require_once __DIR__.'/../vendor/autoload.php';

use SebastianBergmann\Comparator\Factory;
use Webmozart\Expression\PhpUnit\ExpressionComparator;

Factory::getInstance()->register(new ExpressionComparator());
