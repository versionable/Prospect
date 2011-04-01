<?php

namespace Versionable\Http\History;


class History implements HistoryInterface
{
  /**
   *
   * @var array List of entries
   */
  protected $entries = array();
  
  protected $position = null;

  /**
   * Sets the current postion in the history
   * @param integer $position 
   */
  protected function setPosition($position)
  {
    $this->position = $position;
  }
  
  /**
   * Gets the current postion in the history
   * @return type 
   */
  public function getPosition()
  {
    return $this->position;
  }
  
  /**
   *
   * Adds new entry to the history list
   * If position is currently the last, the new current will added to the end
   * Otherwise history is continued from the current position
   * 
   * @param EntryInterface $entry 
   * @return null
   */
  public function add(EntryInterface $entry)
  {
    if (!is_null($this->getPosition()) && $this->getPosition() != $this->count() - 1)
    {
      array_splice($this->entries, $this->getPosition() + 1);
    }
    
    $this->entries[] = $entry;
    
    $this->setPosition($this->count() - 1);
  }
  
  /**
   * Returns the previous entry in the history
   * 
   * @throws \OutOfBoundsException if there is no previous history
   * @return EntryInterface 
   */
  public function back()
  {
    try 
    {
      return $this->go(-1);
    } 
    catch(\OutOfBoundsException $e)
    {
      throw new \OutOfBoundsException('Cannot go further back in history');
    }
  }
  
  /**
   * Returns the next entry in the history
   * 
   * @throws \OutOfBoundsException if at the end of the history
   * @return EntryInterface 
   */
  public function forward()
  {
    try 
    {
      return $this->go(1);
    } 
    catch(\OutOfBoundsException $e)
    {
      throw new \OutOfBoundsException('Cannot go further forward in history');
    }   
  }
  
  public function count()
  {
    return count($this->entries);
  }
  
  /**
   * Goes to a relative page from the current poistion in the history
   * @param type $relative relative offset to move in the history
   * @return type 
   */
  public function go($relative)
  {
    if ($relative + $this->getPosition() < 0)
    {
      throw new \OutOfBoundsException('Cannot go this far back in the history');
    }
    elseif ($relative + $this->getPosition() > ($this->count() - 1))
    {
      throw new \OutOfBoundsException('Cannot go this far forward in the history');
    }
    
    $this->setPosition($this->getPosition() + $relative);
    
    return $this->entries[$this->getPosition()];
  }
  
  public function getLast()
  {
    return end($this->entries);;
  }
}
