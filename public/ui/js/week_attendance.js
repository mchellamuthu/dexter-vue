$(document).ready(function() {
	$('#select-picker').change(function() {
        if($('.selectpicker').val() == 'Absent') {
          $('.selectpicker').css('color', 'red');
        }

      });
})

var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$(function(){
var formatted_date = function(date){
  var m = ("0"+ (date.getMonth()+1)).slice(-2); // in javascript month start from 0.
  var d = ("0"+ date.getDate()).slice(-2); // add leading zero 
  var y = date.getFullYear();
  console.log(m_names[m]+ ' ' + d +', '+y);
  return m_names[m]+ ' ' + d +', '+y; 
}

var curr_date =new Date();
         
var day = curr_date.getDay();
         
var diff = curr_date.getDate() - day + (day == 0 ? -6:1); // 0 for sunday
         
var week_start_tstmp = curr_date.setDate(diff);           
         
var week_start = new Date(week_start_tstmp);
         
var week_start_date =formatted_date(week_start);

var week_end  = new Date(week_start_tstmp);

$('#wc-day-1').text(week_start_date);

$('#wc-day-2').text(formatted_date(new Date (week_end.setDate(week_start.getDate() + 1))));

$('#wc-day-3').text(formatted_date(new Date (week_end.setDate(week_start.getDate() + 2))));

$('#wc-day-4').text(formatted_date(new Date (week_end.setDate(week_start.getDate() + 3))));

$('#wc-day-5').text(formatted_date(new Date (week_end.setDate(week_start.getDate() + 4))));

$('#wc-day-6').text(formatted_date(new Date (week_end.setDate(week_start.getDate() + 5))));

$('#wc-day-7').text(formatted_date(new Date (week_end.setDate(week_start.getDate() + 6))));

});


function dateFormat(date) {
	mlist = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
	return mlist[date.getMonth()] + " " + date.getDate() + "," + date.getFullYear();
}

var student_name_and_prof = [
	{
		"Name":"Beyonce",
  		"imageSrc" : "images/student_images/cute1.png"
  	}, {
		"Name":"Denzel",
  		"imageSrc" : "images/student_images/cute2.png"
  	}, {
		"Name":"Hari",
  		"imageSrc" : "images/student_images/cute3.png"
  	}];

function getResponse(selectedWeekName, selectedDataValue) {
	$.ajax({
      url: 'week_attendance_ajax.php',
      type: 'POST',
      dataType: 'json',
      data: 
      {
        selectedWeek: selectedWeekName, 
        selectedData: selectedDataValue
      },
      timeout:3000,
    })
    .done(function(response) {
    	return response;
    })
    .fail(function() {
      console.log("error");
      return "";
    })
    .always(function() {
      console.log("complete");
      return "";
    });
}


