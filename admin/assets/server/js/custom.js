/*===========================================================================
| Project Name: Upload & Share
| Author: Berkine
| Author URL: https://codecanyon.net/user/berkine/portfolio
| Version: 1.0
| File name: server/custom.js
| Date Created: 21.11.2020
| Website: envato.berkine.cloud/s3-filetransfer
============================================================================= */


/* -------------------------------------------------------------- */
/*                      TABLE OF CONTENTS
/* -------------------------------------------------------------- */
/*   01 - CONFIGURATION DROPDOWN MENUS                            */
/*   02 - MINIMIZE NAVBAR MENU                                    */
/*   03 - NAVBAR MENU ACTIVE BUTTON HIGHLIGHT                     */
/*   04 - MATERIAL EFFECT FOR ACTION BUTTONS                      */
/*   05 - COPY DONWLOAD LINK TO CLIPBOARD FUNCTION                */
/*   06 - FILES DATA TABLE INITIATION                             */
/*   07 - SHARE DATA TABLE INITIATION                             */
/*   08 - GET DOWNLOAD LINK ACTION BUTTON                         */
/*   09 - FILE DONWLOAD ACTION BUTTON                             */
/*   10 - SEND DOWNLOAD LINK VIA EMAIL ACTION BUTTON              */
/*   11 - FILE DELETE ACTION BUTTON                               */
/*   12 - DOWNLOAD ALL SELECTED FILES ACTION BUTTON               */
/*   13 - FILE DELETE ALL FILES ACTION BUTTON                     */
/*   14 - SEND SELECTED FILE DOWNLOAD LINKS ACTION BUTTON         */
/*   15 - SHOW DAILY UPLOADED FILES GRAPH                         */
/*   16 - SHOW DAILY UPLOADED TRAFFIC GRAPH                       */
/*   17 - DASHBOARD TOTAL BUCKET SIZE                             */
/*   18 - CHECK/UNCHECK ALL CHECKBOXES AND ENABLE/DISABLE         */
/*   19 - GOOGLE ANALYTICS GRAPH (FOR ANALYTICS & DASHBOARD PAGES)*/
/*   20 - FILE UPLOAD BUTTON (GOOGLE ACCOUNT CREDENTIALS)         */
/*   21 - ENABLE TOOLTIPS                                         */


/*===========================================================================
*
*  01 - CONFIGURATION DROPDOWN MENUS
*
*============================================================================*/

$(document).ready(function(){

    "use strict";

    $('#region').awselect({
            background: "#3D9AFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "12px", //top and bottom padding
            horizontal_padding: "15px" // left and right padding,
    }); 

    $('#share_type').awselect({
            background: "#3D9AFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "12px", //top and bottom padding
            horizontal_padding: "15px" // left and right padding,
    }); 

    $('#signed_link').awselect({
            background: "#3D9AFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "12px", //top and bottom padding
            horizontal_padding: "15px" // left and right padding,
    });

    $('#link_expiration').awselect({
            background: "#3D9AFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "12px", //top and bottom padding
            horizontal_padding: "15px" // left and right padding,
    });

    $('#chunk_size').awselect({
            background: "#3D9AFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "12px", //top and bottom padding
            horizontal_padding: "15px" // left and right padding,
    });

    $('#server_encryption').awselect({
            background: "#3D9AFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "12px", //top and bottom padding
            horizontal_padding: "15px" // left and right padding,
    });  

});

/*===========================================================================
*
*  02 - MINIMIZE NAVBAR MENU
*
*============================================================================*/

$(document).ready(function() {

    "use strict";

    var largeMenu = 250;
    $('#pushmenu').on('click', function(e) {

      e.preventDefault();

      if($('.main-sidebar').css('width') == '250px') {
          $('.main-sidebar').css('width', '50px');
          $('.main-header').css('margin-left','50px');
          $('.content-wrapper').css('margin-left','50px');
          $('.main-sidebar .sidebar > nav > ul > li.nav-header').fadeOut('fast');
          $('.main-sidebar .sidebar > nav > ul > li > a > p').fadeOut('fast');
          $('.main-sidebar .sidebar > nav > ul > li > a > i.nav-icon').css({'font-size': '18px', 'margin-right':'0.2rem'});
          $('.main-sidebar .sidebar > nav > ul > li > a.nav-link').css({'padding-left': '1rem'});
          $('.main-sidebar .brand-link').css({'width': '50px', 'padding-right': '1rem', 'padding-left':'1rem'});
          $('.main-sidebar .brand-link span').fadeOut('fast');         
          $('footer').css('display', 'none');

      } else {          
          $('.main-sidebar').css('width', '250px');
          $('.main-header').css('margin-left','250px');
          $('.content-wrapper').css('margin-left','250px');
          $('.main-sidebar .brand-link span').fadeIn('fast');
          $('.main-sidebar .brand-link').css({'width': '250px', 'padding-right': '1.5rem', 'padding-left':'1.5rem'});
          $('.main-sidebar .sidebar > nav > ul > li > a > p').fadeIn('slow');
          $('.main-sidebar .sidebar > nav > ul > li.nav-header').fadeIn('slow');        
          $('.main-sidebar .sidebar > nav > ul > li > a > i.nav-icon').css({'font-size': '14px', 'margin-right':'0.4rem'});
          $('.main-sidebar .sidebar > nav > ul > li > a.nav-link').css({'padding-left': '1.5rem', 'padding-right': '1.5rem'});
                                     
      }

    });

});



