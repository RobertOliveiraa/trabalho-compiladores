<?php
/**
 * @author Elynton Fellipe Bazzo
 */
class TokenReader extends Parser
{
  private $expression_tree = [];

  public function __construct(Tokenizer $source)
  {
    parent::__construct($source);
  }

  public function arithmetic()
  {
    while ($this->lookahead->key !== Tokenizer::EOF_TYPE) {
      $this->expression_tree[] = $this->expr();
      $this->match(Tokenizer::T_SEMICOLON);
    }
  }

  public function printExpressionTree()
  {
    var_dump($this->expression_tree);
  }

  private function isSecondaryOperator()
  {
    return $this->lookahead->key === Tokenizer::T_PLUS
        || $this->lookahead->key === Tokenizer::T_MINUS;
  }

  private function isPrimaryOperator()
  {
    return $this->lookahead->key === Tokenizer::T_MULTIPLICATION
        || $this->lookahead->key === Tokenizer::T_DIVISION;
  }

  public function digit()
  {
    $unary = NULL;
    if ($this->isSecondaryOperator()) {
      $unary = $this->secondaryOperator();
    }

    $number = $this->match(Tokenizer::T_INTEGER, Tokenizer::T_DOUBLE);

    return $unary === NULL
      ? $number
      : ($unary === Tokenizer::T_MINUS
        ? -$number
        : $number);
  }

  public function primaryOperator()
  {
    return $this->match(Tokenizer::T_DIVISION, Tokenizer::T_MULTIPLICATION);
  }

  public function secondaryOperator()
  {
    return $this->match(Tokenizer::T_PLUS, Tokenizer::T_MINUS);
  }

  public function expr()
  {
    $x  = $this->term();
    $xs = [];

    while ($this->isSecondaryOperator()) {
      $operator = $this->secondaryOperator();
      $term     = $this->term();
      $xs[] = ["operator" => Tokenizer::$token_names[$operator], "operand" => $term];
    }

    return empty($xs)
      ? $x
      : ["left" => $x, "right" => $xs];
  }

  public function term()
  {
    $x  = $this->factor();
    $xs = [];

    while ($this->isPrimaryOperator()) {
      $operator = $this->primaryOperator();
      $factor   = $this->factor();
      $xs[]     = ["operator" => Tokenizer::$token_names[$operator], "operand" => $factor];
    }

    return empty($xs)
      ? $x
      : ["left" => $x, "right" => $xs];
  }

  public function factor()
  {
    if ($this->lookahead->key === Tokenizer::T_LPAREN) {
      $this->match(Tokenizer::T_LPAREN);
      $factor = $this->expr();
      $this->match(Tokenizer::T_RPAREN);
    } else {
      $factor = $this->digit();
    }

    return $factor;
  }
}
