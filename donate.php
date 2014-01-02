<?PHP

define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'lang/'.$pun_user['language'].'/cash.php';

if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);

$page_title = array(pun_htmlspecialchars($pun_config['o_board_title']), $lang_common['Donate']);
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

if (isset($_POST['submit'])) {
	$amount = intval($_POST['amount']);
	$query = $db->query('SELECT id, username FROM '.$db->prefix.'users WHERE username=\''.pun_htmlspecialchars($_POST['username']).'\' LIMIT 1');
	if (!$db->num_rows($query))
		message($lang_cash['User_not_exist']);

	$user = $db->fetch_assoc($query);
	if ($pun_user['cm_cash'] < $amount || $amount < 0)
		message($lang_cash['Not_enough'].' '.$pun_config['cm_cur_name'].'.');
	$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash+'.$amount.' WHERE id='.$user['id'].' LIMIT 1');
	$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash-'.$amount.' WHERE id='.$pun_user['id'].' LIMIT 1');
echo '	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_common['Donate'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="donate.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['Donations'].'</legend>
						<div class="infldset">
							<div>'.$lang_cash['Donation_sent_to'].' '.$user['username'].' '.$lang_cash['with_amount_of'].' '.number_format($amount).' '.$pun_config['cm_cur_name'].'.</div>
							<div><a href="bank.php">'.$lang_common['Go back'].'</a>.</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>';

} else {
	if (isset($_GET['userid'])) {
		$userid = intval($_GET['userid']);
		$query = $db->query('SELECT id, username FROM '.$db->prefix.'users WHERE id='.$userid.' LIMIT 1');
		if (!$db->num_rows($query))
			$userid = 0;
		else
			$user = $db->fetch_assoc($query);
	} else
		$userid = 0;
echo '	<div id="bank" class="blockform">
		<h2 class="block2"><span>Donate</span></h2>
		<div class="box">
			<form id="bank" method="post" action="donate.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['Select_user_amount'].'</legend>
						<div class="infldset">';

	if ($userid == 0) {
echo '							<div>'.$lang_common['Username'].': <input type="input" name="username" value="" tabindex="2" /></div>';
	} else {
echo '							<div>'.$lang_common['Username'].': <input type="input" name="username" value="'.$user['username'].'" tabindex="2" /></div>';
	}
echo '							<div>'.$lang_cash['Amount'].': <input type="input" name="amount" value="0" tabindex="2" /></div>
							<div><br /><input type="submit" name="submit" value="'.$lang_common['Donate'].'" tabindex="2" /></div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>';



}

require PUN_ROOT.'footer.php';
