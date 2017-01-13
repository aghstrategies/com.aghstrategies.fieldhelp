CRM.$(function ($) {
  var $fields = CRM.vars.fieldhelp.fields;
  $.each($fields, function (key, value) {
    $('<div/>', {
      class: 'description',
      text: value,
    }).insertAfter($('input[id=' + key + ']'));
  });
});
