<?php

class Helper
{
    private static function getConfigs($nameFileConfig = 'default')
    {
        $fileConfig = CONFIG_PATH . "$nameFileConfig.php";
        if (!file_exists($fileConfig)) {
            throw new Exception("Config $nameFileConfig not exists!");
        }
        return require $fileConfig;
    }

    public static function getConfig($name = 'default', $default = null)
    {
        $listName = explode('.', $name);
        $configs = self::getConfigs($listName[0]);

        if (count($listName) === 1) {
            return $configs;
        }

        $listName = array_slice($listName, 1);

        foreach ($listName as $n) {
            if (!isset($configs[$n])) return $default;
            $configs = $configs[$n];
        }

        return $configs;
    }

    public static function dd($data, $isVarDump = false)
    {
        echo '<pre>';
        if ($isVarDump) {
            var_dump($data);
        } else {
            print_r($data);
        }
        exit(1);
    }

    public static function ddJson($data)
    {
        echo json_encode($data);
        exit(1);
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
