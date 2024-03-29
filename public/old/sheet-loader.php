<?php

require __DIR__ . '/../vendor/autoload.php';


/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API Access');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('../credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = '../token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


function getData(){
    
    $datastr = '{"player":"11","vikings":"12","wildcats":"4","bases":{"position":{"base_1":"1","base_2":"1","base_3":"0"},"first_base":{"ball":"3","strike":"2","out":"1"},"second_base":{"ball":null,"strike":null,"out":null},"third_base":{"ball":null,"strike":null,"out":null}},"inning":{"home":["0","1","0","11"," "," "," "],"visitor":["1","0","2","1"," "," "," "],"total":{"home":"12","visitor":"4"}}}';
    return json_decode($datastr, true);

    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Sheets($client);
    $data = [];

    $spreadsheetId = '11fClC_NhZ6uchStr9fEOKz9a3qITRrT1rT_9UiX_mA4';
    $range = 'A1:I14';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    $data = [
        "player" => $values[0][1],
        "vikings" => $values[1][1],
        "wildcats" => $values[2][1],
        "bases" => [
            "position" => [
                "base_1" => $values[4][1],
                "base_2" => $values[4][2],
                "base_3" => $values[4][3],
            ],
            "first_base" => [
                "ball" => $values[5][1],
                "strike" => $values[6][1],
                "out" => $values[7][1],
            ],
            "second_base" => [
                "ball" => $values[5][2],
                "strike" => $values[6][2],
                "out" => $values[7][2],
            ],
            "third_base" => [
                "ball" => $values[5][3],
                "strike" => $values[6][3],
                "out" => $values[7][3],
            ]
        ],
        "inning" => [
            "home" => [
                $values[12][1] ?? "&nbsp;",
                $values[12][2] ?? "&nbsp;",
                $values[12][3] ?? "&nbsp;",
                $values[12][4] ?? "&nbsp;",
                $values[12][5] ?? "&nbsp;",
                $values[12][6] ?? "&nbsp;",
                $values[12][7] ?? "&nbsp;",
            ],
            "visitor" => [
                $values[13][1] ?? "&nbsp;",
                $values[13][2] ?? "&nbsp;",
                $values[13][3] ?? "&nbsp;",
                $values[13][4] ?? "&nbsp;",
                $values[13][5] ?? "&nbsp;",
                $values[13][6] ?? "&nbsp;",
                $values[13][7] ?? "&nbsp;",
            ],
            "total" => [
                "home" => $values[12][8],
                "visitor" => $values[13][8]
            ]
        ]
    ];

    return $data;
}