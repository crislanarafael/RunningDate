//https://www.strava.com/api/v3/athlete/activities?access_token=3c8231b201b77b2404b9ea4f8aac9300d26fd090

//https://www.strava.com/oauth/token?client_id=48535&client_secret=9d625984ab3dd5ae7984fd125fe709a607996e29&refresh_token=d11ce6a938e5c87a38c9e5d8d1ef06fa5894fe2f&grant_type=refresh_token


/*Learning how to retrieve athlete data from strava API for OpenHacks2020 */
const auth = "https://www.strava.com/oauth/token"
function getData(){
  const activities = "https://www.strava.com/api/v3/athlete/activities?per_page=200&access_token=3c8231b201b77b2404b9ea4f8aac9300d26fd090";

  fetch(activities).then((res) => console.log(res.json()))
}

getData()

function reauthorize(res){
  fetch(auth, {
      method: 'post',
      headers: {
        'Accept': 'application/json, text/plain, */*',
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({
          client_id: '48535',
          client_secret: '9d625984ab3dd5ae7984fd125fe709a607996e29',
          refresh_token: 'd11ce6a938e5c87a38c9e5d8d1ef06fa5894fe2f',
          grant_type: 'refresh_token'
      })
  }).then((res) => res.json())
      .then(res => getData(res))
}

reauthorize();
