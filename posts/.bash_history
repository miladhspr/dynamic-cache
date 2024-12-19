ls
cd tests/Unit/
ls
cat PostTest.php 
cd ../..
php artisan test
exit
;s
ls
cd tests/
ls
cd Feature/
ls
cd ../Unit/
ls
cd ../../
php artisan test PostTest
php artisan test --filter PostTest
exit
