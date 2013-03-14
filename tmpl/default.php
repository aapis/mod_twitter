<?php
/**
 * @subpackage	mod_twitter
 * @license		WTFPL
 */

// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
?>

<div class="mod_twitter clearfix">
	<?php if($module->showtitle): ?>
		<div class="clearfix mod_latest_news_title">
			<span class="icon icon-twitter ir">Twitter</span>
			<h2 class="title"><?php echo $module->title; ?></h2>
		</div>
	<?php endif; ?>
	<ul class="twitter-feed <?php echo $moduleclass_sfx; ?>">
		<?php if(count($list)): ?>
			<?php foreach ($list as $item) : ?>
				<?php if(isset($item->Status) && $item->Status == 'Error'): ?>
					<li>
						<?php echo $item->Message; ?>
					</li>
				<?php else : ?>
				<?php
					$item->text = preg_replace('/(http\:\/\/[a-zA-Z0-9\.\/]+[a-zA-Z0-9\/])/', '<a href="$1" target="_blank">$1</a>', $item->text);
					$item->text = preg_replace('/\#([a-zA-Z0-9]+)/', '<a href="https://twitter.com/search?q=$1" target="_blank">#$1</a>', $item->text);
					$item->text = preg_replace('/\@([a-zA-Z0-9]+)/', '<a href="https://twitter.com/$1" target="_blank">@$1</a>', $item->text);
				?>
					<li>
						<span class="user"><?php echo $item->user->name;?> <a href="http://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank">@<?php echo $item->user->screen_name; ?></a></span><br />
						<span class="leadin"><?php echo $item->text; ?></span>
						<br />
						<span class="postdate"><em><?php echo date('F jS, Y', strtotime($item->created_at)); ?></em></span>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<p>There are no recent tweets.</p>
		<?php endif; ?>
	</ul>
	<p><a href="https://twitter.com/<?php echo $params->get('screen_name'); ?>" class="follow_us" target="_blank">Follow us on Twitter</p></a>
</div>