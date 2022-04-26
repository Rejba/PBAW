{extends file="main.tpl"}

{block name=top}

<div class="bottom-margin">
<form action="{$conf->action_root}personSave" method="post" class="pure-form pure-form-aligned">
	<fieldset>
		<legend>Dane osoby</legend>
		<div class="pure-control-group">
            <label for="sum">Wartosc</label>
            <input id="sum" type="text" placeholder="Wartość" name="sum" value="{$form->name}">
        </div>
		<div class="pure-control-group">
            <label for="period">Lata</label>
            <input id="period" type="text" placeholder="Lata" name="period" value="{$form->surname}">
        </div>
		<div class="pure-control-group">
            <label for="percent">Procent</label>
            <input id="percent" type="text" placeholder="Procent" name="percent" value="{$form->birthdate}">
        </div>
		<div class="pure-controls">
			<input type="submit" class="pure-button pure-button-primary" value="Zapisz"/>
			<a class="pure-button button-secondary" href="{$conf->action_root}personList">Powrót</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">
</form>	
</div>

{/block}
