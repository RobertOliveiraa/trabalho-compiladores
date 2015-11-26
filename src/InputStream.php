<?php
/**
 * @author Elynton Fellipe Bazzo
 */
class InputStream
{
  const TYPE_FILE     = 0x0;
  const TYPE_TEXT     = 0x1;

  const METHOD_TREE   = 0x0;
  const METHOD_TOKEN  = 0x1;

  private $options = [];
  private $source;

  public function __construct($source, $options)
  {
    $this->options = [];

    switch ($options["type"]) {
      case self::TYPE_FILE:
        $this->file($source);
        break;
      case self::TYPE_TEXT:
        $this->source = $source;
        $this->text();
        break;
      default:
        echo ">>> Especifique um tipo válido de saída (TYPE_FILE, TYPE_TEXT)", PHP_EOL;
        exit;
    }
  }

  private function file($file)
  {
    if (file_exists($file)) {
      $this->source = file_get_contents($file);
      $this->text();
    } else {
      echo ">>>> Arquivo {$file} não encontrado", PHP_EOL;
      exit;
    }
  }

  private function text()
  {
    var_dump($this->source);
  }
}


$stream = new InputStream("1 * 2 - 4 + -(-3 * 8)", [
  "type"   => InputStream::TYPE_TEXT,
  "method" => InputStream::METHOD_TREE
]);
