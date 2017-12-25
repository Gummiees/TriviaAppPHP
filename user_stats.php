<?php
include("includes/header.html");
include('includes/print_messages.php');

function setUserAverages ($uid, $dbc) {

  $q = "SELECT id_quiz, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` WHERE id_user=$uid GROUP BY id_quiz";
  $r = @mysqli_query ($dbc, $q);
  $num = mysqli_num_rows($r);
  if ($num > 0) {
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $user_averages [] = round(floatval($row['total average']) * 100, 2);
    }
  }
  return $user_averages;
}

function setDailyUserStats ($uid, $oneweek, $yesterday, $dbc) {
  $daily_stats_user = array('daily_total_user' => [], 'daily_avg_user' => [], 'dates' => []);
  $q = "SELECT COUNT(id_user) AS 'daily quizzes', SUM(average)/COUNT(id_user) AS 'daily total average', Convert(date, date) AS 'Date' FROM statistics WHERE (date BETWEEN '$oneweek' AND '$yesterday') AND id_user=$uid GROUP BY Date ORDER BY date";
  $r = @mysqli_query ($dbc, $q);
  if (mysqli_num_rows($r) > 0) {
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $daily_stats_user['daily_total_user'] [] = $row['daily quizzes'];
        $daily_stats_user['daily_avg_user'] [] = round(floatval($row['daily total average']) * 100, 2);
        $daily_stats_user['dates'] [] = $row['Date'];
    }
    if (count($daily_stats_user['daily_total_user']) < 7) {
      $day = -8;
      for ($i=0; $i<7; $i++) {
        $set = true;
        for ($j=0;$j<count($daily_stats_user['dates']); $j++) {
          if ($daily_stats_user['dates'][$j] != date('Y-m-d', strtotime($day.' day'))) {
          } else $set = false;
        }
        if ($set) array_splice( $daily_stats_user['daily_total_user'], $i, 0, 0 );
        $day++;
      }
    }

    if (count($daily_stats_user['daily_avg_user']) < 7) {
      $day = -8;
      for ($i=0; $i<7; $i++) {
        $set = true;
        for ($j=0;$j<count($daily_stats_user['dates']); $j++) {
          if ($daily_stats_user['dates'][$j] != date('Y-m-d', strtotime($day.' day'))) {
          } else $set = false;
        }
        if ($set) array_splice( $daily_stats_user['daily_avg_user'], $i, 0, 0 );
        $day++;
      }
    }
  }
  return $daily_stats_user;
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
	require ('mysqli_connect.php');
	$uid = intval($_GET['uid']);
  $oneweek = date('Y-m-d H:i:s', strtotime('-1 week -1 day'));
  $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
  //var_dump($oneweek);
  //var_dump($yesterday);
  $colors = ['red','yellow','green','blue','purple'];

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

    $stats [$nick] = array('user_averages' => [], 'daily_stats' => []);
    $stats [$nick] ['user_averages'] = setUserAverages($uid, $dbc);
    $stats [$nick] ['daily_stats'] = setDailyUserStats($uid, $oneweek, $yesterday, $dbc);
    for ($i = 1; $i<5; $i++){
      if (isset($_GET['uid'.$i]) && is_numeric($_GET['uid'.$i])) {
        $uid = intval($_GET['uid'.$i]);
        $q = "SELECT nick FROM users WHERE id_user=$uid";
        $r = @mysqli_query ($dbc, $q);

        if (mysqli_num_rows($r) == 1) {
          $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
          $nick = $row['nick'];
          $stats [$nick] = array('user_averages' => [], 'daily_stats' => []);
          $stats [$nick] ['user_averages'] = setUserAverages($uid, $dbc);
          $stats [$nick] ['daily_stats'] = setDailyUserStats($uid, $oneweek, $yesterday, $dbc);
        }
      } else break;
    }

      // for all users

    $q = "SELECT id_quiz, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` GROUP BY id_quiz";
    $r = @mysqli_query ($dbc, $q);
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $all_averages [] = round(floatval($row['total average']) * 100, 2);
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
<div class="row text-center"><h2>Total correct: </h2></div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas4"></canvas>
</div>
<div style="width: 80%; margin-left: 10%;">
  <canvas id="canvas1"></canvas>
