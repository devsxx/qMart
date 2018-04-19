<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="stuff-img-1 img-responsive template-upload">
		<span class="cancel">{% if (!i) { %}
            <button class="close stuff-img-close" {% if (file.error) { %} onclick="addImageError -= 1;" {% } %} >
                ×
            </button>
        {% } %}</span>
        <div class="preview"><span class="fade"></span></div>
        {% if (file.error) { addImageError += 1; %}
            <span class="error" style="display: block;position:absolute;bottom:0;background-color:#fff;width:100%;text-align:center">{%=locale.fileupload.errors[file.error] || file.error%}</span>
        {% } else if (o.files.valid && !i) { %}
            <div class="stuff-progress">							
				<div class="progress stuff-progress-bar progress-striped active">
					<div class="progress-bar progress-bar-success bar" role="progressbar" aria-valuemax="100" style="width:0%"></div>
				</div>	
			</div>
            <span class="start" style="display:none;">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</span>
        {% } else { %}
            <span colspan="2"></span>
        {% } %}
    </div>
{% } %}

{% /* %}
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name" valign="middle"><span style="word-wrap: break-word;width: 250px;float: left;">{%=file.name%}</span></td>
        <td class="size" valign="middle"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { addImageError += 1; %}
            <td class="error" colspan="2" valign="middle" style="width: 232px;display: block;"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td valign="middle">
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start" style="display:none;">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning" {% if (file.error) { %} onclick="addImageError -= 1;" {% } %} >
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
{% */ %}
</script>
