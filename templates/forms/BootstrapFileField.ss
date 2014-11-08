<% if $Image %>
<div class="bootstrapfile">
<div class="thumbnail">$Image</div>
<% end_if %>
<input $AttributesHTML />
<input type="hidden" name="MAX_FILE_SIZE" value="$MaxFileSize" />
<% if $Image %>
</div>
<% end_if %>
