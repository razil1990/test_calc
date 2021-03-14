<?php
require './Calc.php';

use PHPUnit\Framework\TestCase;

class Test extends TestCase {
  private $calc;
  private $x = '(1-3i)';
  private $y = '(6+2i)';

  protected function setUp() : void {
    $this->calc = new Calc();
  }

  protected function tearDown() : void {
    $this->calc = NULL;
  }

  public function testResultSum() : void {
    $result = $this->calc->sum( $this->x, $this->y );
    $this->assertEquals('7-1i', $result);
  }

  public function testResultSubtract() : void {
    $result = $this->calc->subtract( $this->x, $this->y );
    $this->assertEquals('-5-5i', $result);
  }

  public function testResultMultiply() : void {
    $result = $this->calc->multiply( $this->x, $this->y );
    $this->assertEquals('12-16i', $result);
  }

  public function testResultDivide() : void {
    $result = $this->calc->divide( $this->x, $this->y );
    $this->assertEquals('-0.5i', $result);
  }

  public function testIsResultStr() {
    $this->assertIsString($this->calc->sum( $this->x, $this->y ));
    $this->assertIsString($this->calc->subtract( $this->x, $this->y ));
    $this->assertIsString($this->calc->multiply( $this->x, $this->y ));
    $this->assertIsString($this->calc->divide( $this->x, $this->y ));
  }

  public function testResultRegex() {
    $this->assertMatchesRegularExpression("@^\-?\d+[+,-]\d+i$@i", $this->calc->sum( $this->x, $this->y ));
    $this->assertMatchesRegularExpression("@^\-?\d+[+,-]\d+i$@i", $this->calc->subtract( $this->x, $this->y ));
    $this->assertMatchesRegularExpression("@^\-?\d+[+,-]\d+i$@i", $this->calc->multiply( $this->x, $this->y ));;
    $this->assertMatchesRegularExpression("@^\-?\d+[+,-]\d+i$@i", $this->calc->sum( $this->x, $this->y ));
  }
}