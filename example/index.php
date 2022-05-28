<?php declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Example\Domain\ValueObjects\CPF;

/*
 * Samples of invalid document
 *
 * 012.345.678-    Invalid length
 * 111.111.111-11  Invalid format
 * 012.345.678-99  Invalid document
 * 11111111111111  Invalid length and Invalid format
*/

/*
 * Example with valid document
 *
 * 012.345.678-90
*/

$cpf = new CPF('012.345.678-909');

var_dump($cpf->isValid());
var_dump($cpf->getMessages());
var_dump($cpf->filterByMessage('Invalid length'));
