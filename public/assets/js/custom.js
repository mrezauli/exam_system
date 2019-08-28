

  // Setup - add a text input to each footer cell
  
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="" />' );
    } );
 
    // DataTable


    //table = $('#example').DataTable();


    var checked_button = $(".radio:checked");

    var pagination = true;

    if ($('#example').hasClass('no_pagination')) {

      pagination = false;

    }else{

      pagination = true;

    }

    table = $('#example').DataTable({
        /* Disable initial sort */
        "aaSorting": [],

        "bPaginate":pagination,

        "fnDrawCallback": function(oSettings) {

        $(".btn.radio").prop('checked', false);

        var checked_id = $('#checked_id').val();

        $('.radio[data-id=' + checked_id + ']').prop('checked', true);

        }

    });

    $(checked_button).prop('checked', true);





    //Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        });
    });

     //$('#example tfoot').appendTo('.search-section');
     //$('#example_filter').appendTo('.search-section tfoot th:last-child');
     $('#example_filter label input').attr('placeholder', 'Full Search');

     $('#example_filter label input').appendTo('.search-section tfoot th:last-child');






function create_dropdown_column(columns){

index = $('#example thead th:contains("Status")').index() + 1;

index = index.toString();



if (index != '0') {

columns.push(index);

}


console.log(columns);

$(columns).each(function(index, el) {
    
   //el = el - 1;

   var title = $('#example thead tr th:nth-child('+ el +')').text();

   // console.log(eee);

    el = el - 1;
    //el = el + 1;

    table.column(el).every( function () {

        var column = this;

        var select = $('<select><option value="">----------Select----------</option></select>')
          .appendTo($(column.footer()).empty())
          .on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex(
              $(this).val()
            );

            column
              .search(val ? '^' + val + '$' : '', true, false)
              .draw();
          });

        column.data().unique().sort().each(function(d, j) {

          select.append('<option value="' + d + '">' + d + '</option>');
        });

    });

});
/*$('.search-section th:first-child select option:first-child').remove();*/

$('.search-section select option:empty').not('.search-section select option:first-child').each(function(index, el) {


$(el).remove();

//$(select + 'option:first-child').remove();
//console.log($(el).parent('select'));
//$('.search-section th:first-child select option:first-child').remove();

});


}


$('.search-section tr th').css('visibility', 'visible');










$(".close-icon").hide();

$("input.search-box").on('keyup input',function(){
  if ($(this).val()) {
    $(".close-icon").show();
  } else {
    $(".close-icon").hide();
  }
});



$('.close-icon').click(function(e){

e.preventDefault();
//var vvv = $('.modal tfoot.search-section tr th:first-child input').val();


$('#company-name').val('');

     // $('.modal tfoot.search-section tr th:first-child input').text('vvv');


  //$('input.search-box').val('').focus();
  $(".close-icon").hide();


   // table.column(1).search('ss').draw();
//alert('ddd');
});









