<?php
/**
 * @author Elynton Fellipe Bazzo
 */
class Token
{
  public $key;
  public $value;

  public function __construct($key, $value = NULL)
  {
    $this->key   = $key;
    $this->value = $value;
  }

  public function containsValue()
  {
    return $this->value !== NULL;
  }

  public function __toString()
  {
    $token_name = Tokenizer::$token_names[$this->key];

    return $this->containsValue()
      ? "<{$token_name}, {$this->value}>"
      : "<{$token_name}>";
  }
}
