<?PHP

define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'lang/'.$pun_user['language'].'/cash.php';

if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);

$page_title = array(pun_htmlspecialchars($pun_config['o_board_title']), $lang_common['Bank']);
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';
$now = time();

if ($pun_config['cm_bank'] == 0)
	message($lang_cash['Bank_disabled']);

if (isset($_POST['withdraw'])) {
	$amount = intval($_POST['amount']);
	if ($amount <= 0)
		message($lang_cash['Invalid_amount']);
	if ($amount > $pun_user['cm_bank'])
		message($lang_cash['Not_enough'].' '.$pun_config['cm_cur_name'].' '.$lang_cash['In_bank'].'.');
	if ($pun_config['cm_intereste'] == 1)
		$db->query('UPDATE '.$db->prefix.'users SET cm_bank=(cm_bank+cm_bank*((('.$now.'-cm_interest)/86400)*'.$pun_config['cm_interest'].'/100))-'.$amount.', cm_cash=cm_cash+'.$amount.', cm_interest='.$now.' WHERE id='.$pun_user['id'].' LIMIT 1');
	else
		$db->query('UPDATE '.$db->prefix.'users SET cm_bank=cm_bank-'.$amount.', cm_cash=cm_cash+'.$amount.' WHERE id='.$pun_user['id'].' LIMIT 1');
echo '	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_cash['Welcome_bank'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="bank.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['Withdrawing'].'</legend>
						<div class="infldset">
							<div>'.$lang_cash['Withdrew_success'].' '.$amount.' '.$pun_config['cm_cur_name'].'.</div>
							<div><a href="bank.php">'.$lang_common['Go back'].'</a></div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>';

} elseif (isset($_POST['deposit'])) {
	$amount = intval($_POST['amount']);
	if ($amount <= 0)
		message($lang_cash['Invalid_amount']);
	if ($amount > $pun_user['cm_cash'])
		message($lang_cash['Not_enough'].' '.$pun_config['cm_cur_name'].'.');
	if ($pun_config['cm_intereste'] == 1)
		$db->query('UPDATE '.$db->prefix.'users SET cm_bank=(cm_bank+cm_bank*((('.$now.'-cm_interest)/86400)*'.$pun_config['cm_interest'].'/100))+'.$amount.', cm_cash=cm_cash-'.$amount.', cm_interest='.$now.' WHERE id='.$pun_user['id'].' LIMIT 1');
	else
		$db->query('UPDATE '.$db->prefix.'users SET cm_bank=cm_bank+'.$amount.', cm_cash=cm_cash-'.$amount.' WHERE id='.$pun_user['id'].' LIMIT 1');
echo '	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_cash['Welcome_bank'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="bank.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['Depositing'].'</legend>
						<div class="infldset">
							<div>'.$lang_cash['Deposit_succes'].' '.$amount.' '.$pun_config['cm_cur_name'].'.</div>
							<div><a href="bank.php">'.$lang_common['Go back'].'</a></div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>';


} else {
if ($pun_config['cm_intereste'] == 1)
	$amount = $pun_user['cm_bank'] * ((($now - $pun_user['cm_interest']) / 86400) * $pun_config['cm_interest'] / 100);

echo '	<div id="bank" class="blockform">
		<h2 class="block2"><span>'.$lang_cash['Welcome_bank'].'</span></h2>
		<div class="box">
			<form id="bank" method="post" action="bank.php">
				<div class="inform">
					<fieldset>
						<legend>'.$lang_cash['Deposit_or_Withdraw'].'</legend>
						<div class="infldset">
							<div>'.ucwords($pun_config['cm_cur_name']).': '.number_format($pun_user['cm_cash']).'</div>';
if ($pun_config['cm_intereste'] == 1)
echo '							<div>'.$lang_common['Bank'].': '.number_format($pun_user['cm_bank'] + $amount).' <i>('.$amount.' '.$lang_cash['Interest_waiting'].'.)</i></div>';
else
echo '							<div>'.$lang_common['Bank'].': '.number_format($pun_user['cm_bank']).'</div>';

echo '							<div>'.$lang_cash['Amount'].': <input type="text" name="amount" size="10" tabindex="1" /> <input type="submit" name="deposit" value="'.$lang_cash['Deposit'].'" tabindex="2" /> <input type="submit" name="withdraw" value="'.$lang_cash['Withdraw'].'" tabindex="2" /></div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>';


}


require PUN_ROOT.'footer.php';