/*===========================================================================
*
*  03 - NAVBAR MENU ACTIVE BUTTON HIGHLIGHT
*
*============================================================================*/

$(document).ready(function(){
    $(".nav-link").each(function () {
        var currentPage = window.location.pathname;
        var indexPage = '.php';

        if (currentPage.includes($(this).attr('href'))) {
            $(this).addClass("active");
        } else if (currentPage.toLowerCase().indexOf(indexPage) === -1) {
            $('#dashboard-page').addClass("active");
        }
    });


});



/*===========================================================================
*
*  04 - MATERIAL EFFECT FOR ACTION BUTTONS
*
*============================================================================*/

$(function(){

    "use strict";

    var ua =navigator.userAgent;
    if(ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1 || ua.indexOf('iPod')  > -1){
      var start = "touchstart";
      var move  = "touchmove";
      var end   = "touchend";
    } else{
      var start = "mousedown";
      var move  = "mousemove";
      var end   = "mouseup";
    }
    var ink, d, x, y;
    $(".ripple").on(start, function(e){
      if($(this).find(".ink").length === 0){
          $(this).prepend("<span class='ink'></span>");
      }
           
      ink = $(this).find(".ink");
      ink.removeClass("animate");
       
      if(!ink.height() && !ink.width()){
          d = Math.max($(this).outerWidth(), $(this).outerHeight());
          ink.css({height: d, width: d});
      }
       
      x = e.originalEvent.pageX - $(this).offset().left - ink.width()/2;
      y = e.originalEvent.pageY - $(this).offset().top - ink.height()/2;
       
      ink.css({top: y+'px', left: x+'px'}).addClass("animate");

  });

});



/*===========================================================================
*
*  05 - COPY DONWLOAD LINK TO CLIPBOARD FUNCTION
*
*============================================================================*/

function copyToClipboard(link) {

  "use strict";

  var textArea = document.createElement( "textarea" );
  textArea.value = link;
  document.body.appendChild( textArea );

  textArea.select();

  try {
      var successful = document.execCommand( 'copy' );
      var msg = successful ? 'successful' : 'unsuccessful';

  } catch (err) {
      console.log(msg);
  }
    document.body.removeChild( textArea );
}



/*===========================================================================
*
*  06 - FILES DATA TABLE INITIATION
*
*============================================================================*/

var fileTable;

$(document).ready(function(){

  "use strict";

  fileTable = $('#filesTable').DataTable({
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      language: { 
          search: "<i class='fas fa-search' id='bigger'></i>",
          lengthMenu: ' _MENU_',
          paginate : {
                first    : '<i class="fas fa-angle-double-left"></i>',
                last     : '<i class="fas fa-angle-double-right"></i>',
                previous : '<i class="fas fa-angle-left"></i>',
                next     : '<i class="fas fa-angle-right"></i>'
          } 
      },
      pagingType : 'full_numbers',
      responsive: true,
      colReorder: true,
      'processing': true,
      'serverSide': true,
      'order': [],
      'ajax': {
          url:'../admin/includes/tablefilesprocess.inc.php',
          type: 'post'
      },
       "columns": [
        { "orderable": false },
        null,
        null,
        { "orderable": false },
        null,
        null,
        { "orderable": false }
      ]
  });

});



/*===========================================================================
*
*  07 - SHARE DATA TABLE INITIATION
*
*============================================================================*/

