<?php
require __DIR__ . '/../../vendor/autoload.php';


/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API Access');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('../../credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = '../../token.json';
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
            $authCode = trim($_GET["code"]);

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
        echo json_encode($client->getAccessToken());
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


function getData($sheetId)
{

    // $datastr = '{"title":"The National Championship","home_team_name":"Socks","visitor_team_name":"Wildcats","home_team_score":"10","visitor_team_score":"4","player":"11","bases":{"position":{"base_1":"1","base_2":"1","base_3":"0"},"current_score":{"ball":"3","strike":"2","out":"1"}},"inning":{"home":["0","1","0","9","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;"],"visitor":["1","0","2","1","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;"],"total":{"home":"10","visitor":"4"}}}';
    // return json_decode($datastr, true);

    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Sheets($client);
    $data = [];

    $range = 'A1:K17';
    $response = $service->spreadsheets_values->get($sheetId, $range);
    $values = $response->getValues();

    $data = [
        "title" => $values[1][1],
        "home_team_name" => $values[2][1],
        "visitor_team_name" => $values[3][1],
        "home_team_score" => $values[2][2],
        "visitor_team_score" => $values[3][2],
        "player" => $values[4][1],
        "bases" => [
            "position" => [
                "base_1" => $values[8][1],
                "base_2" => $values[8][2],
                "base_3" => $values[8][3],
            ],
            "current_score" => [
                "ball" => $values[9][1],
                "strike" => $values[10][1],
                "out" => $values[11][1],
            ]
        ],
        "inning" => [
            "home" => [
                $values[15][1] ?? "&nbsp;",
                $values[15][2] ?? "&nbsp;",
                $values[15][3] ?? "&nbsp;",
                $values[15][4] ?? "&nbsp;",
                $values[15][5] ?? "&nbsp;",
                $values[15][6] ?? "&nbsp;",
                $values[15][7] ?? "&nbsp;",
                $values[15][8] ?? "&nbsp;",
                $values[15][9] ?? "&nbsp;",
            ],
            "visitor" => [
                $values[16][1] ?? "&nbsp;",
                $values[16][2] ?? "&nbsp;",
                $values[16][3] ?? "&nbsp;",
                $values[16][4] ?? "&nbsp;",
                $values[16][5] ?? "&nbsp;",
                $values[16][6] ?? "&nbsp;",
                $values[16][7] ?? "&nbsp;",
                $values[16][8] ?? "&nbsp;",
                $values[16][9] ?? "&nbsp;",
            ],
            "total" => [
                "home" => $values[15][10],
                "visitor" => $values[16][10]
            ]
        ]
    ];

    return $data;
}
