{extends file="main.tpl"}
{* przy zdefiniowanych folderach nie trzeba już podawać pełnej ścieżki *}

{block name=footer}Stopka{/block}

{block name=content}

<h3>Prosty kalkulator</h2>


<form class="pure-form pure-form-stacked" action="{$conf->action_root}calcCompute" method="post">
	<fieldset>
		<div style="position: relative;left: 5%;">
			<label for="s">Kwota kredytu: </label>
			<input id="s" type="text" name="sum" value="{$form->sum}"/><br/><br/>
		</div>
		<div style="position: relative;left: 40%; top:-99px;">
			<label for="p">Okres spłaty: </label>
			<input id="p" type="text" name="period" placeholder="Ile lat" value="{$form->period}"/><br/><br/>
		</div>
		<div style="position: relative;left: 75%; top:-200px;">
			<label for="per">Oprocentowanie: </label>
			<input id="per" type="text" name="percent" placeholder="6.5"
				   title="Używaj tylko kropki. Maksymalnie dwie liczby po kropce.  " value="{$form->percent}"/><br/>
		</div>
	</fieldset>
	<button style="position: relative;left: 43%; top:-99px;font-size: 175%;" type="submit"
			class="button-xlarge pure-button "><i class="fa-solid fa-calculator fa-lg fa-beat"></i> Oblicz
	</button>
</form>

<div class="messages">

{* wyświeltenie listy błędów, jeśli istnieją *}
{if $msgs->isError()}
	<h4>Wystąpiły błędy: </h4>
	<ol class="err">
	{foreach $msgs->getErrors() as $err}
	{strip}
		<li>{$err}</li>
	{/strip}
	{/foreach}
	</ol>
{/if}

{* wyświeltenie listy informacji, jeśli istnieją *}
{if $msgs->isInfo()}
	<h4>Informacje: </h4>
	<ol class="inf">
	{foreach $msgs->getInfos() as $inf}
	{strip}
		<li>{$inf}</li>
	{/strip}
	{/foreach}
	</ol>
{/if}

{if isset($res->result)}
	<h4>Wynik</h4>
	<p class="res">
	{$res->result}
	</p>
{/if}

</div>

{/block}