$(document).ready(function(){

  "use strict";

  var fileTable = $('#shareTable').DataTable({
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      language: { 
          search: "<i class='fas fa-search' id='bigger'></i>",
          lengthMenu: ' _MENU_',
          paginate : {
                first    : '<i class="fas fa-angle-double-left"></i>',
                last     : '<i class="fas fa-angle-double-right"></i>',
                previous : '<i class="fas fa-angle-left"></i>',
                next     : '<i class="fas fa-angle-right"></i>'
          } 
      },
      pagingType : 'full_numbers',
      responsive: true,
      colReorder: true,
      'processing': true,
      'serverSide': true,
      'order': [],
      'ajax': {
          url:'../admin/includes/tablesharesprocess.inc.php',
          type: 'post'
      }
  });

});



/*===========================================================================
*
*  08 - GET DOWNLOAD LINK ACTION BUTTON
*
*============================================================================*/

$(document).on('click', '.link', function() {

  "use strict";

  var id = $(this).attr("id");

  $.ajax({

      url:"../admin/includes/tableactions.inc.php",
      method:"POST",
      data:{
        id: id,
        action: 'link'
      },
      success:function(data) {       
          copyToClipboard(data);
      }
   
  });

   $(this).tooltip('hide')
    .attr('data-original-title', 'Copied')
    .tooltip('show');

});



/*===========================================================================
*
*  09 - FILE DONWLOAD ACTION BUTTON
*
*============================================================================*/

$(document).on('click', '.download', function() {

  "use strict";

  var id = $(this).attr("id");

  $.ajax({

      url:"../admin/includes/tableactions.inc.php",
      method:"POST",
      data:{
        id: id,
        action: 'download'
      },
      success:function(data) {       
          window.open(data,'_blank');
      }
   
  });

   $(this).tooltip('hide')
    .attr('data-original-title', 'Downloading')
    .tooltip('show');

});



/*===========================================================================
*
*  10 - SEND DOWNLOAD LINK VIA EMAIL ACTION BUTTON
*
*============================================================================*/

 $(".send-email").on("submit",(function(e) {

      "use strict";

      e.preventDefault();

      var id = document.getElementById('id-number').innerText;

      var formData = new FormData(this);
      formData.append('action', 'email-link');
      formData.append('id', id);

      $.ajax({
           type: "POST",
           url: "../admin/includes/tableactions.inc.php",
           data: formData,
           contentType: false,
           processData: false,
           cache: false,
           success: function(response) {                 
              $('#email-link').modal('hide');

              if (response) {
                var message = 'Email has been successfully sent.';
                $('.notification-message').html(message).addClass('success-message').slideDown().delay(5000).slideUp();
              } else {
                var message = 'There was an error with email sending, try again.';
                $('.notification-message').html(message).addClass('error-message').slideDown().delay(5000).slideUp();
              }
           }

      }).done(function(data) {              
          document.getElementById('email').value = '';
          document.getElementById('subject').value = '';
          document.getElementById('message').value = '';
      });     
       
 }));


 $('#email-link').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('#id-number', this).text(data.id);
    $('.file', this).text(data.file);
    $('.btn-ok', this).data('id', data.id);
});



/*===========================================================================
*
*  11 - FILE DELETE ACTION BUTTON
*
*============================================================================*/

$('#confirm-delete').on('click', '.btn-ok', function(e) {

  "use strict";

  var $modalDiv = $(e.delegateTarget);
  var id = $(this).data("id");

  $.ajax({

      url:"../admin/includes/tableactions.inc.php",
      method:"POST",
      data:{
        id: id,
        action: 'delete'
      },
      success:function(data) {

          fileTable.ajax.reload();
          $modalDiv.modal('hide');

          var message = 'Selected file was successfully deleted.';
          $('.notification-message').html(message).addClass('success-message').slideDown().delay(5000).slideUp();

      }
   
  });
  
});


$('#confirm-delete').on('show.bs.modal', function(e) {
  var data = $(e.relatedTarget).data();
  $('.title', this).text(data.title);
  $('.btn-ok', this).data('id', data.id);
});



/*===========================================================================
*
*  12 - DOWNLOAD ALL SELECTED FILES ACTION BUTTON
*
*============================================================================*/

$('#actions-total-download').on('click', function(e) {

  "use strict";

  e.preventDefault();

  var ids = [];
  var links;

  $("input:checkbox[name=selectfile]:checked").each(function(){
        ids.push($(this).val());
  });

  var idList = ids.join(',');
  
  $.ajax({

      url:"../admin/includes/tableactions.inc.php",
      method:"POST",
      data:{
        id: idList,
        action: 'download-all'
      },
      success:function(data) {       
        links = data;
      }

  }).done(function(data) {   
		links.forEach(getFile);

  })


  
});

function getFile(item, index) {
     window.open(item);
}



