<button $getAttributesHTML("class") class="btn btn-default $extraClass" data-toggle="modal" data-target="#$Target">
    <% if $ButtonContent %>$ButtonContent<% else %>$Title<% end_if %>
</button>