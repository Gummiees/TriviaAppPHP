<script src="includes/utils.js"></script>
<?php
session_start();
include("includes/header.html");
include('includes/print_messages.php');
function setUserAverages ($uid, $dbc) {

  $q = "SELECT id_quiz, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` WHERE id_user=$uid GROUP BY id_quiz";
  $r = @mysqli_query ($dbc, $q);
  $num = mysqli_num_rows($r);
  $user_averages = array('total average' => [], 'total average user' => []);
  if ($num > 0) {
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $user_averages ['total average'][] = round(floatval($row['total average']) * 100, 2);
    }
  }
  
  $q = "SELECT id_user, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` WHERE id_user=$uid GROUP BY id_user";
  $r = @mysqli_query ($dbc, $q);
  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $user_averages ['total average user'][] = round(floatval($row['total average']) * 100, 2);
  }

  return $user_averages;
}

function setDailyUserStats ($uid, $oneweek, $today, $dbc) {
  $daily_stats_user = array('daily_total_user' => [], 'daily_avg_user' => [], 'dates' => []);
  $q = "SELECT COUNT(id_user) AS 'daily quizzes', SUM(average)/COUNT(id_user) AS 'daily total average', Convert(date, date) AS 'Date' FROM statistics WHERE (date BETWEEN '$oneweek' AND '$today') AND id_user=$uid GROUP BY Date ORDER BY date";
  $r = @mysqli_query ($dbc, $q);
  if (mysqli_num_rows($r) > 0) {
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $daily_stats_user['daily_total_user'] [] = $row['daily quizzes'];
        $daily_stats_user['daily_avg_user'] [] = round(floatval($row['daily total average']) * 100, 2);
        $daily_stats_user['dates'] [] = $row['Date'];
    }

    if (count($daily_stats_user['daily_total_user']) < 7) {
      $day = -6;
      for ($i=0; $i<7; $i++) {
        $set = true;
        for ($j=0;$j<count($daily_stats_user['dates']); $j++) {
          if ($daily_stats_user['dates'][$j] == date('Y-m-d', strtotime($day.' day'))) $set = false;
        }
        if ($set) array_splice( $daily_stats_user['daily_total_user'], $i, 0, 0 );
        $day++;
      }
    }

    if (count($daily_stats_user['daily_avg_user']) < 7) {
      $day = -6;
      for ($i=0; $i<7; $i++) {
        $set = true;
        for ($j=0;$j<count($daily_stats_user['dates']); $j++) {
          if ($daily_stats_user['dates'][$j] == date('Y-m-d', strtotime($day.' day'))) $set = false;
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
  $oneweek = date('Y-m-d H:i:s',strtotime('-6 day', strtotime(date('Y-m-d')." 00:00:00")));
  $today = date('Y-m-d H:i:s', strtotime('tomorrow'));
  //var_dump($oneweek);
  //var_dump($today);
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
    $stats [$nick] ['daily_stats'] = setDailyUserStats($uid, $oneweek, $today, $dbc);
    if (!isset($_GET['uid1'])) {
      //pie
      
      $q = "SELECT id_user, COUNT(id_user) AS 'total' FROM `statistics`  WHERE id_user=$uid GROUP BY id_user";
      $r = @mysqli_query ($dbc, $q);
      while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $total_quizzes_user = $row['total'];
      }
?>

<div class="row text-center login-title">
  <div class="col-sm-12 text-center">
    <h1 style="font-size: 4em; text-align: center !important;"><?php echo $nick;?></h1> 
    <h3>
      You played <b><?php echo $total_quizzes_user; ?></b> quizzes. Here are your statistics.
    </h3>
  </div>
</div>
<div class="container-canvas">
    <canvas id="canvas4"></canvas>

<script>
var alone = true;
</script>

<?php 
    } else echo "<script>var alone=false;</script><div class='container-canvas'><div class='canvas'><canvas id='canvas5'></canvas></div>";
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
          $stats [$nick] ['daily_stats'] = setDailyUserStats($uid, $oneweek, $today, $dbc);
        }
      } else break;
    }

      // for all users

    $q = "SELECT COUNT(id_user) AS 'total' FROM `users`";
    $r = @mysqli_query ($dbc, $q);
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    $total_users = $row['total'];

    $q = "SELECT id_quiz, SUM(average)/COUNT(id_user) AS 'total average' FROM `statistics` GROUP BY id_quiz";
    $r = @mysqli_query ($dbc, $q);
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $all_averages [] = round(floatval($row['total average']) * 100, 2);
    }

    $q = "SELECT COUNT(id_user)/$total_users AS 'daily quizzes', SUM(average)/COUNT(id_user) AS 'daily total average', Convert(date, date) AS 'Date' FROM statistics WHERE (date BETWEEN '$oneweek' AND '$today') GROUP BY Date ORDER BY date";
    $r = @mysqli_query ($dbc, $q);
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $daily_total_all [] = $row['daily quizzes'];
      $daily_avg_all [] = round(floatval($row['daily total average']) * 100, 2);
      $dates_all [] = $row['Date'];
    }

    if (count($daily_total_all) < 7) {
      $day = -6;
      for ($i=0; $i<7; $i++) {
        $set = true;
        for ($j=0;$j<count($dates_all); $j++) {
          if ($dates_all[$j] == date('Y-m-d', strtotime($day.' day'))) $set = false;
        }
        if ($set) array_splice( $daily_total_all, $i, 0, 0 );
        $day++;
      }
    }

    if (count( $daily_avg_all) < 7) {
      $day = -6;
      for ($i=0; $i<7; $i++) {
        $set = true;
        for ($j=0;$j<count($dates_all); $j++) {
          if ($dates_all[$j] == date('Y-m-d', strtotime($day.' day'))) $set = false;
        }
        if ($set) array_splice( $daily_avg_all, $i, 0, 0 );
        $day++;
      }
    }
  } else echo print_message('danger', 'No register in the last week.');

