<?php
require_once 'sheet-loader.php';
$data = getData();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baseball Score Card</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="field-styles.css">
    <script src="field-script.js"></script>
</head>

<body>
    <div class='wrapper'>
        <div class="container">
            <div class="row">
                <div class="col text-center text-white font-large">The National Championship</div>
            </div>
            <div class="row border-white p-2 mt-2">
                <div class="col">
                    <div class="row">
                        <div class="col-2">
                            <div class="text-center text-white">AT BAT</div>
                            <div class="text-center text-yellow bg-black number"><?php echo $data['player']; ?></div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <div>Ball</div>
                                    <div class="text-yellow bg-black number"><?php echo $data['bases']['first_base']['ball']; ?></div>
                                </div>
                                <div class="col">
                                    <div>Strike</div>
                                    <div class="text-yellow bg-black number"><?php echo $data['bases']['first_base']['strike']; ?></div>
                                </div>
                                <div class="col">
                                    <div>Out</div>
                                    <div class="text-yellow bg-black number"><?php echo $data['bases']['first_base']['out']; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="col">Field</div>
                            <div class="col">
                                <div class='field-wrapper'>
                                    <div id='base-1' class='base base-1'></div>
                                    <div id='base-2' class='base base-2'></div>
                                    <div id='base-3' class='base base-3'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-2">
                            <div class="row">
                                <div class="col">Innings</div>
                            </div>
                            <div class="row">
                                <div class="col mb-1 team-name">Vikings</div>
                            </div>
                            <div class="row">
                                <div class="col team-name">Wildcats</div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">1</div>
                                <div class="col">2</div>
                                <div class="col">3</div>
                                <div class="col">4</div>
                                <div class="col">5</div>
                                <div class="col">6</div>
                                <div class="col">7</div>
                            </div>
                            <div class="row">
                                <?php foreach ($data['inning']['home'] as $inning => $runs) { ?>
                                    <div class="col number bg-black text-red ml-1 mb-1"><?php echo $runs; ?></div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php foreach ($data['inning']['visitor'] as $inning => $runs) { ?>
                                    <div class="col number bg-black text-red ml-1"><?php echo $runs; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <div class="col">Total</div>
                            </div>
                            <div class="row">
                                <div class="col number bg-black text-red ml-1 mb-1 text-right"><?php echo $data['vikings']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col number bg-black text-red ml-1 text-right"><?php echo $data['wildcats']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none">
        <span id="chk_b_1"><?php echo $data['bases']['position']['base_1']; ?></span>
        <span id="chk_b_2"><?php echo $data['bases']['position']['base_2']; ?></span>
        <span id="chk_b_3"><?php echo $data['bases']['position']['base_3']; ?></span>
    </div>
</body>

</html>