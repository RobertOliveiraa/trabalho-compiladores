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
  public $size;

  public function __construct($input)
  {
    $this->input = $input;
    $this->size  = strlen($this->input);

    if ($this->size === 0) {
      return new Token(self::EOF_TYPE, NULL, 0, 0);
    }

    $this->char = $input[$this->position];
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
