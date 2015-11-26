<?php
/**
 * @author Elynton Fellipe Bazzo
 */
class Tokenizer extends Lexer
{
  const T_INTEGER        = 2;
  const T_DOUBLE         = 3;
  const T_SEMICOLON      = 4;
  const T_IDENTIFIER     = 5;
  const T_LPAREN         = 6;
  const T_RPAREN         = 7;
  const T_PLUS           = 8;
  const T_MINUS          = 9;
  const T_DIVISION       = 10;
  const T_MULTIPLICATION = 11;

  public $line = 0;
  public $column = 0;

  static $token_names = [
    'n/a', '<EOF>', 'T_INTEGER', 'T_DOUBLE', 'T_SEMICOLON', 'T_IDENTIFIER'
  , 'T_LPAREN', 'T_RPAREN', 'T_PLUS', 'T_MINUS', 'T_DIVISION'
  , 'T_MULTIPLICATION'
  ];

  public function __construct($input)
  {
    parent::__construct($input);
  }

  public function nextToken()
  {
    while ($this->char != self::EOF) {
      switch ($this->char) {
        case " ":
        case "\t":
        case "\r\n":
        case "\n":
        case "\r":
        case PHP_EOL:
          $this->skipBlank();
          continue;
        case "+":
          $this->consume();
          return new Token(self::T_PLUS);
        case "-":
          $this->consume();
          return new Token(self::T_MINUS);
        case "*":
          $this->consume();
          return new Token(self::T_MULTIPLICATION);
        case "/":
          $this->consume();
          return new Token(self::T_DIVISION);
        default:
          if (ctype_digit($this->char)) {
            return $this->digit();
          }

          throw new LexerError("Caractere inesperado: {$this->char}", $this->line, $this->column);
      }
    }

    return new Token(self::EOF_TYPE);
  }

  public function tokenName($token_type)
  {
    return static::$token_names[$token_type];
  }

  private function skipBlank()
  {
    while (ctype_space($this->char)) {
      switch ($this->char) {
        case "\r\n":
        case "\n":
        case "\r":
        case PHP_EOL:
          $this->line++;
          $this->column = 0;
          break;
        default:
          $this->column++;
          $this->consume();
          break;
      }
    }
  }

  private function digit()
  {
    $buffer = $this->char;
    $this->consume();
    $type = 'integer';


    hold_number:
      while (ctype_digit($this->char)) {
        $buffer .= $this->char;
        $this->consume();
      }

    if ($type !== 'double' && $this->char === ".") {
      $type = 'double';
      $buffer .= ".";
      $this->consume();
      goto hold_number;
    }

    return $type === 'integer'
      ? new Token(self::T_INTEGER, (int) $buffer)
      : new Token(self::T_DOUBLE, (double) $buffer);

  }
}