/*===========================================================================
*
*  13 - FILE DELETE ALL FILES ACTION BUTTON
*
*============================================================================*/

$('#actions-total-delete').on('click', function(e) {

  "use strict";

  e.preventDefault();


  $('#confirm-delete-all').modal();

  var ids = [];

  $('#delete-files').unbind('submit').submit(function(event) {
      event.preventDefault();

      $("input:checkbox[name=selectfile]:checked").each(function(){
            ids.push($(this).val());
      });

      var idList = ids.join(',');
      
      $.ajax({

          url:"../admin/includes/tableactions.inc.php",
          method:"POST",
          data:{
            id: idList,
            action: 'delete-all'
          },
          success:function(data) {

              var message = 'Selected file was successfully deleted.';
              $('.notification-message').html(message).addClass('success-message').slideDown().delay(5000).slideUp();


              $('#confirm-delete-all').modal('hide');
          }
   
      }).done(function(data) {   
          fileTable.ajax.reload();
          $('.actions-total-buttons').attr("disabled", true);   

          document.getElementById('email').value = '';
          document.getElementById('subject').value = '';
          document.getElementById('message').value = '';
      });
  });

  
});



/*===========================================================================
*
*  14 - SEND SELECTED FILE DOWNLOAD LINKS ACTION BUTTON
*
*============================================================================*/

$('#actions-total-share').on('click', function(e) {

  "use strict";

  e.preventDefault();


  $('#email-link-all').modal();

  var ids = [];

  $('#send-email-all').unbind('submit').submit(function(event) {
      event.preventDefault();

      $("input:checkbox[name=selectfile]:checked").each(function(){
            ids.push($(this).val());
      });

      var idList = ids.join(',');

      var formData = new FormData(this);
      formData.append('id', idList);
      formData.append('action', 'email-all');

      $.ajax({
          type: "POST",
           url: "../admin/includes/tableactions.inc.php",
           data: formData,
           contentType: false,
           processData: false,
           cache: false,
          success:function(data) {

              if (data) {
                var message = 'Download links for selected files have been sent successfully.';
                $('.notification-message').html(message).addClass('success-message').slideDown().delay(5000).slideUp();                
              } else {
                var message = 'There was an error with email sending, try again.';
                $('.notification-message').html(message).addClass('success-message').slideDown().delay(5000).slideUp();
              }

              $('#email-link-all').modal('hide');
              
          }
   
      }).done(function(data) {   
          fileTable.ajax.reload();
          $('.actions-total-buttons').attr("disabled", true);
                     
          document.getElementById('email').value = '';
          document.getElementById('subject').value = '';
          document.getElementById('message').value = '';
      });

  });

  
});



/*===========================================================================
*
*  15 - SHOW DAILY UPLOADED FILES GRAPH
*
*============================================================================*/

$(document).ready(function() {

  "use strict";

  if ( $(".box-content canvas").is("#uploaded-files-chart")) {

      $.post({
          method: 'POST',
          url: '../admin/includes/countuploadedfiles.inc.php', 
          beforeSend: function() {
                $("#uploaded-files").removeClass('deactivated');         
          },
          complete: function() {
              $("#uploaded-files").addClass('deactivated');
          },

      }).done(function(data) {

              var dataset_tmp = JSON.parse(data);
              var dataset = Object.values(dataset_tmp);

              var labels = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                          '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];


              var ctx = document.getElementById('uploaded-files-chart').getContext('2d');
              var timeAnalytics = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: labels,
                    datasets: [
                      {
                        label: "Total Files ",
                        data: dataset,
                        backgroundColor: 'rgba(1, 205, 62, 0.4)',
                        borderColor: 'rgba(1, 205, 62, 1)',
                              borderWidth: 1,
                              hoverBackgroundColor: 'rgba(1, 205, 62, 1)',    
                      }
                    ]
                  },
                  options: {
                      tooltips: {
                                cornerRadius: 0,
                                xPadding: 10,
                                yPadding: 10
                            },
                      legend: { 
                        display: true,
                        position: 'bottom',
                        labels: {
                          boxWidth: 10,
                          fontSize: 10
                        } 
                      },
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero: true,
                                  stepSize: 20,                                     
                              },
                              gridLines: {
                            borderDash: [3, 1]                            
                        }
                          }],
                          xAxes: [{
                              gridLines: {                            
                                  borderDash: [3, 1]                            
                              }
                          }]
                      }

                  }
              });

      });

    }

});



/*===========================================================================
*
*  16 - SHOW DAILY UPLOADED TRAFFIC GRAPH
*
*============================================================================*/

