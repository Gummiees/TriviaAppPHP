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

    $q = "SELECT title FROM quizzes";
    $r = @mysqli_query ($dbc, $q);
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $quiz_titles [] = $row['title'];
    }

    // calculate total average 

    // for uid

		$q = "SELECT id_quiz, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` WHERE id_user=$uid GROUP BY id_quiz";
		$r = @mysqli_query ($dbc, $q);
		$num = mysqli_num_rows($r);
		if ($num > 0) {
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$user_averages [] = round(floatval($row['total average']) * 100, 2);
			}

      // for all users

      $q = "SELECT id_quiz, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` GROUP BY id_quiz";
      $r = @mysqli_query ($dbc, $q);
      while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $all_averages [] = round(floatval($row['total average']) * 100, 2);
      }

			$oneweek = date('Y-m-d H:i:s', strtotime('-1 week -1 day'));
			$yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
      //var_dump($oneweek);
      //var_dump($yesterday);

      $q = "SELECT COUNT(id_user) AS 'daily quizzes', SUM(average)/COUNT(id_user) AS 'daily total average', Convert(date, date) AS 'Date' FROM statistics WHERE (date BETWEEN '$oneweek' AND '$yesterday') AND id_user=$uid GROUP BY Date ORDER BY date";
      $r = @mysqli_query ($dbc, $q);
      if (mysqli_num_rows($r) > 0) {
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
          $daily_total_user [] = $row['daily quizzes'];
          $daily_avg_user [] = round(floatval($row['daily total average']) * 100, 2);
          $dates [] = $row['Date'];
        }

        if (count($daily_total_user) < 7) {
          $day = -8;
          foreach ($dates as $key => $date) {
            if ($date == date('Y-m-d', strtotime($day.' day'))) {
            } else {
              array_splice( $daily_total_user, $key, 0, 0 );
              $day++;
            }
            $day++;
          }
        }

        if (count($daily_avg_user) < 7) {
          $day = -8;
          foreach ($dates as $key => $date) {
            if ($date == date('Y-m-d', strtotime($day.' day'))) {
            } else {
              array_splice( $daily_avg_user, $key, 0, 0 );
              $day++;
            }
            $day++;
          }
        }

        $q = "SELECT COUNT(id_user) AS 'daily quizzes', SUM(average)/COUNT(id_user) AS 'daily total average', Convert(date, date) AS 'Date' FROM statistics WHERE (date BETWEEN '$oneweek' AND '$yesterday') GROUP BY Date ORDER BY date";
        $r = @mysqli_query ($dbc, $q);
          while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $daily_total_all [] = $row['daily quizzes'];
            $daily_avg_all [] = round(floatval($row['daily total average']) * 100, 2);
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
        foreach ($user_averages as $key => $value) {
        	echo $value;
        	if ($key != count($user_averages)) echo ',';
        }
        ?>
      ]
    }, {
      label: "All user average",
      backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
      borderColor: window.chartColors.blue,
      pointBackgroundColor: window.chartColors.blue,
      data: [
        <?php
        foreach ($all_averages as $key => $value) {
          echo $value;
          if ($key != count($all_averages)) echo ',';
        }
      ?>
      ]
    },]
  },
  options: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Comparation chart in % of correct answers per quiz'
    },
    scale: {
      ticks: {
        beginAtZero: true,
        max: 100,
        min: 0,
        stepSize: 10
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
        foreach ($daily_total_user as  $daily) {
          echo "$daily, ";
        }
      ?>
      ],
      fill: false,
  	},{
      label: "Users average",
      fill: false,
      backgroundColor: window.chartColors.blue,
      borderColor: window.chartColors.blue,
      data: [
      <?php
        foreach ($daily_total_all as  $daily) {
          echo "$daily, ";
        }
      ?>
      ],
    }]
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
        ticks : {
          beginAtZero: true
        },
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
        foreach ($daily_avg_user as  $daily_avg) {
          echo "$daily_avg, ";
        }
      ?>
      ],
      fill: false,
  	},{
      label: "Users average",
      fill: false,
      backgroundColor: window.chartColors.blue,
      borderColor: window.chartColors.blue,
      data: [
        <?php
        foreach ($daily_avg_all as  $daily_avg) {
          echo "$daily_avg, ";
        }
      ?>
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
        ticks: {
          beginAtZero: true,
          max: 100,
          min: 0,
          stepSize: 10
        },
        display: true,
        scaleLabel: {
          display: true,
          labelString: '% of correct answers'
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