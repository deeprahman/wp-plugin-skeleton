<?php

namespace plugin_name;


class WP_Autoloader
{

    /**
     * Plugin Root Namespace
     * @var string
     */
    const ROOT_NS = 'roi';

    /**
     * Removes the portion of the class name before the second occurrence of the backslash.
     *
     * @param string $className The fully qualified class name.
     * @return string The modified class name with the prefix removed.
     */
    private static function removeBeforeSecondSlash($className)
    {
        // $secondSlashPosition = strpos($className, '\\', strpos($className, '\\') + 1);
        $firstSlash = strpos($className, '\\');
        if ($firstSlash !== false) {
            $className = substr($className, $firstSlash + 1);
        }
        return $className;
    }

    /**
     * Splits a string into two parts at the last occurrence of the forward slash.
     *
     * @param string $string The string to be split.
     * @return array An array with 'beforeLastSlash' and 'afterLastSlash' keys containing the respective parts of the string.
     */
    private static function splitStringByLastSlash($string)
    {
        $string = self::convertClassToPath($string);
        $lastSlashPosition = strrpos($string, '/');
        if ($lastSlashPosition !== false) {
            $beforeLastSlash = substr($string, 0, $lastSlashPosition);
            $afterLastSlash = substr($string, $lastSlashPosition + 1);
        } else {
            $beforeLastSlash = '';
            $afterLastSlash = $string;
        }

        return array(
            'beforeLastSlash' => $beforeLastSlash,
            'afterLastSlash' => $afterLastSlash
        );
    }

    /**
     * Converts a class name to a file path by replacing backslashes with the appropriate directory separator.
     *
     * @param string $className The class name to be converted.
     * @return string The converted file path.
     */
    private static function convertClassToPath($className)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        return $path;
    }

    /**
     * Creates a file name for a given class name.
     *
     * @param string $classname The class name for which to create the file name.
     * @return string The created file name.
     */
    private static function createFileName($classname)
    {
        $lowercaseClassName = strtolower($classname);
        $fileName = str_replace('_', '-', $lowercaseClassName);
        $prefixedFileName = 'class-' . $fileName;
        return $prefixedFileName;
    }

    /**
     * Loads a class file based on the given fully qualified class name.
     *
     * @param string $fq_classname The fully qualified class name.
     * @return void
     */
    public static function loadClass($fq_classname)
    {
        $pat = "/^" .self::ROOT_NS . "\[a-z\\]*$/";
        if( preg_match( $pat, $fq_classname) ){
            return;
        }
        
        $mod_class_name = self::removeBeforeSecondSlash($fq_classname);
        $class_info = self::splitStringByLastSlash($mod_class_name);
        $file_path = $class_info['beforeLastSlash'] . DIRECTORY_SEPARATOR . self::createFileName($class_info['afterLastSlash']);
        $file_path = self::convertClassToPath($file_path);
        $full_path = plugin_dir_path(__FILE__) . $file_path . '.php';
        if(file_exists($full_path)){
            include_once $full_path;
        }
        

    }
}



spl_autoload_register([WP_Autoloader::class, 'loadClass']);
