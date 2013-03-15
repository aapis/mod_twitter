<?php
/**
 * @subpackage	mod_twitter
 * @license		WTFPL
 */

// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
?>

<style type="text/css">
	.mod_twitter {
		margin-bottom: 5px;
	}

	.mod_twitter li {
		list-style: none;
	}

	.mod_twitter ul {
		padding: 0px;
		margin-top: 0px;		
	}
</style>

<div class="mod_twitter clearfix">
	<?php if($module->showtitle): ?>
		<div class="clearfix mod_latest_news_title">
			<h2 class="title"><?php echo $module->title; ?></h2>
		</div>
	<?php endif; ?>
	<ul class="twitter-feed <?php echo $moduleclass_sfx; ?>">
		<?php if(count($list) > 0): ?>
			<?php foreach ($list->results as $item) : ?>
				<?php if(isset($item->Status) && $item->Status == 'Error'): ?>
					<li>
						<?php echo $item->Message; ?>
					</li>
				<?php else : ?>
				<?php
					$item->text = preg_replace('/(http\:\/\/[a-zA-Z0-9\.\/]+[a-zA-Z0-9\/])/', '<a href="$1" target="_blank">$1</a>', $item->text);
					$item->text = preg_replace('/\#([a-zA-Z0-9]+)/', '<a href="https://twitter.com/search?q=%23$1" target="_blank">#$1</a>', $item->text);
					$item->text = preg_replace('/\@([a-zA-Z0-9]+)/', '<a href="https://twitter.com/$1" target="_blank">@$1</a>', $item->text);
				?>
					<li>
						<?php if($params->get('show_user')): ?>
							<p class="user"><?php echo $item->user->name;?> <a href="http://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank">@<?php echo $item->user->screen_name; ?></a></p>
						<?php endif; ?>
						<p class="leadin"><?php echo $item->text; ?></p>
						<?php if($params->get('show_postdate', '1')): ?>
							<span class="postdate"><em><?php echo date($params->get('postdate_format', 'F jS, Y'), strtotime($item->created_at)); ?></em></span>
						<?php endif; ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<p>There are no recent tweets.</p>
		<?php endif; ?>
	</ul>
	<?php if($params->get('show_follow_us_link')): ?>
		<p><a href="https://twitter.com/<?php echo $params->get('screen_name'); ?>" class="follow_us" target="_blank"><?php echo $params->get('follow_us_link_text'); ?></p></a>
	<?php endif; ?>
</div>