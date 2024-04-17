<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', '508-22_70445' );

/** Имя пользователя базы данных */
define( 'DB_USER', '508-22_70445' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '91a4ac70cbf66edd7b6c' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jZHNdavOhKm9v}mvkwi0MfNm=D6h//dVAqK~*d*,fV/oKd*RalOj&_x-4Gs+TF)v' );
define( 'SECURE_AUTH_KEY',  'QKSjiS@P;(,}L},iM|b:mU^eQokgyu/E<1w%62<w36vj|QRrz5nsFYtCKm+A:%Km' );
define( 'LOGGED_IN_KEY',    '_]Ix54);hEKGDddL?8]d^aUFd8f>%oZBdWSz{^Ae#l,$su$p&s<pJ/Ov<bf7,&]`' );
define( 'NONCE_KEY',        'x&{jW[ =]K%kMP+)Vr.kU(^hb8E8Q5?cYw]7b@g%RVlwiPib.KM3Cc?dlvh%J5XM' );
define( 'AUTH_SALT',        '{t6(K~/a?N 2}qvY)S!Y<y=!B<!nJ00P&fq1YamU?.P{}0fy<ZsNgCDP>Bz{n;S-' );
define( 'SECURE_AUTH_SALT', 'K<R+6P`:fXc2,8_Tq.LjN%*-3Je5!inpTvs.9`bwXlK!+C*jD0gQ>Wp7h!!{%S>y' );
define( 'LOGGED_IN_SALT',   '0:l]E;nRUZD9KBO5>KxcEpjX*E@_q%!t,!Ij%$37g<Q]p5W=/-j*H$E/g{}*jxPC' );
define( 'NONCE_SALT',       'EL|1u01?=$/u/K($tPHei]H/3hO^e:JhP5-v4f}5#&W_eY{Z+y2YOt!@t?}bWHHh' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'B7pvB_';


/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';