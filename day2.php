<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class manipulation {
  /* Position will maintain index as we skip 4 in the array between functions */
  public $finalvalue;
  public $position;
  public $inputarray;
  
  public function __construct($input) {
    /* Defaut position of 0 */
    $this->inputarray = $input;
    $this->position = 0;
    
    /* Extra instructions given in the problem*/
    $this->inputarray[1] = 12;
    $this->inputarray[2] = 2;
  }
  
  public function interpretation() {
    /* Reads the value at the current position to determine whether to add, multiply, or end */
    $functiontype = $this->inputarray[$this->position];
    
    /* Gets target position indicated by the third element after the function position
    Sets target position in the array to equal the result of the addition 
    Advances index position by 4 to continue to next function */
    if ($functiontype == 1) {
     $target = $this->inputarray[$this->position+3];
     $this->inputarray[$target] = $this->one();
     $this->position = $this->position+4;
     return;
    }
    
    /* Gets target position indicated by the third element after the function position
    Sets target position in the array to equal the result of the multiplication 
    Advances index position by 4 to continue to next function */
    if ($functiontype == 2) {
      $target = $this->inputarray[$this->position+3];
      $this->inputarray[$target] = $this->two();
      $this->position = $this->position+4;
      return;
    }
    
    /* Sets the final calculated value at position 0 and returns 99 to end the while loop*/
    if ($functiontype == 99) {
      $this->finalvalue = $this->inputarray[0];
      return $this->inputarray[$this->position];
    }
  }
  
  /* Gets the position based on the elements one and two positions after the function element
  Gets the content based on the given positions and then adds them togther and returns the result */
  private function one() {
    $position1 = $this->inputarray[$this->position+1];
    $position2 = $this->inputarray[$this->position+2];
    $content1 = $this->inputarray[$position1];
    $content2 = $this->inputarray[$position2];
    $sum = $content1 + $content2;
    return $sum;
  }
  
  private function two() {
    $position1 = $this->inputarray[$this->position+1];
    $position2 = $this->inputarray[$this->position+2];
    $content1 = $this->inputarray[$position1];
    $content2 = $this->inputarray[$position2];
    $product = $content1 * $content2;
    return $product;
  }
  
}

$input = "1,0,0,3,1,1,2,3,1,3,4,3,1,5,0,3,2,1,9,19,1,13,19,23,2,23,9,27,1,6,27,31,2,10,31,35,1,6,35,39,2,9,39,43,1,5,43,47,2,47,13,51,2,51,10,55,1,55,5,59,1,59,9,63,1,63,9,67,2,6,67,71,1,5,71,75,1,75,6,79,1,6,79,83,1,83,9,87,2,87,10,91,2,91,10,95,1,95,5,99,1,99,13,103,2,103,9,107,1,6,107,111,1,111,5,115,1,115,2,119,1,5,119,0,99,2,0,14,0";
$array = explode(",", $input);
$arraything = new manipulation($array);

/* Initialize $i for the loop, will end once the position reaches an element of 99 */
$i = 0;

/* Will constantly loop over the function that determines which function to use and advances the position */
while ($i != 99) {
  $i = $arraything->interpretation();
}

echo "$arraything->finalvalue";
?>
