<?php
	$balls = array(
		'min' 		=> array(),
		'fiveMin' 	=> array(),
		'hour' 		=> array(),
		'main' 		=> array(),
	);

	$GetTime = new GetTime;

	$balls = $GetTime->setBallCount($balls, $_POST['ballCount']);

	if(!empty($_POST['time'])){
		$GetTime->getOrder($balls, $_POST['time']);
	}

	if(!empty($_POST['how_many_days'])){
		$GetTime->findDayAmount($balls);
	}

	class GetTime{
		var $days = 0;

		function setBallCount($balls, $ballCount){
			for($i = 1; $i <= $ballCount; $i++){
				$balls['main'][] = $i;
			}

			return $balls;
		}

		function getOrder($balls, $time){
			$time 			= explode(':', $time);
			$this->hours 	= $time[0];
			$this->minutes 	= $time[1];

			if(!empty($this->hours)){
				$this->hours--;
			}

			$this->findDayAmount($balls);
		}

		// terrible function but PHP doesn't do well 
		// with recursion so we must do it this way...
		function findDayAmount($balls){
			if(!empty($this->minutes) || !empty($this->hours)){
				$time = true;
			} else{
				$time = false;
			}

			do {
				$balls['min'][] = $balls['main'][0];
				unset($balls['main'][0]);

				if($time && empty($this->hours)){
					$this->minutes--;

					if(empty($this->minutes)){
						break;
					}
				}

				$balls['min'][] = $balls['main'][1];
				unset($balls['main'][1]);

				if($time && empty($this->hours)){
					$this->minutes--;

					if(empty($this->minutes)){
						break;
					}
				}

				$balls['min'][] = $balls['main'][2];
				unset($balls['main'][2]);

				if($time && empty($this->hours)){
					$this->minutes--;

					if(empty($this->minutes)){
						break;
					}
				}

				$balls['min'][] = $balls['main'][3];
				unset($balls['main'][3]);

				if($time && empty($this->hours)){
					$this->minutes--;

					if(empty($this->minutes)){
						break;
					}
				}

				$balls['main'] = array_merge($balls['main'], array_reverse($balls['min']));
				unset($balls['min']);
				$balls['min'] = array();

				if(count($balls['fiveMin']) < 11){
					$balls['fiveMin'][] = $balls['main'][0];
					unset($balls['main'][0]);
					$balls['main'] = array_values($balls['main']);

					if($time && empty($this->hours)){
						$this->minutes--;

						if(empty($this->minutes)){
							break;
						}
					}
				} else{
					$balls['main'] = array_merge($balls['main'], array_reverse($balls['fiveMin']));
					unset($balls['fiveMin']);
					$balls['fiveMin'] = array();

					if(count($balls['hour']) < 11 ){
						$balls['hour'][] = $balls['main'][0];
						unset($balls['main'][0]);
						$balls['main'] = array_values($balls['main']);
					} else{
						$balls['main'] = array_merge($balls['main'], array_reverse($balls['hour']));
						unset($balls['hour']);
						$balls['hour'] = array();
						$balls['main'][] = $balls['main'][0];
						unset($balls['main'][0]);
						$balls['main'] = array_values($balls['main']);

						// check to see if we have the correct order
						if(!$time){
							foreach ($balls['main'] as $check => $number) {
								$check = $check + 1;

								if($number != $check){
									$pass = false;
									$this->days = $this->days + .5;
									break;
								} else{
									$pass = true;
								}
							}

							if($pass){
								$this->days = $this->days + .5;
								break;
							}
						}
					}

					if($time && !empty($this->hours)){
						$this->hours--;
					}
				}
			} while($this->days < 10000);

			if($time){
				echo json_encode($balls);
			} else{
				echo $this->days;
			}
		}
	}