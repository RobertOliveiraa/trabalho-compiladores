<?php
/**
 * @author Elynton Fellipe Bazzo
 * @author Andrei Siqueira
 */
require_once 'InputStream.php';

$args = $argv;
array_shift($args);

$type = @$args[1] === '-f' ? InputStream::TYPE_FILE : InputStream::TYPE_TEXT;

switch (@$args[0]) {
  case '-p':
    parser();
    break;
  case '-l':
    lexer();
    break;
  default:
    help();
}

function help()
{
  echo <<<END
  >>> Analisador de expressões aritméticas
      Escrito por Elynton F. Bazzo e Andrei Siqueira
      para a disciplina de compiladores.

      Uso:

      php Compiler.php <tipo>

      <tipo>   -l (Lexer)   ou -p (Parser)
      <metodo> -f (Arquivo) ou -t (Texto)
END
, PHP_EOL;
exit;
}

function parser()
{
  global $args, $type;
  new InputStream(@$args[2], [
    "type"   => $type,
    "method" => InputStream::METHOD_TREE
  ]);
}

function lexer()
{
  global $args, $type;
  new InputStream(@$args[2], [
    "type"   => $type,
    "method" => InputStream::METHOD_TOKEN
  ]);
}
