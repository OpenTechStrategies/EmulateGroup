(function ($, mw) {
  $(function() {
    $('#emulategroupsubmit').on('click', function() {
      group = $('#emulategroupgroup').val();

      (new mw.Api()).postWithToken('csrf', {
        action: 'emulategroupstart',
        group: group
      }).done(function(response) {
        window.location.reload(true);
      });
    });
    $('#emulategroupstop').on('click', function() {
      (new mw.Api()).postWithToken('csrf', {
        action: 'emulategroupstop',
      }).done(function(response) {
        window.location.reload(true);
      });
    });
  });
}(jQuery, mediaWiki));
