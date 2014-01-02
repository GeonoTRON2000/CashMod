##
##
##        Mod title:  Cash Mod
##
##      Mod version:  1.5.2
##   Works on FluxBB:  1.5.4
##     Release date:  2013-10-01
##           Author:  GeonoTRON2000 + Apache Kof (Pandark) + Gary(13579) Schilling
##
##      Description:  This mod gives people "cash" for their posts.
##
##       Affects DB:  Yes
##
##   Affected files:  post.php
##                    viewtopic.php
##                    delete.php
##                    profile.php
##
##            Notes:  The Original Cash Mod 1.0.1 was made by Gary(13579) Schilling.
##                    Localisation of its and other changes 1.0.1 from made by Apache Kof (Pandark).
##                    Upgrade to 1.5.4 made by GeonoTRON2000.
##
##       DISCLAIMER:  Please note that 'mods' are not officially supported by
##                    FluxBB. Installation of this modification is done at your
##                    own risk. Backup your forum database and any and all
##                    applicable files before proceeding.
##


#
#---------[ 1. UPLOAD ]---------------------------------------------------
#

install_mod.php to ./
donate.php to ./
bank.php to ./
lottery.php to ./
AP_Cash_Mod.php to ./plugins/
English/cash.php to ./lang/English/

#
#---------[ 2. RUN ]---------------------------------------------------
#

install_mod.php

#
#---------[ 3. DELETE ]---------------------------------------------------
#

install_mod.php

#
#---------[ 4. OPEN ]---------------------------------------------------
#

viewtopic.php

#
#---------[ 5. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT u.email, u.title, u.url, u.location, u.signature, u.email_setting, u.num_posts, u.registered, u.admin_note, p.id, p.poster AS username, p.poster_id, p.poster_ip, p.poster_email, p.message, p.hide_smilies, p.posted, p.edited, p.edited_by, g.g_id, g.g_user_title, o.user_id AS is_on'.$db->prefix.'posts AS p INNER JOIN '.$db->prefix.'users AS u ON u.id=p.poster_id INNER JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id LEFT JOIN '.$db->prefix.'ono ON (o.user_id=u.id AND o.user_id!=1 AND o.idle=0) WHERE p.id IN ('.implode(',', $post_ids).') ORDER BY p.id', true) or error('Unable to fetch post info', __FILE__, __LINE__, $db->error());

#
#---------[ 6. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT u.cm_cash, u.cm_bank, u.email, u.title, u.url, u.location, u.signature, u.email_setting, u.num_posts, u.registered, u.admin_note, p.id, p.poster AS username, p.poster_id, p.poster_ip, p.poster_email, p.message, p.hide_smilies, p.posted, p.edited, p.edited_by, g.g_id, g.g_user_title, o.user_id AS is_on'.$db->prefix.'posts AS p INNER JOIN '.$db->prefix.'users AS u ON u.id=p.poster_id INNER JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id LEFT JOIN '.$db->prefix.'ono ON (o.user_id=u.id AND o.user_id!=1 AND o.idle=0) WHERE p.id IN ('.implode(',', $post_ids).') ORDER BY p.id', true) or error('Unable to fetch post info', __FILE__, __LINE__, $db->error());

#
#---------[ 7. FIND ]---------------------------------------------------
#

				$user_info[] = '<dd><span>'.$lang_topic['Posts'].' '.forum_number_format($cur_post['num_posts']).'</span></dd>';

#
#---------[ 8. AFTER, ADD ]---------------------------------------------------
#

			$user_info[] = '<dd><span>'.ucwords($pun_config['cm_cur_name']).': '.forum_number_format($cur_post['cm_cash']).'</span></dd>';
			if ($pun_config['cm_bank'] == 1)
				$user_info[] = '<dd><span>'.$lang_common['Bank'].': '.forum_number_format($cur_post['cm_bank']).'</span></dd>';

#
#---------[ 9. SAVE/UPLOAD ]---------------------------------------------------
#

viewtopic.php

#
#---------[ 10. OPEN ]---------------------------------------------------
#

post.php

#
#---------[ 11. FIND ]---------------------------------------------------
#

