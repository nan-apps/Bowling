<?php
namespace Bowling;

class Game {

	private $rolls = [];
	private $currentRoll = 0;

	public function __construct(){
            $this->rolls = array_fill(0, 20, 0);
	}

    public function roll(int $pins): void{
    	$this->rolls[$this->currentRoll++] = $pins;
    }

    public function score(): int{
    	$score = 0;
    	$firstBallInFrame = 0;

    	for ($frame=0; $frame<10; $frame++) { 

    		if( $this->isStrike($firstBallInFrame) ){
    			$score += 10 + $this->nextTwoBallsForStrike($firstBallInFrame);
    			$firstBallInFrame += 1;
    		} elseif ( $this->isSpare($firstBallInFrame) ){
    			$score += 10 + $this->nextBallForSpare($firstBallInFrame);
    			$firstBallInFrame += 2;
    		} else {
    			$score += $this->nextBallsInFrame($firstBallInFrame);
	    		$firstBallInFrame += 2;
    		}
    	}

    	return $score;
    }

    private function nextTwoBallsForStrike($firstBallInFrame): int{
    	return $this->rolls[$firstBallInFrame+1] + $this->rolls[$firstBallInFrame+2];
    }

    private function nextBallForSpare($firstBallInFrame): int{
    	return $this->rolls[$firstBallInFrame+2];
    }

    private function nextBallsInFrame($firstBallInFrame): int{
    	return $this->rolls[$firstBallInFrame] + $this->rolls[$firstBallInFrame+1];
    }

    private function isSpare($firstBallInFrame): bool{
    	return $this->rolls[$firstBallInFrame] + $this->rolls[$firstBallInFrame+1] == 10;
    }

    private function isStrike($firstBallInFrame): bool{
    	return $this->rolls[$firstBallInFrame]  == 10;
    }

}
