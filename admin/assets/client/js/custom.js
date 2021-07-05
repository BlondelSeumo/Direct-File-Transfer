/*===========================================================================
| Project Name: Upload & Share
| Author: Berkine
| Author URL: https://codecanyon.net/user/berkine/portfolio
| Version: 1.0
| File name: client/custom.js
| Date Created: 21.11.2020
| Website: envato.berkine.cloud/s3-filetransfer
============================================================================= */


/* -------------------------------------------------------------- */
/*                      TABLE OF CONTENTS
/* -------------------------------------------------------------- */
/*   01 - AWSELECT DROPDOWN FOR SETTINGS                          */
/*   02 - ENABLE TOOLTIPS                                         */
/*   03 - INITIATE FILE POND FOR UPLOADING FILES                  */
/*   04 - INITIATE FILE UPLOAD PROCESS                            */
/*   05 - INITIATE MULTIPART UPLOAD PROCESS                       */
/*   06 - RETURN TO INITIAL PAGE AND SET ALL TO DEFAULT MODE      */
/*   07 - MAIN MULTIPART UPLOAD FUNCTIONS                         */
/*   08 - SHOW UPLOAD RESULTS AFTER COMPLETING MULTIPART UPLOAD   */
/*   09 - DOWNLOAD ALL LINKS FUNCTION                             */
/*   10 - COPY TO CLIPBOARD FUNCTION                              */
/*   11 - FORMAT FILE SIZE TO READABLE FORMAT                     */
/*   12 - DISPLAY STATUS MESSAGES                                 */
/*   13 - ADD AND REMOVE NEW RECEIVER EMAIL ADDRESSES             */
/*   14 - TURN OF/OFF PRIVATE SIGNED LINK OPTION                  */
/*   16 - SWITH EMAIL/LINK CHECKBOX INFO MESSAGE                  */
/*   17 - MATERIALIZE ACTION BUTTONS EFFECTS                      */



/*===========================================================================
*
*  01 - AWSELECT DROPDOWN FOR SETTINGS
*
*============================================================================*/

$(document).ready(function(){

    "use strict";

    $('#timer').awselect({
            background: "#FFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "6px", //top and bottom padding
            horizontal_padding: "10px" // left and right padding,
    });

    $('#chunk').awselect({
            background: "#FFF", 
            active_background:"#FFF", 
            placeholder_color: "#212932", // the light blue placeholder color
            placeholder_active_color: "#0e2e40", // the dark blue placeholder color
            option_color:"#0e2e40", // the option colors
            vertical_padding: "6px", //top and bottom padding
            horizontal_padding: "10px" // left and right padding,
    });

});
  


/*===========================================================================
*
*  02 - ENABLE TOOLTIPS
*
*============================================================================*/

$(document).ready(function(){

  "use strict";

  $('[data-toggle="tooltip"]').tooltip();

});



/*===========================================================================
*
*  03 - INITIATE FILEPOND FOR UPLOADING FILES
*
*============================================================================*/

var maxFiles;
var maxFileSize;
var fileIDs = {};

FilePond.registerPlugin( 

  // validates the size of the file...
 FilePondPluginFileValidateSize,
 
 // validates the file type...
 FilePondPluginFileValidateType

);


var pond = FilePond.create(document.querySelector('.filepond'));


$.post('MultipartUpload.php', {

      input: 'set_upload_settings',

  }).done(function(data) {

      maxFileSize = data['maxSize'] + 'MB';
      maxFiles = parseInt(data['maxQuantity']);
      fileType = eval(data['fileType']);
    
      FilePond.setOptions({

          allowMultiple: true,
          maxFiles: maxFiles,
          maxFileSize: maxFileSize,
          labelIdle: "<i class='fab fa-staylinked'></i><br>Drag & Drop your files or <span class='filepond--label-action'>Browse</span><br><span id='restrictions'>[Max File Size: " + maxFileSize + ", Max Number of Files: " + maxFiles + "]</span>",
          required: true,
          instantUpload:false,
          acceptedFileTypes: fileType,
          labelFileProcessingError: (error) => {
              console.log(error);       
          },
          onerror: function(error, file, status) {
              if(file.id in fileIDs) {
                delete fileIDs[file.id]; 
              }
          },
          onaddfile: function(error, file) {
              if (error) {
                console.log(error)
              } else {
                fileIDs[file.id] = file.filename;
              }
              
          },
          onremovefile: function(error, file) {
              if(file.id in fileIDs) delete fileIDs[file.id];
          } 

      });

});

