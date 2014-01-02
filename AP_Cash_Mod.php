<?php
// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

if (!function_exists('generate_config_cache')) // If the file include/cache.php wasn't already included, include it now
	require PUN_ROOT.'include/cache.php';

// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define('PUN_PLUGIN_LOADED', 1);
generate_admin_menu($plugin);
$now = time();

if (isset($_GET['option']) && !isset($_POST['submit'])) {
	if ($_GET['option'] == 'general') {
?>

	<div class="blockform">
		<h2><span>Cash Mod</span></h2>
		<div class="box">
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
				<p class="submittop"><input type="submit" name="submit" value="Save changes" /></p>
				<div class="inform">
					<fieldset>

						<legend>Configuration</legend>
						<div class="infldset">
							<table class="aligntop" cellspacing="0">
								<tr>
									<th scope="row">Currency Name</th>
									<td>
										<input type="text" name="cur_name" size="50" maxlength="255" value="<?PHP echo $pun_config['cm_cur_name']; ?>" />
										<span>This is the name of the currency used. Please use lower case letters, eg. cash instead of Cash</span>

									</td>
								</tr>
								<tr>
									<th scope="row">Bank Enabled</th>
									<td>
										<input type="radio" name="bank_enabled" value="1"<?PHP if ($pun_config['cm_bank'] == 1) { echo ' checked="checked"'; } ?> />&nbsp;<strong>Yes</strong>&nbsp;&nbsp;&nbsp;<input type="radio" name="bank_enabled" value="0"<?PHP if ($pun_config['cm_bank'] == 0) { echo ' checked="checked"'; } ?> />&nbsp;<strong>No</strong>
										<span>If selected Yes, users will have the option of using the bank.</span>
									</td>
								</tr>
								<tr>
									<th scope="row">Lottery Enabled</th>
									<td>
										<input type="radio" name="lottery_enabled" value="1"<?PHP if ($pun_config['cm_lottery'] == 1) { echo ' checked="checked"'; } ?> />&nbsp;<strong>Yes</strong>&nbsp;&nbsp;&nbsp;<input type="radio" name="lottery_enabled" value="0"<?PHP if ($pun_config['cm_lottery'] == 0) { echo ' checked="checked"'; } ?> />&nbsp;<strong>No</strong>
										<span>If selected Yes, users will have the option of using the lottery.</span>
									</td>
								</tr>
							</table>
						</div>
					</fieldset>
				</div>
				<div class="inform">
					<fieldset>

						<legend>Bank Configuration</legend>
						<div class="infldset">
							<table class="aligntop" cellspacing="0">
								<tr>
									<th scope="row">Interest Enabled</th>
									<td>
										<input type="radio" name="intereste" value="1"<?PHP if ($pun_config['cm_intereste'] == 1) { echo ' checked="checked"'; } ?> />&nbsp;<strong>Yes</strong>&nbsp;&nbsp;&nbsp;<input type="radio" name="intereste" value="0"<?PHP if ($pun_config['cm_intereste'] == 0) { echo ' checked="checked"'; } ?> />&nbsp;<strong>No</strong>
										<span>When set to Yes, users will gain interest for having money in the bank.</span>
									</td>
								</tr>
								<tr>
									<th scope="row">Interest Amount</th>
									<td>
										<input type="text" name="interest" size="50" maxlength="255" value="<?PHP echo $pun_config['cm_interest']; ?>" />
										<span>This is the amount of interest (in percent) that the user will gain in a 24 hour period.</span>

									</td>
								</tr>

							</table>
						</div>
					</fieldset>
				</div>
				<div class="inform">
					<fieldset>

						<legend>Lottery Configuration</legend>
						<div class="infldset">
							<table class="aligntop" cellspacing="0">
								<tr>
									<th scope="row">Show last winner</th>
									<td>
										<input type="radio" name="last_win" value="1"<?PHP if ($pun_config['cm_last_win'] == 1) { echo ' checked="checked"'; } ?> />&nbsp;<strong>Yes</strong>&nbsp;&nbsp;&nbsp;<input type="radio" name="last_win" value="0"<?PHP if ($pun_config['cm_last_win'] == 0) { echo ' checked="checked"'; } ?> />&nbsp;<strong>No</strong>
										<span>If you want to show the last winner of the lottery, and how much they won.</span>
									</td>
								</tr>
								<tr>
									<th scope="row">Ticket Cost</th>
									<td>
										<input type="text" name="lottery_cost" size="50" maxlength="255" value="<?PHP echo $pun_config['cm_lottery_cost']; ?>" />
										<span>How much should it cost per ticket?</span>

									</td>
								</tr>
								<tr>
									<th scope="row">Lottery Chance</th>
									<td>
										<input type="text" name="lottery_chance" size="50" maxlength="255" value="<?PHP echo $pun_config['cm_lottery_chance']; ?>" />
										<span>The chance of winning a ticket (percent)</span>

									</td>
								</tr>
								<tr>
									<th scope="row">Lottery Pot</th>
									<td>
										<input type="text" name="lottery_pot" size="50" maxlength="255" value="<?PHP echo $pun_config['cm_lottery_pot']; ?>" />
										<span>Here you can edit how much money is currently in the pot.</span>

									</td>
								</tr>

							</table>
						</div>
					</fieldset>
				</div>
				<p class="submitend"><input type="submit" name="submit" value="Save changes" /></p>
			</form>
		</div>
	</div>


<?PHP
	}
	
	if ($_GET['option'] == 'cp') {
		$query = $db->query('SELECT * FROM '.$db->prefix.'forums ORDER BY disp_position');
		if (!$db->num_rows($query))
			message('There are currently not any forums.');
?>
	<div id="exampleplugin" class="blockform">
		<h2 class="block2"><span>Cash Mod</span></h2>
		<div class="box">
			<form id="example" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
			<div class="inform">
				<fieldset>
					<legend>Edit cash per topic/posts</legend>
					<div class="infldset">
						<table id="categoryedit" cellspacing="0" >
						<thead>
							<tr>
								<th class="tcl" scope="col">Forum Name</th>

								<th scope="col">Per Topic</th>
								<th scope="col">Per Post</th>
							</tr>
						</thead>
						<tbody>
<?PHP
		while ($forum = $db->fetch_assoc($query)) {
?>
							<tr><td><?PHP echo $forum['forum_name']; ?></td><td><input type="text" name="cpt_<?PHP echo $forum['id']; ?>" value="<?PHP echo $forum['cm_cpt']; ?>" size="3" maxlength="3" /></td><td><input type="text" name="cpp_<?PHP echo $forum['id']; ?>" value="<?PHP echo $forum['cm_cpp']; ?>" size="3" maxlength="3" /></td></tr>

<?PHP
		
		}
?>
						</tbody>
						</table>
						<div class="fsetsubmit"><input type="submit" name="submit" value="Update" /></div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
<?PHP

	}

} else if (isset($_GET['option']) && isset($_POST['submit'])) {

	if ($_GET['option'] == 'general') {
		$currency = pun_htmlspecialchars($_POST['cur_name']);
		$db->query('UPDATE '.$db->prefix.'users SET cm_bank=(cm_bank+cm_bank*((('.$now.'-cm_interest)/86400)*'.$pun_config['cm_interest'].'/100)), cm_interest='.$now.'') or error('Unable to update config', __FILE__, __LINE__, $db->error());

		$db->query('UPDATE '.$db->prefix.'config SET conf_value=\''.$currency.'\' WHERE conf_name=\'cm_cur_name\' LIMIT 1');
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['bank_enabled']).' WHERE conf_name=\'cm_bank\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['lottery_enabled']).' WHERE conf_name=\'cm_lottery\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['intereste']).' WHERE conf_name=\'cm_intereste\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['interest']).' WHERE conf_name=\'cm_interest\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['last_win']).' WHERE conf_name=\'cm_last_win\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['lottery_cost']).' WHERE conf_name=\'cm_lottery_cost\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['lottery_pot']).' WHERE conf_name=\'cm_lottery_pot\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.intval($_POST['lottery_chance']).' WHERE conf_name=\'cm_lottery_chance\' LIMIT 1') or error('Unable to update config', __FILE__, __LINE__, $db->error());
		generate_config_cache();
