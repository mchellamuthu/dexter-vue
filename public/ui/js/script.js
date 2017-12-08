/*index-page - START*/
$("#teacher-signin").on("click", function() {
    $('#signup-myModal').modal('hide');
});
$("#parent-signin").on("click", function() {
    $('#signup-myModal').modal('hide');
});
$("#school-leader-signin").on("click", function() {
    $('#signup-myModal').modal('hide');
});
$("#teacher-login").on("click", function() {
    $('#login-myModal').modal('hide');
});
$("#parent-login").on("click", function() {
    $('#login-myModal').modal('hide');
});
$("#school-leader-login").on("click", function() {
    $('#login-myModal').modal('hide');
});

$('#teacher_signup_form').on('keypress', function(e){
    if (e.keyCode == 13){
      e.keyCode = 188;
      e.preventDefault();
    };
  });

$('#teacher-email-id').keyup(function() {
    var teacherEmail = $(this).val();
    console.log(teacherEmail);
    if(isEmail(teacherEmail)) {
        $('#teacher-email-to-invite').attr('disabled', false);
        $('#teacher-email-to-invite').css({
            "background-color": "rgb(51, 190, 242)",
            "color": "white"
        });
    }
    else {
        $('#teacher-email-to-invite').attr('disabled', true);
        $('#teacher-email-to-invite').css({
            "background-color": "rgb(218, 218, 218)",
            "color": "white"
        });
    }
});

$(document).ready(function() {
    $('#login_form input').keyup(function() {
        var loginEmail = $('#login_email').val();
        var loginPwd = $('#login_pwd').val();
        if (isEmail(loginEmail) && loginPwd != "") {
            $('#login_submit_btn').attr('disabled', false);
        } else {
            $('#login_submit_btn').attr('disabled', true);
        }
    });
});

function setSignupForm(fName, lName, email, pwd, inputVal, submitButton, obj) {
    if (obj.is('[type="email"]')) {
        if (isEmail(inputVal)) {
            obj.parent().removeClass('has-error');
            obj.parent().removeClass('has-feedback');
            obj.parent().removeClass('has-success');
            obj.parent().addClass('has-success').addClass('has-feedback');
            obj.next().remove();
            obj.after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
        } else {
            obj.parent().removeClass('has-error');
            obj.parent().removeClass('has-feedback');
            obj.parent().removeClass('has-success');
            obj.parent().addClass('has-error').addClass('has-feedback');
            obj.next().remove();
            obj.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
        }
    } else {
        if (inputVal == '') {
            obj.parent().removeClass('has-error');
            obj.parent().removeClass('has-feedback');
            obj.parent().removeClass('has-success');
            obj.parent().addClass('has-error').addClass('has-feedback');
            obj.next().remove();
            obj.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
        } else {
            obj.parent().removeClass('has-error');
            obj.parent().removeClass('has-feedback');
            obj.parent().removeClass('has-success');
            obj.parent().addClass('has-success').addClass('has-feedback');
            obj.next().remove();
            obj.after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
        }
    }
    if (!(fName == "" || lName == "" || pwd == "") && isEmail(email)) {
        $(submitButton).attr('disabled', false);
    } else {
        $(submitButton).attr('disabled', true);
    }
}

/*Validating input details of school leader signup*/
$(document).ready(function() {
    $('#school_leader_signup_form input').keyup(function() {
        var inputVal = $(this).val();
        console.log("input");
        console.log($(this).attr('type'));
        console.log($(this).attr('id'));
        var fName = $('#school_leader_firstName').val();
        var lName = $('#school_leader_lastName').val();
        var email = $('#school_leader_email').val();
        var pwd = $('#school_leader_pwd').val();
        console.log("fName", fName);
        console.log("lName", lName);
        console.log("email", email);
        console.log("pwd", pwd);
        setSignupForm(fName, lName, email, pwd, inputVal, '#school_leader_submit_btn', $(this));
    });
});
/*Validating input details of teacher signup*/
$(document).ready(function() {
    $('#teacher_signup_form input').keyup(function() {
        var inputVal = $(this).val();
        console.log("input");
        console.log($(this).attr('type'));
        console.log($(this).attr('id'));
        var fName = $('#teacher_firstName').val();
        var lName = $('#teacher_lastName').val();
        var email = $('#teacher_email').val();
        var pwd = $('#teacher_pwd').val();
        console.log("fName", fName);
        console.log("lName", lName);
        console.log("email", email);
        console.log("pwd", pwd);
        setSignupForm(fName, lName, email, pwd, inputVal, '#teacher_submit_btn', $(this));
    });
});
/*Index - page - END*/

function buttonSelection(initialBtn, lastBtn) {
	document.getElementById(initialBtn).style.background = "rgb(0, 174, 239)";
    document.getElementById(initialBtn).style.color = "white";
    document.getElementById(lastBtn).style.background = "white";
    document.getElementById(lastBtn).style.color = "rgb(0, 174, 239)";
}

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

/*My Institute modal - parents - connection circular progress bar - START*/
var defValue = $(".meter input").attr("value");
// var defAngle = $("input").attr("value") * 3.6;

