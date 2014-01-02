<?php
/***********************************************************************/

// Some info about your mod.
$mod_title      = 'Cash Mod';
$mod_version    = '1.5.2';
$release_date   = '2006-03-26';
$author         = 'Pandark (Apache Kof)';
$author_email   = 'apache.kof@gmail.com';

// Versions of PunBB this mod was created for. Minor variations (i.e. 1.2.4 vs 1.2.5) will be allowed, but a warning will be displayed.
$punbb_versions	= array('1.5.4');

// Set this to false if you haven't implemented the restore function (see below)
$mod_restore	= true;


// This following function will be called when the user presses the "Install" button
function install()
{
	global $db, $db_type, $pun_config;

	$db->query("ALTER TABLE ".$db->prefix."users ADD cm_cash BIGINT(255) NOT NULL DEFAULT 0") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("ALTER TABLE ".$db->prefix."users ADD cm_bank BIGINT(255) NOT NULL DEFAULT 0") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("ALTER TABLE ".$db->prefix."users ADD cm_interest BIGINT(255) NOT NULL DEFAULT ".time()."") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());

	$db->query("ALTER TABLE ".$db->prefix."forums ADD cm_cpp BIGINT(255) NOT NULL DEFAULT 1") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("ALTER TABLE ".$db->prefix."forums ADD cm_cpt BIGINT(255) NOT NULL DEFAULT 3") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());

	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_lottery_chance', conf_value='5'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_bank', conf_value='1'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_lottery', conf_value='1'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_cur_name', conf_value='dollars'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_lottery_cost', conf_value='5'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_lottery_pot', conf_value='0'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_interest', conf_value='2'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_lottery_lastwon', conf_value='No one has won yet.'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_intereste', conf_value='1'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	$db->query("INSERT INTO ".$db->prefix."config SET conf_name='cm_last_win', conf_value='1'") or error('Unable to add column "some_column" to table "some_table"', __FILE__, __LINE__, $db->error());
	generate_config_cache();
}

// This following function will be called when the user presses the "Restore" button (only if $mod_uninstall is true (see above))
function restore()
{
	global $db, $db_type, $pun_config;

	$db->query("ALTER TABLE ".$db->prefix."users DROP cm_cash") or error('Unable to drop column "cm_cash" to table "users"', __FILE__, __LINE__, $db->error());
	$db->query("ALTER TABLE ".$db->prefix."users DROP cm_bank") or error('Unable to add column "cm_bank" to table "users"', __FILE__, __LINE__, $db->error());
	$db->query("ALTER TABLE ".$db->prefix."users DROP cm_interest") or error('Unable to add column "cm_interest" to table "users"', __FILE__, __LINE__, $db->error());

	$db->query("ALTER TABLE ".$db->prefix."forums DROP cm_cpp") or error('Unable to add column "cm_cpp" to table "forums"', __FILE__, __LINE__, $db->error());
	$db->query("ALTER TABLE ".$db->prefix."forums DROP cm_cpt") or error('Unable to add column "cm_cpt" to table "forums"', __FILE__, __LINE__, $db->error());

	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_lottery_chance'") or error('Unable to delete config setting "cm_lottery_chance"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_bank'") or error('Unable to delete config setting "cm_bank"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_lottery'") or error('Unable to delete config setting "cm_lottery"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_cur_name'") or error('Unable to delete config setting "cm_cur_name"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_lottery_cost'") or error('Unable to delete config setting "cm_lottery_cost"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_lottery_pot'") or error('Unable to delete config setting ""', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_interest'") or error('Unable to delete config setting "cm_lottery_pot"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_lottery_lastwon'") or error('Unable to delete config setting "cm_lottery_lastwon"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_intereste'") or error('Unable to delete config setting "cm_intereste"', __FILE__, __LINE__, $db->error());
	$db->query("DELETE FROM ".$db->prefix."config WHERE conf_name='cm_last_win'") or error('Unable to delete config setting "cm_last_win"', __FILE__, __LINE__, $db->error());
}

/***********************************************************************/

// DO NOT EDIT ANYTHING BELOW THIS LINE!


// Circumvent maintenance mode
define('PUN_TURN_OFF_MAINT', 1);
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
if (!function_exists('generate_config_cache')) // If the file include/cache.php wasn't already included, include it now
	include PUN_ROOT.'include/cache.php';

// We want the complete error message if the script fails
if (!defined('PUN_DEBUG'))
	define('PUN_DEBUG', 1);

// Make sure we are running a PunBB version that this mod works with
$version_warning = false;
if(!in_array($pun_config['o_cur_version'], $punbb_versions))
{
	foreach ($punbb_versions as $temp)
	{
		if (substr($temp, 0, 3) == substr($pun_config['o_cur_version'], 0, 3))
		{
			$version_warning = true;
			break;
		}
	}

	if (!$version_warning)
		exit('You are running a version of PunBB ('.$pun_config['o_cur_version'].') that this mod does not support. This mod supports PunBB versions: '.implode(', ', $punbb_versions));
}


$style = (isset($cur_user)) ? $cur_user['style'] : $pun_config['o_default_style'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $mod_title ?> installation</title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $pun_config['o_default_style'].'.css' ?>" />
</head>
<body>

<div id="punwrap">
<div id="puninstall" class="pun" style="margin: 10% 20% auto 20%">

<?php

if (isset($_POST['form_sent']))
{
	if (isset($_POST['install']))
	{
		// Run the install function (defined above)
		install();

?>
<div class="block">
	<h2><span>Installation successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>Your database has been successfully prepared for <?php echo pun_htmlspecialchars($mod_title) ?>. See readme.txt for further instructions.</p>
		</div>
	</div>
</div>
<?php

	}
	else
	{
		// Run the restore function (defined above)
		restore();

?>
<div class="block">
	<h2><span>Restore successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>Your database has been successfully restored.</p>
		</div>
	</div>
</div>
<?php

	}
}
else
{

?>
<div class="blockform">
	<h2><span>Mod installation</span></h2>
	<div class="box">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?foo=bar">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<p>This script will update your database to work with the following modification:</p>
				<p><strong>Mod title:</strong> <?php echo pun_htmlspecialchars($mod_title).' '.$mod_version ?></p>
				<p><strong>Author:</strong> <?php echo pun_htmlspecialchars($author) ?> (<a href="mailto:<?php echo pun_htmlspecialchars($author_email) ?>"><?php echo pun_htmlspecialchars($author_email) ?></a>)</p>
				<p><strong>Disclaimer:</strong> Mods are not officially supported by PunBB. Mods generally can't be uninstalled without running SQL queries manually against the database. Make backups of all data you deem necessary before installing.</p>
<?php if ($mod_restore): ?>				<p>If you've previously installed this mod and would like to uninstall it, you can click the restore button below to restore the database.</p>
<?php endif; ?><?php if ($version_warning): ?>				<p style="color: #a00"><strong>Warning:</strong> The mod you are about to install was not made specifically to support your current version of PunBB (<?php echo $pun_config['o_cur_version']; ?>). However, in most cases this is not a problem and the mod will most likely work with your version as well. If you are uncertain about installning the mod due to this potential version conflict, contact the mod author.</p>
<?php endif; ?>			</div>
			<p><input type="submit" name="install" value="Install" /><?php if ($mod_restore): ?><input type="submit" name="restore" value="Restore" /><?php endif; ?></p>
		</form>
	</div>
</div>
<?php

}

?>

</div>
</div>

</body>
</html>