/* SHOW FILEPOND ERROR MESSAGES */
pond.on('warning', (error, file) => {
    $('#filepond-warning').slideDown()
    .html("<span>Maximum allowed number of files is " + maxFiles + "</span>")
    .delay(3000)
    .slideUp();;
});



/*===========================================================================
*
*  04 - INITIATE FILE UPLOAD PROCESS
*
*============================================================================*/

var fileList = [];
var fileDownloadLinks = {};
var emailSendStatus;

function uploadFiles(e) {

    "use strict";

    e.preventDefault();

    /* INITIATE PROCESS IF EMAIL IS SELECTED */
    if (document.getElementById('enable-email').checked) {

        var errors = [];
        var receiverEmail = document.getElementById('send-to');
        var senderEmail = document.getElementById('send-from');
        var receiverError = document.getElementById('receiver-error');
        var senderError = document.getElementById('sender-error');


        /* CHECK IF RECEIVED EMAILS ADDRESSES INCLUDED */
        if (receiverEmail.value === '' || receiverEmail.value == null) {
            receiverError.innerHTML = 'Email Address is Required.';
            errors.push('error');        
        } else {
            receiverError.innerHTML = '';
            errors.pop(); 
        }


        /* CHECK IF SENDER EMAIL ADDRESS IS INCLUDED */
        if (senderEmail.value === '' || senderEmail.value == null) {
            senderError.innerText = 'Email Address is Required.';
            errors.push('error');        
        } else { 
            senderError.innerText = '';
            errors.pop();
        }


        /* IF EMAILS INCLUDED PREPARE FILE UPLOAD LIST */
        if (errors.length == 0) {

            for (var key in fileIDs) {
                fileList.push(pond.getFile(key));
            }

            var i = 0;

            // Process each file individually
            fileList.forEach(function(file) {                
                i++;                
                processFile(file, i, fileList.length);
            });
        }
   
      
      /* INITIATE PROCESS IF LINK IS SELECTED */
    } else if (document.getElementById('enable-link').checked) {
        
        /* PREPARE FILE UPLOAD LIST */
        for (var key in fileIDs) {
            fileList.push(pond.getFile(key));
        }

        var i = 0;

        // Process each file individually
        fileList.forEach(function(file) {            
            i++;            
            processFile(file, i, fileList.length);
        });
    }

}


  
/*===========================================================================
*
*  05 - INITIATE MULTIPART UPLOAD PROCESS
*
*============================================================================*/

var counter = 0;
var upload = [];

