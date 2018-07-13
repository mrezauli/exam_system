This is Online Examination System ::



Migration Sequence ::


Admin Module

    php artisan migrate --path="modules/admin/database/migrations/"


** after admin migration you have to insert 1 user company entry from the browser **

User Module

    php artisan migrate --path="modules/user/database/migrations/"

Application Module

    php artisan migrate --path="modules/application/database/migrations/"

Question Module

     php artisan migrate --path="modules/question/database/migrations/"

Exam Module

    php artisan migrate --path="modules/exam/database/migrations/"