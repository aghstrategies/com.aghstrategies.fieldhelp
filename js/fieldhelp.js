CRM.$(function ($) {
  var $fields = CRM.vars.fieldhelp.fields;
  console.log($fields);
  $.each($fields, function (key, value) {
    var $fieldInput = $('#' + key);
    if (key == 'Email_Block_1') {
      console.log($fieldInput);
    }

    if (key == 'preferred_communication_method_1') {
      $('<div/>', {
        class: 'description',
        text: value,
      }).insertBefore($fieldInput);
    } else {
      $('<div/>', {
        class: 'description',
        text: value,
      }).insertAfter($fieldInput);
    }
  });
});