function getEveryWeekDetails(selectedWeekName, selectedDataValue) {
	$.ajax({
      url: 'week_attendance_ajax.php',
      type: 'POST',
      dataType: 'json',
      data: 
      {
        selectedWeek: selectedWeekName, 
        selectedData: selectedDataValue
      },
    })
    .done(function(response) {

	if(response != "") {
		$('#wc-day-1').html(response.weekDates.weekOfAllDays[0]);
      $('#wc-day-2').html(response.weekDates.weekOfAllDays[1]);
      $('#wc-day-3').html(response.weekDates.weekOfAllDays[2]);
      $('#wc-day-4').html(response.weekDates.weekOfAllDays[3]);
      $('#wc-day-5').html(response.weekDates.weekOfAllDays[4]);
      $('#wc-day-6').html(response.weekDates.weekOfAllDays[5]);
      $('#wc-day-7').html(response.weekDates.weekOfAllDays[6]);
      if(response.weekDates.uptoDate[0] == undefined) {
        $('#monday-attendance').replaceWith('<td id="monday-future-date"></td>');
      }
      else {
        $('#monday-future-date').replaceWith('<td id="monday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');

        if(response.attendance == true) {
          $('.attendance-percent-content .everyday-attendance-details').css('display', 'block');
          $('.attendance-percent-content .no-attendance').css('display', 'none');
          $('#monday-attendance .icon-content').css('background-color', 'rgb(122, 191, 11)');
          $('#monday-attendance .icon-content > span').css('color', 'white');

          if(response.attendance_details.absent != "") {
            $('.absent-on-monday').css('display', 'block');
            $('.absent-on-monday span').text(response.attendance_details.absent).css('color', 'black');
          }

          if(response.attendance_details.late != "") {
            $('.late-on-monday').css('display', 'block');
            $('.late-on-monday span').text(response.attendance_details.late).css('color', 'black');
          }

          if(response.attendance_details.lateEarly != "") {
            $('.late-early-on-monday').css('display', 'block');
            $('.late-early-on-monday span').text(response.attendance_details.lateEarly).css('color', 'black');
          }

         $('.attendance-recorded-students').replaceWith('<div class="attendance-recorded-students"></div>');
          for(var i = 0; i < student_name_and_prof.length; i++) {
          	$('.attendance-recorded-students').prepend('<li>' +
            	'<img src="' + student_name_and_prof[i].imageSrc +'">' +
            	'<span>'+ student_name_and_prof[i].Name +'</span>' +
            	'<span class="status-dropdown">' +
                  '<select class="selectpicker" id="select-picker">' +
                    '<option id="select-absent">Absent</option>' +
                    '<option id="select-present">Present</option>' +
                    '<option id="select-late">Late</option>' +
                    '<option id="select-late-early">Late Early</option>' +
                  '</select>' +
              '</span>' +
            '</li>');
          }
        }
      }

      /*var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[0]));
      $('.record-date h1').text(formattedDate);*/

      if(response.weekDates.uptoDate[1] == undefined) {
        $('#tuesday-attendance').replaceWith('<td id="tuesday-future-date"></td>');
        /*$('#future-date').attr('disabled', 'disabled');*/
      }
      else {
        $('#tuesday-future-date').replaceWith('<td id="tuesday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');

        if(response.attendance == false) {

        	$('.record-date p').replaceWith('<p><button class="btn btn-primary" onclick="recordAttendance()">Record attendance</button></p>')

        	$('.attendance-recorded-students').replaceWith('<div class="attendance-recorded-students"></div>');
          for(var j = 0; j < student_name_and_prof.length; j++) {
            $('.attendance-recorded-students').prepend('<li>' +
            	'<img src="' + student_name_and_prof[j].imageSrc +'">' +
            	'<span>'+ student_name_and_prof[j].Name +'</span>' +
            	'<span class="student-status">' +
	                'None recorded today' +
	            '</span>' +
            '</li>');
          }
        }
      }

      if(response.weekDates.uptoDate[2] == undefined) {
        $('#wednesday-attendance').replaceWith('<td id="wednesday-future-date"></td>');
        /*$('#future-date').attr('disabled', 'disabled');*/
      }
      else {
        $('#wednesday-future-date').replaceWith('<td id="wednesday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');
      }
      
      if(response.weekDates.uptoDate[3] == undefined) {
        $('#thursday-attendance').replaceWith('<td id="thursday-future-date"></td>');
        /*$('#future-date').attr('disabled', 'disabled');*/
      }
      else {
        $('#thursday-future-date').replaceWith('<td id="thursday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');
      }

      if(response.weekDates.uptoDate[4] == undefined) {
        $('#friday-attendance').replaceWith('<td id="friday-future-date"></td>');
        /*$('#future-date').attr('disabled', 'disabled');*/
      }
      else {
        $('#friday-future-date').replaceWith('<td id="friday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');
      }

      if(response.weekDates.uptoDate[5] == undefined){ 
        $('#saturday-attendance').replaceWith('<td id="saturday-future-date"></td>');
        /*$('#future-date').attr('disabled', 'disabled');*/
      }
      else {
        $('#saturday-future-date').replaceWith('<td id="saturday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');
      }

      if(response.weekDates.uptoDate[6] == undefined) {
        $('#sunday-attendance').replaceWith('<td id="sunday-future-date"></td>');
      }
      else {
        $('#sunday-future-date').replaceWith('<td id="sunday-attendance"><div class="icon-content"><span class="glyphicon glyphicon-ok"></span></div><div class="attendance-percent-content"><div style="text-align: center;"><span><span>No attendance</span></span></div></div></td>');
      }
	}
});
}


var selectedDataValue = "this_week";
var selectedWeekName = "This Week";