function processFile(file, i, totalFiles) {

        "use strict";
        
        var uploader;
        var fileName =  file.filename;
        var fileSize = (file.fileSize/Math.pow(1024,2)).toFixed(2) +"MB";

        
        $("<div class='file-info'/>").html("<div class='name'><span>File Name</span>: " + fileName + "</div>").appendTo("#upload-status");
        $("<div class='file-info'/>").html("<div class='size'><span>File Size</span>: " + fileSize+ "</div>").appendTo("#upload-status");
        $("<div class='progress' id='progress" +i+"'/>").html("<div class='progress-bar bar" + i +" progress-bar-striped'></div><div class='progress-statistics progress-number" + i + "'></div>").appendTo("#upload-status");
        $("<div class='status'/>").html("<div class='status-result" + i +"'></div>").appendTo("#upload-status");


        /* Initiate Multipart Upload and Pass Selected File */
        upload[i] = new multipartUpload(file.file);
        uploader = upload[i];
        uploader.start();

        /* Display upload status bars */
        $("#upload-box").slideDown();
        $("#main-input-container").slideUp();
        

        /* Parts URLs created start uploading*/
        uploader.onPrepareCompleted = function() {
          $('.status-result' +i).html('<span class="success">Uploading...</span>');
        }
        

        /* Show Progress Bar Upload Status */
        uploader.onProgressChanged = function(uploadedSize, totalSize, speed) {

            "use strict";

            var progress = parseInt(uploadedSize / totalSize * 100, 10);
            
            $('#progress'+i+' .bar' +i).css('width', progress + '%');

            $("#progress"+i+" .progress-number" +i).html(getReadableFileSizeString(uploadedSize)+" / "+getReadableFileSizeString(totalSize)
                + " <span style='font-size:smaller; color:#0e2e40;'> ["
                +" <i class=\"fas fa-at\"></i> "
                +getReadableFileSizeString(speed)+"ps"
                +"]</span>").css({'margin-left' : -$('#progress'+i+' .progress-number' +i).width()/2});

        }


        /* Miltipart upload completed */
        uploader.onUploadCompleted = function() {

            "use strict";
            counter++;

            $('.status-result' +i).html('<span class="success">Successfully Uploaded</span>');

            /* Generate donwload links */
            if (document.getElementById('enable-private-link').checked) {
                uploader.getSignedPrivateLink();
            } else {
                uploader.getPublicLink();
            }

        
            /* If all files uploaded proceed with final steps */
            if (totalFiles == counter) {   

                uploader.recordSharesTableData();    
                uploader.recordDashboardTableData();           

                /* Send email with all download links */
                if (document.getElementById('enable-email').checked) {
                    setTimeout(function() { 
                      uploader.sendEmails();
                    }, 1000);
                }
               
                /* Display all download links */
                if (document.getElementById('enable-link').checked) {
                    setTimeout(function() { 
                      showResultsPage();
                      $("#upload-box").slideUp();
                      $('#upload-results').slideDown();
                    }, 500);
                }
                  
            }
            
        }


        /* Cancel upload in case of server side error */
        uploader.onServerError = function(command, jqXHR, textStatus, errorThrown) {

            "use strict";
            
            uploader.cancel();
            $('.status-result' +i).html('<span class="error">Upload Failed</span>');        

        }


        /* Cancel upload in case of S3 error */
        uploader.onS3UploadError = function(xhr) {

            "use strict";
            
            uploader.cancel();
            $('.status-result' +i).html('<span class="error">S3 Upload Error</span>');
            $('#progress .progress-bar').css('width',"0px");
            $('#progress .progress-number').text("");        
        }
}



/*===========================================================================
*
*  06 - RETURN TO INITIAL PAGE AND SET ALL TO DEFAULT MODE
*
*============================================================================*/

function sendNewFile(){

      "use strict";
        
      keys = [];
      fileList = [];
      counter = 0;
      fileDownloadLinks = {};

      /* Clean file pond */
      for (var key in fileIDs) {
          pond.removeFile(key);
      }

      /* Clean file pond */
      if (pond.getFiles().length != 0) {
          for (var j = 0; j <= pond.getFiles().length - 1; j++) {
               pond.removeFiles(pond.getFiles()[j].id);
          }
      }

      /* Set default sending method */
      if (document.getElementById('enable-link').checked) {
          var shareType = document.getElementById("enable-email");
          shareType.checked = true;
          sendOptions();
      }
      

      $("#main-input-container").slideDown();
      $("#upload-results").slideUp();      
      $('#upload-status').html('');
      $('#files-data').html('');
      $('.file-data').html('');
      $('.extra-emails').remove();

      document.getElementById('send-to').value = '';
      document.getElementById('send-from').value = '';
      document.getElementById('message').value = '';


}



/*===========================================================================
*
*  07 - MAIN MULTIPART UPLOAD FUNCTIONS
*
*============================================================================*/

var keys = [];

