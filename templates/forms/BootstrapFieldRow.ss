<div class="form-group">
    <div class="row<% if $extraClass %> $extraClass<% end_if %>" <% if $ID %>id="$ID"<% end_if %>>
        <% loop $FieldList %>
        $FieldHolder
        <% end_loop %>
    </div>
</div>
