{* コンテンツ *}
<h2>{$time}のニュース</h2>
<ul>
	{foreach item=item from=$news}
	<li>
	   <a href="{$item.link}">{$item.title}</a><br />
	   {$item.description}
	</li>
	{/foreach}
</ul>
<div style="text-align: center">{$pager.links.all}</div>
{* /コンテンツ *}