</div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas2"></canvas>
</div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas3"></canvas>
</div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas5"></canvas>
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
    datasets: [<?php $i=0; foreach ($stats as $nick => $value) {?>{
      label: "<?php echo $nick;?>",
      backgroundColor: color(window.chartColors.<?php echo $colors[$i]; ?>).alpha(0.2).rgbString(),
      borderColor: window.chartColors.<?php echo $colors[$i]; ?>,
      pointBackgroundColor: window.chartColors.<?php echo $colors[$i]; ?>,
      data: [<?php
      foreach ($stats[$nick]['user_averages'] as $avg) {
          echo $avg;
        	if ($key != count($avg)) echo ',';
        }?>]
    },<?php $i++; } ?>{
      label: "All users average",
      backgroundColor: color(window.chartColors.grey).alpha(0.2).rgbString(),
      borderColor: window.chartColors.grey,
      pointBackgroundColor: window.chartColors.grey,
      data: [<?php foreach ($all_averages as $key => $avg) {
         echo "$avg, ";
      }?>]
    }
    ]
  },
  options: {
    legend: {
      position: 'right',
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
        stepSize: 20
      }
    }
  }
};
var config2 = {
  type: 'line',
	data: {
    labels: last7days,
    datasets: [<?php $i=0; foreach ($stats as $nick => $value) {?>{
      label: "<?php echo $nick;?>",
      backgroundColor: window.chartColors.<?php echo $colors[$i]; ?>,
      borderColor: window.chartColors.<?php echo $colors[$i]; ?>,
      data: [<?php
        foreach ($stats[$nick]['daily_stats']['daily_total_user'] as $avg) {
          echo $avg;
          if ($key != count($avg)) echo ',';
        }?>],
      fill: false,
  	},<?php $i++; } ?>{
      label: "Users average",
      fill: false,
      backgroundColor: window.chartColors.grey,
      borderColor: window.chartColors.grey,
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
    legend: {
      position: 'right',
    },
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
    datasets: [<?php $i=0; foreach ($stats as $nick => $value) {?>{
      label: "<?php echo $nick;?>",
      backgroundColor: window.chartColors.<?php echo $colors[$i]; ?>,
      borderColor: window.chartColors.<?php echo $colors[$i]; ?>,
      data: [<?php
        foreach ($stats[$nick]['daily_stats']['daily_avg_user'] as $avg) {
          echo $avg;
          if ($key != count($avg)) echo ',';
        }?>],
      fill: false,
  	},<?php $i++; } ?>{
      label: "Users average",
      fill: false,
      backgroundColor: window.chartColors.grey,
      borderColor: window.chartColors.grey,
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

//pie

var config4 = {
  type: 'pie',
  data: {
    datasets: [{
      data: [
        randomScalingFactor(),
        randomScalingFactor()
      ],
      backgroundColor: [
        window.chartColors.red,
        window.chartColors.blue
      ]
    }],
    labels: [
      "Correct",
      "Wrong"
    ]
  },
  options: {
    legend: {
        position: 'right',
    },
    title: {
        display: true,
        text: 'General % of correct answers'
    },
    responsive: true
  }
};
    

//radar

var chartColors = window.chartColors;
var color = Chart.helpers.color;
var config5 = {
  data: {
    datasets: [{
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
      ],
      backgroundColor: [
        color(chartColors.red).alpha(0.5).rgbString(),
        color(chartColors.orange).alpha(0.5).rgbString(),
        color(chartColors.yellow).alpha(0.5).rgbString(),
        color(chartColors.green).alpha(0.5).rgbString(),
        color(chartColors.blue).alpha(0.5).rgbString(),
      ],
      label: 'My dataset' // for legend
    }],
    labels: [
      "Red",
      "Orange",
      "Yellow",
      "Green",
      "Blue"
    ]
  },
  options: {
    responsive: true,
    legend: {
        position: 'right',
    },
    title: {
        display: true,
        text: 'General % of correct answers'
    },
    scale: {
      ticks: {
        beginAtZero: true
      },
      reverse: false
    },
    animation: {
      animateRotate: true,
      animateScale: true
    }
  }
};

window.onload = function() {
  window.myRadar = new Chart(document.getElementById("canvas1"), config1);
  window.myLine1 = new Chart(document.getElementById("canvas2").getContext("2d"), config2);
  window.myLine2 = new Chart(document.getElementById("canvas3").getContext("2d"), config3);
  window.myPie = new Chart(document.getElementById("canvas4").getContext("2d"), config4);
  window.myPolarArea = Chart.PolarArea(document.getElementById("canvas5"), config5);
};

</script>

<?php
	} else echo print_message('danger', 'No user selected.');
include("includes/footer.html");
?>