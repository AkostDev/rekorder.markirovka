<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Форма распространения креатива
 */
class CreativeForm
{
    /** Баннер */
    const string BANNER = 'banner';

    /** Текстовый блок */
    const string TEXT_BLOCK = 'text_block';

    /** Текстово-графический блок */
    const string TEXT_GRAPHIC_BLOCK = 'text_graphic_block';

    /** Аудиозапись */
    const string AUDIO = 'audio';

    /** Видеоролик */
    const string VIDEO = 'video';

    /** Аудиотрансляция в прямом эфире */
    const string LIVE_AUDIO = 'live_audio';

    /** Видеотрансляция в прямом эфире */
    const string LIVE_VIDEO = 'live_video';

    /** Иное (устарело) */
    const string OTHER = 'other';

    /** Текстовый блок с видео */
    const string TEXT_VIDEO_BLOCK = 'text_video_block';

    /** Текстово-графический блок с видео */
    const string TEXT_GRAPHIC_VIDEO_BLOCK = 'text_graphic_video_block';

    /** Текстовый блок с аудио */
    const string TEXT_AUDIO_BLOCK = 'text_audio_block';

    /** Текстово-графический блок с аудио */
    const string TEXT_GRAPHIC_AUDIO_BLOCK = 'text_graphic_audio_block';

    /** Текстовый блок с аудио и видео */
    const string TEXT_AUDIO_VIDEO_BLOCK = 'text_audio_video_block';

    /** Текстово-графический блок с аудио и видео */
    const string TEXT_GRAPHIC_AUDIO_VIDEO_BLOCK = 'text_graphic_audio_video_block';

    /** HTML5-баннер */
    const string BANNER_HTML5 = 'banner_html5';

    /**
     * Получить список всех форм
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::BANNER,
            self::TEXT_BLOCK,
            self::TEXT_GRAPHIC_BLOCK,
            self::AUDIO,
            self::VIDEO,
            self::LIVE_AUDIO,
            self::LIVE_VIDEO,
            self::OTHER,
            self::TEXT_VIDEO_BLOCK,
            self::TEXT_GRAPHIC_VIDEO_BLOCK,
            self::TEXT_AUDIO_BLOCK,
            self::TEXT_GRAPHIC_AUDIO_BLOCK,
            self::TEXT_AUDIO_VIDEO_BLOCK,
            self::TEXT_GRAPHIC_AUDIO_VIDEO_BLOCK,
            self::BANNER_HTML5,
        ];
    }

    /**
     * Получить список для отображения
     *
     * @return array
     */
    public static function getList(): array
    {
        return [
            self::BANNER => 'Баннер',
            self::TEXT_BLOCK => 'Текстовый блок',
            self::TEXT_GRAPHIC_BLOCK => 'Текстово-графический блок',
            self::AUDIO => 'Аудиозапись',
            self::VIDEO => 'Видеоролик',
            self::LIVE_AUDIO => 'Аудиотрансляция в прямом эфире',
            self::LIVE_VIDEO => 'Видеотрансляция в прямом эфире',
            self::OTHER => 'Иное (устарело)',
            self::TEXT_VIDEO_BLOCK => 'Текстовый блок с видео',
            self::TEXT_GRAPHIC_VIDEO_BLOCK => 'Текстово-графический блок с видео',
            self::TEXT_AUDIO_BLOCK => 'Текстовый блок с аудио',
            self::TEXT_GRAPHIC_AUDIO_BLOCK => 'Текстово-графический блок с аудио',
            self::TEXT_AUDIO_VIDEO_BLOCK => 'Текстовый блок с аудио и видео',
            self::TEXT_GRAPHIC_AUDIO_VIDEO_BLOCK => 'Текстово-графический блок с аудио и видео',
            self::BANNER_HTML5 => 'HTML5-баннер',
        ];
    }

    /**
     * Получить список актуальных форм
     *
     * @return array
     */
    public static function getActualList(): array
    {
        $list = self::getList();
        unset($list[self::OTHER]); // Удаляем устаревший тип
        return $list;
    }

    /**
     * Проверить валидность значения
     *
     * @param string $value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::getAll());
    }
}