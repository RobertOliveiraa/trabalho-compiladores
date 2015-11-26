<?php
/**
 * @author Elynton Fellipe Bazzo
 * @author Andrei Siqueira
 */
require_once 'Lexer.php';
require_once 'Tokenizer.php';
require_once 'Token.php';
require_once 'LexerError.php';

$source = <<<END
  1 + 1 / 2.3;
  2.3 * -(4) - 2;
END
;

try {
  $lexer = new Tokenizer($source);
  $token = $lexer->nextToken();

  while ($token->key !== Tokenizer::EOF_TYPE) {
    echo $token;
    $token = $lexer->nextToken();
  }

} catch (LexerError $e) {
  echo $e->getMessage();
}