if ( defValue < 50 ) {
  var defAngle = defValue * 3.6 + 90 + "deg";
  // $(".print").text(defAngle);
  $(".percent").css({
    "background-image": "linear-gradient(90deg, #efefef 50%, transparent 51%, transparent), linear-gradient( "+defAngle+", teal 50%, #efefef 51%, #efefef)"
  });
} else {
  var defAngle = ( defValue - 50 ) * 3.6 - 90 + "deg";
  // $(".print").text(defAngle);
  $(".percent").css({
    "background-image": "linear-gradient("+defAngle+", teal 50%, transparent 51%, transparent), linear-gradient(270deg, teal 50%, #efefef 51%, #efefef)"
  });
}

$('.connection-percent').prepend(defValue);
/*My Institute modal - parents - connection circular progress bar - END*/

/*My Institute modal - class - image selection - START*/
$("#dropdown-image-add-class li a img").click(function(){
    console.log("welcome");
    var imageSelected = $(this).attr('src');
    console.log(imageSelected);
    $(this).parents(".dropdown").find('.btn').html("<img src= '"+ imageSelected +"' style='height: 100%;'>" + ' <span style="bottom: 0.3rem; right: 4.1rem; position: absolute; width: 0px; height: 0px; border-width: 0.4rem; border-style: solid; border-color: rgb(140, 140, 140) transparent transparent; border-image: initial;"></span>');
});
/*My Institute modal - class - image selection - END*/

/*My Institute modal - Skill - positive/need work btn - START*/

function positiveDesktopFunction() {
	buttonSelection("positive-desktop-btn", "needs-desktop-work-btn");
}

function needsDesktopWorkFunction() {
	buttonSelection("needs-desktop-work-btn", "positive-desktop-btn");
}

function positiveFeedbackFunction() {
    buttonSelection("positive-feedback-btn", "needs-work-feedback-btn");
}

function needsWorkFeedbackFunction() {
    buttonSelection("needs-work-feedback-btn", "positive-feedback-btn");
}

$("#dropdown-image-edit-skill li a img").click(function(){
    console.log("welcome");
    var imageSelected = $(this).attr('src');
    console.log(imageSelected);
    $(this).parents(".dropdown").find('.btn').html("<img src= '"+ imageSelected +"' style='width: 5.6rem; height: 5.6rem;'>" + ' <span style="bottom: 0px; right: 10px; position: absolute; width: 0px; height: 0px; border-width: 0.4rem; border-style: solid; border-color: rgb(140, 140, 140) transparent transparent; border-image: initial;"></span>');
});

$("#dropdown-image-add-skill li a img").click(function(){
    console.log("welcome");
    var imageSelected = $(this).attr('src');
    console.log(imageSelected);
    $(this).parents(".dropdown").find('.btn').html("<img src= '"+ imageSelected +"' style='width: 5.6rem; height: 5.6rem;'>" + ' <span style="bottom: 0px; right: 10px; position: absolute; width: 0px; height: 0px; border-width: 0.4rem; border-style: solid; border-color: rgb(140, 140, 140) transparent transparent; border-image: initial;"></span>');
});

/*My Institute modal - Skill - positive/need work btn - START*/

/*My Institute modal - teacher - email input - START*/
$('#teacher-email-id').keyup(function() {
    var teacherEmail = $(this).val();
    console.log(teacherEmail);
    if(isEmail(teacherEmail)) {
        $('#teacher-email-to-invite').attr('disabled', false);
        $('#teacher-email-to-invite').css({
            "background-color": "rgb(51, 190, 242)",
            "color": "white"
        });
    }
    else {
        $('#teacher-email-to-invite').attr('disabled', true);
        $('#teacher-email-to-invite').css({
            "background-color": "rgb(218, 218, 218)",
            "color": "white"
        });
    }
});
/*My Institute modal - teacher - email input - END*/

$(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});


/*Add institute with classes - START*/
$("#title_school").on('keyup',function(){
   var title=$('#title_school').val();
   if (title=='') {
    $('.schools-list').css('display','none');
   }else{
    $('.schools-list').css('display','block');
    $('.cant-find-institute').css('display', 'block');
   }
    
});

$('#request-to-join-school, #change-school').on("click", function() {
    $('#selected-school').modal('hide');
    $('#title_school').val("");
    $('.schools-list').css('display','none');
    $('.cant-find-institute').css('display', 'none');
});

var studentsCount = 0;
var className = false;
var selectGrade = false;
function addClassButton() {
    if(className && selectGrade) {
        $('#add_class_btn').attr('disabled', false);
        $('#add_class_btn').css({
            "background-color": "rgb(51, 190, 242)"
        });
    } else{
        $('#add_class_btn').attr('disabled', true);
        $('#add_class_btn').css({
            "background-color": "rgb(218, 218, 218)"
        });
    }
}

$(document).ready(function() {
    $('#class-name-input').keyup(function() {
        console.log($('#class-name-input').val());
        if($('#class-name-input').val() != '') {
            className = true;
        }
        else {
           className = false; 
        }
        addClassButton();
    });

    $('#selectGrade').change(function() {
        console.log($('#selectGrade').val());
        if ($('#selectGrade').val() != '') {
            selectGrade = true;
        }
        else {
            selectGrade = false;
        }
        addClassButton();
    });
});

