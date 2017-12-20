<?php
include("includes/header.html");
include('includes/print_messages.php');
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
	require ('mysqli_connect.php');
?>
<script src="includes/utils.js"></script>
<div class="wrapper" style="max-width: 512px; margin: auto">
			<canvas id="chart-0"></canvas>
		</div>
		<div class="toolbar">
			<button onclick="togglePropagate(this)">Propagate</button>
			<button onclick="toggleSmooth(this)">Smooth</button>
			<button onclick="randomize(this)">Randomize</button>
		</div>
		<div id="chart-analyser" class="analyser"></div>	
<script>
		var presets = window.chartColors;
		var utils = Samples.utils;
		var inputs = {
			min: 8,
			max: 16,
			count: 8,
			decimals: 2,
			continuity: 1
		};

		function generateData() {
			// radar chart doesn't support stacked values, let's do it manually
			var values = utils.numbers(inputs);
			inputs.from = values;
			return values;
		}

		function generateLabels(config) {
			return utils.months({count: inputs.count});
		}

		utils.srand(42);

		var data = {
			labels: generateLabels(),
			datasets: [{
				backgroundColor: utils.transparentize(presets.red),
				borderColor: presets.red,
				data: generateData(),
				label: 'D0'
			}, {
				backgroundColor: utils.transparentize(presets.orange),
				borderColor: presets.orange,
				data: generateData(),
				hidden: true,
				label: 'D1',
				fill: '-1'
			}, {
				backgroundColor: utils.transparentize(presets.yellow),
				borderColor: presets.yellow,
				data: generateData(),
				label: 'D2',
				fill: 1
			}, {
				backgroundColor: utils.transparentize(presets.green),
				borderColor: presets.green,
				data: generateData(),
				label: 'D3',
				fill: false
			}, {
				backgroundColor: utils.transparentize(presets.blue),
				borderColor: presets.blue,
				data: generateData(),
				label: 'D4',
				fill: '-1'
			}, {
				backgroundColor: utils.transparentize(presets.purple),
				borderColor: presets.purple,
				data: generateData(),
				label: 'D5',
				fill: '-1'
			}]
		};

		var options = {
			maintainAspectRatio: true,
			spanGaps: false,
			elements: {
				line: {
					tension: 0.000001
				}
			},
			plugins: {
				filler: {
					propagate: false
				},
				samples_filler_analyser: {
					target: 'chart-analyser'
				}
			}
		};

		var chart = new Chart('chart-0', {
			type: 'radar',
			data: data,
			options: options
		});

		function togglePropagate(btn) {
			var value = btn.classList.toggle('btn-on');
			chart.options.plugins.filler.propagate = value;
			chart.update();
		}

		function toggleSmooth(btn) {
			var value = btn.classList.toggle('btn-on');
			chart.options.elements.line.tension = value? 0.4 : 0.000001;
			chart.update();
		}

		function randomize() {
			inputs.from = [];
			chart.data.datasets.forEach(function(dataset) {
				dataset.data = generateData();
			});
			chart.update();
		}
	</script>

<?php
	} else echo print_messages('danger', 'No user selected.');
include("includes/footer.html");
?>