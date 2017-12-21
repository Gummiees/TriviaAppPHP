<?php
include("includes/header.html");
include('includes/print_messages.php');
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
	require ('mysqli_connect.php');
	$uid = $_GET['uid'];
	$user_stats = array('id_quizzes' => [], 'averages' => [], 'dates' => []);

	$q = "SELECT id_quiz, average, date FROM statistics WHERE id_user=$uid";
	$r = @mysqli_query ($dbc, $q);
	$num = mysqli_num_rows($r);
	if ($num > 0) {
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$user_stats ['id_quizzes'] [] = $row['id_quiz'];
			$user_stats ['averages'] [] = $row['average'];
			$user_stats ['dates'] [] = $row['date'];
		}

		$last_id=-1;
		foreach ($user_stats['id_quizzes'] as $id_quiz) {
			if ($last_id != $id_quiz) {
				$q = "SELECT title date FROM quizzes WHERE id_quiz=$id_quiz";
				var_dump($id_quiz);
				$r = @mysqli_query ($dbc, $q);
				if (mysqli_num_rows($r) > 0) {
					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						$quiz_titles [] = $row['title'];
					}
				} else echo print_message('danger', 'No quiz found.');
				$last_id = $id_quiz;
			}
		}
?>
<script src="includes/utils.js"></script>
<div style="width: 80%; margin-left: 10%;">
  <canvas id="canvas1"></canvas>
</div>
<div style="width:80%; margin-left: 10%;">
  <canvas id="canvas2"></canvas>
</div>
<script>
var randomScalingFactor = function() {
  return Math.round(Math.random() * 100);
};

var color = Chart.helpers.color;
var config1 = {
  type: 'radar',
  data: {
    labels:<?php
    	echo "['";
    	foreach ($quiz_titles as $key => $quiz_title) {
    		echo $quiz_title;
    		if ($key != count($quiz_title)) echo ",";
    	}
    	echo "']";
    ?>,
    datasets: [{
      label: "User",
      backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
      borderColor: window.chartColors.red,
      pointBackgroundColor: window.chartColors.red,
      data: [
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor(),
        randomScalingFactor()
      ]
    }, {
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
    }, {
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
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
      label: "Me",
      backgroundColor: window.chartColors.red,
      borderColor: window.chartColors.red,
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
  	},{
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
    }]
  },
  options: {
    responsive: true,
    title:{
      display:true,
      text:'Total quizzes done per month'
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
          labelString: 'Month'
        }
      }],
      yAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Value'
        }
      }]
    }
  }
};

window.onload = function() {
  window.myRadar = new Chart(document.getElementById("canvas1"), config1);
  window.myLine = new Chart(document.getElementById("canvas2").getContext("2d"), config2);
};
</script>

<?php
		} else echo print_message('danger', 'The user does not have any stats.');
	} else echo print_message('danger', 'No user selected.');
include("includes/footer.html");
?>