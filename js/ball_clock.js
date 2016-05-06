var currentTime;

$(document).ready(function(){
	getCurrentTime();
	getBallCounts(currentTime, '27');

	$(document).on('click', '.intial-submit', function(e){
		e.preventDefault();
		var ballCount = $('.initial-order').find('.ball-number').val();
		if(ballCount > 26 && ballCount < 128){
			getDayAmount(ballCount);
		} else{
			$('.day-amount').html('<strong style="color: red;"> Please choose a number between 27 and 127 </strong>');
		}

		return false;
	});

	$(document).on('click', '.specified-time-submit', function(e){
		e.preventDefault();

		var ballCount = $('.specified-time').find('.ball-number').val();
		var minutes = $('.specified-time').find('.minutes').val();

		if(ballCount > 0 && minutes > 0){
			getJsonObj('0:' + minutes, ballCount);
		} else{
			$('.json-order').html('<strong style="color: red;"> Please specify ball amount and minutes </strong>');
		}

		return false;
	});
});

function getCurrentTime(){
	var dt = new Date();
	currentTime = dt.getHours() + ':' + dt.getMinutes();
}

function getBallCounts(time, ballCount){
	$.ajax({
		method: "POST",
		url: 	"php/ball_count.php",
		data: 	{time: time, ballCount: ballCount}
	}).done(function(data){
		data = jQuery.parseJSON(data);

		$.each(data, function(key, val){
			$.each(val, function(k, v){
				$('.' + key + ' .balls').append('<div class="ball"><strong>' + v + '</strong></div>');
			});
		});
	});
}

function getDayAmount(ballCount){
	$.ajax({
		method: "POST",
		url: 	"php/ball_count.php",
		data: 	{ballCount: ballCount, how_many_days: true}
	}).done(function(data){
		$('.day-amount').html('<strong> Number of days: </strong> ' + data);
	})
}

function getJsonObj(time, ballCount){
	$.ajax({
		method: "POST",
		url: 	"php/ball_count.php",
		data: 	{time: time, ballCount: ballCount}
	}).done(function(data){
		$('.json-order').text(data);
	});
}