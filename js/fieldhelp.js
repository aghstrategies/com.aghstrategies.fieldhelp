CRM.$(function ($) {
  var addFieldHelp = function () {
    var $fields = CRM.vars.fieldhelp.fields;
    $.each($fields, function (key, value) {
      var $fieldInput = $('#' + key);
      if ($('#' + key + 'descrip').length == 0) {
        if (key == 'preferred_communication_method_1') {
          $('<div/>', {
            class: 'description',
            id: key + 'descrip',
            text: value,
          }).insertBefore($fieldInput);
        } else {
          $('<div/>', {
            class: 'description',
            id: key + 'descrip',
            text: value,
          }).insertAfter($fieldInput);
        }
      }
    });
  };

  addFieldHelp();
  $(document).on('crmLoad', function () {
    addFieldHelp();
  });
});