?>
	<div id="exampleplugin" class="blockform">
		<h2 class="block2"><span>Cash Mod</span></h2>
		<div class="box">
			<form id="example" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
				<div class="inform">
					<fieldset>
						<legend>Select your choice.</legend>
						<div class="infldset">
							<div>Cash mod config updated.</div>
							<div><a href="<?php echo $_SERVER['REQUEST_URI'] ?>">Go back</a>.</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
<?PHP
	}
	
	if ($_GET['option'] == 'cp') {
		$query = $db->query('SELECT * FROM '.$db->prefix.'forums ORDER BY disp_position');
		if (!$db->num_rows($query))
			message('There are currently not any forums.');
		while ($forum = $db->fetch_assoc($query)) {
			if (isset($_POST['cpt_'.$forum['id']])) {
				$db->query('UPDATE '.$db->prefix.'forums SET cm_cpt='.intval($_POST['cpt_'.$forum['id']]).' WHERE id='.$forum['id'].' LIMIT 1') or error('Unable to update forums', __FILE__, __LINE__, $db->error());
			}
			if (isset($_POST['cpp_'.$forum['id']])) {
				$db->query('UPDATE '.$db->prefix.'forums SET cm_cpp='.intval($_POST['cpp_'.$forum['id']]).' WHERE id='.$forum['id'].' LIMIT 1') or error('Unable to update forums', __FILE__, __LINE__, $db->error());
			}
		}
?>
	<div id="exampleplugin" class="blockform">
		<h2 class="block2"><span>Cash Mod</span></h2>
		<div class="box">
			<form id="example" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
				<div class="inform">
					<fieldset>
						<legend>Select your choice.</legend>
						<div class="infldset">
							<div>Forums updated.</div>
							<div><a href="<?php echo $_SERVER['REQUEST_URI'] ?>">Go back</a>.</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>

<?PHP

	}


} else {

?>
	<div id="exampleplugin" class="blockform">
		<h2><span>Cash Mod Plugin</span></h2>
		<div class="box">
			<div class="inbox">
				<p>Use this to change any settings about the cash mod.</p>
			</div>
		</div>

		<h2 class="block2"><span>Cash Mod</span></h2>
		<div class="box">
			<form id="example" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
				<div class="inform">
					<fieldset>
						<legend>Select your choice.</legend>
						<div class="infldset">
							<ul>
							<li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>&option=general">General Config</a></li>
							<li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>&option=cp">Amount of cash per post/topic</a></li>
							</ul>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
<?php

}
