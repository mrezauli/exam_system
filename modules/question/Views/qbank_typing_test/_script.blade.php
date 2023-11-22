<script>
    $(document).ready(function() {





        // console.log($('.typing_question').val());

        // $('#words_count').val(words_count);

        $('body').on('keyup', '.typing_question', function(event) {

            var words_count = Math.floor($(this).val().trim().length / 5);

            if ($(this).val().trim() == '') {
                words_count = 0;
            }

            $(this).closest('.repeater-block').find('.words-count').val(words_count);

            $(this).closest('.typing-test-modal').find('.words-count').val(words_count);

        });



        $('.typing_question').trigger('keyup');

    });
</script>
