$ModalFormAction.Field
<div class="modal fade" id="Modal_{$FormName}" tabindex="-1" role="dialog" aria-labelledby="Modal_{$FormName}_Label" aria-hidden="true">
    <div class="modal-dialog $Size">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Modal_{$FormName}_Label">$Title</h4>
            </div>
            <% if $IncludeFormTag %>
            <form $AttributesHTML role="form">
            <% end_if %>
            <div class="modal-body">
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
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            $Message
                        </div>
                    <% else %>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            $Message
                        </div>
                    <% end_if %>
                <% end_if %>

                <% if $Legend %><legend>$Legend</legend><% end_if %> 
                <% loop $Fields %>
                    $FieldHolder
                <% end_loop %>
            </div>
            <div class="modal-footer">
                <% if $Actions %>
                    <% loop $Actions %>
                        $Field
                    <% end_loop %>
                <% end_if %>
            </div>
            <% if $IncludeFormTag %>
            </form>
            <% end_if %>
        </div>
    </div>
</div>