// Fetch some info about the topic and/or the forum
if ($tid)
	$result = $db->query('SELECT f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.subject, t.closed, s.user_id AS is_subscribed FROM '.$db->prefix.'topics AS t INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') LEFT JOIN '.$db->prefix.'topic_subscriptions AS s ON (t.id=s.topic_id AND s.user_id='.$pun_user['id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND t.id='.$tid) or error('Unable to fetch forum info', __FILE__, __LINE__, $db->error());
else
	$result = $db->query('SELECT f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics FROM '.$db->prefix.'forums AS f LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND f.id='.$fid) or error('Unable to fetch forum info', __FILE__, __LINE__, $db->error());

#
#---------[ 12. REPLACE WITH ]---------------------------------------------------
#

// Fetch some info about the topic and/or the forum
if ($tid)
	$result = $db->query('SELECT f.cm_cpp, f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.subject, t.closed, s.user_id AS is_subscribed FROM '.$db->prefix.'topics AS t INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') LEFT JOIN '.$db->prefix.'topic_subscriptions AS s ON (t.id=s.topic_id AND s.user_id='.$pun_user['id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND t.id='.$tid) or error('Unable to fetch forum info', __FILE__, __LINE__, $db->error());
else
	$result = $db->query('SELECT f.cm_cpt, f.id, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics FROM '.$db->prefix.'forums AS f LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND f.id='.$fid) or error('Unable to fetch forum info', __FILE__, __LINE__, $db->error());

#
#---------[ 13. FIND ]---------------------------------------------------
#

		// If the posting user is logged in, increment his/her post count
		if (!$pun_user['is_guest'])
		{
			$db->query('UPDATE '.$db->prefix.'users SET num_posts=num_posts+1, last_post='.$now.' WHERE id='.$pun_user['id']) or error('Unable to update user', __FILE__, __LINE__, $db->error());

			// Promote this user to a new group if enabled
			if ($pun_user['g_promote_next_group'] != 0 && $pun_user['num_posts'] + 1 >= $pun_user['g_promote_min_posts'])
			{
				$new_group_id = $pun_user['g_promote_next_group'];
				$db->query('UPDATE '.$db->prefix.'users SET group_id='.$new_group_id.' WHERE id='.$pun_user['id']) or error('Unable to promote user to new group', __FILE__, __LINE__, $db->error());
			}

			// Topic tracking stuff...
			$tracked_topics = get_tracked_topics();
			$tracked_topics['topics'][$new_tid] = time();
			set_tracked_topics($tracked_topics);
		}
		else
		{
			$db->query('UPDATE '.$db->prefix.'online SET last_post='.$now.' WHERE ident=\''.$db->escape(get_remote_address()).'\'' ) or error('Unable to update user', __FILE__, __LINE__, $db->error());
		}

#
#---------[ 14. REPLACE WITH ]---------------------------------------------------
#

		// If the posting user is logged in, increment his/her post count
		if (!$pun_user['is_guest'])
		{
			$db->query('UPDATE '.$db->prefix.'users SET num_posts=num_posts+1, last_post='.$now.' WHERE id='.$pun_user['id']) or error('Unable to update user', __FILE__, __LINE__, $db->error());

			// Promote this user to a new group if enabled
			if ($pun_user['g_promote_next_group'] != 0 && $pun_user['num_posts'] + 1 >= $pun_user['g_promote_min_posts'])
			{
				$new_group_id = $pun_user['g_promote_next_group'];
				$db->query('UPDATE '.$db->prefix.'users SET group_id='.$new_group_id.' WHERE id='.$pun_user['id']) or error('Unable to promote user to new group', __FILE__, __LINE__, $db->error());
			}

			// Topic tracking stuff...
			$tracked_topics = get_tracked_topics();
			$tracked_topics['topics'][$new_tid] = time();
			set_tracked_topics($tracked_topics);
      if ($tid)
			{
				$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash+'.$cur_posting['cm_cpp'].' WHERE id='.$pun_user['id']) or error('Unable to update user', __FILE__, __LINE__, $db->error());
				redirect('viewtopic.php?pid='.$new_pid.'#p'.$new_pid, $lang_post['Post redirect'].'<br />'.$lang_cash['You_won'].' '.$cur_posting['cm_cpp'].' '.$pun_config['cm_cur_name'].'.');
			}
			else if($fid)
			{
				$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash+'.$cur_posting['cm_cpt'].' WHERE id='.$pun_user['id']) or error('Unable to update user', __FILE__, __LINE__, $db->error());
				redirect('viewtopic.php?pid='.$new_pid.'#p'.$new_pid, $lang_post['Post redirect'].'<br />'.$lang_cash['You_won'].' '.$cur_posting['cm_cpt'].' '.$pun_config['cm_cur_name'].'.');
			}
		}
		else
		{
			$db->query('UPDATE '.$db->prefix.'onlast_post='.$now.' WHERE ident=\''.$db->escape(get_remote_address()).'\'' ) or error('Unable to update user', __FILE__, __LINE__, $db->error());
		}

#
#---------[ 15. SAVE/UPLOAD ]---------------------------------------------------
#

post.php

#
#---------[ 16. OPEN ]---------------------------------------------------
#

delete.php

#
#---------[ 17. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT f.id AS fid, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.id AS tid, t.subject, t.first_post_id, t.closed, p.posted, p.poster, p.poster_id, p.message, p.hide_smilies FROM '.$db->prefix.'posts AS p INNER JOIN '.$db->prefix.'topics AS t ON t.id=p.topic_id INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND p.id='.$id) or error('Unable to fetch post info', __FILE__, __LINE__, $db->error());

#
#---------[ 18. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT f.cm_cpp, f.cm_cpt, f.id AS fid, f.forum_name, f.moderators, f.redirect_url, fp.post_replies, fp.post_topics, t.id AS tid, t.subject, t.first_post_id, t.closed, p.posted, p.poster, p.poster_id, p.message, p.hide_smilies FROM '.$db->prefix.'posts AS p INNER JOIN '.$db->prefix.'topics AS t ON t.id=p.topic_id INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND p.id='.$id) or error('Unable to fetch post info', __FILE__, __LINE__, $db->error());

#
#---------[ 19. FIND ]---------------------------------------------------
#

		// Delete the topic and all of its posts
		delete_topic($cur_post['tid']);
		update_forum($cur_post['fid']);

#
#---------[ 20. AFTER, ADD ]---------------------------------------------------
#

		$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash-'.$cur_post['cm_cpt'].' WHERE id='.$cur_post['poster_id']) or error('Unable to modify user\'s cash', __FILE__, __LINE__, $db->error());

#
#---------[ 21. FIND ]---------------------------------------------------
#

		// Delete just this one post
		delete_post($id, $cur_post['tid']);
		update_forum($cur_post['fid']);

#
#---------[ 22. AFTER, ADD ]---------------------------------------------------
#

		$db->query('UPDATE '.$db->prefix.'users SET cm_cash=cm_cash-'.$cur_post['cm_cpp'].' WHERE id='.$cur_post['poster_id']) or error('Unable to modify user\'s cash', __FILE__, __LINE__, $db->error());

#
#---------[ 23. SAVE/UPLOAD ]---------------------------------------------------
#

delete.php

#
#---------[ 24. OPEN ]---------------------------------------------------
#

profile.php

#
#---------[ 25. FIND ]---------------------------------------------------
#

				// We only allow administrators to update the post count
				if ($pun_user['g_id'] == PUN_ADMIN)
					$form['num_posts'] = intval($_POST['num_posts']);
			}