$(document).ready(function() {

  "use strict";

  if ( $(".box-content canvas").is("#uploaded-traffic-chart") ) {

      $.post('../admin/includes/countuploadedtraffic.inc.php', {


      }).done(function(data) {

              var dataset_tmp = JSON.parse(data);
              var dataset = Object.values(dataset_tmp);

              var labels = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                          '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];


              var ctx = document.getElementById('uploaded-traffic-chart').getContext('2d');
              var usersAnalytics = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: labels,
                      datasets: [{
                          label: 'Upload Size (MB) ',
                          data: dataset,
                          pointBackgroundColor: 'rgba(1, 205, 62, 1)',  
                          pointBorderColor: 'rgba(1, 205, 62, 1)',                            
                          backgroundColor: [
                            'rgba(1, 205, 62, 0.2)',
                          ],
                          pointStyle: 'rect',
                          borderColor: [
                            'rgba(1, 205, 62, 1)',
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                    scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero: true,
                                  stepSize: 100,                                     
                              },
                              gridLines: {
                            borderDash: [3, 1]                            
                        }
                          }],
                          xAxes: [{
                        gridLines: {                            
                            borderDash: [3, 1]                            
                        }
                    }]
                      },
                      tooltips: {
                        cornerRadius: 0,
                        xPadding: 10,
                        yPadding: 10
                      },
                      legend: {
                        position: 'bottom',
                        labels: {
                          boxWidth: 10,
                          fontSize: 10
                        }
                      }
                  }
            });

      });

    }

});



/*===========================================================================
*
*  17 - DASHBOARD TOTAL BUCKET SIZE 
*
*============================================================================*/

