<?php

$sudoku = $numbers = $temp_results = [];
$num_of_cleanings;

init_sudoku();
//generating coords for each square (5-th square has 36, 37, 38, 46, 47, 48, 56, 57, 58)
foreach (range(0, 8) as $square_number) {
	$square_coords[] = get_square_coords($square_number);
}

$temp_results = [];

while (count($numbers)) { //go through all the numbers
	$number = array_pop($numbers);
	$used_rows = $used_cols = [];
	$square = 0;
	while ($square < 9) {
		$coord = random_coord($square, $used_rows, $used_cols);
		if (false === $coord) {
			// echo "cleaning!!!\n";
			$num_of_cleanings++;
			if($num_of_cleanings > 2) {
				init_sudoku();
				break;
			}
			$square = 0;
			$sudoku = $temp_results;
			$used_rows = $used_cols = [];
			continue;
		}
		$row = intval($coord/10);
		$col = $coord % 10;
		$sudoku[$row][$col] = $number;
		$used_rows[] = $row;
		$used_cols[] = $col;
		$square++;			
	}
	$temp_results = $sudoku;
}

$message = "We have created a sudoku!\n";
// print_sudoku();


function init_sudoku() {
	global $sudoku, $numbers, $num_of_cleanings;

	$zeroes = array_fill(0,9, 0); // array of 9 zeroes
	$sudoku = array_fill(0, 9, $zeroes); // array 9 x 9 of zeroes for sudoku
	$numbers = range(1, 9);
	$num_of_cleanings = 0;
}

function print_sudoku(){
	global $sudoku;
	foreach ($sudoku as $s1) {
		foreach ($s1 as $value) {
			print $value . "  ";
		}
		print "\n";
	}
}

function get_square_coords($square) {
	$x = ($square % 3) * 3;
	$y = intval($square / 3) * 3;
	$coords = array_merge(
		range($y*10 + $x, $y*10 +$x +2),
		range(($y+1)*10 + $x, ($y+1)*10 +$x +2),
		range(($y+2)*10 + $x, ($y+2)*10 +$x +2)
	);
	return $coords;
}

function random_coord($square, $used_rows, $used_cols) {
	global $square_coords, $sudoku;
	$option_coords = $square_coords[$square];
	do {
		if(! count($option_coords)) {
			return false;
		}
		$coord = random_value($option_coords);
		$x = $coord % 10;
		$y = intval($coord/10);
		$option_coords = array_diff($option_coords, [$coord]);
	} while (in_array($x, $used_cols) || in_array($y, $used_rows) || ($sudoku[$y][$x] != 0));
	return $coord;
}

function random_value($array) {
	return $array[array_rand($array, 1)];
}