/*----------------------------------------------*/
/*   Initiate Create Multipart Upload
/*----------------------------------------------*/
function multipartUpload(file) {

    "use strict";

    var sharetypeValue = (document.getElementById('enable-email').checked) ? 'Email' : 'Link';
    var privatelinkValue = (document.getElementById('private-link-label').innerHTML == 'Disabled') ? 'No' : 'Yes';
    var privatelinkDuration = document.getElementById('timer').value;
    
    var fileNamesList = [];
    var fileList;
    var totalEmails;
    var totalLinks;
    var emailToList = [];
    var emailTo;
    var emailToSend;
    var emailFrom;
    var emailMessage;


    /* Get email lists */
    if (sharetypeValue == 'Email') {      
        emailTo = document.getElementsByName('send-to[]');
        emailFrom = document.getElementById('send-from').value;
        emailMessage = document.getElementById('message').value;
        
        for (var i = 0; i < emailTo.length; i++) { 
            emailToList.push(emailTo[i].value); 
        }
       
        emailTo = emailToList.join('\n');
        emailToSend = emailToList.join(',');
        totalEmails = emailToList.length;
        totalLinks = 0;

    } else {
        emailTo = ' ';
        emailFrom = ' ';
        emailMessage = ' ';
        totalEmails = 0;
        totalLinks = Object.keys(fileDownloadLinks).length;
    }

    /* Get the list of file names*/
    for (var key in fileIDs) {
        fileNamesList.push(pond.getFile(key).filename);            
    }

    /* Add new line character for each filename */
    if (fileNamesList.length > 1) {
        fileList = fileNamesList.join('\n');
    } else {
        fileList = fileNamesList.join();
    }


    var chunkSize = parseInt(document.getElementById('chunk').value);
    this.PART_SIZE = chunkSize * 1024 * 1024; // Minimum part size defined by aws s3 is 5 MB, maximum 5 GB
    this.SERVER_LOC = 'MultipartUpload.php'; // Location of the server
    this.completed = false;
    this.file = file;
    this.fileInfo = {
        name: this.file.name,
        type: this.file.type,
        size: this.file.size
    };

    this.sendBackData = null;       // XHR server side return data
    this.uploadXHR = [];
    this.totalParts = null;         // Total number of file parts
    this.blobs = [];                // Array of file blobs split by chunk size

    this.fileTableData = {
        name: this.file.name,
        type: this.file.type,
        size: this.file.size,
        sharetype: sharetypeValue
    };

    this.sharesTableData = {
        sharetype: sharetypeValue,
        filequantity: Object.keys(fileIDs).length,
        filenames: fileList,
        senderemail: emailFrom,
        receiveremail: emailTo,
        message: emailMessage,
        privatelink: privatelinkValue,
        expirationtime: privatelinkDuration
    }

    this.emailData = {
        emailFrom: emailFrom,
        emailTo: emailToSend,
        emailMessage: emailMessage,        
        filequantity: Object.keys(fileIDs).length
    }
    
    // Upload Progress monitoring
    this.byterate = []
    this.lastUploadedSize = []
    this.lastUploadedTime = []
    this.loaded = [];
    this.total = [];

}


/*----------------------------------------------*/
/*   Initiate Create Multipart Upload
/*----------------------------------------------*/
multipartUpload.prototype.start = function() {

    "use strict";

    this.createMultipartUpload();

};


/*----------------------------------------------*/
/*   Create S3 Multipart Upload 
/*----------------------------------------------*/
multipartUpload.prototype.createMultipartUpload = function() {

    "use strict";

    var self = this;


      $.post(self.SERVER_LOC, {

          input: 'create',
          fileInfo: self.fileInfo,
          userData: self.userData

      }).done(function(data) {

          self.sendBackData = data;
          keys.push(data['key']);
          self.uploadParts();
        
      }).fail(function(jqXHR, textStatus, errorThrown) {

          self.onServerError('create', jqXHR, textStatus, errorThrown);

      });


};


