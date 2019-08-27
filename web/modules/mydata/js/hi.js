jQuery(document).ready(function() {
    jQuery('#edit-dob').on('blur', function() {


 var date1 = jQuery(this).val();
 console.log(date1);
  //   var date2 = new Date();
  // var dd = date2.getDate();
  //
  // var mm = date2.getMonth()+1;
  // var yyyy = date2.getFullYear();
  // date2 = mm+'/'+dd+'/'+yyyy;
  //
  // alert(date2);


var date11 = new Date(date1);
 // const date1 = new Date('7/13/2010');
 var date2 = new Date('12/15/2019');
 jQuery("input[name=candidate_age]").val(diff_years(date11,date2));
    });

    $('#edit-field-borrow-date-0-value-date').on('blur',function(){
      alert('ok');
    })

  });
  function diff_years(dt2, dt1)
   {

    var diff =(dt2.getTime() - dt1.getTime()) / 1000;
     diff /= (60 * 60 * 24);
    return Math.abs(Math.round(diff/365.25));

   }
