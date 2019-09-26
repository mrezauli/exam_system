<script>

    $(function(){

        $('.datepicker').each(function(index, el) {
            
         $(el).datepicker({
             format: 'yyyy-mm-dd',
             autoclose:true
         });

        });


    });

</script>