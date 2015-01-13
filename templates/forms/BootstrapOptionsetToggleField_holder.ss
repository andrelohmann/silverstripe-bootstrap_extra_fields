<% if $IsHorizontal %>
    <% if $Title || $RightTitle %>
    <div class="form-group">
        <% if $Title %>
            <label class="col-sm-2 control-label" for="$id">$Title</label>
        <% else %>
            <div class="col-sm-2"></div>
        <% end_if %>
        
        <div class="col-sm-9"></div>
        
        <% if $RightTitle %>
            <div class="col-sm-1">
                <span class="help-inline"><a href="#" data-toggle="tooltip" title="$RightTitle"><i class="glyphicon glyphicon-question-sign"></i></a></span>
            </div>
        <% end_if %>
    </div>
    <% end_if %>

    <div class="BootstrapOptionsetToggleFieldMainContainer">
    <% if $Options.Count %>
        <% loop $Options %>
            <div class="BootstrapOptionsetToggleFieldContainer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
                        <div class="radio">
                            <label>
                                <input id="$ID" name="$Name" type="radio" value="$Value" class="optionsettogglefield-radio-horizontal $extraClass"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> />
                                $Title
                            </label>
                        </div>
                    </div>
                </div><%-- End Formgroup --%>
                
                <div class="BootstrapOptionsetToggleFieldContainerVisibility"<% if $isChecked %><% else %>style="display:none;"<% end_if %>>
                
                <% loop $FieldList %>
                    <div class="form-group">
                        <% if $Title && $hasData %>
                            <label class="col-sm-2 control-label" for="$id">$Title</label>
                        <% else %>
                            <div class="col-sm-2"></div>
                        <% end_if %>

                        <div class="col-sm-9">
                            $Field
                        </div>   

                        <% if $RightTitle %>
                            <div class="col-sm-1">
                                <span class="help-inline"><a href="#" data-toggle="tooltip" title="$RightTitle"><i class="glyphicon glyphicon-question-sign"></i></a></span>
                            </div>
                        <% end_if %>                 
                    </div>
    
                    <% if $Description %>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                $Description
                            </div>
                        </div>
                    </div>
                    <% end_if %>

                    <% if $Message %>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
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
                <% end_loop %>

                </div><%-- BootstrapOptionsetToggleFieldContainerVisibility End --%>
            </div><%-- BootstrapOptionsetToggleFieldContainer End --%>
        <% end_loop %>
    <% end_if %>
    </div><%-- BootstrapOptionsetToggleFieldMainContainer End --%>

    <% if $Description %>
        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    $Description
                </div>
            </div>
        </div>
    <% end_if %>
    
    <% if $Message %>
        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
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
    <% if $Title || $RightTitle %>
    <div class="form-group">
        <% if $Title %><label for="$id">$Title</label><% end_if %>
        <% if $RightTitle %><span class="help-block">$RightTitle</span><% end_if %>
    </div>
    <% end_if %>

    <div class="BootstrapOptionsetToggleFieldMainContainer">
    <% if $Options.Count %>
        <% loop $Options %>
            <div class="BootstrapOptionsetToggleFieldContainer">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input id="$ID" name="$Name" type="radio" value="$Value" class="optionsettogglefield-radio $extraClass"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> />
                            $Title
                        </label>
                    </div>
                </div>

                <div class="BootstrapOptionsetToggleFieldContainerVisibility"<% if $isChecked %><% else %>style="display:none;"<% end_if %>>

                <% loop $FieldList %>
                    <div class="form-group">
                        <% if $Title %><label for="$id">$Title</label><% end_if %>
                        $Field
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
                <% end_loop %>
                
                </div><%-- BootstrapOptionsetToggleFieldContainerVisibility End --%>
            </div><%-- BootstrapOptionsetToggleFieldContainer End --%>
        <% end_loop %>
    <% end_if %>
    </div><%-- BootstrapOptionsetToggleFieldMainContainer End --%>

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