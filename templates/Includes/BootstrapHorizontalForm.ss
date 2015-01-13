<% if $IncludeFormTag %>
<form $AttributesHTML role="form">
<% end_if %>
    <% if $Message %>
        <% if $MessageType="good" %>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                $Message
            </div>
        <% else_if $MessageType="bad" %>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                $Message
            </div>
        <% else_if $MessageType="warning" %>
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                $Message
            </div>
        <% else %>
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                $Message
            </div>
        <% end_if %>
    <% end_if %>
    <% if $Fields %>
        <% loop $Fields %>
            <% if $IsHidden || $class == 'BootstrapTabSet' %>
                $Field
            <% else %>
                $FieldHolder
            <% end_if %>
        <% end_loop %>
    <% end_if %>
    
    <% if $Actions %>
    <% loop $Actions %>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    $Field
    </div>
    </div>
    <% end_loop %>
    <% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
