<?php
class position {
  public $coordinates;
  public $horizontal;
  public $vertical;
  public $index;
  
  public function __construct($directions) {
    /* Initialize horizontal/vertical positions of the current wire end 
    Index is a register of every single coordinate on the wire
    Set the starting coordinate values to 0 */
    $this->horizontal = 0;
    $this->vertical = 0;
    $this->index = 0;
    $this->coordinates[$this->index]['vertical'] = $this->vertical;
    $this->coordinates[$this->index]['horizontal'] = $this->horizontal;
    
    /* Loop across all of input directions array*/
    foreach ($directions as $key => $value) {
      
      /* Parses the first character as the direction 
      Parses the distance after the direction */
      $direction = $value[0];
      $distance = intval(substr($value, 1-strlen($value)));
      
      /* Depending on the direction, will save the original position 
      and then update the corresponding direction to the final position.
      For vertical movement, there will be no change in horizontal value
      so it can be assigned to the current horizontal value.
      For horizontal movement, there will be no change in vertical value 
      so it can be assigned to the current vertical value. */
      if ($direction == 'U') {
        $original = $this->vertical;
        $this->vertical = $this->vertical + $distance;
        /* Current index is returned, then updates by 1 afterwards 
        so that each point can be tracked. */
        $this->coordinates[$this->index]['direction'] = 'vertical';
        $this->coordinates[$this->index]['x1'] = $this->horizontal;
        $this->coordinates[$this->index]['x2'] = $this->horizontal;
        $this->coordinates[$this->index]['y1'] = $original;
        $this->coordinates[$this->index++]['y2'] = $this->vertical;

      } elseif ($direction == 'D') {
        $original = $this->vertical;
        $this->vertical = $this->vertical - $distance;

        $this->coordinates[$this->index]['direction'] = 'vertical';
        $this->coordinates[$this->index]['x1'] = $this->horizontal;
        $this->coordinates[$this->index]['x2'] = $this->horizontal;
        $this->coordinates[$this->index]['y1'] = $original;
        $this->coordinates[$this->index++]['y2'] = $this->vertical;

      } elseif ($direction == 'L') {
        $original = $this->horizontal;
        $this->horizontal = $this->horizontal - $distance;

        $this->coordinates[$this->index]['direction'] = 'horizontal';
        $this->coordinates[$this->index]['x1'] = $original;
        $this->coordinates[$this->index]['x2'] = $this->horizontal;
        $this->coordinates[$this->index]['y1'] = $this->vertical;
        $this->coordinates[$this->index++]['y2'] = $this->vertical;
      } elseif ($direction == 'R') {
        $original = $this->horizontal;
        $this->horizontal = $this->horizontal + $distance;

        $this->coordinates[$this->index]['direction'] = 'horizontal';
        $this->coordinates[$this->index]['x1'] = $original;
        $this->coordinates[$this->index]['x2'] = $this->horizontal;
        $this->coordinates[$this->index]['y1'] = $this->vertical;
        $this->coordinates[$this->index++]['y2'] = $this->vertical;
      }
    }
  }
}

class comparison {
  public $shortestdistance;
  
  function __construct($wire1, $wire2) {
    $this->shortestdistance = 0;
    
    /* Loop through all segments of both wires*/
    foreach ($wire1 as $wire1point => $wire1values) {
      foreach ($wire2 as $wire2point => $wire2values) {
        
        /* If the start of x of wire 2 is less than the end of x of wire 1, and if the end of x of wire 2 is greater than the start of x of wire 1, the x range overlaps
        If the start of y of wire 2 is less than the end of y of wire 1, and if the end of y of wire 2 is greater than the start of y of wire 1, the y range overlaps
        If both overlap then there is an intersection of values*/
        if (($wire2values['x1'] < $wire1values['x2'] && $wire2values['x2'] > $wire1values['x1']) && ($wire2values['y1'] < $wire1values['y2'] && $wire2values['y2'] > $wire1values['y1'])) {
          
          /* If wire 1 is horizontal, it means the y value never changes and is where the y intersection is.
          If wire 2 is vertical, it means the x value never changes and is where the x intersection is.*/
          if ($wire1values['direction'] == 'horizontal' && $wire2values['direction'] == 'vertical') {
            /* Distance is calculated by abs(x) + abs(y) for the Manhattan formula... */
            $distance = abs($wire2values['x1']) + abs($wire1values['y1']);
            
            /* Sets the shorest distance if none is set, and then compares to see if any further intersections are smaller than the initially set distance. */
            if ($this->shortestdistance == 0) {
              $this->shortestdistance = $distance;
            } elseif ($distance < $this->shortestdistance) {
              $this->shortestdistance = $distance;
            }
            
            /* If wire 1 is vertical, it means the x value never changes and is where the x intersection is.
          If wire 2 is horizontal, it means the y value never changes and is where the y intersection is.*/
          } elseif ($wire1values['direction'] == 'vertical' && $wire2values['direction'] == 'horizontal') {
            $distance = abs($wire1values['x1']) + abs($wire2values['y1']);

            if ($this->shortestdistance == 0) {
              $this->shortestdistance = $distance;
            } elseif ($distance < $this->shortestdistance) {
              $this->shortestdistance = $distance;
            }
          }
          echo "There is an intersection between wire 1 segment (${wire1values['x1']}, ${wire1values['y1']}) to (${wire1values['x2']}, ${wire1values['y2']}) and wire 2 segment (${wire2values['x1']}, ${wire2values['y1']}) to (${wire2values['x2']}, ${wire2values['y2']})\n";
        }
      }
    }
  }
}

$inputwire1 ="R8,U5,L5,D3";
$directionswire1 = explode(",", $inputwire1);
$wire1 = new position($directionswire1);

$inputwire2 ="U7,R6,D4,L4";
$directionswire2 = explode(",", $inputwire2);
$wire2 = new position($directionswire2);

$compare = new comparison($wire1->coordinates, $wire2->coordinates);
echo "$compare->shortestdistance \n";
?>
