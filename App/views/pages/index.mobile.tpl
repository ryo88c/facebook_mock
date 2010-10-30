<a name=”top” id=”top”></a>
{* メニュー *}
<div style="text-align: center; color: #3366cc; background-color: #e5ecf9;"><b>ﾒﾆｭｰ1</b></div>
{* コンテンツ *}
<span style="font-size: large">{$time}のニュース</span>
<ul>
	{foreach item=item from=$news}
	<li><a href="{$item.link}">{$item.title}</a></li>
	{/foreach}
</ul>
<div align="center">{$pager.links.all}</div>
<a href="#top"><span style="color: orange;">topへ</span></a>
{* /コンテンツ *}