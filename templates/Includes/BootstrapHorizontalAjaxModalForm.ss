            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Modal_{$FormName}_Label">$Title</h4>
            </div>
            <% if $IncludeFormTag %>
            <form $AttributesHTML role="form">
            <% end_if %>
            <div class="modal-body">
                <div class="row">
                <% if $Message %>
                    <div class="col-md-12">
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
                    </div>
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
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                <% if $Actions %>
                <% loop $Actions %>
                <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                $Field
                </div>
                </div>
                <% end_loop %>
                <% end_if %>
                </div>
            </div>
            <% if $IncludeFormTag %>
            </form>
            <% end_if %>