?>
  <canvas id="canvas1"></canvas>
  <canvas id="canvas2"></canvas>
  <canvas id="canvas3"></canvas>
</div>
<script>
var last7days = [];
for (var i=6; i>=0; i--) {
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
      foreach ($stats[$nick]['user_averages']['total average'] as $avg) {
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
    datasets: [<?php $i=0; $max=0; foreach ($stats as $nick => $value) {?>{
      label: "<?php echo $nick;?>",
      backgroundColor: window.chartColors.<?php echo $colors[$i]; ?>,
      borderColor: window.chartColors.<?php echo $colors[$i]; ?>,
      data: [<?php
        foreach ($stats[$nick]['daily_stats']['daily_total_user'] as $avg) {
          echo $avg;
          if ($avg > $max) $max = $avg;
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
          beginAtZero: true,
          max: <?php echo $max;?> + 1
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
      data: [<?php
          echo $stats[$nick]['user_averages']['total average user'][0].',';
          $total = 100 - $stats[$nick]['user_averages']['total average user'][0];
          echo $total;
        ?>],
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
<?php 
  $i=0;
  foreach ($stats as $nick => $value) {
    foreach ($stats[$nick]['user_averages']['total average user'] as $avg) {
      echo $avg;
      if ($key != count($avg)) echo ',';
    }
  $i++;
  }
?>
      ],
      backgroundColor: [
<?php 
  $i=0;
  foreach ($stats as $nick => $value) {
    foreach ($stats[$nick]['user_averages']['total average user'] as $avg) {
      ?>
        color(chartColors.<?php echo $colors[$i]; ?>).alpha(0.5).rgbString()
      <?php
      if ($key != count($avg)) echo ',';
    }
  $i++;
  }
?>
      ]
     }],

    labels: [
    <?php $i=0; foreach ($stats as $nick => $value) {
      echo '"'.$nick.'",';
    }?>
    ]
  },
  options: {
    responsive: true,
    title: {
        display: true,
        text: 'General % of correct answers'
    },
    scale: {
      ticks: {
        beginAtZero: true,
        max: 100
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
  if (alone) window.myPie = new Chart(document.getElementById("canvas4").getContext("2d"), config4);
  else window.myPolarArea = Chart.PolarArea(document.getElementById("canvas5"), config5);
};

</script>

<?php
	} else echo print_message('danger', 'No user selected.');
include("includes/footer.html");
?>