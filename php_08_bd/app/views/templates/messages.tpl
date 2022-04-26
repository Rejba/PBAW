{if $messages->isError()}
<div class="messages error">
	<ol>
	{foreach $messages->getErrors() as $error}
	{strip}
		<li>{$error}</li>
	{/strip}
	{/foreach}
	</ol>
</div>
{/if}
{if $messages->isInfo()}
<div class="messages info bottom-margin">
	<ol>
	{foreach $messages->getInfos() as $info}
	{strip}
		<li>{$info}</li>
	{/strip}
	{/foreach}
	</ol>
</div>
{/if}