$(document).ready(function() {

  "use strict";

  $.post('../admin/includes/totalupload.inc.php', {


  }).done(function(data) {

      var output = data.replace(/"/g,"");
      $('#total-bucket-size').text(output);

  });
    

});



/*===========================================================================
*
*  18 - CHECK/UNCHECK ALL CHECKBOXES AND ENABLE/DISABLE TOP ACTION BUTTONS
*
*============================================================================*/

$(document).on('click', '#select-all', function (e) {

    "use strict";

    e.preventDefault();
    $('.selectfile').prop('checked', !$('.selectfile').prop('checked'));
    checkSelected();

});


$(document).on('click', '.selectfile', function (e) {
    checkSelected();
});


function checkSelected(){

    if ($('.selectfile:checked').length > 0) {
        $('.actions-total-buttons').attr("disabled", false);
    } else {
        $('.actions-total-buttons').attr("disabled", true);
    }
}



/*===========================================================================
*
*  19 - GOOGLE ANALYTICS GRAPH (FOR ANALYTICS AND DASHBOARD PAGES)
*
*============================================================================*/

(function(){

   
   if ( $(".content-body div").is("#google-analytics-charts") ) {

      var now = moment();
      var start_date = moment(now).subtract(14, 'day').format('YYYY-MM-DD');
      var end_date = moment(now).format('YYYY-MM-DD');

      /* --------------------------------------------------- */
      /*   USERS & SESSIONS DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'users_sessions_biweekly',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#users-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#users-biweekly").addClass('deactivated');
            },
            success: function(data) {              
            }, 
            error: function (data) {              
              console.log(data)
            }
        }).done(function(data) {

            var sessions = data.rows.map(function(row) { return +row[2]; });
            var users = data.rows.map(function(row) { return +row[1]; });
            var labels = data.rows.map(function(row) { return +row[0]; });

            labels = labels.map(function(label) {
              return moment(label, 'YYYYMMDD').format('DD/MM');
            });

            var ctx = document.getElementById('users-analytics-chart').getContext('2d');
            var usersAnalytics = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: labels,
                      datasets: [{
                          label: 'Users ',
                          data: users,
                          pointBackgroundColor: 'rgba(1, 205, 62, 1)',  
                          pointBorderColor: 'rgba(1, 205, 62, 1)',                            
                          backgroundColor: [
                            'rgba(1, 205, 62, 0.2)',
                          ],
                          pointStyle: 'rect',
                          borderColor: [
                            'rgba(1, 205, 62, 1)',
                          ],
                          borderWidth: 1
                      },
                      {
                          label: 'Sessions ',
                          data: sessions,
                          pointBackgroundColor: 'rgba(220,220,220,0.5)',  
                          pointBorderColor: 'rgba(220,220,220,1)',                            
                          backgroundColor: [
                            'rgba(220,220,220,0.5)',
                          ],
                          pointStyle: 'rect',
                          borderColor: [
                            'rgba(220,220,220,1)',
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                    scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero: true,
                                  stepSize: 100,                                     
                              },
                              gridLines: {
                            borderDash: [3, 1]                            
                        }
                          }],
                          xAxes: [{
                        gridLines: {                            
                            borderDash: [3, 1]                            
                        }
                    }]
                      },
                      tooltips: {
                        cornerRadius: 0,
                        xPadding: 10,
                        yPadding: 10
                      },
                      legend: {
                        position: 'bottom',
                        labels: {
                          boxWidth: 10,
                          fontSize: 10
                        }
                      }
                  }
            });

        });


      /* --------------------------------------------------- */
      /*   USERS & SESSIONS DURING CURRENT AND PAST MONTHS
      /* --------------------------------------------------- */
      var start_month = moment(now).startOf('month').format('YYYY-MM-DD');
      var end_month = moment(now).endOf("month").format('YYYY-MM-DD');      

      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'users_sessions_monthly',
                start_month: start_month,
                end_month: end_month
            },
            beforeSend: function() {
                $("#users-current-month").removeClass('deactivated');         
            },
            complete: function() {
                $("#users-current-month").addClass('deactivated');
            },
            success: function(data) {                            
            }, 
            error: function (data) {              
              console.log(data)
            }
        }).done(function(data) {            
            processMonthlyTraffic(data);
        });



        function processMonthlyTraffic(currentMonthData) {

            var currentMonth = currentMonthData.rows.map(function(row) { return +row[1]; });
            var labels = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                        '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];

            var now = moment();
            var start_month = moment(now).subtract(1, 'month').startOf('month').format('YYYY-MM-DD');
            var end_month = moment(now).subtract(1, 'month').endOf('month').format('YYYY-MM-DD');

            $.ajax({
                    method: "POST",
                    url: "../admin/includes/googleanalytics.inc.php",
                    data: {
                        action: 'users_sessions_monthly',
                        start_month: start_month,
                        end_month: end_month
                    },
                    beforeSend: function() {
                        $("#users-last-month").removeClass('deactivated');         
                    },
                    complete: function() {
                        $("#users-last-month").addClass('deactivated');
                    },
                    success: function(data) {              
                    }, 
                    error: function (data) {              
                      console.log(data)
                    }
                }).done(function(data) {

                    var lastMonth = data.rows.map(function(row) { return +row[1]; });                    

                    var ctx = document.getElementById('monthly-analytics-chart').getContext('2d');
                    var montlyAnalytics = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Current Month ',
                                data: currentMonth,
                                pointBackgroundColor: 'rgba(1, 205, 62, 1)',  
                                pointBorderColor: 'rgba(1, 205, 62, 1)',                            
                                backgroundColor: [
                                  'rgba(1, 205, 62, 0.2)',
                                ],
                                pointStyle: 'rect',
                                borderColor: [
                                  'rgba(1, 205, 62, 1)',
                                ],
                                borderWidth: 1
                            },
                            {
                                label: 'Last Month ',
                                data: lastMonth,
                                pointBackgroundColor: 'rgba(220,220,220,0.5)',  
                                pointBorderColor: 'rgba(220,220,220,1)',                            
                                backgroundColor: [
                                  'rgba(220,220,220,0.5)',
                                ],
                                pointStyle: 'rect',
                                borderColor: [
                                  'rgba(220,220,220,1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                          scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        stepSize: 100,                                     
                                    },
                                    gridLines: {
                                  borderDash: [3, 1]                            
                              }
                                }],
                                xAxes: [{
                              gridLines: {                            
                                  borderDash: [3, 1]                            
                              }
                          }]
                            },
                            tooltips: {
                              cornerRadius: 0,
                              xPadding: 10,
                              yPadding: 10
                            },
                            legend: {
                              position: 'bottom',
                              labels: {
                                boxWidth: 10,
                                fontSize: 10
                              }
                            }
                        }
                    }); 
                });
        }


      /* --------------------------------------------------- */
      /*   TOP BROWSERS USED DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'top_browsers',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#browsers-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#browsers-biweekly").addClass('deactivated');
            },
            success: function(data) {              
            }, 
            error: function (data) {              
              console.log(data)
            }
        }).done(function(data) {

            var sessions = [];
            var labels = [];
            var colors = ['#1e1e2d','#949FB1','#D4CCC5','#E2EAE9','#F7464A'];

            sessions = data.rows.map(function(row) { return +row[1]; });
            data.rows.map(function(row) { labels.push(row[0]); });

            var pieData = {
                labels: labels,
                datasets: [{
                    data: sessions,
                    backgroundColor: colors
                }]        
            };

            var ctx = document.getElementById('browsers-analytics-chart').getContext('2d');
            var browserAnalytics = new Chart(ctx, {
                type: 'pie',
                data: pieData,
                options: {
                  legend: {
                    position: 'bottom'
                  }
                }
            });

        });



      /* --------------------------------------------------- */
      /*   TOP DEVICES USED DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'top_devices',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#devices-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#devices-biweekly").addClass('deactivated');
            },
            success: function(data) {              
            }, 
            error: function (data) {              
              console.log(data)
            }
        }).done(function(data) {

            var sessions = [];
            var labels = [];
            var colors = ['#1e1e2d','#949FB1','#D4CCC5','#E2EAE9','#F7464A'];

            sessions = data.rows.map(function(row) { return +row[1]; });
            data.rows.map(function(row) { labels.push(row[0]); });

            var pieData = {
                labels: labels,
                datasets: [{
                    data: sessions,
                    backgroundColor: colors
                }]        
            };

            var ctx = document.getElementById('devices-analytics-chart').getContext('2d');
            var deviceAnalytics = new Chart(ctx, {
                type: 'pie',
                data: pieData,
                options: {
                  legend: {
                    position: 'bottom'
                  }
                }
            });

        });



      /* --------------------------------------------------- */
      /*   TOP TRAFFIC SOURCES DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'top_traffic',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#traffic-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#traffic-biweekly").addClass('deactivated');
            },
            success: function(data) {              
            }, 
            error: function (data) {              
              console.log(data)
            }
        }).done(function(data) {

            var sessions = [];
            var labels = [];
            var colors = ['#1e1e2d','#949FB1','#D4CCC5','#E2EAE9','#F7464A', '#39CDFF','#FF6b39', '#D4CCC5', '#949FB1', '#1e1e2d'];

            sessions = data.rows.map(function(row) { return +row[1]; });
            data.rows.map(function(row) { labels.push(row[0]); });

            var pieData = {
                labels: labels,
                datasets: [{
                    data: sessions,
                    backgroundColor: colors
                }]        
            };

            var ctx = document.getElementById('traffic-analytics-chart').getContext('2d');
            var deviceAnalytics = new Chart(ctx, {
                type: 'pie',
                data: pieData,
                options: {
                  legend: {
                    position: 'right'
                  }
                }
            });

        });


      /* --------------------------------------------------- */
      /*   TOP COUNTRIES DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'top_countries',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#countries-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#countries-biweekly").addClass('deactivated');
            },
            success: function(sessions) {              
            }, 
            error: function (sessions) {              
              console.log(sessions)
            }
        }).done(function(sessions) {

            var sessionData = sessions['sessions'];
            var mapsKey = sessions['key']; 

             google.charts.load('current', {
              'packages':['geochart'],
              // Note: you will need to get a mapsApiKey for your project.
              // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
              'mapsApiKey': mapsKey
            });
      
            google.charts.setOnLoadCallback(drawRegionsMap);

            function drawRegionsMap() {     

              var options = {colors: ['#01CD3E']};
              var result = [];

              result.push(['Country', 'Sessions']);

              sessionData.rows.map(function(row) { result.push([row[0], parseInt(row[1])]); });

              var data = google.visualization.arrayToDataTable(result);

              var chart = new google.visualization.GeoChart(document.getElementById('countries-analytics-chart'));

              chart.draw(data, options);

            }

        });


        // Set some global Chart.js defaults.
        Chart.defaults.global.animationSteps = 60;
        Chart.defaults.global.animationEasing = 'easeInOutQuart';
        Chart.defaults.global.maintainAspectRatio = false;

    }



    if ( $(".content-body div").is("#google-analytics-dashboard") ) {

      var now = moment();
      var start_date = moment(now).subtract(14, 'day').format('YYYY-MM-DD');
      var end_date = moment(now).format('YYYY-MM-DD');

      /* --------------------------------------------------- */
      /*   USERS & SESSIONS DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'users_sessions_biweekly',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#users-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#users-biweekly").addClass('deactivated');
            },
            success: function(data) {              
            }, 
            error: function (data) {              
              console.log(data)
            }
        }).done(function(data) {

            var sessions = data.rows.map(function(row) { return +row[2]; });
            var users = data.rows.map(function(row) { return +row[1]; });
            var labels = data.rows.map(function(row) { return +row[0]; });

            labels = labels.map(function(label) {
              return moment(label, 'YYYYMMDD').format('DD/MM');
            });

            var ctx = document.getElementById('users-analytics-chart').getContext('2d');
            var usersAnalytics = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: labels,
                      datasets: [{
                          label: 'Users ',
                          data: users,
                          pointBackgroundColor: 'rgba(1, 205, 62, 1)',  
                          pointBorderColor: 'rgba(1, 205, 62, 1)',                            
                          backgroundColor: [
                            'rgba(1, 205, 62, 0.2)',
                          ],
                          pointStyle: 'rect',
                          borderColor: [
                            'rgba(1, 205, 62, 1)',
                          ],
                          borderWidth: 1
                      },
                      {
                          label: 'Sessions ',
                          data: sessions,
                          pointBackgroundColor: 'rgba(220,220,220,0.5)',  
                          pointBorderColor: 'rgba(220,220,220,1)',                            
                          backgroundColor: [
                            'rgba(220,220,220,0.5)',
                          ],
                          pointStyle: 'rect',
                          borderColor: [
                            'rgba(220,220,220,1)',
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                    scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero: true,
                                  stepSize: 100,                                     
                              },
                              gridLines: {
                            borderDash: [3, 1]                            
                        }
                          }],
                          xAxes: [{
                        gridLines: {                            
                            borderDash: [3, 1]                            
                        }
                    }]
                      },
                      tooltips: {
                        cornerRadius: 0,
                        xPadding: 10,
                        yPadding: 10
                      },
                      legend: {
                        position: 'bottom',
                        labels: {
                          boxWidth: 10,
                          fontSize: 10
                        }
                      }
                  }
            });

        });



      /* --------------------------------------------------- */
      /*   TOP COUNTRIES DURING PAST 2 WEEKS
      /* --------------------------------------------------- */
      $.ajax({
            method: "POST",
            url: "../admin/includes/googleanalytics.inc.php",
            data: {
                action: 'top_countries',
                start_date: start_date,
                end_date: end_date
            },
            beforeSend: function() {
                $("#countries-biweekly").removeClass('deactivated');         
            },
            complete: function() {
                $("#countries-biweekly").addClass('deactivated');
            },
            success: function(sessions) {              
            }, 
            error: function (sessions) {              
              console.log(sessions)
            }
        }).done(function(sessions) {

            var sessionData = sessions['sessions'];
            var mapsKey = sessions['key']; 
            
             google.charts.load('current', {
              'packages':['geochart'],
              // Note: you will need to get a mapsApiKey for your project.
              // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
              'mapsApiKey': mapsKey
            });
      
            google.charts.setOnLoadCallback(drawRegionsMap);

            function drawRegionsMap() {     

              var options = {colors: ['#01CD3E']};
              var result = [];

              result.push(['Country', 'Sessions']);

              sessionData.rows.map(function(row) { result.push([row[0], parseInt(row[1])]); });
              // for( var i = 0; i < countries.yf.rows.length; i++ ) {
              //  result.push([countries.yf.rows[i].c[0].v, countries.yf.rows[i].c[1].v]);
              // }

              var data = google.visualization.arrayToDataTable(result);

              var chart = new google.visualization.GeoChart(document.getElementById('countries-analytics-chart'));

              chart.draw(data, options);

            }

        });


        // Set some global Chart.js defaults.
        Chart.defaults.global.animationSteps = 60;
        Chart.defaults.global.animationEasing = 'easeInOutQuart';
        Chart.defaults.global.maintainAspectRatio = false;

    }


})();



/*===========================================================================
*
*  20 - FILE UPLOAD BUTTON (GOOGLE ACCOUNT CREDENTIALS)
*
*============================================================================*/

$(document).ready(function() {

  "use strict";

  $( '.file' ).each( function() {

    var $input   = $( this ),
      $label   = $input.next( 'label' ),
      labelVal = $label.html();

    $input.on( 'change', function( e ) {

      var fileName = '';

      if( this.files && this.files.length > 1 )
        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
      else if( e.target.value )
        fileName = e.target.value.split( '\\' ).pop();

      if( fileName )
        $label.find( 'span' ).html( fileName );
      else
        $label.html( labelVal );

    });

    // Firefox bug fix
    $input
    .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
    .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
  });
});



/*===========================================================================
*
*  21 - ENABLE TOOLTIPS
*
*============================================================================*/

$(document).ready(function(){

    "use strict";

    $('[data-toggle="tooltip"]').tooltip();

});


$('#filesTable').on('draw.dt', function () {

    "use strict";

    $('[button-toggle="tooltip"]').tooltip();

});


setTimeout(function() {
    $('.status-message').slideUp('slow');
}, 3000);



