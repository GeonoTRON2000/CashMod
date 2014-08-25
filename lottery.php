<?PHP

define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'lang/'.$pun_user['language'].'/cash.php';
if (!function_exists('generate_config_cache')) // If the file include/cache.php wasn't already included, include it now
	require PUN_ROOT.'include/cache.php';

if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);

$page_title = array(pun_htmlspecialchars($pun_config['o_board_title']), $lang_common['Lottery']);
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

if ($pun_config['cm_lottery'] == 0)
	message($lang_cash['Bank_disabled']);

if (isset($_POST['submit'])) {
	if ($pun_user['cm_cash'] < $pun_config['cm_lottery_cost'])
		message($lang_cash['Not_enough'].' '.$pun_config['cm_cur_name'].' '.$lang_cash['To_buy_ticket'].'.');
	if (rand(1, 100) <= $pun_config['cm_lottery_chance']) {
		// They win!
		$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash+('.$pun_config['cm_lottery_pot'].'-'.$pun_config['cm_lottery_cost'].') WHERE id='.$pun_user['id'].' LIMIT 1');
		$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$pun_config['cm_lottery_cost'].' WHERE conf_name=\'cm_lottery_pot\' LIMIT 1');
		$db->query('UPDATE '.$db->prefix.'config SET conf_value=\''.$pun_user['username'].' '.$lang_cash['Last_winner_received'].' '.$pun_config['cm_lottery_pot'].' '.$pun_config['cm_cur_name'].'.\' WHERE conf_name=\'cm_lottery_pot\' LIMIT 1');
echo '
	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_cash['Welcome_lottery'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="lottery.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['You_won'].'</legend>
						<div class="infldset">
							<div>'.$lang_cash['You_won_you_received'].' '.number_format($pun_config['cm_lottery_pot']).' '.$pun_config['cm_cur_name'].'.</div>
							<div><br /><input type="submit" name="submit" value="'.$lang_cash['Try_again'].'" tabindex="2" /></div>
							<div><br /><a href="lottery.php">'.$lang_common['Go back'].'</a>.</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
';
		generate_config_cache();

	} else {
		// This things a scam...
		$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash-'.$pun_config['cm_lottery_cost'].' WHERE id='.$pun_user['id'].' LIMIT 1');
		$db->query('UPDATE '.$db->prefix.'config SET conf_value=conf_value+'.$pun_config['cm_lottery_cost'].' WHERE conf_name=\'cm_lottery_pot\' LIMIT 1');
echo '
	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_cash['Welcome_lottery'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="lottery.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['You_lost'].'</legend>
						<div class="infldset">
							<div>'.$lang_cash['You_lost_you_received'].'</div>';
if ($pun_config['cm_last_win'] == 1)
echo '							<div><br />'.$pun_config['cm_lottery_lastwon'].'</div>';
echo '
							<div>Current Pot: '.number_format($pun_config['cm_lottery_pot']).'</div>
							<div><br /><input type="submit" name="submit" value="'.$lang_cash['Try_again'].'" tabindex="2" /></div>
							<div><br /><a href="lottery.php">'.$lang_common['Go back'].'</a>.</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
';
		generate_config_cache();
	
	}

} else {
echo '
	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_cash['Welcome_lottery'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="lottery.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['Buy_ticket'].'</legend>
						<div class="infldset">
							<div>'.ucwords($pun_config['cm_cur_name']).': '.number_format($pun_user['cm_cash']).'</div>
							<div>'.ucwords($pun_config['cm_cur_name']).' '.$lang_cash['Needed'].': '.$pun_config['cm_lottery_cost'].'</div>
							<div><a href="bank.php">'.$lang_common['Bank'].'</a>: '.number_format($pun_user['cm_bank']).'</div>
							<div>Current pot: '.number_format($pun_config['cm_lottery_pot']).'</div>
							<div><br /><input type="submit" name="submit" value="'.$lang_cash['Buy'].'" tabindex="2" /></div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
';



}

require PUN_ROOT.'footer.php';
