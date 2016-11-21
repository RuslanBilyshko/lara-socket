<?php namespace App\Http\Support;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TableLayout {

  private $headers;
  private $rows;

  public function __construct()
  {
    $this->headers = collect();
    $this->rows = collect();
  }

  public function headers(Collection $headers)
  {
    $this->headers = $headers;
    return $this;
  }

  public function rows(Collection $rows)
  {
    $this->rows = $rows;
    return $this;
  }


  public function render()
  {
    return view('layout.table',['headers' => $this->headers, 'rows' => $this->rows]);
  }

}