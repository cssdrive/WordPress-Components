//Меняем папку [wp-content] на свою
define('WP_CONTENT_FOLDERNAME', 'cdn'); //CSSD название измененой папки
define('WP_CONTENT_DIR', ABSPATH . WP_CONTENT_FOLDERNAME);
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_CONTENT_URL', WP_SITEURL . WP_CONTENT_FOLDERNAME);

//Меняем папку [uploads] на свой
define('UPLOADS', 'cdn/files');

//Меняем папку [plugins] на свою
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/components' );
define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/components' );

//Включаем [куки] для всех файлов
define('USER_COOKIE', 'siteuser_' . COOKIEHASH);
define('PASS_COOKIE', 'sitepass_' . COOKIEHASH);
define('AUTH_COOKIE', 'site_' . COOKIEHASH);
define('SECURE_AUTH_COOKIE', 'site_sec_' . COOKIEHASH);
define('LOGGED_IN_COOKIE', 'site_logged_in_' . COOKIEHASH);
define('TEST_COOKIE', 'site_test_cookie');

/Настройки Авто созранения
define('AUTOSAVE_INTERVAL', 1);  //время авто сохранения
define('EMPTY_TRASH_DAYS', 1);   //Время хранения корзины
define('WP_POST_REVISIONS', false); //Отключаем создание ревизий
