<?php
// Make sure we get Sheet Id
$sheetId = $_GET["sheetId"] ?? exit("Sheet Id is Missing in the Url, please check the link");

// Load data from Sheet
require_once '../src/sheet-loader.php';
$data = getData($sheetId);

$base_1_col = $data['bases']['position']['base_1'] === "1" ? "#ffff00" : "#999999";
$base_2_col = $data['bases']['position']['base_2'] === "1" ? "#ffff00" : "#999999";
$base_3_col = $data['bases']['position']['base_3'] === "1" ? "#ffff00" : "#999999";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baseball Score Card</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/styles-v1.css" />
</head>

<body class="container-fluid">
    <div class="row justify-content-center mt-md-4">
        <div class="col-sm-11 col-md-10 scorecard p-2">
            <div class="header text-center text-white py-2">
                <?php echo $data['title']; ?>
            </div>
            <div class="scoreboard-body">
                <div class="row" id="top-row">
                    <div class="col">
                        <div class="col-title">At Bat</div>
                        <div class="col-body number"><?php echo $data['player']; ?></div>
                    </div>
                    <div class="col">
                        <div class="col-title">Ball</div>
                        <div class="col-body number"><?php echo $data['bases']['current_score']['ball']; ?></div>
                    </div>
                    <div class="col">
                        <div class="col-title">Strike</div>
                        <div class="col-body number"><?php echo $data['bases']['current_score']['strike']; ?></div>
                    </div>
                    <div class="col">
                        <div class="col-title">Out</div>
                        <div class="col-body number"><?php echo $data['bases']['current_score']['out']; ?></div>
                    </div>
                    <div class="col field-column">
                        <div class="col-title">Field</div>
                        <div class="col-body">
                            <!-- prettier-ignore -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="134.853 129.453 117.75 92.75">
                                <rect stroke="#000" id="svg_1" height="92.75" width="117.75" y="129.453" x="134.853" stroke-width="1.5" fill="#000000" />
                                <g id="svg_5" transform="matrix(1, 0, 0, 1, -206.271652, -124.172058)">
                                    <path stroke="#000" id="svg_2" d="m342.87499,314.75l25.75,-24.50001l25.75,24.50001l-25.75,24.50001l-25.75,-24.50001z" stroke-width="1.5" fill="<?php echo $base_1_col; ?>" />
                                    <path stroke="#000" id="svg_3" d="m374.12499,285l25.75,-24.50001l25.75,24.50001l-25.75,24.50001l-25.75,-24.50001z" stroke-width="1.5" fill="<?php echo $base_2_col; ?>" />
                                    <path stroke="#000" id="svg_4" d="m405.62499,315l25.75,-24.50001l25.75,24.50001l-25.75,24.50001l-25.75,-24.50001z" stroke-width="1.5" fill="<?php echo $base_3_col; ?>" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 row-eq-height" id="bottom-row">
                    <div class="col-2" id="leftside">
                        <div class="col-title">Teams</div>
                        <div class="col-body-number text-white">
                            <div class="mb-2 innings-text"><?php echo $data['home_team_name']; ?></div>
                            <div class="innings-text"><?php echo $data['visitor_team_name']; ?></div>
                        </div>
                    </div>
                    <div class="col-8" id="center">
                        <div class="row">
                            <?php foreach ($data['inning']['home'] as $inning => $score) { ?>
                                <div class="col">
                                    <div class="col-title"><?php echo $inning + 1; ?></div>
                                    <div class="col-body-number text-danger">
                                        <div class="mb-2 number-score bg-black text-red"><?php echo $score; ?></div>
                                        <div class="number-score bg-black text-red"><?php echo $data['inning']['visitor'][$inning]; ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-2" id="right">
                        <div class="col-title">Total</div>
                        <div class="col-body-number" style="margin: 0 auto; width: 90%">
                            <div class="mb-2 number bg-black text-red">
                                <?php echo $data['inning']['total']['home']; ?>
                            </div>
                            <div class="number bg-black text-red">
                                <?php echo $data['inning']['total']['visitor']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>