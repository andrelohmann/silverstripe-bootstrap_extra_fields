<select $getAttributesHTML("class") class="form-control $extraClass">
<% loop $Options %>
	<option value="$Value.XML"<% if $Selected %> selected="selected"<% end_if %><% if $Disabled %> disabled="disabled"<% end_if %><% if $Class %> class="$Class"<% end_if %>>$Title.XML</option>
<% end_loop %>
</select>