/*------------------------------------------------*/
/*   Call S3 UploadParts to Generate Parts URLs
/*------------------------------------------------*/
multipartUpload.prototype.uploadParts = function() {

    "use strict";

    var blobs = this.blobs = [], promises = [];
    var start = 0;
    var parts =0;
    var end, blob;
    var partNum = 0;
    var filePart;

    try {

        while(start < this.file.size) {

            end = Math.min(start + this.PART_SIZE, this.file.size);
            filePart = this.file.slice(start, end);

            /* Prevent push blob with 0Kb */
            if (filePart.size > 0) {

                blobs.push(filePart);

            }

            start = this.PART_SIZE * ++partNum;
        }
    

        for (var i = 0; i < blobs.length; i++) {

            blob = blobs[i];

            promises.push(this.uploadXHR[i] = $.post(this.SERVER_LOC, {

                input: 'part',
                sendBackData: this.sendBackData,
                partNumber: i+1,
                contentLength: blob.size  

            }));


        }


        this.totalParts = promises.length;

        /* After received URLs for all parts, initiate upload all */
        $.when.apply(null, promises)
        .then(this.sendAll.bind(this), this.onServerError)
        .done(this.onPrepareCompleted);

    } catch(ex) {

          $('#error-message').html(ex);
          console.log("Try to increase Chunk sizes: " + ex);

    }

}


/*----------------------------------------------*/
/*   Sends all the created upload parts in a loop
/*----------------------------------------------*/
multipartUpload.prototype.sendAll = function() {

    "use strict";

    var blobs = this.blobs;
    var length = blobs.length;

    if (length==1) {

        this.sendToS3(arguments[0], blobs[0], 0);

    } else {
      
        for (var i = 0; i < length; i++) {
        
            this.sendToS3(arguments[i][0], blobs[i], i);

        } 
        
    }
};


/*--------------------------------------------------------------
 * Used to send each uploadPart
 * @param  array data  parameters of the part
 * @param  blob blob  data bytes
 * @param  integer index part index (base zero)
 *--------------------------------------------------------------*/
multipartUpload.prototype.sendToS3 = function(data, blob, index) {

    "use strict";

    var self = this;
    var url = data['url'];
    var size = blob.size;
    var request = self.uploadXHR[index] = new XMLHttpRequest();

    request.onreadystatechange = function() {

        if (request.readyState === 4) { // 4 is DONE

            if (request.status !== 200) {

                self.updateProgress();
                self.onS3UploadError(request);                 
                return;                
            }

            self.updateProgress();
           
        }
        
    };

    /* Show XHR onprogress status */
    request.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            self.total[index] = size;
            self.loaded[index] = e.loaded;
            if (self.lastUploadedTime[index])
            {
                var time_diff=(new Date().getTime() - self.lastUploadedTime[index])/1000;
                if (time_diff > 0.005) // 5 miliseconds has passed
                {
                    var byterate=(self.loaded[index] - self.lastUploadedSize[index])/time_diff;
                    self.byterate[index] = byterate; 
                    self.lastUploadedTime[index]=new Date().getTime();
                    self.lastUploadedSize[index]=self.loaded[index];
                }
            }
            else 
            {
                self.byterate[index] = 0; 
                self.lastUploadedTime[index]=new Date().getTime();
                self.lastUploadedSize[index]=self.loaded[index];
            }
            // Only send update to user once, regardless of how many
            // parallel XHRs we have (unless the first one is over).
            if (index==0 || self.total[0]==self.loaded[0])
                self.updateProgress();
        }
    };

    request.open('PUT', url, true);
    request.send(blob);

};


/*----------------------------------------------------------
 * Track progress, propagate event, and check for completion
 *----------------------------------------------------------*/
multipartUpload.prototype.updateProgress = function() {

    "use strict";

    var total=0;
    var loaded=0;
    var byterate=0.0;
    var complete=1;

    for (var i=0; i<this.total.length; ++i) {

        loaded += +this.loaded[i] || 0;
        total += this.total[i];

        if (this.loaded[i]!=this.total[i])
        {
            // Only count byterate for active transfers
            byterate += +this.byterate[i] || 0;
            complete=0;

        }
    }

    if (complete) {

      this.completeMultipartUpload();

    }

    total=this.fileInfo.size;
    this.onProgressChanged(loaded, total, byterate);
};


