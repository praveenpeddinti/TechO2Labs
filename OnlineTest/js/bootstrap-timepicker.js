/* =========================================================
 * bootstrap-timepicker.js
 * https://github.com/Bloafer/bootstrap-timepicker
 * =========================================================
 * Copyright 2012 Bloafer ltd
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

(function( $ ){

  var methods = {
    init : function( options ) { 
      if($(".timepicker-popup").length==0){
        var hours           = 12;
        var minutes         = 59;
        var seperator       = ":";
        var popup           = $("<div id='timepicker-popup' style='display:none' >");
        var table           = $("<table>");
        var tableHour       = $("<td>");
        var tableMinute     = $("<td>");
	var tableAm     = $("<td>");
        var tableSeperator  = $("<td>");
        var hour            = $("<select id='timepicker-popup-hour'>");
        var minute          = $("<select>");
 	var Am         = $("<select>");
        for(h=0; h<=hours; h++){
          h = (h < 10) ? ("0" + h) : h;
          var rowHour = $("<option>");
             rowHour
            .attr("value", h)
            .text(h)
          ;
          hour.append(rowHour);
        }
        for(m=0; m<=minutes; m++){
          m = (m < 10) ? ("0" + m) : m;
          var rowMinute = $("<option>");
          rowMinute
            .attr("value", m)
            .text(m)
          ;
          minute.append(rowMinute);
        }

	for(A=0; A<=1; A++){
		if(A=="0"){
			var Amp="AM";
			}else{
			var Amp="PM";
		}
         // A = (A < 1) ? ("AM") : ("PM");
          var rowAm = $("<option>");
          rowAm
            .attr("value", Amp)
            .text(Amp)
          ;
          Am.append(rowAm);
        }
	 
        hour
          .addClass("timepicker-popup-hour")
        ;
        minute
          .addClass("timepicker-popup-minute")
        ;
 	Am
          .addClass("timepicker-popup-Am")
        ;
        tableHour
          .append(hour)
        ;
        tableSeperator
          .text(seperator)
        ;
        tableMinute
          .append(minute)
        ;
	tableAm
          .append(Am)
        ;
        table
          .append(tableHour)
          .append(tableSeperator)
          .append(tableMinute)
	  .append(tableSeperator)
          .append(tableAm)
        ;
        popup
          .addClass("timepicker-popup")
          .addClass("dropdown-menu")
          .css("display", "block")
          .append(table)
          .hide()
        ;
        $("body").append(popup);
      }
      return this.each(function(){
        var thisOffset = $(this).offset();
        var thisElement = this;
        $(this).bind("focus", function(){
          $(".timepicker-popup-hour, .timepicker-popup-minute").val("00");
          $(".timepicker-popup-Am").val("AM");
          if($(this).val()!=""){
            var inputTime = $(this).val();
            var splitTime = inputTime.split(":");
            if(splitTime.length==2){
                 var minutes = splitTime[1].split(" ");
                    $(".timepicker-popup-hour").val(splitTime[0]);
                    $(".timepicker-popup-minute").val(minutes[0]);
                    $(".timepicker-popup-Am").val(minutes[2]);
            }
          }
          var timePickerPopup = $(".timepicker-popup");

          timePickerPopup
            .css("position", "absolute")
           /* .css("left", thisOffset.left + "px")
            .css("top", thisOffset.top + $(this).outerHeight(true) + "px")*/
            .data("caller", this)
            //.show()
          ;
        });
        $(document).on('mousedown.timepicker', function (e) {
          if ($(e.target).closest('.timepicker-popup').length == 0) {
              if($(".timepicker-popup-hour").val()!=00 || $(".timepicker-popup-minute").val()!=00){
                   var caller = $(".timepicker-popup").data("caller");
                   $(caller).val($(".timepicker-popup-hour").val() +":"+$(".timepicker-popup-minute").val()+"  "+ $(".timepicker-popup-Am").val());
              }
            $(".timepicker-popup").hide();
          }
        });

      });
    }
  };
  $.fn.timepicker = function( method ) {
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.timepicker' );
    }
  };

})( jQuery );
