<% if not $IsHorizontal %><br /><% end_if %>
<div class="btn-group" data-toggle="buttons">
    <label class="btn btn-default<% if $extraClass %> $extraClass<% end_if %><% if $isChecked %> active<% end_if %><% if $isDisabled %> disabled<% end_if %>">
        <input type="checkbox" id="$ID" name="$Name" autocomplete="off" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %>> $Title
    </label>
</div>