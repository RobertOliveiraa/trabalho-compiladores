<?php
/**
 * @author Elynton Fellipe Bazzo
 */
require_once 'Lexer.php';
require_once 'Tokenizer.php';
require_once 'Token.php';
require_once 'LexerError.php';

try {
  $lexer = new Tokenizer("   1.4+    1 * (3 - 2)/  10 num 6");
  $token = $lexer->nextToken();

  while ($token->key !== Tokenizer::EOF_TYPE) {
    echo $token;
    $token = $lexer->nextToken();
  }

} catch (LexerError $e) {
  echo $e->getMessage();
}