function removeMe(e) {
    $(e).closest('li').remove();
    studentsCount--;
    if(studentsCount < 1) {
        $('#add_student_btn').attr('disabled', true);
        $('#add_student_btn').css({
            "background-color": "rgb(218, 218, 218)"
        });
    }
    countOfStudent(studentsCount);
}

function randomimages() {
    var iconArray = new Array(
    "cute0.png",
    "cute1.png",
    "cute2.png",
    "cute3.png",
    "cute4.png",
    "cute5.png",
    "cute6.png",
    "cute7.png",
    "cute8.png",
    "cute9.png",
    "cute10.png");
    var randIcon = Math.floor(Math.random()*(iconArray.length));
    return iconArray[randIcon];
}

function countOfStudent(studentCount) {
    if(studentsCount > 1) {
        $('#number-of-students').text(studentsCount + ' students');
    }
    else if(studentsCount == 1) {
        $('#number-of-students').text(studentsCount + ' student');
    }
    else {
        $('#number-of-students').css('display', 'none');
        $('.students-not-added-yet').css('display', 'block');
    }

}

function getStudents() {
    var finps = document.getElementsByName('fname[]');
    var linps = document.getElementsByName('lname[]');
    for (var i = 0; i <finps.length; i++) {
    var finp=finps[i];
        console.log("fname["+i+"].value="+finp.value);
    }
    for (var i = 0; i <linps.length; i++) {
        var linp=linps[i];
        console.log("lname["+i+"].value="+linp.value);
    }
}

$('#continue-import-list').on('click', function() {
   var file_data = $('.file-uploading-input').prop('files')[0];
   var form_data = new FormData();
   form_data.append('file', file_data);
   console.log(form_data);
   $.ajax({
         url: 'ajax.php', // point to server-side PHP script 
         dataType: 'json',  // what to expect back from the PHP script, if anything
         cache: false,
         contentType: false,
         processData: false,
         data: form_data,                         
         type: 'post',
         success: function(response){
            for(var index = 0; index < response.data.length; index++) {
                var newStudent = response.data[index].first_name + response.data[index].last_name;
                addNewStudent(newStudent, response.data[index].first_name, response.data[index].last_name, response.data[index].email);
            }
         }
    });
})

function addNewStudent(newStudent, first_name, last_name, studentEmail) {
    var listContainer = $('#list');
    if(newStudent != '') {
            if(first_name != '' && last_name != '') {
                $('.add-student-input input').removeClass("invalid").addClass("valid");
                $('.input-error-msg').css('display', 'none');
                $('.full-name-error-msg').css('display', 'none');

                if(studentEmail !='') {
                    if(!isEmail(studentEmail)) {
                        $('.email-error-msg').css('display', 'none');
                        $('.valid-email-error-msg').css('display', 'block');
                    } else {
                        $('.add-email-input input').removeClass("invalid").addClass("valid");
                        $('.email-error-msg').css('display', 'none');
                        $('.valid-email-error-msg').css('display', 'none');

                        listContainer.prepend("<li><div><img src='images/student_images/" + randomimages() + "' style='width: 5%; height: 5%; background-color: rgb(218, 218, 218); border-radius: 50%; border: 2px solid rgba(0, 0, 0, 0.05);'><span> " + newStudent + "</span><a href='javascript:void(0);' style='float: right; text-decoration: none;' onclick='removeMe(this);' class='remove-me'> X </a><input type='hidden' name='fname[]' value='" + first_name + "' /><input type='hidden' name='lname[]' value='" + last_name +"' /></div>" +
                        "<div style='margin-left: 3rem; color: rgba(139, 132, 130, 0.95);'>" + studentEmail + "</div></li>");
                        $('.students-not-added-yet').css('display', 'none');
                        $('#add_student_btn').attr('disabled', false);
                        $('#add_student_btn').css({
                            "background-color": "rgb(51, 190, 242)"
                        });
                        studentsCount++;
                        $('#number-of-students').css('display', 'block');
                        countOfStudent(studentsCount);
                        getStudents();
                        $('#add_input, #add_email_input').val('');
                    }
                }
                else {
                    $('.add-email-input input').removeClass("valid").addClass("invalid");
                    $('.email-error-msg').css('display', 'block');
                }
            }
            else {
                $('.add-student-input input').removeClass("valid").addClass("invalid");
                $('.input-error-msg').css('display', 'block');
                $('.full-name-error-msg').css('display', 'none');
            }
        }else{
            $('.add-student-input input').removeClass("valid").addClass("invalid");
            $('.full-name-error-msg').css('display', 'block');
            $('#add_student_btn').attr('disabled', true);
            $('#add_student_btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
        }
    $('#confirm-student-list').modal('hide');
   $('#imported-student-detail-list input').remove();
}

$(function() {
    var add = $('#add_new_student');
    add.on('click', function() {
        event.preventDefault();

        newStudent = $('#add_input').val();
        studentEmail = $('#add_email_input').val();

        var first_name = newStudent.split(' ')[0];
        var last_name = newStudent.substring(first_name.length).trim();
        addNewStudent(newStudent, first_name, last_name, studentEmail);
    });
});

function importXLSFile(input) {
    if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
        $('#imported-list').css('display', 'block');

        var fileSize = 0;
          var file = input.files[0];
          if (file.size > 1024 * 1024)
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
          else
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

      $('#fileName').text(file.name);
      $('#fileSize').text(fileSize);
      $('#preview-btn, #import-list-btn').attr('disabled', false);
      $('#preview-btn, #import-list-btn').css({
        "background-color": "rgb(51, 190, 242)",
        "color": "white"
      });
    };
    reader.readAsDataURL(input.files[0]);
  }
};