$(document).ready(function() {
	$('#week-selection-prev-btn, #week-selection-next-btn').on('click', function() {
    var dataValue = $('#week-name').attr('data-value');
    var weekName = $('#week-name');
    var trigger = $(this).attr('data-value');
    
    if(trigger == "prev") {
      if(dataValue == 'this_week') {
        weekName.attr('data-value', 'last_week');
        weekName.html('Last Week');
        $('.next-btn').attr('disabled', false);
        $('.next-btn').css({
          background: 'white',
          'border-color': 'rgb(0, 174, 239)',
          color: 'rgb(0, 174, 239)'
        });
      }
      else if(dataValue == 'last_week') {
        weekName.attr('data-value', '2_weeks_ago');
        weekName.html('2 Weeks ago');
        $('.next-btn').attr('disabled', false);
        $('.next-btn').css({
          background: 'white',
          'border-color': 'rgb(0, 174, 239)',
          color: 'rgb(0, 174, 239)'
        });
      }
      else if(dataValue == '2_weeks_ago') {
        weekName.attr('data-value', '3_weeks_ago');
        weekName.html('3 Weeks ago');
        $('.next-btn').attr('disabled', false);
        $('.prev-btn').attr('disabled', true);
        $('.next-btn').css({
          background: 'white',
          'border-color': 'rgb(0, 174, 239)',
          color: 'rgb(0, 174, 239)'
        });
        $('.prev-btn').css({
          background: 'white',
          'border-color': 'rgb(218, 218, 218)',
          color: 'rgb(218, 218, 218)'
        });
      }
      selectedDataValue = $('#week-name').attr('data-value');
      selectedWeekName = $('#week-name').html();
      console.log("prev");
      console.log(selectedDataValue);
      console.log(selectedWeekName);
    }
    else if(trigger == "next") {
      if(dataValue == 'last_week') {
        weekName.attr('data-value', 'this_week');
        weekName.html('This Week');
        $('.prev-btn').attr('disabled', false);
        $('.prev-btn').css({
          background: 'white',
          'border-color': 'rgb(0, 174, 239)',
          color: 'rgb(0, 174, 239)'
        });
        $('.next-btn').attr('disabled', true);
        $('.next-btn').css({
          background: 'white',
          'border-color': 'rgb(218, 218, 218)',
          color: 'rgb(218, 218, 218)'
        });
      }
      else if(dataValue == '2_weeks_ago') {
        weekName.attr('data-value', 'last_week');
        weekName.html('Last Week');
        $('.prev-btn').attr('disabled', false);
        $('.prev-btn').css({
          background: 'white',
          'border-color': 'rgb(0, 174, 239)',
          color: 'rgb(0, 174, 239)'
        });
      }
      else if(dataValue == '3_weeks_ago') {
        weekName.attr('data-value', '2_weeks_ago');
        weekName.html('2 Weeks ago');
        $('.prev-btn').attr('disabled', false);
        $('.prev-btn').css({
          background: 'white',
          'border-color': 'rgb(0, 174, 239)',
          color: 'rgb(0, 174, 239)'
        });
      }
      selectedDataValue = $('#week-name').attr('data-value');
      selectedWeekName = $('#week-name').html();
      console.log("prev");
      console.log(selectedDataValue);
      console.log(selectedWeekName);
    }
    getEveryWeekDetails(selectedWeekName, selectedDataValue);
  });
});

$(document).ready(function() {
	$('#monday-attendance').on('click', function() {
      	$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[0]));
      		$('.record-date h1').text(formattedDate);
	    })
		
	});

	$('#tuesday-attendance').on('click', function() {
		$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[1]));
      		$('.record-date h1').text(formattedDate);
	    })
	});

	$('#wednesday-attendance').on('click', function() {
		$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[2]));
      		$('.record-date h1').text(formattedDate);
	    })
	});

	$('#thursday-attendance').on('click', function() {
		$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[3]));
      		$('.record-date h1').text(formattedDate);
	    })
	});

	$('#friday-attendance').on('click', function() {
		$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[4]));
      		$('.record-date h1').text(formattedDate);
	    })
	});

	$('#saturday-attendance').on('click', function() {
		$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[5]));
      		$('.record-date h1').text(formattedDate);
	    })
	});

	$('#sunday-attendance').on('click', function() {
		$.ajax({
	      url: 'week_attendance_ajax.php',
	      type: 'POST',
	      dataType: 'json',
	      data: 
	      {
	        selectedWeek: selectedWeekName, 
	        selectedData: selectedDataValue
	      },
	      timeout:3000,
	    })
	    .done(function(response) {
	    	var formattedDate = dateFormat(new Date(response.weekDates.weekOfAllDays[6]));
      		$('.record-date h1').text(formattedDate);
	    })
	});
});

function recordAttendance() {
	$('.record-date p').replaceWith('<p>(Recorded)</p>')

    $('.attendance-recorded-students').replaceWith('<div class="attendance-recorded-students"></div>');
    for(var i = 0; i < student_name_and_prof.length; i++) {
      	$('.attendance-recorded-students').prepend('<li>' +
        	'<img src="' + student_name_and_prof[i].imageSrc +'">' +
        	'<span>'+ student_name_and_prof[i].Name +'</span>' +
        	'<span class="status-dropdown">' +
              '<select class="selectpicker" id="select-picker">' +
                '<option id="select-absent">Absent</option>' +
                '<option id="select-present">Present</option>' +
                '<option id="select-late">Late</option>' +
                '<option id="select-late-early">Late Early</option>' +
              '</select>' +
          '</span>' +
        '</li>');
    }
}