#
#---------[ 26. REPLACE WITH ]---------------------------------------------------
#

				// We only allow administrators to update the post count
				if ($pun_user['g_id'] == PUN_ADMIN)
				{
					$form['num_posts'] = intval($_POST['num_posts']);
					$form['cm_cash'] = intval($_POST['cm_cash']);
					$form['cm_bank'] = intval($_POST['cm_bank']);
				}
			}

#
#---------[ 27. FIND ]---------------------------------------------------
#

$result = $db->query('SELECT u.username, u.email, u.title, u.realname, u.url, u.jabber, u.icq, u.msn, u.aim, u.yahoo, u.location, u.signature, u.disp_topics, u.disp_posts, u.email_setting, u.notify_with_post, u.auto_notify, u.show_smilies, u.show_img, u.show_img_sig, u.show_avatars, u.show_sig, u.timezone, u.dst, u.language, u.style, u.num_posts, u.last_post, u.registered, u.registration_ip, u.admin_note, u.date_format, u.time_format, u.last_visit, g.g_id, g.g_user_title, g.g_moderator FROM '.$db->prefix.'users AS u LEFT JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id WHERE u.id='.$id) or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());

#
#---------[ 28. REPLACE WITH ]---------------------------------------------------
#

$result = $db->query('SELECT u.cm_cash, u.cm_bank, u.username, u.email, u.title, u.realname, u.url, u.jabber, u.icq, u.msn, u.aim, u.yahoo, u.location, u.signature, u.disp_topics, u.disp_posts, u.email_setting, u.notify_with_post, u.auto_notify, u.show_smilies, u.show_img, u.show_img_sig, u.show_avatars, u.show_sig, u.timezone, u.dst, u.language, u.style, u.num_posts, u.last_post, u.registered, u.registration_ip, u.admin_note, u.date_format, u.time_format, u.last_visit, g.g_id, g.g_user_title, g.g_moderator FROM '.$db->prefix.'users AS u LEFT JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id WHERE u.id='.$id) or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());

#
#---------[ 29. FIND ]---------------------------------------------------
#

	if ($posts_field != '')
	{
		$user_activity[] = '<dt>'.$lang_common['Posts'].'</dt>';
		$user_activity[] = '<dd>'.$posts_field.'</dd>';
	}

#
#---------[ 30. AFTER, ADD ]---------------------------------------------------
#

	// Cash Mod
	$user_activity[] = '<dt>'.ucwords($pun_config['cm_cur_name']).'</dt>';
	$user_activity[] = '<dd>'.forum_number_format($user['cm_cash']).'</dd>';
	$user_activity[] = '<dt>'.$lang_common['Bank'].'</dt>';
	$user_activity[] = '<dd>'.forum_number_format($user['cm_bank']).'</dd>';

#
#---------[ 31. SAVE/UPLOAD ]---------------------------------------------------
#

profile.php

#
#---------[ 32. OPEN ]---------------------------------------------------
#

lang/English/common.php

#
#---------[ 33. FIND ]---------------------------------------------------
#

'Mark all as read'					=>	'Mark all topics as read',
'Mark forum read'					=>	'Mark this forum as read',
'Title separator'					=>	' / ',

#
#---------[ 34. AFTER, ADD ]---------------------------------------------------
#

// Cash Mod
'Bank'				=>	'Bank',
'Lottery'				=>	'Lottery',
'Donate'				=>	'Donate',

#
#---------[ 35. SAVE/UPLOAD ]---------------------------------------------------
#

lang/English/common.php