$('#import-list-btn').on("click", function() {
    $('#import-student-list').modal('hide');
});

$('#get_invites').on('click', function() {
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var $addedStudent = $('#done-students-adding');

    setTimeout(function() {
        $progressBar.css('width', '10%');
        setTimeout(function() {
            $progressBar.css('width', '30%');
            setTimeout(function() {
                $progressBar.css('width', '100%');
                setTimeout(function() {
                    $progress.css('display', 'none');
                    $addedStudent.css('display', 'block');
                }, 500); // WAIT 5 milliseconds
            }, 2000); // WAIT 2 seconds
        }, 1000); // WAIT 1 seconds
    }, 1000); // WAIT 1 second
});


/*Add institute with classes - END*/


/*View report - attendance - START*/
function doNutFunction() {
    buttonSelection("donut-btn", "attendance-btn");
}

function attendanceFunction() {
    buttonSelection("attendance-btn", "donut-btn");
}


/*View report - attendance - END*/

/*Story-view - START*/
function closeImage(e) {
    $('#add-profile-buttons .add-photo-btn').css('display', 'block');
    $('#add-profile-buttons .add-file-btn').css('display', 'block');
    $('#add-profile-buttons .add-card-btn').css('display', 'block');

    $('#uploading-image-content .close span').html('');
    $('#file-upload-image').replaceWith('<img id="file-upload-image" width="100%" height="100%">');
}

$('.close-file-upload-content').on('click', function() {
    $('.uploaded-doc').hide();
    $('#add-profile-buttons .add-photo-btn').css('display', 'block');
    $('#add-profile-buttons .add-file-btn').css('display', 'block');
    $('#add-profile-buttons .add-card-btn').css('display', 'block');
});

function closeImageOnEditContent(d) {
    $('#add-profile-button-in-edit-post .add-photo-btn').css('display', 'block');
    
    $('#edit-image-content .close span').html('');
    $('#edit-post-file-upload-image').replaceWith('<img id="edit-post-file-upload-image" width="100%" height="100%">');
}

