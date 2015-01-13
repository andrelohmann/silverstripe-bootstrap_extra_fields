<div <% if $ID %>id="$ID"<% end_if %> class="col-sm-$ColumnWidth<% if $extraClass %> $extraClass<% end_if %>">
    <% loop $FieldList %>
    $FieldHolder
    <% end_loop %>
</div>
