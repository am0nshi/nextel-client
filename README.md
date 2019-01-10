##Nextel API client

###Install
```bash
composer require am0nshi/nextel-client
```

###Usage:
```bash
$client = new Nextel($apiKey); 
$voiceRecordId = $client->uploadVoiceRecord($pathOrBinary);
$client->initiateCall($phone, $voiceRecordId, $meta = null);
```