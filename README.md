# builder-team
This repository is for builder team. Add optimized code here.

<h2>Gravity Form</h2>
## 🗓️ Set Dynamic Date Range in Gravity Forms
### Datepicker 1 becomes minDate for datepicker 2 ————————— (Disable past dates from datepicker)

<pre> ```js gform.addFilter('gform_datepicker_options_pre_init', function (optionsObj, formId, fieldId) { if (formId == 2 && fieldId == 23) { optionsObj.minDate = 0; optionsObj.onClose = function (dateText, inst) { jQuery('#input_2_24') .datepicker('option', 'minDate', dateText) .datepicker('setDate', dateText); }; } return optionsObj; }); ``` </pre>
