

//Default vex.modal theme
vex.defaultOptions.className = 'vex-theme-os';

//bPopup
var modalstyle = 'modal-container';
var modalWidth = 425;
var closeButton = '<button class="b-close b-cancel btn btn-default">Отмена</button>';
var closeButtonTop = '<button class="b-close b-top-close btn btn-primary">&times;</button>';

//show hide speed
var showHideSpeed = 500;


$(document).ready(function() {

//ajax-container
  var ajaxContainer = $('.ajax-container');
  //site message
  //------------------------
    /*
    var siteMessages = $('.message-wrapper').html();
    if($('div').is('.message'))
    {
      vex.dialog.alert(siteMessages);
    }
  */

  //ajaxPopup
  //--------------------
  var ajaxPopup = $('a.ajaxPopup');
  ajaxPopup.on('click', function(){
    ajaxContainer.load($(this).attr('href'), function(){
      $(this).addClass(modalstyle).prepend(closeButtonTop).bPopup();
    });
    return false;
  });




});//End Ready
