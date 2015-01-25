<% if $isReadonly %>
	<span id="$ID"<% if $extraClass %> class="$extraClass"<% end_if %>>
		$Value
	</span>
<% else %>
	<div class="input-group date" id="$ID">
            <input $getAttributesHTML("class") class="form-control<% if $extraClass %> $extraClass<% end_if %>"  readonly="readonly" />
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
<% end_if %>
