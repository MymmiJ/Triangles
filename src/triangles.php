<?php
/*
 * This test gives you an almost finished simple program. Your task is to finish two methods in class
 * GeometryChecker (isOneLine and isPointOnEdge).
 *
 * Expected output is in attached txt file.
 */

/**
 * Class Point describes one single point with coordinates x & y
 */
class Point {
    protected $x;
    protected $y;
    
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
    
    public function x() {
        return $this->x;
    }
    
    public function y() {
        return $this->y;
    }
    
    public function __toString() {
        return "[{$this->x}, {$this->y}]";
    }
}

/**
 * Class Triangle describes three Points
 */
class Triangle {
    protected $p1;
    protected $p2;
    protected $p3;
    
    public function __construct(Point $p1, Point $p2, Point $p3) {
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->p3 = $p3;
    }
    
    public function p1() {
        return $this->p1;
    }
    
    public function p2() {
        return $this->p2;
    }
    
    public function p3() {
        return $this->p3;
    }
    
    public function __toString() {
        return "{$this->p1}, {$this->p2}, {$this->p3}";
    }
}

class GeometryChecker {
    /**
     * This method checks whether these three points form a triangle
     * Three points do not form a triangle only if they are on one line.
     *
     * @returns bool true if is one line (that means it is not a triangle), false if is not
     */ 
    protected function isOneLine(Triangle $triangle) {
        $dist_p1_p2 =   sqrt( pow(($triangle->p2()->x() - $triangle->p1()->x()) , 2)
                            +
                              pow(($triangle->p2()->y() - $triangle->p1()->y()) , 2));

        $dist_p2_p3 =   sqrt( pow(($triangle->p3()->x() - $triangle->p2()->x()) , 2)
                            +
                              pow(($triangle->p3()->y() - $triangle->p2()->y()) , 2));

        $dist_p1_p3 =   sqrt( pow(($triangle->p3()->x() - $triangle->p1()->x()) , 2)
                            +
                              pow(($triangle->p3()->y() - $triangle->p1()->y()) , 2));

//        echo "<p>" . ($dist_p1_p2 + $dist_p2_p3) . "</p>" . PHP_EOL;

//        echo "<p>" . $dist_p1_p3 . "</p>" . PHP_EOL;


        return $dist_p1_p2 + $dist_p2_p3 === $dist_p1_p3;
    }

    /**
     * This method checks whether given point is on edge of triangle
     *
     * @return bool true if on edge, false if not
     * @throws TriangleException if given triangle cannot form a real triangle
     */
    public function isPointOnEdge(Point $point, Triangle $triangle) {
        if($this->isOneLine($triangle)) throw new TriangleException("$triangle is not a valid triangle.");

        if( $this->isOneLine(new Triangle($triangle->p1(),$point,$triangle->p2()))
         || $this->isOneLine(new Triangle($triangle->p2(),$point,$triangle->p3()))
         || $this->isOneLine(new Triangle($triangle->p1(),$point,$triangle->p3())) ) {
            return true;
        } else {
            return false;
        }
         
        
    }
}

class Runner {
    public function run($triangles, $points) {
        $checker = new GeometryChecker();
        foreach ($triangles as $triangle) {
            foreach ($points as $point) {
                try {
                    if ($checker->isPointOnEdge($point, $triangle)) {
                        echo "Point $point is on edge of $triangle". PHP_EOL;
                    } else {
                        echo "Point $point is not on edge of $triangle". PHP_EOL;
                    }
                } catch (TriangleException $e) {
                    echo $e->getMessage(). PHP_EOL;
                    break;               
                }
            }
        }
    }
}

class TriangleException extends Exception {}

// 5 "triangles"
$triangles = array(
    new Triangle(new Point(1,2), new Point(2,3), new Point(3,4)),
    new Triangle(new Point(10,0), new Point(0,10), new Point(-5,-5)),
    new Triangle(new Point(0,0), new Point(0,4), new Point(2,0)),
    new Triangle(new Point(2,2), new Point(4,2), new Point(2,4)),
    new Triangle(new Point(1,2), new Point(1,3), new Point(1,4)),
);

// 2 points
$points = array(
    new Point(0,0),
    new Point(1,2)
);

// Run Forrest!
$runner = new Runner();
$runner->run($triangles, $points);