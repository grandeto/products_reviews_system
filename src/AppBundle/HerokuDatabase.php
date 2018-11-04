<?php
namespace AppBundle;

use Composer\Script\Event;

class HerokuDatabase
{
    public static function populateEnvironment(Event $event)
    {
        $url = getenv("DATABASE_URL2");

        if ($url) {
            $url = parse_url($url);
            putenv("DATABASE_HOST={$url['host']}");
            putenv("DATABASE_USER={$url['user']}");
            putenv("DATABASE_PASSWORD={$url['pass']}");
            $db = substr($url['path'],1);
            putenv("DATABASE_NAME={$db}");
            putenv("DATABASE_PORT=5432");
            putenv("DATABASE_DRIVER=pdo_pgsql");
        }

        $io = $event->getIO();

        $io->write("DATABASE_URL=".getenv("DATABASE_URL"));
    }
}
