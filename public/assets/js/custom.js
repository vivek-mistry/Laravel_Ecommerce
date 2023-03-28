$(document).ready(function(){
    $('#home_slider, #super_offer_slider').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        dots: true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:1,
            },
            1000:{
                items:1,
            }
        }
    });
});

// Cart full Product quantity
$(document).ready(function() {

    $('.cart_full_quantity .number .minusq').click(function () {
      var $input = $(this).parent().find('input');
      var count = parseInt($input.val()) - 1;
      count = count < 1 ? 1 : count;
      $input.val(count);
      $input.change();
      return false;
    });
    $('.cart_full_quantity .number .plusq').click(function () {
      var $input = $(this).parent().find('input');
      $input.val(parseInt($input.val()) + 1);
      $input.change();
      return false;
    });
});

// Multistep
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  /*var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "ORDER REVIEW";
  } else {
    document.getElementById("nextBtn").innerHTML = "SAVE AND CONTINUE";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)*/
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("msform").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}


$(function() {
  // init the validator
  // validator files are included in the download package
  // otherwise download from http://1000hz.github.io/bootstrap-validator

  // $("#msform").validator();

  // when the form is submitted
  $("#msform").on("submit", function(e) {
    // if the validator does not prevent form submit
    if (!e.isDefaultPrevented()) {
      var url = "";

      // let's compose Bootstrap alert box HTML
      var alertBox ='<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
        messageText + "</div>";

      // If we have messageAlert and messageText
      if (messageAlert && messageText) {
        // inject the alert to .messages div in our form
        $("#msform").find(".messages").html(alertBox);
        // empty the form
        $("#msform")[0].reset();
      }
      return false;
    }
  });
});