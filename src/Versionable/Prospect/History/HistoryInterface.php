<?php

namespace Versionable\Prospect\History;

interface HistoryInterface
{  
  public function add(EntryInterface $entry);
  
  public function back();
  
  public function forward();
  
  public function go($index);
    
  public function getLast();
  
  public function count();
}
