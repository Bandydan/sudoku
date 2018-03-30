console.clear();

class Sudoku {
	constructor(complexity) {
		this.complexity = complexity;
		this.__timer = true;
	}
	
	createTable(selector = 'body', w = 9, h = 9) {
		let $table = $('<table>').appendTo(selector);
		for (let i = 1; i <= w; i++) {
			let $tr = $('<tr>').appendTo($table);
			for (let j = 1; j <= h; j++) {
				let $td = $('<td>').appendTo($tr);
			}
		}

		this.selector = $table;
	}
	
	fillTable(data = [], gaped = true) {
		this.__source = JSON.parse(JSON.stringify(data));

		if (gaped) {
			for (let i = 0; i < this.complexity; i++) this.__source[this.randomInteger(0, 8)][this.randomInteger(0, 8)] = null;
		}
		
		for (let i = 0; i < this.__source.length; i++) {
			for (let j = 0; j < this.__source[i].length; j++) {
				$(this.selector)
					.find(`tr:nth-child(${i+1}) td:nth-child(${j+1})`)
					.hide()
					.fadeIn(Math.random()*2000)
					.text(this.__source[i][j]);
			}
		}
	}
	
	cleanTable() {
		$(this.selector).find('td').empty();
		this.__stopTimer();
	}
	
	__stopTimer() {
		this.__timer = false;	
	}
	
	__setTime(selector = 'body', time) {
		time.str = (time.mm < 10 ? `0${time.mm}` : time.mm) + ':' + (time.ss < 10 ? `0${time.ss}` : time.ss);
		$(selector).text(time.str);
	}
	
	setTimer(selector = 'body') {
		var time = {mm: 0, ss: 0, str: ''};
		
		this.__setTime(selector, time);
		
		var timerId = setTimeout(function timeout() {
			time.ss++;
			
			if (time.ss > 60) {
				time.ss = 0;
				time.mm++;
			}

			this.__setTime(selector, time);
				
			timerId = setTimeout(timeout.bind(this), 1000);

			if (!this.__timer) {
				clearTimeout(timerId);
				time.mm = 0;
				time.ss = 0;
				setTime();
			}
			
		}.bind(this), 1000);
		
	}
	
	randomInteger(min, max) {
		return Math.round(Math.random() * (max - min) + min);
	}
}

$(function() {
	var game = new Sudoku(30);
	game.createTable('#game');
	var source = JSON.parse($('#hidden_sudoku').val());
	
	$('#btn-gaped').on('click', () => {
		game.fillTable(source);
		$('#btn-clear').prop('disabled', false);
		// game.setTimer('#time');
	});

	$('#btn-full').on('click', () => {
		game.fillTable(source, false);
		$('#btn-clear').prop('disabled', false);
	});

	$('#btn-clear').on('click', function() {
		game.cleanTable();
		$(this).prop('disabled', true);
	});	
})
