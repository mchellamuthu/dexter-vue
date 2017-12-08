<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=1024">
    <title>Dexter</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- font-awesome icons -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css" rel="stylesheet"> <!-- toggle - button -->

    <!-- Bootstrap -->
    <link href="/ui/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/ui/css/project.css">
    <link rel="stylesheet" type="text/css" href="/ui/css/header_navigation.css">
  </head>
  <body style="background-color: rgb(245, 245, 243);">
    <!-- Email verification - Start -->
    <div class="dojo-header-content">
       <div class="dojo-header-text">
          <span>You still need to verify your email!</span>
          <a href="" class="resend-email">Resend email to josna@gmail.com</a> or
          <a href="" class="update-email" data-toggle="modal" data-target="#update-email-address">update your email address</a>
       </div>
    </div>
    <!-- Email verification - End -->

    <!-- Navigation for user profile - Start -->
      <nav class="navbar navbar-default navbar-settings">
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="/"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle withImageAndIcon" data-toggle="dropdown" role="button">
                     Login as <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>Student</span></a>
                        </li>
                        <li>
                           <a href="#"><img src="/images/header_navigation_images/parent.png" class="img-responsive"> Parent</a>
                        </li>
                        <li>
                           <a href="/cdojo1"><i class="fa fa-user" aria-hidden="true"></i> <span>School Leader</span></a>
                        </li>
                     </ul>
                  </li>
                  <li><a href="#" data-toggle="modal" data-target="#myTeacherModal"><img class="img-responsive" src="images/header_navigation_images/logo6.png"></a></li>
                  <li><a href="#" data-toggle="modal" data-target="#myTeacherModal">Refer a teacher</a></li>
                  <li><a href="#"><img class="img-responsive" src="/images/header_navigation_images/logo7.png"/></a></li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle withImageAndIcon" data-toggle="dropdown" role="button">
                        <div class="profile-icon"></div>
                        <div class="updated-profile-icon"></div>
                        Mr.ram <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="#" data-toggle="modal" data-target="#update-email-address">Account Settings</a>
                        </li>
                        <li>
                           <a href="#" data-toggle="modal" data-target="#myTeacherModal">Refer a teacher</a>
                        </li>
                        <li>
                           <a href="/cdojo1">Logout</a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container-fluid -->
      </nav>
      <!-- Navigation for user profile - end -->

      <!-- Teacher profile details - START -->

      <div class="container-fluid profile-background">
         <div class="row" style="width: 100%">
         <button class="btn btn-default change-btn" onclick="changeCoverPhoto()"><i class="fa fa-camera fa-lg" aria-hidden="true"></i></button>
            <div class="col-md-6 col-md-offset-3">
               <div class="col-md-3">
                  <div class="add-profile-photo" onclick="showPicker()">
                     <div class="add-photo-section">Add your photo</div>
                  </div>
                  <div class="add-profile-picture" onclick="showPicker()">
                  </div>
               </div>
               <div class="col-md-9 school-detail-content">
                  <div class="user-name">Mr. Sai</div>
                  <div class="school-name"><strong>Teacher at Government Higher Secondary School</strong></div>
                  <div>
                     <button class="btn btn-primary pd-resource-btn"> PD Resources </button>
                     <button class="btn btn-primary pd-resource-btn" onclick="window.location.href='add_school_class_student_details.php'; "> Add Institute </button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Teacher profile details - END -->

      <!-- Class selection navigation - Start -->
      <nav class="navbar navbar-default main_navigation" role="navigation">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#class-view-navbar-collapse">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>

            </div>
            <div class="navbar-collapse collapse" id="class-view-navbar-collapse">
               <ul class="nav navbar-nav navbar-center custom_menu">
                  <li class="active">
                    <a href="teacher_classes.php">
                      <i class="fa fa-university fa-lg" aria-hidden="true"></i>
                      Classes
                    </a>
                  </li>
                  <li class="">
                    <a href="staff_view.php">
                      <i class="fa fa-user fa-lg" aria-hidden="true"></i>
                      Staffs
                    </a>
                  </li>
                  <li class="">
                    <a href="staff_story.php">
                      <i class="fa fa-picture-o fa-lg" aria-hidden="true"></i>
                      Stories
                    </a>
                  </li>
               </ul>

            </div>
         </div>
      </nav>
      <!-- Class selection navigation - End -->

      <!-- Class view - Start -->
      <div class="container">
       <div class="row">
          <div class="col-md-4 col-md-offset-4 teacher-class-view-btn">
           <div class="btn-group" role="group" aria-label="...">
            <button type="button" id="class-btn" onclick="window.location.href='teacher_classes.php'; classFunction()" class="btn btn-default">Class</button>
            <button type="button" id="group-class-btn" onclick="window.location.href='teacher_class_group.php'; groupClassFunction()" class="btn btn-default">Group</button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="class-block">
          <div class="class-settings">
            <span>
              <div class="dropdown-toggle" data-toggle="dropdown">
                 <div class="class-settings-icon"><img src="images/class_images/settings_icon.png" width="16" icon="gear" height="16"></div>
              </div>
              <ul class="dropdown-menu" style="left: -14rem;">
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectClass()">Edit class</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Connect parents</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectStudents()">Connect students</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectTeachers()">Add co-teachers</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Archive class</a>
                 </li>
              </ul>
            </span>
          </div>
          <a href="student_view.php">
            <div class="class-image-content">
               <img src="images/class_images/class1.png">
               <div id="class-name">Demo Class</div>
               <div id="no-of-students">5 Students</div>
            </div>
          </a>
        </div>

        <div class="class-block">
          <div class="class-settings">
            <span>
              <div class="dropdown-toggle" data-toggle="dropdown">
                 <div class="class-settings-icon"><img src="images/class_images/settings_icon.png" width="16" icon="gear" height="16"></div>
              </div>
              <ul class="dropdown-menu" style="left: -14rem;">
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectClass()">Edit class</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Connect parents</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectStudents()">Connect students</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectTeachers()">Add co-teachers</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Archive class</a>
                 </li>
              </ul>
            </span>
          </div>
          <a href="student_view.php">
            <div class="class-image-content">
               <img src="images/class_images/class2.png">
               <div id="class-name">Drawing Class</div>
               <div id="no-of-students">5 Students</div>
            </div>
          </a>
        </div>

        <div class="class-block">
          <div class="class-settings">
            <span>
              <div class="dropdown-toggle" data-toggle="dropdown">
                 <div class="class-settings-icon"><img src="images/class_images/settings_icon.png" width="16" icon="gear" height="16"></div>
              </div>
              <ul class="dropdown-menu" style="left: -14rem;">
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectClass()">Edit class</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Connect parents</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectStudents()">Connect students</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectTeachers()">Add co-teachers</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Archive class</a>
                 </li>
              </ul>
            </span>
          </div>
          <a href="student_view.php">
            <div class="class-image-content">
               <img src="images/class_images/class3.png">
               <div id="class-name">Music Class</div>
               <div id="no-of-students">5 Students</div>
            </div>
          </a>
        </div>

        <div class="class-block">
          <div class="class-settings">
            <span>
              <div class="dropdown-toggle" data-toggle="dropdown">
                 <div class="class-settings-icon"><img src="images/class_images/settings_icon.png" width="16" icon="gear" height="16"></div>
              </div>
              <ul class="dropdown-menu" style="left: -14rem;">
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectClass()">Edit class</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Connect parents</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectStudents()">Connect students</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectTeachers()">Add co-teachers</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Archive class</a>
                 </li>
              </ul>
            </span>
          </div>
          <a href="student_view.php">
            <div class="class-image-content">
               <img src="images/class_images/class4.png">
               <div id="class-name">Demo Class</div>
               <div id="no-of-students">5 Students</div>
            </div>
          </a>
        </div>

        <div class="class-block">
          <div class="class-settings">
            <span>
              <div class="dropdown-toggle" data-toggle="dropdown">
                 <div class="class-settings-icon"><img src="images/class_images/settings_icon.png" width="16" icon="gear" height="16"></div>
              </div>
              <ul class="dropdown-menu" style="left: -14rem;">
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectClass()">Edit class</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Connect parents</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectStudents()">Connect students</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectTeachers()">Add co-teachers</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Archive class</a>
                 </li>
              </ul>
            </span>
          </div>
          <a href="student_view.php">
            <div class="class-image-content">
               <img src="images/class_images/class5.png">
               <div id="class-name">Drawing Class</div>
               <div id="no-of-students">5 Students</div>
            </div>
          </a>
        </div>

        <div class="class-block">
          <div class="class-settings">
            <span>
              <div class="dropdown-toggle" data-toggle="dropdown">
                 <div class="class-settings-icon"><img src="images/class_images/settings_icon.png" width="16" icon="gear" height="16"></div>
              </div>
              <ul class="dropdown-menu" style="left: -14rem;">
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectClass()">Edit class</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Connect parents</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectStudents()">Connect students</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectTeachers()">Add co-teachers</a>
                 </li>
                 <li>
                    <a href="" data-toggle="modal" data-target="#myInstituteModal" onclick="connectParents()">Archive class</a>
                 </li>
              </ul>
            </span>
          </div>
          <a href="student_view.php">
            <div class="class-image-content">
               <img src="images/class_images/class6.png">
               <div id="class-name">Music Class</div>
               <div id="no-of-students">5 Students</div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <!-- Class view - END -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
      <script src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
    <!-- <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->

     <!-- File Stack - profile picture - start -->
      <script type="text/javascript" src="https://static.filestackapi.com/v3/filestack.js"></script>
      <script type="text/javascript">
         var client = filestack.init('AxCK8Sd0ARlOOpib6Vd2Gz');
         function showPicker() {
             client.pick({
             }).then(function(result) {
                 uploadedImageUrl = result.filesUploaded[0].url;
                 $('.add-profile-photo').css('display', 'none');
                 $('.add-profile-picture').css('display', 'block');
                 $('.add-profile-picture').css('background-image', 'url(" ' + uploadedImageUrl + ' " )');

                 $('.profile-icon').css('display', 'none');
                 $('.updated-profile-icon').css('display', 'inline-block');
                 $('.updated-profile-icon').css('background-image', 'url(" ' + uploadedImageUrl + ' " )');
             });
         }

         function changeCoverPhoto() {
          client.pick({
          }).then(function(result) {
            uploadedImageUrl = result.filesUploaded[0].url;
            var cssStyle = ""
            var backgroundUrl = "url(" + uploadedImageUrl + ") no-repeat center center"
            $('.profile-background').css({
              'background': backgroundUrl,
              'background-size': 'cover',
              'height': '22rem',
              'background-color': '#060',
              'color': '#fff',
              'text-align': 'center',
              'text-shadow': '0 1px 3px rgba(0,0,0,.5)',
              'position': 'relative',
            });
          });
         }
      </script>

      <!-- File Stack - profile picture - END -->
  </body>
</html>
