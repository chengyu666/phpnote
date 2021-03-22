<!DOCTYPE html>
<html lang="en">

<head>
	<title>Notes of FCY</title>
	<meta name="viewport" content="width=device-width,initial-scale=0.8">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link crossorigin="anonymous" integrity="sha384-Pr99BdaiK6qML1jUB4M/wzTI7pwwpjUiRaa7JD3CgqF3NxwHgsbjAc5m1RcfGXId" href="https://lib.baomitu.com/materialize/1.0.0/css/materialize.css" rel="stylesheet">
	<script crossorigin="anonymous" integrity="sha384-V2vzHm/4vwRrnPN0dLbxh4hP4Hngnf/KafRjFODPm1QYGNdFQR3yZB5ueUG/wsKJ" src="https://lib.baomitu.com/jquery/2.1.1/jquery.min.js"></script>
	<script crossorigin="anonymous" integrity="sha384-z/iqpfP0o4rvbluRPP+wwxNyKlTFVkl4XnkKoebzbNlNZuEICIE/G7zYOpa90L96" src="https://lib.baomitu.com/materialize/1.0.0/js/materialize.js"></script>
	<style type="text/css">
		#title {
			padding: 1px;
			position: fixed;
			width: 100%;
			top: 0px;
		}

		#list {
			padding-top: 80px;
			padding-bottom: 150px;
			font-size: 1.2em;
		}

		.page-footer {
                        padding-bottom: 0px;
			margin-bottom: 0px;
                        position: fixed;
			width: 100%;
			bottom: 0px;
			min-width: 300px;
		}

		.col {
			padding: 0;
		}

		.col1 {
			min-width: wrap-content;
		}

		.col3 {
			min-width: 7.4rem;
		}

		.character-counter {
			color: black;
		}

		.deleted {
			text-decoration: line-through;
		}

		#subbtn {
			text-align: center;
		}
	</style>
	<script>
		$(document).ready(function() {
			$('#data').characterCounter();
			$('#submit').click(function() {
				var txt = $('#data').val();
				if (txt.length > 0) {
					window.location.href = "/notes.php?text=" + txt;
				}
			})
			if ($('#insflag').text() == '1') {
				window.location.href = "/notes.php";
			}
			if ($('#insflag').text() == '2') {
				setTimeout(function() {
					window.location.href = "/notes.php";
				}, 3000)
			}
		});
	</script>
</head>

<body class="cyan lighten-5">
	<div id="title" class="light-blue lighten-4 z-depth-3">
		<div class="container">
			<h3> Notes:</h3>
		</div>
	</div><br>
	<div id="list" class="container">
		<?php
		$servername = "localhost";
		$username = "chengyu";
		$password = "19980925";
		$dbname = "fcy";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("连接失败: " . $conn->connect_error);
		}

		@$txt = $_GET["text"];
		if (strlen($txt) > 0) {
			$sql = "INSERT INTO `note` (`id`, `data`, `adddate`, `isdelete`) VALUES (NULL, '" . $txt . "', NOW(), '0');";
			if ($conn->query($sql) == true) {
				echo "<blockquote>插入成功!</blockquote>";
				echo "<p id='insflag' hidden>1</p>";
			} else {
				echo "<blockquote>插入失败!<br>" . $sql . "<br>" . $conn->error . "</blockquote>";
				echo "<p id='insflag' hidden>2</p>";
			}
		}
		?>
		<table class="bordered highlight">
			<th class="col1">№</th>
			<th>内容</th>
			<th>添加日期</th>
			<?php
			$sql = "SELECT * FROM note ORDER BY adddate DESC";
			$result = $conn->query($sql);
			if (mysqli_num_rows($result) > 0) {
				// 输出数据
				while ($row = mysqli_fetch_assoc($result)) {
					if ($row["isdelete"] == '0') {
						echo "<tr>";
						echo "<td class='col1'>" . $row["id"] . "</td>";
						echo "<td class='col2'>" . $row["data"] . "</td>";
						echo "<td class='col3'>" . $row["adddate"] . "</td>";
						echo "</tr>";
					} else {
						echo "<tr>";
						echo "<td class='col1'>" . $row["id"] . "</td>";
						echo "<td class='col2 deleted'>" . $row["data"] . "</td>";
						echo "<td class='col3'>" . $row["adddate"] . "</td>";
						echo "</tr>";
					}
				}
			} else {
				echo "0 结果";
			}
			$conn->close();
			?>
		</table>
	</div>

	<footer class="page-footer white">
		<div class="row">
			<div class="input-field col s10">
				<i class="material-icons prefix">mode_edit</i>
				<input placeholder="上限100字符" id="data" type="text" length="100" class="validate">
				<label for="data">笔记</label>
			</div>
			<div id="subbtn" class="col s1">
				<button id="submit" type="submit" class="btn-floating btn-large waves-effect waves-light light-blue lighten-2">
					<i class="material-icons">done</i>
				</button>
			</div>
		</div>
	</footer>
</body>

</html>
