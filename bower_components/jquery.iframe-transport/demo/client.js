(function($) {
  'use strict';

  $('form').on('click', 'button[type=submit]', function(evt) {
    var form = $(this.form).addClass('loading');
    evt.preventDefault();
    $.ajax(form.prop('action'), {
      data: form.find('textarea').serializeArray(),
      dataType: 'json',
      files: form.find(':file'),
      iframe: true,
      processData: false
    }).always(function() {
      form.removeClass('loading');
    }).done(function(data) {
      console.log(data);
      $.each(data.files, function(idx, file) {
        $('<li class="list-group-item">' +
          '<h4 class="list-group-item-heading"></h4>' +
          '<p class="list-group-item-text"><span class="size"></span>, <span class="mime"></span></p>' +
          '<blockquote class="list-group-item-text comment"></blockquote></li>')
          .find('h4').text(file.originalFilename).end()
          .find('.size').text(formatSize(file.size)).end()
          .find('.mime').text(file.headers['content-type']).end()
          .find('.comment').text(data.comment || '').end()
          .appendTo('#filelist');
      });
      form.find(':file').val('');
    });
  });

  function formatSize(size) {
    var units = ['B', 'KB', 'MB', 'GB'],
        idx = 0;
    if (!size) {
      return '0 bytes';
    }
    while (size >= 1024) {
      size /= 1024;
      idx++;
    }
    return size.toFixed(0) + ' ' + units[idx];
  }

})(jQuery);
