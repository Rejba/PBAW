{extends file="main.tpl"}

{block name=content}



<form action="{$conf->action_root}calcCompute" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Kalkulator</legend>
	<fieldset>

		<div style="position: relative;left: 5%;">
			<label for="s">Kwota kredytu: </label>
			<input id="s" type="text" name="sum" value="{$form->sum}"/><br/><br/>
		</div>
		<div style="position: relative;left: 40%; top:-55px;">
			<label for="p">Okres spłaty: </label>
			<input id="p" type="text" name="period" placeholder="Ile lat" value="{$form->period}"/><br/><br/>
		</div>
		<div style="position: relative;left: 75%; top:-108px;">
			<label for="per">Oprocentowanie: </label>
			<input id="per" type="text" name="percent" placeholder="6.5"
				   title="Używaj tylko kropki. Maksymalnie dwie liczby po kropce.  " value="{$form->percent}"/><br/>
		</div>
	</fieldset>

	<button style="position: relative;left: 47%; top:-20px;font-size: 175%;" type="submit"
			class="button-xlarge pure-button "><i class="fa-solid fa-calculator fa-lg fa-beat"></i> Oblicz
	</button>

</form>

	{include file='messages.tpl'}

{if isset($res->result)}
<div class="messages info">
	Wynik: {$res->result}
</div>
{/if}

{/block}