<% if $isReadonly %>
	<span id="$ID"<% if $extraClass %> class="$extraClass"<% end_if %>>
		$CurrencySymbol $Value
	</span>
<% else %>
	<div class="input-group">
            <span class="input-group-addon">$CurrencySymbol</span>
            <input $getAttributesHTML("class") class="form-control $extraClass" />
        </div>
<% end_if %>
