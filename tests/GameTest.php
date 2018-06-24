<?php

use PHPUnit\Framework\TestCase;
use Bowling\Game;

final class GameTest extends TestCase
{
    private $game;

    public function setUp(): void
    {
        $this->game = new Game();
    }
    
    private function rollMany(int $n, int $pins): void
    {
        for ($i=0; $i<$n; $i++) {
            $this->game->roll($pins);
        }
    }

    private function rollSpare(): void
    {
        $this->rollMany(2, 5);
    }

    private function rollStrike(): void
    {
        $this->game->roll(10);
    }
   
    public function testGutterGame(): void
    {
        $this->rollMany(20, 0);
        $this->assertEquals(0, $this->game->score());
    }

    public function testAllOnes(): void
    {
        $this->rollMany(20, 1);
        $this->assertEquals(20, $this->game->score());
    }

    public function testOneSpare(): void
    {
        $this->rollSpare();
        $this->game->roll(3); //despues de un spare suma doble
        $this->rollMany(17, 0);
        $this->assertEquals(16, $this->game->score());
    }

    public function testOneStrike(): void
    {
        $this->rollStrike();
        $this->game->roll(3); //suma doble
        $this->game->roll(4); //suma doble
        $this->rollMany(16, 0);
        $this->assertEquals(24, $this->game->score());
    }

    public function testPerfectGame(): void
    {
        $this->rollMany(12, 10);
        $this->assertEquals(300, $this->game->score());
    }
}
