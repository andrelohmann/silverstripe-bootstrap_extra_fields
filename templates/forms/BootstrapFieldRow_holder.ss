<div class="form-group">
    <% if $Title %><label class="left">$Title</label><% end_if %>
    <div <% if $Name %>id="$Name"<% end_if %> class="row<% if $extraClass %> $extraClass<% end_if %>">
    <% loop $FieldList %>
        $FieldHolder
    <% end_loop %>
    </div>
    <% if $RightTitle %><span class="help-block">$RightTitle</span><% end_if %>
</div>

<% if $Description %>
<div class="form-group">
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        $Description
    </div>
</div>
<% end_if %>

<% if $Message %>
<div class="form-group">
    <% if $MessageType="good" %>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            $Message
        </div>
    <% else_if $MessageType="bad" %>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            $Message
        </div>
    <% else_if $MessageType="warning" %>
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            $Message
        </div>
    <% else %>
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            $Message
        </div>
    <% end_if %>
</div>
<% end_if %>
