<?php
namespace Am0nshi\Nextel;

class Client
{
    protected $client;

    public function __construct($apiKey)
    {
        $this->client = new Network($apiKey);
    }

    /**
     * Upload physical file for voice calls
     *
     * @param $pathOrBinary
     *
     * @return string File name
     */
    public function uploadVoiceRecord($pathOrBinary)
    {
        $file = realpath($pathOrBinary) ? file_get_contents($pathOrBinary) : $pathOrBinary;

        $data = [
            [
                'name'     => 'name',
                'contents' => date('d.m.Y') . '_' . md5(microtime(1) . $file)
            ],
            [
                'name'     => 'type',
                'contents' => 'API'
            ],
            [
                'name'     => 'file',
                'contents' => $file,
                'filename' => date('d.m.Y') . '_' . md5(microtime(1) . $file)
            ],
        ];

        $json = $this->client->post('/audio/upload', $data);

        return $json->message;
    }

    public function initiateCall($phone, $voiceRecordId, $meta = null)
    {
        $data = [
            "phone" => str_replace('+', '', $phone), // номер абонента на который необходимо звонить. Не null.
            "outerLine" => null, // внешняя линия для звонка абоненту. Если null - то линия будет выбрана автоматически, согласно правилам исходящих сценариев.
            "meta" => $meta, // String на 1000 символов. Это любая информация, которая должна отображаться в вэбхуках. Может быть null.
            "mainAudio" => [ // основное аудио, которое будет воспроизведено абоненту как только он ответит на звонок.
                "id" => $voiceRecordId // id заранее загруженного аудио для API звонков.
            ]
        ];

        $json = $this->client->json('/calls/originateNew', $data);

        return $json->status == 'Success';
    }
}