/*------------------------------------------------------------
 * Complete multipart upload
 *------------------------------------------------------------*/
multipartUpload.prototype.completeMultipartUpload = function() {

    "use strict";

    var self = this;
    var blobs = self.blobs;
    var length = blobs.length;

  self.counter += 1;

    if (this.completed) return;

    this.completed=true;

    setTimeout(function() { 

        $.post(self.SERVER_LOC, {

                input: 'complete',
                sendBackData: self.sendBackData,
                fileTableData: self.fileTableData

            }).done(function(data) {

                  self.onUploadCompleted(data);                

            }).fail(function(jqXHR, textStatus, errorThrown) {

                self.onServerError('complete', jqXHR, textStatus, errorThrown);

            });

      }, 1000);

};


/*------------------------------------------------------------
 * Write user data to Shared Table
 *------------------------------------------------------------*/
multipartUpload.prototype.recordSharesTableData = function() { 

  "use strict";

  $.post(this.SERVER_LOC, {

        input: 'database',
        sharesTableData: this.sharesTableData,

    }).done(function(data) {});


};


/*------------------------------------------------------------
 * Write user data to Dashboard Table
 *------------------------------------------------------------*/
multipartUpload.prototype.recordDashboardTableData = function() { 

  "use strict";

  var totalEmails;
  var totalLinks;
  var emailToList = [];
  var emailTo;

  var sharetypeValue = (document.getElementById('enable-email').checked) ? 'Email' : 'Link';

  /* Get email lists */
  if (sharetypeValue == 'Email') {      
      emailTo = document.getElementsByName('send-to[]');
      
      for (var i = 0; i < emailTo.length; i++) { 
          emailToList.push(emailTo[i].value); 
      }
     
      totalEmails = emailToList.length;
      totalLinks = 0;

  } else {
      totalEmails = 0;
      totalLinks = Object.keys(fileIDs).length;
  }

  this.dashboardData = {
        totalUploads: Object.keys(fileIDs).length,
        emailsSent: totalEmails,
        linksCreated: totalLinks,
  }

  $.post(this.SERVER_LOC, {

        input: 'dashboard',
        dashboardData: this.dashboardData,

    }).done(function(data) {});


};


/*------------------------------------------------------------
 * Send links with emails
 *------------------------------------------------------------*/
multipartUpload.prototype.sendEmails = function() { 

  "use strict";
  
    var all_links = " ";
    var links_holder = Object.entries(fileDownloadLinks);

    for(var [key, value] of links_holder) {
        all_links += key + "," + value + "; ";
    }

    $.post(this.SERVER_LOC, {

          input: 'email',
          emailData: this.emailData,
          links: all_links

      }).done(function(data) {
          emailSendStatus = data;

           setTimeout(function() { 
            showResultsPage();
            $("#upload-box").slideUp();
            $('#upload-results').slideDown();
          }, 1000);

      });

};


/*------------------------------------------------------------
 *  Display Public URL
 *------------------------------------------------------------*/
multipartUpload.prototype.getPublicLink = function() {

    "use strict";

     $.post(this.SERVER_LOC, {

        input: 'public',
        sendBackData: this.sendBackData
    
    }).done(function(data) {

        fileDownloadLinks[data['key']] = data['public-link'];          
                  
    });
  
};


/*------------------------------------------------------------
 *  Display Private Signed URL
 *------------------------------------------------------------*/
multipartUpload.prototype.getSignedPrivateLink = function() {

    "use strict";

     if (document.getElementById('enable-private-link').checked) {
        var duration = parseInt(document.getElementById('timer').value);
      }

     $.post(this.SERVER_LOC, {

        input: 'private',
        sendBackData: this.sendBackData,
        timer: duration
    
    }).done(function(data) {

        fileDownloadLinks[data['key']] = data['private-link'];               
                  
    });
  
};


