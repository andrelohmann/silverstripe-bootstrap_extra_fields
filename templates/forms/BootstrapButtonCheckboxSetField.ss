<% if not $IsHorizontal %><br /><% end_if %>
<% if $Options.Count %>
<div class="btn-group" data-toggle="buttons">
    <% loop $Options %>
    <label class="btn btn-{$ButtonClass} {$ExtraClass}<% if $isChecked %> active<% end_if %><% if $isDisabled %> disabled<% end_if %>">
        <input type="checkbox" id="$ID" name="$Name" autocomplete="off" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %>> $Title
    </label>
    <% end_loop %>
</div>
<% else %>
    <p>No options available</p>
<% end_if %>