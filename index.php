<?php

class Life {
	public $grid = array();

	public function createGrid() {
		$x = 10;
		$y = 20;
		for ( $i = 0; $i < $x; $i++ ) {
			$state = array();
			for ( $j = 0; $j < $y; $j++ ) {
				$state[ $j ] = 0;
			}
			$this->grid[ $i ] = $state;
		}
		$this->grid[2][7] = 1;
		$this->grid[3][7] = 1;
		$this->grid[4][7] = 1;
		$this->grid[3][5] = 1;
		$this->grid[4][6] = 1;
	}

	public function countAdjacentCells( $x, $y ) {
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
			if (
				isset( $this->grid[ $x + $coordinate[0] ][ $y + $coordinate[1] ] ) &&
				1 == $this->grid[ $x + $coordinate[0] ][ $y + $coordinate[1] ]
			) {
				$count = $count + 1;
			}
		}
		return $count;
	}

	public function runLife() {
		$newGrid = array();

		foreach ( $this->grid as $i => $width ) {
			$newGrid[ $i ] = array();
			foreach ( $width as $y => $height ) {
				$count = $this->countAdjacentCells( $i, $y );
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
