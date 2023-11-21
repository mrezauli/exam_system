<script>
    $(document).ready(function() {





        // console.log($('.typing_question').val());

        // $('#words_count').val(words_count);

        $('body').on('keyup', '.typing_question', function(event) {

            //var words_count = $(this).val().trim().split(/\s+/).length;
            var character_count = $(this).val().trim().length;

            if ($(this).val().trim() == '') {
                //words_count = 0;
                character_count = 0;
            }

            //$(this).closest('.repeater-block').find('.words-count').val(words_count);
            $(this).closest('.repeater-block').find('.words-count').val(character_count);

            //$(this).closest('.typing-test-modal').find('.words-count').val(words_count);
            $(this).closest('.typing-test-modal').find('.words-count').val(character_count);

        });



        $('.typing_question').trigger('keyup');

    });
</script>
