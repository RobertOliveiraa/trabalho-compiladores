<?php
/**
 * @author Elynton Fellipe Bazzo
 */
require_once 'Lexer.php';
require_once 'Parser.php';
require_once 'Tokenizer.php';
require_once 'TokenReader.php';
require_once 'Token.php';
require_once 'LexerError.php';
require_once 'ParserError.php';

$source = <<<END
  1 + 2 * (3 - 4 / 12);
END
;

try {
  $lexer = new Tokenizer($source);
  $parser = new TokenReader($lexer);
  $parser->arithmetic();
} catch (Exception $e) {
  echo $e->getMessage();
}
