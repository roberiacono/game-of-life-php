<?php

class Life {
	public $grid = array();

	public function createGrid() {
		$x = 5;
		$y = 10;
		for ( $i = 0; $i < $x; $i++ ) {
			$state = array();
			for ( $j = 0; $j < $y; $j++ ) {
				$state[ $j ] = 0;
			}
			$this->grid[ $i ] = $state;
		}

		// Glider.
		$this->grid[2][7] = 1;
		$this->grid[3][7] = 1;
		$this->grid[4][7] = 1;
		$this->grid[3][5] = 1;
		$this->grid[4][6] = 1;

		/*
		// Blinker
		$this->grid[0][0] = 1;
		$this->grid[0][1] = 1;
		$this->grid[0][2] = 1; */
	}

	public function countAdjacentCells( $x, $y, $xMax, $yMax ) {
		$count = 0;

		$coordinatesArray = array(
			array( -1, -1 ),
			array( -1, 0 ),
			array( -1, 1 ),
			array( 0, -1 ),
			array( 0, 1 ),
			array( 1, -1 ),
			array( 1, 0 ),
			array( 1, 1 ),
		);

		foreach ( $coordinatesArray as $coordinate ) {
			// x=4, y=1 ,    xMax = 5, yMax = 10
			$coordinateX = $x > 0 && $x < $xMax - 1 ? $x + $coordinate[0] : ( $x + $coordinate[0] + $xMax ) % $xMax;
			$coordinateY = $y > 0 && $y < $yMax - 1 ? $y + $coordinate[1] : ( $y + $coordinate[1] + $yMax ) % $yMax;
			if (
				isset( $this->grid[ $coordinateX ][ $coordinateY ] ) &&
				1 == $this->grid[ $coordinateX ][ $coordinateY ]
			) {
				$count = $count + 1;
			}
		}
		return $count;
	}

	public function runLife() {
		$newGrid = array();
		$xMax    = count( $this->grid );

		foreach ( $this->grid as $i => $width ) {
			$newGrid[ $i ] = array();
			$yMax          = count( $width );
			foreach ( $width as $y => $height ) {
				$count = $this->countAdjacentCells(
					$i,
					$y,
					$xMax,
					$yMax
				);

				$state = $this->grid[ $i ][ $y ];

				if ( $state == 1 ) {
					// The cell is alive.
					if ( $count < 2 || $count > 3 ) {
						// Any live cell with less than two or more than three neighbours dies.
						$newState = 0;
					} else {
						// Any live cell with exactly two or three neighbours lives.
						$newState = 1;
					}
				} else {
					// The cell is death.
					if ( $count == 3 ) {
						// Any dead cell with three neighbours lives.
						$newState = 1;
					} else {
						$newState = 0;
					}
				}
				$newGrid[ $i ][ $y ] = $newState;
			}
		}
		$this->grid = $newGrid;
		unset( $newGrid );
	}
}

function render( Life $life ) {
	$output = '';
	// var_dump( $life->grid );
	foreach ( $life->grid as $widthId => $width ) {
		foreach ( $width as $heightId => $height ) {
			if ( $height == 1 ) {
				$output .= '*';
			} else {
				$output .= '.';
			}
		}
		$output .= PHP_EOL;
	}

	return $output;
}


$life = new Life();
$life->createGrid();


while ( true ) {
	// Linux / macOS
	// system('clear');
	// Windows
	echo chr( 27 ) . '[H' . chr( 27 ) . '[J';
	echo render( $life );
	$life->runLife();
	usleep( 500000 );
}
