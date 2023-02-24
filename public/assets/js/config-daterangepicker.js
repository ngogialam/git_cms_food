$(document).ready(function(){
	$('#daterangepicker').daterangepicker({
		'timePicker': false,
		'opens': 'right',
    'drops': 'down',
    // autoUpdateInput: false,
    // 'startDate': moment().subtract(6, 'days'),
    // 'endDate' : moment(),
		'ranges': {
              'Hôm nay': [moment(), moment()],
              'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              '7 ngày qua': [moment().subtract(6, 'days'), moment()],
              '30 ngày qua': [moment().subtract(29, 'days'), moment()],
              'Tháng này': [moment().startOf('month'), moment().endOf('month')],
              'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        'locale':{
        	direction: $('#rtl').is(':checked') ? 'rtl' : 'ltr',
              format: 'DD/MM/YYYY',
              separator: ' - ',
              applyLabel: 'Apply',
              cancelLabel: 'Cancel',
              fromLabel: 'From',
              toLabel: 'To',
              customRangeLabel: 'Tùy chỉnh',
              daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6','T7'],
              monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              firstDay: 1
        },
  });

  $('#dateShipper').daterangepicker({
		'timePicker': false,
		'opens': 'right',
    'drops': 'down',
    autoUpdateInput: false,
    // 'startDate': moment().subtract(6, 'days'),
    // 'endDate' : moment(),
		'ranges': {
              'Hôm nay': [moment(), moment()],
              'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              '7 ngày qua': [moment().subtract(6, 'days'), moment()],
              '30 ngày qua': [moment().subtract(29, 'days'), moment()],
              'Tháng này': [moment().startOf('month'), moment().endOf('month')],
              'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        'locale':{
        	direction: $('#rtl').is(':checked') ? 'rtl' : 'ltr',
              format: 'DD/MM/YYYY',
              separator: ' - ',
              applyLabel: 'Apply',
              cancelLabel: 'Cancel',
              fromLabel: 'From',
              toLabel: 'To',
              customRangeLabel: 'Tùy chỉnh',
              daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6','T7'],
              monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              firstDay: 1
        },
  });


  $('#dateShipper').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
  });

  $('#dateShipper').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });


});