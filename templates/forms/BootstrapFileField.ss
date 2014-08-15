<% if $Image %>
<div class="bootstrapfile">
<div class="thumbnail">$Image</div>
<% end_if %>
<div class="row">
<input $AttributesHTML />
<input type="hidden" name="MAX_FILE_SIZE" value="$MaxFileSize" />
</div>
<% if $Image %>
</div>
<% end_if %>