/*------------------------------------------------------------
 *  Abort Multipart Upload
 *------------------------------------------------------------*/
multipartUpload.prototype.cancel = function() {

  "use strict";

    var self = this;

    $('#cancel').slideDown().css('display',"none");

    for (var i=0; i<this.uploadXHR.length; ++i) {

        this.uploadXHR[i].abort();

    }

    $.post(self.SERVER_LOC, {

        input: 'abort',
        sendBackData: self.sendBackData

    }).done(function(data) {

    });
};



/*===========================================================================
*
*  08 - SHOW UPLOAD RESULTS AFTER COMPLETING MULTIPART UPLOAD PROCESS
*
*============================================================================*/

function showResultsPage() {

    "use strict";

    if (document.getElementById('enable-email').checked) {

        var emailList = [];
        var emails = document.getElementsByName('send-to[]'); 
  
        for (var i = 0; i < emails.length; i++) { 
            emailList.push(emails[i].value); 
        }

        if (emailSendStatus) {
          $('#final-email-status').html('Successfully Sent');
          var message = "We have sent download links to following emails addresses: " + emailList.join(', ');
          
        } else {
          $('#final-email-status').html('Email Sending Failed');
          var message = 'There were some errors with email sending, check your configurations or email addresses.';
        }

        
        $('#final-message span').html(message);
        $("<div class='file-data' />").html("<div class='file-total'><span>Total Uploaded Files</span>: " + Object.keys(fileIDs).length + "</div>").appendTo("#files-data");

        for (var key in fileIDs) {
            $("<div class='file-data' />").html("<div class='file-name'><span>File Name</span>: " + pond.getFile(key).filename + "</div>").appendTo("#files-data");
            $("<div class='file-data' />").html("<div class='file-size'><span>File Size</span>: " + getReadableFileSizeString(pond.getFile(key).fileSize) + "</div>").appendTo("#files-data");
        }
        

        if (document.getElementById('enable-private-link').checked) {

            var duration = parseInt(document.getElementById('timer').value);
            var validUntil = new Date();

            validUntil.setHours(validUntil.getHours() + duration);
            $("<div class='file-data' />").html("<div class='link-duration'><span>Download links valid until</span>: " + validUntil + "</div>").appendTo("#files-data");
        }


    } else if (document.getElementById('enable-link').checked) {

        $('#upload-results-title h5').html('Successfully Uploaded')
        var message = "Here are your download links for the uploaded files.";

        $('#final-message span').html(message);

        $("<div class='file-data' />").html("<div class='file-total'><span>Total Uploaded Files</span>: " + Object.keys(fileIDs).length + "</div>").appendTo("#files-data");

        for (var key in fileDownloadLinks) {
            
            $("<div class='file-data' />").html("<div class='file-name'><span>File Name</span>: " + key + "</div>").appendTo("#files-data");

            var inputLink = '<div class="input-group download-links"> \
                                <input type="text" class="form-control link" value="' + fileDownloadLinks[key] + '"> \
                                <div class="input-group-append"> \
                                    <button class="btn btn-email-option copy-link" type="button" data-toggle="tooltip" data-placement="top" title="Copy Link"><i class="fas fa-copy"></i></button> \
                                    <button class="btn btn-email-option download-link" type="button" data-toggle="tooltip" data-placement="top" title="Download All Links" onclick="downloadLinks()"><i class="fas fa-save"></i></button> \
                                </div> \
                            </div>';

            $("<div class='file-data' />").html(inputLink).appendTo("#files-data");

        }
        

        if (document.getElementById('enable-private-link').checked) {

            var duration = parseInt(document.getElementById('timer').value);
            var validUntil = new Date();
            validUntil.setHours(validUntil.getHours() + duration);

            $("<div class='file-data' />").html("<div class='link-duration'><span>Download links valid until</span>: " + validUntil + "</div>").appendTo("#files-data");
        }

        $('[data-toggle="tooltip"]').tooltip();
    }
     
}



