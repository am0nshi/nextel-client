<?php
namespace Am0nshi\Nextel\Exceptions;

class NextelException extends \Exception
{
    public static function getException($message)
    {
        $messages = [
            'File is null' => VoiceFileNotProvided::class,
            'Wrong format' => VoiceFileFormatNotSupported::class,
            'Name is empty' => VoiceFileNameIsRequired::class,
            'Name length more than 200 chars' => VoiceFileNameIsMoreThan200Chars::class,
        ];
        if (isset($messages[$message])) {
            throw new $messages[$message]($messages[$message]);
        }
        throw new NextelException($message);
    }
}
class VoiceFileNotProvided extends NextelException {}
class VoiceFileFormatNotSupported extends NextelException {}
class VoiceFileNameIsRequired extends NextelException {}
class VoiceFileNameIsMoreThan200Chars extends NextelException {}