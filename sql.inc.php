<?php
if ($_POST) {
	$result = mysql_query($_POST["query"]); //! multiple commands
	if ($result === true) {
		redirect($SELF . "sql=", sprintf(lang('Query executed OK, %d row(s) affected.'), mysql_affected_rows()));
	}
	$error = mysql_error();
}
page_header(lang('SQL command'));

if ($_POST) {
	if (!$result) {
		echo "<p class='error'>" . lang('Error in query') . ": " . htmlspecialchars($error) . "</p>\n";
	} else {
		if (!mysql_num_rows($result)) {
			echo "<p class='message'>" . lang('No rows.') . "</p>\n";
		} else {
			echo "<table border='1' cellspacing='0' cellpadding='2'>\n";
			for ($i=0; $row = mysql_fetch_assoc($result); $i++) {
				if (!$i) {
					echo "<thead><tr><th>" . implode("</th><th>", array_map('htmlspecialchars', array_keys($row))) . "</th></tr></thead>\n";
				}
				echo "<tr>";
				foreach ($row as $val) {
					echo "<td>" . (isset($val) ? nl2br(htmlspecialchars($val)) : "<i>NULL</i>") . "</td>";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		mysql_free_result($result);
	}
}
?>
<form action="" method="post">
<p><textarea name="query" rows="20" cols="80"><?php echo htmlspecialchars($_POST["query"]); ?></textarea></p>
<p><input type="submit" value="<?php echo lang('Execute'); ?>" /></p>
</form>
