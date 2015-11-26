<?php
/**
 * Gramática de referência:
 * @link {http://karmin.ch/ebnf/examples}
 * @author Elynton Fellipe Bazzo
 */
abstract class Parser
{
  public $source;
  public $lookahead;

  public function __construct(Tokenizer $source)
  {
    $this->source = $source;
    $this->consume();
  }

  public function match()
  {
    $args = func_get_args();
    foreach ($args as $arg) {
      if ($this->lookahead->key === $arg) {
        $data = $this->lookahead->value !== NULL
          ? $this->lookahead->value
          : $this->lookahead->key;
        $this->consume();
        return $data;
      }
    }

    $expected = array_map(function($t) {
      return Tokenizer::$token_names[$t];
    }, $args);

    $found = Tokenizer::$token_names[$this->lookahead->key];
    $line = $this->lookahead->line;
    $column = $this->lookahead->column;

    $message = "Esperava encontrar " . implode(" ou ", $expected)
      . ". Encontrou {$found}";

    throw new ParserError($message, $line, $column);
  }

  public function consume()
  {
    $this->lookahead = $this->source->nextToken();
  }
}