$('#like-button').on('click', function() {
    if($('#like-button span').text() == "Like") {
        $('#like-button i').replaceWith('<i class="fa fa-heart" aria-hidden="true"></i>');
        $('#like-button .fa').css('color', 'red');
        $('#like-button span').text('Liked');
        $('.no-of-likes-and-comments').css('display', 'block');
        $('.no-of-likes-and-comments .no-of-likes').css('display', 'block');
        $('.no-of-likes-and-comments hr').css('display', 'block');
    }
    else if($('#like-button span').text() == 'Liked') {
        $('#like-button i').replaceWith('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $('#like-button span').text('Like');
        $('.no-of-likes-and-comments .no-of-likes').css('display', 'none');
        if($('.no-of-likes-and-comments .no-of-comments').css('display') == 'none') {
            $('.no-of-likes-and-comments').css('display', 'none');
            $('.no-of-likes-and-comments hr').css('display', 'none');
        }
    }
});

$('#comment-button').on('click', function() {
    $('.no-of-likes-and-comments').css('display', 'block');
    $('.no-of-likes-and-comments .no-of-comments').css('display', 'block');
    $('.no-of-likes-and-comments hr').css('display', 'block');
    $('.comments-posting').css('display', 'block');
});

$(document).ready()
{
    $(".comments-posting .posted-day span").hover(
         function() // on mouseover
        {
            $(this).text("X");
            $(this).attr({class: 'close-comment', onclick: 'closeCommentFn()'});
            $(this).css('cursor', 'pointer');
            
        }, 
        
        function() // on mouseout
        {
            $(this).text("1m");
            $(this).attr('class', 'text-muted');
        });
};


function closeCommentFn() {
    $('#posted-comments').remove();
}
/*Story-view - END*/

/*Message-view - START*/
$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

$('#text-message').keyup(function() {
    if($('#text-message').val() != '') {
        $('#message-send-btn, #message-caret-btn').attr('disabled', false);
        $('#message-send-btn, #message-caret-btn').css({
            'background-color': 'rgb(0, 174, 239)',
            'border': '1px solid rgb(0, 174, 239)',
            'color': 'white'
        });
    }
    else if($('#text-message').val() == '') {
        $('#message-send-btn, #message-caret-btn').attr('disabled', true);
        $('#message-send-btn, #message-caret-btn').css({
            'background-color': 'rgb(218, 218, 218)',
            'border': '1px solid rgb(218, 218, 218)',
            'color': 'white'
        });
    }
});

$('#expand-scheduled-msg').on('click', function() {
    if($(this).text() == 'Expand') {
        $('#scheduled-message-list').css('display', 'block');
        $(this).text('Hide');
    }
    else if($(this).text() == 'Hide') {
        $('#scheduled-message-list').css('display', 'none');
        $(this).text('Expand');
    }
});

$('#message-send-btn').on('click', function() {
    if($('#message-send-btn').text() == 'Schedule') {
        $('.scheduled-messages').css('display', 'block');
    }

    $('#message-send-btn, #message-caret-btn').attr('disabled', true);
    $('#message-send-btn, #message-caret-btn').css({
        'background-color': 'rgb(218, 218, 218)',
        'border': '1px solid rgb(218, 218, 218)',
        'color': 'white'
    });

    $('#text-message').val('');
});
/*Message-view - END*/

function connectClass() {
    $('#myEditModalTab li .connect-class').tab('show');
}

function connectParents() {
    $('#myEditModalTab li .parent-class').tab('show');

}

function connectStudents() {
    $('#myEditModalTab li .student-class').tab('show');
}

function connectTeachers() {
    $('#myEditModalTab li .teacher-class').tab('show');
}

function connectSkills() {
    $('#myEditModalTab li .skill-class').tab('show');
    $('#skill-edit-modal .edit-skills').css('display', 'none');
    $('#skill-edit-modal .add-skills').css('display', 'block');
}

/*Attendance - START*/
$('.mark-all-present').each(function(index) {
    $(this).on('click', function(event) {
        var status = "Present";
        $('.attendance_block input[name="attendance[][status]"]').val(status);
        $('.attendance_block').find('.attendance_outdoor_layer').children().html('<img src="https://teach-static.classdojo.com/a67c7fb4f4473797c855981ea7faff78.png">');
    });
});
$('.mark-all-absent').each(function(index) {
    $(this).on('click', function(event) {
        var status = "Absent";
        $('.attendance_block input[name="attendance[][status]"]').val(status);
        $('.attendance_block').find('.attendance_outdoor_layer').children().html('<img src="https://teach-static.classdojo.com/be0f7a34ef27e82a28e9005115e57754.png">');
    });
});
var attendanceCount = 0;
$(".attendance_block").each(function(index) {
    $(this).on("click", function() {
        attendanceCount++;
        var status = "Present";
        if (attendanceCount == 0) {
            var inimg = '<img src="https://teach-static.classdojo.com/a67c7fb4f4473797c855981ea7faff78.png">';
            status = "Present";
        }
        if (attendanceCount == 1) {
            var inimg = '<img src="https://teach-static.classdojo.com/be0f7a34ef27e82a28e9005115e57754.png">';
            status = "Absent";
        }
        if (attendanceCount == 2) {
            var inimg = '<img src="https://teach-static.classdojo.com/a88b6d72d410a8cea1d8ab18a04c44d4.png">';
            status = "Late";
        }
        if (attendanceCount == 3) {
            var inimg = '<img src="https://teach-static.classdojo.com/03002e3c71802fdbb14c2bd49a148411.png">';
            status = "Late leave";
        }
        if (attendanceCount > 3) {
            var inimg = '<img src="https://teach-static.classdojo.com/a67c7fb4f4473797c855981ea7faff78.png">';
            attendanceCount = 0;
        }
        var atblock = $(this);
        atblock.find('input[name="attendance[][status]"]').val(status);
        $(this).find('.attendance_outdoor_layer').children().html(inimg);
    });
});
/*Attendance - END*/

/*Multiple-attendance - students - START*/
var selectedMultipleStudentCount = 0;
var stud1count = 0;
$("#beyonce_multiple").on("click", function() {
    stud1count++;
    if (!((stud1count % 2) == 0)) {
        $('#beyonce_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount++;
    } else {
        $('#beyonce_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount--;
    }
});
var stud2count = 0;
$("#denzel_multiple").on("click", function() {
    stud2count++;
    if (!((stud2count % 2) == 0)) {
        $('#denzel_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount++;
    } else {
        $('#denzel_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount--;
    }
});
var stud3count = 0;
$("#jennifer_multiple").on("click", function() {
    stud3count++;
    if (!((stud3count % 2) == 0)) {
        $('#jennifer_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount++;
    } else {
        $('#jennifer_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount--;
    }
});
var stud4count = 0;
$("#justin_multiple").on("click", function() {
    stud4count++;
    if (!((stud4count % 2) == 0)) {
        $('#justin_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount++;
    } else {
        $('#justin_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount--;
    }
});
var stud5count = 0;
$("#leonardo_multiple").on("click", function() {
    stud5count++;
    if (!((stud5count % 2) == 0)) {
        $('#leonardo_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount++;
    } else {
        $('#leonardo_multiple').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentCount--;
    }
});

$(".attendance_block_layer").each(function(index) {
    $(this).on("click", function() {
        if (selectedMultipleStudentCount >= 1) {
            $('.feedback-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
        } else {
            $('.feedback-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
        }
    });
});

$('.select_multiple_student').each(function(index) {
    $(this).on('click', function(event) {
        if ($(this).text() == "Select all") {
            console.log("multiple student select all");
            $(this).text('Select none');
            $('.attendance_block_layer').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.feedback-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
            selectedMultipleStudentCount++;
        }
        else if ($(this).text() == "Select none") {
            console.log("multiple student select none");
            $(this).text('Select all');
            $('.attendance_block_layer').find('.attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.feedback-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
            selectedMultipleStudentCount--;
        }
    });
});
/*Multiple-attendance - students - END*/

/*Multiple-attendance - group - START*/
$('.select_multiple_group_student').each(function(index) {
    $(this).on('click', function(event) {
        if ($(this).text() == "Select all") {
            console.log("multiple student select all");
            $(this).text('Select none');
            $('.group_attendance_block_layer').find('.group_attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.feedback-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
            selectedMultipleStudentCount++;
        }
        else if ($(this).text() == "Select none") {
            console.log("multiple student select none");
            $(this).text('Select all');
            $('.group_attendance_block_layer').find('.group_attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.feedback-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
            selectedMultipleStudentCount--;
        }
    });
});

var stud6count = 0;
var selectedMultipleStudentGroupCount = 0;
$("#tableOne_multiple").on("click", function() {
    stud6count++;
    if (!((stud6count % 2) == 0)) {
        $('#tableOne_multiple').find('.group_attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentGroupCount++;
    } else {
        $('#tableOne_multiple').find('.group_attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentGroupCount--;
    }
});
var stud7count = 0;
$("#tableTwo_multiple").on("click", function() {
    stud7count++;
    if (!((stud7count % 2) == 0) ) {
        $('#tableTwo_multiple').find('.group_attendance_outdoor_layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentGroupCount++;
    } else {
        $('#tableTwo_multiple').find('.group_attendance_outdoor_layer').children().html('<img style="background-color: rgb(218, 218, 218); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedMultipleStudentGroupCount--;
    }
});

$(".group_attendance_block_layer").each(function(index) {
    $(this).on("click", function() {
        if (selectedMultipleStudentGroupCount >= 1) {
            $('.feedback-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
        } else {
            $('.feedback-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
        }
    });
});

function groupFunction() {
    $('.multiple-attendance-btn-group #group-btn').css('background', 'rgb(0, 174, 239)');
    $('.multiple-attendance-btn-group #group-btn').css('color', 'white');
    $('.multiple-attendance-btn-group #student-btn').css('background', 'white');
    $('.multiple-attendance-btn-group #student-btn').css('color', 'rgb(0, 174, 239)');
    $('.multiple-attendance-btn-group #view-report-button').css('background', 'white');
    $('.multiple-attendance-btn-group #view-report-button').css('color', 'rgb(0, 174, 239)');
}

function studentFunction() {
    $('.multiple-attendance-btn-group #student-btn').css('background', 'rgb(0, 174, 239)');
    $('.multiple-attendance-btn-group #student-btn').css('color', 'white');
    $('.multiple-attendance-btn-group #group-btn').css('background', 'white');
    $('.multiple-attendance-btn-group #group-btn').css('color', 'rgb(0, 174, 239)');
    $('.multiple-attendance-btn-group #view-report-button').css('background', 'white');
    $('.multiple-attendance-btn-group #view-report-button').css('color', 'rgb(0, 174, 239)');
}
/*Multiple-attendance - group - END*/

/*Reset bubbles - START*/
function studentResetBubblesFunction() {
    buttonSelection("student-reset-bubbles-btn", "group-reset-bubbles-btn");
}

function groupResetBubblesFunction() {
    buttonSelection("group-reset-bubbles-btn", "student-reset-bubbles-btn");
}

var selectedResetBubbleStudentCount = 0;
var resetstud1count = 0;
$("#reset-student-1").on("click", function() {
    resetstud1count++;
    if (!((resetstud1count % 2) == 0)) {
        $('#reset-student-1').find('.student-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentCount++;
    } else {
        $('#reset-student-1').find('.student-select-outer-layer').html('<div class="student-select-inner-layer">0</div>');
        selectedResetBubbleStudentCount--;
    }
});
var resetstud2count = 0;
$("#reset-student-2").on("click", function() {
    resetstud2count++;
    if (!((resetstud2count % 2) == 0)) {
        $('#reset-student-2').find('.student-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentCount++;
    } else {
        $('#reset-student-2').find('.student-select-outer-layer').html('<div class="student-select-inner-layer">0</div>');
        selectedResetBubbleStudentCount--;
    }
});
var resetstud3count = 0;
$("#reset-student-3").on("click", function() {
    resetstud3count++;
    if (!((resetstud3count % 2) == 0)) {
        $('#reset-student-3').find('.student-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentCount++;
    } else {
        $('#reset-student-3').find('.student-select-outer-layer').html('<div class="student-select-inner-layer">0</div>');
        selectedResetBubbleStudentCount--;
    }
});
var resetstud4count = 0;
$("#reset-student-4").on("click", function() {
    resetstud4count++;
    if (!((resetstud4count % 2) == 0)) {
        $('#reset-student-4').find('.student-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentCount++;
    } else {
        $('#reset-student-4').find('.student-select-outer-layer').html('<div class="student-select-inner-layer">0</div>');
        selectedResetBubbleStudentCount--;
    }
});
var resetstud5count = 0;
$("#reset-student-5").on("click", function() {
    resetstud5count++;
    if (!((resetstud5count % 2) == 0)) {
        $('#reset-student-5').find('.student-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentCount++;
    } else {
        $('#reset-student-5').find('.student-select-outer-layer').html('<div class="student-select-inner-layer">0</div>');
        selectedResetBubbleStudentCount--;
    }
});

$(".reset-block-layer").each(function(index) {
    $(this).on("click", function() {
        if (selectedResetBubbleStudentCount >= 1) {
            $('.reset-bubble-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
        } else {
            $('.reset-bubble-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
        }
    });
});

$('.reset-bubble-footer-btn .select-all-stud .select_all_student').each(function(index) {
    $(this).on('click', function(event) {
        if ($(this).text() == "Select all") {
            console.log("multiple student select all");
            $(this).text('Select none');
            $('.reset-block-layer').find('.student-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.reset-bubble-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
            $('.group_block_layer').find('.group-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.reset-bubble-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
            selectedResetBubbleStudentGroupCount++;
            selectedResetBubbleStudentCount++;
        }
        else if ($(this).text() == "Select none") {
            console.log("multiple student select none");
            $(this).text('Select all');
            $('.reset-block-layer').find('.student-select-outer-layer').html('<div class="student-select-inner-layer">0</div>');
            $('.reset-bubble-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
            selectedResetBubbleStudentCount--;
            $('.group_block_layer').find('.group-select-outer-layer').html('<div class="group-select-inner-layer">0</div>');
            $('.reset-bubble-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
            selectedResetBubbleStudentGroupCount--;
        }
    });
});

var resetstud6count = 0;
var selectedResetBubbleStudentGroupCount = 0;
$("#group-reset-bubbles-1").on("click", function() {
    resetstud6count++;
    if (!((resetstud6count % 2) == 0)) {
        $('#group-reset-bubbles-1').find('.group-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentGroupCount++;
    } else {
        $('#group-reset-bubbles-1').find('.group-select-outer-layer').html('<div class="group-select-inner-layer">0</div>');
        selectedResetBubbleStudentGroupCount--;
    }
});
var resetstud7count = 0;
$("#group-reset-bubbles-2").on("click", function() {
    resetstud7count++;
    if (!((resetstud7count % 2) == 0) ) {
        $('#group-reset-bubbles-2').find('.group-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedResetBubbleStudentGroupCount++;
    } else {
        $('#group-reset-bubbles-2').find('.group-select-outer-layer').html('<div class="group-select-inner-layer">0</div>');
        selectedResetBubbleStudentGroupCount--;
    }
});

$(".group_block_layer").each(function(index) {
    $(this).on("click", function() {
        if (selectedResetBubbleStudentGroupCount >= 1) {
            $('.reset-bubble-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
        } else {
            $('.reset-bubble-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
        }
    });
});

/*$('.reset-bubble-footer-btn .select-all-stud .select_all_student').each(function(index) {
    $(this).on('click', function(event) {
        if ($(this).text() == "Select all") {
            console.log("multiple student select all");
            $(this).text('Select none');
            $('.group_block_layer').find('.group-select-outer-layer').children().html('<img style="background-color: rgb(0, 174, 239); border-radius: 20rem;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
            $('.reset-bubble-btn').css({
                "background-color": "rgb(51, 190, 242)"
            });
            selectedResetBubbleStudentGroupCount++;
        }
        else if ($(this).text() == "Select none") {
            console.log("multiple student select none");
            $(this).text('Select all');
            $('.group_block_layer').find('.group-select-outer-layer').html('<div class="group-select-inner-layer">0</div>');
            $('.reset-bubble-btn').css({
                "background-color": "rgb(218, 218, 218)"
            });
            selectedResetBubbleStudentGroupCount--;
        }
    });
});*/
/*Reset bubbles - END*/

/*Create group - START*/
var selectedStudentForGroup = 0;
var studentOneCountForGroup = 0;
$('#beyonce-add-to-group').on('click', function() {
    studentOneCountForGroup++;
    if(!((studentOneCountForGroup % 2) == 0)) {
        $('#beyonce-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#beyonce-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#beyonce-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#beyonce-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var studentTwoCountForGroup = 0;
$('#denzel-add-to-group').on('click', function() {
    studentTwoCountForGroup++;
    if(!((studentTwoCountForGroup % 2) == 0)) {
        $('#denzel-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#denzel-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#denzel-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#denzel-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});
var studentThreeCountForGroup = 0;
$('#jennifer-add-to-group').on('click', function() {
    studentThreeCountForGroup++;
    if(!((studentThreeCountForGroup % 2) == 0)) {
        $('#jennifer-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#jennifer-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#jennifer-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#jennifer-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var studentFourCountForGroup = 0;
$('#justin-add-to-group').on('click', function() {
    studentFourCountForGroup++;
    if(!((studentFourCountForGroup % 2) == 0)) {
        $('#justin-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#justin-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#justin-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#justin-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var studentFiveCountForGroup = 0;
$('#leonard-add-to-group').on('click', function() {
    studentFiveCountForGroup++;
    if(!((studentFiveCountForGroup % 2) == 0)) {
        $('#leonard-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#leonard-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#leonard-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#leonard-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var groupNameEntered = false;
var selectStudentForCreateGroup = false;
function createGroupButton() {
    if(groupNameEntered && selectStudentForCreateGroup) {
        $('#create-group-btn').attr('disabled', false);
        $('#create-group-btn').css({
            "background-color": "rgb(51, 190, 242)"
        });
    }
    else {
        $('#create-group-btn').attr('disabled', true);
        $('#create-group-btn').css({
            "background-color": "rgb(218, 218, 218)"
        });
    }
}


$('.group-name-content .form-inline .form-group input').keyup(function(event) {
    if($(this).val() != '') {
        groupNameEntered = true;
    }
    else {
        groupNameEntered = false;
    }
    createGroupButton();
});

$('.student-to-add-group').each(function() {
    $(this).on("click", function() {
        if(selectedStudentForGroup >= 1) {
            selectStudentForCreateGroup = true;
        }
        else {
            selectStudentForCreateGroup = false;
        }
        createGroupButton();
    });
});
/*Create group - END*/

$(document).ready(function() {
    var currentId = '';
    var blog = '';
    var taskName = '';
    $('#positiveDesktopTab .positive-desktop-container .row .student-task, #positiveDesktopTab .positive-desktop-container .row .positive-tab-add-skills, #needsDesktopWorkTab .need-work-containter .row .need-work-add-skills').hover(function() {
        currentId = $(this).attr('id');
        blog = $('#' + currentId).children('img').attr('src');
        taskName = $('#' + currentId).children('.task-name').html();
        $('#' + currentId).children('img').attr('src', 'https://teach-static.classdojo.com/4be21f7fe9ae98b7ab205d1bd0194a9f.png');
        $('#' + currentId).children('.task-points').hide();
        //$('#' + currentId).children('.task-name').children('p').replaceWith('<p class="hover-edit-text" style="color: white;">Edit</p>')
    }, function() {
        $('#' + currentId).children('img').attr('src', blog);
        $('#' + currentId).children('.task-points').show();
        //$('#' + currentId).children('.task-name').children('p').replaceWith(taskName);
    });
});


/*---------------------
  Teacher page script
-----------------------*/

/*Create group - START*/
var selectedStudentForGroup = 0;
var studentOneCountForGroup = 0;
$('#beyonce-add-to-group').on('click', function() {
    studentOneCountForGroup++;
    if(!((studentOneCountForGroup % 2) == 0)) {
        $('#beyonce-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#beyonce-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#beyonce-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#beyonce-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var studentTwoCountForGroup = 0;
$('#denzel-add-to-group').on('click', function() {
    studentTwoCountForGroup++;
    if(!((studentTwoCountForGroup % 2) == 0)) {
        $('#denzel-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#denzel-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#denzel-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#denzel-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});
var studentThreeCountForGroup = 0;
$('#jennifer-add-to-group').on('click', function() {
    studentThreeCountForGroup++;
    if(!((studentThreeCountForGroup % 2) == 0)) {
        $('#jennifer-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#jennifer-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#jennifer-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#jennifer-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var studentFourCountForGroup = 0;
$('#justin-add-to-group').on('click', function() {
    studentFourCountForGroup++;
    if(!((studentFourCountForGroup % 2) == 0)) {
        $('#justin-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#justin-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#justin-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#justin-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var studentFiveCountForGroup = 0;
$('#leonard-add-to-group').on('click', function() {
    studentFiveCountForGroup++;
    if(!((studentFiveCountForGroup % 2) == 0)) {
        $('#leonard-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(0, 174, 239)');
        $('#leonard-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup++;
    }
    else {
        $('#leonard-add-to-group').find('.student-select-inner-layer').css('background-color', 'rgb(218, 218, 218)');
        $('#leonard-add-to-group').find('.student-select-outer-layer').children().html('<img style="display: block;height: 24px;width: 23px;" src="https://teach-static.classdojo.com/61349f8482ecfd35884ab4a8781fe218.png">');
        selectedStudentForGroup--;
    }
});

var groupNameEntered = false;
var selectStudentForCreateGroup = false;
function createGroupButton() {
    if(groupNameEntered && selectStudentForCreateGroup) {
        $('#create-group-btn').attr('disabled', false);
        $('#create-group-btn').css({
            "background-color": "rgb(51, 190, 242)"
        });
    }
    else {
        $('#create-group-btn').attr('disabled', true);
        $('#create-group-btn').css({
            "background-color": "rgb(218, 218, 218)"
        });
    }
}


$('.group-name-content .form-inline .form-group input').keyup(function(event) {
    if($(this).val() != '') {
        groupNameEntered = true;
    }
    else {
        groupNameEntered = false;
    }
    createGroupButton();
});

$('.student-to-add-group').each(function() {
    $(this).on("click", function() {
        if(selectedStudentForGroup >= 1) {
            selectStudentForCreateGroup = true;
        }
        else {
            selectStudentForCreateGroup = false;
        }
        createGroupButton();
    });
});
/*Create group - END*/

$(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

