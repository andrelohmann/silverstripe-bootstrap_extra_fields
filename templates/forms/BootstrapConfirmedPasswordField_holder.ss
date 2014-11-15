<% if $IsHorizontal %>
    <% if $ShowOnClick %>
        <div class="showOnClick">
        <div class="form-group">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <a href="#">$ShowTitle</a>
            </div>
        </div>
        <div class="showOnClickContainer" style="display:none;">
    <% end_if %>
    
    <% loop $Fields %>
        <% if $IsHidden %>
            $Field
        <% else %>
            <div class="form-group">
                <% if $Title && $hasData %>
                    <label class="col-md-2 control-label" for="$id">$Title</label>
                <% else %>
                    <div class="col-md-2"></div>
                <% end_if %>

                <div class="col-md-9">
                    $Field
                </div>   

                <% if $RightTitle %>
                    <div class="col-md-1">
                        <span class="help-inline"><a href="#" data-toggle="tooltip" title="$RightTitle"><i class="glyphicon glyphicon-question-sign"></i></a></span>
                    </div>
                <% end_if %>                 
            </div>
        <% end_if %>
    <% end_loop %>
    
    <% if $ShowOnClick %>
        </div>
        </div>
    <% end_if %>
    
    <% if $Description %>
        <div class="form-group">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    $Description
                </div>
            </div>
        </div>
    <% end_if %>
    
    <% if $Message %>
        <div class="form-group">
            <div class="col-md-2"></div>
            <div class="col-md-9">
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
            </div>
        </div>
    <% end_if %>
<% else %>
    <% if $ShowOnClick %>
        <div class="showOnClick">
        <div class="form-group">
            <label for="$id"><a href="#">$ShowTitle</a></label>
        </div>
        <div class="showOnClickContainer" style="display:none;">
    <% end_if %>
    
    <% loop $Fields %>
        <% if $IsHidden %>
            $Field
        <% else %>
            <div class="form-group">
                <% if $Title %><label for="$id">$Title</label><% end_if %>
                $Field
                <% if $RightTitle %><span class="help-block">$RightTitle</span><% end_if %>
            </div>
        <% end_if %>
    <% end_loop %>
    
    <% if $ShowOnClick %>
        </div>
        </div>
    <% end_if %>
    
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
<% end_if %>