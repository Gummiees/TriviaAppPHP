<?php
include("includes/header.html");
include('includes/print_messages.php');
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

	require ('mysqli_connect.php');
	$uid = intval($_GET['uid']);

	$q = "SELECT nick FROM users WHERE id_user=$uid";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) {

		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$nick = $row['nick'];

		$user_stats = array('id_quizzes' => [], 'averages' => [], 'dates' => []);

		$q = "SELECT id_quiz, average, date FROM statistics WHERE id_user=$uid";
		$r = @mysqli_query ($dbc, $q);
		$num = mysqli_num_rows($r);
		if ($num > 0) {
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$user_stats ['id_quizzes'] [] = intval($row['id_quiz']);
				$user_stats ['averages'] [] = floatval($row['average']);
				$user_stats ['dates'] [] = $row['date'];
			}

			$last_id=-1;
			foreach ($user_stats['id_quizzes'] as $key => $id_quiz) {
				if ($last_id != $id_quiz) {
					$suma_avg[$id_quiz] = 0;
					$total_times[$id_quiz] = 0;
					$q = "SELECT title FROM quizzes WHERE id_quiz=$id_quiz";
					$r = @mysqli_query ($dbc, $q);
					if (mysqli_num_rows($r) > 0) {
						while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
							$quiz_titles [] = $row['title'];
						}
					} else echo print_message('danger', 'No quiz found.');
					$last_id = $id_quiz;
				}
				$suma_avg[$id_quiz] += $user_stats['averages'][$key];
				$total_times[$id_quiz]++;
			}

			foreach ($suma_avg as $key => $value) {
				$suma_avg[$key] = round(($value/$total_times[$key])*100, 2);
			}

			//semana pasada: strtotime('-1 week');
			$oneweek = date('Y-m-d H:i:s', strtotime('-1 week -1 day'));
			$yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
			$q = "SELECT average, date FROM statistics WHERE (date BETWEEN '$oneweek' AND '$yesterday') AND id_user=$uid ORDER BY date";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_num_rows($r) > 0) {
				while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					$averages [] = $row['average'];
					$dates [] =  substr($row['date'], 0, 10);
				}

        $cont = 0;
        $date_before = substr($oneweek, 0, 10);
        $total_per_day = array();
        $total_per_day [$cont] = 0;
        foreach ($dates as $date) {
          if ($date_before == $date) $total_per_day [$cont] ++;
          else {
            $date_before = $date;
            $cont++;
            $total_per_day [$cont] = 0;
          }
        }

        //sacar stats por dia
        $cont = 0;
        $date_before = substr($oneweek, 0, 10);
        $average_per_day = array();
        $average_per_day [$cont] = 0;
        foreach ($averages as $key => $value) {
          if ($date_before == $dates[$key]) $average_per_day [$cont] += $value;
          else {
            $date_before = $dates[$key];
            $cont++;
            $average_per_day [$cont] = 0;
          }
        }

        foreach ($average_per_day as $key => $daily_avg) {
          if ($daily_avg == 0) $average_per_day[$key] = 0;
          else $average_per_day [$key] = round(($daily_avg/$total_per_day[$key])*100, 2);
        }

			} else echo print_message('danger', 'No register in the last week.');

?>
<script src="includes/utils.js"></script>
<div style="width: 80%; margin-left: 10%;">
  <canvas id="canvas1"></canvas>
</div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas2"></canvas>
</div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas3"></canvas>
</div>
<script>
var last7days = [];
for (var i=7; i>=1; i--) {
	last7days.push(moment().subtract(i, 'days').format('dddd'));
}

var randomScalingFactor = function() {
  return Math.round(Math.random() * 100);
};

var color = Chart.helpers.color;
var config1 = {
  type: 'radar',
  data: {
    labels:<?php
    	echo "[";
    	foreach ($quiz_titles as $key => $quiz_title) {
    		echo "'$quiz_title'";
    		if ($key != count($quiz_titles)) echo ",";
    	}
    	echo "]";
    ?>,
    datasets: [{
      label: "<?php echo $nick;?>",
      backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
      borderColor: window.chartColors.red,
      pointBackgroundColor: window.chartColors.red,
      data: [
      <?php
      foreach ($suma_avg as $key => $value) {
      	echo $value;
      	if ($key != count($suma_avg)) echo ',';
      }
      ?>
      ]
    }/*, {
      label: "My friend",
      backgroundColor: color(window.chartColors.orange).alpha(0.2).rgbString(),
      borderColor: window.chartColors.orange,
      pointBackgroundColor: window.chartColors.orange,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ]
    }*/, {
      label: "All user average",
      backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
      borderColor: window.chartColors.blue,
      pointBackgroundColor: window.chartColors.blue,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ]
    },]
  },
  options: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Comparation chart'
    },
    scale: {
      ticks: {
        beginAtZero: true
      }
    }
  }
};
var config2 = {
  type: 'line',
	data: {
    labels: last7days,
    datasets: [{
      label: "<?php echo $nick;?>",
      backgroundColor: window.chartColors.red,
      borderColor: window.chartColors.red,
      data: [
      <?php
        foreach ($total_per_day as  $daily) {
          echo "$daily, ";
        }
      ?>
      ],
      fill: false,
  	}/*,{
      label: "My friend",
      backgroundColor: window.chartColors.orange,
      borderColor: window.chartColors.orange,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ],
      fill: false,
  	}, {
      label: "Users average",
      fill: false,
      backgroundColor: window.chartColors.blue,
      borderColor: window.chartColors.blue,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ],
    }*/]
  },
  options: {
    responsive: true,
    title:{
      display:true,
      text:'Total quizzes done per day last week'
    },
    tooltips: {
      mode: 'index',
      intersect: false,
    },
    hover: {
      mode: 'nearest',
      intersect: true
    },
    scales: {
      xAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Day'
        }
      }],
      yAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Total quizzes'
        }
      }]
    }
  }
};
var config3 = {
  type: 'line',
	data: {
    labels: last7days,
    datasets: [{
      label: "<?php echo $nick;?>",
      backgroundColor: window.chartColors.red,
      borderColor: window.chartColors.red,
      data: [
        <?php
        foreach ($average_per_day as  $daily_avg) {
          echo "$daily_avg, ";
        }
      ?>
      ],
      fill: false,
  	},/*{
      label: "My friend",
      backgroundColor: window.chartColors.orange,
      borderColor: window.chartColors.orange,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ],
      fill: false,
  	}, */{
      label: "Users average",
      fill: false,
      backgroundColor: window.chartColors.blue,
      borderColor: window.chartColors.blue,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ],
    }]
  },
  options: {
    responsive: true,
    title:{
      display:true,
      text:'Average on quizzes per day last week'
    },
    tooltips: {
      mode: 'index',
      intersect: false,
    },
    hover: {
      mode: 'nearest',
      intersect: true
    },
    scales: {
      xAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Day'
        }
      }],
      yAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Average'
        }
      }]
    }
  }
};

window.onload = function() {
  window.myRadar = new Chart(document.getElementById("canvas1"), config1);
  window.myLine1 = new Chart(document.getElementById("canvas2").getContext("2d"), config2);
  window.myLine2 = new Chart(document.getElementById("canvas3").getContext("2d"), config3);
};

</script>

<?php
			} else echo print_message('danger', 'The user does not exist.');
		} else echo print_message('danger', 'The user does not have any stats.');
	} else echo print_message('danger', 'No user selected.');
include("includes/footer.html");
?>