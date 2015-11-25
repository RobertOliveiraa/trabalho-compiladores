<?php
/**
 * @author Elynton Fellipe Bazzo
 */
abstract class Lexer
{
  const EOF      = -1;
  const EOF_TYPE =  1;

  public $input;
  public $position = 0;
  public $char;

  private $size;

  public function __construct($input)
  {
    $this->input = $input;
    $this->char  = $input[$this->position];
    $this->size = strlen($this->input);
  }

  protected function isEnd()
  {
    return $this->position >= strlen($this->input);
  }

  public function consume()
  {
    $this->position++;
    $this->char = $this->isEnd()
      ? /* then      */ self::EOF
      : /* otherwise */ $this->input[$this->position];
  }

  public abstract function nextToken();
  public abstract function tokenName($token_type);
}
