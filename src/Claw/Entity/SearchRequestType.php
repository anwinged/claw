<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 11:14.
 */

namespace Claw\Entity;

class SearchRequestType
{
    const TEXT = 'text';

    const IMAGE = 'image';

    const LINK = 'link';

    private static $availableTypes = [
        self::TEXT,
        self::IMAGE,
        self::LINK,
    ];

    private static $names = [
        self::LINK => 'Ссылки',
        self::IMAGE => 'Изображения',
        self::TEXT => 'Текст',
    ];

    public static function getTypeNames()
    {
        return self::$names;
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public static function getName($type)
    {
        if (!isset(self::$names[$type])) {
            throw new \RuntimeException(sprintf('Unknown type %s', $type));
        }

        return self::$names[$type];
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isAvailable($type)
    {
        return isset(self::$availableTypes[$type]);
    }

    /**
     * @return array
     */
    public static function getAvailableTypes()
    {
        return self::$availableTypes;
    }
}
