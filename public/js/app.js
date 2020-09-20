function updateEl(id, value) {
  document.getElementById(id).innerHTML = value;
}

function updatePage(data) {
  updateEl("data_title", data.title);
  updateEl("data_player", data.player);
  updateEl("data_bases_current_score_ball", data.bases.current_score.ball);
  updateEl("data_bases_current_score_strike", data.bases.current_score.strike);
  updateEl("data_bases_current_score_out", data.bases.current_score.out);
  document
    .getElementById("data_base_1_col")
    .setAttribute("fill", data.base_1_col);
  document
    .getElementById("data_base_2_col")
    .setAttribute("fill", data.base_2_col);
  document
    .getElementById("data_base_3_col")
    .setAttribute("fill", data.base_3_col);

  updateEl("data_home_team_name", data.home_team_name);
  updateEl("data_visitor_team_name", data.visitor_team_name);
  for (let index = 0; index < 9; index++) {
    updateEl(`data_home_team_${index + 1}`, data.inning.home[index]);
    updateEl(`data_visitor_team_${index + 1}`, data.inning.visitor[index]);
  }

  updateEl("data_inning_total_home", data.home_team_score);
  updateEl("data_inning_total_visitor", data.visitor_team_score);
}

async function getData(sheetId) {
  await fetch(`../src/getData.php?sheetId=${sheetId}`)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      updatePage(data);
      //setTimeout(getData, 3000);
    })
    .catch(function (err) {
      console.error(err);
      alert("Something went wrong!!");
    });
}

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const sheetId = urlParams.get("sheetId");
if (!sheetId) {
  alert("Sheet Id is required");
} else {
  getData(sheetId);
}