/*===========================================================================
*
*  09 - DOWNLOAD ALL LINKS FUNCTION
*
*============================================================================*/

function downloadLinks() {

    "use strict";

    var csv = 'File Name, Download Link\n';

    for (var key in fileDownloadLinks) {
        csv += key + ',' + fileDownloadLinks[key];
        csv += "\n";
    }
 
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'download-links.csv';
    hiddenElement.click();
}



/*===========================================================================
*
*  10 - COPY TO CLIPBOARD FUNCTION
*
*============================================================================*/

$(document).on('click', '.copy-link', function(event) {

    "use strict";

    var link = '';

    link =  $(this).closest('.download-links').find('.link').val();

   copyToClipboard(link);

   $(this).tooltip('hide')
    .attr('data-original-title', 'Copied')
    .tooltip('show');

});


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
*  11 - FORMAT FILE SIZE TO READABLE FORMAT
*
*============================================================================*/

function getReadableFileSizeString(fileSizeInBytes) {

    "use strict";

    var i = -1;
    var byteUnits = [' KB', ' MB', ' GB', ' TB'];

    do {

        fileSizeInBytes = fileSizeInBytes / 1024;
        i++;

    } while (fileSizeInBytes > 1024);

    return Math.max(fileSizeInBytes, 0.1).toFixed(2) + byteUnits[i];
}



/*===========================================================================
*
*  12 - DISPLAY STATUS MESSAGES
*
*============================================================================*/

function showStatusMessage(message,status){
  
  "use strict";

  if (status == "success") {
      
      $("#status-message").addClass("success-message").removeClass("error-message");
    
  } else if (status == "error") {
      
      $("#status-message").removeClass("success-message").addClass("error-message");
  }

  $("#status-message")
    .slideDown()
    .html(message)
    .delay(5000)
    .slideUp();

}



/*===========================================================================
*
*  13 - ADD AND REMOVE NEW RECEIVER EMAIL ADDRESSES
*
*============================================================================*/

/*----------------------------------------------*/
/*   ADD EMAIL ADDRESS
/*----------------------------------------------*/
$(document).on('click', '.add-email', function(event) {

    "use strict";

    var emailField = '<div class="input-group email-group extra-emails"> \
                        <input type="email" class="form-control" name="send-to[]" placeholder="Receiver\'s Email Address"> \
                        <div class="input-group-append"> \
                          <button class="btn btn-email-option remove-email" type="button" data-toggle="tooltip" data-placement="top" title="Remove Email Address"><i class="fas fa-minus"></i></button> \
                        </div> \
                      </div>';

    $('#email-container').append(emailField);

});


/*----------------------------------------------*/
/*   REMOVE EMAIL ADDRESS
/*----------------------------------------------*/
$(document).on('click', '.remove-email', function(event) {

    "use strict";

    $(this).closest(".email-group").remove();

});



/*===========================================================================
*
*  14 - TURN OF/OFF PRIVATE SIGNED LINK OPTION
*
*============================================================================*/

$(document).on('click', '#enable-private-link', function(event) {

    "use strict";

    var label = document.getElementById("private-link-label");

    if (label.innerHTML === "Disabled") {
        label.innerHTML = "Enabled";
    } else {
        label.innerHTML = "Disabled";
    }

});



/*===========================================================================
*
*  16 - SWITH EMAIL/LINK CHECKBOX INFO MESSAGE
*
*============================================================================*/

$(document).ready(function(){

    "use strict";

    var link = document.getElementById("enable-link");
    var email_box = document.getElementById("email-box");
    email_box.style.display = link.checked ? "none" : "block"; 

});

function sendOptions() {

    "use strict";

    var link = document.getElementById("enable-link");
    var email_box = document.getElementById("email-box");
    email_box.style.display = link.checked ? "none" : "block";    

}



/*===========================================================================
*
*  17 - MATERIALIZE ACTION BUTTONS EFFECTS
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