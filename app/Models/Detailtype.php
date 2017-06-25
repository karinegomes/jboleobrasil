<?php

namespace App\Models;

// TODO: fazer disso uma tabela
class Detailtype
{
  public $id;
  public $name;

  function __construct($id = '', $name = ''){
    $this->id = $id;
    $this->name = $name;
  }
}
